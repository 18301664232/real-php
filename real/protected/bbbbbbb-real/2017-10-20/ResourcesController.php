<?php

//项目素材
class ResourcesController extends CenterController {

    public $page = 1;
    public $pagesize = 20;

    //添加素材
    public function actionAdd() {
        $params['product_id'] = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $params['param'] = !empty($_REQUEST['param']) ? $_REQUEST['param'] : '';

        if (empty($params['product_id']) || empty($params['param']))
            $this->out('100005', '参数不能为空');
        //验证product_id是否正确
        $rs = ProductServer::getList(array('product_id' => $params['product_id']));
        if ($rs['code'] != 0) {
            $this->out('100004', 'id错误');
        }
        if (is_array($params['param'])) {
            //开启事物处理
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($params['param'] as $k => $v) {
                    $data['product_id'] = $params['product_id'];
                    $data['datas'] = $v;
                    $data['addtime'] = time();
                    $rs = ResourcesServer::add($data);
                    if ($rs['code'] != 0) {
                        throw new CException('添加失败', 100001);
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                $this->out($e->getCode(), $e->getMessage());
            }

            //调用node通知
            $r = $this->postCurl(NODE . '/upload', json_encode(array('pid' => $params['product_id'], 'filelist' => $params['param'])), true);
            if ($r['code'] == '0')
                $this->out('0', '保存成功');
            else
                $this->out('100007', 'node保存错误');
        } else
            $this->out('100003', '参数格式错误');
    }

    //添加预览素材
    public function actionPreview() {
        $params['product_id'] = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $params['param'] = !empty($_REQUEST['param']) ? $_REQUEST['param'] : '';
        $params['soures'] = !empty($_REQUEST['soures']) ? $_REQUEST['soures'] : '';
        $params['videoPath'] = !empty($_REQUEST['videoPath']) ? $_REQUEST['videoPath'] : [];
        if (empty($params['product_id']) || empty($params['param']) || empty($params['soures']))
            $this->out('100005', '参数不能为空');
        //验证product_id是否正确
        $rs = ProductServer::getList(array('product_id' => $params['product_id']));
        if ($rs['code'] != 0) {
            $this->out('100004', 'id错误');
        }
///////////////////////////////////////////////////////////////////////

//        //判断当前的product_id在数据库是否存在video_path
//        $is_save = ResourcesServer::getResourcesVideo(['product_id'=>$params['product_id']]);
//        if($is_save['code'] == 0){
//            //已经存在更新更新video_path
//            $v_arr=json_decode($is_save['data'][0]['video_path']);
//            $v_arr_res=array_diff($params['videoPath'],$v_arr);//判断差集
//            if(!empty($v_arr_res)) {
//                //如果提交的视频路径差集不为空就更新数据库
//                foreach ($v_arr_res as $k => $v) {
//                    array_push($v_arr, $v);//把差集加到新的数组中
//                }
//            }
//            ResourcesServer::updateResourcesVideo(['video_path' => json_encode($v_arr)],['id' => $is_save['data'][0]['id']]);
//        }else{
//            //添加视频video_path
//            $params_video['product_id'] = $params['product_id'];
//            $params_video['addtime'] = time();
//            $params_video['video_path'] = json_encode($params['videoPath']);
//            ResourcesServer::addResourcesVideo($params_video);
//        }

////////////////////////////////////////////////////////////////////////////////////////

       // file_put_contents('aa.php', json_encode( $params['param']));
       // $str = '{"page":["realapp_3022f0814c84ab3bbf0faeffd2708b32"],"config":["realapp_09ba82d36e9e8b420c87aaa4824bb756","realapp_351805741e0b898ebdab0c45e1443d52","realapp_25f571ea13e26466b833474e934b7370","realapp_c0834a30bcb2d7ef38b0bbe89a7cb0f0"]}';
      //  $params['soures'] = json_decode($str, true);
      //  $params['param'] = array('aa');
        if (is_array($params['param'])) {
            //开启事物处理
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //上线状态更新素材后需要变成待更新（待更新和未上线项目不做操作）
                if ($rs['data'][0]['online'] == 'online') {
                    //获取json串
                    $rs_json = ResourcesServer::getjson(array('product_id' => $params['product_id']));
                    if ($rs_json['code'] == 0) {
                        //比对
                        $rs = $this->ChangeProduct($params['soures'], $rs_json['data'][0]['str']);
                        if ($rs) {
                            //更新
                            $rs = ProductServer::updateProduct(array('product_id' => $params['product_id']), array('online' => 'update', 'updatetime' => time()));
                            if ($rs['code'] != 0) {
                                throw new CException('添加失败', 100002);
                            }
                        }
                    }
                }

                foreach ($params['param'] as $k => $v) {
                    $data['product_id'] = $params['product_id'];
                    $data['datas'] = $v;
                    $data['addtime'] = time();
                    $rs = ResourcesServer::select(array('datas' => $v), $this->page, $this->pagesize);
                    if ($rs['code'] != 0) {
                        //添加
                        $rs = ResourcesServer::addPreview($data);
                        if ($rs['code'] != 0) {
                            throw new CException('添加失败', 100001);
                        }
                    } else {
                        //更新时间
                        $rs = ResourcesServer::update(array('id' => $rs['data'][0]['id']), array('addtime' => time()));
                        if ($rs['code'] != 0) {
                            throw new CException('添加失败', 100004);
                        }
                    }
                }

                $transaction->commit();
                $this->out('0', '保存成功');
            } catch (Exception $e) {
                $transaction->rollback();
                $this->out($e->getCode(), $e->getMessage());
            }
        } else
            $this->out('100003', '参数格式错误');
    }

