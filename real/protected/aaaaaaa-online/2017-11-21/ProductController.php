<?php

//用户作品
class ProductController extends CenterController {

    public $page = 1;
    public $pagesize = 20;
    public $layout = 'pro'; //定义布局

    public function init() {
        parent::init();
    }

    //主页
    public function actionIndex() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $params['user_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        if (!empty($_REQUEST['product_id']))
            $params['product_id'] = $_REQUEST['product_id'];
        if (!empty($_REQUEST['online']))
            $params['online'] = $_REQUEST['online']; //作品状态
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : $this->page;
        $pagesize = !empty($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : $this->pagesize;
        $rs = ProductServer::getList($params, $page, $pagesize);

        $data = array();
        if ($rs['code'] == 0) {
            $data = $this->listData($rs['data']);
            //获取数量
            $count_data = ProductServer::getCount(array('user_id' => $params['user_id']));
            $res['online_count'] = 0;
            $res['update_count'] = 0;
            $res['notonline_count'] = 0;
            $res['empty_count'] = 0;
            foreach ($count_data as $k => $v) {
                if ($v['online'] == 'online')
                    $res['online_count'] = $v['total'];
                if ($v['online'] == 'update')
                    $res['update_count'] = $v['total'];
                if ($v['online'] == 'notonline')
                    $res['notonline_count'] = $v['total'];
                if ($v['online'] == 'empty')
                    $res['empty_count'] = $v['total'];
            }
            $res['count'] = (int) ($res['online_count']) + (int) ($res['update_count']) + (int) ($res['notonline_count']) + (int) ($res['empty_count']);
            $res['data'] = $data;
        } else
            $res = array('online_count' => 0, 'update_count' => 0, 'notonline_count' => 0, 'empty_count' => 0, 'count' => 0, 'data' => array());

        $this->render('index', array('data' => $res));
    }

    public function actionBuilding() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $this->render('building');
    }

    //查询产品数目信息
    public function actionAjax() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $params['user_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        if (!empty($_REQUEST['product_id']))
            $params['product_id'] = $_REQUEST['product_id'];
        if (!empty($_REQUEST['online']))
            $params['online'] = $_REQUEST['online']; //作品状态
        if (!empty($_REQUEST['keyword']))
            $params['keyword'] = $_REQUEST['keyword']; //模糊查询
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : $this->page;
        $pagesize = !empty($_REQUEST['pagesize']) ? $_REQUEST['pagesize'] : $this->pagesize;
        $rs = ProductServer::getListlike($params, $page, $pagesize);
        $data = array();
        if ($rs['code'] == 0) {
            $data = $this->listData($rs['data']);
            //获取数量
            $count_data = ProductServer::getCount(array('user_id' => $params['user_id']));
            $res['online_count'] = 0;
            $res['update_count'] = 0;
            $res['notonline_count'] = 0;
            $res['empty_count'] = 0;
            foreach ($count_data as $k => $v) {
                if ($v['online'] == 'online')
                    $res['online_count'] = $v['total'];
                if ($v['online'] == 'update')
                    $res['update_count'] = $v['total'];
                if ($v['online'] == 'notonline')
                    $res['notonline_count'] = $v['total'];
                if ($v['online'] == 'empty')
                    $res['empty_count'] = $v['total'];
            }
            $res['count'] = (int) ($res['online_count']) + (int) ($res['update_count']) + (int) ($res['notonline_count']) + (int) ($res['empty_count']);
            $res['data'] = $data;
        } else
            $res = array();
        $this->out('0', '查询成功', $res);
    }

