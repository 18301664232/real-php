<?php

//文件上传控制器
class ExcelController extends BaseController {

    public $layout = 'index'; //定义布局

    public function actionPutexc() {
        $data = new mysql1();
        $criteria = new CDbCriteria;
        //查询字段
        $criteria->select = 'user_id, user_name, person_id, user_type, active_id, user_org_id,
		user_org_name,area,area_code,user_status,created,updated,user_level,phone,presentation,video';
        $criteria->limit = 50;   //取1条数据，如果小于0，则不作处理
        $criteria->offset = 0;   //两条合并起来，则表示 limit 10
        $list = $data->findAll($criteria);
        $list = json_decode(CJSON::encode($list), TRUE); //因为是对象无法输出，需要转为数组
        if (empty($list)) {
            $this->showMessage('无导出数据');
        }
        $params = array('filename' => date('Y-m-d'),
            'title' => '报名表',
            'cell_title' => array(
                array('key' => 'user_name', 'name' => '姓名'),
                array('key' => 'person_id', 'name' => '用户ID'),
                array('key' => 'user_type', 'name' => '用户类型'),
            ),
            'list' => $list
        );
        ExcelTool::postExcerpt($params);
        exit;
    }

    public function actionGetexc() {
        if (!empty($_FILES["inputExcel"]["name"])) {
            if ($_FILES["inputExcel"]["error"] > 0) {
                echo "Error: " . $_FILES["inputExcel"]["error"];
                exit;
            }
            $uploaddir = "uploads/Excels/" . date("Y-m-d");
            $data = array();
            if (Tools::createDir($uploaddir)) {
                $uploadpath = $uploaddir . '/' . $_FILES["inputExcel"]["name"];
                //移动文件
                move_uploaded_file($_FILES["inputExcel"]["tmp_name"], $uploadpath);
                //导出数据
                $data = ExcelTool::getExcelList(array('filepath' => $uploadpath));
            }
            dump($data);
        }
        $this->render('excel');
    }

}
