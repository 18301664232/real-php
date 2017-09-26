<?php

//流量类型

class FlowType extends CActiveRecord {

    public $id; //主键
    public $name;
    public $type;
    public $img_url;
    public $grade;
    public $money;
    public $timespan; //
    public $water; //
    public $pay; //
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{flow_type}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,name,timespan,water,pay,addtime,type,grade,money,img_url', 'safe'),
        );
    }

}
