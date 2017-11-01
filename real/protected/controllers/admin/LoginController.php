<?php

//后台登录
class LoginController extends CenterController {

    //用户登录
    public function actionLogin() {
        if ($this->checkLogin('admin'))
            $this->showMessage('你已经登录', U('admin/index/index'));

        $isajax = Yii::app()->request->isAjaxRequest;
        if (!empty($_POST) && $isajax) {
            $username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
            $password = !empty($_REQUEST['password']) ? Tools::setpwd($_REQUEST['password']) : '';
            if (empty($username) || empty($password))
                $this->out('100005', '参数不能为空');
            //登陆
            $rs = AdminServer::doLogin(array('username' => $username, 'password' => $password));
            if ($rs['code'] == 0) {
                //写入session
                $this->userInsession($rs['data'], 'admin');
                //修改最后一次登录信息
                AdminServer::updateAdmin(array('id' => $rs['data']['id']), array('last_time' => time(), 'last_ip' => $_SERVER["REMOTE_ADDR"]));

                $this->out('0', '登录成功');
            } elseif ($rs['code'] == 100002) {
                $this->out('100002', '用户名或者密码错误');
            }
        }
        $this->render('login');
    }

    //登出
    public function actionLoginout() {
        //清除cookie，停止自动登陆

        unset(Yii::app()->session['admin']);
        if (isset(Yii::app()->session['admin'])) {
            $this->out('100001', '退出失败');
        } else {
            $this->out('0', '退出成功');
        }
    }

}
