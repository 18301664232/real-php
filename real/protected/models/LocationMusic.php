<?php

//图标位置

class LocationMusic extends CActiveRecord {

    public $id; //主键
    public $uid; //
    public $name;
    public $grade;
    public $jskey;
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{music_location}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,uid,name,grade,jskey,addtime', 'safe'),
        );
    }

}
