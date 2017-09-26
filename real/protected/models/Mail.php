
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-08-25 05:41:58
 */
//邮件数据表

class Mail extends CActiveRecord{

    public $id;
    public $title;
    public $type;
    public $status;
    public $contents;
    public $sendtime;
    public $addtime;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{mail}}';
    }


    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,title,type,status,contents,sendtime,addtime', 'safe'),
        );
    }

}
