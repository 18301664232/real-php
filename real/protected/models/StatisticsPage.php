<?php

//页面统计表

class StatisticsPage extends CActiveRecord {

    public $id; //主键
    public $product_id;
    public $page_name;
    public $page_time;
    public $source_id;
    public $status;
    public $browse_status;
    public $addtime;
    public $page;
    
    

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{statistics_page}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,product_id,page_name,page_time,source_id,status,browse_status,addtime,page', 'safe'),
        );
    }

}
