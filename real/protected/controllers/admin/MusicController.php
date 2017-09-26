<?php

//后台管理(音效)
class MusicController extends CenterController {

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

        $this->render('list3');
    }

    //@syl:ajax提交获取数据
    public function actionAjax() {
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $list = '';
        if ($params['type'] == 'system' || $params['type'] == '') {
            $system_music = MusicServer::system(array());
            if ($system_music['code'] == 0) {
                $list['system'] = $system_music['data'];
            }
        }
        if ($params['type'] == 'location' || $params['type'] == '') {
            $location_music = MusicServer::location(array());
            if ($location_music['code'] == 0) {
                $list['location'] = $location_music['data'];
            }
        }
        $this->out('0', '成功', array('data' => $list));
    }

    //-----------------系统音乐--------------------------------------------------------------
    //@syl:系统音乐的更新
    public function actionSystemupdate()
    {
        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['jskey'] = !empty($_REQUEST['key']) ? $_REQUEST['key'] : '';
        $params['addtime'] = time();
        if (empty($params['id']) || empty($params['name']) || empty($params['jskey']))
            $this->out('100005', '参数不能为空');
        $res = MusicServer::uppSystem($params);
        if($res){
            $this->out('0', '更新成功');
        }else{
            $this->out('100001', '更新失败');
        }

    }
    //@syl:系统音乐的添加
    public function actionSystemadd() {
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['jskey'] = !empty($_REQUEST['key']) ? $_REQUEST['key'] : '';
        if (empty($params['name']))
            $this->out('100005', '参数不能为空');
        if ($_FILES['music']['size'] > 1024 * 1024 * 5) {
            $this->out('100004', 'MP3不能超过5M');
        }

        if (!in_array($_FILES['music']['type'], array('audio/mpeg', 'audio/mp3'))) {
            $this->out('100006', 'MP3格式错误'.$_FILES['music']['type']);
        }
        $new_name = md5($_FILES["music"]["name"] . rand(1, 999999)) . '.mp3';
        $rs = OssServer::uploadFile('realadobe', "music/$new_name", $_FILES["music"]["tmp_name"]);
        $params['uid'] = $this->creatId();
        $params['addtime'] = time();

        if ($rs) {
            $params['url'] = "music/$new_name";
            $params['music_size'] = $_FILES['music']['size'];
            $rs = MusicServer::addSystem($params);
            if ($rs['code'] == 0)
                $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID(), 'jskey' => $params['jskey']));
        } else
            $this->out('100001', '创建失败');
    }
//@syl:系统音乐的删除
    public function actionSystemdel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');

        $rs = MusicServer::delSystem(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

    //-----------------图标位置--------------------------------------------------------------
    //@syl:音乐图标的添加
    public function actionlocationdd() {
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        $params['jskey'] = !empty($_REQUEST['jskey']) ? $_REQUEST['jskey'] : '';
        if (empty($params['name']) || empty($params['grade']) || empty($params['jskey']))
            $this->out('100005', '参数不能为空');
        $params['uid'] = $this->creatId();
        $params['addtime'] = time();

        $rs = MusicServer::addLocation($params);
        if ($rs['code'] == 0)
            $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID(), 'jskey' => $params['jskey']));
        else
            $this->out('100001', '创建失败');
    }
    //@syl:音乐图标的更新
    public function actionLocationupdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        $params['jskey'] = !empty($_REQUEST['jskey']) ? $_REQUEST['jskey'] : '';
        if (empty($id) || empty($params['name']) || empty($params['grade']) || empty($params['jskey']))
            $this->out('100005', '参数不能为空');

        $rs = MusicServer::updateLocation(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }
    //@syl:音乐图标的删除
    public function actionLocationdel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');

        $rs = MusicServer::delLocation(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

}
