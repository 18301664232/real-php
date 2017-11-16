<?php

/**
 * 公共接口类
 */
require_once 'HttpClient.class.php';
require_once 'SendSmsByDlsw.php';

class CommonInterface extends BaseInterface {

    //给手机发短信（乐信平台）
    public static function sendMsg($phone, $code) {
        $rs = dlswSdk::sendSms(MSGNAME, MSGPWD, '您好,您的手机验证码是 ' . $code . ' (注意保管,请勿泄露) 【博世家电】', $phone);
        $rs = json_decode($rs, true);
        if ($rs['replyMsg'] == '发送成功!') {
            return array('code' => '000000', 'msg' => '发送成功');
        } else {
            return array('code' => '100000', 'msg' => '发送失败');
        }
    }

    //给手机发短信（大于阿里）
    public static function sendAliMsg($phone, $code) {
//		include "../extensions/AliMsg/TopSdk.php";
        $c = new TopClient;
        $c->appkey = AliMSGNAME;
        $c->secretKey = AliMSGPWD;
        $c->format = 'json';
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("动壹科技");
        $req->setSmsParam("{\"code\":\"$code\"}");
        $req->setRecNum("$phone");
        $req->setSmsTemplateCode("SMS_24545125");
        $rs = $c->execute($req);
        $rs = json_decode(CJSON::encode($rs), TRUE);
        if (isset($rs['result']['err_code']) && ($rs['result']['err_code'] == 0)) {
            return array('code' => '000000', 'msg' => '发送成功');
        } else {
            return array('code' => '100000', 'msg' => '发送失败');
        }
    }

    //给手机发短信（阿里云）
    public static function sendAliyunMsg($phone, $data) {
        $demo = new SmsDemo(
                "jSk0QdJ04yY2tXIT", "F4aFmrTjjM4Joo6eHOQWgm81x8rVID"
        );

        $response = $demo->sendSms(
                "动壹科技", // 短信签名
                "SMS_80445021", // 短信模板编号
                $phone, // 短信接收者
                $data //传输的数据
        );
        $response = json_decode(json_encode($response),true);
         if (isset($response['Code']) && ($response['Code'] == 'OK')) {
            return array('code' => '000000', 'msg' => '发送成功');
        } else {
            return array('code' => '100000', 'msg' => '发送失败');
        }
    }

}
?> 
