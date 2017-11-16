<?php

/**
 * 用户作品类
 * 
 */
class ProductServer extends BaseServer {

    //@syl项目审核链接详情列表查询
    public static function getProLink($params){
        $param = self::comParams($params);
        $rs = Yii::app()->db->createCommand()
            ->select('p.addtime,t.addtime as uptime,k.*')
            ->from('r_product_verify t')
            ->join('r_product_link k', 't.product_id=k.product_id')
            ->join('r_product p', 'p.product_id=k.product_id')
            ->where($param)
            ->group('t.product_id')
            ->order('t.addtime DESC')
            ->queryRow();
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }


    //获取项目审核表数据
    public static function getProductVerify($params = array(),$type=false)
    {

            $param = self::comParams2($params);


        $model = new ProductVerify();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        if($type){
            $criteria->addInCondition('product_id',[$params['product_id']]);
            $criteria->addNotInCondition('verify_reason',['已通过']);

        }else{

            $criteria->condition = $param['con'];
            $criteria->params = $param['par'];
        }

        $criteria->order = 'addtime DESC';

        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }

    //修改项目审核表表数据
    public static function updateProductVerify($condition,$params)
    {

        $param = self::comParams($condition);
        $rs = ProductVerify::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }

    //增加项目审核表表数据
    public static function addProductVerify($params)
    {
        $model = new ProductVerify();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }


    //获取数据
    public static function getList($params = array(), $page = 0, $pagesize = '') {
        $param = self::comParams2($params);
        $model = new Product();
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

    //获取数据
    public static function getListlike($params = array(), $page = 0, $pagesize = '') {
        $model = new Product();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $str = "user_id = '$params[user_id]'";
        if (isset($params['online'])) {
            if ($params['online'] == 'notonlineall') {
                $str .= " and online in( 'empty', 'notonline')";
            } else {
                $str .= " and online = '$params[online]'";
            }
        }
        if (isset($params['keyword'])) {
            $str .= " and CONCAT(title,product_id) like '%$params[keyword]%'";
        }
        $criteria->condition = $str;
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

    //获取作品数量
    public static function getCount($params = array()) {
        $param = self::comParams2($params);
        $model = new Product();
        $criteria = new CDbCriteria;
        $criteria->select = 'online,count(`online`)as total';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->group = 'online';
        $rs = $model->findAll($criteria);
        return $rs;
    }

    //添加
    public static function addProduct($params) {
        $model = new Product();
        $model->attributes = $params;
        $rs = $model->save();

        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改
    public static function updateProduct($condition, $params) {
        $param = self::comParams($condition);
        $rs = Product::model()->updateAll($params, $param);

        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //删除
    public static function delProduct($params) {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = Product::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //获取数据
    public static function getListResources($params = array(), $page = 0, $pagesize = '') {
        if (!is_array($params)) {
            return array('code' => '100002', 'msg' => '参数错误');
        }
        $param = self::comParams($params);
        $model = new Resources();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param;
        if (!empty($pagesize)) {
            $offset = ($page - 1) * $pagesize;
            $criteria->limit = $pagesize;   //取1条数据，如果小于0，则不作处理
            $criteria->offset = $offset;   //两条合并起来，则表示 limit 10
        }
        $rs = $model->findAll($criteria);
        if ($rs) {
            return array('code' => '000000', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }
    }

    //添加资源
    public static function addResources($params) {
        $model = new Resources();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '000000', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //删除资源
    public static function delResources($params) {
        $param = self::comParams($params);
        $model = new Resources();
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = $model->deleteAll($criteria);
        if ($rs) {
            return array('code' => '000000', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //查询link
    public static function selectLink($params = array(), $page = 1, $pagesize = 20) {
        $param = self::comParams2($params);
        $model = new ProductLink();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = "addtime ASC";
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

    //添加link
    public static function addLink($params) {
        $model = new ProductLink();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改link
    public static function updateLink($condition, $params) {
        $param = self::comParams($condition);
        $rs = ProductLink::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }
    }

    //删除链接
    public static function delLink($params) {
        $param = self::comParams($params);
        $model = new ProductLink();
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = $model->deleteAll($criteria);
        if ($rs) {
            return array('code' => '000000', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //查询项目视频
    public static function slectVideo($params = array()) {
        $param = self::comParams2($params);
        $model = new ProductVideo();
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

    //添加视频
    public static function addVideo($params) {
        $model = new ProductVideo();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //删除项目视频
    public static function delVideo($params) {
        $param = self::comParams($params);
        $model = new ProductVideo();
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = $model->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //后台查询
    public static function AdminList($params = array(), $page = 1, $pagesize = 20) {
        $sql = 'select *,COUNT(*)as total from (select t1.`id`,t1.`product_id`,t1.`title`,t1.user_id,t2.status,t2.p_size from (select * from r_product';
        if ($params['keyword'] != '') {
            $sql .= " where  CONCAT(`title`,`product_id`) like '%$params[keyword]%'";
        }
        $min = ($page - 1) * $pagesize;
        $max = $pagesize;
        $sql .=" LIMIT $min,$max )as t1 left join r_statistics as t2 on t1.product_id = t2.product_id)  as t3   GROUP by product_id,status ORDER by t3.id";

        $list = Statistics::model()->dbConnection->createCommand($sql)->queryAll();
        $data = '';
        if (empty($list))
            return array('code' => 0, 'data' => $data);
        foreach ($list as $k => $v) {
            $data[$v['product_id']]['product_id'] = $v['product_id'];
            $data[$v['product_id']]['title'] = $v['title'];
            $data[$v['product_id']]['user_id'] = $v['user_id'];
            if ($v['status'] == 'pv') {
                $data[$v['product_id']]['pv'] = $v['total'];
            } elseif ($v['status'] == 'uv') {
                $data[$v['product_id']]['uv'] = $v['total'];
            } elseif ($v['status'] == 'nv') {
                $data[$v['product_id']]['nv'] = $v['total'];
            }
        }
        $sql = 'select t4.product_id,sum(t5.p_size)as sizesum from (select *,COUNT(*)as total from (select t1.`id`,t1.`product_id`,t1.`title`,t1.user_id,t2.status,t2.p_size from (select * from r_product LIMIT 0,20 )as t1 left join r_statistics as t2 on t1.product_id = t2.product_id) as t3 GROUP by product_id,status ORDER by t3.id) t4  left join r_statistics as t5 on t4.product_id = t5.product_id GROUP by t4.`product_id`';
        $sizelist = Statistics::model()->dbConnection->createCommand($sql)->queryAll();
        foreach ($data as $k => $v) {
            foreach ($sizelist as $kk => $vv) {
                if ($vv['product_id'] == $v['product_id'])
                    $data[$k]['water'] = $vv['sizesum'];
            }
        }

        foreach ($data as $k => $v) {
            if (!isset($v['pv']))
                $data[$k]['pv'] = 0;
            if (!isset($v['uv']))
                $data[$k]['uv'] = 0;
            if (!isset($v['nv']))
                $data[$k]['nv'] = 0;
            if (!isset($v['water']))
                $data[$k]['water'] = 0;
        }
        return array('code' => 0, 'data' => $data);
    }

    //后台查询数量
    public static function AdminListCount($params = array()) {
        $sql = 'select count(*) as total from r_product';
        if ($params['keyword'] != '')
            $sql .= " where  CONCAT(`title`,`product_id`) like '%$params[keyword]%'";
        $count = Statistics::model()->dbConnection->createCommand($sql)->queryAll();
        return $count;
    }

}
