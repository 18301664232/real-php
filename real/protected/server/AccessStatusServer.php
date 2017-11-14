<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-06 11:17:17
 */
class AccessStatusServer extends BaseServer
{


    //获取用户访问状态表数据
    public static function getAccessStatus($params = array())
    {

        $param = self::comParams2($params);
        $model = new AccessStatus();
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

    //删除用户访问状态表表数据
    public static function delAccessStatus($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = AccessStatus::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加用户访问状态表表数据
    public static function addAccessStatus($params)
    {
        $model = new AccessStatus();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

//修改用户访问状态表表数据
    public static function updateAccessStatus($condition,$params)
    {

        $param = self::comParams($condition);
        $rs = AccessStatus::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

}