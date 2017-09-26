<?php

//工单管理
class OrderController extends CenterController {

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
        $params['keyword'] = !empty($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
        $params['type'] = !empty($_REQUEST['type']) && $_REQUEST['type']!='undefined' ? $_REQUEST['type'] : '';
        $params['status'] = !empty($_REQUEST['status'])  && $_REQUEST['status']!='undefined'? $_REQUEST['status'] : '';
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : $this->page;

        $rs = WorkorderServer::selectAdmin($params, $page, $this->pagesize);


        $count = WorkorderServer::selectAdmin($params);
        $count = count($count);
        $pages = new CPagination($count);
        $pages->pageSize = $this->pagesize;

        $this->render('list', array('data' => $rs, 'pages' => $pages, 'keyword' => $params['keyword'], 'count' => $count));
    }

    //查询工单详情
    public function actionWorkorderinfo() {
        $params['_id'] = !empty($_REQUEST['_id']) ? $_REQUEST['_id'] : '';
        $params['order_no'] = !empty($_REQUEST['order_no']) ? $_REQUEST['order_no'] : '';
        $rs = WorkorderServer::selectInfo($params);
        $user_list = UserServer::selUser(array('_id' => $params['_id'], 'pc_type' => 0));
        $user_list = $user_list['data'];
        if (!empty($rs)) {

            $rs['name'] = $user_list['tel'] ? $user_list['tel'] : '';
            if (empty($rs['name'])) {
                $rs['name'] = $user_list['email'];
            }
            $rs['headimg'] = $user_list['headimg'] ? $user_list['headimg'] : STATICSADMIN . 'img/22.png';

            $this->out('0', '查询成功', $rs);
        } else
            $this->out('100001', '查询失败');
    }

    //回复工单
    public function actionReplyorder() {

        $params['order_no'] = !empty($_REQUEST['order_no']) ? $_REQUEST['order_no'] : '';
        $params['content'] = !empty($_REQUEST['content']) ? $_REQUEST['content'] : '';
        $params['reply_type'] = 'realapp'; //如果是工作人员回复则传递admin
        $params['addtime'] = time();
        if (empty($params['order_no']) || empty($params['content']))
            $this->out('100005', '参数不能为空');
        //开启事物处理
        $transaction = Yii::app()->db->beginTransaction();
        try {

            $add_rs = WorkorderServer::addReply($params);
            if ($add_rs['code'] != 0) {
                throw new CException('生成失败', 100001);
            }
            $id = Yii::app()->db->getLastInsertID();
            //添加图片
            $link = '';
            if (isset($_REQUEST['img'])) {
                $img = $_REQUEST['img'];
                foreach ($img as $k => $v) {
                    $filename = time() . rand() . '.png';
                    $filepath = UPLOAD_PATH . '/workorder';
                    if (Tools::createDir($filepath)) {
                        $url = explode(',', $v);
                        //验证是不是图片
                        if (!strpos($url[0], 'image/png') && !strpos($url[0], 'image/jpeg'))
                            $this->out('100003', '图片格式错误');
                        //base64保存图片
                        @file_put_contents($filepath . '/' . $filename, base64_decode($url[1]));
                        $add_rs = WorkorderServer::addReplyimg(array('reply_no' => $id, 'link' => $filename));
                        if ($add_rs['code'] != 0) {
                            throw new CException('生成失败', 100001);
                        }
                        $link[] = $filename;
                    } else {
                        $this->out('100002', '创建文件夹失败');
                    }
                }
            }
            //修改工单状态
            WorkorderServer::update(array('order_no'=>$params['order_no']), array('status'=>2));
            $transaction->commit();
            $this->out('0', '提交成功');
        } catch (Exception $e) {
            $transaction->rollback();
            $this->out($e->getCode(), $e->getMessage());
        }
    }
    
        //删除工单
    public function actionDelorder() {
        $params['order_no'] = !empty($_REQUEST['order_no']) ? $_REQUEST['order_no'] : '';
        if (empty($params['order_no']))
            $this->out('100005', '参数不能为空');
        $rs = WorkorderServer::del($params);
        if (!empty($rs))
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

}
