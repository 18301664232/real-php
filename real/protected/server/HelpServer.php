<?php

/**
 * 帮助中心逻辑类
 * 
 */
class HelpServer extends BaseServer {

    //查询
    public static function select($params = array()) {

        $param = self::comParams2($params);
        $model = new Help();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = "grade DESC";
        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => 'ok', 'data' => $rs);
        } else {
            return array('code' => '100002', 'msg' => 'error');
        }
    }

    //模糊查询
    public static function selectlike($params = array()) {
        $sql = 'select *  from r_help';
        $sql .= " where  title like '%$params[keyword]%' and type =$params[type]";
        if($params['pid'] !='')
            $sql .= " and pid = $params[pid]";
        $sql .= " order by grade desc";
        $rs = Help::model()->dbConnection->createCommand($sql)->queryAll();
        return $rs;
    }

    //修改用户信息
    public static function update($condition, $params) {
        $param = self::comParams($condition);
        $rs = Help::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //添加资源
    public static function add($params) {
        $model = new Help();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //删除资源
    public static function del($params) {
        $param = self::comParams($params);
        $model = new Help();
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = $model->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

}
