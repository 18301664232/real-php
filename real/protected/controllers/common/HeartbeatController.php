<?php

//心跳续时
class HeartbeatController extends BaseController {

    //前台用户
    public function actionindex() {
        if (!empty(Yii::app()->session['user'])) {
            $data = !empty($_REQUEST['data']) ? $_REQUEST['data'] : '';
            $r = '';
            if (!empty($data)) {
                $id = Yii::app()->session['user']['id'];
                $rs = UserServer::getList(array('id' => $id));
                $r = $rs['data'][0];
            }
            $this->out('000000', 'succeed', $r);
        } else {
            //自动登陆
            $cookie_id = COOKIE_KEY;
            $user_id = Yii::app()->request->cookies[$cookie_id];
            if (!empty($user_id)) {
                $rs = UserServer::getList(array('user_id' => $user_id));
                $r = $rs['data'][0];
                $this->userInsession($r);
                $this->out('000000', 'succeed', $r);
            } else
                $this->out('100001', 'no login');
        }
    }

    //后台管理员
    public function actionindex2() {
        if (!empty(Yii::app()->session['admin'])) {
            $data = !empty($_REQUEST['data']) ? $_REQUEST['data'] : '';
            $r = '';
            if (!empty($data)) {
                $id = Yii::app()->session['admin']['id'];
                $rs = AdminServer::getList(array('id' => $id));
                $r = $rs['data'][0];
            }
            $this->out('000000', 'succeed', $r);
        } else
            $this->out('100001', 'no login');
    }

}
