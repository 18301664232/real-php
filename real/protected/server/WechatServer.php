<?php

//
class WechatServer extends BaseServer {
    /*
      $params[appid]	必传   appid
      $params[secret]	必传   secret
      $params[code]	必传   code
      $params[state]	必传   state

     */

    public static function openid($params) {
        $res = self::getWebtoken($params['code'], $params['state'], $params['appid'], $params['secret']);
        //刷新access_token
        $res = self::refWebtoken($params['appid'], $res['refresh_token']);
        //检验授权凭证（access_token）是否有效
        $check = self::checkToken($res['access_token'], $res['openid']);
        //获取用户信息
        $list = self::getWebuserinfo($res['access_token'], $res['openid']);
        return $list;
    }

    //获取access_token
    public static function getWebtoken($code, $state, $appid, $secret) {
        $res = WxInterface::getWebtoken($code, $state, $appid, $secret);
        if (!isset($res['access_token'])) {
            echo 'error1';
            exit;
        } else
            return $res;
    }

    //刷新access_token
    public static function refWebtoken($appid, $refresh_token) {
        $res = WxInterface::refWebtoken($appid, $refresh_token);
        if (!isset($res['access_token'])) {
            echo 'error2';
            exit;
        } else
            return $res;
    }

    //检验授权凭证（access_token）是否有效
    public static function checkToken($access_token, $openid) {
        $res = WxInterface::checkToken($access_token, $openid);
        if ($res['errcode'] != 0) {
            echo 'error3';
            exit;
        }
    }

    //获取用户信息
    public static function getWebuserinfo($access_token, $openid) {
        $res = WxInterface::getWebuserinfo($access_token, $openid);
        if (!isset($res['openid'])) {
            echo 'error4';
            exit;
        } else
            return $res;
    }

    //获取access_token
    public static function getAccessToken() {
        $res = WxInterface::getAccessToken();
        if (!isset($res['access_token'])) {
            echo 'error5';
            exit;
        } else
            return $res['access_token'];
    }

    //获取js_ticket
    public static function getJsTicket() {
        $token = self::getAccessToken();
        $res = WxInterface::getJsTicket($token);
        if (!isset($res['ticket'])) {
            echo 'error6';
            exit;
        } else
            return $res['ticket'];
    }

}
