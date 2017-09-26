<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ALL);




class PayNotifyCallBack
{
	//查询订单
	public function Queryorder()
	{
		
		
$result = ' {
        "appid": "wx80460a89c5dea15c",
        "attach": "G3inQsRTr0f",
        "bank_type": "CFT",
        "cash_fee": "1",
        "fee_type": "CNY",
        "is_subscribe": "Y",
        "mch_id": "1228863302",
        "nonce_str": "94L3gat5LZa9Ahkp",
        "openid": "o8crFt_oOb7b82hQsQmpWuP3G-q4",
        "out_trade_no": "122886330220170428125452",
        "result_code": "SUCCESS",
        "return_code": "SUCCESS",
        "return_msg": "OK",
        "sign": "1E42599CED8F5FBE4C048BFD57168CC2",
        "time_end": "20170428125511",
        "total_fee": "1",
        "trade_state": "SUCCESS",
        "trade_type": "NATIVE",
        "transaction_id": "4001642001201704288650185637"
    }';
		//提交后台逻辑处理
		$post = json_decode($result,true);
		
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
		print_r($data);
	
	}
	

}


$notify = new PayNotifyCallBack(); 
$notify->Queryorder();
