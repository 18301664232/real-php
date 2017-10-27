
<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-10-25 10:35:25
 */
//小时统计表

class StatisticsDay extends CActiveRecord{

    public $id;
    public $uv;
    public $pv;
    public $nv;
    public $register;
    public $issuance_user;
    public $total_flow;
    public $total_order;
    public $total_money;
    public $free_product;
    public $pay_product;
    public $issuance_product;
    public $search_addtime;
    public $addtime;


    //Model静态方法为必须有的方法
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //tableName方法也是必须有的方法
    public function tableName() {
        return '{{statistics_day}}';
    }

    public function primaryKey() {
        return 'id';
    }

    public function rules() {
        return array(
            array('id,uv,pv,nv,register,issuance_user,total_flow,total_order,total_money,free_product,pay_product,issuance_product,search_addtime,addtime,', 'safe'),
        );
    }

}
