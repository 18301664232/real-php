<?php

//流量
class WaterController extends CenterController {

    public $layout = 'pro'; //定义布局

    public function init() {
        parent::init();
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
    }

    public function actionIndex() {
        //预警值
        $user_id = Yii::app()->session['user']['user_id'];
        $rs = FlowServer::getNub(array('user_id' => $user_id));
        if (empty($rs['data'])) {
            //如果为空添加
            $nub = 5;
            $status = 'closed';
            FlowServer::addNub(array('user_id' => $user_id, 'nub' => $nub, 'status' => $status));
        } else {
            $nub = $rs['data']['nub'];
            $status = $rs['data']['status'];
        }
        //获取流量包
        $data = FlowServer::getUserlist(array('user_id' => $user_id));
        //删除免费流量
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if ($v['type_id'] == 1) {
                    unset($data[$k]);
                }
            }
        }
        //获取当天的修改次数
        $key = 'water_' . $user_id;
        $update_count = Yii::app()->redis->getClient()->get($key);
        if (!empty($update_count)) {
            $count = $update_count;
        } else {
            $count = 0;
        }
        
        //查询总流量消耗
        $water_all = StatisticsServer::selectall(array('user_id'=>$user_id));
     
        $water_all = Tools::formatBytes($water_all[0]['total']);

        $this->render('index', array('nub' => $nub, 'status' => $status, 'data' => $data, 'count' => $count,'water_all'=>$water_all));
    }

    //修改流量预警值
    public function actionEditnub() {
        $user_id = Yii::app()->session['user']['user_id'];
        $nub = !empty($_REQUEST['nub']) ? $_REQUEST['nub'] : '';
        if ($nub < 0 || $nub > 999)
            $this->out('100005', '参数不能为空');
        //获取当天的修改次数
        $key = 'water_' . $user_id;
        $data = Yii::app()->redis->getClient()->get($key);
        if (!empty($data)) {
            if ($data >= 5) {
                $this->out('100002', '已达上限');
            }
        } else
            $data = 0;
        $rs = FlowServer::getNub(array('user_id' => $user_id));
        if ($rs['code'] != 0)
            $this->out('100001', '修改失败');
        if ($rs['data']['nub'] == $nub)
            $this->out('0', '修改成功');


        $r = FlowServer::updateNub(array('user_id' => $user_id), array('nub' => $nub));
        if ($r['code'] == 0) {
            $data++;
            $time = strtotime(date('Ymd', strtotime('+1 day'))) - time();
            Yii::app()->redis->getClient()->set($key, $data, $time);
            $this->out('0', '修改成功');
        } else
            $this->out('100001', '修改失败');
    }

    //改变流量预警值状态
    public function actionEditstatus() {
        $user_id = Yii::app()->session['user']['user_id'];
        if (empty($user_id))
            $this->out('100005', '参数不能为空');
        $rs = FlowServer::getNub(array('user_id' => $user_id));
        if ($rs['code'] != 0)
            $this->out('100001', '修改失败');
        if ($rs['data']['status'] == 'open')
            $status = 'closed';
        else
            $status = 'open';
        $r = FlowServer::updateNub(array('user_id' => $user_id), array('status' => $status));
        if ($r['code'] == 0) {
            $this->out('0', '修改成功');
        } else
            $this->out('100001', '修改失败');
    }

    public function actionDetail() {
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        if (empty($product_id))
            $this->out('100005', '参数不能为空');
        $this->checkProduct($product_id);
        //选定时间
        $starttime = !empty($_REQUEST['starttime']) ? strtotime($_REQUEST['starttime']) : '';
        $endtime = !empty($_REQUEST['endtime']) ? strtotime($_REQUEST['endtime']) + (3600 * 24) : '';
        //固定时间
        $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        if ($type) {
            $t_rs = Tools::typetime($type);
            $starttime = $t_rs['starttime'];
            $endtime = $t_rs['endtime'];
        }
        $diff = $endtime - $starttime;
        if ($diff <= 24 * 3600 * 2) { //小于2天
            $m_time = 5;
        } elseif ($diff <= 24 * 3600 * 5) {//小于5天
            $m_time = 10;
        } elseif ($diff <= 24 * 3600 * 10) {//10
            $m_time = 30;
        } elseif ($diff <= 24 * 3600 * 20) {//20
            $m_time = 45;
        } else {//超过20天
            $m_time = 60;
        }
        $rs = StatisticsServer::Detail(array('product_id' => $product_id, 'starttime' => $starttime, 'endtime' => $endtime, 'type' => $m_time)); 
        $rs['total'] = Tools::formatBytes(array_sum($rs['y_pay'])*1024*1024);
        //如果是今天或者昨天，重写时间
        if ($type == 'today' || $type == 'ttoday') {
            $i = $starttime;
            while ($i <= $endtime) {
                $time[] = date('H:i', $i);
                $i += $m_time * 60;
            }
            $rs['time']=$time;
        }
        $this->out('0', 'ok', $rs);
    }

}
