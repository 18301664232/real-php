<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-27 05:35:46
 */
class AuthPermissionsController extends CenterController
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

    //读取权限表列表
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

    //添加权限表
    public function actionAuthPermissionsadd() {

        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['permissions_main'] = !empty($_REQUEST['permissions_main']) ? $_REQUEST['permissions_main'] : '';
$params['permissions_name'] = !empty($_REQUEST['permissions_name']) ? $_REQUEST['permissions_name'] : '';
$params['permissions_sign'] = !empty($_REQUEST['permissions_sign']) ? $_REQUEST['permissions_sign'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';

        if(empty($params['id']) || empty($params['permissions_main']) || empty($params['permissions_name']) || empty($params['permissions_sign']) || empty($params['addtime']) || empty(2))

          $this->out('100005', '参数不能为空');
        $params['paynum'] = 0;
        $params['paytotal'] = 0;
        $params['addtime'] = time();
        $rs = AuthPermissionsServer::addAuthPermissions($params);
        if ($rs['code'] == 0)
            $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID(), 'jskey' => $params['jskey']));
        else
            $this->out('100001', '创建失败');
    }
    //更新权限表
    public function actionAuthPermissionsupdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['permissions_main'] = !empty($_REQUEST['permissions_main']) ? $_REQUEST['permissions_main'] : '';
$params['permissions_name'] = !empty($_REQUEST['permissions_name']) ? $_REQUEST['permissions_name'] : '';
$params['permissions_sign'] = !empty($_REQUEST['permissions_sign']) ? $_REQUEST['permissions_sign'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';

        if(empty($params['id']) || empty($params['permissions_main']) || empty($params['permissions_name']) || empty($params['permissions_sign']) || empty($params['addtime']) || empty(2))
            $this->out('100005', '参数不能为空');
        $rs = AuthPermissionsServer::updateAuthPermissions(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }
    //删除权限表
    public function actionAuthPermissionsDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');

        $rs = AuthPermissionsServer::delAuthPermissions(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

}