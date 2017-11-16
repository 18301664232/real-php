<?php

//后台管理(项目列表)
class ProductController extends CenterController {

    public $page = 1;
    public $pagesize = 5;
    public $layout = 'admin'; //定义布局

    public function init() {
        parent::init();
        if (!$this->checkLogin('admin'))
            $this->showMessage('未登录', U('admin/login/login'));
    }

    //主页
    public function actionList() {
        $keyword = !empty($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
        $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : '';
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : $this->page;
        $list = '';
        $rs = ProductServer::AdminList(array('keyword' => $keyword,'status'=>$status), $page);
        if ($rs['code'] == 0) {
            $list = $rs['data'];
        }
        //$criteria=new CDbCriteria();
        $count = ProductServer::AdminListCount(array('keyword' => $keyword,'status'=>$status));
        $count = $count[0]['total'];

        $pages = new CPagination($count);
        //$pages->pageSize = 10;
        //$pages->applyLimit($criteria);


        $this->render('list', array('data' => $list, 'pages' => $pages, 'keyword' => $keyword, 'count' => $count));
    }

    //后台查看项目状态返回预览连接
    public function actionReturnLookLink(){
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        if(empty($product_id)){
            $this->out('1000403','参数未提交');
        }
        //查看项目状态
        $rs = ProductServer::getList(['product_id'=>$product_id]);
        if($rs['code'] != 0){
            $this->out('1000404','读取状态失败');
        }
        switch ($rs['data'][0]['online']){
            case 'online':
                $link_uid_list = ProductServer::selectLink(['product_id'=>$product_id,'status'=>'online']);
                break;
            case 'update':
                $link_uid_list = ProductServer::selectLink(['product_id'=>$product_id,'status'=>'online']);
                break;
            default:
                $link_uid_list = ProductServer::selectLink(['product_id'=>$product_id,'status'=>'test']);
        }
        if(empty($link_uid_list['data'])){
            $this->out('1000405','读取链接失败');
        }
        $this->out('0','成功',['data'=>$link_uid_list['data'][0]]);

    }



}
