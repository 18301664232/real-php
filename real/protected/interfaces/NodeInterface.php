<?php

/**
 * node类
 * 
 */
class NodeInterface extends BaseInterface {

    //发送测试    
    public static function Sendtest($params) {
        self::postCurl(NODE . '/package-test', json_encode(array('pid' => $params['product_id'], 'data' => $params['str'], 'type' => $params['type'] ,'p_color' => $params['color'])), true, 1);
       // self::postCurl(NODE . '/package-test', json_encode(array('pid' => 123456, 'data' => 123456, 'type' => $params['type'] ,'color' => $params['color'])), true, 1);
    }

    //发送正式  
    public static function Sendonline($params) {
        self::postCurl(NODE . '/publish', json_encode(array('pid' => $params['product_id'], 'path' => $params['path'], 'link' => $params['link'] )), true, 1);
    }

}
