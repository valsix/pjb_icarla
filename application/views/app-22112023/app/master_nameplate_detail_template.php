<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');


$this->load->model("base-app/MasterTabel");

// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/nameplate_detail.xlsx');

$objPHPExcel = new PHPExcel();

$BStyle = array(
	'borders' => array(
		'allborders' => array(

			'style' => PHPExcel_Style_Border::BORDER_THIN
		)				
	),
	'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	)
);


$sheetIndex= 1;
$objPHPExcel->createSheet();
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPexcel->getActiveSheet();
$objWorksheet->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet->getStyle("B1")->applyFromArray($BStyle);

$objWorksheet->setCellValue("A1","MASTER_TABEL_ID");
$objWorksheet->setCellValue("B1","NAMA");

$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("MASTER_TABEL_ID","NAMA");

$statement="";

$set = new MasterTabel();
$sOrder="";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
$objWriter->save('template/export/nameplate_detail.xls');

$down = 'template/export/nameplate_detail.xls';
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.basename($down));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($down));
ob_clean();
flush();
readfile($down);
unlink($down);
//unlink($save);
?>