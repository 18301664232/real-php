<?php

//工单

class WorkOrder extends CActiveRecord {

    public $id; //主键
    public $order_no;
    public $_id; //
    public $title; //
    public $content; //
    public $type; //
    public $remind; //
    public $status; //
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{work_order}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,order_no,_id,title,content,type,remind,status,addtime', 'safe'),
        );
    }

}
