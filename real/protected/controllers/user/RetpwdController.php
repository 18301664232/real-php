<?php

//找回密码类
class RetpwdController extends CenterController {

    public $layout = 'user'; //定义布局

    //验证身份

    public function actionCheck() {
        if ($this->checkLogin())
            $this->showMessage('你已经登录', U('product/product/index'));
        $isajax = Yii::app()->request->isAjaxRequest;
        if (!empty($_POST) && $isajax) {
            $username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
            $msg_code = !empty($_REQUEST['msg_code']) ? $_REQUEST['msg_code'] : '';
            if (empty($username) || empty($msg_code))
                $this->out('100005', '参数不能为空');
            //验证码接口
            $code = json_decode(Yii::app()->session[$this->user_retpwd_code], true);
            if ($msg_code != $code['code'])
                $this->out('100004', '短信验证码错误');
            //根据用户名或者ID查询用户信息
            if (Tools::isPhone($username))
                $data['tel'] = $username;
            if (Tools::isEmail($username))
                $data['email'] = $username;
            if (substr($username, 0, 2) == 'id')
                $data['_id'] = $username;
            if (!isset($data['tel']) && !isset($data['email']) && !isset($data['_id']))
                $this->out('100007', '手机/邮箱格式错误');
            $data['pc_type'] = 0; //区分个人和企业（0不区分/1个人/2企业）
            $rs = UserServer::selUser($data);
            if ($rs['code'] == 0) {
                if ($rs['type'] == 'person') {
                    $id = $rs['data']['user_id'];
                }
                if ($rs['type'] == 'company') {
                    $id = $rs['data']['company_id'];
                }
                $id = STD3DesServer::encrypt($id);
                //销毁验证码
                Yii::app()->session[$this->user_retpwd_code] = '';
                //生成表单验证
                $key = $this->tokenCreate();
                $this->out('0', '成功', array('data' => array('code' => $id, 'key' => $key)));
            } else {
                $this->out('100007', '用户名不存在');
            }
        }
        $this->render('check');
    }

    //修改密码
    public function actionRpassword() {
        if ($this->checkLogin())
            $this->showMessage('你已经登录', U('product/product/index'));
        $isajax = Yii::app()->request->isAjaxRequest;
        if (!empty($_POST) && $isajax) {
            $password = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
            $rpassword = !empty($_REQUEST['rpassword']) ? $_REQUEST['rpassword'] : '';
            $code = !empty($_REQUEST['code']) ? $_REQUEST['code'] : '';
            if (empty($password) || empty($rpassword) || empty($code))
                $this->out('100005', '参数不能为空');
            if ($password !== $rpassword)
                $this->out('100001', '两次密码不一致');
            if (strlen($password) < 6 || strlen($password) > 16)
                $this->out('100010', '密码不合规');
            if (!Tools::isPwd($password))
                $this->out('100010', '密码不合规'); //20161017密码规则简化
            $id = STD3DesServer::decrypt($code);
            if (empty($id))
                $this->out('100002', 'code错误');
            $data['pc_type'] = 0; //区分个人和企业（0不区分/1个人/2企业）
            $data['_id'] = $id;
            $rs = UserServer::selUser($data);
            if ($rs['code'] == 0) {
                if ($rs['data']['pwd'] == Tools::setpwd($password))
                    $this->out('100003', '新密码不能和老密码一致');
                if ($rs['type'] == 'person') {
                    $updateData['user_id'] = $rs['data']['user_id'];
                }
                if ($rs['type'] == 'company') {
                    $updateData['company_id'] = $rs['data']['company_id'];
                }
                $updaters = UserServer::updateUser($updateData, array('pwd' => Tools::setpwd($password)));
                if ($updaters['code'] == 0)
                    $this->out('0', '修改成功');
                else
                    $this->out('100004', '修改失败');
            } else
                $this->out('100002', 'code错误');
        }
        //验证页面来源
        $key = !empty($_REQUEST['key']) ? $_REQUEST['key'] : '';
        if (!$this->tokenCheck($key))
            $this->showMessage('页面已过期', U('user/login/login'));
        $this->render('rpassword');
    }

}
