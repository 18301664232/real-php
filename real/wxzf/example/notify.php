<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once "WxPay.JsApiPay.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		file_put_contents(dirname(__FILE__).'/../log.php',json_encode($result).PHP_EOL,FILE_APPEND);
		Log::DEBUG("query:" . json_encode(array('data'=>$result)));
		//提交后台逻辑处理
		$post = json_decode(json_encode($result),true);
		$url = 'http://test.realplus.cc/?r=finance/pay/ok';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); //The URL to fetch.
		curl_setopt($ch, CURLOPT_HEADER, 0); //TRUE to include the header in the output.
		if($post)
		{
			curl_setopt($ch, CURLOPT_POST, 1); //TRUE to do a regular HTTP POST
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); //The full data to post in a HTTP "POST" operation.
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); //TRUE to return the raw output
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); //The maximum number of seconds to allow CURL functions to execute.
	
		$data = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($data,true);
			
		if($data['code']==0){
			return true;
		}else{
			return false;
		}
		/* if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			//成功推送
			
			
			return true;
		}
		//失败推送
		
		return false; */
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{ 
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack(); 
$notify->Handle(false);
