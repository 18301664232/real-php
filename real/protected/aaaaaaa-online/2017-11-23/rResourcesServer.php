<?php

/**
 * 素材管理类
 * 
 */
class ResourcesServer extends BaseServer {

    //添加素材
    public static function add($params) {
        $model = new Resources();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //查询源素材
    public static function selectOrigine($params = array(), $page = 1, $pagesize = 20) {
        $param = self::comParams2($params);
        $model = new Resources();
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

    //添加预览素材
    public static function addPreview($params) {
        $model = new ResourcesPreview();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //查询素材
    public static function select($params = array(), $page = 1, $pagesize = 20) {
        $param = self::comParams2($params);
        $model = new ResourcesPreview();
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

    //查询素材like json
    public static function selectjson($params = array(), $page = 1, $pagesize = 20) {
        if (!empty($pagesize)) {
            $offset = ($page - 1) * $pagesize;
        }
       // $key = $params['key'];
       // $sql = "SELECT * FROM `r_resources_preview` WHERE `product_id` ='$params[product_id]' AND `type` = '$key'  ORDER BY `addtime`,`id` DESC  LIMIT $offset,$pagesize";
        if(!empty($params['key'])){
            $key = $params['key'];
            $sql = "SELECT * FROM `r_resources_preview` WHERE `product_id` ='$params[product_id]' and `datas` like '%$key%' ORDER BY `addtime`,`id` DESC  LIMIT $offset,$pagesize";
            //   echo $sql;exit;
            $rs = ResourcesPreview::model()->dbConnection->createCommand($sql)->queryAll();
        }else{
            $param = self::comParams2($params);
            $model = new ResourcesPreview();
            $criteria = new CDbCriteria;
            $criteria->select = '*';
            $criteria->condition = $param['con'];
            $criteria->params = $param['par'];
            $criteria->order = "addtime DESC";
            $criteria->limit = "$pagesize";
            $criteria->offset = "$offset";
            $rs = $model->findAll($criteria);
        }

        if (!empty($rs)) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    public static function update($condition, $params) {
        $param = self::comParams($condition);
        $rs = ResourcesPreview::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //删除
    public static function del($params) {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;

        $rs = ResourcesPreview::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'message' => '删除成功');
        } else {
            return array('code' => '100001', 'message' => '删除失败');
        }
    }

    //保存json
    public static function savejson($params) {
        $model = new ResourcesJson();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }


    //@syl查询需要审核项目列表
    public static function getDisVerify($params=[], $search_key,$page_limit,$page_offset) {
        $param = self::comParams($params);
        if($param){
            $str=$param;
        }else{
            $str='t.addtime < 200000000000';
        }
        if($search_key==''){
            $search_key = '_';
        }
        $rs = Yii::app()->db->createCommand()
            ->select('p.status,p.title,t.product_id,u.tel,t.id,t.is_has_video,t.verify_status,t.verify_reason,p.user_id,p.description,p.cover,p.path')
            ->from('r_product_verify t')
            ->join('r_product p', 't.product_id=p.product_id')
            ->join('r_person_user u', 'p.user_id=u.user_id')
            ->andWhere(['like','CONCAT(p.title,t.product_id,u.user_id)','%'.$search_key.'%'])
            ->andWhere($str)
            ->order('t.addtime DESC')
            ->limit($page_limit)
            ->offset($page_offset)
            ->queryAll();
        $c_rs = Yii::app()->db->createCommand()
            ->select('p.status,p.title,t.product_id,u.tel,t.id,t.is_has_video,t.verify_status,t.verify_reason,p.user_id,p.description,p.cover,p.path')
            ->from('r_product_verify t')
            ->join('r_product p', 't.product_id=p.product_id')
            ->join('r_person_user u', 'p.user_id=u.user_id')
            ->andWhere(['like','CONCAT(p.title,t.product_id,u.user_id)','%'.$search_key.'%'])
            ->andWhere($str)
            ->queryAll();

        if ($rs) {
            return array('code' => '0', 'data' => $rs,'c_data'=>$c_rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //查询素材
    public static function getjson($params = array(), $page = 1, $pagesize = 20) {
        $param = self::comParams2($params);
        $model = new ResourcesJson();
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

    public static function updateJson($condition, $params) {
        $param = self::comParams($condition);
        $rs = ResourcesJson::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }


    /////////////////////////////////////////@syl2017年9月6日
    //获取视频路径表数据
    public static function getResourcesVideo($params = array())
    {

        $param = self::comParams2($params);
        $model = new ResourcesVideo();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        //$criteria->order = 'grade DESC';

        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }


    //删除视频路径表表数据
    public static function delResourcesVideo($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = ResourcesVideo::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加视频路径表表数据
    public static function addResourcesVideo($params)
    {
        $model = new ResourcesVideo();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

//修改视频路径表表数据
    public static function updateResourcesVideo($params, $condition)
    {

        $param = self::comParams($condition);
        $rs = ResourcesVideo::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

}
