<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-11-06 11:17:17
 */
class AccessStatusController extends CenterController
{

    //读取用户访问状态表列表
    public function actionAccessStatusGet(){

        $params['token'] = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $params['page_num'] = !empty($_REQUEST['pageNum']) ? $_REQUEST['pageNum'] : '';
        if(empty($params['token'] ||  $params['page_num'])){
            $this->out('100005', '参数不能为空');
        }
        $rs = AccessStatusServer::getAccessStatus(['token'=>$params['token']]);
        if($rs['code'] == 0){
            $this->out('0', '成功', array('data' =>$rs['data']));
        }else{
            $this->out('100444', '读取失败', array('data' =>[]));

        }
    }

    //添加用户访问状态表
    public function actionAccessStatusAdd() {
        $params['token'] = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $params['page_num'] = !empty($_REQUEST['pageNum']) ? $_REQUEST['pageNum'] : '';
        $params['addtime'] = time();
        if( empty($params['token']) || empty($params['page_num'])){
            $this->out('100005', '参数不能为空');
        }
        $rs = AccessStatusServer::getAccessStatus(['token'=>$params['token']]);
        if ($rs['code'] == 0){
            $rs = AccessStatusServer::updateAccessStatus(array('token' =>  $params['token']), $params);
        }else{
            $rs = AccessStatusServer::addAccessStatus($params);
        }
        if ($rs['code'] == 0)
            $this->out('0', '添加、更新成功', array('id' => Yii::app()->db->getLastInsertID()));
        else
            $this->out('100444', '添加、更新失败');
    }
    //更新用户访问状态表
    public function actionAccessStatusUpdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $params['token'] = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $params['page_num'] = !empty($_REQUEST['page_num']) ? $_REQUEST['page_num'] : '';
        $params['addtime'] = !empty($_REQUEST['addtime']) ? $_REQUEST['addtime'] : '';
        if(empty($params['id']) || empty($params['token']) || empty($params['page_num']) || empty($params['addtime']) || empty(2))
            $this->out('100005', '参数不能为空');
        $rs = AccessStatusServer::updateAccessStatus(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }

    //删除用户访问状态表
    public function actionAccessStatusDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if (empty($id))
            $this->out('100005', '参数不能为空');
        $rs = AccessStatusServer::delAccessStatus(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }

}