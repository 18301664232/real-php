<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-09-07 06:22:25
 */
class SendNubServer extends BaseServer
{


    //获取短信发送阀值表数据
    public static function getSendNub($params = array())
    {

        $param = self::comParams2($params);
        $model = new SendNub();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = 'addtime DESC';

        $rs = $model->find($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }

    //删除短信发送阀值表表数据
    public static function delSendNub($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = SendNub::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加短信发送阀值表表数据
    public static function addSendNub($params)
    {
        $model = new SendNub();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

//修改短信发送阀值表表数据
    public static function updateSendNub($condition,$params)
    {

        $param = self::comParams($condition);
        $rs = SendNub::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

}