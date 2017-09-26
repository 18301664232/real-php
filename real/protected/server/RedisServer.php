<?php
/**
 * Created by PhpStorm.
 * User: syl-----此类暂时没有使用
 * Date: 2017/9/14
 * Time: 10:24
 */
class RedisServer extends BaseServer{

     const GETLIST_REDIS_KEY='getlist';
     const GETUSERLIST_REDIS_KEY='getuserlist';

    public function  SetlistRedis(){

        $model = new Product();
        $criteria = new CDbCriteria;
        $criteria->select = '*';
        $rs = $model->findAll($criteria);
        Yii::app()->redis->getClient()->set(GETLIST_REDIS_KEY, json_encode($rs), 60);

    }

    public function SetuserlistRedis(){

        $sql = "SELECT t1.`id`,t1.`user_id`,t1.`type_id`,t1.`status`,t1.`use_water`,t1.`addtime`,t2.`name`,t2.`timespan`,t2.`water`,t2.`pay` FROM `r_flow` t1 "
            . "left join `r_flow_type` t2 on t1.`type_id` = t2.`id`";

        $data = Flow::model()->dbConnection->createCommand($sql)->queryAll();
        Yii::app()->redis->getClient()->set(GETUSERLIST_REDIS_KEY, json_encode($data), 60);
    }
    //查看缓存是否存在

    public function GetRedisMore($redis_key){

        if(Yii::app()->redis->getClient()->exsits($redis_key)){
            $rs = Yii::app()->redis->getClient()->get($redis_key);
            return json_decode($rs);
        }

    }

}
