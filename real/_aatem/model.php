
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: _TIME_
 */
//_HAHA_

class _MODELNAME_ extends _MODELEXTENDS_{

   _PUBLICSTR_

    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{_TABLENAMECASE_}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('_SAFESTR_', 'safe'),
        );
    }

}
