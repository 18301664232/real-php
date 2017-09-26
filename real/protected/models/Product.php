<?php

//用户作品

class Product extends CActiveRecord {

    public $id; //主键
    public $user_id; //
    public $product_id; //
    public $title; //
    public $description; //
    public $p_size; //
    public $cover; //
    public $online; //
    public $pay; //
    public $status; //
    public $total; // 用于分组的数量
    public $is_open; //
    public $cloud; //
    public $wechat_title; //
    public $wechat_content; //
    public $wechat_img; //
    public $path;
    public $color;
    public $updatetime; //
    public $addtime; //

    //Model静态方法为必须有的方法

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{product}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,user_id,product_id,title,description,p_size,cover,online,pay,status,total,is_open,cloud,wechat_title,wechat_content,wechat_img,path,color,updatetime,addtime', 'safe'),
        );
    }

}
