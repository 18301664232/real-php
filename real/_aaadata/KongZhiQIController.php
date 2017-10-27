<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-10-25 10:35:25
 */
class KongZhiQIController extends CenterController
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

    //读取小时统计表列表
    public function actionAjax(){

        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $list = '';

          if ($params['type'] == '' || $params['type'] == '') {
            $_list =::(array());
             if ($_list['code'] == 0) {
               $list[''] = $_list['data'];
                  }
                }

        $this->out('0', '成功', array('data' => $list));


    }

    //添加小时统计表
    public function actionStatisticsDayadd() {

        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['uv'] = !empty($_REQUEST['uv']) ? $_REQUEST['uv'] : '';
$params['pv'] = !empty($_REQUEST['pv']) ? $_REQUEST['pv'] : '';
$params['nv'] = !empty($_REQUEST['nv']) ? $_REQUEST['nv'] : '';
$params['register'] = !empty($_REQUEST['register']) ? $_REQUEST['register'] : '';
$params['issuance_user'] = !empty($_REQUEST['issuance_user']) ? $_REQUEST['issuance_user'] : '';
$params['total_flow'] = !empty($_REQUEST['total_flow']) ? $_REQUEST['total_flow'] : '';
$params['total_order'] = !empty($_REQUEST['total_order']) ? $_REQUEST['total_order'] : '';
$params['total_money'] = !empty($_REQUEST['total_money']) ? $_REQUEST['total_money'] : '';
$params['free_product'] = !empty($_REQUEST['free_product']) ? $_REQUEST['free_product'] : '';
$params['pay_product'] = !empty($_REQUEST['pay_product']) ? $_REQUEST['pay_product'] : '';
$params['issuance_product'] = !empty($_REQUEST['issuance_product']) ? $_REQUEST['issuance_product'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';

        if(empty($params['id']) || empty($params['uv']) || empty($params['pv']) || empty($params['nv']) || empty($params['register']) || empty($params['issuance_user']) || empty($params['total_flow']) || empty($params['total_order']) || empty($params['total_money']) || empty($params['free_product']) || empty($params['pay_product']) || empty($params['issuance_product']) || empty($params['addtime']) || empty(2))

          $this->out('100005', '参数不能为空');
        $params['paynum'] = 0;
        $params['paytotal'] = 0;
        $params['addtime'] = time();
        $rs = FuWuQiServer::addStatisticsDay($params);
        if ($rs['code'] == 0)
            $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID(), 'jskey' => $params['jskey']));
        else
            $this->out('100001', '创建失败');
    }
    //更新小时统计表
    public function actionStatisticsDayupdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['uv'] = !empty($_REQUEST['uv']) ? $_REQUEST['uv'] : '';
$params['pv'] = !empty($_REQUEST['pv']) ? $_REQUEST['pv'] : '';
$params['nv'] = !empty($_REQUEST['nv']) ? $_REQUEST['nv'] : '';
$params['register'] = !empty($_REQUEST['register']) ? $_REQUEST['register'] : '';
$params['issuance_user'] = !empty($_REQUEST['issuance_user']) ? $_REQUEST['issuance_user'] : '';
$params['total_flow'] = !empty($_REQUEST['total_flow']) ? $_REQUEST['total_flow'] : '';
$params['total_order'] = !empty($_REQUEST['total_order']) ? $_REQUEST['total_order'] : '';
$params['total_money'] = !empty($_REQUEST['total_money']) ? $_REQUEST['total_money'] : '';
$params['free_product'] = !empty($_REQUEST['free_product']) ? $_REQUEST['free_product'] : '';
$params['pay_product'] = !empty($_REQUEST['pay_product']) ? $_REQUEST['pay_product'] : '';
$params['issuance_product'] = !empty($_REQUEST['issuance_product']) ? $_REQUEST['issuance_product'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';

        if(empty($params['id']) || empty($params['uv']) || empty($params['pv']) || empty($params['nv']) || empty($params['register']) || empty($params['issuance_user']) || empty($params['total_flow']) || empty($params['total_order']) || empty($params['total_money']) || empty($params['free_product']) || empty($params['pay_product']) || empty($params['issuance_product']) || empty($params['addtime']) || empty(2))
            $this->out('100005', '参数不能为空');
        $rs = FuWuQiServer::updateStatisticsDay(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }
    //删除小时统计表
    public function actionStatisticsDayDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');

        $rs = FuWuQiServer::delStatisticsDay(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

}