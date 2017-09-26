<?php

//支付
class PayController extends CenterController {

    public $layout = 'pro'; //定义布局

    public function init() {
        parent::init();
        //删除超时订单
        $time = time() - 3600 * 24;
        FlowServer::delTypeOrder(array('user_id' => Yii::app()->session['user']['user_id'], 'addtime' => $time));
    }

    //选择
    public function actionSelect() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $rs = FlowServer::getType(array('pay' => 'yes'));

        $this->render('select', array('data' => $rs['data']));
    }

    //结算
    public function actionPay() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $rs = '';
        //订单支付
        if (!empty($token)) {
            $data = Yii::app()->redis->getClient()->get($token);
            if (!empty($data)) {
                $data = substr($data, 1, -1);
                $arr = explode(',', $data);
                foreach ($arr as $k => $v) {
                    if (!empty($v)) {
                        $r = FlowServer::getType(array('id' => $v));
                        $rs[] = $r['data'][0];
                    }
                }
            }
        }
        //历史订单支付
        $order = !empty($_REQUEST['order']) ? $_REQUEST['order'] : '';
        if (!empty($order)) {
            $rs = FlowServer::getTypeOrder(array('order_no_id' => $order));
        }

        $this->render('pay', array('data' => $rs));
    }

    //结束中间页
    public function actionPayinfo() {
        $data = !empty($_REQUEST['data']) ? $_REQUEST['data'] : '';
        $token = $this->tokenCreate();
        Yii::app()->redis->getClient()->set($token, json_encode($data), 3600 * 24);
        echo $token;
    }

    //生成订单（事物）
    public function actionCreatinfo() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $data = !empty($_REQUEST['data']) ? $_REQUEST['data'] : '';
        $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : '';
        if (empty($data) || empty($status))
            $this->out('100005', '数据不能为空');
        $data = json_decode($data, true);
        $params['order_no'] = $this->creatId(11);
        $params['user_id'] = Yii::app()->session['user']['user_id'];
        $params['detail'] = '';
        $params['status'] = 'no';
        $params['addtime'] = time();
        $params['money'] = 0;
        if ($status == 'wx') {
            $params['type'] = '微信';
        } elseif ($status == 'zfb') {
            $params['type'] = '支付宝';
        }
        //开启事物处理
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($data as $k => $v) {
                if (!empty($v)) {
                    $arr = explode(',', $v);
                    //查询
                    $rs = FlowServer::getType(array('id' => $arr[0]));
                    if ($rs['code'] == 0) {
                        //插入中间表
                        $params_select['order_no_id'] = $params['order_no'];
                        $params_select['flow_type_id'] = $arr[0];
                        $params_select['name'] = $rs['data'][0]['name'];
                        $params_select['count'] = $arr[1];
                        $params_select['addtime'] = time();
                        $add_rs = FlowServer::addTypeOrder($params_select);
                        if ($add_rs['code'] != 0) {
                            throw new CException('添加中间表失败', 100001);
                        }
                        $params['detail'] .=$rs['data'][0]['name'] . '/';
                        $params['money'] += $rs['data'][0]['money'] * $params_select['count'];
                    }
                }
            }
            //插入订单表
            $add_rs = FlowServer::addOrder($params);
            if ($add_rs['code'] != 0) {
                throw new CException('添加订单表失败', 100002);
            }

            //判断是微信还是支付宝
            if ($status == 'wx') {
                //生成二维码链接
                $datas = json_encode(array('data' => array('money' => $params['money'], 'order_no' => $params['order_no'])));
                $url = REAL . '/wxzf/example/native.php?data=' . $datas;
                $rdata = $this->postCurl($url);
                $rdata = json_decode($rdata, true);
                if ($rdata['code'] != 0) {
                    throw new CException('生成支付二维码失败', 100003);
                }
                $transaction->commit();
                $this->out('1', 'ok', array('total' => $params['money'], 'url' => $rdata['url'], 'order_no' => $params['order_no']));
            } elseif ($status == 'zfb') {
                $transaction->commit();
                $this->out('2', 'ok', array('total' => $params['money'], 'order_no' => $params['order_no']));
            }
        } catch (Exception $e) {
            $transaction->rollback();
            $this->out($e->getCode(), $e->getMessage());
        }
    }

    //接受微信支付消息（事物）
    public function actionOk() {
        $result = !empty($_REQUEST) ? $_REQUEST : '';
        file_put_contents('wxzf_log.php', json_encode($result) . PHP_EOL, FILE_APPEND);
        //  $result = json_decode($result,true);
        if (empty($result))
            $this->out('100005', '数据不能为空');
        if (array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
            //成功修改订单状态
            //查询订单
            $rs = FlowServer::getOrder(array('order_no' => $result['attach']));
            if ($rs['code'] == 0) {
                //开启事物处理
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $update_rs = FlowServer::updateOrder(array('order_no' => $result['attach']), array('status' => 'yes', 'paytime' => time()));
                    if ($update_rs['code'] != 0) {
                        throw new CException('修改失败', 100001);
                    }

                    //生成流量包getOrder
                    $list = FlowServer::getOrderTypeOrderList(array('order_no_id' => $result['attach']));
                    foreach ($list['data'] as $k => $v) {
                        for ($i = 0; $i < $v['count']; $i++) {
                            //print_r(array('user_id'=>$rs['data'][0]['user_id'],'type_id'=>$v['flow_type_id'],'status'=>'use','use_water'=>0,'addtime'=>addtime()));
                            $data['user_id'] = $rs['data'][0]['user_id'];
                            $data['type_id'] = $v['flow_type_id'];
                            $data['status'] = 'use';
                            $data['use_water'] = 0;
                            $data['addtime'] = time();
                            $add_rs = FlowServer::addFlow($data);
                            if ($add_rs['code'] != 0) {
                                throw new CException('添加失败', 100002);
                            }
                        }
                    }
                    $transaction->commit();
                    $this->sendSocket($result['attach'], array('code' => '0', 'data' => 'ok'));
                    $this->out('0', 'ok');
                } catch (Exception $e) {
                    $transaction->rollback();
                    $this->sendSocket($result['attach'], array('code' => '0', 'data' => $e->getMessage()));
                    $this->out($e->getCode(), $e->getMessage());
                }
            }
        }



        $this->sendSocket($result['attach'], array('code' => '0', 'data' => 'error'));
        $this->out('100001', 'error');
    }

    //接受支付宝支付消息（事物）
    public function actionOkzfb() {
        $result = !empty($_REQUEST) ? $_REQUEST : '';
        file_put_contents('zfb_log.php', json_encode($result) . PHP_EOL, FILE_APPEND);
//        $result = '{"r":"finance\/pay\/okzfb","code":"10000","msg":"Success","buyer_logon_id":"wda***@sina.com","buyer_pay_amount":"0.00","buyer_user_id":"2088812734232990","invoice_amount":"0.00","open_id":"20881076829789475916604520313299","out_trade_no":"SFGmdxl2fRE","point_amount":"0.00","receipt_amount":"0.00","send_pay_date":"2017-05-19 15:30:09","total_amount":"0.01","trade_no":"2017051921001004990256197555","trade_status":"TRADE_SUCCESS"}';
//        $result = json_decode($result,true);

        if (empty($result))
            $this->out('100005', '数据不能为空');
        if ($result["msg"] == "Success" && $result["code"] == "10000") {
            //成功修改订单状态
            //查询订单
            $rs = FlowServer::getOrder(array('order_no' => $result['out_trade_no']));
            if ($rs['code'] == 0) {
                //开启事物处理
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $update_rs = FlowServer::updateOrder(array('order_no' => $result['out_trade_no']), array('status' => 'yes', 'paytime' => time()));
                    if ($update_rs['code'] != 0) {
                        throw new CException('修改失败', 100001);
                    }

                    //生成流量包getOrder
                    $list = FlowServer::getOrderTypeOrderList(array('order_no_id' => $result['out_trade_no']));
                    foreach ($list['data'] as $k => $v) {
                        for ($i = 0; $i < $v['count']; $i++) {
                            //print_r(array('user_id'=>$rs['data'][0]['user_id'],'type_id'=>$v['flow_type_id'],'status'=>'use','use_water'=>0,'addtime'=>addtime()));
                            $data['user_id'] = $rs['data'][0]['user_id'];
                            $data['type_id'] = $v['flow_type_id'];
                            $data['status'] = 'use';
                            $data['use_water'] = 0;
                            $data['addtime'] = time();
                            $add_rs = FlowServer::addFlow($data);
                            if ($add_rs['code'] != 0) {
                                throw new CException('添加失败', 100002);
                            }
                        }
                    }
                    $transaction->commit();
                    $this->sendSocket($result['out_trade_no'], array('code' => '0', 'data' => 'ok'));
                    $this->out('0', 'ok');
                } catch (Exception $e) {
                    $transaction->rollback();
                    $this->sendSocket($result['out_trade_no'], array('code' => '0', 'data' => $e->getMessage()));
                    $this->out($e->getCode(), $e->getMessage());
                }
            }
        }

        $this->sendSocket($result['out_trade_no'], array('code' => '0', 'data' => 'error'));
        $this->out('100001', 'error');
    }

    //历史订单
    public function actionList() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $params['user_id'] = Yii::app()->session['user']['user_id'];
        $rs = FlowServer::getOrder($params);

        $this->render('list', array('data' => $rs['data']));
    }

    //成功跳转
    public function actionSus() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));

        $this->render('sus');
    }

}
