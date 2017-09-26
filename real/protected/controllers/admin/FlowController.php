
<?php

/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017/8/23
 * Time: 12:16
 */
header("Content-Type: text/html; charset=utf-8");
class FlowController extends CenterController
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

    //读取流量包类型列表
    public function actionAjax(){

        $sql = 'select t.id,t.type,t.money,t.img_url,t.name,t.grade,IFNULL(sum(o.count),0) as total,(IFNULL(sum(o.count),0)*t.money) as total_money from `r_flow_type` `t` LEFT JOIN `r_type_order` `o` ON t.id=o.flow_type_id group by t.name ORDER BY t.grade DESC ';
       $list= Yii::app()->db->createCommand($sql)->queryAll();

//        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
//        $list = '';
//        if ($params['type'] == 'trigger' || $params['type'] == '') {
//            $flowtype_list =FlowServer::getFlowType(array());
//            if ($flowtype_list['code'] == 0) {
//                $list['flowtype'] = $flowtype_list['data'];
//            }
//        }
        //可以添加多个选项卡数据
        $this->out('0', '成功', array('data' => $list));


    }

    //添加流量包类型
    public function actionFlowTypeadd() {

        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
       // $params['jskey'] = !empty($_REQUEST['jskey']) ? $_REQUEST['jskey'] : '';
        $params['money'] = !empty($_REQUEST['money']) ? $_REQUEST['money'] : '';
        $params['type'] = !empty($_REQUEST['btype']) ? $_REQUEST['btype'] : '';
        if (empty($params['name']) || empty($params['grade']) || empty($params['money']) || empty($params['type']))
            $this->out('100005', '参数不能为空');

      //$res = @move_uploaded_file($_FILES['imgfile']['tmp_name'], ''.'/'.'ddddd.jpg');

      //  $model= FlowType::model();
       // $res=$model->image->saveAs('UPLOAD_PATH');//设置上传路径
      //  dump(GetImageSize($_FILES['imgfile']['tmp_name']));


         $upload_name=uniqid();
         $upload_dir='/uploads/'.$upload_name;
         Tools::ImageToJPG($_FILES['imgfile']['tmp_name'],UPLOAD_PATH.'/'.$upload_name.'.jpg',400,500);

        $params['img_url'] = $upload_dir;
        $params['timespan'] = '365';
        $params['pay'] = 'yes';
        $params['water'] = '0';
        $params['addtime'] = time();
        $rs = FlowServer::addFlowType($params);
        if ($rs['code'] == 0)
            $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID()));
        else
            $this->out('100001', '创建失败');
    }
    //更新流量包类型
    public function actionFlowTypeupdate() {
        $id = !empty($_REQUEST['fid']) ? $_REQUEST['fid'] : '';
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        // $params['jskey'] = !empty($_REQUEST['jskey']) ? $_REQUEST['jskey'] : '';
        $params['money'] = !empty($_REQUEST['money']) ? $_REQUEST['money'] : '';
        $params['type'] = !empty($_REQUEST['btype']) ? $_REQUEST['btype'] : '';
        $del_img_url = !empty($_REQUEST['del_img_url']) ? $_REQUEST['del_img_url'] : '';

        if (empty($id) || empty($params['name']) || empty($params['grade'])  || empty($params['money']) || empty($params['type']))
            $this->out('100005', '参数不能为空');

        if($_FILES['imgfile']['error']==0){

            $upload_name=uniqid();

            $upload_dir='/uploads/'.$upload_name;
            Tools::ImageToJPG($_FILES['imgfile']['tmp_name'],UPLOAD_PATH.'/'.$upload_name.'.jpg',400,500);
            //删除原来的图片
            $params['img_url'] = $upload_dir;
            if(!empty($del_img_url)){
                if(file_exists('/data/www/real'.$del_img_url.'.jpg')){
                    unlink( '/data/www/real'.$del_img_url.'.jpg');
                }
            }
        }
        $rs = FlowServer::updateFlowType(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }
    //删除流量包类型
    public function actionFlowTypeDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');

        $rs = FlowServer::delFlowType(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

}