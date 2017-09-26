<?php

//流量包

class OrderInfo extends CActiveRecord {

    public $id; //主键
    public $user_id;
    public $order_no; //
    public $status; //
    public $detail; //
    public $money; //
    public $addtime;
    public $paytime; //
    public $type; //

    //Model静态方法为必须有的方法

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{order_info}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,user_id,order_no,status,detail,money,addtime,paytime,type', 'safe'),
        );
    }

}
