<?php

//保存JSON

class ResourcesJson extends CActiveRecord {

    public $id; //主键
    public $product_id; //
    public $datas; //
    public $str; //
    public $status; //
    public $addtime; //
    public $is_has_video; //


    //Model静态方法为必须有的方法

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{resources_json}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,product_id,datas,str,status,addtime,is_has_video', 'safe'),
        );
    }

}
