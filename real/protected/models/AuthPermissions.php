
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-27 05:35:46
 */
//权限表

class AuthPermissions extends CActiveRecord{

   public $id;
public $permissions_main;
public $permissions_name;
public $permissions_sign;
public $addtime;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{auth_permissions}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,permissions_main,permissions_name,permissions_sign,addtime,', 'safe'),
        );
    }

}
