<?php

//效果方向

class Dir extends CActiveRecord {

    public $id; //主键
    public $grade;
    public $name;
    public $uid;
    public $jskey;
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{transform_dir}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,grade,name,uid,jskey,addtime', 'safe'),
        );
    }

}
