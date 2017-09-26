<?php

//帮助中心管理
class HelpController extends CenterController {

    public $page = 1;
    public $pagesize = 20;
    public $layout = 'admin'; //定义布局

    public function init() {
        parent::init();
        if (!$this->checkLogin('admin'))
            $this->showMessage('未登录', U('admin/login/login'));
    }

    //主页
    public function actionList() {

        $rs = HelpServer::select();
        if ($rs['code'] == 0) {
            $data = json_decode(json_encode($rs['data']), true);
            foreach ($data as $k => $v) {
                //获取二级数量
                $count = $this->diguis($rs['data'], $v['id']);
                $data[$k]['child'] = $count;
                $data[$k]['childs'] = 0;
            }


            //获取三级数量
            foreach ($data as $k => $v) {
                foreach ($data as $kk => $vv) {
                    if ($v['id'] == $vv['pid']) {
                        $data[$k]['childs'] = $data[$k]['childs'] + $vv['child'];
                    }
                }
            }
        } else
            $data = array();
        $list = array();
        foreach ($data as $k => $v) {
            if ($v['type'] == 1)
                $list[] = $v;
        }

        $this->render('list', array('data' => $list));
    }

    private function diguis($data, $pid) {
        $i = 0;
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid)
                $i++;
        }
        return $i;
    }

    public function actionAjax() {
        $params['keyword'] = !empty($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $params['pid'] = !empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '';
        $rs = HelpServer::select();
        if ($rs['code'] == 0) {
            $data = json_decode(json_encode($rs['data']), true);
            foreach ($data as $k => $v) {
                //获取二级数量
                $count = $this->diguis($rs['data'], $v['id']);
                $data[$k]['child'] = $count;
                $data[$k]['childs'] = 0;
            }
            if ($params['type'] == 1) {
                //获取三级数量
                foreach ($data as $k => $v) {
                    foreach ($data as $kk => $vv) {
                        if ($v['id'] == $vv['pid']) {
                            $data[$k]['childs'] = $data[$k]['childs'] + $vv['child'];
                        }
                    }
                }
            }

            //筛选
            $list = array();
            $rs_list = HelpServer::selectlike($params);
            if (count($rs_list) != 0) {
                foreach ($rs_list as $k => $v) {
                    foreach ($data as $kk => $vv) {
                        if ($v['pid'] == $vv['id'])
                            $list[$k]['p_name'] = $vv['title'];
                        if ($v['id'] == $vv['id']) {
                            $list[$k]['id'] = $vv['id'];
                            $list[$k]['title'] = $vv['title'];
                            $list[$k]['grade'] = $vv['grade'];
                            $list[$k]['child'] = $vv['child'];
                            $list[$k]['childs'] = $vv['childs'];
                        }
                    }
                }
            }
        } else
            $list = array();


        //      print_r($list);print_r($data);exit;
        $this->out('0', 'ok', $list);
    }

    public function actionAdd() {
        $params['title'] = !empty($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        $params['pid'] = !empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '';
        $params['content'] = !empty($_REQUEST['content']) ? $_REQUEST['content'] : '';
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $params['addtime'] = time();
        if (empty($params['title']) || empty($params['grade']))
            $this->out('100005', '参数不能为空');
        $rs = HelpServer::add($params);
        $params['id'] = Yii::app()->db->getLastInsertID();
        if ($rs['code'] == 0)
            $this->out('0', 'ok', $params);
        else
            $this->out('100001', 'error');
    }

    public function actionUpdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $params['title'] = !empty($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        $params['pid'] = !empty($_REQUEST['pid']) ? $_REQUEST['pid'] : '';
        $params['content'] = !empty($_REQUEST['content']) ? $_REQUEST['content'] : '';
        $params['addtime'] = time();
        if (empty($params['title']) || empty($params['grade']) || empty($id))
            $this->out('100005', '参数不能为空');
        foreach ($params as $k => $v) {
            if (!$v)
                unset($params[$k]);
        }
        $rs = HelpServer::update(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', 'ok');
        else
            $this->out('100001', 'error');
    }

    //删除
    public function actionDel() {
        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($params['id']))
            $this->out('100005', '参数不能为空');
        //查询id下面有没有子类目
        $rs = HelpServer::select(array('pid' =>  $params['id']));
        if ($rs['code'] == 0) $this->out('100002', '存在子类目，无法删除，请先修改子类目');
            $rs = HelpServer::del($params);
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

    public function actionInfo() {
        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($params['id']))
            $this->out('100005', '参数不能为空');
        $rs = HelpServer::select($params);
        if ($rs['code'] == 0)
            $this->out('0', '查询成功', $rs['data'][0]);
        else
            $this->out('100001', '查询失败');
    }

}
