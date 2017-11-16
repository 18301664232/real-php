<?php

//后台管理(用户列表)
class UserController extends CenterController {

    public $page = 1;
    public $pagesize = 20;
    public $layout = 'admin'; //定义布局

    public function init() {
        parent::init();
        if (!$this->checkLogin('admin'))
            $this->showMessage('未登录', U('admin/login/login'));
    }

    //主页
    public function actionList() {
        $this->render('list');
    }

    public function actionAjax() {
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $list = '';

        $this->out('0', '成功', array('data' => $list));
    }

}
