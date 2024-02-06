<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');


$this->load->model("base-app/JenisPengukuran");
$this->load->model("base-app/TipeInput");
$this->load->model("base-app/GroupState");
$this->load->model("base-app/EnjiniringUnit");
$this->load->model("base-app/Uom");

$reqTipePengukuranid = $this->input->get("reqTipePengukuranid");
$reqTipePengukuranText = $this->input->get("reqTipePengukuranText");
$reqTipePengukuranText =str_replace(" ", "_", $reqTipePengukuranText);


// print_r($reqTipePengukuranText);exit;


// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/pengukuran.xlsx');

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

$sheetIndex= 0;
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPexcel->getActiveSheet();

$arrtipe=[];
$searchForValue = ',';
$stringValue = $reqTipePengukuranid;
if( strpos($stringValue, $searchForValue) !== false ) {
	$arrtipe=explode(",", $stringValue);
}

// print_r($arrtipe);exit;

$namafile="";

if(!empty($arrtipe))
{
	$namafile="pengukuran_".$reqTipePengukuranText;
	foreach ($arrtipe as $key => $value) {
	 	if($value == 1 || $value == 2)
	 	{
	 		for ($x = 1; $x <= 14; $x++) {
				$kolom = getColoms($x);
				$objWorksheet->getStyle($kolom."1")->applyFromArray($BStyle);
			}

			$objWorksheet->setCellValue("A1","Kode Pengukuran");
			$objWorksheet->setCellValue("B1","Nama");
			$objWorksheet->setCellValue("C1","Jenis Pengukuran Id");
			$objWorksheet->setCellValue("D1","Nama Pengukuran");
			$objWorksheet->setCellValue("E1","Tipe");
			$objWorksheet->setCellValue("F1","Formula");
			if($value == 1)
			{
				$objWorksheet->setCellValue("G1","Analog");
				$objWorksheet->setCellValue("H1","Uom Id");
				$objWorksheet->setCellValue("I1","Status Pengukuran");
				$objWorksheet->setCellValue("J1","Enjiniring Unit Id");
				$objWorksheet->setCellValue("K1","Catatan");
				$objWorksheet->setCellValue("L1","Sequence");
				$objWorksheet->setCellValue("M1","Is Interval");
			}
			else if($value == 2)
			{
				$objWorksheet->setCellValue("G1","Analog");
				$objWorksheet->setCellValue("H1","Uom Id");
				$objWorksheet->setCellValue("I1","Text");
				$objWorksheet->setCellValue("J1","Status Pengukuran");
				$objWorksheet->setCellValue("K1","Enjiniring Unit Id");
				$objWorksheet->setCellValue("L1","Catatan");
				$objWorksheet->setCellValue("M1","Sequence");
				$objWorksheet->setCellValue("N1","Is Interval");
			}
			
	 	}

	}
}
else
{

	if($reqTipePengukuranid == 0)
	{
		$namafile="pengukuran_".$reqTipePengukuranText;

		for ($x = 1; $x <= 12; $x++) {
			$kolom = getColoms($x);
			$objWorksheet->getStyle($kolom."1")->applyFromArray($BStyle);
		}

		$objWorksheet->setCellValue("A1","Kode Pengukuran");
		$objWorksheet->setCellValue("B1","Nama");
		$objWorksheet->setCellValue("C1","Jenis Pengukuran Id");
		$objWorksheet->setCellValue("D1","Nama Pengukuran");
		$objWorksheet->setCellValue("E1","Tipe");
		$objWorksheet->setCellValue("F1","Formula");
		$objWorksheet->setCellValue("G1","Group State Id");
		$objWorksheet->setCellValue("H1","Status Pengukuran");
		$objWorksheet->setCellValue("I1","Enjiniring Unit Id");
		$objWorksheet->setCellValue("J1","Catatan");
		$objWorksheet->setCellValue("K1","Sequence");
		$objWorksheet->setCellValue("L1","Is Interval");
	}
	else if($reqTipePengukuranid == 1)
	{
		$namafile="pengukuran_".$reqTipePengukuranText;
		for ($x = 1; $x <= 12; $x++) {
			$kolom = getColoms($x);
			$objWorksheet->getStyle($kolom."1")->applyFromArray($BStyle);
		}

		$objWorksheet->setCellValue("A1","Kode Pengukuran");
		$objWorksheet->setCellValue("B1","Nama");
		$objWorksheet->setCellValue("C1","Jenis Pengukuran Id");
		$objWorksheet->setCellValue("D1","Nama Pengukuran");
		$objWorksheet->setCellValue("E1","Tipe");
		$objWorksheet->setCellValue("F1","Formula");
		$objWorksheet->setCellValue("G1","Analog");
		$objWorksheet->setCellValue("H1","Uom Id");
		$objWorksheet->setCellValue("I1","Status Pengukuran");
		$objWorksheet->setCellValue("J1","Enjiniring Unit Id");
		$objWorksheet->setCellValue("K1","Catatan");
		$objWorksheet->setCellValue("L1","Sequence");
		$objWorksheet->setCellValue("M1","Is Interval");
	}
	else if($reqTipePengukuranid == 2)
	{
		$namafile="pengukuran_".$reqTipePengukuranText;
		for ($x = 1; $x <= 12; $x++) {
			$kolom = getColoms($x);
			$objWorksheet->getStyle($kolom."1")->applyFromArray($BStyle);
		}

		$objWorksheet->setCellValue("A1","Kode Pengukuran");
		$objWorksheet->setCellValue("B1","Nama");
		$objWorksheet->setCellValue("C1","Jenis Pengukuran Id");
		$objWorksheet->setCellValue("D1","Nama Pengukuran");
		$objWorksheet->setCellValue("E1","Tipe");
		$objWorksheet->setCellValue("F1","Formula");
		$objWorksheet->setCellValue("G1","Text");
		$objWorksheet->setCellValue("H1","Status Pengukuran");
		$objWorksheet->setCellValue("I1","Enjiniring Unit Id");
		$objWorksheet->setCellValue("J1","Catatan");
		$objWorksheet->setCellValue("K1","Sequence");
		$objWorksheet->setCellValue("L1","Is Interval");
	}

}



