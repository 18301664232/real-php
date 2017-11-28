<?php
//用户授权类
class AuthController extends BaseController

{
    public $layout = 'admin';
    public function init() {
        parent::init();
        if (!$this->checkLogin('admin'))
            $this->showMessage('未登录', U('admin/login/login'));
    }

    //输出页面
    public function actionList()
    {
        //读取全部的角色
        $rs = AuthServer::getAuthRole();
        $this->render('list',['data'=>$rs['data']]);
    }

    //输出列表
    public function actionGetList(){
        //读取全部的帐号
        $rs = AdminServer::getAdmin();
        var_dump($rs);die;
        if($rs['code'] == 0){
            $admin_id_arr = [];
            foreach ($rs['data'] as $key =>$vel){
                $admin_id_arr[]=$vel['id'];
            }
            //查处对应的权限
            $prs = AdminServer::getPromissionsList($admin_id_arr);
            if($prs['code'] ==0){
                foreach ($prs['data'] as $key =>$vel){
                    foreach ($rs['data'] as $k=>$v){
                        if($key == $v['id']){
                            $rs['data'][$k]['permissions'] = $vel;
                        }
                    }
                }
               $this->out('0','查询成功',['data'=> $rs['data']]);
            }else{
                $this->out('100444','查询失败');
            }
        }else{
            $this->out('100445','查询失败');
        }

    }

    //创建后台帐号并执行授权
    public function actionGrantRight()
    {
        $params['account'] = !empty($_REQUEST['account']) ? $_REQUEST['account'] : '';
        $params['password'] = !empty($_REQUEST['password']) ? Tools::setpwd($_REQUEST['password']) : '';
        $params['department'] = !empty($_REQUEST['department']) ? $_REQUEST['department'] : '';
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $param['role_id'] = !empty($_REQUEST['role_id']) ? $_REQUEST['role_id'] : '';
        if(empty($params['account']) || empty($params['password']) || empty($params['department'])|| empty($params['name'])|| empty($param['role_id'])){
            $this->out('100444','参数不能为空');
        }
        //开启事务处理
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //存入后台管理员表
            $rs = AdminServer::addAdmin($params);
            if ($rs['code'] != 0) {
                throw new CException('添加失败', 100008);
            }
            //添加到角色与管理员关联表
            $res = AuthServer::delAdminRole(['role_id'=>$param['role_id'],'admin_id'=>$rs['data']]);
                if ($res['code'] != 0) {
                    throw new CException('添加失败', 100009);
                }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            exit;
        }
    }

    //删除帐号
    public function actionDelAccount(){
        $params['account_id'] = !empty($_REQUEST['account_id']) ? $_REQUEST['account_id'] : '';
        if(empty($params['account_id'])){
            $this->out('100444','参数不能为空');
        }
        //执行删除
        //开启事务处理
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $rs = AdminServer::delAdmin(['id'=>$params['account_id']]);
            if ($rs['code'] != 0) {
                throw new CException('添加失败', 100008);
            }
            $rs = AuthServer::delAdminRole(['admin_id'=>$params['admin_id']]);
            if ($rs['code'] != 0) {
                throw new CException('添加失败', 100010);
            }
            $transaction->commit();
            $this->out('0','删除成功');
        } catch (Exception $e) {
            $transaction->rollback();
            $this->out('100444','删除失败');
            exit;
        }

    }


}