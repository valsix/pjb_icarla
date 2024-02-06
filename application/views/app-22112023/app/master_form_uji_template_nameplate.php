<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->library('Classes/PHPExcel');


$this->load->model("base-app/Nameplate");
$this->load->model("base-app/FormUji");
$this->load->model("base-app/FormUjiTipe");


$reqTipeId = $this->input->get("reqTipeId");
$reqNameplateId = $this->input->get("reqNameplateId");
$reqId = $this->input->get("reqId");

$set= new Nameplate();
$statement = " AND A.NAMEPLATE_ID =".$reqNameplateId;
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$reqNamaFile=$set->getField("NAMA");
unset($set);

$namafile="nameplate_".strtolower($reqNamaFile);
// print_r($reqNameplateId);exit;


// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji_nameplate.xlsx');

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
$objPHPExcel->setActiveSheetIndex($sheetIndex);
$objWorksheet= $objPHPExcel->getActiveSheet();

$row = 1;
$tempRowAwal= 1;

$field= array();
$field= array("NAMA");

$statement=" AND A.NAMEPLATE_ID =".$reqNameplateId;
	$index_kolom= 1;

$set = new Nameplate();
$sOrder=" ORDER BY A.NAMEPLATE_ID";
$set->selectByParamsDetil(array(), -1,-1, $statement,$sOrder);
while($set->nextRow())
{
	for($i=0; $i<count($field); $i++)
	{
		$kolom= getColoms($index_kolom);
		$objWorksheet->getStyle($kolom.$row)->applyFromArray($BStyle);
		$objWorksheet->setCellValue($kolom.$row,$set->getField($field[$i]));
		$objWorksheet->getColumnDimension($kolom)->setAutoSize(TRUE);
		
	}
	$index_kolom++;
}
$objWorksheet->setTitle('Import Nameplate');

//nameplate master start

$set= new Nameplate();
$arrnameplate= [];

$statement = " AND A.NAMEPLATE_ID=".$reqNameplateId." AND A.STATUS = '1'";
$set->selectByParamsDetil(array(), -1, -1, $statement);
    // echo  $set->query;exit;
while($set->nextRow())
{
	$arrdata= array();
	$arrdata["iddetil"]= $set->getField("NAMEPLATE_DETIL_ID");
	$arrdata["id"]= $set->getField("NAMEPLATE_ID");
	$arrdata["NAMA"]= $set->getField("NAMA");
	$arrdata["NAMA_TABEL"]= $set->getField("NAMA_TABEL");
	$arrdata["STATUS"]= $set->getField("STATUS");

	array_push($arrnameplate, $arrdata);
}
unset($set);
$statement = " ";
$sOrder="";
$arrMaster= [];
$arrKey= [];

$sheetIndex= 1;

foreach($arrnameplate as $detil) 
{
	$idmaster= $detil["iddetil"];
	$nama=$detil["NAMA"];
	$namatabel=$detil["NAMA_TABEL"];
	$objWorkSheet = $objPHPExcel->createSheet($sheetIndex);
	$objPHPExcel->setActiveSheetIndex($sheetIndex);
	$objWorkSheet= $objPHPExcel->getActiveSheet();
	$objWorkSheet->setTitle("Master ".ucfirst(strtolower($namatabel)));

	$set= new Nameplate();
	$sOrder=" ORDER BY ".$namatabel."_ID ASC";

	$i=2;
	$set->selectByParamsCheckTabel(array(), -1, -1, $statement,$sOrder,$namatabel);
	// echo $set->query;exit;
	while($set->nextRow())
	{		
		$objWorkSheet->setCellValue("A1","".$namatabel."_ID");
		$objWorkSheet->setCellValue("B1","KODE");
		$objWorkSheet->setCellValue("C1","NAMA");
		$objWorkSheet->getStyle("A1")->applyFromArray($BStyle);
		$objWorkSheet->getStyle("B1")->applyFromArray($BStyle);
		$objWorkSheet->getStyle("C1")->applyFromArray($BStyle);
		$objWorkSheet->getColumnDimension("A")->setAutoSize(TRUE);
		$objWorkSheet->getColumnDimension("B")->setAutoSize(TRUE);
		$objWorkSheet->getColumnDimension("C")->setAutoSize(TRUE);

		$arrdata["id"]= $set->getField("".$namatabel."_ID");
		$arrdata["KODE"]= $set->getField("KODE");
		$arrdata["NAMA"]= $set->getField("NAMA");
		$arrdata["NAMA_TABEL"]= $namatabel;
		$arrdata["INDEX"]= $sheetIndex;
		$arrdata["ROW"]= $i;
		$i++;

		array_push($arrMaster, $arrdata);
	}
	$sheetIndex++;

}

foreach ($arrMaster as $key => $master) {
	$idmaster= $master["id"];
	$masterkode=$master["KODE"];
	$masternama=$master["NAMA"];
	$mastertabel=$master["NAMA_TABEL"];
	$index=$master["INDEX"];
	$jumlah=$master["ROW"];
	$objPHPExcel->setActiveSheetIndex($index);
	$objWorkSheet= $objPHPExcel->getActiveSheet();
	// print_r($kolom);
	$objWorkSheet->getStyle("A".$jumlah)->applyFromArray($BStyle);
	$objWorkSheet->getStyle("B".$jumlah)->applyFromArray($BStyle);
	$objWorkSheet->getStyle("C".$jumlah)->applyFromArray($BStyle);
	$objWorkSheet->setCellValue("A".$jumlah,$idmaster);
	$objWorkSheet->setCellValue("B".$jumlah,$masterkode); 
	$objWorkSheet->setCellValue("C".$jumlah,$masternama);

}
unset($set);
//nameplate master end

//default sheet
$objPHPExcel->setActiveSheetIndex(0);

	

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
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