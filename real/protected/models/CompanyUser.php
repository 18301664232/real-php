<?php

//公司用户

class CompanyUser extends CActiveRecord {

    public $id; //主键
    public $company_id; //用户ID
    public $pwd; //密码
    public $tel; //电话
    public $email; //邮箱
    public $nickname; //昵称
    public $headimg; //头像
    public $province; //省份
    public $city; //城市
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
        return '{{company_user}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,company_id,pwd,tel,email,nickname,headimg,province,city,signature,last_time,last_ip,addtime,status', 'safe'),
        );
    }

}
