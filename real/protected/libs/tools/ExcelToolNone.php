<?php

/**
 * Excel 工具类
 * @author wlei
 * @date 2013-07-22
 */
class ExcelToolNone {

    //26个栏目，不够的请继续添加AA,AB,AC,AD,AE......
    private static $cell = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    /**
     * 导出成员信息数据
     * @param $params=array()
     * 			filename	string	(excel文件名)可选
     * 			title		string	(sheet名称)可选
     * 			cell_title	array	(单元格标题，以及要读取的字段)必传
     * 			list		array	(要导出的数据)必传
     * @author wlei	 
     * @date 2013-07-22
     */
    public static function postExcerpt($params = array()) {
        $cell = self::$cell;
        $number = 1; //递增数字
        $filename = isset($params['filename']) ? $params['filename'] : date('Y-m-d-H-i');
        $title = isset($params['title']) ? $params['title'] : '导出数据';
        if (!isset($params['cell_title']) || !is_array($params['cell_title'])) {
            exit('no data');
        }
        if (!isset($params['list']) || !is_array($params['list'])) {
            exit('no list');
        }
        //$params['list'] =array();
        //创建一个excel
        $objPHPExcel = new PHPExcel();
        //缺省情况下，PHPExcel会自动创建第一个sheet被设置SheetIndex=0
        $objPHPExcel->setActiveSheetIndex(0);
        //设置当前sheet的名称
        $objActSheet = $objPHPExcel->getActiveSheet();
        $objActSheet->setTitle($title); //设置sheet的name
        //由PHPExcel根据传入内容自动判断单元格内容类型  //设置单元格的值

        foreach ($params['cell_title'] as $k => $v) {
            $objActSheet->setCellValue($cell[$k] . $number, $v['name']);
            //设置宽width//Set column widths
            $objActSheet->getColumnDimension($cell[$k])->setWidth(30);
        }
        $number++;

        foreach ($params['list'] as $k => $v) {
            foreach ($params['cell_title'] as $ck => $cv) {
                $objActSheet->setCellValueExplicit($cell[$ck] . $number, isset($v[$cv['key']]) ? $v[$cv['key']] : '', PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $number++;
        }

        $m_strOutputExcelFileName = $filename . '.xls';
        // 从浏览器输出EXCEL
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        // 从浏览器直接输出$m_strOutputExcelFileName
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type: application/vnd.ms-excel;");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename=" . $m_strOutputExcelFileName);
        header("Content-Transfer-Encoding:binary");
        $objWriter->save("php://output");
        exit;
    }

    /**
     * 获取excel数据
     * $params=array()
     * 			filepath	string		(文件路径)必传
     * @author wlei	 
     * @date 2013-07-22 
     */
    public static function getExcelList($params = array()) {
        if (!isset($params['filepath']) || empty($params['filepath'])) {
            return array('code' => '100000', 'message' => '文件路径不能为空');
        }
        if (!file_exists($params['filepath']) || !is_file($params['filepath'])) {
            return array('code' => '100001', 'message' => '文件路径不正确');
        }
        $list = array();
        //创建一个excel
        $objPHPExcel = new PHPExcel();
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load($params['filepath']);
        $sheet = $objPHPExcel->getSheet(0);
        //=========================获得行数
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow(); //总共行数
        //=========================获得列数
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); //总列数
        //导入的开始行数,从第二条开始
        for ($row = 2; $row <= $highestRow; $row++) {
            $data = array();
            //注意highestColumnIndex的列数索引从0开始
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $val = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                $data[$col] = is_null($val) ? '' : $val;
            }
            $list[] = $data;
        }
        //spl_autoload_unregister(array('PHPExcel_Autoloader', 'Load'));
        //spl_autoload_register(array('YiiBase','autoload'));
        return array('code' => '000000', 'message' => '', 'list' => $list);
    }

}

?>