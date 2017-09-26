<?php

/**
 * 工单类
 * 
 */
class WorkorderServer extends BaseServer {

    //添加工单
    public static function add($params) {
        $model = new WorkOrder();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //添加工单图片
    public static function addImg($params) {
        $model = new WorkOrderImg();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //查询个人工单列表
    public static function select($params, $page = 1, $pagesize = '') {
        $model = new WorkOrder();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $str = '1=1';
        if (isset($params['_id'])) {
            $str .= " and t._id = '$params[_id]'";
        }
        if (isset($params['order_no'])) {
            $str .= " and t.order_no = '$params[order_no]'";
        }

        if (isset($params['keyword'])) {
            $str .= " and CONCAT(t.title,t.content) like '%$params[keyword]%'";
        }
        if (isset($params['start'])) {
            $str .= " and t.addtime>$params[start]";
        }
        if (isset($params['end'])) {
            $str .= " and t.addtime<$params[end]";
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

    public static function selectAdmin($params, $page = 1, $pagesize = 20) {
        $offset = ($page - 1) * $pagesize;
        $sql = "SELECT t.id,t.order_no,t._id,t.title,t.status,t.addtime,count(r_work_reply.reply_type)as total FROM `r_work_order` t "
                . "LEFT JOIN r_work_reply on t.order_no = r_work_reply.order_no and r_work_reply.reply_type != 'user'"
                . " where 1=1";
        if ($params['type'])
            $sql .= " and t.`type` = '$params[type]'";
        if ($params['status'])
            $sql .= " and t.`status` = '$params[status]'";
        $sql .= "  and CONCAT(t.title,t.order_no) like '%$params[keyword]%' GROUP by t.order_no order by t.addtime limit $offset,$pagesize";
     //   echo $sql;exit;
        $data = WorkOrder::model()->dbConnection->createCommand($sql)->queryAll();

        return $data;
    }

    public static function selectInfo($params) {
        $sql = "SELECT t1.order_no,t1.title,t1.content,t1.type,t1.status,t1.addtime,t2.link FROM `r_work_order` t1 left JOIN r_work_order_img t2 ON t1.order_no = t2.order_no where t1.order_no = '$params[order_no]' and _id='$params[_id]' ";
        $list = WorkOrder::model()->dbConnection->createCommand($sql)->queryAll();
        $data = '';
        foreach ($list as $k => $v) {
            $data['order_no'] = $v['order_no'];
            $data['title'] = $v['title'];
            $data['content'] = $v['content'];
            $data['type'] = $v['type'];
            $data['status'] = $v['status'];
            $data['addtime'] = $v['addtime'];
            $data['children'] = '';
            if (!empty($v['link'])) {
                $data['link'][] = $v['link'];
            }
        }

        //获取回复
        $sql = "select t4.id,t4.content,t4.addtime,t4.reply_type,t5.reply_no,t5.link from `r_work_reply` t4 LEFT JOIN `r_work_reply_img` t5 on t4.id = t5.reply_no where t4.`order_no` = '$params[order_no]' ORDER by t4.addtime desc";
        $list_reply = WorkOrder::model()->dbConnection->createCommand($sql)->queryAll();
        if (!empty($list_reply)) {
            $reply_data = array();
            foreach ($list_reply as $k => $v) {
                $reply_data[$v['id']]['content'] = $v['content'];
                $reply_data[$v['id']]['reply_type'] = $v['reply_type'];
                $reply_data[$v['id']]['addtime'] = $v['addtime'];
                $reply_data[$v['id']]['link'][] = $v['link'];
            }
            $data['children'] = $reply_data;
        }
        return $data;
    }

    //修改
    public static function update($condition, $params) {
        $param = self::comParams($condition);
        $rs = WorkOrder::model()->updateAll($params, $param);
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
        $rs = WorkOrder::model()->deleteAll($criteria);
        if ($rs) {
            WorkReply::model()->deleteAll($criteria);
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //添加工单回复
    public static function addReply($params) {
        $model = new WorkReply();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //添加工单回复图片
    public static function addReplyImg($params) {
        $model = new WorkReplyImg();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

}
