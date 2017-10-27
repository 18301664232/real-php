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

}