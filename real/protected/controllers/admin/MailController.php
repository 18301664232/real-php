<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-08-28 05:41:58
 */
class MailController extends CenterController
{
    public $page = 1;
    public $pagesize = 20;
    public $layout = 'admin'; //定义布局


    public function init() {
        parent::init();
        if (!$this->checkLogin('admin'))
            $this->showMessage('未登录', U('admin/login/login'));
    }

    //显示页面
    public function actionList(){
        $this->render('list');
    }

    //读取邮件数据表列表
    public function actionAjax(){

        $params['type'] = !empty($_REQUEST['message_type']) ? $_REQUEST['message_type'] : '';
        $change['type'] =!empty($_REQUEST['message_status']) ? $_REQUEST['message_status'] : '';
        $change['like'] =!empty($_REQUEST['like']) ? $_REQUEST['like'] : '';
        $change['mailid'] =!empty($_REQUEST['mailid']) ? $_REQUEST['mailid'] : '';

            $mail_list =UserMailServer::getMail(!empty($change['mailid'])?$change['mailid']:'',!empty($params['type'])?$params['type']:'',!empty($change['type'])?$change['type']:'',!empty($change['like'])?$change['like']:'');
             if ($mail_list['code'] == 0) {
               $list['mail'] = $mail_list['data'];
                 $this->out('0', '成功', array('data' => $list));
             }else{
                 $this->out('100401', '失败', array('data' => ''));
             }

    }

    //草稿按钮发送请求
    public function actionDraftSend(){
        $params['lastid'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if(empty($params['lastid']))
            $this->out('100005', '参数不能为空');
        //获取对应的用户列表
        $user_list = UserServer::selUser(['pc_type' => 1]);
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //循环发送邮件
            $rs = UserMailServer::SendMail($user_list,$params['lastid']);
            if ($rs ['code'] != 0) {
                throw new CException('发送邮件失败', 1000401);
            }
            $rs_updete = UserMailServer::updateMail(array('id' => $params['lastid']), ['status'=>2,'sendtime'=>time()]);
            if ($rs_updete ['code'] != 0) {
                throw new CException('更新邮件失败', 1000441);
            }
            $transaction->commit();
        }catch (Exception $e) {
            $transaction->rollback();
            $this->out($e->getCode(), $e->getMessage());
        }

        if ($rs['code'] == 0)
            $this->out('0', '发送成功');
        else
            $this->out('100001', '邮件发送失败');


    }

    //添加邮件数据表
    public function actionMailadd() {
        $params['btn_type'] = !empty($_REQUEST['btn_type']) ? $_REQUEST['btn_type'] : '';
        $params['title'] = !empty($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $params['contents'] = !empty($_REQUEST['content']) ? ($_REQUEST['content']) : '';
        $params['addtime'] = time();
        if(empty($params['title']) || empty($params['type']) || empty($params['btn_type']) || empty($params['contents']) || empty(2)){
            $this->out('100005', '参数不能为空');
        }
        //直接发送邮件请求
        if($params['btn_type'] == 'send'){
            $params['sendtime']=time();
            $params['status'] = 2;//代表已经发送
            //获取对应的用户列表
            $user_list = UserServer::selUser(['pc_type' => 1]);
            if($user_list['code'] != '0'){
                $this->out('100044', '获取用户列表失败');
            }
            //开启事处理
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $rs = UserMailServer::addMail($params);
                if ($rs['code'] != 0) {
                    throw new CException('添加邮件失败', 100001);
                }
                //循环发送邮件
                $rs = UserMailServer::SendMail($user_list,$rs['lastid']);
                if ($rs ['code'] != 0) {
                    throw new CException('发送邮件失败', 1000401);
                }
                $transaction->commit();
            }catch (Exception $e) {
                $transaction->rollback();
                $this->out($e->getCode(), $e->getMessage());
            }
         //如果不是发送请求保存为草稿
        }else{
            $params['status'] = 1;//代表存为草稿
            $rs = UserMailServer::addMail($params);
        }
        if ($rs['code'] == 0)
            $this->out('0', '邮件创建/发送成功');
        else
            $this->out('100001', '邮件创建失败');
    }

    //更新邮件数据表
    public function actionMailupdate() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $params['title'] = !empty($_REQUEST['title']) ? $_REQUEST['title'] : '';
        $params['type'] = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $params['contents'] = !empty($_REQUEST['content']) ? $_REQUEST['content'] : '';
        if(empty($id) || empty($params['title']) || empty($params['type']) || empty($params['contents']) || empty(2))
            $this->out('100005', '参数不能为空');
        $rs = UserMailServer::updateMail(array('id' => $id), $params);
        if ($rs['code'] == 0)
            $this->out('0', '修改成功');
        else
            $this->out('100001', '修改失败');
    }
    //删除邮件数据表
    public function actionMailDel() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($id))
            $this->out('100005', '参数不能为空');
        $rs = UserMailServer::delMail(array('id' => $id));
        if ($rs['code'] == 0)
            $this->out('0', '删除成功');
        else
            $this->out('100001', '删除失败');

    }

}