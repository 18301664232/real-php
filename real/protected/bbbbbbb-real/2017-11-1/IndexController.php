<?php

/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017/10/26
 * Time: 16:10
 */
class IndexController extends CenterController
{

    //后台首页
    public $layout = 'admin';
    public function init() {
        parent::init();
        if (!$this->checkLogin('admin'))
            $this->showMessage('未登录', U('admin/login/login'));
    }

    public function actionIndex(){

        $this->render('list');
    }

    //查询筛选的统计
    public function actionSearchToday(){

        $time_type = !empty($_REQUEST['time_type']) ? $_REQUEST['time_type']:'now';
        if($time_type == 'now'){
            $today_start_time = strtotime(date('Y-m-d',time()));
            $sql = "SELECT `total_order`,`total_money`, `uv`,`pv`, `register`,`issuance_user`,ROUND(total_flow/1024/1024/1024,2) AS `total_flow`, `free_product`, `pay_product`, `issuance_product`,FROM_UNIXTIME(search_addtime,'%H:%i:%s') AS `group_time`FROM `r_statistics_day` WHERE search_addtime >= $today_start_time ORDER BY search_addtime";
        }
        if($time_type == 'prev'){
            $today_start_time = strtotime(date('Y-m-d',time()));
            $prev_start_time = strtotime(date('Y-m-d',time())) - (3600*24);
            $sql = "SELECT  `total_order`,`total_money`, `uv`,`pv`, `register`,`issuance_user`,ROUND(total_flow/1024/1024/1024,2) AS `total_flow`, `free_product`, `pay_product`, `issuance_product`,FROM_UNIXTIME(search_addtime,'%H:%i:%s') AS `group_time` FROM `r_statistics_day` WHERE search_addtime >= $prev_start_time AND search_addtime < $today_start_time ORDER BY search_addtime";
        }
        if($time_type == 'prev_seven'){
            $prev_seven_start_time = strtotime(date('Y-m-d',time())) - (3600*24*6);
            $sql = "SELECT SUM(total_order) AS `total_order`, SUM(total_money) AS `total_money`, SUM(uv) AS `uv`,SUM(pv) AS `pv`,SUM(register) AS `register`,SUM(issuance_user) AS `issuance_user`,ROUND(SUM(total_flow)/1024/1024/1024,2) AS `total_flow`,SUM(free_product) AS `free_product`,SUM(pay_product) AS `pay_product`,SUM(issuance_product) AS `issuance_product`,FROM_UNIXTIME(search_addtime,'%Y-%m-%d') AS `group_time` FROM `r_statistics_day` WHERE search_addtime >= $prev_seven_start_time GROUP BY group_time ORDER BY search_addtime";
        }
        if($time_type == 'prev_thirty'){
            $prev_seven_start_time = strtotime(date('Y-m-d',time())) - (3600*24*29);
            $sql = "SELECT  SUM(total_order) AS `total_order`,  SUM(total_money) AS `total_money`, SUM(uv) AS `uv`,SUM(pv) AS `pv`,SUM(register) AS `register`,SUM(issuance_user) AS `issuance_user`,ROUND(SUM(total_flow)/1024/1024/1024,2)AS `total_flow`,SUM(free_product) AS `free_product`,SUM(pay_product) AS `pay_product`,SUM(issuance_product) AS `issuance_product`,FROM_UNIXTIME(search_addtime,'%Y-%m-%d') AS `group_time` FROM `r_statistics_day` WHERE search_addtime >= $prev_seven_start_time GROUP BY group_time ORDER BY search_addtime";
        }

        if($time_type == 'myself'){
            $start_time = !empty($_REQUEST['start_time']) ? $_REQUEST['start_time']:'';
            $end_time = !empty($_REQUEST['end_time']) ? $_REQUEST['end_time']:'';
            if(empty($start_time) || empty($end_time)){
                $this->out('100444','参数输入为空',['data'=>[]]);
            }
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time);
            if(($end_time - $start_time) > 3600*24){
                $sql = "SELECT  SUM(total_order) AS `total_order`, SUM(total_money) AS `total_money`, SUM(uv) AS `uv`,SUM(pv) AS `pv`,SUM(register) AS `register`,SUM(issuance_user) AS `issuance_user`,ROUND(SUM(total_flow)/1024/1024/1024,2) AS `total_flow`,SUM(free_product) AS `free_product`,SUM(pay_product) AS `pay_product`,SUM(issuance_product) AS `issuance_product`,FROM_UNIXTIME(search_addtime,'%Y-%m-%d') AS `group_time` FROM `r_statistics_day` WHERE search_addtime >= $start_time AND search_addtime <= $end_time GROUP BY group_time ORDER BY search_addtime";

            }else if ($end_time == $start_time){
                $end_time = ($end_time+3600*24);

                $sql = "SELECT  `total_order`,`total_money`, `uv`,`pv`, `register`,`issuance_user`,ROUND(total_flow/1024/1024/1024,2) AS `total_flow`, `free_product`, `pay_product`, `issuance_product`,FROM_UNIXTIME(search_addtime,'%H:%i:%s') AS `group_time` FROM `r_statistics_day` WHERE search_addtime >= $start_time AND search_addtime < $end_time ORDER BY search_addtime";


            }else{
                $end_time = ($end_time+3600*24);
                $sql = "SELECT  `total_order`,`total_money`, `uv`,`pv`, `register`,`issuance_user`,ROUND(total_flow/1024/1024/1024,2) AS `total_flow`, `free_product`, `pay_product`, `issuance_product`,FROM_UNIXTIME(search_addtime,'%H:%i:%s') AS `group_time` FROM `r_statistics_day` WHERE search_addtime >= $start_time AND search_addtime < $end_time ORDER BY search_addtime";

            }

        }
        $rs = Yii::app()->db->createCommand($sql)->queryAll();
        if($rs){
//            if($time_type == 'myself'&&count($rs)>24 && count($rs)<=48){
//            $self_data = [];
//                foreach ($rs as $k=>$v){
//                    $self_data = array_merge_recursive($self_data,$v);
//                }
//
//                foreach ($self_data as $k=>$v){
//                    if($k == 'group_time'){
//                        break;
//                    }
//                    $count_arr[$k] = array_sum($v);
//                }
//
//                    $this->out('0','数据读取',['data'=>$self_data,'count'=>$count_arr]);
//                }

            $arr = [];
            $count_arr = [];
            foreach ($rs as $k=>$v){
                $arr = array_merge_recursive($arr,$rs[$k]);
            }
            if(is_array($arr['uv'])){
                foreach ($arr as $k=>$v){
                    if($k == 'group_time'){
                        break;
                    }
                    $count_arr[$k] = array_sum($v);
                }

            }else{

               $data= $arr;
               foreach ($arr as $k=>$v){
                   $data[$k] = [$v];
               }
                $this->out('0','数据读取成功',['data'=>$data,'count'=>$arr]);
            }
            $this->out('0','数据读取成功',['data'=>$arr,'count'=>$count_arr]);
        }
        $this->out('100444','数据读取失败',['data'=>[]]);


    }



}