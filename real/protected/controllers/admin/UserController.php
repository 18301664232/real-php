<?php

//后台管理(用户列表)
class UserController extends CenterController {

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
        $this->render('list');
    }


    //封停用户
    public function actionKillUser(){
        $params['user_id'] = !empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
        $params['reason'] = !empty($_REQUEST['reason']) ? $_REQUEST['reason'] : '';
        if(empty($params['user_id'])||empty($params['reason'])){
            $this->out('100005', '参数不能为空');
        }
        //修改状态
        $rs = UserServer::updateUser(['user_id'=> $params['user_id']],['status'=>2,'reason'=>$params['reason']]);
        if($rs['code']==0){
            //发送短信或者邮件
           $rs =  UserServer::getUserPhone([$params['user_id']]);
           if($rs['code'] ==0 ){
               if(!empty($rs['data'][0]->tel)){
                   CommonInterface::sendAliyunMsg($rs['data'][0]->tel, array('productname' =>$rs['data'][0]->tel,'productreason'=>$params['reason'] ),'SMS_111585387');
               }
               if(!empty($rs['data'][0]->email)){
                  $body = "【动壹科技】您的账号“$rs[data][0]->email”，因“$params[reason]”被封停，已被禁止登陆，请联系官方人员进行申诉。"; //邮件内容
                  UserMailServer::SendInternetEmail($rs['data'][0]->email,$body);
               }

           }

            $this->out('0', '封停成功');
        }
        $this->out('100044', '封停失败');

    }

    //解封用户
    public function actionLifeUser(){

        $params['user_id'] = !empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
        $params['reason'] = !empty($_REQUEST['reason']) ? $_REQUEST['reason'] : '';
        if(empty($params['user_id'])){
            $this->out('100005', '参数不能为空');
        }
        //修改状态

        $rs = UserServer::updateUser(['user_id'=> $params['user_id']],['status'=>1,'reason'=>$params['reason']]);
        if($rs['code']==0){
            //发送短信或者邮件
            $res =  UserServer::getUserPhone([$params['user_id']]);
            if(!empty($res['data'][0]->tel)){
              $rs =  CommonInterface::sendAliyunMsg($res['data'][0]->tel, array('productname' =>$res['data'][0]->tel,'productdate'=>date('Y-m-d H:i:s',time()) ),'SMS_110220058');
            }
            if(!empty($rs['data'][0]->email)){
                $body = "【动壹科技】您的账号“$rs[data][0]->email”，已于".date('Y-m-d H:i:s',time())."解除封停，请您知晓。"; //邮件内容
                UserMailServer::SendInternetEmail($rs['data'][0]->email,$body);
            }

            $this->out('0', '修改成功');
        }
        $this->out('100044', '修改失败');



    }

    //ajax渲染主页数据
    public  function  actionGetListAjax(){

        //ajax接收当前页数
        $now_page = !empty($_REQUEST['page']) ? $_REQUEST['page']:'';
        $time_type = !empty($_REQUEST['time_type']) ? $_REQUEST['time_type']:'';
        $user_type = !empty($_REQUEST['user_type']) ? $_REQUEST['user_type']:'';
        $user_status_type = !empty($_REQUEST['user_status_type']) ? $_REQUEST['user_status_type']:'';
        $need_excel = !empty($_REQUEST['need_excel']) ? $_REQUEST['need_excel']:'';
        if(!$now_page){
            $this->out('100000','当前页码不存在');
        }
        if(!$time_type || !$user_type){
            $this->out('100005','有参数为空');
        }
        $page_limit = 4;
        $page_offset = ($now_page-1) * $page_limit;
        if(!empty($_REQUEST['start_time'])){
            $params['start_time'] = $_REQUEST['start_time'];
        }
        if(!empty($_REQUEST['end_time'])){
            $params['end_time'] = $_REQUEST['end_time'];
        }
        $params['search_key'] = '';
        if(!empty($_REQUEST['search_key'])){
            $params['search_key'] = $_REQUEST['search_key'];
        }
        switch ($time_type){
            case '1':
                $start_time = strtotime(date('Y-m-d', time()));
                $end_time = time();
                break;
            case '2':
                $start_time = strtotime(date('Y-m-d', time()-(3600*24)));
                $end_time = strtotime(date('Y-m-d', time()));
                break;
            case '7':
                $start_time = strtotime(date('Y-m-d', time()-(3600*24*6)));
                $end_time = time();
                break;
            case '15':
                $start_time = strtotime(date('Y-m-d', time()-(3600*24*14)));
                $end_time = time();
                break;
            case '30':
                $start_time = strtotime(date('Y-m-d', time()-(3600*24*29)));
                $end_time = time();
                break;
            case 'self':
                if(empty($params['start_time']) || empty($params['end_time'])){
                    $this->out('100402','时间参数为空');
                }
                $start_time = strtotime($params['start_time']);
                $end_time = strtotime($params['end_time']);
                break;
            case 'total':
                $start_time = 0;
                $end_time = time()+100000;
                break;

        }

        $rs = UserServer::getAdminManageDate($user_type,$user_status_type,$start_time,$end_time,$page_limit,$page_offset,$params['search_key'],$need_excel);
        if($rs['code'] == 0){
            if(!empty($need_excel)){
                $filename = "用户数据";
                switch ($user_type){
                    case 'total':
                        $title = "全部用户列表";
                        break;
                    case 'register':
                        $title = "注册用户列表";
                        break;
                    case 'login':
                        $title = "登录用户列表";
                        break;
                    case 'issuance':
                        $title = "发布用户列表";
                        break;
                    case 'pay':
                        $title = "支付用户列表";
                        break;

                }

                $title_list = array(
                    array('key' => 'tel', 'name' => '账号'),
                    array('key' => 'total_product', 'name' => '项目个数'),
                    array('key' => 'addtime', 'name' => '注册时间'),
                    array('key' => 'last_time', 'name' => '最后登录'),
                    array('key' => 'total_money', 'name' => '消费金额'),
                    array('key' => 'status', 'name' => '账户状态1'),
                );
                $list_data = $rs['data'];

                foreach ($list_data as $k =>$v){
                    foreach ($list_data[$k] as $key=>$vel){
                        if(empty($vel)){
                            $list_data[$k][$key] = ' ';
                        }
                        if($key == 'addtime' || $key=='last_time'){
                            $list_data[$k][$key] = date('Y-m-d H:s:i',$vel);
                        }
                    }
                }

                $params = array('filename' => $filename,
                    'title' => $title,
                    'cell_title' => $title_list,
                    'list' => $list_data,
                );

                //var_dump($params);die;
                ExcelTool::postExcerpt($params);
                exit;

            }

            $c_count = $rs['c_count'];
            $count = count($rs['data']);
            $pages = ceil($c_count/$page_limit);
            if($pages == 0){
                $pages=1;
            }
            $this->out('0','数据读取成功',['data'=>$rs['data'],'count'=>$count,'c_count'=>$c_count,'pages'=>$pages]);
        }
        $this->out('100401','数据读取失败');


    }


    //获取用户详情数据
    public function actionGetUserDetails() {
        $params['user_id'] = !empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
        if(empty($params['user_id'])){
            $this->out('100005', '参数不能为空');
        }
        //获取用户基本信息
        $user_base_data = UserServer::GetSelfUser(['user_id'=>$params['user_id']]);
        if($user_base_data['code'] != 0){
            $this->out('100006', '用户基本信息查询失败');
        }
        //获取用户付费项目信息
        $user_product_pay = ProductServer::getList(['user_id'=>$params['user_id'],'pay'=>'yes','online'=>'online']);
//        if($user_product_pay['code'] != 0){
//            $this->out('100007', '用户付费项目信息查询失败');
//        }
        //获取用户免费项目信息
        $user_product_notpay = ProductServer::getList(['user_id'=>$params['user_id'],'pay'=>'no','online'=>'online']);
//        if($user_product_notpay['code'] != 0){
//            $this->out('100008', '用户免费项目信息查询失败');
//        }
        //获取用户线下项目信息
        $user_product_notonline = ProductServer::getList(['user_id'=>$params['user_id'],'online'=>'ontonline']);
//        if($user_product_notonline['code'] != 0){
//            $this->out('100009', '用户线下信息查询失败');
//        }
        //获取用户订单列表信息
        $user_order_info = FlowServer::getOrder(['user_id'=>$params['user_id'],'status'=>'yes']);
//        if($user_order_info['code'] != 0){
//            $this->out('100010', '用用户订单列表信息查询失败');
//        }

        if($user_product_pay['data'] == ''){
            $user_product_pay['data'] = [];
        }
        if($user_product_notpay['data']==''){
            $user_product_notpay['data'] = [];
        }
        if($user_product_notonline['data']==''){
            $user_product_notonline['data'] = [];
        }


        //遍历数组
        $list = [
            'user_base_data'=>$user_base_data['data'],
            'user_order_info'=>$user_order_info['data'],
            'user_product_pay'=>count($user_product_pay['data']),
            'user_product_notpay'=>count($user_product_notpay['data']),
            'user_product_notonline'=>count($user_product_notonline['data']),
        ];

        $this->out('0', '成功', array('data' => $list));
    }

}