    private function ChangeProduct($data, $json) {
        //验证页面有没有变化
        if (isset($data['page']) && $data['page'] != 'undefined') {
            foreach ($data['page'] as $v) {
                if (strpos($json, $v)) {
                    return true;
                }
            }
        }

        //验证配置页面有没有变化
        if (isset($data['config']) && $data['config'] != 'undefined') {
            $json = json_decode($json, true);
            if (!isset($json['proConfig']) || empty($json['proConfig']))
                return false;  // 新加的配置不改变状态               
//解析json
            $list = array();
            foreach ($json['proConfig'] as $v) {
                $list[$v['jsData']['id']] = $v['enable'];
            }

            foreach ($data['config'] as $v) {
                if (isset($list[$v]) && $list[$v] == 'true')
                    return true;
            }
        }
        return false;
    }

    //跳转到制作页面
    public function actionLocal() {
        //生成token 
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        if (empty($product_id))
            $this->out('100005', '参数不能为空');
        $key = md5($product_id . time() . rand());
        $data['product_id'] = $product_id;
        $data['time'] = time();
        $str = json_encode($data);
        //写入redis
        Yii::app()->redis->getClient()->set($key, $str, 3600 * 24);
        //跳转
        $url = WTEDITOR;
        echo "<script>window.location.href='$url?token=$key'</script>";
    }


    //获取用户素材
    public function actionGetresources() {
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $page = !empty($_REQUEST['page']) ? $_REQUEST['page'] : $this->page;
        $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        if (empty($token))
            $this->out('100005', '参数不能为空');
        //根据token换取信息
        $data = Yii::app()->redis->getClient()->get($token);
        if (!empty($data)) {
            $data = json_decode($data, true);
            if ($type == 'config'){
                $key = '_$config$_config.json';
            }else if ($type == 'layer'){
                $key = 'layer';
            }else{
                $key = '_$config$.json';
            }
            $rs = ResourcesServer::selectjson(array('product_id' => $data['product_id'], 'key' => $key), $page, $this->pagesize);
            if($rs['code'] == '0'){
                $this->out('0', '获取成功', $rs['data']);
            }else{

                $this->out('100444', '获取失败');
            }

        } else {
            $this->out('100003', 'token失效');
        }
    }
   

    //开放到云端
    public function actionCloud() {
        if (!$this->checkLogin())
            $this->out('100008', '登录失效');
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        if (empty($token))
            $this->out('100005', '参数不能为空');
        //根据token换取信息
        $data = Yii::app()->redis->getClient()->get($token);
        if (!empty($data)) {
            $data = json_decode($data, true);
            $rs = ProductServer::getList(array('product_id' => $data['product_id']));
            if (empty($rs))
                $this->out('100002', 'token错误');
            $params['cloud'] = 'no';
            if ($rs['data'][0]['cloud'] == 'no') {
                $params['cloud'] = 'yes';
            }
            $r = ProductServer::updateProduct(array('product_id' => $data['product_id']), $params);
            if ($r)
                $this->out('0', '获取成功');
            else
                $this->out('100001', '失败');
        }else {
            $this->out('100003', 'token失效');
        }
    }

