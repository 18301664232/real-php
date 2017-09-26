
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-08-25 05:38:24
 */
//用户与邮件关联数据表

class UserMail extends CActiveRecord{

    public $id;
    public $user_id;
    public $mail_id;
    public $status;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{user_mail}}';
    }

    public function primaryKey() {
        return 'id';
    }

//    public function relations(){
//
//        return array(
//            'mail'=>array(self::BELONGS_TO, 'Mail', 'id','foreignKey'=>'mail_id'),
//          //  'activityinfo'=>array(self::BELONGS_TO, 'ActivityInfo', 'id', 'foreignKey'=>'aid', 'alias'=>'activityinfo', 'select'=>'id,act_name'),
//        );
//
//    }

    public function rules() {
        return array(
            array('id,user_id,mail_id,status', 'safe'),
        );
    }

}
