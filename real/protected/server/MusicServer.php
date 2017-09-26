<?php

/**
 * 音乐管理类
 * 
 */
class MusicServer extends BaseServer {



    //添加个人音效
    public static function add($params) {
        $model = new PersonMusic();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //删除个人音效
    public static function del($params) {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;

        $rs = PersonMusic::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'message' => '删除成功');
        } else {
            return array('code' => '100001', 'message' => '删除失败');
        }
    }


    //查询音乐图标位置
    public static function location($params, $page = 1, $pagesize = 10) {
        $param = self::comParams2($params);
        $model = new LocationMusic();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = "grade DESC";
        if (!empty($pagesize)) {
            $offset = ($page - 1) * $pagesize;
            $criteria->limit = $pagesize;   //取1条数据，如果小于0，则不作处理
            $criteria->offset = $offset;   //两条合并起来，则表示 limit 10
        }
        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //查询个人音效
    public static function person($params, $page = 1, $pagesize = 10) {
        $param = self::comParams2($params);
        $model = new PersonMusic();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = "addtime DESC";
        if (!empty($pagesize)) {
            $offset = ($page - 1) * $pagesize;
            $criteria->limit = $pagesize;   //取1条数据，如果小于0，则不作处理
            $criteria->offset = $offset;   //两条合并起来，则表示 limit 10
        }
        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //查询系统音效
    public static function system($params, $page = 1, $pagesize = 10) {
        $param = self::comParams2($params);
        $model = new SystemMusic();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = "addtime DESC";
        if (!empty($pagesize)) {
            $offset = ($page - 1) * $pagesize;
            $criteria->limit = $pagesize;   //取1条数据，如果小于0，则不作处理
            $criteria->offset = $offset;   //两条合并起来，则表示 limit 10
        }
        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //添加系统音效
    public static function addSystem($params) {
        $model = new SystemMusic();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //更新系统音效
    public static function uppSystem($params){

        $rs = SystemMusic::model()->find('id=:id',array(':id'=>$params['id']));
        $rs->name=$params['name'];
        if ($rs->save()) {
            return array('code' => '0', 'msg' => '更新成功');
        } else {
            return array('code' => '100001', 'msg' => '更新失败');
        }
    }

    //删除系统音效
    public static function delSystem($params) {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = SystemMusic::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //添加音乐图标位置
    public static function addLocation($params) {
        $model = new LocationMusic();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改音乐图标位置
    public static function updateLocation($condition, $params) {
        $param = self::comParams($condition);
        $rs = LocationMusic::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //删除手势//？？？删除音乐图标
    public static function delLocation($params) {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = LocationMusic::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

}
