<?php

//后台管理(项目列表)
class ProductController extends CenterController {

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
        $keyword = !empty($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : $this->page;
        $list = '';
        $rs = ProductServer::AdminList(array('keyword' => $keyword), $page);
        if ($rs['code'] == 0) {
            $list = $rs['data'];
        }
        $count = ProductServer::AdminListCount(array('keyword' => $keyword));
        $count = $count[0]['total'];
        $pages = new CPagination($count);
        $pages->pageSize = $this->pagesize;

        $this->render('list', array('data' => $list, 'pages' => $pages, 'keyword' => $keyword, 'count' => $count));
    }



}
