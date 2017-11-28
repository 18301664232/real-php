<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-27 08:42:26
 */
class AdminController extends CenterController
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

    //读取后台管理员表列表
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

    //添加后台管理员表
    public function actionAdminadd() {

        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['username'] = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
$params['password'] = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
$params['last_time'] = !empty($_REQUEST['last_time']) ? $_REQUEST['last_time'] : '';
$params['last_ip'] = !empty($_REQUEST['last_ip']) ? $_REQUEST['last_ip'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';
$params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['username'] = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
$params['password'] = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
$params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
$params['department'] = !empty($_REQUEST['department']) ? $_REQUEST['department'] : '';
$params['last_time'] = !empty($_REQUEST['last_time']) ? $_REQUEST['last_time'] : '';
$params['last_ip'] = !empty($_REQUEST['last_ip']) ? $_REQUEST['last_ip'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';
$params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['username'] = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
$params['password'] = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
$params['last_time'] = !empty($_REQUEST['last_time']) ? $_REQUEST['last_time'] : '';
$params['last_ip'] = !empty($_REQUEST['last_ip']) ? $_REQUEST['last_ip'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';

        if(empty($params['id']) || empty($params['username']) || empty($params['password']) || empty($params['last_time']) || empty($params['last_ip']) || empty($params['addtime']) || empty($params['id']) || empty($params['username']) || empty($params['password']) || empty($params['name']) || empty($params['department']) || empty($params['last_time']) || empty($params['last_ip']) || empty($params['addtime']) || empty($params['id']) || empty($params['username']) || empty($params['password']) || empty($params['last_time']) || empty($params['last_ip']) || empty($params['addtime']) || empty(2))

          $this->out('100005', '参数不能为空');
        $params['paynum'] = 0;
        $params['paytotal'] = 0;
        $params['addtime'] = time();
        $rs = AdminServer::addAdmin($params);
        if ($rs['code'] == 0)
            $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID(), 'jskey' => $params['jskey']));
        else
            $this->out('100001', '创建失败');
    }
    //更新后台管理员表
    public function actionAdminupdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['username'] = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
$params['password'] = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
$params['last_time'] = !empty($_REQUEST['last_time']) ? $_REQUEST['last_time'] : '';
$params['last_ip'] = !empty($_REQUEST['last_ip']) ? $_REQUEST['last_ip'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';
$params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['username'] = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
$params['password'] = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
$params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
$params['department'] = !empty($_REQUEST['department']) ? $_REQUEST['department'] : '';
$params['last_time'] = !empty($_REQUEST['last_time']) ? $_REQUEST['last_time'] : '';
$params['last_ip'] = !empty($_REQUEST['last_ip']) ? $_REQUEST['last_ip'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';
$params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
$params['username'] = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
$params['password'] = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
$params['last_time'] = !empty($_REQUEST['last_time']) ? $_REQUEST['last_time'] : '';
$params['last_ip'] = !empty($_REQUEST['last_ip']) ? $_REQUEST['last_ip'] : '';
$params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';

        if(empty($params['id']) || empty($params['username']) || empty($params['password']) || empty($params['last_time']) || empty($params['last_ip']) || empty($params['addtime']) || empty($params['id']) || empty($params['username']) || empty($params['password']) || empty($params['name']) || empty($params['department']) || empty($params['last_time']) || empty($params['last_ip']) || empty($params['addtime']) || empty($params['id']) || empty($params['username']) || empty($params['password']) || empty($params['last_time']) || empty($params['last_ip']) || empty($params['addtime']) || empty(2))
            $this->out('100005', '参数不能为空');
        $rs = AdminServer::updateAdmin(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }
    //删除后台管理员表
    public function actionAdminDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');

        $rs = AdminServer::delAdmin(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

}