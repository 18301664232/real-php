<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: _TIME_
 */
class _SELFSERVERNAME_Server extends _SERVEREXTENDS_
{


    //获取_HAHA_数据
    public static function get_MODELNAME_($params = array())
    {

        $param = self::comParams2($params);
        $model = new _MODELNAME_();
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

    //删除_HAHA_表数据
    public static function del_MODELNAME_($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = _MODELNAME_::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加_HAHA_表数据
    public static function add_MODELNAME_($params)
    {
        $model = new _MODELNAME_();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

//修改_HAHA_表数据
    public static function update_MODELNAME_($condition,$params)
    {

        $param = self::comParams($condition);
        $rs = _MODELNAME_::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

}