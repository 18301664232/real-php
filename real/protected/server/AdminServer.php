<?php

/**
 * 管理员公共逻辑类
 * 
 */
class AdminServer extends BaseServer {

    //用户登录
    public static function doLogin($params = array()) {
        if (!is_array($params)) {
            return array('code' => '100002', 'msg' => '参数错误');
        }
        $param = self::comParams2($params);
        $model = new Admin();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $rs = $model->find($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '正在登录', 'data' => $rs);
        } else {
            return array('code' => '100002', 'msg' => '用户或密码错误');
        }
    }

    //修改用户信息
    public static function updateAdmin($condition, $params) {
        $param = self::comParams($condition);
        $rs = Admin::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

}
