<?php

//工单

class WorkOrderImg extends CActiveRecord {

    public $id; //主键
    public $order_no;
    public $link; //

    //Model静态方法为必须有的方法

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{work_order_img}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,order_no,link', 'safe'),
        );
    }

}
