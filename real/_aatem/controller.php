<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: _TIME_
 */
class _CONTROLLERNAME_Controller extends _EXTENDSNAME_
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

    //读取_HAHA_列表
    public function actionAjax(){

        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $list = '';

        _GETDATATYPE_
        $this->out('0', '成功', array('data' => $list));


    }

    //添加_HAHA_
    public function action_MODELNAME_add() {

        _ADDMETHODONE_
        _ADDMETHODTWO_

          $this->out('100005', '参数不能为空');
        $params['paynum'] = 0;
        $params['paytotal'] = 0;
        $params['addtime'] = time();
        $rs = _SELFSERVERNAME_Server::add_MODELNAME_($params);
        if ($rs['code'] == 0)
            $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID(), 'jskey' => $params['jskey']));
        else
            $this->out('100001', '创建失败');
    }
    //更新_HAHA_
    public function action_MODELNAME_update() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        _UPDATEMETHODONE_
        _UPDATEMETHODTWO_
            $this->out('100005', '参数不能为空');
        $rs = _SELFSERVERNAME_Server::update_MODELNAME_(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }
    //删除_HAHA_
    public function action_MODELNAME_Del() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');

        $rs = _SELFSERVERNAME_Server::del_MODELNAME_(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

}