<?php

//帮助类

class Help extends CActiveRecord {

    public $id; //主键
    public $grade;
    public $title; //
    public $content; //
    public $pid; //
	public $type; //
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{help}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,grade,title,content,pid,type,addtime', 'safe'),
        );
    }

}
