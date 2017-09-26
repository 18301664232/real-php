<?php

//前端个人中心控制器

class CenterController extends BaseController {

    //跨域源资源共享
    public function init() {
        parent::init();
          //获取剩余流量
        $water = FlowServer::getUserresidue(array('user_id' => Yii::app()->session['user']['user_id'], 'pay' => 'yes')) / (1024 * 1024 * 1024);
        if ($water < 10) {
            $water = number_format($water, 2, '.', '').'G';
        } else if($water > 1024){
            $water = ceil($water/1024).'T';
        } else{
            $water = ceil($water).'G';
        }

        Yii::app()->session['water_count'] = $water;
    }

    //生成产品id
    public function creatId($nub = 10) {
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789QWERTYUIOPASDFGHJKLZXCVBNM';
        $code = '';
        for ($i = 0; $i < $nub; $i++) {
            $code .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $code;
    }

    //判断权限
    public function checkProduct($product_id) {
        $rs = ProductServer::getList(array('product_id' => $product_id));
        if ($rs['code'] != 0) {
            $this->out('100003', '非法操作');
        } else {
            if ($rs['data'][0]['user_id'] != Yii::app()->session['user']['user_id'])
                $this->out('100003', '非法操作');
            return $rs['data'][0];
        }
    }

    //给socket发消息
    public function sendSocket($key, $msg) {
        $data = array('key' => $key, 'msg' => $msg);
        $this->postCurl("http://10.45.36.182:3281/", json_encode($data));
    }

}
