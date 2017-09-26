<?php

/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017/9/6
 * Time: 14:38
 */
class MyController extends BaseController
{


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


        dump(json_decode('{"list":[{"name":"Real_Page_1","uid":"realapp_d6388e50ed7a68d158bb8bd1568bc26d","index":0,"iconUrl":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d6388e50ed7a68d158bb8bd1568bc26d_icon.jpg?Kd5CKrsiFk","previewUrl":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d6388e50ed7a68d158bb8bd1568bc26d_preview.jpg?thp476wnDX","Transform":{"triggert":{"next":"bHScR19kR2","prev":"a8ggWRX7da"},"effect":{"next":"MPq0yOYAvN","prev":"MPq0yOYAvN"},"dir":{"next":"enBqbUh7kM","prev":"C7WkmTqc2p"},"time":{"next":1,"prev":1}},"ver":"b61BYAQLiDrF37FZ528ycWk49","videoPath":["http://preview.realplus.cc/201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7?rvYTnKslnpTUyJCkePWUy949x?imqqUMmF0s11a1YvhgnyVz8ax","http://preview.realplus.cc/201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT?yIFhR1GRFfAenVf9B3AfNJUuu?4IOhYTbINf8Jq6W54Gpz8A91q"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d6388e50ed7a68d158bb8bd1568bc26d_preview.jpg?thp476wnDX","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d6388e50ed7a68d158bb8bd1568bc26d_icon.jpg?Kd5CKrsiFk","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d6388e50ed7a68d158bb8bd1568bc26d.html?LUemO6vUDx","jsData":{"id":"realapp_d6388e50ed7a68d158bb8bd1568bc26d","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_d6388e50ed7a68d158bb8bd1568bc26d.json?pE614aHEbW","type":"manifest","preload":"false","callback":"realapp_d6388e50ed7a68d158bb8bd1568bc26d","videoPath":["http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7?rvYTnKslnpTUyJCkePWUy949x?imqqUMmF0s11a1YvhgnyVz8ax?s8jBmnKdVvm5cD0iHfTELKpCf?pGu5ReMaY9YjpmfIjzkcDRRbe?GFd2CBsBEWYcIc7vyGJwMXHxy?TiQX95w8lZ6yEpboGctmYwwVB?n6Tqs507FqyDIdzzHMSQJgG69?R1JntfuweSryqDK4dU9xUiO7i?7VsTFmWOWsiN8ve8ZcS6rX3Rr?OBcKZrSdomWmaCyjSV0kGgyTK?MXYZFv3jJng6CT0dBUfGxRXY1?iPziyyqNMcMwluJ7ABoNKtzOZ?LRSUnKWAD18fJ2WpLq99tBwvT?cmEcQCNovNKYo2pnQKxcwFCW5?zlDwllz3QBkLgi1gIZABttm2c?7JWvhZNwVOg4mleHHPtXONeVP?S86yebIM5uZ7eqUAMDEUrryzv?YQGB90u3VuMpuaCjk4sy53LL7?eNoZHpNYOvcjKHqL9R4NxtFtd?StPCgX0hO63Aqls8v8fppmscb?3xSsZz4hdUKdY7FYKZkKu3y8s?dzKQA3XaDRetoh7ut2UOAOLAW?VEOcmO1llinVVTpngtGxcuiEL?0MF62rDOWe16AC4EWBtTOAoOe?6vGVR2H4FHew68BpcZNTgcGjY?aFv3bhbWoA53D2TzEV8spWW9a?dy1b2utFJoSmedo0xhgtChF8u?jDdHzGy4FpueiBv1iC779tSJ3?oBcBtXNVt9kdj0DSAEOXNfJ6A?9nvepZQJNkVSwHkyscNPr9F9U?yM1l306NCn7lG8CnDTl7NICxK","http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT?yIFhR1GRFfAenVf9B3AfNJUuu?4IOhYTbINf8Jq6W54Gpz8A91q?ex77DFpzfOFA9qK1NvgG5bz5z?t51hvaT592m46VnlLjiuJinZO?q2NqVWqovh0Kz9Xesd998F7gC?WtCKnQ2MyZByUMAqywcMy16ob?OnqV5iF6wwJviBBPAylpRvxnm?YEAHun8tbzPuersZImfVA495g?NN671Fb1wrvIFE3r71du0JIfx?2g6ELwuWgpqocjc3qPp5SogTd?t0xyckChYvQkpzA3xeKQbsLPO?HjNpJdBcARxCWCLexmxWXOVws?yZzJevbtYw32GFkUiby2fTm44?jSaC3AoA5EncfQn9jofXeQdE7?VyvGgNam72rPR3V46WTzIXU43?5gUfGUkcbw5Rsr7owE2zCg9qa?ij4SPtFn8hcMMbw0cZhElhFbo?QNtISlCnCpykfUNECUHkknQJk?2kMtfIXq6B2U9vDctFGyh8Mjr?TxiqWH7MYs7zWvE6TRbJoxKbi?NP22A3g5Cr162rbrgx8FohIYV?90xQTWfLQqpAV9rrFHYsFMMEg?PROVXGju1JI14xEvRcPYSLsCh?CTkATIQzZ2y7MNt2KympeRD4p?jz1WX0cDATPUQkdgeAr0LiDOx?xoKXQ58Id32uLygFPGgmBJZJK?71DuGzY6g6X2EPpAZfQpkcfrX?5n169unCg2YQi5iNLfbQxIAGc?cnZfkKE5e2WhY4FtQnwOJAXl0?23gBFJt9RtoFaDrQionO5uLTN?UGlsumscKmbbCHSkbPkVreQku"],"loadTimeout":8000,"ext":"json","path":""},"t":{"triggert":{"next":"bHScR19kR2","prev":"a8ggWRX7da"},"effect":{"next":"MPq0yOYAvN","prev":"MPq0yOYAvN"},"dir":{"next":"enBqbUh7kM","prev":"C7WkmTqc2p"},"time":{"next":1,"prev":1}},"covered":true,"element":{"currentType":"video","video":{"current":"R_instance_Real_Page_1","currentName":"Real_Video_1","arr":[{"id":"R_instance_Real_Page_1","type":"video","name":"Real_Video_1","dotArr":[{"type":"shareLayer","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?FyUK3U9UeI","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?0LRv1RfYhK"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_0d8298e5024364f9d3e272df1519de40_preview.jpg?ZFby21vcSA","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_0d8298e5024364f9d3e272df1519de40_icon.jpg?kDQXGXCLHn","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_0d8298e5024364f9d3e272df1519de40.html?V5V51bvUy9","name":"Real_FlootLayer3","jsData":{"id":"realapp_0d8298e5024364f9d3e272df1519de40","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_0d8298e5024364f9d3e272df1519de40.json?4Kil8rgxxn","type":"manifest","preload":"false","callback":"realapp_0d8298e5024364f9d3e272df1519de40"},"time":"1504149617","used":true,"dotTime":4}]}]}}},{"name":"Real_Page_1","uid":"realapp_d5af41e690a45ed8009f373b9ed1677b","index":1,"iconUrl":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d5af41e690a45ed8009f373b9ed1677b_icon.jpg?UwLCyIKLtS","previewUrl":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d5af41e690a45ed8009f373b9ed1677b_preview.jpg?yb6nopCFzp","Transform":{"triggert":{"next":"bHScR19kR2","prev":"a8ggWRX7da"},"effect":{"next":"MPq0yOYAvN","prev":"MPq0yOYAvN"},"dir":{"next":"enBqbUh7kM","prev":"C7WkmTqc2p"},"time":{"next":1,"prev":1}},"ver":"1KPEUboMnCF2KeU52RsCIQAoa","videoPath":[],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d5af41e690a45ed8009f373b9ed1677b_preview.jpg?yb6nopCFzp","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d5af41e690a45ed8009f373b9ed1677b_icon.jpg?UwLCyIKLtS","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d5af41e690a45ed8009f373b9ed1677b.html?Fq28Pvsdrt","jsData":{"id":"realapp_d5af41e690a45ed8009f373b9ed1677b","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_d5af41e690a45ed8009f373b9ed1677b.json?vtgBFXwL8P","type":"manifest","preload":"false","callback":"realapp_d5af41e690a45ed8009f373b9ed1677b","videoPath":[]},"t":{"triggert":{"next":"bHScR19kR2","prev":"a8ggWRX7da"},"effect":{"next":"MPq0yOYAvN","prev":"MPq0yOYAvN"},"dir":{"next":"enBqbUh7kM","prev":"C7WkmTqc2p"},"time":{"next":1,"prev":1}},"element":{"currentType":"button","button":{"current":"R_instance_realapp_d5af41e690a45ed8009f373b9ed1677b","currentName":"Real_Btn_12","arr":[{"id":"R_instance_realapp_d5af41e690a45ed8009f373b9ed1677b","type":"button","name":"Real_Btn_12","trigger":{"triEvent":"点击时","triAction":"显示浮层","triContent":""},"layer":"realapp_ec97308750f5b407d7b2dbcfa8a47c5c"}]}},"covered":true},{"name":"Real_Page_3","uid":"realapp_4bf80744131b58b2ea3ff0a6ac2523cb","index":2,"iconUrl":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_4bf80744131b58b2ea3ff0a6ac2523cb_icon.jpg?gWZr3v2how","previewUrl":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_4bf80744131b58b2ea3ff0a6ac2523cb_preview.jpg?oYmVQDvp45","Transform":{"triggert":{"next":"bHScR19kR2","prev":"a8ggWRX7da"},"effect":{"next":"MPq0yOYAvN","prev":"MPq0yOYAvN"},"dir":{"next":"enBqbUh7kM","prev":"C7WkmTqc2p"},"time":{"next":1,"prev":1}},"ver":"M7qnyxqYMkaNxxtV9zJuL3C4D","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_4bf80744131b58b2ea3ff0a6ac2523cb_preview.jpg?oYmVQDvp45","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_4bf80744131b58b2ea3ff0a6ac2523cb_icon.jpg?gWZr3v2how","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_4bf80744131b58b2ea3ff0a6ac2523cb.html?miUSoZMqvC","jsData":{"id":"realapp_4bf80744131b58b2ea3ff0a6ac2523cb","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_4bf80744131b58b2ea3ff0a6ac2523cb.json?sytlWrnBDy","type":"manifest","preload":"false","callback":"realapp_4bf80744131b58b2ea3ff0a6ac2523cb","videoPath":["http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7?2euk69nfXjpwPRToyOgUjHM32?3DXt1mBXCqzoeLlJxz9MiuUYx?KKIZmjYjXeevWqXS5DHs1ZomU?0wut47ZYhRFSGXxrUotrwE6HH?IPlTWNJ7TPUP1YENRfZFwQZUz?TSsleCFh3a4TEmgrbBGOzHoN2?h4XSdVwEbKXKTvYUtYw73Ru8k?uVQQvAw2J0cBbg2MAyxaMEcw1?VyOa69xZ7jVr6Hhlxr0U6zfZn?XEfTISJYsN6d54rLXhLEXSl6v?vl9PDtxlMgnJgl7kbCcfDxDEb?skIsOJ5CBznqgnLoHGng9sqFq?IjKjwWDCPMNzKTEyCZdRwT7Al?PUNQmkse61ndnKI5nv577nrkv?f9kQw2nHd8EEZRZCXyYU2Uzjw?4BxvfvYludgWYPiZDJ7fWLyCp?I7HarJGGLttjxBslXAuV6KLdM?5xbWpyTyCw8Q5lmCykpakd52G?W0PIX36GnqPUdfxKjO9Jmjw9q?XfVMey5RUcKtrlhkp7f5POO6G?FZuzEKukpGWTHEbvPr5TulVJW?6SfqYStljFiDELkxj38vXvGS5?pXEm1iiwyEPPlFSEL3oyPEaYM?p3o4ZIkNNsQ3K9xHFHNnWM1WJ?r3MI3U68X3HLLxY4OO7jF7USJ","http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/http://preview.realplus.cc/201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT?deq55GLn9GYfVTdppxL8ShEPS?3rH4OhIHTGXQHYW4Oco2RLxdC?S594twvBOVWlkplXAwrCI9JYi?GYig6t46WjfyNUOdKWbALImFL?F4G81dvMWzC3THZf88XyL733s?1Mr5h0OGbCeBiwqsJC4oz8zw3?qISMqEkWiyKGp8ge3ZSN1iYRn?0W4qZzPpuINSlQVdA1Igz3ffZ?tGtlWVxqYoCvQIMQ34znQU6QN?nHudV8qNSkC66N3KYDhfof16Z?IUxdOYDVH2VZlqi29YgeLMNdp?n7lC1AexDTIYGwkbtw7BfwkU0?tT57spMH5GfPjukDD7uHxLeb3?OV9cqDyOG2azwH8FmfgmXUz18?MlppPWsv63zt7OgeufgmjQDzp?wuFkaSKp49ak5BsQsdZteErBk?50bZj7hkk49yfDvoDj2Fg3ClW?Y56QflNPnEjntJ1u9KIW1eYOZ?WIuyorqtYDmzQdCS4H5OEAp8s?o3PD4aNV7ZEJnJ9UQe68DeTwJ?s0Squ9reaOnZs2UOug3AdCKi9?yr23JG6tB92n5iBgtpCn3irRH?QB9BA4hyvPMKbqeMdpnRzbICz?eprpIENi8WbH9OK6XsBYFTEMK?37IkJbe54kw5T6Np8ltqhjLDl"]},"covered":false,"t":{"triggert":{"next":"bHScR19kR2","prev":"a8ggWRX7da"},"effect":{"next":"MPq0yOYAvN","prev":"MPq0yOYAvN"},"dir":{"next":"enBqbUh7kM","prev":"C7WkmTqc2p"},"time":{"next":1,"prev":1}},"element":{"currentType":"video","video":{"current":"R_instance_Real_Page_3","currentName":"Real_Video_5","arr":[{"id":"R_instance_Real_Page_3","type":"video","name":"Real_Video_5","dotArr":[{"type":"shareLayer","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_04ba87a94b4d3151c6911474e50d6e8e_preview.jpg?1KLImpfZDn","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_04ba87a94b4d3151c6911474e50d6e8e_icon.jpg?koZjGgl0Kr","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_04ba87a94b4d3151c6911474e50d6e8e.html?01UzCBY2lK","name":"Real_FlootLayer3","jsData":{"id":"realapp_04ba87a94b4d3151c6911474e50d6e8e","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_04ba87a94b4d3151c6911474e50d6e8e.json?Kmg5DSqjnG","type":"manifest","preload":"false","callback":"realapp_04ba87a94b4d3151c6911474e50d6e8e"},"time":"1504150153","used":true,"dotTime":0}]}]}}}],"ver":"DADKO1PyoliTCqjtWqtRvvWed","cover":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_d5af41e690a45ed8009f373b9ed1677b_preview.jpg?yb6nopCFzp","layer":[{"type":"shareLayer","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?FyUK3U9UeI","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?0LRv1RfYhK"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_0d8298e5024364f9d3e272df1519de40_preview.jpg?ZFby21vcSA","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_0d8298e5024364f9d3e272df1519de40_icon.jpg?kDQXGXCLHn","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_0d8298e5024364f9d3e272df1519de40.html?V5V51bvUy9","name":"Real_FlootLayer3","jsData":{"id":"realapp_0d8298e5024364f9d3e272df1519de40","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_0d8298e5024364f9d3e272df1519de40.json?4Kil8rgxxn","type":"manifest","preload":"false","callback":"realapp_0d8298e5024364f9d3e272df1519de40"},"time":"1504149617","used":false,"ver":"eyq4ZhL8mQ89hvSgPzimIWyFg"},{"type":"shareLayer","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_ec97308750f5b407d7b2dbcfa8a47c5c_preview.jpg?yQKdVVGPjK","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_ec97308750f5b407d7b2dbcfa8a47c5c_icon.jpg?XFRLFt8xNo","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_ec97308750f5b407d7b2dbcfa8a47c5c.html?pd3Xu2rrbG","name":"Real_FlootLayer1","jsData":{"id":"realapp_ec97308750f5b407d7b2dbcfa8a47c5c","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_ec97308750f5b407d7b2dbcfa8a47c5c.json?mJEJpUfd92","type":"manifest","preload":"false","callback":"realapp_ec97308750f5b407d7b2dbcfa8a47c5c"},"time":"1504150153","used":false,"ver":"6nwu0kVnRFe1npNmxznNArcb4"},{"type":"shareLayer","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_6b513aa9f10b7988550e876aec8c0562_preview.jpg?KquZFFXlKr","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_6b513aa9f10b7988550e876aec8c0562_icon.jpg?35UGgwAWmj","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_6b513aa9f10b7988550e876aec8c0562.html?ekdbBBtjo4","name":"Real_FlootLayer2","jsData":{"id":"realapp_6b513aa9f10b7988550e876aec8c0562","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_6b513aa9f10b7988550e876aec8c0562.json?H56WYMzsiW","type":"manifest","preload":"false","callback":"realapp_6b513aa9f10b7988550e876aec8c0562"},"time":"1504150153","used":false,"ver":"93CHPE7L1EW7seMgEJ4IAuEBV"},{"type":"shareLayer","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_04ba87a94b4d3151c6911474e50d6e8e_preview.jpg?1KLImpfZDn","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_04ba87a94b4d3151c6911474e50d6e8e_icon.jpg?koZjGgl0Kr","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_04ba87a94b4d3151c6911474e50d6e8e.html?01UzCBY2lK","name":"Real_FlootLayer3","jsData":{"id":"realapp_04ba87a94b4d3151c6911474e50d6e8e","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_04ba87a94b4d3151c6911474e50d6e8e.json?Kmg5DSqjnG","type":"manifest","preload":"false","callback":"realapp_04ba87a94b4d3151c6911474e50d6e8e"},"time":"1504150153","used":false,"ver":"kzk3PeOc8fLK54TuqQYgkH43Q"},{"type":"manifest","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?FyUK3U9UeI","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?0LRv1RfYhK"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_0d8298e5024364f9d3e272df1519de40_preview.jpg?ZFby21vcSA","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_0d8298e5024364f9d3e272df1519de40_icon.jpg?kDQXGXCLHn","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_0d8298e5024364f9d3e272df1519de40.html?V5V51bvUy9","name":"Real_FlootLayer3","id":"realapp_0d8298e5024364f9d3e272df1519de40","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_0d8298e5024364f9d3e272df1519de40.json?4Kil8rgxxn","preload":"false","callback":"realapp_0d8298e5024364f9d3e272df1519de40","time":"1504149617","used":false,"ver":"xgBQ0EWyGuOGNe655wMVe5wjw"},{"type":"manifest","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_ec97308750f5b407d7b2dbcfa8a47c5c_preview.jpg?yQKdVVGPjK","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_ec97308750f5b407d7b2dbcfa8a47c5c_icon.jpg?XFRLFt8xNo","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_ec97308750f5b407d7b2dbcfa8a47c5c.html?pd3Xu2rrbG","name":"Real_FlootLayer1","id":"realapp_ec97308750f5b407d7b2dbcfa8a47c5c","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_ec97308750f5b407d7b2dbcfa8a47c5c.json?mJEJpUfd92","preload":"false","callback":"realapp_ec97308750f5b407d7b2dbcfa8a47c5c","time":"1504150153","used":false,"ver":"5tfHMlSupRV7CKUuW8eYFAV2H"},{"type":"manifest","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_6b513aa9f10b7988550e876aec8c0562_preview.jpg?KquZFFXlKr","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_6b513aa9f10b7988550e876aec8c0562_icon.jpg?35UGgwAWmj","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_6b513aa9f10b7988550e876aec8c0562.html?ekdbBBtjo4","name":"Real_FlootLayer2","id":"realapp_6b513aa9f10b7988550e876aec8c0562","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_6b513aa9f10b7988550e876aec8c0562.json?H56WYMzsiW","preload":"false","callback":"realapp_6b513aa9f10b7988550e876aec8c0562","time":"1504150153","used":false,"ver":"RS4LjuLQrvFG6d53sPryyAHDx"},{"type":"manifest","videoPath":["201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/6ivIJfB2F7nwiCNk3b7p.mp4?tBEY9Q9Ti7","201708/94159ef9861d70e6504f6d86068abd0285c9902f/video/xzHoDQfJIdt4ribH3HHj.mp4?7ioqboIsJT"],"img_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_04ba87a94b4d3151c6911474e50d6e8e_preview.jpg?1KLImpfZDn","img_icon":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_04ba87a94b4d3151c6911474e50d6e8e_icon.jpg?koZjGgl0Kr","html_preview":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/preview/realapp_04ba87a94b4d3151c6911474e50d6e8e.html?01UzCBY2lK","name":"Real_FlootLayer3","id":"realapp_04ba87a94b4d3151c6911474e50d6e8e","src":"201708/94159ef9861d70e6504f6d86068abd0285c9902f/edit/json/realapp_04ba87a94b4d3151c6911474e50d6e8e.json?Kmg5DSqjnG","preload":"false","callback":"realapp_04ba87a94b4d3151c6911474e50d6e8e","time":"1504150153","used":false,"ver":"9T0DyqsQDnHBeS14wZHKaVYcU"}],"music":{"enabled":false,"position":"PfWzf6RdAJ","selectMusic":-1},"proConfig":{}}
'));


    }

    public function actionLianxi(){


        $die_count = ProductServer::getProductVerify(['product_id'=> 'HBqV8d9bzV'],true);
        dump($die_count);


    }

}