<?php

//系统音乐

class SystemMusic extends CActiveRecord {

    public $id; //主键
    public $uid; //
    public $name;
    public $url;
    public $music_size;
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{system_music}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,uid,name,url,music_size,addtime', 'safe'),
        );
    }

}
