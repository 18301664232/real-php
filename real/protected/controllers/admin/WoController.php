<?php


ignore_user_abort();//即使关掉浏览器，PHP脚本也可以继续执行.
set_time_limit(0);// 可以让程序无限制的执行下去
$interval=60*1;// 每隔15分钟执行一次
do{
    $user_arr =  FlowServer::getNub(['status'=>'open','is_send'=>'no'],2);
    $user_send_arr = [];
    if($user_arr['code']==0){
        foreach ($user_arr['data'] as $k=>$v){
            //循环查询每个人的剩余流量
            $water = FlowServer::getUserresidue(array('user_id' => $v->user_id, 'pay' => 'yes')) / (1024 * 1024 * 1024);
            if ($water < 10) {
                $water = number_format($water, 2, '.', '');
            } else {
                $water = ceil($water);
            }
            //找出需要发送短信的人
            if($v->nub > $water){
                array_push($user_send_arr,$v->user_id);
            }
        }
        //根据user_id找出映射的手机号码集合
        //$phone_arr=UserServer::getUserPhone($user_send_arr);
        $phone_arr=['18301664232'];
        //发送短信
        foreach ($phone_arr as $k=>$v){
            $rs = CommonInterface::sendAliyunMsg($v, array('code'=>'8984'));
        }
        if ($rs['code'] == 000000) {

            echo '流量监测成功';
        }
    }
    // 等待15分钟再次开始循环实行
    sleep($interval);
}while(true);