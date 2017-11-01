<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-10-25 10:35:25
 */
class StatisticsDayServer extends BaseServer
{


    //获取小时统计表数据
    public static function getStatisticsDay($params = array())
    {

        $param = self::comParams2($params);
        $model = new StatisticsDay();
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

    //删除小时统计表表数据
    public static function delStatisticsDay($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = StatisticsDay::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加小时统计表表数据
    public static function addStatisticsDay($params)
    {
        $model = new StatisticsDay();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

//修改小时统计表表数据
    public static function updateStatisticsDay($condition,$params)
    {

        $param = self::comParams($condition);
        $rs = StatisticsDay::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

 //后台获取时间维度统计数据
    public static  function GetAdminList($time_type,$start_time,$end_time){


        if($time_type == 'now'|| $time_type =='prev'){

            $rs = Yii::app()->db->createCommand()
                ->select('total_order,total_money,uv,pv,register,issuance_user,ROUND(total_flow/1024/1024/1024,2) AS total_flow, free_product, pay_product, issuance_product,FROM_UNIXTIME(search_addtime,"%H:%i:%s") AS group_time')
                ->from('r_statistics_day')
                ->where("search_addtime >= $start_time and search_addtime < $end_time")
                ->order('search_addtime')
                ->queryAll();

        }else if($time_type == 'prev_seven'|| $time_type =='prev_thirty'){

            $rs = Yii::app()->db->createCommand()
                ->select('SUM(total_order) AS total_order, SUM(total_money) AS total_money, SUM(uv) AS uv,SUM(pv) AS pv,SUM(register) AS register,SUM(issuance_user) AS issuance_user,ROUND(SUM(total_flow)/1024/1024/1024,2) AS total_flow,SUM(free_product) AS free_product,SUM(pay_product) AS pay_product,SUM(issuance_product) AS issuance_product,FROM_UNIXTIME(search_addtime,"%Y-%m-%d") AS group_time')
                ->from('r_statistics_day')
                ->where("search_addtime >= $start_time and search_addtime < $end_time")
                ->group('group_time')
                ->order('search_addtime')
                ->queryAll();

        }else if($time_type == 'myself'){

            $rs = Yii::app()->db->createCommand()
                ->select('SUM(total_order) AS total_order, SUM(total_money) AS total_money, SUM(uv) AS uv,SUM(pv) AS pv,SUM(register) AS register,SUM(issuance_user) AS issuance_user,ROUND(SUM(total_flow)/1024/1024/1024,2) AS total_flow,SUM(free_product) AS free_product,SUM(pay_product) AS pay_product,SUM(issuance_product) AS issuance_product,FROM_UNIXTIME(search_addtime,"%Y-%m-%d") AS group_time')
                ->from('r_statistics_day')
                ->where("search_addtime >= $start_time and search_addtime <= $end_time")
                ->group('group_time')
                ->order('search_addtime')
                ->queryAll();

        }

        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100444', 'data' => []);
        }

    }

}