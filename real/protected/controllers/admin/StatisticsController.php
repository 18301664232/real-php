<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017/10/25
 * Time: 17:31
 */
class StatisticsController extends CenterController

{

    //定时查询数据
    public function actionSearch(){

            $start_time = strtotime(date('Y-m-d H:0:0', time()-3600));
            $today_start_time = $start_time;
            $search_end_time = $start_time+ 3600;
            $params['addtime'] = time();
            //删除视图
            $view_sql = "DROP VIEW IF EXISTS `r_statistics_view`";
            $view_rs = Yii::app()->db->createCommand($view_sql)->execute();

            //建立访问表statistics表视图
            $view_sql = "CREATE VIEW `r_statistics_view` AS SELECT * FROM `r_statistics` WHERE `source_name` != '测试地址' AND `addtime` > $today_start_time AND `addtime` < $search_end_time";
            $view_rs = Yii::app()->db->createCommand($view_sql)->execute();
            $view_name = 'r_statistics_view';

            //uv,pv,总流量
            $sql = "SELECT `id`,`status`,COUNT(`status`) as `lookin`,SUM(`p_size`) as `total_flow` FROM `$view_name` WHERE `source_name` != '测试地址' GROUP BY `status`";
            $rs = Yii::app()->db->createCommand($sql)->queryAll();
            $params['uv'] = 0;
            $params['total_flow'] = 0;
            $params['nv'] = 0;
            $params['pv'] = 0;
            if ($rs) {
                foreach ($rs as $k => $v) {
                    $params['total_flow'] = $params['total_flow'] + $v['total_flow'];
                    if ($v['status'] == 'nv' || $v['status'] == 'uv') {
                        $params['uv'] = $params['uv'] + $v['lookin'];
                    }
                    if ($v['status'] == 'nv') {
                        $params['nv'] = $params['nv']+$v['lookin'];
                    }
                    if ($v['status'] == 'pv') {
                        $params['pv'] = $params['pv']+$v['lookin'];
                    }
                }
            }


            //注册用户数量
            $sql = "SELECT `id`,COUNT(*) AS `register` FROM `r_person_user` WHERE `addtime` >=$today_start_time AND `addtime` < $search_end_time";
            $rs = Yii::app()->db->createCommand($sql)->queryRow();
            if ($rs) {
                $params['register'] = $rs['register'];
            } else {
                $params['register'] = 0;

            }

            //发布并有访问的用户数量
            $sql = "SELECT s.id FROM `r_product_verify` `v` JOIN `$view_name` `s` ON v.product_id=s.product_id WHERE s.source_name != '测试地址' GROUP BY s.user_id";
            $rs = Yii::app()->db->createCommand($sql)->queryAll();
            $params['issuance_user'] = 0;
            if ($rs) {
                foreach ($rs as $k => $v) {
                    $params['issuance_user']++;
                }
            }


            //免费/付费发布项目数量
            $sql = "SELECT p.id,p.pay FROM `r_product_verify` `v` JOIN `$view_name` `s` ON v.product_id=s.product_id JOIN `r_product` `p` ON s.product_id=p.product_id WHERE s.source_name != '测试地址' GROUP BY s.product_id";
            $rs = Yii::app()->db->createCommand($sql)->queryAll();
            $params['free_product'] = 0;
            $params['pay_product'] = 0;
            $params['issuance_product'] = 0;
            if ($rs) {
                foreach ($rs as $k => $v) {
                    $params['issuance_product']++;
                    if ($v['pay'] == 'yes') {
                        $params['pay_product']++;
                    }
                    if ($v['pay'] == 'no') {
                        $params['free_product']++;
                    }
                }
            }

            //订单数量和总额
            $sql = "SELECT COUNT(*) AS `total_order`,IFNULL(SUM(money),0) AS `total_money` FROM `r_order_info` WHERE addtime >= $today_start_time AND status = 'yes' AND `addtime` < $search_end_time";
            $rs = Yii::app()->db->createCommand($sql)->queryRow();

            if (!$rs) {
                $params['total_order'] = 0;
                $params['total_money'] = 0;
            } else {
                $params['total_order'] = $rs['total_order'];
                $params['total_money'] = $rs['total_money'];
            }

            $params['search_addtime'] = $start_time;


            //存储到表中
            $rs = StatisticsDayServer::addStatisticsDay($params);


    }


}