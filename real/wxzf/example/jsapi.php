<?php 
header("Content-type: text/html; charset=utf-8"); 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);


$tools = new JsApiPay();
$openId = $tools->GetOpenid();
$state = !empty($_GET['state'])?$_GET['state']:'';
$price =1;
$arr = explode(",",$state); 
$nub =$arr[0];
$spread = isset($arr[1])?$arr[1]:'';
$tools->check($nub,$openId);

//统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("mone支付1");  //设置商品或支付单简要描述（用于付款成功后提示）
$input->SetAttach($state); //设置附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis")); // 设置商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
$input->SetTotal_fee($price);//金额
$input->SetTime_start(date("YmdHis"));//时间
$input->SetTime_expire(date("YmdHis", time() + 600)); //超过时间
$input->SetGoods_tag("mone支付3"); //设置商品标记，代金券或立减优惠功能的参数，说明详见代金券或立减优惠
$input->SetNotify_url("http://test.realplus.cc/wxzf_mone/index.php"); //访问地址
$input->SetTrade_type("JSAPI"); //类型
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input); 
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付</title>
    <script type="text/javascript">
	
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg); 
				if(res.err_msg=='get_brand_wcpay_request:ok'){
					alert('付款成功');
				}else{
					alert('付款失败');
				}
			}
		);
	}
	
	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false); 
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); alert('bb');
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();alert('cc');
		}
	}
	callpay();
	</script>
</head>