    //删除素材（事物）
    public function actionDelresources() {
        if (!$this->checkLogin())
            $this->out('100008', '登录失效');
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $param = !empty($_REQUEST['param']) ? $_REQUEST['param'] : '';
        if (empty($token) || empty($param))
            $this->out('100005', '参数不能为空');
        //根据token换取信息
        $data = Yii::app()->redis->getClient()->get($token);
        if (!empty($data)) {
            $data = json_decode($data, true);
            if (is_array($param)) {
                //判断删除的文件是否是该用户的项目
                $pid = explode('/', $param[0]);
                if (SHA1($data['product_id']) != $pid[1])
                    $this->out('100002', '权限不够');
                //开启事物处理
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    foreach ($param as $k => $v) {
                        // $this->delOss($v);  不删除oss素材
                        $del_rs = ResourcesServer::del(array('datas' => $v));
                        if ($del_rs['code'] != 0) {
                            throw new CException('删除失败', 100001);
                        }
                    }
                    $transaction->commit();
                    $this->out('0', '删除成功');
                } catch (Exception $e) {
                    $transaction->rollback();
                    $this->out($e->getCode(), $e->getMessage());
                }
            }
            $this->out('100004', '参数错误');
        } else {
            $this->out('100003', 'token失效');
        }
    }

