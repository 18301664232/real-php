<?php
include 'PHPExcel.php';
//include 'PHPExcel/Writer/Excel2007.php';
//include 'PHPExcel/Writer/Excel5.php'; //用于输出.xls的
//创建一个excel
$objPHPExcel = new PHPExcel();
//设置当前的sheet
$objPHPExcel->setActiveSheetIndex(0);

//设置sheet的name
$objPHPExcel->getActiveSheet()->setTitle('Simple');
//设置单元格的值
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'String');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 12);
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'h哈哈');
$objPHPExcel->getActiveSheet()->setCellValue('C5', '=SUM(C2:C4)');
$objPHPExcel->getActiveSheet()->setCellValue('B8', '=MIN(B2:C5)');
$m_strOutputExcelFileName='xxx.xls';
// 从浏览器输出EXCEL
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// 从浏览器直接输出$m_strOutputExcelFileName
header("Pragma: public");
header("Expires: 0");
header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
header("Content-Type:application/force-download");
header("Content-Type: application/vnd.ms-excel;");
header("Content-Type:application/octet-stream");
header("Content-Type:application/download");
header("Content-Disposition:attachment;filename=".$m_strOutputExcelFileName);
header("Content-Transfer-Encoding:binary");
$objWriter->save("php://output");
?>