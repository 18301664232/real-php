<?php

//效果

class Effect extends CActiveRecord {

    public $id; //主键
    public $grade;
    public $name;
    public $uid;
    public $dir;
    public $jskey;
    public $addtime;
    public $parentid;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{transform_effect}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,grade,name,uid,dir,jskey,addtime,parentid', 'safe'),
        );
    }

}
