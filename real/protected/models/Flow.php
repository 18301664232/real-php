<?php

//流量包

class Flow extends CActiveRecord {

    public $id; //主键
    public $user_id;
    public $type_id; //
    public $status; //
    public $use_water; //
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{flow}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,user_id,type_id,status,use_water,addtime', 'safe'),
        );
    }

}
