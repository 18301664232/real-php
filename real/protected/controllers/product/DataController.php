<?php

//数据添加
class DataController extends CenterController {

    public function actionIndex() {
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : ''; //userdata 用户提交  //page 页面事件   //button 按钮事件
        if (empty($type) || empty($token))
            $this->out('100005', '数据不能为空');
        $data = Yii::app()->redis->getClient()->get($token);
        if (empty($data)) {
            $this->out('100003', 'token错误');
        }
        $data = json_decode($data, true);
        //用户提交数据追加
        if ($type == 'userdata') {
            $params['data'] = !empty($_REQUEST['data']) ? $_REQUEST['data'] : '';  //提交数据
            $params['button_id'] = !empty($_REQUEST['button']) ? $_REQUEST['button'] : ''; //按钮id
            $params['button_name'] = !empty($_REQUEST['button_name']) ? $_REQUEST['button_name'] : '';
            $params['page'] = !empty($_REQUEST['page']) ? $_REQUEST['page'] : '';
            if (empty(json_decode($params['data'], true)) || empty($params['button_id']))
                $this->out('100005', '数据不能为空');
            $params['product_id'] = $data['product_id'];
            $params['status'] = $data['status'];  //项目状态
            $params['source_id'] = $data['uid'];  //渠道id
            $params['addtime'] = time();
            $this->UserData($params);
        } elseif ($type == 'page') { //页面事件
            $params['page_name'] = !empty($_REQUEST['page_name']) ? $_REQUEST['page_name'] : ''; //页面名字
            $params['page_time'] = 0; //页面停留时间默认为0
            $params['browse_status'] = !empty($_REQUEST['status']) ? $_REQUEST['status'] : 'pv'; //pv还是uv
            $params['page'] = !empty($_REQUEST['page']) ? $_REQUEST['page'] : '';
            if (empty($params['page_name']))
                $this->out('100005', '数据不能为空');
            $params['product_id'] = $data['product_id'];
            $params['status'] = $data['status'];  //项目状态
            $params['source_id'] = $data['uid'];  //渠道id
            $params['addtime'] = time();
            $this->Page($params);
        } elseif ($type == 'button') {  //按钮事件
            $params['button_name'] = !empty($_REQUEST['button_name']) ? $_REQUEST['button_name'] : ''; //按钮名字
            $params['page'] = !empty($_REQUEST['page']) ? $_REQUEST['page'] : '';
            $params['browse_status'] = !empty($_REQUEST['status']) ? $_REQUEST['status'] : 'pv'; //pv还是uv
            if (empty($params['button_name']))
                $this->out('100005', '数据不能为空');
            $params['product_id'] = $data['product_id'];
            $params['status'] = $data['status'];  //项目状态
            $params['source_id'] = $data['uid'];  //渠道id
            $params['addtime'] = time();
            $this->Button($params);
        }elseif ($type == 'page_time') {
            //修改一条对应项目id和渠道、页面的数据
            $page_time = !empty($_REQUEST['page_time']) ? $_REQUEST['page_time'] : 0;
            $params['page'] = !empty($_REQUEST['page']) ? $_REQUEST['page'] : '';
            $params['source_id'] = $data['uid'];  //渠道id
            $params['product_id'] = $data['product_id'];
            $params['page_time'] = 0;
            $this->UpdatePageTime($params,$page_time);
        } else {
            $this->out('100008', '类型错误');
        }
    }

    private function UserData($params) {
        $rs = StatisticsServer::addUserData($params);
        if ($rs['code'] == 0)
            $this->out('0', 'ok');
        else
            $this->out('100001', '添加失败');
    }

    private function Page($params) {
        $rs = StatisticsServer::addPage($params);
        if ($rs['code'] == 0)
            $this->out('0', 'ok');
        else
            $this->out('100001', '添加失败');
    }

    private function Button($params) {

        $rs = StatisticsServer::addButton($params);
        if ($rs['code'] == 0)
            $this->out('0', 'ok');
        else
            $this->out('100001', '添加失败');
    }

    private function UpdatePageTime($params,$page_time) {

        $rs = StatisticsServer::UpdatePageTime($params,$page_time);
        if ($rs['code'] == 0)
            $this->out('0', 'ok');
        else
            $this->out('100001', '修改失败');
    }

}
