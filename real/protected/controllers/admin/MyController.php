<?php

/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017/9/6
 * Time: 14:38
 */
class MyController extends BaseController
{

    public function actionQunima(){

      $res= OssServer::doesObjectExist('realive','statics/35Qbnp8xV7jpg');
//       // $res=OssServer::uploadFile('realive','statics/xiaoming.png','uploads/oss_qrcode/59ae0531e02b8.jpg');
      dump($res);
//        $params['title'] = !empty($_REQUEST['title']) ? $_REQUEST['title'] : '';
//        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
//        $params['contents'] = !empty($_REQUEST['content']) ? $_REQUEST['content'] : '';
//        $params['addtime'] = time();
//        $rs = UserMailServer::addMail($params);
//        dump($rs);
//        $rs = UserMailServer::updateMail(['title'=>'修改的标题'],['id'=>7]);
//        dump($rs);

       // SELECT * FROM `r_statistics` WHERE `product_id`='gzOc0hFizW'

//        $sss = 'select SUM(total)from (select p.product_id,s.status,count(s.status) as total from  r_product p left join r_statistics s ON p.product_id = s.product_id group by p.product_id,s.status)as pp GROUP BY pp.product_id';
//
//
//        "SELECT *, count(t2.`status`) as total FROM `r_product_link` t1 LEFT JOIN `r_statistics` t2 on t1.uid = t2.source_id WHERE t1.`product_id` = '09pzVWNFYk' and t1.`status` != 'notonline' group by t1.uid ,t2.`status` order by t1.id";
//
//        'select *,count(*)as total from (SELECT *,COUNT(`ip`)as`total` FROM `r_statistics` WHERE `product_id`='09pzVWNFYk' group by `source_id`,`ip`) t3 group by `source_id`';

        echo strtotime('2017-10-20');
        echo strtotime('2017-10-20 11:57:20');



    }
    public function actionStatistics(){

        //当前天开始的时间戳
        $today_start_time = strtotime(date('Y-m-d',time()));
        dump($today_start_time);
        //uv,pv,总流量
        $sql ="SELECT `id`,`status`,COUNT(`status`) as `lookin`,SUM(`p_size`) as `total_flow` FROM `r_statistics` WHERE `source_name` != '测试地址' AND `addtime` > $today_start_time GROUP BY `status`";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        $params['uv'] = 0;
        $params['total_flow'] = 0;
        if(!$rs){
            $params['nv'] = 0;
            $params['pv'] = 0;
        }else{
            foreach ( $rs as $k=>$v){
                $params['total_flow'] =  $params['total_flow']+$v['total_flow'];
                if($v['status'] == 'nv' || $v['status'] == 'uv'){
                    $params['uv'] =  $params['uv']+$v['lookin'];
                }
                if($v['status'] =='nv'){
                    $params['nv'] = $v['lookin'];
                }
                if($v['status'] =='pv'){
                    $params['pv'] = $v['lookin'];
                }
            }
        }

        $params['one'] =time();

        //注册用户数量
        $sql = "SELECT `id`,COUNT(*) AS `register` FROM `r_person_user` WHERE `addtime` >=$today_start_time";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if(!$rs){
            $params['register'] =0;
        }else{
            $params['register'] =$rs['register'];
        }
        $params['two'] =time();

        //发布并有访问的用户数量
        $sql = "SELECT s.id FROM `r_product_verify` `v` JOIN `r_statistics` `s` ON v.product_id=s.product_id WHERE v.addtime >= $today_start_time AND s.source_name != '测试地址' GROUP BY s.user_id";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        $params['issuance_user'] = 0;
        if(!$rs){
            foreach ($rs as $k=>$v){
                $params['issuance_user']++;
            }
        }
        $params['there'] =time();
        //免费/付费发布项目数量
        $sql = "SELECT p.id,p.pay FROM `r_product_verify` `v` JOIN `r_statistics` `s` ON v.product_id=s.product_id JOIN `r_product` `p` ON s.product_id=p.product_id WHERE v.addtime >= $today_start_time AND s.source_name != '测试地址' GROUP BY s.product_id";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        $params['free_product'] =0;
        $params['pay_product'] =0;
        $params['issuance_product'] =0;
        if(!$rs){
            foreach ($rs as $k=>$v){
                $params['issuance_product']++;
                if($v['pay'] =='yes'){
                    $params['pay_product']++;
                }
                if($v['pay'] =='no'){
                    $params['free_product']++;
                }
            }
        }
        $params['four'] =time();
        //订单数量和总额
        $sql = "SELECT COUNT(*) AS `total_order`,SUM(money) AS `total_money` FROM `r_order_info` WHERE addtime >= $today_start_time AND status = 'yes'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();

        if(!$rs){
            $params['total_order'] =0;
            $params['total_money'] =0;
        }else{
            $params['total_order'] =$rs['total_order'];
            $params['total_money'] =$rs['total_money'];
        }

            $params['addtime'] =time();

        $params['five'] =time();
        dump($params);



    }
    public function actionStatistics2(){

        //当前天开始的时间戳
        $today_start_time = strtotime(date('Y-m-d',time()));
        dump($today_start_time);

        //删除视图
        $view_sql = "DROP VIEW IF EXISTS `r_statistics_view`";
        $view_rs = Yii::app()->db->createCommand($view_sql)->execute();
        if($view_rs){
            dump('ssss');
        }


        //建立访问表statistics表视图
        $view_sql = "CREATE VIEW `r_statistics_view` AS SELECT * FROM `r_statistics` WHERE `source_name` != '测试地址' AND `addtime` > $today_start_time";
        $view_rs = Yii::app()->db->createCommand($view_sql)->execute();
        if($view_rs){
            dump('ssss');
        }

        if($view_rs){
            $view_name = 'r_statistics_view';
        }else{
            $view_name = 'r_statistics';
        }
        //uv,pv,总流量
        $sql ="SELECT `id`,`status`,COUNT(`status`) as `lookin`,SUM(`p_size`) as `total_flow` FROM `$view_name` WHERE `source_name` != '测试地址' AND `addtime` > $today_start_time GROUP BY `status`";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        $params['uv'] = 0;
        $params['total_flow'] = 0;
        if(!$rs){
            $params['nv'] = 0;
            $params['pv'] = 0;
        }else{
            foreach ( $rs as $k=>$v){
                $params['total_flow'] =  $params['total_flow']+$v['total_flow'];
                if($v['status'] == 'nv' || $v['status'] == 'uv'){
                    $params['uv'] =  $params['uv']+$v['lookin'];
                }
                if($v['status'] =='nv'){
                    $params['nv'] = $v['lookin'];
                }
                if($v['status'] =='pv'){
                    $params['pv'] = $v['lookin'];
                }
            }
        }

        $params['one'] =time();

        //注册用户数量
        $sql = "SELECT `id`,COUNT(*) AS `register` FROM `r_person_user` WHERE `addtime` >=$today_start_time";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();
        if(!$rs){
            $params['register'] =0;
        }else{
            $params['register'] =$rs['register'];
        }
        $params['two'] =time();

        //发布并有访问的用户数量
        $sql = "SELECT s.id FROM `r_product_verify` `v` JOIN `$view_name` `s` ON v.product_id=s.product_id WHERE v.addtime >= $today_start_time AND s.source_name != '测试地址' GROUP BY s.user_id";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        $params['issuance_user'] = 0;
        if(!$rs){
            foreach ($rs as $k=>$v){
                $params['issuance_user']++;
            }
        }
        $params['there'] =time();
        //免费/付费发布项目数量
        $sql = "SELECT p.id,p.pay FROM `r_product_verify` `v` JOIN `$view_name` `s` ON v.product_id=s.product_id JOIN `r_product` `p` ON s.product_id=p.product_id WHERE v.addtime >= $today_start_time AND s.source_name != '测试地址' GROUP BY s.product_id";
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        $params['free_product'] =0;
        $params['pay_product'] =0;
        $params['issuance_product'] =0;
        if(!$rs){
            foreach ($rs as $k=>$v){
                $params['issuance_product']++;
                if($v['pay'] =='yes'){
                    $params['pay_product']++;
                }
                if($v['pay'] =='no'){
                    $params['free_product']++;
                }
            }
        }
        $params['four'] =time();
        //订单数量和总额
        $sql = "SELECT COUNT(*) AS `total_order`,SUM(money) AS `total_money` FROM `r_order_info` WHERE addtime >= $today_start_time AND status = 'yes'";
        $rs = Yii::app()->db->createCommand($sql)->queryRow();

        if(!$rs){
            $params['total_order'] =0;
            $params['total_money'] =0;
        }else{
            $params['total_order'] =$rs['total_order'];
            $params['total_money'] =$rs['total_money'];
        }

        $params['addtime'] =time();

        $params['five'] =time();
        dump($params);



    }
    public function actionStatistics3(){
       // $end_time = '1493568000';
        //当前天开始的时间戳
        //$today_start_time = strtotime(date('Y-m-d',time()));
        //dump($today_start_time);
        for ($today_start_time =strtotime(date('Y-m-d',time())); $today_start_time>=1474519954; $today_start_time-=(3600*24)) {

              $search_end_time = $today_start_time+ (3600*24);
             $params['date'] = date('Y-m-d',$today_start_time);

            //删除视图
            $view_sql = "DROP VIEW IF EXISTS `r_statistics_view`";
            $view_rs = Yii::app()->db->createCommand($view_sql)->execute();
            if ($view_rs) {
                dump('ssss');
            }


            //建立访问表statistics表视图
            $view_sql = "CREATE VIEW `r_statistics_view` AS SELECT * FROM `r_statistics` WHERE `source_name` != '测试地址' AND `addtime` > $today_start_time AND `addtime` < $search_end_time";
            $view_rs = Yii::app()->db->createCommand($view_sql)->execute();
            if ($view_rs) {
                dump('ssss');
            }

           // if ($view_rs) {
                $view_name = 'r_statistics_view';
          //  } else {
          //      $view_name = 'r_statistics';
         //   }

            $params['view'] =$view_name;


            //uv,pv,总流量
            $sql = "SELECT `id`,`status`,COUNT(`status`) as `lookin`,SUM(`p_size`) as `total_flow` FROM `$view_name` WHERE `source_name` != '测试地址' AND `addtime` > $today_start_time AND `addtime` < $search_end_time GROUP BY `status`";
            $rs = Yii::app()->db->createCommand($sql)->queryAll();
            $params['uv'] = 0;
            $params['total_flow'] = 0;
            if (!$rs) {
                $params['nv'] = 0;
                $params['pv'] = 0;
            } else {
                foreach ($rs as $k => $v) {
                    $params['total_flow'] = $params['total_flow'] + $v['total_flow'];
                    if ($v['status'] == 'nv' || $v['status'] == 'uv') {
                        $params['uv'] = $params['uv'] + $v['lookin'];
                    }
                    if ($v['status'] == 'nv') {
                        $params['nv'] = $v['lookin'];
                    }
                    if ($v['status'] == 'pv') {
                        $params['pv'] = $v['lookin'];
                    }
                }
            }

            $params['one'] = time();


            //注册用户数量
            $sql = "SELECT `id`,COUNT(*) AS `register` FROM `r_person_user` WHERE `addtime` >=$today_start_time AND `addtime` < $search_end_time";
            $rs = Yii::app()->db->createCommand($sql)->queryRow();
            if ($rs) {
                $params['register'] = $rs['register'];
            } else {
                $params['register'] = 0;

            }
            $params['two'] = time();

            //发布并有访问的用户数量
            $sql = "SELECT s.id FROM `r_product_verify` `v` JOIN `$view_name` `s` ON v.product_id=s.product_id WHERE v.addtime >= $today_start_time AND s.source_name != '测试地址' AND v.addtime < $search_end_time GROUP BY s.user_id";
            $rs = Yii::app()->db->createCommand($sql)->queryAll();
            $params['issuance_user'] = 0;
            if ($rs) {
                foreach ($rs as $k => $v) {
                    $params['issuance_user']++;
                }
            }
            $params['there'] = time();
            //免费/付费发布项目数量
            $sql = "SELECT p.id,p.pay FROM `r_product_verify` `v` JOIN `$view_name` `s` ON v.product_id=s.product_id JOIN `r_product` `p` ON s.product_id=p.product_id WHERE v.addtime >= $today_start_time AND s.source_name != '测试地址' AND v.addtime < $search_end_time GROUP BY s.product_id";
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
            $params['four'] = time();
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

            $params['addtime'] = time();

            $params['five'] = time();
            dump($params);

        }
        die;






    }
    public function actionStatistics4(){


        $type = !empty($_REQUEST['type'])?$_REQUEST['type']:'today';//查询类型
        $interval_count = !empty($_REQUEST['interval_count'])?$_REQUEST['interval_count']: '';//间隔天数

        if($type =='today'){
            //统计每小时的数据
            $start_time = time();
            $end_time = strtotime(date('Y-m-d',time()));
            $interval_time = 3600;
        }else{
            if(empty($interval_count)){
                $this->out('100444','间隔天数为空');
            }
            $start_time = strtotime(date('Y-m-d',time()));
            $end_time = $start_time-($interval_count * 3600 * 24);
            $interval_time = 3600 * 24;
        }

        for ($today_start_time = $start_time; $today_start_time>=$end_time; $today_start_time-=$interval_time) {


            if($type == 'today'){
                $search_end_time = $today_start_time+ 3600;
                $params['date'] = date('H:i',$today_start_time);
            }else{
                $search_end_time = $today_start_time+ (3600*24);
                $params['date'] = date('Y-m-d',$today_start_time);

            }

            //删除视图
            $view_sql = "DROP VIEW IF EXISTS `r_statistics_view`";
            $view_rs = Yii::app()->db->createCommand($view_sql)->execute();
            if ($view_rs) {
                dump('ssss');
            }


            //建立访问表statistics表视图
            $view_sql = "CREATE VIEW `r_statistics_view` AS SELECT * FROM `r_statistics` WHERE `source_name` != '测试地址' AND `addtime` > $today_start_time AND `addtime` < $search_end_time";
            $view_rs = Yii::app()->db->createCommand($view_sql)->execute();
            // if ($view_rs) {
            $view_name = 'r_statistics_view';
            //  } else {
            //      $view_name = 'r_statistics';
            //   }

            $params['view'] =$view_name;


            //uv,pv,总流量
            $sql = "SELECT `id`,`status`,COUNT(`status`) as `lookin`,SUM(`p_size`) as `total_flow` FROM `$view_name` WHERE `source_name` != '测试地址' AND `addtime` > $today_start_time AND `addtime` < $search_end_time GROUP BY `status`";
            $rs = Yii::app()->db->createCommand($sql)->queryAll();
            $params['uv'] = 0;
            $params['total_flow'] = 0;
            if (!$rs) {
                $params['nv'] = 0;
                $params['pv'] = 0;
            } else {
                foreach ($rs as $k => $v) {
                    $params['total_flow'] = $params['total_flow'] + $v['total_flow'];
                    if ($v['status'] == 'nv' || $v['status'] == 'uv') {
                        $params['uv'] = $params['uv'] + $v['lookin'];
                    }
                    if ($v['status'] == 'nv') {
                        $params['nv'] = $v['lookin'];
                    }
                    if ($v['status'] == 'pv') {
                        $params['pv'] = $v['lookin'];
                    }
                }
            }

            $params['one'] = time();


            //注册用户数量
            $sql = "SELECT `id`,COUNT(*) AS `register` FROM `r_person_user` WHERE `addtime` >=$today_start_time AND `addtime` < $search_end_time";
            $rs = Yii::app()->db->createCommand($sql)->queryRow();
            if ($rs) {
                $params['register'] = $rs['register'];
            } else {
                $params['register'] = 0;

            }
            $params['two'] = time();

            //发布并有访问的用户数量
            $sql = "SELECT s.id FROM `r_product_verify` `v` JOIN `$view_name` `s` ON v.product_id=s.product_id WHERE v.addtime >= $today_start_time AND s.source_name != '测试地址' AND v.addtime < $search_end_time GROUP BY s.user_id";
            $rs = Yii::app()->db->createCommand($sql)->queryAll();
            $params['issuance_user'] = 0;
            if ($rs) {
                foreach ($rs as $k => $v) {
                    $params['issuance_user']++;
                }
            }
            $params['there'] = time();
            //免费/付费发布项目数量
            $sql = "SELECT p.id,p.pay FROM `r_product_verify` `v` JOIN `$view_name` `s` ON v.product_id=s.product_id JOIN `r_product` `p` ON s.product_id=p.product_id WHERE v.addtime >= $today_start_time  AND v.addtime < $search_end_time AND s.source_name != '测试地址' GROUP BY s.product_id";
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
            $params['four'] = time();
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

            $params['addtime'] = time();

            $params['five'] = time();
            dump($params);

        }



    }
    public function actionStatistics5(){


        $type = !empty($_REQUEST['type'])?$_REQUEST['type']:'today';//查询类型
        $interval_count = !empty($_REQUEST['interval_count'])?$_REQUEST['interval_count']: '';//间隔天数
        $is_save = !empty($_REQUEST['is_save'])?$_REQUEST['is_save']: false;//间隔天数

        if($type =='today'){
            //统计每小时的数据
            $start_time = strtotime('2017-10-25 19:00:00');
            $end_time = strtotime('2017-10-25 00:00:00');
            $interval_time = 3600;
        }else{
            if(empty($interval_count)){
                $this->out('100444','间隔天数为空');
            }
            $start_time = strtotime(date('Y-m-d',time()));
            $end_time = $start_time-($interval_count * 3600 * 24);
            $interval_time = 3600 * 24;
        }

        for ($today_start_time = $start_time; $today_start_time>=$end_time; $today_start_time-=$interval_time) {


            if($type == 'today'){
                $search_end_time = $today_start_time+ 3600;
                $params['date'] = date('H:i',$today_start_time);
            }else{
                $search_end_time = $today_start_time+ (3600*24);
                $params['date'] = date('Y-m-d',$today_start_time);

            }



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

            $params['search_addtime'] = $today_start_time;
            $params['addtime'] = time();

            if($is_save){

                //存储到表中
                $rs = StatisticsDayServer::addStatisticsDay($params);
                if($rs){
                    echo '存储成功';
                }

            }

            dump($params);

        }



    }
    public function actionStatistics6(){

            $start_time = strtotime(date('Y-m-d H:0:0',time()-3600));
            $today_start_time = $start_time;
            $search_end_time = $start_time+ 3600;

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
            $params['addtime'] = time();
            dump($params);

            //存储到表中
            //$rs = StatisticsDayServer::addStatisticsDay($params);


    }




