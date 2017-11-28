<?php

/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017/9/6
 * Time: 14:38
 *
 *
 */
//加载GatewayClient。关于GatewayClient参见本页面底部介绍
require_once '__DIR__/../../../GatewayClient-master/Gateway.php';
// GatewayClient 3.0.0版本开始要使用命名空间
use GatewayClient\Gateway;




class MyyController extends BaseController

{
    public $layout='admin';

    public function actionList(){


        $this->render('list');
    }


    public function actionQuanxian(){

      // $rs = AdminServer::getPromissionsList(['2']);
        //dump(AuthServer::getRolePermissionsList(['\'超级管理员\''])['data']);
        //dump(AuthServer::getRolePermissionsList([]));

    }


    public function actionLi(){

// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
        Gateway::$registerAddress = '127.0.0.1:1238';
    $client_id = $_REQUEST['client_id'];
// 假设用户已经登录，用户uid和群组id在session中
       // $uid      = $_SESSION['uid'];
       // $group_id = $_SESSION['group'];
        $uid      = 999;
       // $group_id = $_SESSION['group'];
// client_id与uid绑定
        Gateway::bindUid($client_id, $uid);
// 加入某个群组（可调用多次加入多个群组）
       // Gateway::joinGroup($client_id, $group_id);


    }


    public function actionLi2(){
// 设置GatewayWorker服务的Register服务ip和端口，请根据实际情况改成实际值
        Gateway::$registerAddress = '127.0.0.1:1238';

// 向任意uid的网站页面发送数据
        Gateway::sendToUid(999, '发送成功');
// 向任意群组的网站页面发送数据
       // Gateway::sendToGroup($group, $message);

    }




}