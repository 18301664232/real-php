<?php
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once "WxPay.NativePay.php";
require_once 'log.php';

//模式一
/**
 * 流程：
 * 1、组装包含支付信息的url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、确定支付之后，微信服务器会回调预先配置的回调地址，在【微信开放平台-微信支付-支付配置】中进行配置
 * 4、在接到回调通知之后，用户进行统一下单支付，并返回支付信息以完成支付（见：native_notify.php）
 * 5、支付完成之后，微信服务器会通知支付成功
 * 6、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
 $notify = new NativePay();
// $url1 = $notify->GetPrePayUrl("123456789");

//模式二
/**
 * 流程：
 * 1、调用统一下单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，微信服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */
$data = !empty($_REQUEST['data'])?$_REQUEST['data']:'';
if(empty($data)){
	echo json_encode(array('code'=>100005,'msg'=>'数据不能为空','url'=>''));
	exit;
}

$data = json_decode($data,true);
$info = $data['data']['order_no'];
$money = $data['data']['money']*100;
$money = 1;
$input = new WxPayUnifiedOrder();
$input->SetBody("RealApp流量包"); //商品描述
$input->SetAttach($info); //附加数据，在查询API和支付通知中原样返回，可作为自定义参数使用。
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis")); //商户系统内部订单号，要求32个字符内、且在同一个商户号下唯一。 详见商户订单号
$input->SetTotal_fee($money); //金额
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 1800));
//$input->SetGoods_tag("test"); //商品标记，使用代金券或立减优惠功能时需要的参数，说明详见代金券或立减优惠
$input->SetNotify_url("http://test.realplus.cc/wxzf/example/notify.php");
$input->SetTrade_type("NATIVE");
$input->SetProduct_id($info); //trade_type=NATIVE时（即扫码支付），此参数必传。此参数为二维码中包含的商品ID，商户自行定义。
$result = $notify->GetPayUrl($input);
if(isset($result["code_url"])){
	$url2 = $result["code_url"];
	echo json_encode(array('code'=>0,'url'=>$url2));exit;
}else{
	echo json_encode(array('code'=>100001,'url'=>'','msg'=>''));exit;
}

?>
