<?php

//微信接口类 
class WxInterface extends BaseInterface {

    public static function getMsg($data) {
        if (!empty($data)) {
            //获取的xml转成对象，方便使用
            $result = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
            //XML转数组
            $result = json_decode(json_encode($result), TRUE);
            return $result;
        } else
            return false;
    }

    public static function getWebtoken($code, $state, $appid, $secret) {
        $_api = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
        $_json = self::curlOpen($_api);
        $_json = json_decode($_json, true);
        return $_json;
    }

    public static function refWebtoken($appid, $refresh_token) {
        $_api = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$appid&grant_type=refresh_token&refresh_token=$refresh_token";
        $_json = self::curlOpen($_api);
        $_json = json_decode($_json, true);
        return $_json;
    }

    public static function getWebuserinfo($access_token, $openid) {
        $_api = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
        $_json = self::curlOpen($_api);
        $_json = json_decode($_json, true);
        return $_json;
    }

    public static function checkToken($access_token, $openid) {
        $_api = "https://api.weixin.qq.com/sns/auth?access_token=$access_token&openid=$openid";
        $_json = self::curlOpen($_api);
        $_json = json_decode($_json, true);
        return $_json;
    }

    public static function getAccessToken() {
        $_api = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . APPID . '&secret=' . APPSECRET;
        $_json = self::curlOpen($_api);
        $_json = json_decode($_json, true);
        return $_json;
    }

    public static function getJsTicket($token) {
        $_api = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$token";
        $_json = self::curlOpen($_api);
        $_json = json_decode($_json, true);
        return $_json;
    }

}
