<?php

//后台管理员

class Admin extends CActiveRecord {

    public $id; //主键
    public $username;
    public $password; //密码
    public $last_time; //密码
    public $last_ip; //密码
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{admin}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,username,password,last_time,last_ip,addtime', 'safe'),
        );
    }

}
