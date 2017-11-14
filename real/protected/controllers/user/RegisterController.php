<?php

//用户注册类
class RegisterController extends CenterController {

    public $layout = 'user'; //定义布局

    //用户注册主页

    public function actionIndex() {
        $this->render('index');
    }

    //用户注册
    public function actionIndexs() {
        if ($this->checkLogin())
            $this->showMessage('你已经登录', U('product/product/index'));
        $isajax = Yii::app()->request->isAjaxRequest;
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';  //类型1个人，2企业，3企业子账号
        if (!empty($_POST) && $isajax) {
            $params['username'] = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
            $params['password'] = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
            $params['msg_code'] = !empty($_REQUEST['msg_code']) ? $_REQUEST['msg_code'] : '';
            $params['is_read'] = !empty($_REQUEST['is_read']) ? $_REQUEST['is_read'] : '';
            //验证信息
            if (empty($params['username']))
                $this->out('100002', '手机/邮箱不能为空');
            if (empty($params['password']))
                $this->out('100003', '密码不能为空');
            if (empty($params['msg_code']))
                $this->out('100004', '验证码不能为空');
            if (empty($params['is_read']))
                $this->out('100005', '条例没有勾选');
            if (empty($params['type']))
                $this->out('100006', '类型错误');
            //验证用户名和密码是否合法
            if (!Tools::isPhone($params['username']) && !Tools::isEmail($params['username']))
                $this->out('100009', '手机/邮箱不合规');
            if (Tools::isPhone($params['username']))
                $data['tel'] = $params['username'];
            if (Tools::isEmail($params['username']))
                $data['email'] = $params['username'];
            if (strlen($params['password']) < 6 || strlen($params['password']) > 16)
                $this->out('100010', '密码不合规');
            if (!Tools::isPwd($params['password']))
                $this->out('100010', '密码不合规'); //20161017密码规则简化
            if ($params['type'] == 2 && empty($data['email']))
                $this->out('1000012', '邮箱不能为空');
            //验证用户名是否存在           
            $user_rs = UserServer::checkUsername($params['username']);
            if ($user_rs['code'] == 0)
                $this->out('100008', '手机/邮箱已存在');
            //验证码接口
            $code = json_decode(Yii::app()->session[$this->user_register_code], true);
            if ($params['msg_code'] != $code['code'] || $params['username'] != $code['username']) {
                $this->out('100007', '验证码错误');
            }
            if (time() - $this->ValidateCodeExpTimes * 60 > $code['time'])
                $this->out('100010', '验证码已过期');
            //生成随机用户ID
            if ($params['type'] == 1)
                $data['user_id'] = self::getnewid();
            if ($params['type'] == 2)
                $data['company_id'] = self::getnewid();
            $data['pwd'] = Tools::setpwd($params['password']);
            $data['type'] = $params['type'];
            $data['addtime'] = time();
            $data['is_looked_edit'] = 1;
            $data['is_looked_work'] = 1;
            //注册
            $rs = UserServer::addUser($data);
            if ($rs['code'] == 0) {
                if (isset($data['user_id'])) {
                    $_id = $data['user_id'];
                    $rs_user = UserServer::selUser(array('_id' => $_id,'pc_type'=>1));
                    $this->userInsession($rs_user['data']);
                    //送迎新流量包
                    if ($params['type'] == 1)

                    lowServer::addFlow(array('user_id' => $_id, 'type_id' => 1, 'status' => 'use', 'use_water' => 0, 'addtime' => time()));
                }
                //销毁验证码
                Yii::app()->session[$this->user_register_code] = '';
                $this->out('0', '注册成功');
            } else
                $this->out('1000011', '注册失败');
        }else {
            if ($params['type'] != 2)
                $this->render('person');
            else
                $this->render('company');
        }
    }

    public static function getnewid($id = "") {
        if (empty($id)) {
            $id = "id" . rand(100000, 999999);
        }
        $rs = UserServer::checkId($id);
        if ($rs['code'] == 0) {
            $id = "id" . rand(100000, 999999);
            $id = self::getnewid($id);
        }
        return $id;
    }

    public function actionUsernameisok() {
        $isajax = Yii::app()->request->isAjaxRequest;
        if (!empty($_POST) && $isajax) {
            $params['username'] = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
            //验证用户名是否存在
            $user_rs = UserServer::checkUsername($params['username']);
            if ($user_rs['code'] != 0)
                $this->out('0', '手机/邮箱不存在');
        }
        $this->out('100001', '手机/邮箱已存在');
    }

}
