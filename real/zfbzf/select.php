<?php

require_once("AopSdk.php");

$data = !empty($_REQUEST)?$_REQUEST:'';
$list = array(
	'out_trade_no'=>$data['out_trade_no'],
	'trade_no'=>$data['trade_no']
);

$list = json_encode($list);

$aop = new AopClient ();
$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
$aop->appId = '2017051507248193';
$aop->rsaPrivateKey = 'MIIEowIBAAKCAQEA0Wejgg9sx4ibpMiwS7iazUn42WO4p2H48ormM/dIv72/myy2S/3X1fltMIiq+f+AwgSyKF8Yba7iIZlpKjPu/ZX35LQF8EATrK97dtRGU5EQL8de1A+GgMamG8MO4WFfHIIKXE8gx/kmFhcJEJYpnVAnXsqa8RjqW9F7mwbwmQcNs6ClokJkcD3X5o1IdSeFT0NFlt5M43muplbLXNmbODRsZnzVnnmz4YVPnlJ4lXhSIXZsDqo3xw+6hbisyYo3A09Ec5hmMQDoQz64mYzChhFVXoOV+k4iXm8Cdt5IHM0XU8pORiSRTAcEbEgYzhRDBDQ7jV4kGs7+3P+0JvUnnwIDAQABAoIBAGR19RKDdetwFUOD6Fgbc2DDeThJyB+9N+KcUn5hxyv9yzuVwstIN9D2vbSIDIatVkc+W35UyPJt8Ryvba2KhsBvvyKgXyz4gLfa5D+I7UhQEtTpMAxKenuzUaOF+9CSlz+k/3VznMVzORtl57pmYAaRmqG2T4kVK/Hq2QLx3GF9CtrVodZB9KhPBDr+YFEKueeqbwbOxpkJgs43Lwm1zoCLjpdINIMzlmMxaLah3H67r9/jraX8y4iYgy3JKxxqExTD6drveTPC6FyA6T7BMLvspWP/ZoYbFfMoN6ZXsxzPOp/q6E2I53Wl1UpB92EPEEWrBUma4zt1ZnrNPqwY0bECgYEA+9/TjldUObTWjGh1bE4YZnbtkzSj5CiW4r0g1LbrcyryAFhI3QQM2XwL2towKstU8nh5ES4cWklmxUeYANugVV0gaylaN3lM/grBpJ2pQPpTdkb1K+COK8DiuyglfzlujwuGzL/LzA/U7W5JApjNl+KEAN+UPrGWULD4whmr/qcCgYEA1NW6FOAW8aUKGDAxBmx0ebekE5NaFD9qi46Wer2Rh1Zmko+5I5dF+i96DzUtFUkp6C0gIEe8sfFo3Th9iN04czFh+AUhAft0FCybWloTE780pda2l5ZOB1JBXx51vvmUGLlto+XQEg15H4ha93iRaVgywfs+iwmcMfwnLUBVZkkCgYBgQfwBzBIeM6RC6LDngTkF/7FvrpBr4682W/0uDfIRg3oU86h0/tVCUIvfSb9au3Zta+kozax8PM0P2/qVaVnvBbYb/iPCS5NHCylSFgbXFFPNQfT0nc73nbGIwSEDbBl6hXcwzKPACtTfIGS6n1cDEshL5SYsh4XgtKF83H7ExQKBgQCyzBnXD6o2tn8Ucue8jcALwMqF53P1LpFDTDX+RuLK3zqsRTEzRRH0a44O2I1XJG+gLMigVaOfmT6PGbXcFHwnyYST5zsjfyq1CAQ6kxETtb101DvwfMRwQhnI3r3sAZ74Zk5FMfrqL4dhhhtlalQ+O2norDiOdTRSiZIf4bvcgQKBgCltAXWXqMaUiWnqy3hsDCtloMVrQcUlOjRtZOLee11ap/PJRZxRkMePLTl7hHJx7GAzbTQuqBI/ES0d5/bE+gWHPUXpn85NPYAKpUDpQMus/5hB3GEtlJkilO4dJh8X0WAZLrr5CJGV7EoNaTjlIqaAAmGGw8laX96u+7UQ6oYi';
$aop->alipayrsaPublicKey='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA0Wejgg9sx4ibpMiwS7iazUn42WO4p2H48ormM/dIv72/myy2S/3X1fltMIiq+f+AwgSyKF8Yba7iIZlpKjPu/ZX35LQF8EATrK97dtRGU5EQL8de1A+GgMamG8MO4WFfHIIKXE8gx/kmFhcJEJYpnVAnXsqa8RjqW9F7mwbwmQcNs6ClokJkcD3X5o1IdSeFT0NFlt5M43muplbLXNmbODRsZnzVnnmz4YVPnlJ4lXhSIXZsDqo3xw+6hbisyYo3A09Ec5hmMQDoQz64mYzChhFVXoOV+k4iXm8Cdt5IHM0XU8pORiSRTAcEbEgYzhRDBDQ7jV4kGs7+3P+0JvUnnwIDAQAB';
$aop->apiVersion = '1.0';
$aop->signType = 'RSA';
$aop->postCharset= 'utf-8';
$aop->format='json';

$request = new AlipayTradeQueryRequest();

$request->setBizContent($list);

$result = $aop->execute($request);  
$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";

$result = $result->$responseNode;
//$resultCode = $result->$responseNode->code;

// if(!empty($resultCode)&&$resultCode == 10000){
// echo "成功";
// } else {
// echo "失败";
// }

file_put_contents(dirname(__FILE__).'/log.php',json_encode($result).PHP_EOL,FILE_APPEND);

//提交后台逻辑处理
$post = json_decode(json_encode($result),true);
$url = 'http://test.realplus.cc/?r=finance/pay/okzfb';

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
	echo "成功";
}else{
	echo "失败";
}