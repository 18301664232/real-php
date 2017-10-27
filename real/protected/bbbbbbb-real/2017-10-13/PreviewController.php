<?php

//作品预览
class PreviewController extends CenterController {

    public $page = 1;
    public $pagesize = 20;
    public $layout = 'pro'; //定义布局

    public function init() {
        parent::init();
    }

    //创建预览生成测试地址（事物）
    public function actionCreate() {
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $url = !empty($_REQUEST['url']) ? $_REQUEST['url'] : '';
        $size = !empty($_REQUEST['size']) ? $_REQUEST['size'] : '';
        $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        if (empty($product_id))
            $this->out('100005', '参数不能为空');

        $rs = ProductServer::getList(array('product_id' => $product_id));
        if ($rs['code'] != 0) {
            $this->sendSocket($product_id, array('code' => '100003', 'data' => ''));
            $this->out('100003', '非法操作');
        }
        $rs = $rs['data'][0];

        //正式上线调用发布正式接口
        if ($type == 'online') {
            $link = ProductServer::selectLink(array('product_id' => $product_id, 'status' => 'online'));
            if ($link['code'] == 0) {
                $id = $link['data'][0]['uid'];
            } else {
                $id = $this->creatId();
            }
            $link = REAL . U('product/index/index', array('id' => $id));
            NodeInterface::Sendonline(array('product_id' => $product_id, 'path' => $rs['path'], 'link' => $link));
            exit();
        }

        $data = array('notonline' => '', 'online' => '', 'title' => $rs['title'], 'status' => $rs['online'], 'notonlineimg' => '', 'onlineimg' => '');
        //获取预览链接
        $list = ProductServer::selectLink(array('product_id' => $product_id));
        $link_id = '';
        if ($list['code'] == 0) {
            foreach ($list['data'] as $k => $v) {
                if ($v['status'] == 'notonline' && empty($data['notonline'])) {
                    $data['notonline'] = $v['uid'];
                    $link_id = $v['id'];
                } elseif ($v['status'] == 'online' && empty($data['online'])) {
                    $data['online'] = $v['uid'];
                }
            }
        }
        //获取json,看是否需要重新编译
        $rsJson = ResourcesServer::getjson(array('product_id' => $product_id));
        if ($rsJson['code'] != 0)
            $this->resultUrl($data, $product_id);
        if ($rsJson['data'][0]['status'] == 1) {   //未编译
            //开启事物处理
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //修改状态
                $update_rs = ResourcesServer::updateJson(array('id' => $rsJson['data'][0]['id']), array('status' => 2));
                if ($update_rs['code'] != 0) {
                    throw new CException('生成失败', 100001);
                }
                //修改项目大小
                $update_rs = ProductServer::updateProduct(array('product_id' => $product_id), array('p_size' => $size));
                if ($update_rs['code'] != 0) {
                    throw new CException('生成失败', 100001);
                }
                //修改链接大小
                if (!empty($link_id)) {
                    $update_rs = ProductServer::updateLink(array('id' => $link_id), array('p_size' => $size, 'addtime' => time()));
                    if ($update_rs['code'] != 0) {
                        throw new CException('生成失败', 100001);
                    }
                }
                //有测试链接编译后直接返回
                if (!empty($data['notonline'])) {
                    $transaction->commit();
                    $this->resultUrl($data, $product_id);
                }

                //添加
                $params['uid'] = $this->creatId();
                $params['product_id'] = $product_id;
                $params['url'] = $url;
                $params['name'] = '测试地址';
                $params['p_size'] = $size;
                $params['status'] = 'notonline';
                $params['addtime'] = time();
                $add_rs = ProductServer::addLink($params);
                if ($add_rs['code'] != 0) {
                    throw new CException('生成失败', 100001);
                }
                $transaction->commit();
                $data['notonline'] = $params['uid'];
                $this->resultUrl($data, $product_id);
            } catch (Exception $e) {
                $transaction->rollback();
                $this->resultUrl($data, $product_id);
            }
        } else { //已经编译直接输出预览链接
            $this->resultUrl($data, $product_id);
        }
    }

    //重写返回
    public function resultUrl($data, $product_id) {
        foreach ($data as $k => $v) {
            if ($k == 'notonline' || $k == 'online') {
                if (!empty($v)) {
                    $data[$k] = REAL . U('product/index/index') . '&id=' . $v;
                    $data[$k . 'img'] = REAL . U('product/preview/Createimg') . '&id=' . $v;
                }
            }
        }
        $this->sendSocket($product_id, array('code' => '0', 'data' => $data));
        $this->out('0', 'ok');
    }

    //生成预览二维码
    public function actionCreateimg() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $name = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        if (empty($id))
            $this->out('100005', 'id不能为空');
        $link = REAL . U('product/index/index', array('id' => $id));
        if (empty($name)) {
            Tools::createImg($link);
        } else {
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");
            header("Content-Disposition:attachment;filename=" . $name . '.png');
            header("Content-Transfer-Encoding:binary");
            Tools::createImg($link);
        }
    }

}
