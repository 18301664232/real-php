<?php

//流量阈值

class FlowNub extends CActiveRecord {

    public $id; //主键
    public $user_id;
    public $nub;
    public $status;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{flow_nub}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,user_id,nub,status', 'safe'),
        );
    }

}
