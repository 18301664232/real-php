<?php

//个人音乐

class PersonMusic extends CActiveRecord {

    public $id; //主键
    public $user_id;
    public $product_id;
    public $uid; //
    public $name;
    public $url;
    public $music_size;
    public $status;
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{person_music}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,user_id,product_id,uid,name,url,music_size,status,addtime', 'safe'),
        );
    }

}
