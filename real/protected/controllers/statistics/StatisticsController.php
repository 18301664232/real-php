<?php

//统计
class StatisticsController extends CenterController {

    public function actionGetdata() {
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $class = !empty($_REQUEST['class']) ? $_REQUEST['class'] : 'ditch';
        $qd = !empty($_REQUEST['qd']) && $_REQUEST['qd'] != '全部渠道' ? $_REQUEST['qd'] : '';
        $excel = !empty($_REQUEST['excel']) ? $_REQUEST['excel'] : '';
        if (empty($product_id))
            $this->out('100005', '参数不能为空');
        $this->checkProduct($product_id);
        //选定时间
        $starttime = !empty($_REQUEST['starttime']) ? strtotime($_REQUEST['starttime']) : '';
        $endtime = !empty($_REQUEST['endtime']) ? strtotime($_REQUEST['endtime']) + (3600 * 24) : '';
        //固定时间
        $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        if ($type) {
            $t_rs = Tools::typetime($type);
            $starttime = $t_rs['starttime'];
            $endtime = $t_rs['endtime'];
        }

        //类别
        switch ($class) {
            case 'ditch':
                $rs = StatisticsServer::CountDitchList(array('product_id' => $product_id, 'starttime' => $starttime, 'endtime' => $endtime));
                break;
            case 'page':
                $rs = StatisticsServer::CountPageList(array('product_id' => $product_id, 'starttime' => $starttime, 'endtime' => $endtime, 'source_id' => $qd));
                break;
            case 'button':
                $rs = StatisticsServer::CountButtonList(array('product_id' => $product_id, 'starttime' => $starttime, 'endtime' => $endtime, 'source_id' => $qd));
                break;
            case 'userdata':
                if (!$excel)
                    $rs = StatisticsServer::CountUserdataList(array('product_id' => $product_id, 'starttime' => $starttime, 'endtime' => $endtime, 'source_id' => $qd));
                else
                    $rs = StatisticsServer::CountUserdataListExcel(array('product_id' => $product_id, 'starttime' => $starttime, 'endtime' => $endtime, 'source_id' => $qd));

                break;
            default:
                $rs = array();
        }
        //导表
        if ($excel) {
            $this->excel($rs, $class, $qd, $product_id);
        }

        $this->out('0', '查询成功', $rs);
    }

    private function excel($data, $class, $qd, $product_id) {
        if (empty($qd))
            $qd = '全部渠道';
        switch ($class) {
            case 'ditch':
                $filename = "渠道数据";
                $title = "渠道数据列表";
                $title_list = array(
                    array('key' => 'name', 'name' => '渠道名称'),
                    array('key' => 'pv', 'name' => '浏览次数 (PV)'),
                    array('key' => 'uv', 'name' => '独立访客 (UV)'),
                    array('key' => 'ip', 'name' => 'IP'),
                    array('key' => 'nv', 'name' => '新增独立访客'),
                );
                $list_data = $data;
                break;
            case 'page':
                $filename = "页面事件($qd)";
                $title = "页面事件数据列表($qd)";
                $title_list = array(
                    array('key' => 'page_name', 'name' => '页面名称'),
                    array('key' => 'pv', 'name' => '浏览次数 (PV)'),
                    array('key' => 'uv', 'name' => '独立访客 (UV)'),
                    array('key' => 'avg', 'name' => '页面平均停留时长'),
                );
                $list_data = $data;
                break;
            case 'button':
                $filename = "按钮事件($qd)";
                $title = "按钮事件数据列表($qd)";
                $title_list = array(
                    array('key' => 'button_name', 'name' => '按钮名称'),
                    array('key' => 'page', 'name' => '所在页面'),
                    array('key' => 'total', 'name' => '点击量'),
                );
                $list_data = $data;
                break;
            case 'userdata':
                $filename = "表单数据($qd)";
                $title = "表单数据列表($qd)";

                $title_list[] = array('key' => 'u_button_name', 'name' => '按钮名称');

                $title_list[] = array('key' => 'u_page', 'name' => '提交页面');
                $title_list[] = array('key' => 'u_name', 'name' => '渠道');
                $title_list[] = array('key' => 'u_addtime', 'name' => '添加时间');

                $check = array(); // 去除重复tip
                foreach ($data as $k => $v) {
                    $list[$k]['u_button_name'] = $v['button_name'];
                    $list[$k]['u_page'] = $v['page'];
                    $list[$k]['u_addtime'] = date('Ymd H:i:s', $v['addtime']);
                    $list[$k]['u_name'] = $v['name'];
                    $rs = json_decode($v['data'], true);
                    foreach ($rs as $kk => $vv) {
                        if ($vv['name'] == '' || $vv['name'] == 'undefined') {
                            $list[$k][$vv['userName']] = $vv['value'];
                            if (!in_array($vv['userName'], $check)) {
                                $check[] = $vv['userName'];
                                $title_list[] = array('key' => $vv['userName'], 'name' => $vv['userName']);
                            }
                        } else {
                            $list[$k][$vv['name']] = $vv['value'];
                            if (!in_array($vv['name'], $check)) {
                                $check[] = $vv['name'];
                                $title_list[] = array('key' => $vv['name'], 'name' => $vv['name']);
                            }
                        }
                    }
                }
                //print_r($list);
                //  print_r($title_list);
                //exit;
                $list_data = $list;
                break;
        }

        $params = array('filename' => $filename,
            'title' => $title,
            'cell_title' => $title_list,
            'list' => $list_data
        );



        //查看是否有单选多选图片
        $rs = ResourcesServer::selectjson(array('product_id' => $product_id, 'key' => 'preview_select.jpg'), 1, 999);
        if ($rs['code'] == 0) {
            foreach ($rs['data'] as $k => $v) {
                $filepath = UPLOAD_PATH . '/checkbox/';
                $name = time() . rand(11, 99) . '.jpg';
                $name_list[] = $filepath . $name;
                if (Tools::createDir($filepath)) {
                    $img_data = file_get_contents(PREVIEW . '/' . $v['datas']);
                    @file_put_contents($filepath . $name, $img_data);
                }
            }
            $params['img'] = $name_list;
        }

        ExcelTool::postExcerpt($params);
    }

}
