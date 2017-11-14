<?php

/**
 * 统计类
 * 
 */
class StatisticsServer extends BaseServer {

    //添加
    public static function addStat($params) {
        $model = new Statistics();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //添加页面事件
    public static function addPage($params) {
        $model = new StatisticsPage();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改页面时间
    public static function UpdatePageTime($params, $time) {
        if (!is_array($params)) {
            return array('code' => '100002', 'msg' => '参数错误');
        }
        $param = self::comParams2($params);
        $model = new StatisticsPage();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $criteria->condition = $param['con'];
        $criteria->params = $param['par'];
        $criteria->order = "id DESC";
        $rs = $model->find($criteria);
        if ($rs) {
            $param = self::comParams(array('id' => $rs['id']));
            $rs = StatisticsPage::model()->updateAll(array('page_time' => $time), $param);
            if ($rs) {
                return array('code' => '0', 'msg' => '修改成功');
            } else {
                return array('code' => '100001', 'msg' => '修改失败');
            }
        } else {
            return array('code' => '100002', 'msg' => 'on');
        }
    }

    //添加按钮事件
    public static function addButton($params) {
        $model = new StatisticsButton();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //添加用户数据
    public static function addUserData($params) {
        $model = new StatisticsData();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '000000', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //获取渠道数量
    public static function getListCount($params = array()) {
        $sql = "SELECT  count(*) as total FROM `r_statistics` where `source_id`='$params[source_id]' and `addtime`>= $params[starttime] and `addtime`<$params[endtime]";
        $count = Statistics::model()->dbConnection->createCommand($sql)->queryAll();

        return $count[0]['total'];
    }

    //获取用户总流量
    public static function getUserWater($params = array()) {
        $sql = "SELECT  sum(`p_size`) as total FROM `r_statistics` where `user_id`='$params[user_id]'";
        $count = Statistics::model()->dbConnection->createCommand($sql)->queryAll();

        return $count[0]['total'];
    }

    //统计访问数据
    public static function CountDitchList($params) {
        $sql = "SELECT *, count(t2.`status`) as total FROM `r_product_link` t1 LEFT JOIN `r_statistics` t2 on t1.uid = t2.source_id "
                . "WHERE t1.`product_id` = '$params[product_id]' and t1.`status` != 'notonline'";
        if (!empty($params['starttime'])) {
            $sql .= " and t2.`addtime`>$params[starttime]";
        }
        if (!empty($params['endtime'])) {
            $sql .= " and t2.`addtime`<$params[endtime]";
        }
        $sql .=" group by t1.uid ,t2.`status` order by t1.id";
        $data = Statistics::model()->dbConnection->createCommand($sql)->queryAll();

        $rs_data = '';
        foreach ($data as $k => $v) {
            $rs_data[$v['uid']]['name'] = $v['name'];
            $rs_data[$v['uid']][$v['status']] = $v['total'];
        }
        //获取IP
        $sql = "select *,count(*)as total from (SELECT *,COUNT(`ip`)as`total` FROM `r_statistics` WHERE `product_id`='$params[product_id]'";
        if (!empty($params['starttime'])) {
            $sql .= " and `addtime`>$params[starttime]";
        }
        if (!empty($params['endtime'])) {
            $sql .= " and `addtime`<$params[endtime]";
        }
        $sql .=" group by `source_id`,`ip`) t3 group by `source_id` ";
        $ip_data = Statistics::model()->dbConnection->createCommand($sql)->queryAll();

        //计算全部渠道（并初始化）
        $rs[0] = array('name' => '全部渠道', 'pv' => 0, 'uv' => 0, 'nv' => 0, 'ip' => 0);
        if (empty($rs_data))
            return $rs;
        foreach ($rs_data as $k => $v) {
            foreach ($ip_data as $kk => $vv) {
                if ($k == $vv['source_id']) {
                    $rs_data[$k]['ip'] = $vv['total'];
                }
            }
        }

        foreach ($rs_data as $k => $v) {
            if (!isset($v['pv']))
                $rs_data[$k]['pv'] = 0;
            if (!isset($v['uv']))
                $rs_data[$k]['uv'] = 0;
            if (!isset($v['nv']))
                $rs_data[$k]['nv'] = 0;
            if (!isset($v['ip']))
                $rs_data[$k]['ip'] = 0;
        }

        foreach ($rs_data as $k => $v) {
            //每个渠道
            $rs[$k]['pv'] = $v['pv'] + $v['uv'] + $v['nv'];
            $rs[$k]['uv'] = $v['uv'] + $v['nv'];
            $rs[$k]['name'] = $v['name'];
            $rs[$k]['nv'] = $v['nv'];
            $rs[$k]['ip'] = $v['ip'];
        }

        foreach ($rs as $k => $v) {
            //全部渠道
            $rs[0]['uv'] = $rs[0]['uv'] + $v['uv'];
            $rs[0]['pv'] = $rs[0]['pv'] + $v['pv'];
            $rs[0]['nv'] = $rs[0]['nv'] + $v['nv'];
            $rs[0]['ip'] = $rs[0]['ip'] + $v['ip'];
        }
        return $rs;
    }

    //统计页面数据
    public static function CountPageList($params) {
        $sql = "SELECT t1.`product_id`,t1.`page_name` ,t1.`browse_status`,t2.`name`,t1.`status`, count(*)as total ,AVG(`page_time`)as avg FROM `r_statistics_page` t1 left JOIN `r_product_link` t2 on t1.source_id = t2.uid WHERE t1.`product_id` ='$params[product_id]' and t1.`status` != 'notonline' ";
        if (!empty($params['source_id'])) {
            $sql .= " and t2.`name`= '$params[source_id]'";
        }
        if (!empty($params['starttime'])) {
            $sql .= " and t1.`addtime`>$params[starttime]";
        }
        if (!empty($params['endtime'])) {
            $sql .= " and t1.`addtime`<$params[endtime] ";
        }
        $sql .= "group by t1.`page_name`,`browse_status` ORDER by page_name ASC ";
        // echo $sql;exit;
        $data = Statistics::model()->dbConnection->createCommand($sql)->queryAll();
        //重写数据结构
        $new_data = array();
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $kk = $k - 1;
                if ($kk >= 0 && $v['page_name'] == $data[$kk]['page_name']) {
                    if ($v['browse_status'] == 'uv') {
                        isset($new_data[$kk]['pv']) ? $new_data[$kk]['pv'] += $v['total'] : $new_data[$kk]['pv'] = $v['total'];
                        $new_data[$kk][$v['browse_status']] = $v['total'];
                    } else {
                        $new_data[$kk][$v['browse_status']] += $v['total'];
                    }
                } else {
                    $new_data[$k]['page_name'] = $v['page_name'];
                    $new_data[$k]['name'] = $v['name'];
                    $new_data[$k]['avg'] = $v['avg'];

                    if ($v['browse_status'] == 'uv') {
                        isset($new_data[$k]['pv']) ? $new_data[$k]['pv'] += $v['total'] : $new_data[$k]['pv'] = $v['total'];
                        $new_data[$k][$v['browse_status']] = $v['total'];
                    } else {
                        $new_data[$k][$v['browse_status']] = $v['total'];
                    }
                }
            }
            foreach ($new_data as $k => $v) {
                if (!isset($v['pv']))
                    $new_data[$k]['pv'] = 0;
                if (!isset($v['uv']))
                    $new_data[$k]['uv'] = 0;
            }
        }

        return $new_data;
    }

    //统计按钮数据
    public static function CountButtonList($params) {
        $sql = "SELECT t1.`product_id` ,t1.page,t1.`button_name`, t2.name,t1.`status`, COUNT(*)as total FROM `r_statistics_button` t1 LEFT join r_product_link t2 on t1.`source_id` = t2.uid WHERE t1.`product_id` = '$params[product_id]' and t1.`status` != 'notonline'";
        if (!empty($params['source_id'])) {
            $sql .= " and t2.`name`= '$params[source_id]'";
        }
        if (!empty($params['starttime'])) {
            $sql .= " and t1.`addtime`>$params[starttime]";
        }
        if (!empty($params['endtime'])) {
            $sql .= " and t1.`addtime`<$params[endtime] ";
        }
        $sql .= " group by `button_name` ORDER by page asc ";
        $data = Statistics::model()->dbConnection->createCommand($sql)->queryAll();
        return $data;
    }

    //统计用户提交数据
    public static function CountUserdataList($params) {
        $sql = "SELECT t1.`product_id`,t1.`button_name` , t2.name,t1.`status`,t1.addtime,t1.data,t1.page,t1.button_id, COUNT(*)as total FROM `r_statistics_data` t1 LEFT join r_product_link t2 on t1.`source_id` = t2.uid WHERE t1.`product_id` = '$params[product_id]' and t1.`status` != 'notonline' ";
        if (!empty($params['source_id'])) {
            $sql .= " and t2.`name`= '$params[source_id]'";
        }
        if (!empty($params['starttime'])) {
            $sql .= " and t1.`addtime`>$params[starttime]";
        }
        if (!empty($params['endtime'])) {
            $sql .= " and t1.`addtime`<$params[endtime] ";
        }
        $sql .= " ORDER by page asc";

        $data = Statistics::model()->dbConnection->createCommand($sql)->queryAll();
        if ($data[0]['total'] == 0)
            return array();
        return $data;
    }

    //统计用户提交数据(导出)
    public static function CountUserdataListExcel($params) {
        $sql = "SELECT t1.`product_id`,t1.`button_name` , t2.name,t1.`status`,t1.addtime,t1.data,t1.page,t1.button_id FROM `r_statistics_data` t1 LEFT join r_product_link t2 on t1.`source_id` = t2.uid WHERE t1.`product_id` = '$params[product_id]' and t1.`status` != 'notonline' ";
        if (!empty($params['source_id'])) {
            $sql .= " and t2.`name`= '$params[source_id]'";
        }
        if (!empty($params['starttime'])) {
            $sql .= " and t1.`addtime`>$params[starttime]";
        }
        if (!empty($params['endtime'])) {
            $sql .= " and t1.`addtime`<$params[endtime] ";
        }
        $sql .= " ORDER by t1.id asc";
        $data = Statistics::model()->dbConnection->createCommand($sql)->queryAll();
        return $data;
    }

    //流量详情
    public static function Detail($params = array()) {
        $sql = "SELECT addtime,pay,ROUND(sum(p_size)/1024/1024,3) as total,FROM_UNIXTIME(FLOOR(addtime/$params[type]/60)*60*$params[type]) as t2 FROM `r_statistics` WHERE `product_id`='$params[product_id]' and addtime> $params[starttime] and addtime<$params[endtime] GROUP BY  FROM_UNIXTIME(FLOOR(addtime/$params[type]/60)*60*$params[type]) ,pay order by addtime asc";
        $rs = Statistics::model()->dbConnection->createCommand($sql)->queryAll();
        //按开始和结束时间5分钟分组
        $time = $y_pay = $n_pay = array();
        $i = $params['starttime'];
        while ($i <= $params['endtime']) {
            $time[] = date('Ymd H:i', $i);
            $i += $params['type'] * 60;
        }
        foreach ($time as $k => $v) {
            $y_pay[$k] = $n_pay[$k] = 0;
            $i = $k + 1;
            foreach ($rs as $kk => $vv) {
                if ($i < count($time)) {
                    if ($vv['addtime'] >= strtotime($time[$k]) && $vv['addtime'] < strtotime($time[$i])) {
                        if ($vv['pay'] == 'yes') {
                            $y_pay[$k] += $vv['total'];
                        } else
                            $n_pay[$k] += $vv['total'];
                    }
                }
            }
        }

        return array('time' => $time, 'y_pay' => $y_pay, 'n_pay' => $n_pay);
    }
    
    public static function  selectall($params){
         $sql = "select sum(`p_size`)as total from r_statistics where `user_id`='$params[user_id]' and `pay`='yes'"; 
         $rs = Statistics::model()->dbConnection->createCommand($sql)->queryAll();
         return $rs;
    }
}