    //修改列表数据
    public function listData($data) {
        foreach ($data as $k => $v) {
            if ($v['cover'] == NULL)
                $cover = NULL;
            else
                $cover = PREVIEW . $v['cover'];
            $r = array(
                'product_id' => $v['product_id'],
                'title' => $v['title'],
                'online' => $v['online'],
                'p_size' => number_format($v['p_size'] / (1024 * 1024), 2, '.', ''),
                'pay' => $v['pay'],
                'is_open' => $v['is_open'],
                'cover' => $cover,
                'updatetime' => !empty($v['updatetime']) ? date('Y/m/d H:m', $v['updatetime']) : '',
                'addtime' => $v['addtime'],
            );
            $datas[] = $r;
        }
        return $datas;
    }

    //创建作品
    public function actionCreat() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        if (!empty($_POST)) {
            $params['user_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
            $params['product_id'] = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
            $params['title'] = !empty($_REQUEST['title']) ? $_REQUEST['title'] : '';
            $params['description'] = !empty($_REQUEST['description']) ? $_REQUEST['description'] : '';
            $params['addtime'] = time();
            $params['online'] = 'empty';
            $params['pay'] = 'no';
            $params['is_open'] = 'no';
            $params['cloud'] = 'yes';
            $params['wechat_title'] = '';
            $params['wechat_content'] = '';
            $params['wechat_img'] = '';
            $params['path'] = date('Ym', time()) . '/' . SHA1($params['product_id']);
            if (empty($params['user_id']) || empty($params['product_id']))
                $this->out('100001', '创建失败');
            if (mb_strlen($params['title'], 'utf8') > 26 || mb_strlen($params['description'], 'utf8') > 36)
                $this->out('100001', '创建失败');
            $rs = ProductServer::addProduct($params);
            if ($rs['code'] == 0)
                $this->out('0', '创建成功', array('product_id' => $params['product_id'], 'title' => $params['title']));
            else
                $this->out('100001', '创建失败');
        }else {
            //生成产品id
            $product = $this->creatId();
            $this->out('0', '成功', array('product_id' => $product));
        }
    }

    //删除
    public function actionDel() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $user_id = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        if (empty($product_id))
            $this->out('100005', '参数不能为空');
        //判断
        $rs = $this->checkProduct($product_id);
        if ($rs['online'] == 'online' || $rs['online'] == 'update')
            $this->out('100002', '上线项目无法删除');
        $p_rs = ProductServer::delProduct(array('product_id' => $product_id));

