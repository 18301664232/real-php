<?php

//素材

class Resources extends CActiveRecord {

    public $id; //主键
    public $product_id; //
    public $datas; //
    public $addtime; //

    //Model静态方法为必须有的方法

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{resources}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,product_id,datas,addtime', 'safe'),
        );
    }

}
