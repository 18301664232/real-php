
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-27 05:36:37
 */
//角色与权限关联表

class RolePermissions extends CActiveRecord{

    public $id;
    public $role_id;
    public $permissions_id;
    public $addtime;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{role_permissions}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,role_id,permissions_id,addtime,', 'safe'),
        );
    }

}
