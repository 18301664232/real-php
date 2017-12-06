<?php
//用户授权类
class RoleController extends  CenterController

{
    public $layout = 'admin'; //定义布局
    public function init() {
        parent::init();
        if (!$this->checkLogin('admin'))
            $this->showMessage('未登录', U('admin/login/login'));
    }

    //输出页面
    public function actionList()
    {

        //查询所有的权限
        $rs = AuthServer::getAuthPermissions();
        if($rs['code']!=0){
            $this->out('100444','数据获取失败');
        }
        foreach ($rs['data'] as $key=>$vel){
            $data_arr["$vel[permissions_main]"][] = ['permissions_name'=>$vel['permissions_name'],'id'=>$vel['id']];
        }
        $this->render('list',['data'=>$data_arr]);
       // $this->render('list',['data'=>$rs['data']]);
    }

    //输出列表
    public function actionGetList(){
        $search_key = !empty($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
        $role_id = !empty($_REQUEST['role_id']) ? $_REQUEST['role_id'] : [];
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $rs = AuthServer::getRolePermissionsList($role_id,$search_key,$page);
        $c_count =count($rs['data']);
        if($rs['code']!=0){
            $this->out('100444','数据获取失败');
        }else{
           $this->out('0','查询成功',['data'=> $rs['data'],'c_count'=>$c_count,'count'=>$rs['count'],'pages'=>$rs['pages']]);
            //$this->out('0','查询成功',['data'=> $rs['data'],'c_count'=>$c_count]);
        }

    }

    //更新角色的权限
    public function  actionUpdateRole(){
        $params['role_id'] = !empty($_REQUEST['role_id']) ? $_REQUEST['role_id'] : '';
        $params['role_permissions'] = !empty($_REQUEST['role_permissions']) ? json_decode($_REQUEST['role_permissions']) : '';

        if(empty($params['role_id']) || empty($params['role_permissions'])){
            $this->out('100444','参数不能为空');
        }
        //开启事务处理
        $transaction = Yii::app()->db->beginTransaction();
        try {
        //全部删除权限
            $rs = AuthServer::delRolePermissions(['role_id'=>$params['role_id']]);
            if ($rs['code'] != 0) {
                throw new CException('删除失败', 100009);
            }
        //添加权限
            foreach ($params['role_permissions'] as $k=>$v){
                $res = AuthServer::addRolePermissions(['role_id'=>$params['role_id'],'permissions_id'=>$v,'addtime'=>time()]);
                if ($res['code'] != 0) {
                    throw new CException('添加失败', 100008);
                }
            }

            $transaction->commit();
            $this->out('0','添加成功');
        } catch (Exception $e) {
            $transaction->rollback();
            $this->out('100444','添加失败',['data'=>$e]);
            exit;
        }




    }


    //创建角色并关联权限
    public function actionCreateRole()
    {
        $params['role_name'] = !empty($_REQUEST['role_name']) ? $_REQUEST['role_name'] : '';
        $params['role_permissions'] = !empty($_REQUEST['role_permissions']) ? json_decode($_REQUEST['role_permissions']) : '';

        if(empty($params['role_name']) || empty($params['role_permissions'])){
            $this->out('100444','参数不能为空');
        }
        //开启事务处理
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //角色表添加角色
            $rs = AuthServer::addAuthRole(['role_name'=>$params['role_name'],'addtime'=>time()]);
            if ($rs['code'] != 0) {
                throw new CException('添加失败', 100008);
            }
            $RPparams['role_id'] = $rs['data'];
            $rid = $rs['data'];
            //增加角色映射权限
            foreach ($params['role_permissions'] as $k=>$v){
                $rs = AuthServer::addRolePermissions(['role_id'=>$rid,'permissions_id'=>$v,'addtime'=>time()]);
                if ($rs['code'] != 0) {
                    throw new CException('添加失败', 100009);
                }
            }
            $transaction->commit();
            $this->out('0','创建成功');
        } catch (Exception $e) {
            $transaction->rollback();
            $this->out('100445','创建失败');
            exit;
        }

    }

    //删除角色
    public function actionDelRole(){
        $params['role_id'] = !empty($_REQUEST['role_id']) ? $_REQUEST['role_id'] : '';
        if(empty($params['role_id'])){
            $this->out('100444','参数不能为空');
        }
        //执行删除
        //开启事务处理
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $rs = AuthServer::delAuthRole(['id'=>$params['role_id']]);
            if ($rs['code'] != 0) {
                throw new CException('删除失败', 100008);
            }
            $rs = AuthServer::delRolePermissions(['role_id'=>$params['role_id']]);
                if ($rs['code'] != 0) {
                    throw new CException('删除失败', 100009);
                }
//            $rs = AuthServer::delAdminRole(['role_id'=>$params['role_id']]);
//            if ($rs['code'] != 0) {
//                throw new CException('删除失败', 100010);
//            }
            $transaction->commit();
            $this->out('0','删除成功');
        } catch (Exception $e) {
            $transaction->rollback();
            $this->out('100444','删除失败');
            exit;
        }

    }

}