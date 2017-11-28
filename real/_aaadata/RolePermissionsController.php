<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-27 05:36:37
 */
class RolePermissionsController extends CenterController
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

    //读取角色与权限关联表列表
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

    //添加角色与权限关联表
    public function actionRolePermissionsadd() {

        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['role_id'] = !empty($_REQUEST['role_id']) ? $_REQUEST['role_id'] : '';
$params['permissions_id'] = !empty($_REQUEST['permissions_id']) ? $_REQUEST['permissions_id'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';

        if(empty($params['id']) || empty($params['role_id']) || empty($params['permissions_id']) || empty($params['addtime']) || empty(2))

          $this->out('100005', '参数不能为空');
        $params['paynum'] = 0;
        $params['paytotal'] = 0;
        $params['addtime'] = time();
        $rs = RolePermissionsServer::addRolePermissions($params);
        if ($rs['code'] == 0)
            $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID(), 'jskey' => $params['jskey']));
        else
            $this->out('100001', '创建失败');
    }
    //更新角色与权限关联表
    public function actionRolePermissionsupdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['role_id'] = !empty($_REQUEST['role_id']) ? $_REQUEST['role_id'] : '';
$params['permissions_id'] = !empty($_REQUEST['permissions_id']) ? $_REQUEST['permissions_id'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';

        if(empty($params['id']) || empty($params['role_id']) || empty($params['permissions_id']) || empty($params['addtime']) || empty(2))
            $this->out('100005', '参数不能为空');
        $rs = RolePermissionsServer::updateRolePermissions(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }
    //删除角色与权限关联表
    public function actionRolePermissionsDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');

        $rs = RolePermissionsServer::delRolePermissions(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

}