<?php

//用户作品预览链接

class ProductLink extends CActiveRecord {

    public $id; //主键
    public $uid; //
    public $name; //
    public $product_id; //
    public $url; //
    public $p_size; //
    public $status; //
    public $addtime; //

    //Model静态方法为必须有的方法

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{product_link}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,uid,name,product_id,url,p_size,status,addtime', 'safe'),
        );
    }

}
