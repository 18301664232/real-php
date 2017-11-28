<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-27 08:42:26
 */
class AdminServer extends BaseServer
{


    //获取后台管理员表数据
    public static function getAdmin($params = array())
    {

        $param = self::comParams2($params);
        $model = new Admin();
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
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

//修改后台管理员表表数据
    public static function updateAdmin($condition,$params)
    {

        $param = self::comParams($condition);
        $rs = Admin::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

}