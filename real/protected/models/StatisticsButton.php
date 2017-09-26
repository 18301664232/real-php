<?php

//按钮统计表

class StatisticsButton extends CActiveRecord {

    public $id; //主键
    public $product_id;
    public $button_name;
    public $browse_status;
    public $source_id;
    public $status;
    public $page;
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{statistics_button}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,product_id,button_name,source_id,status,addtime,page,browse_status', 'safe'),
        );
    }

}
