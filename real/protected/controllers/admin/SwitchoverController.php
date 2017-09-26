<?php

//后台管理(切换)
class SwitchoverController extends CenterController {

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
        $this->render('list2');
    }

    //查询时间轴设置
    public function actionTimeset(){
        $transform_list = TransformServer::transform(array());

        if ($transform_list['code'] == 0) {
            foreach ($transform_list['data'] as $k => $v) {
                if ($v['uid'] == 'times') {
                    $arr = json_decode($v['jsobj'], true);
                    $transform = array($arr['min'], $arr['max'],$arr['que'],$arr['lang']);
                }
            }
        } else
            $transform = array(0, 0);
        $data['transform']['time'] = $transform;
        $this->out('0', '成功', array('data' =>$data['transform']['time']));

    }

    //更新时间步长
    public function actionTimeupdate(){
        $params['min'] = !empty($_REQUEST['min']) ? $_REQUEST['min'] : '';
        $params['max'] = !empty($_REQUEST['max']) ? $_REQUEST['max'] : '';
        $params['que'] = !empty($_REQUEST['que']) ? $_REQUEST['que'] : '';
        $params['lang'] = !empty($_REQUEST['lang']) ? $_REQUEST['lang'] : '';
        if (empty($params['min']) || empty($params['max']) || empty($params['que']) || empty($params['lang']))
            $this->out('100005', '参数不能为空');
        $res = TransformServer::timeUpdate($params);
        if($res){
            $this->out('0', '成功');
        }
        $this->out('100401','成功');
    }

    public function actionAjax() {
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $list = '';
        if ($params['type'] == 'trigger' || $params['type'] == '') {
            $transform_trigger_list = TransformServer::trigger(array());
            if ($transform_trigger_list['code'] == 0) {
                $list['trigger'] = $transform_trigger_list['data'];
            }
        }
        if ($params['type'] == 'effect' || $params['type'] == '') {
            $transform_effect_list = TransformServer::effect(array());
            if ($transform_effect_list['code'] == 0) {
                foreach ($transform_effect_list['data'] as $k => $v) {
                    $list['effect'][] = array('id' => $v['id'], 'grade' => $v['grade'], 'name' => $v['name'], 'parentid'=>$v['parentid'],'uid' => $v['uid'], 'dir' => json_decode($v['dir'], true), 'jskey' => $v['jskey']);
                }
            }
        }
        if ($params['type'] == 'dir' || $params['type'] == '') {
            $transform_dir_list = TransformServer::dir(array());
            if ($transform_dir_list['code'] == 0) {
                $list['dir'] = $transform_dir_list['data'];
            }
        }
        $this->out('0', '成功', array('data' => $list));
    }

    //-----------------手势--------------------------------------------------------------
    //添加手势
    public function actionTriggeradd() {
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        $params['jskey'] = !empty($_REQUEST['jskey']) ? $_REQUEST['jskey'] : '';
        if (empty($params['name']) || empty($params['grade']) || empty($params['jskey']))
            $this->out('100005', '参数不能为空');
        $params['uid'] = $this->creatId();
        $params['addtime'] = time();

        $rs = TransformServer::addTrigger($params);
        if ($rs['code'] == 0)
            $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID(), 'jskey' => $params['jskey']));
        else
            $this->out('100001', '创建失败');
    }
    // //更新手势
    public function actionTriggerupdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        $params['jskey'] = !empty($_REQUEST['jskey']) ? $_REQUEST['jskey'] : '';
        if (empty($id) || empty($params['name']) || empty($params['grade']) || empty($params['jskey']))
            $this->out('100005', '参数不能为空');

        $rs = TransformServer::updateTrigger(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }
    //删除手势
    public function actionTriggerDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');

        $rs = TransformServer::delTrigger(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

    //---------------方向---------------------------------------------------------------
    public function actionDiradd() {
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        $params['jskey'] = !empty($_REQUEST['jskey']) ? $_REQUEST['jskey'] : '';
        if (empty($params['name']) || empty($params['grade']) || empty($params['jskey']))
            $this->out('100005', '参数不能为空');
        $params['uid'] = $this->creatId();
        $params['addtime'] = time();

        $rs = TransformServer::addDir($params);
        if ($rs['code'] == 0)
            $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID(), 'jskey' => $params['jskey']));
        else
            $this->out('100001', '创建失败');
    }

    public function actionDirupdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        $params['jskey'] = !empty($_REQUEST['jskey']) ? $_REQUEST['jskey'] : '';
        if (empty($id) || empty($params['name']) || empty($params['grade']) || empty($params['jskey']))
            $this->out('100005', '参数不能为空');

        $rs = TransformServer::updateDir(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }

    public function actionDirDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');
        $data = TransformServer::dir(array('id' => $id));
        $rs = TransformServer::likeEffect($data['data'][0]['uid']);
        if ($rs['code'] == 0)
            $this->out('100002', '效果中已使用，删除对应的效果后才能删除');
        $rs = TransformServer::delDir(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

    //---------------效果---------------------------------------------------------------
    public function actionEffectadd() {
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        $params['jskey'] = !empty($_REQUEST['jskey']) ? $_REQUEST['jskey'] : '';
        $params['dir'] = !empty($_REQUEST['dir']) ? $_REQUEST['dir'] : '';



        if (empty($params['name']) || empty($params['grade']) || empty($params['jskey']) || empty($params['dir']))
            $this->out('100005', '参数不能为空');

        if($params['dir'][0] == 666){

            $dirarr=array_map(function($v){
                return  $v->uid;
            },TransformServer::dir([])['data']);
            $params['dir']=json_encode( $dirarr);

        }else{

            $params['dir']=json_encode($params['dir']);
        }


        $params['parentid'] = $params['type'];

        $params['uid'] = $this->creatId();
        $params['addtime'] = time();


        $rs = TransformServer::addEffect($params);
        if ($rs['code'] == 0)
            $this->out('0', '创建成功', array('id' => Yii::app()->db->getLastInsertID(), 'jskey' => $params['jskey']));
        else
            $this->out('100001', '创建失败');
    }

    public function actionEffectupdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $params['name'] = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $params['grade'] = !empty($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
        $params['jskey'] = !empty($_REQUEST['jskey']) ? $_REQUEST['jskey'] : '';
        $params['dir'] = !empty($_REQUEST['dir']) ? json_encode($_REQUEST['dir']) : '';
        if (empty($id) || empty($params['name']) || empty($params['grade']) || empty($params['jskey']) || empty($params['dir']))
            $this->out('100005', '参数不能为空');

        $rs = TransformServer::updateEffect(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }

    public function actionEffectDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($id))
            $this->out('100005', '参数不能为空');
        $rs = TransformServer::delEffect(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

}
