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
    //单独查询个人用户信息
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

    //单独查询个人用户信息
    public static function GetSelfUser($params = array()){
        //个人
        if (isset($params['user_id']))
            $Persondata['user_id'] = $params['user_id'];
        if (isset($params['tel']))
            $Persondata['tel'] = $params['tel'];
        if (isset($params['email']))
            $Persondata['email'] = $params['email'];
        if (isset($params['password']))
            $Persondata['pwd'] = $params['password'];

        $model = new PersonUser();
        $criteria = new CDbCriteria;
        if(empty($Persondata)){
            $criteria->select = '*';
            $rs = $model->findAll($criteria);
        }else{
            $param = self::comParams2($Persondata);
            $criteria->select = '*';
            $criteria->condition = $param['con'];
            $criteria->params = $param['par'];
            $rs = $model->findAll($criteria);
        }

        if ($rs) {
            return array('code' => '0', 'msg' => '查询成功', 'data' => $rs, 'type' => 'person');
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

            $model = new PersonUser();
            $criteria = new CDbCriteria;
            if(empty($Persondata)){
                $criteria->select = '*';
                $rs = $model->findAll($criteria);
            }else{
                $param = self::comParams2($Persondata);
                $criteria->select = '*';
                $criteria->condition = $param['con'];
                $criteria->params = $param['par'];
                $rs = $model->find($criteria);
            }

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

    //查询后台用户管理数据

    public static function getAdminManageDate($type,$user_status,$start_time,$end_time,$page_limit,$page_offset,$search_key){
//        $start_time =0;
//        $end_time= 88888888888888;
//        $type ='pay';
//        $user_status = 1;

        //删除视图
        $view_sql = "DROP VIEW IF EXISTS `r_user_view`";
        $view_rs = Yii::app()->db->createCommand($view_sql)->execute();

        //建立访问表person_user表视图
        if($type == 'total'){
            $view_sql = "CREATE VIEW `r_user_view` AS SELECT * FROM `r_person_user`";
            if(!empty($search_key)){
                $view_sql.=" WHERE `tel`=$search_key OR `email`= $search_key ";
            }
            if(!empty($user_status)){
                $view_sql.=" WHERE `status`=$user_status";
            }
        }else if($type == 'register'){
            $view_sql = "CREATE VIEW `r_user_view` AS SELECT * FROM `r_person_user` WHERE `addtime` >=$start_time AND `addtime`< $end_time";
            if(!empty($user_status)){
                $view_sql.=" AND `status`=$user_status";
            }

        }else if ($type == 'login'){
            $view_sql = "CREATE VIEW `r_user_view` AS SELECT * FROM `r_person_user` WHERE `last_time` >=$start_time AND `last_time`< $end_time";
            if(!empty($user_status)){
                $view_sql.=" AND `status`=$user_status";
            }
        }else if ($type == 'issuance'){
            $view_sql = "CREATE VIEW `r_user_view` AS SELECT u.* FROM `r_product_verify` `v` LEFT JOIN `r_product` `p` ON  v.`product_id` = p.`product_id` LEFT JOIN `r_person_user` `u` ON u.`user_id`=p.`user_id`  WHERE `last_time` >=$start_time AND `last_time`< $end_time  GROUP BY p.`user_id`";
            if(!empty($user_status)){
                $view_sql = "CREATE VIEW `r_user_view` AS SELECT u.* FROM `r_product_verify` `v` LEFT JOIN `r_product` `p` ON  v.`product_id` = p.`product_id` LEFT JOIN `r_person_user` `u` ON u.`user_id`=p.`user_id`  WHERE `last_time` >=$start_time AND `last_time`< $end_time AND `u`.`status`=$user_status GROUP BY p.`user_id`";
            }
        }else if ($type == 'pay'){
            $view_sql = "CREATE VIEW `r_user_view` AS SELECT u.* FROM `r_order_info` `o`  LEFT JOIN `r_person_user` `u` ON u.`user_id`=o.`user_id`  WHERE `last_time` >=$start_time AND `last_time`< $end_time AND o.`status`='yes' GROUP BY u.`user_id`";
            if(!empty($user_status)){
                $view_sql = "CREATE VIEW `r_user_view` AS SELECT u.* FROM `r_order_info` `o` LEFT JOIN `r_person_user` `u` ON u.`user_id`=o.`user_id`  WHERE `last_time` >=$start_time AND `last_time`< $end_time AND o.`status`='yes' AND `u`.`status`=$user_status GROUP BY u.`user_id`";

            }
        }
        $view_rs = Yii::app()->db->createCommand($view_sql)->execute();
        //求出一共的数据条数
        $c_count_sql = "SELECT COUNT(*) AS `c_count` FROM `r_user_view`";
        $c_count = Yii::app()->db->createCommand($c_count_sql)->queryRow();
        //查询订单金额
        $user_order= Yii::app()->db->createCommand()
            ->select('u.id,u.user_id,u.tel,u.email,u.addtime,u.last_time,u.status,IFNULL(sum(o.money),0) as total_money,IFNULL(o.status,"no") as status_o')
            ->from('r_user_view u')
            ->leftjoin('r_order_info o','o.user_id=u.user_id')
            //->where('o.`status`="yes"')
            ->group('u.user_id,o.status')
            ->order('u.addtime DESC')
            ->queryAll();
        //遍历数组
        foreach ($user_order as $k=>$v){
            foreach ($user_order as $key=>$vel){
                if($v['status_o'] =='yes'){
                    if($vel['user_id'] == $v['user_id'] && $vel['status_o'] != 'yes'){
                        unset($user_order[$key]);
                    }
                }
            }
        }
        //查询项目数据
        //$user_product_param_str = self::comParamsSelf2(['online'=>'online'],['=']);
        $user_product = Yii::app()->db->createCommand()
            ->select('u.id,u.user_id,online,IFNULL(COUNT(product_id),0) as total_product')
            ->from('r_user_view u')
            ->leftjoin('r_product p','u.user_id=p.user_id')
            //->where($user_product_param_str['con'], $user_product_param_str['par'])
            ->group('u.user_id,online')
            ->order('u.addtime DESC')
            ->queryAll();
        foreach ($user_product as $k=>$v){
            foreach ($user_product as $key=>$vel){
                if($v['online'] =='online'){
                    if($vel['user_id'] == $v['user_id'] && $vel['online'] != 'online'){
                        unset($user_product[$key]);
                    }
                }
            }
        }
        foreach ($user_product as $k=>$v){
            if($v['online'] != 'online'){
                $user_product[$k]['online'] = 'notonline';
                $user_product[$k]['total_product'] = 0;
            }
        }
        foreach ($user_order as $k=>$v){
            foreach ($user_product as $key=>$vel){
                if($v['user_id'] == $vel['user_id']){
                    $user_order[$k]['total_product'] =$vel['total_product'];
                }
            }
        }
        //模拟分页从数组中获取数据
        $user_order = array_slice($user_order,$page_offset,$page_limit);

        if ($user_order) {
            return array('code' => '0', 'msg' => '添加成功','data'=>$user_order,'c_count'=>$c_count['c_count']);
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }



    }

}