$sheetIndex= 1;

$objPHPExcel->createSheet();
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet2= $objPHPexcel->getActiveSheet();
$objWorksheet2->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet2->getStyle("B1")->applyFromArray($BStyle);

$objWorksheet2->setCellValue("A1","Jenis Pengukuran ID");
$objWorksheet2->setCellValue("B1","Nama");



$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("JENIS_PENGUKURAN_ID", "NAMA");

$statement="";

$set = new JenisPengukuran();
$sOrder=" ORDER BY A.JENIS_PENGUKURAN_ID";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet2->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet2->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet2->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}

$sheetIndex= 2;

$objPHPExcel->createSheet();
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet3= $objPHPexcel->getActiveSheet();
$objWorksheet3->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet3->getStyle("B1")->applyFromArray($BStyle);

$objWorksheet3->setCellValue("A1","Tipe Input ID");
$objWorksheet3->setCellValue("B1","Nama");



$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("TIPE_INPUT_ID", "NAMA");

$statement="";

$set = new TipeInput();
$sOrder=" ORDER BY TIPE_INPUT_ID";
$set->selectByParamsCombo(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet3->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet3->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet3->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}

$sheetIndex= 3;

$objPHPExcel->createSheet();
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet4= $objPHPexcel->getActiveSheet();
$objWorksheet4->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet4->getStyle("B1")->applyFromArray($BStyle);

$objWorksheet4->setCellValue("A1","Group State ID");
$objWorksheet4->setCellValue("B1","Nama");



$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("GROUP_STATE_ID", "NAMA");

$statement="";

$set = new GroupState();
$sOrder=" ORDER BY A.GROUP_STATE_ID";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet4->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet4->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet4->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}


$sheetIndex= 4;

$objPHPExcel->createSheet();
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet5= $objPHPexcel->getActiveSheet();
$objWorksheet5->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet5->getStyle("B1")->applyFromArray($BStyle);
$objWorksheet5->getStyle("C1")->applyFromArray($BStyle);


$objWorksheet5->setCellValue("A1","Enjiniring Unit ID");
$objWorksheet5->setCellValue("B1","Kode");
$objWorksheet5->setCellValue("C1","Nama");



$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("ENJINIRINGUNIT_ID","KODE","NAMA");

$statement="";

$set = new EnjiniringUnit();
$sOrder=" ORDER BY A.ENJINIRINGUNIT_ID";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet5->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet5->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet5->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}

$sheetIndex= 5;

$objPHPExcel->createSheet();
$objPHPexcel->setActiveSheetIndex($sheetIndex);
$objWorksheet6= $objPHPexcel->getActiveSheet();
$objWorksheet6->getStyle("A1")->applyFromArray($BStyle);
$objWorksheet6->getStyle("B1")->applyFromArray($BStyle);

$objWorksheet6->setCellValue("A1","Uom ID");
$objWorksheet6->setCellValue("B1","Nama");



$row = 2;
$tempRowAwal= 1;

$field= array();
$field= array("UOM_ID","NAMA");

$statement="";

$set = new Uom();
$sOrder=" ORDER BY A.UOM_ID";
$set->selectByParams(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	$index_kolom= 1;
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		
		$objWorksheet6->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet6->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet6->getColumnDimension($kolom)->setAutoSize(TRUE);
		
		$index_kolom++;
	}
	$row++;

}




$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
$objWriter->save('template/export/'.$namafile.'.xls');

$down = 'template/export/'.$namafile.'.xls';
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