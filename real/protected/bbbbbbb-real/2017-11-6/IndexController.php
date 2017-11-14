<?php

//预览
class IndexController extends CenterController {

    public function actionIndex() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($id))
            $this->out('100005', '数据不能为空');
        //id转换成链接
        $rs = ProductServer::selectLink(array('uid' => $id));
        if ($rs['code'] != 0)
            $this->out('100004', '链接错误');
        //查看当前项目的状态是否可以访问
        $status = ProductServer::getList(['product_id'=>$rs['data'][0]['product_id']]);
        if($status['data'][0]['status'] == '已屏蔽'){
            $this->renderpartial('testerror');
            exit;

        }
        //测试链接达到20次则访问失败
        if ($rs['data'][0]['status'] == 'notonline' && Tools::isMobile()) {
            $starttime = strtotime(date('Ymd', time())) + date('H', time()) * 3600;
            $endtime = time();
            $count = StatisticsServer::getListCount(array('source_id' => $id, 'starttime' => $starttime, 'endtime' => $endtime));
            if ($count >=900) {
                $this->renderpartial('testerror');
                exit;
            }
        }
        $data['uid'] = $id;
        $data['p_size'] = $rs['data'][0]['p_size'];
        $data['status'] = $rs['data'][0]['status']; //链接状态
        $data['link'] = $rs['data'][0]['url'];
        $data['product_id'] = $rs['data'][0]['product_id'];
        $p_rs = ProductServer::getList(array('product_id' => $data['product_id']));
        $data['online'] = $p_rs['data'][0]['online'];  //项目状态
        $token = md5($data['product_id'] . time());
        //项目下线后关闭
        if ($data['online'] == 'notonline') {
            if ($data['status'] == 'online') {
                $this->renderpartial('over');
                exit;
            }
        }

        //正式链接查看流量是否用完
        if ($data['status'] == 'online' && $p_rs['data'][0]['pay'] == 'yes') {
            $list = FlowServer::getUserlist(array('user_id' => $p_rs['data'][0]['user_id'], 'status' => 'use'));
            if (empty($list) ) {
                $this->renderpartial('over');
                exit;
            }
        }

        Yii::app()->redis->getClient()->set($token, json_encode($data), 3600 * 24);
        $url = $data['link'] . '&token=' . $token. '&id='.$id. '&p_id='. $data['product_id'];
        //$url = 'http://test.realplus.cc/wteditor/browser_phone.html?'.'token=' . $token. '&id='.$id. '&pid='.$data['product_id']. '&p_link='.$url;
        //生成token用于前端
        echo '<script>';
        echo 'location.href="' . $url . '"';
        echo '</script>';
    }

    //项目监测
    public function actionCheck() {
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        if (empty($token))
            $this->Shareout('100005', '数据不能为空');
        $data = Yii::app()->redis->getClient()->get($token);
        if (!empty($data)) {
            $data = json_decode($data, true);
            $p_data = ProductServer::getList(array('product_id' => $data['product_id']));

            $url = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
            $rs_data['share'] = $this->WechatShare($url);
            $rs_data['wechat_title'] = $p_data['data'][0]['wechat_title'] ? $p_data['data'][0]['wechat_title'] : 'wxtitle';
            $rs_data['wechat_content'] = $p_data['data'][0]['wechat_content'] ? $p_data['data'][0]['wechat_content'] : 'wxcontent';
            $rs_data['wechat_img'] = $p_data['data'][0]['wechat_img'] ? REAL . UPLOAD . $p_data['data'][0]['wechat_img'] : 'http://preview.realplus.cc/icon/icon.png';
            $rs_data['wechat_link'] = 'http://test.realplus.cc/wteditor/browser_phone.html?'.'token='.$token.'&p_id='.$data['product_id'].'&p_link='.REAL . U('product/index/index') . '&id=' . $data['uid'];
            $rs_data['channel_id'] = $data['uid']; //渠道id用于记录访问pv和uv
            $rs_data['key'] = STD3DesServer::encrypt('real');
            $rs_data['ispay'] = $p_data['data'][0]['pay'];
            //监测代码
            $this->CheckCode($data, $p_data);
            //正式环境消耗流量
            if ($data['status'] == 'online') {
                //看是走付费还是免费
                $this->Water(array('user_id' => $p_data['data'][0]['user_id'], 'p_size' => $data['p_size'], 'pay' => $p_data['data'][0]['pay']));
            }
            //分享输出
            $this->Shareout('0', $rs_data);
        }
        $this->Shareout('100003', 'token错误');
    }

    public function Water($params) {
        $rs = FlowServer::useWater($params);
        if ($rs['code'] != 0)
            $this->Shareout('100004', '流量用完');
    }

    public function Shareout($code, $data) {
        $str = '';
        if ($code == 0) {
            $str .= 'var secretData = {};';
            $str .= 'secretData.weixin = {};';
            $str .= 'secretData.weixin.appId = ' . "'" . APPID . "'" . ';';
            $str .= 'secretData.weixin.timestamp = ' . "'" . $data['share']['timestamp'] . "'" . ';';
            $str .= 'secretData.weixin.nonceStr = ' . "'" . $data['share']['nonceStr'] . "'" . ';';
            $str .= 'secretData.weixin.signature = ' . "'" . $data['share']['signature'] . "'" . ';';
            $str .='secretData.weixin.title = ' . "'" . $data['wechat_title'] . "'" . ';';
            $str .='secretData.weixin.desc = ' . "'" . $data['wechat_content'] . "'" . ';';
            $str .='secretData.weixin.iconUrl = ' . "'" . $data['wechat_img'] . "'" . ';';
            $str .='secretData.weixin.shareUrl = ' . "'" . $data['wechat_link'] . "'" . ';';
            $str .='secretData.channel_id = ' . "'" . $data['channel_id'] . "'" . ';';
            $str .='secretData.key = ' . "'" . $data['key'] . "'" . ';';
            $str .='secretData.ispay = ' . "'" . $data['ispay'] . "'" . ';';
            $str .="secretData.code ='0'" . ';';
        } else {
            $str .= 'var secretData = {};';
            $str .='secretData.code =' . "'" . $code . "'" . ';';
        }
        echo $str;
        exit;
    }

    //微信分享信息
    public function WechatShare($url) {
        $timestamp = time();
        $nonceStr = $this->creatId(16);
        $ticket = WechatServer::getJsTicket();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);

        $signPackage = array(
            "appId" => APPID,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string,
        );
        return $signPackage;
    }

    //如果用户使用了代理获取IP
    private function getIp()
    {

        if(!empty($_SERVER["HTTP_CLIENT_IP"]))
        {
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        }
        else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else if(!empty($_SERVER["REMOTE_ADDR"]))
        {
            $cip = $_SERVER["REMOTE_ADDR"];
        }
        else
        {
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);

        return $cip;
    }



    //监测逻辑
    public function CheckCode($data, $p_data) {
        $check_data['user_id'] = $p_data['data'][0]['user_id'];
        $check_data['product_id'] = $p_data['data'][0]['product_id'];
        $check_data['product_name'] = $p_data['data'][0]['title'];
        $check_data['pay'] = $p_data['data'][0]['pay'];
        $check_data['source_id'] = $data['uid'];
        $rs = ProductServer::selectLink(array('uid' => $data['uid']));
        $check_data['source_name'] = $rs['data'][0]['name'];
        $check_data['p_size'] = $rs['data'][0]['p_size'];
        //$check_data['ip'] = $_SERVER["REMOTE_ADDR"] ? $_SERVER["REMOTE_ADDR"] : '';
        $check_data['ip'] = self::getIp();
        $check_data['addtime'] = time();
        $p_md5 = md5($check_data['source_id']);
        $cookie = Yii::app()->request->cookies[CHECK_REAL];
        //pv浏览次数
        //uv独立访客数
        //nv新增独立访客数
        if (!empty($cookie)) {//cookie存在
            $data_cookie = json_decode($cookie, true);
            if (array_key_exists($p_md5, $data_cookie)) {//ID存在
                if (time() - $data_cookie[$p_md5] < 3600 * 24)
                    $check_data['status'] = 'pv'; //小于一天
                else {
                    $check_data['status'] = 'uv'; //大于一天 
                    $data_cookie[$p_md5] = time();
                    $data_cookie = json_encode($data_cookie);
                    $this->setCookie(CHECK_REAL, $data_cookie, 3600 * 24 * 30);
                }
            } else { //ID不存在
                $check_data['status'] = 'nv';
                $data_cookie[$p_md5] = time();
                $data_cookie = json_encode($data_cookie);
                $this->setCookie(CHECK_REAL, $data_cookie, 3600 * 24 * 30);
            }
        } else { //没有cookie
            $check_data['status'] = 'nv';
            $data_cookie[$p_md5] = time();
            $data_cookie = json_encode($data_cookie);
            $this->setCookie(CHECK_REAL, $data_cookie, 3600 * 24 * 30);
        }
        StatisticsServer::addStat($check_data);
    }

}
