<?php

//流量包

class TypeOrder extends CActiveRecord {

    public $id; //主键
    public $order_no_id;
    public $flow_type_id; //
    public $name; //
    public $count; //
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{type_order}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,order_no_id,flow_type_id,name,count,addtime', 'safe'),
        );
    }

}
