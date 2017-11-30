
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-27 08:42:26
 */
//后台管理员表

class Admin extends CActiveRecord{

    public $id;
    public $username;
    public $password;
    public $last_time;
    public $last_ip;
    public $addtime;
    public $department;
    public $name;


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
            array('id,username,password,last_time,last_ip,addtime,department,name', 'safe'),
        );
    }

}