//    private function delOss($data){ 
//        $new_data = 'warehouse/'.$data;
//        $r = OssServer::copyObject('realadobe',$data,'realadobe',$new_data); 
//        if($r) OssServer::deleteObject('realadobe',$data);
//    }



    //保存项目信息（事物）
    public function actionSaveinfo() {
        // if(!$this->checkLogin())$this->out('100008','登录失效');
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $param = !empty($_REQUEST['param']) ? $_REQUEST['param'] : '';
        $str = !empty($_REQUEST['str']) ? $_REQUEST['str'] : '';
        $link = !empty($_REQUEST['link']) ? $_REQUEST['link'] : '';
        $coreChange = !empty($_REQUEST['coreChange']) ? $_REQUEST['coreChange'] : '';
        $param_config = !empty($_REQUEST['param_config']) ? $_REQUEST['param_config'] : '';
        if (empty($token) || empty($param) || empty($str))
            $this->out('100005', '参数不能为空');

        //根据token换取信息
        $data = Yii::app()->redis->getClient()->get($token);
        if (!empty($data)) {
            $data = json_decode($data, true);
            $list = ProductServer::getList(array('product_id' => $data['product_id']));
            if (empty($list))
                $this->out('100002', 'token错误');
            //@syl检查当前项目有没有视频
            foreach ((json_decode($param)->list) as $k=>$v) {
                if (!empty($v->videoPath)) {
                    $params['is_has_video'] = 2;//表示有视频项目
                    break;
                }else{
                    $params['is_has_video'] = 1;
                }
            }

            $params['product_id'] = $data['product_id'];
            $params['datas'] = $param;
            $params['str'] = $str;
            $params['status'] = 1;
            $params['addtime'] = time();
            $status = $list['data'][0]['online'];
            //检查数据(如果数据没有改动状态不变，如果改动则变为待更新
            if ($coreChange == 'true') {
                if ($status == 'online' || $status == 'update')
                    $status = 'update';
                else
                    $status = 'notonline';
            }

            //保存信息
            //开启事物处理
            $transaction = Yii::app()->db->beginTransaction();
            try {
                //删除配置
                if (is_array($param_config)) {
                    foreach ($param_config as $k => $v) {
                        //  $this->delOss($v);  不删除oss素材
                        $del_rs = ResourcesServer::del(array('datas' => $v));
                        if ($del_rs['code'] != 0) {
                            throw new CException('删除失败', 100001);
                        }
                    }
                }

                $add_rs = ResourcesServer::savejson($params);
                if ($add_rs['code'] != 0) {
                    throw new CException('保存失败', 100002);
                }
                $update_rs = ProductServer::updateProduct(array('product_id' => $data['product_id']), array('online' => $status, 'updatetime' => time(), 'cover' => $link));
                if ($update_rs['code'] != 0) {
                    throw new CException('保存失败', 100004);
                }
                $transaction->commit();
                $this->out('0', '保存成功');
            } catch (Exception $e) {
                $transaction->rollback();
                $this->out($e->getCode(), $e->getMessage());
            }
        } else
            $this->out('100003', 'token失效');
    }

    //点完编辑按钮初始化项目
    public function actionIndex() {
        // if(!$this->checkLogin())$this->out('100008','登录失效');
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        if (empty($token))
            $this->out('100005', '参数不能为空');
        //根据token换取信息
        $data = Yii::app()->redis->getClient()->get($token);
        if (!empty($data)) {
            $data = json_decode($data, true);
            $list = ProductServer::getList(array('product_id' => $data['product_id']));
            if (empty($list))
                $this->out('100002', 'token错误');
            $rs = ResourcesServer::getjson(array('product_id' => $list['data'][0]['product_id']));
            $json = '';
            $cloud = $list['data'][0]['cloud'];
            if ($rs['data']) {
                $json = $rs['data'][0]['datas'];
            }
            //返回后台系统数据
            $datas = $this->obj($list['data'][0]['product_id'], $json);
            $this->out('0', '成功', array('pid' => $list['data'][0]['product_id'], 'path' => $list['data'][0]['path'], 'cloud' => $cloud, 'title' => $list['data'][0]['title'], 'data' => $datas));
        } else
            $this->out('100003', 'token失效');
    }

    //合并系统数据
    private function obj($pid, $json) {
        $data = array();
        //查询音乐图标位置
        $music_location_list = MusicServer::location(array());
        if ($music_location_list['code'] == 0) {
            foreach ($music_location_list['data'] as $k => $v) {
                $music_location[] = array('txt' => $v['name'], 'uid' => $v['uid'], 'key' => $v['jskey']);
            }
        } else
            $music_location = array();
        $data['music']['positionlist'] = $music_location;

        //查询我的音效
        $music_person_list_1 = MusicServer::person(array('product_id' => $pid, 'status' => 1));
        if ($music_person_list_1['code'] == 0) {
            foreach ($music_person_list_1['data'] as $k => $v) {
                $music_person_1[] = array('txt' => $v['name'], 'uid' => $v['uid'], 'url' => PREVIEW . $v['url'], 'size' => $v['music_size']);
            }
        } else
            $music_person_1 = array();
        $data['music']['mylist'] = $music_person_1;

        //查询常用音效
//         $music_person_list_2 = MusicServer::person(array('user_id'=>$pid,'status'=>2));
//          if($music_person_list_2['code']==0){
//            foreach($music_person_list_2['data'] as $k=>$v){
//                $music_person_2[] = array('txt'=>$v['name'],'uid'=>$v['uid'],'url'=>PREVIEW.$v['url'],'size'=>$v['music_size']);
//            }
//        }else $music_person_2 = array();
//        $data['music']['commonlist']=$music_person_2;
        //查询系统音效
        $music_system_list = MusicServer::system(array());
        if ($music_system_list['code'] == 0) {
            foreach ($music_system_list['data'] as $k => $v) {
                $music_system[] = array('txt' => $v['name'], 'uid' => $v['uid'], 'url' => PREVIEW . $v['url'], 'size' => $v['music_size']);
            }
        } else
            $music_system = array();
        $data['music']['systemlist'] = $music_system;

        //查询手势
        $transform_trigger_list = TransformServer::trigger(array());
        if ($transform_trigger_list['code'] == 0) {
            foreach ($transform_trigger_list['data'] as $k => $v) {
                $transform_trigger[] = array('txt' => $v['name'], 'uid' => $v['uid'], 'key' => $v['jskey']);
            }
        } else
            $transform_trigger = array();
        $data['transform']['triggertList'] = $transform_trigger;


        //查询效果
        $transform_effect_list = TransformServer::effect(array());
        if ($transform_effect_list['code'] == 0) {
            foreach ($transform_effect_list['data'] as $k => $v) {
                $transform_effect[] = array('txt' => $v['name'], 'uid' => $v['uid'], 'dir' => json_decode($v['dir'], true), 'key' => $v['jskey']);
            }
        } else
            $transform_effect = array();
        $data['transform']['effectList'] = $transform_effect;
        $data['transform']['default'] = array('next' => array('triggert' => 'bHScR19kR2', 'effect' => 'MPq0yOYAvN', 'dir' => 'enBqbUh7kM'), 'prev' => array('triggert' => 'a8ggWRX7da', 'effect' => 'MPq0yOYAvN', 'dir' => 'C7WkmTqc2p'));
        //方向列表
        $transform_dir_list = TransformServer::dir(array());
        if ($transform_dir_list['code'] == 0) {
            foreach ($transform_dir_list['data'] as $k => $v) {
                $transform_dir[] = array('txt' => $v['name'], 'uid' => $v['uid'], 'key' => $v['jskey']);
            }
        } else
            $transform_dir = array();
        $data['transform']['dirList'] = $transform_dir;

        //查询总设置
        $transform_list = TransformServer::transform(array());
        if ($transform_list['code'] == 0) {
            foreach ($transform_list['data'] as $k => $v) {
                if ($v['uid'] == 'times') {
                    $arr = json_decode($v['jsobj'], true);
                    $transform = array($arr['min'], $arr['max']);
                }
            }
        } else
            $transform = array(0, 0);
        $data['transform']['time'] = $transform;
        return array('system' => $data, 'user' => $json);
    }

    //添加音乐
    public function actionAddmusic() {
        if (!$this->checkLogin())
            $this->out('100008', '登录失效');
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $music = !empty($_FILES["music"]["tmp_name"]) ? $_FILES["music"]["tmp_name"] : '';
        if (empty($token) || empty($music))
            $this->out('100005', '参数不能为空');
        if ($_FILES['music']['size'] > 1024 * 1024 * 5) {
            $this->out('100004', 'MP3不能超过5M');
        }

        if (!in_array($_FILES['music']['type'], array('audio/mpeg', 'audio/mp3'))) {
            $this->out('100006', 'MP3格式错误');
        }
        //根据token换取信息
        $data = Yii::app()->redis->getClient()->get($token);
        if (!empty($data)) {
            $data = json_decode($data, true);
            $list = ProductServer::getList(array('product_id' => $data['product_id']));
            if (empty($list))
                $this->out('100002', 'token错误');
            $new_name = md5($_FILES["music"]["name"] . rand(1, 999999)) . '.mp3';
            $rs = OssServer::uploadFile('realadobe', "music/$new_name", $_FILES["music"]["tmp_name"]);
            if ($rs) {
                $params['user_id'] = $list['data'][0]['user_id'];
                $params['product_id'] = $data['product_id'];
                $params['uid'] = $this->creatId();
                $params['name'] = $_FILES["music"]["name"];
                $params['url'] = "music/$new_name";
                $params['music_size'] = $_FILES['music']['size'];
                $params['status'] = 1; //1为上传，2为常用
                $params['addtime'] = time();
                $rs = MusicServer::add($params);
                if ($rs['code'] == 0) {
                    $this->out('0', '上传成功', array('name' => $params['name'], 'url' => PREVIEW . $params['url'], 'size' => $params['music_size'], 'uid' => $params['uid']));
                } else
                    $this->out('100001', '上传失败');
            } else
                $this->out('100001', '上传失败');
        } else
            $this->out('100003', 'token失效');
    }

    //删除音乐
    public function actionDelmusic() {
        if (!$this->checkLogin())
            $this->out('100008', '登录失效');
        $token = !empty($_REQUEST['token']) ? $_REQUEST['token'] : '';
        $uid = !empty($_REQUEST['uid']) ? $_REQUEST['uid'] : '';
        if (empty($token) || empty($uid))
            $this->out('100005', '参数不能为空');
        $data = Yii::app()->redis->getClient()->get($token);
        if (!empty($data)) {
            $data = json_decode($data, true);
            $params['product_id'] = $data['product_id'];
            $params['uid'] = $uid;
            //查询音乐地址
            $data = MusicServer::person($params);
            $rs = MusicServer::del($params);
            if ($rs['code'] == 0) {
                OssServer::deleteObject('realadobe', $data['data'][0]['url']);
                $this->out('0', '删除成功');
            } else
                $this->out('100001', '删除失败');
        } else
            $this->out('100003', 'token失效');
    }

}
