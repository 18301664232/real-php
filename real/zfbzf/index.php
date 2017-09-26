<?php

require_once("AopSdk.php");
$data = !empty($_REQUEST['data'])?$_REQUEST['data']:'';
$connection = new mysqli("10.161.28.82","root","MoneplusDataBs11","real_test"); 
$connection->set_charset('utf8');
$query="select * from r_order_info where `order_no` = '$data'"; 

	$result=$connection->query($query);  
	if($result->num_rows==0){ 
		$restul['code'] = 100001;
		$restul['msg'] = '无效订单号';
		echo json_encode($restul);exit;
	}
        $rs =$result->fetch_assoc();
        if($rs['status']=='yes'){
           $restul['code'] = 100002;
           $restul['msg'] = '订单已经支付支付过';
           echo json_encode($restul);exit;
        } 
        $list = array(
            'product_code'=>'FAST_INSTANT_TRADE_PAY',
            'out_trade_no'=>$data,
            'subject'=>'RealApp流量包',
            //'total_amount'=>$rs['money'],
             'total_amount'=>0.01,
            'qr_pay_mode'=>4,
            'qrcode_width'=>124,
            'timeout_express'=>'30m'
        );
        $list = json_encode($list);

$aop = new AopClient ();
$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
$aop->appId = '2017051507248193';
$aop->rsaPrivateKey = 'MIIEowIBAAKCAQEA0Wejgg9sx4ibpMiwS7iazUn42WO4p2H48ormM/dIv72/myy2S/3X1fltMIiq+f+AwgSyKF8Yba7iIZlpKjPu/ZX35LQF8EATrK97dtRGU5EQL8de1A+GgMamG8MO4WFfHIIKXE8gx/kmFhcJEJYpnVAnXsqa8RjqW9F7mwbwmQcNs6ClokJkcD3X5o1IdSeFT0NFlt5M43muplbLXNmbODRsZnzVnnmz4YVPnlJ4lXhSIXZsDqo3xw+6hbisyYo3A09Ec5hmMQDoQz64mYzChhFVXoOV+k4iXm8Cdt5IHM0XU8pORiSRTAcEbEgYzhRDBDQ7jV4kGs7+3P+0JvUnnwIDAQABAoIBAGR19RKDdetwFUOD6Fgbc2DDeThJyB+9N+KcUn5hxyv9yzuVwstIN9D2vbSIDIatVkc+W35UyPJt8Ryvba2KhsBvvyKgXyz4gLfa5D+I7UhQEtTpMAxKenuzUaOF+9CSlz+k/3VznMVzORtl57pmYAaRmqG2T4kVK/Hq2QLx3GF9CtrVodZB9KhPBDr+YFEKueeqbwbOxpkJgs43Lwm1zoCLjpdINIMzlmMxaLah3H67r9/jraX8y4iYgy3JKxxqExTD6drveTPC6FyA6T7BMLvspWP/ZoYbFfMoN6ZXsxzPOp/q6E2I53Wl1UpB92EPEEWrBUma4zt1ZnrNPqwY0bECgYEA+9/TjldUObTWjGh1bE4YZnbtkzSj5CiW4r0g1LbrcyryAFhI3QQM2XwL2towKstU8nh5ES4cWklmxUeYANugVV0gaylaN3lM/grBpJ2pQPpTdkb1K+COK8DiuyglfzlujwuGzL/LzA/U7W5JApjNl+KEAN+UPrGWULD4whmr/qcCgYEA1NW6FOAW8aUKGDAxBmx0ebekE5NaFD9qi46Wer2Rh1Zmko+5I5dF+i96DzUtFUkp6C0gIEe8sfFo3Th9iN04czFh+AUhAft0FCybWloTE780pda2l5ZOB1JBXx51vvmUGLlto+XQEg15H4ha93iRaVgywfs+iwmcMfwnLUBVZkkCgYBgQfwBzBIeM6RC6LDngTkF/7FvrpBr4682W/0uDfIRg3oU86h0/tVCUIvfSb9au3Zta+kozax8PM0P2/qVaVnvBbYb/iPCS5NHCylSFgbXFFPNQfT0nc73nbGIwSEDbBl6hXcwzKPACtTfIGS6n1cDEshL5SYsh4XgtKF83H7ExQKBgQCyzBnXD6o2tn8Ucue8jcALwMqF53P1LpFDTDX+RuLK3zqsRTEzRRH0a44O2I1XJG+gLMigVaOfmT6PGbXcFHwnyYST5zsjfyq1CAQ6kxETtb101DvwfMRwQhnI3r3sAZ74Zk5FMfrqL4dhhhtlalQ+O2norDiOdTRSiZIf4bvcgQKBgCltAXWXqMaUiWnqy3hsDCtloMVrQcUlOjRtZOLee11ap/PJRZxRkMePLTl7hHJx7GAzbTQuqBI/ES0d5/bE+gWHPUXpn85NPYAKpUDpQMus/5hB3GEtlJkilO4dJh8X0WAZLrr5CJGV7EoNaTjlIqaAAmGGw8laX96u+7UQ6oYi';
$aop->apiVersion = '1.0';
$aop->signType = 'RSA';
$aop->postCharset= 'utf-8';
$aop->format='json';
$request = new AlipayTradePagePayRequest ();
//$request->setReturnUrl('http://www.baidu.com');
$request->setNotifyUrl('http://test.realplus.cc/zfbzf/select.php');
$request->setBizContent($list);
 

$result = $aop->pageExecute ($request); 
 

echo $result;