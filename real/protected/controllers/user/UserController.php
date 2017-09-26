<?php

//用户基础类
class UserController extends CenterController {

    public $page = 1;
    public $pagesize = 20;
    public $layout = 'pro'; //定义布局

    public function init() {
        parent::init();
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
    }
    

    //获取用户信息
    public function actionInfo() {

        if (!empty(Yii::app()->session['user']['user_id'])) {
            //个人
            $params['_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
            $params['pc_type'] = 1;
        } else {
            //企业
            $params['_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
            $params['pc_type'] = 2;
        }

        $rs = UserServer::selUser($params);
        $data = $rs['data'];
        $this->render('info', array('data' => $data));
    }

    //完善信息
    public function actionUpdateinfo() {
        if (!empty(Yii::app()->session['user']['user_id'])) {
            //个人
            $params['user_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        } else {
            //企业
            $params['company_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
        }
        $data['nickname'] = !empty($_REQUEST['nickname']) ? $_REQUEST['nickname'] : '';
        $data['signature'] = !empty($_REQUEST['signature']) ? $_REQUEST['signature'] : '';
        $data['province'] = !empty($_REQUEST['province']) ? $_REQUEST['province'] : '';
        $data['city'] = !empty($_REQUEST['city']) ? $_REQUEST['city'] : '';
        $data['headimg'] = !empty($_REQUEST['headimg']) ? $_REQUEST['headimg'] : '';
        //确认是不是用户新上传的图片
        if (strlen($data['headimg']) > 1000) {
            $filename = time() . rand() . '.png';
            $filepath = UPLOAD_PATH . '/headimg';
            if (Tools::createDir($filepath)) {
                $url = explode(',', $data['headimg']);
                //验证是不是图片
                if (!strpos($url[0], 'image/png') && !strpos($url[0], 'image/jpeg'))
                    $this->out('100003', '头像错误');
                //base64保存图片
                @file_put_contents($filepath . '/' . $filename, base64_decode($url[1]));
                //缩放图片
                Tools::ImageToJPG($filepath . '/' . $filename, $filepath . '/' . $filename, 256, 256);
                $data['headimg'] = UPLOAD_HEADIMG . $filename;
                $session_data = Yii::app()->session['user'];
                $session_data['headimg'] = $data['headimg'];
                Yii::app()->session['user'] = $session_data;
            }else {
                $this->out('100002', '创建文件夹失败');
            }
        }

        $rs = UserServer::updateUser($params, $data);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }

    //账户安全
    public function actionSafety() {

        if (isset(Yii::app()->session['user']['tel']) && Yii::app()->session['user']['tel'] != '') {
            $data = Yii::app()->session['user']['tel'];
        } elseif (isset(Yii::app()->session['user']['email']) && Yii::app()->session['user']['email'] != '') {
            $data = Yii::app()->session['user']['email'];
        }
        $this->render('safety', array('data' => $data));
    }

    //修改密码
    public function actionUpdatepwd() {
        if (!empty(Yii::app()->session['user']['user_id'])) {
            //个人
            $params['_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
            $params['pc_type'] = 1;
            $update_data['user_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        } else {
            //企业
            $params['_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
            $params['pc_type'] = 2;
            $update_data['company_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
        }
        $o_password = !empty($_REQUEST['o_password']) ? $_REQUEST['o_password'] : '';
        $n_password = !empty($_REQUEST['n_password']) ? $_REQUEST['n_password'] : '';
        $r_password = !empty($_REQUEST['r_password']) ? $_REQUEST['r_password'] : '';
        if (empty($params['_id']) || empty($o_password) || empty($n_password) || empty($r_password))
            $this->out('100005', '参数不能为空');
        if ($n_password != $r_password)
            $this->out('100002', '密码不一致');
        $params['password'] = Tools::setpwd($o_password);
        $rs = UserServer::selUser($params);
        if ($rs['code'] != 0)
            $this->out('100003', '原始密码错误');
        $rst = UserServer::updateUser($update_data, array('pwd' => Tools::setpwd($n_password)));
        if ($rst['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }

    //用户工单
    public function actionWorkorder() {
        if (!empty(Yii::app()->session['user']['user_id'])) {
            //个人
            $params['_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        } else {
            //企业
            $params['_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
        }
        if (!empty($_REQUEST['keyword']))
            $params['keyword'] = $_REQUEST['keyword'];
        if (!empty($_REQUEST['start']))
            $params['start'] = strtotime($_REQUEST['start']);
        if (!empty($_REQUEST['end']))
            $params['end'] = strtotime($_REQUEST['end']) + 3600 * 24;

        $data = '';
        $rs = WorkorderServer::select($params);
        if ($rs['code'] == 0)
            $data = $rs['data'];
        $this->render('workorder', array('data' => $data));
    }

    //添加用户工单
    public function actionAddworkorder() {
        if (!empty(Yii::app()->session['user']['user_id'])) {
            //个人
            $params['_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        } else {
            //企业
            $params['_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
        }
        $params['title'] = !empty($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $params['content'] = !empty($_REQUEST['content']) ? $_REQUEST['content'] : '';
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $params['remind'] = !empty($_REQUEST['remind']) ? $_REQUEST['remind'] : '';
        $params['order_no'] = $this->creatId();
        $params['status'] = 1;
        $params['addtime'] = time();
        if (empty($params['title']) || empty($params['content']) || empty($params['type']) || empty($params['remind']))
            $this->out('100005', '参数不能为空');
        //开启事物处理
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $add_rs = WorkorderServer::add($params);
            if ($add_rs['code'] != 0) {
                throw new CException('生成失败', 100001);
            }
            //添加图片
            if (isset($_REQUEST['img'])) {
                $img = $_REQUEST['img'];
                foreach ($img as $k => $v) {
                    $filename = time() . rand() . '.png';
                    $filepath = UPLOAD_PATH . '/workorder';
                    if (Tools::createDir($filepath)) {
                        $url = explode(',', $v);
                        //验证是不是图片
                        if (!strpos($url[0], 'image/png') && !strpos($url[0], 'image/jpeg'))
                            $this->out('100003', '图片格式错误');
                        //base64保存图片
                        @file_put_contents($filepath . '/' . $filename, base64_decode($url[1]));
                        $add_rs = WorkorderServer::addImg(array('order_no' => $params['order_no'], 'link' => $filename));
                        if ($add_rs['code'] != 0) {
                            throw new CException('生成失败', 100001);
                        }
                    } else {
                        $this->out('100002', '创建文件夹失败');
                    }
                }
            }

            $transaction->commit();
            $this->out('0', '提交成功');
        } catch (Exception $e) {
            $transaction->rollback();
            $this->out($e->getCode(), $e->getMessage());
        }
    }

    //查询工单详情
    public function actionWorkorderinfo() {
        if (!empty(Yii::app()->session['user']['user_id'])) {
            //个人
            $params['_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        } else {
            //企业
            $params['_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
        }
        $params['order_no'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $rs = WorkorderServer::selectInfo($params);
        if (!empty($rs))
            $this->out('0', '查询成功', $rs);
        else
            $this->out('100001', '查询失败');
    }

    //关闭工单
    public function actionCloseorder() {
        if (!empty(Yii::app()->session['user']['user_id'])) {
            //个人
            $params['_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        } else {
            //企业
            $params['_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
        }
        $params['order_no'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($params['order_no']))
            $this->out('100005', '参数不能为空');
        $rs = WorkorderServer::update($params, array('status' => 3));
        if (!empty($rs))
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }

    //删除工单
    public function actionDelorder() {
        if (!empty(Yii::app()->session['user']['user_id'])) {
            //个人
            $params['_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        } else {
            //企业
            $params['_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
        }
        $params['order_no'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($params['order_no']))
            $this->out('100005', '参数不能为空');
        $rs = WorkorderServer::del($params);
        if (!empty($rs))
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

    //回复工单
    public function actionReplyorder() {
        if (!empty(Yii::app()->session['user']['user_id'])) {
            //个人
            $_id = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        } else {
            //企业
            $_id = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
        }
        $params['order_no'] = !empty($_REQUEST['order_no']) ? $_REQUEST['order_no'] : '';
        $params['content'] = !empty($_REQUEST['content']) ? $_REQUEST['content'] : '';
        $params['reply_type'] = 'user'; //如果是工作人员回复则传递admin
        $params['addtime'] = time();
        if (empty($params['order_no']) || empty($params['content']))
            $this->out('100005', '参数不能为空');
        //开启事物处理
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $rs = WorkorderServer::select(array('_id' => $_id, 'order_no' => $params['order_no']));
            if ($rs['code'] != 0) {
                throw new CException('生成失败', 100001);
            }
            $add_rs = WorkorderServer::addReply($params);
            if ($add_rs['code'] != 0) {
                throw new CException('生成失败', 100001);
            }
            $id = Yii::app()->db->getLastInsertID();
            //添加图片
            $link = '';
            if (isset($_REQUEST['img'])) {
                $img = $_REQUEST['img'];
                foreach ($img as $k => $v) {
                    $filename = time() . rand() . '.png';
                    $filepath = UPLOAD_PATH . '/workorder';
                    if (Tools::createDir($filepath)) {
                        $url = explode(',', $v);
                        //验证是不是图片
                        if (!strpos($url[0], 'image/png') && !strpos($url[0], 'image/jpeg'))
                            $this->out('100003', '图片格式错误');
                        //base64保存图片
                        @file_put_contents($filepath . '/' . $filename, base64_decode($url[1]));
                        $add_rs = WorkorderServer::addReplyimg(array('reply_no' => $id, 'link' => $filename));
                        if ($add_rs['code'] != 0) {
                            throw new CException('生成失败', 100001);
                        }
                        $link[] = $filename;
                    } else {
                        $this->out('100002', '创建文件夹失败');
                    }
                }
            }
            //修改工单状态
            WorkorderServer::update(array('order_no' => $params['order_no']), array('status' => 1));
            $transaction->commit();
            $this->out('0', '提交成功', array('content' => $params['content'], 'addtime' => $params['addtime'], 'link' => $link));
        } catch (Exception $e) {
            $transaction->rollback();
            $this->out($e->getCode(), $e->getMessage());
        }
    }

}
