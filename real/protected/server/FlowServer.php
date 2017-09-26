<?php

/**
 * 用户流量包类
 * 
 */
class FlowServer extends BaseServer {

    //使用流量
    public static function useWater($params = array()) {
        $list = self::getUserlist(array('user_id' => $params['user_id'], 'status' => 'use', 'pay' => $params['pay']));
        if (empty($list))
            return array('code' => '100001', 'msg' => '流量用完');
        foreach ($list as $k => $v) {
            //验证流量包有没有过期
            if ($v['addtime'] + $v['timespan'] * 3600 * 24 - time() < 0) {
                //过期修改流量包状态
                self::updateFlow(array('id' => $v['id']), array('status' => 'after'));
            } else {
                //没有过期开始使用
                if ($v['use_water'] - $v['water'] > 0) {
                    //流量用完
                    self::updateFlow(array('id' => $v['id']), array('status' => 'over'));
                } else {
                    $sql = "UPDATE `r_flow` SET `use_water` = `use_water` + $params[p_size] WHERE id =$v[id]";
                    Flow::model()->dbConnection->createCommand($sql)->execute();
                    return array('code' => '0', 'msg' => 'ok');
                }
            }
        }
        return array('code' => '100002', 'msg' => '流量用完');
    }

    //添加
    public static function addFlow($params) {
        $model = new Flow();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改状态
    public static function updateFlow($condition, $params) {
        $param = self::comParams($condition);
        $rs = Flow::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //获取流量包列表
    public static function getUserlist($params = array()) {


        $sql = "SELECT t1.`id`,t1.`user_id`,t1.`type_id`,t1.`status`,t1.`use_water`,t1.`addtime`,t2.`name`,t2.`timespan`,t2.`water`,t2.`pay` FROM `r_flow` t1 "
                . "left join `r_flow_type` t2 on t1.`type_id` = t2.`id`";
        //@syl
        if(isset($params['user_id'])){
            $sql.="WHERE `user_id` = '$params[user_id]' ";
        }

        if (!empty($params['starttime'])) {
            $sql .= " and t1.`addtime`>$params[starttime]";
        }
        if (!empty($params['endtime'])) {
            $sql .= " and t1.`addtime`<$params[endtime]";
        }
        if (!empty($params['status'])) {
            $sql .= " and t1.`status`='$params[status]'";
        }
        if (!empty($params['pay'])) {
            $sql .= " and t2.`pay`='$params[pay]'";
        }

            $data = Flow::model()->dbConnection->createCommand($sql)->queryAll();


        return $data;
    }

    //获取剩余流量
    public static function getUserresidue($params = array()) {
        $list = self::getUserlist(array('user_id' => $params['user_id'], 'status' => 'use', 'pay' => $params['pay']));

        $residue = 0; //剩余流量
        $use = 0; //使用流量
        $total = 0;
        if (empty($list))
            return $residue;
        //获取可使用流量总流量
        foreach ($list as $k => $v) {
            $total += $v['water'];
            $use += $v['use_water'];
        }
        $residue = $total - $use;
        if ($residue < 0)
            return 0; //小于0则返回0
        return $residue;
    }

    //获取预警值
    public static function getNub($params = array(),$branch = 1) {
        $param = self::comParams2($params);
        $model = new FlowNub();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        if($branch == 2){
            $rs = $model->findAll($criteria);
        }else{
            $rs = $model->find($criteria);
        }
        return array('code' => '0', 'data' => $rs);
    }

    //添加预警值
    public static function addNub($params) {
        $model = new FlowNub();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改预警值
    public static function updateNub($condition, $params) {
        $param = self::comParams($condition);
        $rs = FlowNub::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //获取付费流量包列表
    public static function getType($params = array()) {
        $param = self::comParams2($params);
        $model = new FlowType();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //添加中间表
    public static function addTypeOrder($params) {
        $model = new TypeOrder();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //添加订单
    public static function addOrder($params) {
        $model = new OrderInfo();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改订单
    public static function updateOrder($condition, $params) {
        $param = self::comParams($condition);
        $rs = OrderInfo::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //获取历史订单列表
    public static function getOrder($params = array()) {
        $param = self::comParams2($params);
        $model = new OrderInfo();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = "addtime DESC";
        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //获取中间表
    public static function getOrderTypeOrderList($params = array()) {
        $param = self::comParams2($params);
        $model = new TypeOrder();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //获取中间表数据
    public static function getTypeOrder($params = array()) {
        $sql = "SELECT * FROM `r_type_order` t1 left join r_flow_type t2 on t1.`flow_type_id`= t2.`id` where t2.timespan is not null and t1.order_no_id = '$params[order_no_id]' ";

        $rs = TypeOrder::model()->dbConnection->createCommand($sql)->queryAll();
        return $rs;
    }

    //删除已经超时的订单
    public static function delTypeOrder($params = array()) {
        $sql = "DELETE `r_order_info`,`r_type_order` from `r_order_info` LEFT JOIN `r_type_order` ON `r_order_info`.`order_no`=`r_type_order`.`order_no_id` "
                . "WHERE `r_order_info`.`user_id`='$params[user_id]' and `r_order_info`.`addtime`<=$params[addtime] and `r_order_info`.`status`='no' ";

        $rs = TypeOrder::model()->dbConnection->createCommand($sql)->execute();
        return $rs;
    }


    //@syl2017年8月23日//获取流量类型表数据
    public static function getFlowType($params = array()){

        $param = self::comParams2($params);
        $model = new FlowType();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = 'grade DESC';

        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }
   
    //@syl2017年8月23日//删除流量类型表数据
    public static function delFlowType($params){
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = FlowType::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }
    //@syl2017年8月23日//增加流量类型表数据
    public static function addFlowType($params){
        $model = new FlowType();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }
    //@syl2017年8月23日//修改流量类型表数据
    public static function updateFlowType($condition,$params){

        $param = self::comParams($condition);
        $rs = FlowType::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败'.$rs);
        }
        
    }
    
    
    
}
