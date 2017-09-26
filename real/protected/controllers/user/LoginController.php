<?php

//用户登录
class LoginController extends CenterController {

    public $layout = 'user'; //定义布局
    public $ValidateCodeTimes = 3; //提交按钮是否显示验证码 点击提交按钮第3次时需要显示
    public $ValidateCodeTimesExpTime = 1; //提交按钮保存cookie的时间  1天
    public $ValidateCodeExpTimes = 5; //登陆时验证码有效时间  5分钟
    public $IsKeepTime = 7; //自动登陆保存时长  7天

    //用户登录

    public function actionLogin() {
        if ($this->checkLogin())
            $this->showMessage('你已经登录', U('product/product/index'));
        $isajax = Yii::app()->request->isAjaxRequest;
        if (!empty($_POST) && $isajax) {
            $username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
            $password = !empty($_REQUEST['password']) ? Tools::setpwd($_REQUEST['password']) : '';
            $is_login = $_REQUEST['is_login'] ? $_REQUEST['is_login'] : false;
            $msg_code = !empty($_REQUEST['msg_code']) ? $_REQUEST['msg_code'] : '';
            if (empty($username) || empty($password))
                $this->out('100005', '参数不能为空');
            //图片验证码session
            $user_code = isset(Yii::app()->session['user_code']) ? json_decode(Yii::app()->session['user_code'], true) : ['code' => '', 'time' => 0];
            if ($this->IsCheckValidateCode() && time() - $this->ValidateCodeExpTimes * 60 > $user_code['time'])
                $this->out('100010', '验证码已过期');
            if ($this->IsCheckValidateCode() && strtolower($msg_code) != $user_code['code'])
                $this->out('100011', '验证码错误');
            //判断用户名
            if (Tools::isPhone($username))
                $data['tel'] = $username;
            if (Tools::isEmail($username))
                $data['email'] = $username;
            if (substr($username, 0, 2) == 'id')
                $data['_id'] = $username;
            if (!isset($data['tel']) && !isset($data['email']) && !isset($data['_id']))
                $this->out('100007', '用户名不存在');
            //登陆
            $data['pwd'] = $password;
            $rs = UserServer::doLogin($data);
            if ($rs['code'] == 0) {
                //写入session
                $this->userInsession($rs['data']);
                //修改最后一次登录信息
                if ($rs['type'] == 'person') {
                    $updateData['user_id'] = $rs['data']['user_id'];
                    $id = $rs['data']['user_id'];
                }
                if ($rs['type'] == 'company') {
                    $updateData['company_id'] = $rs['data']['company_id'];
                    $id = $rs['data']['company_id'];
                }
                UserServer::updateUser($updateData, array('last_time' => time(), 'last_ip' => $_SERVER["REMOTE_ADDR"]));
                //是否保存cookie
                if ($is_login == 'true') {
                    $this->setCookie(COOKIE_KEY, $id, 60 * 60 * 24 * $this->IsKeepTime);
//                        $this->UserCookie($id);
                }
                $this->out('0', '登录成功');
            } elseif ($rs['code'] == 100002) {
                $this->out('100002', '用户名或者密码错误');
            } elseif ($rs['code'] == 100003) {
                $this->out('100003', '用户不存在');
            } elseif ($rs['code'] == 100004) {
                $this->out('100004', '用户被锁定');
            } else {
                $this->out('100006', '登录失败');
            }
        }
        $this->render('login');
    }

    //登出
    public function actionLoginout() {
        //清除cookie，停止自动登陆
        $cookie_id = COOKIE_KEY;
        unset(Yii::app()->request->cookies[$cookie_id]);
        unset(Yii::app()->session['user']);
        if (isset(Yii::app()->session['user'])) {
            $this->out('100001', '退出失败');
        } else {
            $this->out('0', '退出成功');
        }
    }

    //设置验证码图片cookie
    public function actionIsCheckValidateCode() {
        $key = $this->ValidateCodeKey;
        $ExpTime = $this->ValidateCodeTimesExpTime; //过期时间  1天
        $cookie = Yii::app()->request->cookies[$key];
        $re = 1;
        if (isset($cookie))
            $re = $cookie->value + 1;
        $this->setCookie($key, $re, 60 * 60 * 24 * $ExpTime);
//        $cookie = new CHttpCookie($key,$re);
//        $cookie->expire = 0;
//        if($ExpTime)
//            $cookie->expire = time()+$ExpTime*3600*24;
//        Yii::app()->request->cookies[$key]=$cookie;

        if ($re == $this->ValidateCodeTimes)
            $this->out('show', '显示验证码');
        if ($re > $this->ValidateCodeTimes)
            $this->out('check', '需要填写验证码');
        $this->out('nocheck', '不需要填写验证码');
    }

    //查询是否需要检查验证码(接口)
    public function actionIsCheckValidateCodes() {
        $key = $this->ValidateCodeKey;
        $cookie = Yii::app()->request->cookies[$key];
        if (isset($cookie) && $cookie->value == $this->ValidateCodeTimes)
            $this->out('show', '显示验证码');
        if (isset($cookie) && $cookie->value > $this->ValidateCodeTimes)
            $this->out('check', '需要填写验证码');
        $this->out('nocheck', '不需要填写验证码');
    }

    //查询是否需要检查验证码(登陆时检查)
    private function IsCheckValidateCode() {
        $key = $this->ValidateCodeKey;
        $cookie = Yii::app()->request->cookies[$key];
        if (isset($cookie) && $cookie->value >= $this->ValidateCodeTimes)
            return true;
        return false;
    }

}
