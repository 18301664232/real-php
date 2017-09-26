<?php

//统计

class Statistics extends CActiveRecord {

    public $id; //主键
    public $user_id; //
    public $product_id; //
    public $product_name; //
    public $source_name; //
    public $source_id; //
    public $p_size; //
    public $ip; //
    public $status; //
    public $pay; //
    public $addtime; //

    //Model静态方法为必须有的方法

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{statistics}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,user_id,product_id,product_name,source_name,source_id,p_size,ip,status,pay,addtime', 'safe'),
        );
    }

}
