<?php

//用户提交表单数据

class StatisticsData extends CActiveRecord {

    public $id; //主键
    public $product_id;
    public $button_id; //
    public $source_id; //
    public $data; //
    public $status; //
    public $button_name;
    public $page;
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{statistics_data}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,product_id,button_id,source_id,data,status,addtime,button_name,page', 'safe'),
        );
    }

}
