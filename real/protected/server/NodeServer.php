<?php
/**
 * node类
 * 
 */
class NodeServer extends BaseServer
{
    //发送测试 //暂时屏蔽错误
    public static function Sendtest($params){ 
       //$r= $this->postCurl(NODE.'/package-test', json_encode(array('pid'=>$params['product_id'],'data'=>$params['str'])),true);
       dump($r);exit;
    }
    
    //发送正式  
    public static function Sendonline($params){ 
        //$this->postCurl(NODE.'/publish', json_encode(array('pid'=>$params['product_id'],'path'=>$params['path'],'link'=>$params['link'])),true);
    }
	
}