
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-09-06 10:17:05
 */
//视频路径表

class ResourcesVideo extends CActiveRecord{

   public $id;
    public $product_id;
    public $video_path;
    public $addtime;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{resources_video}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,product_id,video_path,addtime,', 'safe'),
        );
    }

}
