
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-09-18 12:11:08
 */
//项目审核表

class ProductVerify extends CActiveRecord{

   public $id;
public $product_id;
public $verify_admin;
public $is_has_video;
public $verify_reason;
public $verify_status;
public $copy_status;
public $addtime;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{product_verify}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,product_id,verify_admin,is_has_video,verify_reason,verify_status,copy_status,addtime,', 'safe'),
        );
    }

}
