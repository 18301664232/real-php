<?php

/**
 * 用户公共逻辑类
 * 
 */
class UserServer extends BaseServer {

    //用户登录
    public static function doLogin($params = array()) {
        //个人
        if (isset($params['_id']))
            $Persondata['user_id'] = $params['_id'];
        if (isset($params['tel']))
            $Persondata['tel'] = $params['tel'];
        if (isset($params['email']))
            $Persondata['email'] = $params['email'];
        $param = self::comParams2($Persondata);
        $model = new PersonUser();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $rs = $model->find($criteria);
        if ($rs) {
            if ($rs['pwd'] != $params['pwd'])
                return array('code' => '100002', 'msg' => '用户名或者密码错误');
            if ($rs['status'] != 1)
                return array('code' => '100004', 'msg' => '用户已被锁定');
            return array('code' => '0', 'msg' => '登录成功', 'data' => $rs, 'type' => 'person');
        }

        //公司
        if (isset($params['_id']))
            $Companydata['company_id'] = $params['_id'];
        if (isset($params['tel']))
            $Companydata['tel'] = $params['tel'];
        if (isset($params['email']))
            $Companydata['email'] = $params['email'];
        $param = self::comParams2($Companydata);
        $model = new CompanyUser();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $rs = $model->find($criteria);
        if ($rs) {
            if ($rs['pwd'] != $params['pwd'])
                return array('code' => '100002', 'msg' => '用户名或者密码错误');
            if ($rs['status'] != 1)
                return array('code' => '100004', 'msg' => '用户已被锁定');
            return array('code' => '0', 'msg' => '登录成功', 'data' => $rs, 'type' => 'company');
        }
        return array('code' => '100003', 'msg' => '用户不存在');
    }
    //@syl2017年9月7日
    public static function getUserPhone($user_arr){
            $model = new  PersonUser();
            $criteria = new CDbCriteria;
            $criteria->select = 'user_id,tel';
            $criteria->addInCondition('user_id',$user_arr);
            $rs = $model->findAll($criteria);
           if($rs){
               return array('code' => '0', 'data' => $rs);
           }else{
               return array('code' => '100401', 'data' => []);
           }

        }

    //查询用户信息
    public static function selUser($params = array()) {
        if ($params['pc_type'] == 1 || $params['pc_type'] == 0) {
            //个人
            if (isset($params['_id']))
                $Persondata['user_id'] = $params['_id'];
            if (isset($params['tel']))
                $Persondata['tel'] = $params['tel'];
            if (isset($params['email']))
                $Persondata['email'] = $params['email'];
            if (isset($params['password']))
                $Persondata['pwd'] = $params['password'];
            $param = self::comParams2($Persondata);
            $model = new PersonUser();
            $criteria = new CDbCriteria;
            $criteria->select = '*';
            $criteria->condition = $param['con'];
            $criteria->params = $param['par'];
            $rs = $model->find($criteria);
            if ($rs) {
                return array('code' => '0', 'msg' => '查询成功', 'data' => $rs, 'type' => 'person');
            }
        }
        if ($params['pc_type'] == 2 || $params['pc_type'] == 0) {
            //公司
            if (isset($params['_id']))
                $Companydata['company_id'] = $params['_id'];
            if (isset($params['tel']))
                $Companydata['tel'] = $params['tel'];
            if (isset($params['email']))
                $Companydata['email'] = $params['email'];
            if (isset($params['password']))
                $Companydata['pwd'] = $params['password'];
            $param = self::comParams2($Companydata);
            $model = new CompanyUser();
            $criteria = new CDbCriteria;
            $criteria->select = '*';
            $criteria->condition = $param['con'];
            $criteria->params = $param['par'];
            $rs = $model->find($criteria);
            if ($rs) {
                return array('code' => '0', 'msg' => '查询成功', 'data' => $rs, 'type' => 'company');
            }
        }
        return array('code' => '100003', 'msg' => '用户不存在');
    }

    //添加用户
    public static function addUser($params) {
        if ($params['type'] == 1) {
            $model = new PersonUser();
            $model->attributes = $params;
            $rs = $model->save();
            if ($rs) {
                return array('code' => '0', 'msg' => '添加成功');
            } else {
                return array('code' => '100001', 'msg' => '添加失败');
            }
        } elseif ($params['type'] == 2) {
            $model = new CompanyUser();
            $model->attributes = $params;
            $rs = $model->save();
            if ($rs) {
                return array('code' => '0', 'msg' => '添加成功');
            } else {
                return array('code' => '100001', 'msg' => '添加失败');
            }
        }
    }

    //修改用户信息
    public static function updateUser($condition, $params) {
        $param = self::comParams($condition);
        if (isset($condition['user_id'])) {
            $rs = PersonUser::model()->updateAll($params, $param);
        } elseif (isset($condition['company_id'])) {
            $rs = CompanyUser::model()->updateAll($params, $param);
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //验证用户名是否存在
    public static function checkUsername($username) {
        //个人
        $sql = "select * from r_person_user where `tel` ='$username' or `email` = '$username'";
        $result = PersonUser::model()->dbConnection->createCommand($sql)->queryAll();
        if ($result)
            return array('code' => '0', 'msg' => '用户名已存在');
        //公司
        $sql = "select * from r_company_user where `tel` ='$username' or `email` = '$username'";
        $result = CompanyUser::model()->dbConnection->createCommand($sql)->queryAll();
        if ($result)
            return array('code' => '0', 'msg' => '用户名已存在');
        return array('code' => '100001', 'msg' => '用户名不存在');
    }

    //验证ID是否存在
    public static function checkId($id) {
        //个人
        $sql = "select * from r_person_user where `user_id` ='$id'";

        $result = PersonUser::model()->dbConnection->createCommand($sql)->queryAll();
        if ($result)
            return array('code' => '0', 'msg' => 'id已存在', 'data' => $result);
        //公司
        $sql = "select * from r_company_user where `company_id` ='$id'";
        $result = CompanyUser::model()->dbConnection->createCommand($sql)->queryAll();
        if ($result)
            return array('code' => '0', 'msg' => 'id已存在', 'data' => $result);
        return array('code' => '100001', 'msg' => '用户名不存在');
    }

}
