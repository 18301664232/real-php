
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-06 11:17:17
 */
//用户访问状态表

class AccessStatus extends CActiveRecord{

    public $id;
    public $token;
    public $page_num;
    public $addtime;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{access_status}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,token,page_num,addtime,', 'safe'),
        );
    }

}
