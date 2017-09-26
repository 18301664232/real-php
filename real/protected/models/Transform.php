<?php

//切换

class Transform extends CActiveRecord {

    public $id; //主键
    public $grade;
    public $name;
    public $uid;
    public $jsobj;
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{transform}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,grade,name,uid,jsobj,addtime', 'safe'),
        );
    }

}
