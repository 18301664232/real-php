
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-27 05:34:51
 */
//角色表

class AuthRole extends CActiveRecord{

   public $id;
public $role_name;
public $addtime;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{auth_role}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,role_name,addtime,', 'safe'),
        );
    }

}
