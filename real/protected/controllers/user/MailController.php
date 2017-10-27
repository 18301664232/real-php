<?php

/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017/9/20
 * Time: 17:48
 * 用户邮件类
 */

class MailController extends CenterController
{

    public $layout='site';


    public function init() {
        parent::init();
//        if (!$this->checkLogin())
//            $this->showMessage('未登录', U('user/login/login'));
    }

    //显示页面
    public function actionMailIndex(){
        $this->render('mes');
    }

    //获取用户邮件列表
    public function actionList(){

        $params['user_id'] = !empty( Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        if(empty($params['user_id'])){
            $this->out('100401','未登录');
        }
        $res = UserMailServer::getUserMail($params);
        if($res['code'] == 0){
            foreach ($res['data'] as $k=>$v){
                $res['data'][$k]['sendtime']=date('Y/m/d H:i',$v['sendtime']);
                switch ($res['data'][$k]['type']){
                    case 1:
                        $res['data'][$k]['type']='系统公告';
                        break;
                    case 2:
                        $res['data'][$k]['type']='消息提醒';
                        break;
                    case 3:
                        $res['data'][$k]['type']='系统警告';
                        break;
                }
            }
           $this->out('0','读取成功',['MailInfo'=>$res['data']]);
        }
           $this->out('100401','信息读取错误');

    }

    //邮件全部删除操作
    public function actionDelAll(){
        $params['user_id'] = !empty( Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
        if(empty($params['user_id'])){
            $this->redirect('user/login/login');
        }
        $res = UserMailServer::delUserMail($params);
        if($res['code'] == 0){
            $this->out('0','邮件删除成功');
        }
        $this->out('100401','邮件删除错误');

    }

    //邮件点击修改状态
    public function actionStatusRevise(){
        $params['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($params['id']))
            $this->out('100005', '参数不能为空');
        $res = UserMailServer::updateUserMail(['status'=>2],$params);
        if($res['code'] == 0){
            $this->out('0','邮件更新成功');
        }
            $this->out('100401','邮件更新错误');

    }

    //点击删除单个邮件

    public function actionUserMailDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($id))
            $this->out('100005', '参数不能为空');

        $rs = UserMailServer::delUserMail(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');
    }


}