        if ($p_rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

    //上下线验证码
    private function CheckValcode($msg_code, $val_code = '') {
        //手机验证码
        if (empty($_REQUEST['msg_code']))
            $this->out('100005', '参数不能为空');
        $code = json_decode(Yii::app()->session[$this->user_product_code], true);
        if ($msg_code != $code['code'])
            $this->out('100003', '短信验证码错误');
        if (time() - $this->ValidateCodeExpTimes * 60 > $code['time'])
            $this->out('100010', '验证码已过期');
        //图片验证码
        if (!empty($val_code)) {
            $img_code = json_decode(Yii::app()->session['user_code'], true);
            if (strtolower($val_code) != $img_code['code'])
                $this->out('100004', '图片验证码错误');
        }
    }

    //公开项目广场
    public function actionOpen() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        if (empty($product_id))
            $this->out('100005', '参数不能为空');
        //判断
        $rs = $this->checkProduct($product_id);
        $params['is_open'] = 'no';
        if ($rs['is_open'] == 'no') {
            $params['is_open'] = 'yes';
        }
        $r = ProductServer::updateProduct(array('product_id' => $product_id), $params);
        if ($r['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }

    //去除logo
    public function actionDellogo() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        if (empty($product_id))
            $this->out('100005', '参数不能为空');
        //判断有没有充值过
        $rs = FlowServer::getUserlist(array('user_id' => Yii::app()->session['user']['user_id']));

        $status = 'no';
        foreach ($rs as $k => $v) {
            if ($v['type_id'] > 1) {
                $status = 'yes';
            }
        }

        if ($status == 'yes') {
            //修改状态
            $rs = $this->checkProduct($product_id);
            if ($rs['pay'] == 'no') {
                $pay = 'yes';
            } else {
                $pay = 'no';
            }
            ProductServer::updateProduct(array('product_id' => $product_id), array('pay' => $pay));
            $this->out('0', 'ok');
        } else {
            $this->out('100001', '需要购买流量包');
        }
    }

    //项目设置
    public function actionSetting() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        if (empty($product_id))
            $this->out('100005', '参数不能为空');
        //判断
        $rs = $this->checkProduct($product_id);
        $data = array();
        $data['title'] = $rs['title'];
        $data['description'] = $rs['description'];
        $data['wechat_title'] = $rs['wechat_title'];
        $data['wechat_content'] = $rs['wechat_content'];
        $data['wechat_img'] = $rs['wechat_img'];
        $data['color'] = $rs['color'];
        //查询渠道
        //定义是否已经上线开关
        $is_need_update = false;
        $product_data = ProductServer::getList(array('product_id' => $product_id));
        if ($product_data['code'] == 0) {
            if($product_data['data'][0]['online'] == 'online'){
                $is_need_update = true;
            }
        }
        $data_link = ProductServer::selectLink(array('product_id' => $product_id));
        if ($data_link['code'] == 0) {
            foreach ($data_link['data'] as $k => $v) {
                if ($v['status'] != 'notonline') {
                    if ($v['status'] == 'online') {
                        $data['is_add_link'] = true;
                        $data['link'][0]['name'] = $v['name'];
                        $data['link'][0]['url'] = REAL . U('product/index/index'). '&url_type=pc' . '&id=' . $v['uid'];
                    } else {
                        $data['link'][$k + 1]['name'] = $v['name'];
                        $data['link'][$k + 1]['url'] = REAL . U('product/index/index') . '&url_type=pc'. '&id=' . $v['uid'];
                    }
                }
            }
        }
        //保存填写的信息
        $params = array();
        if (!empty($_REQUEST['title'])){
            $params['title'] = $_REQUEST['title'];
            ////////////////////////////////
            //每次修改更改项目状态
            if($is_need_update){
                $params['online'] = 'update';
            }
            $rsJson = ResourcesServer::getjson(array('product_id' => $product_id));
            if ($rsJson['code'] != 0)
                $this->out('100044', '读取json失败');
            $str = $rsJson['data'][0]['str'];
            $str_obj = json_decode($str);
            $str_obj->title = $params['title'];
            $str =json_encode($str_obj);
            $rsJson = ResourcesServer::updateJson(['id'=>$rsJson['data'][0]['id']],['str'=>$str]);
            if ($rsJson['code'] != 0)
                $this->out('100055', '修改title失败');
            ///////////////////////////////
        }
        if (!empty($_REQUEST['description']))
            $params['description'] = $_REQUEST['description'];
        if (!empty($_REQUEST['wechat_title']))
            $params['wechat_title'] = $_REQUEST['wechat_title'];
        if (!empty($_REQUEST['wechat_content']))
            $params['wechat_content'] = $_REQUEST['wechat_content'];
        if (!empty($_REQUEST['wechat_img'])) {
            $filename = time() . rand() . '.png';
            $filepath = UPLOAD_PATH . '/photo';
            if (Tools::createDir($filepath)) {
                $url = explode(',', $_REQUEST['wechat_img']);
                //base64保存图片
                @file_put_contents($filepath . '/' . $filename, base64_decode($url[1]));
                //缩放图片
                Tools::ImageToJPG($filepath . '/' . $filename, $filepath . '/' . $filename, 120, 120);
                $params['wechat_img'] = $filename;
            } else {
                $this->out('100002', '创建文件夹失败');
            }
        }
        if (!empty($params)) {
            ProductServer::updateProduct(array('product_id' => $product_id), $params);
            $this->out('0', '保存成功');
        }
        $this->out('0', '查询成功', $data);
    }

    //添加渠道
    public function actionAddditch() {
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $name = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $uid = !empty($_REQUEST['uid']) ? $_REQUEST['uid'] : '';
        if (empty($product_id) || empty($name))
            $this->out('100005', '参数不能为空');
        $rs = $this->checkProduct($product_id);
        //判断是添加还是修改
        if (empty($uid)) {
            //获取大小
            $rs_link = ProductServer::selectLink(array('product_id' => $product_id, 'status' => 'online'));
            if ($rs_link['code'] == 0) {
                $params['p_size'] = $rs_link['data'][0]['p_size'];
                $base_path = explode('/',$rs_link['data'][0]['url'])[5];
            } else {
                $params['p_size'] = 0;
                $this->out('100001', '保存失败');
            }
            $params['uid'] = $this->creatId();
            $params['product_id'] = $product_id;
            $params['url'] = 'http://live.realplus.cc/' . $rs['path'] .'/'.$base_path. '/index.html?' . $this->creatId();
            $params['name'] = $name;

            $params['status'] = 'other';
            $params['addtime'] = time();
            $rs = ProductServer::addLink($params);
            if ($rs['code'] == 0)
                $this->out('0', '保存成功', array('uid' => $params['uid']));
            else
                $this->out('100001', '保存失败');
        }else {
            $rs = ProductServer::updateLink(array('product_id' => $product_id, 'uid' => $uid, 'status' => 'other'), array('name' => $name));
            if ($rs['code'] == 0)
                $this->out('0', '保存成功');
            else
                $this->out('100001', '保存失败');
        }
    }

    //删除渠道
    public function actionDelditch() {
        if (!$this->checkLogin())
            $this->showMessage('未登录', U('user/login/login'));
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $uid = !empty($_REQUEST['uid']) ? $_REQUEST['uid'] : '';
        if (empty($product_id) || empty($uid))
            $this->out('100005', '参数不能为空');
        //判断
        $rs = $this->checkProduct($product_id);
        $rs = ProductServer::delLink(array('product_id' => $product_id, 'uid' => $uid, 'status' => 'other'));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

    //上线OR下线（事物）
    public function actionEditonline() {
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $online = !empty($_REQUEST['online']) ? $_REQUEST['online'] : 'online';
        $url = !empty($_REQUEST['url']) ? $_REQUEST['url'] : '';
        $page_size = !empty($_REQUEST['size']) ? $_REQUEST['size'] : 0;
        $video_size = !empty($_REQUEST['videoSize']) ? $_REQUEST['videoSize'] : 0;
        $size = $page_size + $video_size;
        $link = !empty($_REQUEST['link']) ? $_REQUEST['link'] : '';
        if (empty($product_id))
            $this->out('100005', '参数不能为空');
        //批量
        if (is_array($product_id)) {
//            $params['online']  =$online;
//            if($params['online'] == 'notonline'){
//                //验证码接口(上线不需验证，下线需要)
//                if(empty($_REQUEST['msg_code'])) $this->out('100005','参数不能为空'); 
//                $val_code='';
//                if(!empty($_REQUEST['val_code'])) $val_code = $_REQUEST['val_code'];
//                $this->CheckValcode($_REQUEST['msg_code'],$val_code);
//            }
//            foreach ($product_id as $v){
//                $data = $this->checkProduct($v);
//                //生成文件
//                $this->changeLink($data['product_id'],$params['online'],$data['path']);
//                $r = ProductServer::updateProduct(array('product_id'=>$v),$params);
//                if($r['code']!=0) $this->out('100002','批量修改失败');
//            }
//             unset(Yii::app()->session[$this->user_product_code]);
//            $this->out('0','修改成功');
        } else {
            $params['online'] = $online;
            if ($params['online'] == 'notonline') {
                //验证码接口(上线不需验证，下线需要)
                if (empty($_REQUEST['msg_code']))
                    $this->out('100005', '参数不能为空');
                $val_code = '';
                if (!empty($_REQUEST['val_code']))
                    $val_code = $_REQUEST['val_code'];
                $this->CheckValcode($_REQUEST['msg_code'], $val_code);
                $this->checkProduct($product_id);
            }
            $rs = ProductServer::getList(array('product_id' => $product_id));
            if ($rs['code'] != 0)
                $this->out('100003', '非法操作');
            //生成文件处理逻辑
            $this->changeLink($product_id, $params['online'], $url, $size, $link);
            if (!empty($size))
                $params['p_size'] = $size;
            $r = ProductServer::updateProduct(array('product_id' => $product_id), $params);
            if ($r['code'] == 0) {
                unset(Yii::app()->session[$this->user_product_code]);
                if ($online == 'online')


                    $this->sendSocket($product_id, array('code' => '0', 'data' => ''));
                $this->out('0', '修改成功');
            } else {
                if ($online == 'online'){
                /////////////////////
                    $this->sendSocket($product_id, array('code' => '100001', 'data' => ''));
                }
                $this->out('100001', '修改失败');
            }
        }
    }

    //上下线时生成链接或删除链接
    private function changeLink($product_id, $online, $url, $size, $link) {
        //下线
        if ($online == 'notonline') {
            //删除正式链接地址
            //$rs = ProductServer::delLink(array('product_id'=>$product_id,'status'=>'online'));
            // if($rs['code'] != 0)  $this->out('100001','修改失败');
            //删除oss数据
            //OssServer::deleteObject('realive',PREVIEW.$path);
        }
        if ($online == 'online') {
            //判断是更新还是新增
            $data = ProductServer::selectLink(array('product_id' => $product_id, 'status' => 'online'));
            if ($data['code'] == 0) {
                //修改
                //开启事物处理
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    //修改线上渠道文件大小
                    $update_rs = ProductServer::updateLink(array('product_id' => $product_id, 'status' => 'online'), array('p_size' => $size, 'url' => $url, 'addtime' => time()));
                    if ($update_rs['code'] != 0) {
                        throw new CException('添加失败', 100006);
                    }
                    //修改其他渠道文件大小
                    $sel_data = ProductServer::selectLink(array('product_id' => $product_id, 'status' => 'other'));
                    if ($sel_data['code'] == 0) {
                        $new_url = $url;
                        $new_arr = explode('?',$new_url);
                        foreach ($sel_data['data'] as $k=>$v){
                            $new_url = $new_arr[0].'?'.$this->creatId();
                            $update_rs = ProductServer::updateLink(array('uid' => $v['uid'], 'status' => 'other'), array('p_size' => $size,'url'=>$new_url));
                        }
                        if ($update_rs['code'] != 0) {
                            throw new CException('添加失败', 100004);
                        }
                    }

                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    $this->sendSocket($product_id, array('code' => $e->getCode(), 'data' => ''));
                    exit;
                }
            } else {
                //开启事物处理
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    //新增
                    $params['uid'] = substr($link, -10);
                    $params['product_id'] = $product_id;
                    $params['url'] = $url;
                    $params['name'] = '正式地址';
                    $params['p_size'] = $size;
                    $params['status'] = 'online';
                    $params['addtime'] = time();
                    $add_rs = ProductServer::addLink($params);
                    if ($add_rs['code'] != 0) {
                        throw new CException('添加失败', 100007);
                    }
                    //修改其他渠道文件大小
                    $sel_data = ProductServer::selectLink(array('product_id' => $product_id, 'status' => 'other'));
                    if ($sel_data['code'] == 0) {
                        $update_rs = ProductServer::updateLink(array('product_id' => $product_id, 'status' => 'other'), array('p_size' => $size));
                        if ($update_rs['code'] != 0) {
                            throw new CException('添加失败', 100008);
                        }
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    $this->sendSocket($product_id, array('code' => $e->getCode(), 'data' => ''));
                    exit;
                }
            }
        }
    }

    //给NODE发推送
    public function actionSendmsg() {
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : 'test';
        if (!empty($product_id)) {   //产品页面
            if (!$this->checkLogin())
                $this->out('100003', '非法操作');
            $rs = $this->checkProduct($product_id);
        }elseif (!empty($token)) {  //编辑页面
            $data = Yii::app()->redis->getClient()->get($token);
            if (!empty($data)) {
                $data = json_decode($data, true);
                $product_id = $data['product_id'];
                $rs = ProductServer::getList(array('product_id' => $product_id));
                if ($rs['code'] != 0) {
                    $this->out('100003', '非法操作');
                }
                $rs = $rs['data'][0];
                $product_id = $rs['product_id'];
            } else
                $this->out('100003', '非法操作');
        }
        else {
            $this->out('100005', '参数不能为空');
        }

        //调取node接口生成正式地址
        $rsJson = ResourcesServer::getjson(array('product_id' => $product_id));
        if ($rsJson['code'] != 0)
            $this->out('100004', '修改失败');
        $str = $rsJson['data'][0]['str'];
        //////////////////////////////////

        $show_color_rs = ProductServer::getList(['product_id' => $product_id]);
        if($show_color_rs['code'] == 0){
            $show_color = $show_color_rs['data'][0]->color;
            if(empty($show_color)){
                $show_color = '#ffffff';
            }
        }
        //项目更新触发的逻辑
        if($type == 'online'){
            $rsJson = ResourcesServer::getjson(array('product_id' => $product_id));
            if($rsJson['code'] == 0){
                $verify_params['product_id'] = $product_id;
                $verify_params['is_has_video'] = $rsJson['data'][0]->is_has_video;
                $verify_params['addtime'] = time();
                ProductServer::addProductVerify($verify_params);
                //更新product表中的状态
                $pro_rs = ProductServer::updateProduct(['product_id'=>$product_id],['status'=>'未审核','online'=>'online','cloud'=>'yes']);
            }
        }
        ////////////////////////////////////////
        //@syl查询项目映射的video_path
//        $videoJson = ResourcesServer::getResourcesVideo(array('product_id' => $product_id));
//        if ($videoJson['code'] != 0){
//            $video_str =[];
//        }else{
//            $video_str = $videoJson['data'][0]['video_path'];
//        }
        NodeInterface::Sendtest(array('product_id' => $product_id, 'str' => $str, 'type' => $type, 'color'=>$show_color));
        $this->out('0', 'ok');
    }

    public function actionSaveColor(){
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $color = !empty($_REQUEST['color']) ? $_REQUEST['color'] : '';
        if (empty($product_id) || empty($color)) {   //产品页面
            $this->out('100003', 'pid和颜色为空');
          }
        $rsJson = ResourcesServer::getjson(array('product_id' => $product_id));
        if ($rsJson['code'] != 0)
            $this->out('100044', '读取json失败');
        $str = $rsJson['data'][0]['str'];
        $str_obj = json_decode($str);
        $str_obj->pageData[0]->ver =uniqid('color');
        $str =json_encode($str_obj);
        $rsJson = ResourcesServer::updateJson(['id'=>$rsJson['data'][0]['id']],['str'=>$str]);
        if ($rsJson['code'] != 0)
            $this->out('100055', '修改版本号失败');
        //查看当前项目是否已经上线
         $rs = ProductServer::getList(['product_id'=>$product_id]);
        if($rs['code'] !=0){
            $this->out('100066', '读取项目信息失败');
        }
        if($rs['data'][0]['online'] == 'online'){
            $rs = ProductServer::updateProduct(['product_id'=>$product_id],['color'=>$color,'online'=>'update']);
        }else{
            $rs = ProductServer::updateProduct(['product_id'=>$product_id],['color'=>$color]);
        }
        if($rs['code'] ==0){
            $this->out('0', '颜色保存成功');
        }
    }
}
