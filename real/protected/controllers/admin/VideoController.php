<?php

/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017/9/12
 * Time: 18:40
 */
class VideoController extends CenterController
{

    public $page = 1;
    public $pagesize = 20;
    public $layout = 'admin'; //定义布局

    public function init() {
        parent::init();
        if (!$this->checkLogin('admin'))
            $this->showMessage('未登录', U('admin/login/login'));
    }

    //显示页面
    public function actionList(){
       $this->render('list');
    }

    //初始化数据
    public function actionAjax(){
        $params=[];
        //ajax接收当前页数
        $now_page = !empty($_REQUEST['page']) ? $_REQUEST['page']:'';
        if(!$now_page){
            $this->out('100000','当前页码不存在');
        }
        $page_limit = 2;
        $page_offset = ($now_page-1) * $page_limit;

        if(!empty($_REQUEST['verify_status'])){
            $params['verify_status'] = $_REQUEST['verify_status'];
        }
        if(!empty($_REQUEST['is_has_video'])){
            $params['is_has_video'] = $_REQUEST['is_has_video'];
        }
        if(!empty($_REQUEST['search_key'])){
            $search_key = $_REQUEST['search_key'];
        }else{
            $search_key = '';
        }

        $rs = ResourcesServer:: getDisVerify($params,$search_key,$page_limit,$page_offset);
        if($rs['code'] == 0){
            $c_count = count($rs['c_data']);
            $count = count($rs['data']);
            $pages = floor($c_count/$page_limit);
            if($pages == 0){
                $pages=1;
            }
            $this->out('0','数据读取成功',['data'=>$rs['data'],'count'=>$count,'c_count'=>$c_count,'pages'=>$pages]);
        }
        $this->out('100401','数据读取失败');

    }
    //查询单个项目链接详情
    public function actionProDetial(){
        $params['k.product_id'] = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $params['k.status'] = 'online';
        if(empty($params['k.product_id'])){
            $this->out('100005','PID不能为空');
        }
        $rs = ProductServer::getProLink($params);//项目的详情

        foreach ($rs['data'] as $k=>$v){
            if($k=='addtime' || $k=='uptime' ){
                $rs['data'][$k] = date('Y-m-d H:i',$v);
            }
        }

        if($rs['code'] !=0){
            $this->out('100404','项目的详情读取失败');
        }
        $rs['data']['show_url']=REAL . U('product/index/index') . '&id=' .  $rs['data']['uid'];

        $up_count = ProductServer::getProductVerify(['product_id'=> $params['k.product_id']]);//项目更新次数
        if($up_count['code'] !=0){
            $this->out('100401','项目更新次数读取失败');
        }
        $die_count = ProductServer::getProductVerify(['product_id'=> $params['k.product_id']],false);//项目屏蔽次数

        if($die_count['code'] !=0){
            $this->out('100402','项目屏蔽次数读取失败');
        }
        if($rs['code'] == 0 && $up_count['code'] == 0 && $die_count['code'] == 0){
            $this->out('0','P详情读取成功',['data'=>$rs['data'],'up_count'=>count($up_count['data']),'die_count'=>count($die_count['data'])]);
        }else{
            $this->out('100403','P详情读取失败','');
        }

    }
    //前端展示项目链接二维码
    public function actionLinkimg(){
        $url=$_REQUEST['url'];
        Tools::createImg($url);
    }
    //解除/屏蔽/审核用户项目
    public function actionForceOut(){
        $params['product_id'] = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $user_tel = !empty($_REQUEST['user_tel']) ? $_REQUEST['user_tel'] : '';
        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';//verifyid
        $params['reason'] = !empty($_REQUEST['reason']) ? urldecode($_REQUEST['reason']) : '';
        if(empty($params['product_id']) || empty($params['type'])){
            $this->out('100005','参数不能为空');
        }

        switch ($params['type']){
            case 'p_ok':
                $status = '通过';
                $line = 'online';
                $look = 'yes';
                $verify_status = 2;
                $verify_reason = '已通过';
                break;
            case 'p_no':
                $status = '已屏蔽';
                $line = 'notonline';
                $look = 'no';
                $verify_status = 2;
                $verify_reason =  $params['reason'];
                break;
//            case 'p_release':
//                $status = '屏蔽后解除';
//                $line = 'online';
//                $look = 'yes';
//                $verify_status = 3;
//                $verify_reason =  $params['reason'];
//                break;
        }


        $transaction = Yii::app()->db->beginTransaction();
        try {
            //更新

            $pro_rs = ProductServer::updateProduct(['product_id'=>$params['product_id']],['status'=>$status,'online'=>$line,'cloud'=>$look]);
            if ($pro_rs['code'] != 0) {
                throw new CException('更新失败', 100001);
            }
            $json_rs = ProductServer::updateProductVerify(['id'=>$params['id']],['verify_status'=>$verify_status,'verify_reason'=> $verify_reason]);

            if ($json_rs['code'] != 0) {
                throw new CException('更新失败', 100001);
            }
            //还没写发送短信
            $transaction->commit();
        }catch (Exception $e) {
            $transaction->rollback();
            $this->out('100444','事务失败');
        }
        $this->out('0','事物成功');
    }

    //备份项目
    public function actionProCopy(){
        $params['product_id'] = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $verify_id = !empty($_REQUEST['verify_id']) ? $_REQUEST['verify_id'] : '';
        if(empty($params['product_id']) || empty($verify_id)){
            $this->out('100005','参数不能为空');
        }
        $origine_rs = ResourcesServer::selectOrigine($params);
        if($origine_rs['code'] == 0){
            foreach ($origine_rs['data'] as $k=>$v){

              OssServer::copyObject('realadobe',$v['datas'],'real-copy',$v['datas']);
            }
        }
        //$re=OssServer::doesBucketExist('real-copy');
        //dump($re);
        $rs = ProductServer::updateProductVerify(['id'=>$verify_id],['copy_status'=>2]);
        if($rs['code'] == 0){
            $this->out('0','项目备份成功');
        }
        $this->out('10444','项目备份失败');
    }
}