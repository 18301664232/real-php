<?php

//项目视频

class ProductVideo extends CActiveRecord {

    public $id; //主键
    public $product_id;
    public $video;
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{product_video}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,product_id,video,addtime', 'safe'),
        );
    }

}
