<?php

/**
 * 效果管理类
 * 
 */
class TransformServer extends BaseServer {

    //查询手势
    public static function trigger($params, $page = 1, $pagesize = 10) {
        $param = self::comParams2($params);
        $model = new Trigger();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = "grade DESC";

        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //添加手势
    public static function addTrigger($params) {
        $model = new Trigger();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改手势
    public static function updateTrigger($condition, $params) {
        $param = self::comParams($condition);
        $rs = Trigger::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //删除手势
    public static function delTrigger($params) {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = Trigger::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //查询效果
    public static function effect($params, $page = 1, $pagesize = 10) {
        $param = self::comParams2($params);
        $model = new Effect();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = "grade DESC";

        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //查询效果中有没有方向值
    public static function likeEffect($data) {
        //个人
        $sql = "select * from r_transform_effect where `dir` like '%$data%'";
        $result = Effect::model()->dbConnection->createCommand($sql)->queryAll();
        if ($result)
            return array('code' => '0', 'msg' => '已存在');
        return array('code' => '100001', 'msg' => '不存在');
    }

    //添加效果
    public static function addEffect($params) {
        $model = new Effect();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改效果
    public static function updateEffect($condition, $params) {
        $param = self::comParams($condition);
        $rs = Effect::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //删除效果
    public static function delEffect($params) {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = Effect::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //查询方向
    public static function dir($params, $page = 1, $pagesize = 10) {
        $param = self::comParams2($params);
        $model = new Dir();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = "grade DESC";

        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //添加方向
    public static function addDir($params) {
        $model = new Dir();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改方向
    public static function updateDir($condition, $params) {
        $param = self::comParams($condition);
        $rs = Dir::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //删除方向
    public static function delDir($params) {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = Dir::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //@syl更新时间步长
    public  static function timeUpdate($params){
        $time_json = json_encode($params);

        $transform_model = Transform::model();
        $rs = $transform_model->find('uid=:uid',array(':uid'=>'times'));
        $rs->jsobj=$time_json;
        if($rs->save()){
            return array('code' => '0', 'data' => $rs);
        }else{
            return array('code' => '100001', 'data' => '');
        }

    }


    //查询总设置
    public static function transform($params, $page = 1, $pagesize = 10) {
        $param = self::comParams2($params);
        $model = new Transform();
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

}