    public function actionIndex()
    {

        $params['product_id'] = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $params['videoPath'] = !empty($_REQUEST['videoPath']) ? $_REQUEST['videoPath'] : [];


        //判断当前的product_id在数据库是否存在video_path
        $is_save = ResourcesServer::getResourcesVideo(['product_id' => $params['product_id']]);
        if ($is_save['code'] == 0) {
            //已经存在更新更新video_path
            $v_arr = json_decode($is_save['data'][0]['video_path']);
            $v_arr_res = array_diff($params['videoPath'], $v_arr);//判断差集
            if (!empty($v_arr_res)) {
                //如果提交的视频路径差集不为空就更新数据库
                foreach ($v_arr_res as $k => $v) {
                    array_push($v_arr, $v);//把差集加到新的数组中
                }
            }
            ResourcesServer::updateResourcesVideo(['video_path' => json_encode($v_arr)], ['id' => $is_save['data'][0]['id']]);
        } else {
            //添加视频video_path
            $params_video['product_id'] = $params['product_id'];
            $params_video['addtime'] = time();
            $params_video['video_path'] = json_encode($params['videoPath']);
            ResourcesServer::addResourcesVideo($params_video);
        }


    }

    public function actionCao()
    {

        ignore_user_abort();//即使关掉浏览器，PHP脚本也可以继续执行.
        set_time_limit(0);// 可以让程序无限制的执行下去
        $interval = 60 * 1;// 每隔15分钟执行一次
        do {
            $user_arr = FlowServer::getNub(['status' => 'open'], 2);

            $user_send_arr = [];

            if ($user_arr['code'] == 0) {
                foreach ($user_arr['data'] as $k => $v) {
                    //循环查询每个人的剩余流量
                    $water = FlowServer::getUserresidue(array('user_id' => $v->user_id, 'pay' => 'yes')) / (1024 * 1024 * 1024);
                    if ($water < 10) {
                        $water = number_format($water, 2, '.', '');
                    } else {
                        $water = ceil($water);
                    }

                    //找出需要发送短信的人
                    if ($v->nub > $water) {
                        array_push($user_send_arr, $v->user_id);
                        $user_send_arr[$v->user_id]=$v->nub;
                    }
                }
                //根据user_id找出映射的手机号码集合
                $phone_arr=UserServer::getUserPhone($user_send_arr);
                //$phone_arr = ['18301664232'];
                //发送短信
                foreach ($phone_arr['data'] as $k => $v) {
                    //查询在间隔期是否发送过短信
                    $is_sended = SendNubServer::getSendNub(['tel'=>$v->tel,'send_type'=>'watersend']);
                    if(($is_sended['code']!=0)|| (time()-$is_sended['data']->addtime)/3600 > 24){//最小单位为小时
                        $rs = CommonInterface::sendAliyunMsg($v->tel, array('code' =>$user_send_arr[$v->user_id] ),'SMS_85370060');
                        if ($rs['code'] == 000000) {
                            //保存发送的短信
                            SendNubServer::addSendNub(['tel'=>$v->tel,'send_type'=>'watersend','addtime'=>time()]);
                    var_dump($v->tel);
                            FlowServer::updateNub(['user_id'=>$v->user_id],['status'=>'closed']);
                            echo '峰值发送短信成功';
                        }

                    }

                }

            }
            // 等待15分钟再次开始循环实行
            sleep($interval);
        } while (true);


    }

