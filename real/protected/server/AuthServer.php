<?php

/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-06 11:17:17
 */
class AuthServer extends BaseServer
{
    
    //获取全部角色的权限
    public static function getRolePermissionsList($params=[],$search_key=''){
        //        $param = self::comParams($params);
//        if($param){
//            $str=$param;
//        }else{
//            $str='t.addtime < 200000000000';
//        }
        if($search_key==''){
            $search_key = '_';
        }
        $rs = Yii::app()->db->createCommand()
            ->select('r.role_name as name,r.id as id,p.permissions_main,p.permissions_name,p.permissions_sign')
            ->from('r_auth_role r')
            ->join('r_role_permissions s', 's.role_id=r.id')
            ->join('r_auth_permissions p', 'p.id=s.permissions_id')
            //->andWhere(['like','r.role_name','%'.$search_key.'%'])
           // ->andWhere(['in','r.role_name',$params])
            ->queryAll();
        $permissions_arr = [];
        foreach ($rs as $key =>$vel){
            if(!empty($permissions_arr[$vel['name']]['permissions_main'])){
                if(!in_array($vel['permissions_main'],$permissions_arr[$vel['name']]['permissions_main'])){
                    $permissions_arr[$vel['name']]['permissions_main'][]=$vel['permissions_main'];
                }
            }else{
                $permissions_arr[$vel['name']]['permissions_main'][]=$vel['permissions_main'];
            }
            $permissions_arr[$vel['name']]['permissions_name'][]=$vel['permissions_name'];
            $permissions_arr[$vel['name']]['permissions_sign'][]=$vel['permissions_sign'];
        }

        if ($permissions_arr) {
            return array('code' => '0', 'data' => $permissions_arr);
        } else {
            return array('code' => '100001', 'data' => []);
        }



    }

    //获取管理员与角色关联表数据
    public static function getAdminRole($params = array())
    {

        $param = self::comParams2($params);
        $model = new AdminRole();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = 'addtime DESC';

        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }

    //删除管理员与角色关联表表数据
    public static function delAdminRole($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = AdminRole::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加管理员与角色关联表表数据
    public static function addAdminRole($params)
    {
        $model = new AdminRole();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

//修改管理员与角色关联表表数据
    public static function updateAdminRole($condition, $params)
    {

        $param = self::comParams($condition);
        $rs = AdminRole::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

    //获取权限表数据
    public static function getAuthPermissions($params = array())
    {

        $param = self::comParams2($params);
        $model = new AuthPermissions();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = 'addtime DESC';

        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }

    //删除权限表表数据
    public static function delAuthPermissions($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = AuthPermissions::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加权限表表数据
    public static function addAuthPermissions($params)
    {
        $model = new AuthPermissions();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

//修改权限表表数据
    public static function updateAuthPermissions($condition, $params)
    {

        $param = self::comParams($condition);
        $rs = AuthPermissions::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

    //获取角色表数据
    public static function getAuthRole($params = array())
    {

        $param = self::comParams2($params);
        $model = new AuthRole();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = 'addtime DESC';

        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }

    //删除角色表表数据
    public static function delAuthRole($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = AuthRole::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加角色表表数据
    public static function addAuthRole($params)
    {
        $model = new AuthRole();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功','data'=>$model->attributes['id']);
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

//修改角色表表数据
    public static function updateAuthRole($condition, $params)
    {

        $param = self::comParams($condition);
        $rs = AuthRole::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

    //获取角色与权限关联表数据
    public static function getRolePermissions($params = array())
    {

        $param = self::comParams2($params);
        $model = new RolePermissions();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = 'addtime DESC';

        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }

    //删除角色与权限关联表表数据
    public static function delRolePermissions($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = RolePermissions::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加角色与权限关联表表数据
    public static function addRolePermissions($params)
    {
        $model = new RolePermissions();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

//修改角色与权限关联表表数据
    public static function updateRolePermissions($condition, $params)
    {

        $param = self::comParams($condition);
        $rs = RolePermissions::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

}