<?php

//基类控制器

class BaseController extends CController
{

    public $ValidateCodeKey = 'loginValidateCode'; //登陆时图片验证码的sessionKey
    public $ValidateCodeExpTimes = 10; //注册/找回密码 验证码有效时间  10分钟
    public $user_register_code = 'user_register_code'; //注册时保存在session里信息的key值
    public $user_retpwd_code = 'user_retpwd_code'; //找回密码时保存在session里信息的key值
    public $user_product_code = 'user_product_code'; //项目下线时保存在session里信息的key值

    //跨域源资源共享

    public function init()
    {
        parent::init();

    }

    //输出
    function out($code = '', $content = '', $data = '')
    {
        if (is_array($code)) {
            $re = $code;
        } else {
            $re = array(
                'code' => $code,
                'msg' => $content,
                'result' => $data
            );
        }
        echo json_encode($re);
        Yii::app()->end();
    }

    //提示页面
    function showMessage($content, $url = '', $time = 1550)
    {
        if (is_array($content)) {
            $re = array(
                'content' => $content['content'],
                'url' => $content['url'],
                'time' => $content['time']
            );
        } else {
            $re = array(
                'content' => $content,
                'url' => $url,
                'time' => $time
            );
        }
        $isAjax = Yii::app()->request->getIsAjaxRequest();

        $this->renderPartial('//show_message', array('msg' => $re, 'isAjax' => $isAjax));
        Yii::app()->end();
    }

    /**
     * 创建表单令牌
     * -----------------------------------------------
     * 加密通过配置项进行,所以验证时应在渲染模版的控制器进行
     * -----------------------------------------------
     */
    function tokenCreate()
    {
        $key = uniqid();         //令牌 id值
        $hash = 'HASH';
        $value = sha1($key . $hash); //令牌value//
        Yii::app()->session[$key] = $value; //令牌存入session
        return $key;
    }

    /**
     * 根据id验证表单令牌
     * @param string $id
     */
    function tokenCheck($id)
    {
        if (!isset($_SESSION[$id]))
            return false;
        $hash = 'HASH';
        $value = sha1($id . $hash); //令牌value//
        if ($_SESSION[$id] == $value) {
            unset($_SESSION[$id]); //验证通过 销毁令牌
            return true;
        }
        return false;
    }

    //把用户信息保存在SESSION里
    public function userInsession($data, $type = 'user')
    {
        $data = json_decode(json_encode($data), true);
        if ($type == 'user') {
            $lifeTime = 24 * 3600;
            ini_set('session.gc_maxlifetime', '864000');
            Yii::app()->session[$type] = array(
                'user_id' => isset($data['user_id']) ? $data['user_id'] : '',
                'tel' => isset($data['tel']) ? $data['tel'] : '',
                'email' => isset($data['email']) ? $data['email'] : '',
                'company_id' => isset($data['company_id']) ? $data['company_id'] : '',
                'nickname' => isset($data['nickname']) ? $data['nickname'] : '',
                'sex' => isset($data['sex']) ? $data['sex'] : '',
                'headimg' => isset($data['headimg']) ? $data['headimg'] : '',
                'province' => isset($data['province']) ? $data['province'] : '',
                'city' => isset($data['city']) ? $data['city'] : '',
                'birthdate' => isset($data['birthdate']) ? $data['birthdate'] : '',
                'signature' => isset($data['signature']) ? $data['signature'] : '',
                'last_time' => isset($data['last_time']) ? $data['last_time'] : '',
                'last_ip' => isset($data['last_ip']) ? $data['last_ip'] : '',
            );
        }
        if ($type == 'admin') {
            Yii::app()->session[$type] = array(
                'username' => isset($data['username']) ? $data['username'] : '',
                'last_time' => isset($data['last_time']) ? $data['last_time'] : '',
                'last_ip' => isset($data['last_ip']) ? $data['last_ip'] : '',
                'addtime' => isset($data['addtime']) ? $data['addtime'] : '',
                'permissions' => isset($data['permissions']) ? $data['permissions'] : [],
            );
        }
    }

    //检查前后台是否登陆
    public function checkLogin($type = 'user')
    {
        if ($type == 'user') {
            if (!empty(Yii::app()->session[$type]['user_id'])) {
                return true;
            } else {
                $cookie = Yii::app()->request->cookies[COOKIE_KEY];
                if (isset($cookie) && isset($cookie->value)) {
                    $id = $cookie->value;
                    $rs = UserServer::checkId($id);
                    if ($rs['code'] == 0) {
                        $this->userInsession($rs['data']['0']);
                        return true;
                    }
                }
            }
        }
        if ($type == 'admin') {
            if (!empty(Yii::app()->session[$type])) {
                return true;
            }
        }
        return false;
    }

    //设置cookie
    public function setCookie($key, $val, $time = 60)
    {
        $cookie = new CHttpCookie($key, $val);
        $cookie->expire = time() + $time;
        Yii::app()->request->cookies[$key] = $cookie;
    }

    public function postCurl($url, $post = '', $json = false)
    {
        $header = array(
            'Content-Type: application/json',
            'Content-Length:' . strlen($post),
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); //The URL to fetch.
        curl_setopt($ch, CURLOPT_HEADER, 0); //TRUE to include the header in the output.
        //post
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        if ($json)
            return json_decode($data, true);
        return $data;
    }

    //查看权限

    public function checkAuth($auth_type)
    {
        if (!$this->checkLogin('admin')) {
            $this->showMessage('未登录', U('admin/login/login'));
        }
        if (!empty(Yii::app()->session['admin'])) {
            //查询当前管理人员角色权限
          if(in_array($auth_type, Yii::app()->session['admin']['permissions'])){
              return 0;
          }else{
              return 1;
          }
        }

    }


}
