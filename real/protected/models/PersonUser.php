<?php

//个人用户

class PersonUser extends CActiveRecord {

    public $id; //主键
    public $user_id; //用户ID
    public $pwd; //密码
    public $type; //账号类别，个人1，企业子账号3
    public $company_id; //企业id
    public $tel; //电话
    public $email; //邮箱
    public $nickname; //昵称
    public $sex; //性别
    public $headimg; //头像
    public $province; //省份
    public $city; //城市
    public $birthdate; //出生年月日
    public $signature; //签名
    public $last_time; //最后一次登录的时间
    public $last_ip; //最后一次登录的IP
    public $addtime; //添加时间
    public $status; //状态

    //Model静态方法为必须有的方法

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{person_user}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,user_id,pwd,type,company_id,tel,email,nickname,sex,headimg,province,city,birthdate,signature,last_time,last_ip,addtime,status', 'safe'),
        );
    }

}
