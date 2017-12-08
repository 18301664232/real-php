<?php

/**
 * 管理员公共逻辑类
 * 
 */
class AdminServer extends BaseServer {

    //用户登录
    public static function doLogin($params = array()) {
        if (!is_array($params)) {
            return array('code' => '100002', 'msg' => '参数错误');
        }
        $param = self::comParams2($params);
        $model = new Admin();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $rs = $model->find($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '正在登录', 'data' => $rs);
        } else {
            return array('code' => '100002', 'msg' => '用户或密码错误');
        }
    }

    //修改用户信息
    public static function updateAdmin($condition, $params) {
        $param = self::comParams($condition);
        $rs = Admin::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //查询用户权限
    public static function getPromissionsList($params=[], $search_key=''){
//        $param = self::comParams($params);
//        if($param){
//            $str=$param;
//        }else{
//            $str='t.addtime < 200000000000';
//        }
//        if($search_key==''){
//            $search_key = '_';
//        }
        $rs = Yii::app()->db->createCommand()
            ->select('a.id as aid,p.permissions_main,p.permissions_name,p.permissions_sign')
            ->from('r_admin a')
            ->join('r_admin_role e','a.`id`=e.`admin_id`')
            ->join('r_auth_role r', 'r.id=e.role_id')
            ->join('r_role_permissions s', 's.role_id=r.id')
            ->join('r_auth_permissions p', 'p.id=s.permissions_id')
            //->andWhere(['like','r.role_name','%'.$search_key.'%'])
            ->Where(['in','a.id',$params])
           // ->group('t.product_id')
           // ->order('t.addtime DESC')
            ->queryAll();
        $permissions_arr = [];
        foreach ($rs as $key =>$vel){
            if(!empty($permissions_arr[$vel['aid']]['permissions_main'])){
                if(!in_array($vel['permissions_main'],$permissions_arr[$vel['aid']]['permissions_main'])){
                    $permissions_arr[$vel['aid']]['permissions_main'][]=$vel['permissions_main'];
                }
            }else{
                $permissions_arr[$vel['aid']]['permissions_main'][]=$vel['permissions_main'];
            }
            $permissions_arr[$vel['aid']]['permissions_name'][]=$vel['permissions_name'];
            $permissions_arr[$vel['aid']]['permissions_sign'][]=$vel['permissions_sign'];
        }

        if ($permissions_arr) {
            return array('code' => '0', 'data' => $permissions_arr);
        } else {
            return array('code' => '100001', 'data' => []);
        }


    }


    //获取后台管理员表数据
    public static function getAdmin($params = array(),$search_key='',$page)
    {
        $pagesize = 4;
        $offset = ($page - 1) * $pagesize;
        $param = self::comParams2($params);
        $model = new Admin();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        if(!empty($search_key)){

            $criteria->addSearchCondition('CONCAT(username,IFNULL(name,""))', "$search_key");
        }else{
             $criteria->condition = $param['con'];
             $criteria->params = $param['par'];
        }
        $criteria->order = 'addtime DESC';
        $criteria->limit = $pagesize;   //取1条数据，如果小于0，则不作处理
        $criteria->offset = $offset;   //两条合并起来，则表示 limit 10
        $rs = $model->findAll($criteria);

        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }
    public static function getAdminCount($params = array(),$search_key='',$page)
    {
        $pagesize = 4;
        $offset = ($page - 1) * $pagesize;
        $param = self::comParams2($params);
        $model = new Admin();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        if(!empty($search_key)){
            $criteria->addSearchCondition('CONCAT(username,IFNULL(name,""))',  "$search_key");
        }else{
            $criteria->condition = $param['con'];
            $criteria->params = $param['par'];
        }
        $criteria->order = 'addtime DESC';
        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }

    //删除后台管理员表表数据
    public static function delAdmin($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = Admin::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加后台管理员表表数据
    public static function addAdmin($params)
    {
        $model = new Admin();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功','data'=>$model->attributes['id']);
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }



}
