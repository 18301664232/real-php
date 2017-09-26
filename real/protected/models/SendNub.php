
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-09-07 06:22:25
 */
//短信发送阀值表

class SendNub extends CActiveRecord{

   public $id;
public $tel;
public $send_type;
public $addtime;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{send_nub}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,tel,send_type,addtime,', 'safe'),
        );
    }

}
