
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-27 05:34:05
 */
//管理员与角色关联表

class AdminRole extends CActiveRecord{

    public $id;
    public $role_id;
    public $admin_id;
    public $addtime;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{admin_role}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,role_id,admin_id,addtime,', 'safe'),
        );
    }

}
