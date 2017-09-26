<?php

//首页

class IndexController extends BaseController {

    public $layout = 'site'; //定义布局

    public function actionIndex() {
        $this->render('index');
    }

    public function actionDownload() {
        $this->render('download');
    }

    public function actionMode() {
        $this->render('mode');
    }

    public function actionBuilding() {
        $this->render('building');
    }

    public function actionHelp() {
        $rs = HelpServer::select();
        foreach ($rs['data'] as $k => $v) {
            if ($v['type'] == 1) {
                $list[$k]['title'] = $v['title'];
                $list[$k]['id'] = $v['id'];
            }
        }
        foreach ($list as $k => $v) {
            foreach ($rs['data'] as $kk => $vv) {
                if ($v['id'] == $vv['pid']) {
                    $list[$k]['child'][$kk]['title'] = $vv['title'];
                    $list[$k]['child'][$kk]['id'] = $vv['id'];
                }
            }
        }

        $this->render('help', array('data' => $list));
    }

    public function actionHelpajax() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($id))
            $this->out('100005', '参数不能为空');
        $rs = HelpServer::select(array('pid' => $id, 'type' => 3));
        $data = '';
        if ($rs['code'] == 0) {
            foreach ($rs['data'] as $k => $v) {
                $data[$k]['id'] = $v['id'];
                $data[$k]['title'] = $v['title'];
                $data[$k]['content'] = $v['content'];
            }
        }

        $this->out('0', 'ok', $data);
    }

    public function actionHelpajaxinfo() {
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if (empty($id))
            $this->out('100005', '参数不能为空');
        $rs = HelpServer::select(array('id' => $id, 'type' => 3));
        $data = '';
        if ($rs['code'] == 0) {
            foreach ($rs['data'] as $k => $v) {
                $data[$k]['id'] = $v['id'];
                $data[$k]['title'] = $v['title'];
                $data[$k]['content'] = $v['content'];
            }
        }

        $this->out('0', 'ok', $data);
    }

    public function actionHelpselect() {
        $keyword = !empty($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
        if (empty($keyword))
            $this->out('100005', '参数不能为空');
        $rs = HelpServer::selectlike(array('keyword' => $keyword, 'type' => 3,'pid'=>''));
        $data = '';
        if ($rs) {
            foreach ($rs as $k => $v) {
                $data[$k]['id'] = $v['id'];
                $data[$k]['title'] = $v['title'];
                $data[$k]['content'] = $v['content'];
                //查询标签
                $data[$k]['tab'] = $this->tab($v['pid']). $v['title'];
            }
        }
          $this->out('0', 'ok', $data);
    }
    
    private  function tab($pid,$str=''){ 
       
        $rs = HelpServer::select(array('id' => $pid)); 
        if($rs['code'] == 0){ 
            $str = $rs['data'][0]['title'].'>'.$str;
            $str = $this->tab($rs['data'][0]['pid'], $str); 
        }
            return $str;
        
    }

}