    public function actionLiu(){
        //获取付费和在使用的流量包列表
        $flow_list = FlowServer::getUserlist(['status' => 'use', 'pay' =>'yes']);
        $user_msend_arr=[];
        foreach ($flow_list as $k=>$v){
            if(ceil(($v['addtime'] + $v['timespan'] * 3600 * 24 - time()) / (24 * 3600)) < 30){
                array_push($user_msend_arr, $v['user_id']);
            }
        }
        //根据user_id找出映射的手机号码集合
        $phone_obj=UserServer::getUserPhone($user_msend_arr);
        foreach ($phone_obj['data'] as $k=>$v){
            $phone_arr[$v['tel']] = $v['user_id'];
        }
        $phone_arr=array_unique($phone_arr);
        //$phone_arr = ['18301664232'];
        //发送短信
        foreach ($phone_arr as $k => $v) {
            $is_sended = SendNubServer::getSendNub(['tel' => $k, 'send_type' => 'datesend']);
            if (($is_sended['code']!=0) || (time() - $is_sended['data']->addtime) / 3600 > (24*30)) {//最小单位为小时
               $rs = CommonInterface::sendAliyunMsg($v->tel, array('code' => '8984'),'SMS_85530074');
                if ($rs['code'] == 000000) {
                    //保存发送的短信
                   SendNubServer::addSendNub(['tel' => $k, 'send_type' => 'datesend', 'addtime' => time()]);
                    dump($k.'包发送短信成功') ;
                }
            }
        }

    }

    public function actionQusiba(){
        $rsJson = ResourcesServer::getjson(array('product_id' => 'LdPEVOTsxX'));

        $str = $rsJson['data'];

        dump($str);

    }

    public function actionShipin(){

             $rs = ResourcesServer::getDisJson();
             dump($rs);

    }

    public function actionFeng()
    {
        Yii::app()->redis->getClient()->set('getUserlist','122222',3333);
        var_dump(Yii::app()->redis->getClient()->exists('getUserlist'));
        var_dump(Yii::app()->redis->getClient()->get('getUserlist'));

       // $rs = FlowServer::getUserlist();
        //var_dump($rs);
   echo microtime();

    }

    public function actionBoss(){

        $rs = OssServer::doesBucketExist('real-copy');

        var_dump($rs);
    }

    public function actionSb(){
        dump(  Yii::app()->params);

        dump(CommonInterface::sendMail('1975439864@qq.com','dsds','nihao'));



    }

    public function actionLianxi(){


        $die_count = ProductServer::getProductVerify(['product_id'=> 'HBqV8d9bzV'],true);
        dump($die_count);


    }

}