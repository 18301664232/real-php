<?php

//工单回复

class WorkReply extends CActiveRecord {

    public $id; //主键
    public $order_no;
    public $content; //
    public $reply_type; //
    public $addtime;

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{work_reply}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,order_no,content,reply_type,addtime', 'safe'),
        );
    }

}
