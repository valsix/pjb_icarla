<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/excel.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class form_uji_cetak_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		//kauth

		if($this->session->userdata("appuserid") == "")
		{
			redirect('login');
		}
		
		
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appusernama= $this->session->userdata("appusernama");
		$this->personaluserlogin= $this->session->userdata("personaluserlogin");
		$this->appusergroupid= $this->session->userdata("appusergroupid");

		$this->configtitle= $this->config->config["configtitle"];
		$this->load->library('Classes/PHPExcel');
	}	

	function getRowcount($text, $width=55) {
	    $rc = 0;
	    $line = explode("\n", $text);
	    foreach($line as $source) {
	        $rc += intval((strlen($source) / $width) +1);
	    }
	    return $rc;
	}

	function ir_pi()
	{

		$reqTipe= $this->input->get("reqTipe");
		$reqId= $this->input->get("reqId");
		// print_r($reqId);exit;
		$this->load->model('base-app/FormUji');

		 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/ir_pi.xlsx');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();
		$objDrawing = new PHPExcel_Worksheet_Drawing();

		$objDrawing->setPath('images/logo-pjb.png');

		$objDrawing->setCoordinates('A1');
		$objDrawing->setResizeProportional(false);
		$objDrawing->setWidth(75);
		$objDrawing->setHeight(47);
		$objDrawing->setOffsetX(20);    
		$objDrawing->setOffsetY(35); 

		$objDrawing->setWorksheet($objWorksheet);

		$style = StyleExcel(1);

		$tahun=date("Y");
		$objWorksheet->setCellValue("Q6",$tahun);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParamsDetil(array(), -1, -1, $statement);

		// echo  $set->query;exit;

		$row = 11;
		$field= array();
		$field= array("WAKTU","HV_GND","LV_GND","HV_LV");

		// $index_kolom= 4;
		while($set->nextRow())
		{
			for($i=0; $i<count($field); $i++)
			{
				// $kolom= getColoms($index_kolom);
				
				$objWorksheet->mergeCells("D".$row.':'."J".$row);
				$objWorksheet->mergeCells("K".$row.':'."P".$row);
				$objWorksheet->mergeCells("Q".$row.':'."V".$row);
				$objWorksheet->mergeCells("W".$row.':'."AB".$row);
				
				if ($field[$i] == "WAKTU")
				{
					$objWorksheet->getStyle("D".$row.':'."J".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("D".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "HV_GND")
				{
					
					$objWorksheet->getStyle("K".$row.':'."P".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("K".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "LV_GND")
				{
					$objWorksheet->getStyle("Q".$row.':'."V".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("Q".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "HV_LV")
				{
					$objWorksheet->getStyle("W".$row.':'."AB".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("W".$row,$set->getField($field[$i]));
				}
				// $index_kolom++;
			}	
			$row++;
		}

		unset($set);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqId= $set->getField("FORM_UJI_ID");
		$reqReference= $set->getField("REFERENCE");
		$reqResult= $set->getField("RESULT");
		$reqNote= $set->getField("NOTE");
		$reqNama= $set->getField("NAMA");

		$objWorksheet->setCellValue("F4",$reqNama);

		if($reqTipe==1)
		{
			$objWorksheet->setCellValue("D7","Before Tan Delta");
		}
		else if($reqTipe==2)
		{
			$objWorksheet->setCellValue("D7","After Tan Delta");
		}
		
		
		$rowref= $row+2;
		$rowres= $row+3;
		$rownote= $row+4;
		$objWorksheet->setCellValue("D".$row,"Gnd : Ground");

		$objWorksheet->setCellValue("B".$rowref,"Reference");
		$objWorksheet->setCellValue("B".$rowres,"Result");
		$objWorksheet->setCellValue("B".$rownote,"Note");

		$objWorksheet->setCellValue("E".$rowref,":");
		$objWorksheet->setCellValue("E".$rowres,":");
		$objWorksheet->setCellValue("E".$rownote,":");

		$objWorksheet->setCellValue("F".$rowref,$reqReference);
		$objWorksheet->setCellValue("F".$rowres,$reqResult);
		$objWorksheet->setCellValue("F".$rownote,$reqNote);

		$objWorksheet->getStyle("B".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("B".$rowres)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("B".$rownote)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		
		$objWorksheet->getStyle("E".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("E".$rowres)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("E".$rownote)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		
		$objWorksheet->getStyle("F".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("F".$rowres)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("F".$rownote)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

		$numrowsref = $this->getRowcount($reqReference);
		$numrowsres = $this->getRowcount($reqResult);
		$numrowsnote = $this->getRowcount($reqNote);

		$objWorksheet->getRowDimension($rowref)->setRowHeight($numrowsref * 12.75 + 2.25);
		$objWorksheet->getRowDimension($rowres)->setRowHeight($numrowsres * 12.75 + 2.25);
		$objWorksheet->getRowDimension($rownote)->setRowHeight($numrowsnote * 12.75 + 2.25);

		$objWorksheet->mergeCells("F".$rowref.':'."AB".$rowref);
		$objWorksheet->mergeCells("F".$rowres.':'."AB".$rowres);
		$objWorksheet->mergeCells("F".$rownote.':'."AB".$rownote);

		$rowrecom= $row+6;
		$rowmeas= $row+7;
		$rowdesc= $row+8;
		$rowname= $row+9;
		$rowsign= $row+10;
		$rowdate= $row+11;

		$objWorksheet->mergeCells("A".$rowrecom.':'."F".$rowrecom);
		$objWorksheet->getStyle("A".$rowrecom.':'."F".$rowrecom)->applyFromArray($style);
		$objWorksheet->getStyle("A".$rowrecom.':'."F".$rowrecom)->getFont()->setSize(10);
		$objWorksheet->setCellValue("A".$rowrecom,"RECOMENDATION");

		$objWorksheet->mergeCells("G".$rowrecom.':'."AF".$rowrecom);
		$objWorksheet->getStyle("G".$rowrecom.':'."AF".$rowrecom)->applyFromArray($style);
		$objWorksheet->getStyle("G".$rowrecom.':'."AF".$rowrecom)->getFont()->setSize(10);
		$objWorksheet->setCellValue("G".$rowrecom,"ACCEPTED/REWORK/REPLACE/REPAIR/MONITORING
			(by Quality Control)");

		$objWorksheet->mergeCells("A".$rowmeas.':'."F".$rowmeas);
		$objWorksheet->getStyle("A".$rowmeas.':'."F".$rowmeas)->applyFromArray($style);
		$objWorksheet->getStyle("A".$rowmeas.':'."F".$rowmeas)->getFont()->setSize(10);
		$objWorksheet->setCellValue("A".$rowmeas,"Measuring Tool:");

		$objWorksheet->mergeCells("G".$rowmeas.':'."AF".$rowmeas);
		$objWorksheet->getStyle("G".$rowmeas.':'."AF".$rowmeas)->applyFromArray($style);
		$objWorksheet->getStyle("G".$rowmeas.':'."AF".$rowmeas)->getFont()->setSize(10);
		$objWorksheet->setCellValue("G".$rowmeas,"Insulation Tester MEGER MIT 525");


		$objWorksheet->mergeCells("A".$rowdesc.':'."D".$rowdesc);
		$objWorksheet->getStyle("A".$rowdesc.':'."D".$rowdesc)->applyFromArray($style);
		$objWorksheet->getStyle("A".$rowdesc.':'."D".$rowdesc)->getFont()->setSize(10);
		$objWorksheet->setCellValue("A".$rowdesc,"Description");

		$objWorksheet->mergeCells("E".$rowdesc.':'."K".$rowdesc);
		$objWorksheet->getStyle("E".$rowdesc.':'."K".$rowdesc)->applyFromArray($style);
		$objWorksheet->getStyle("E".$rowdesc.':'."K".$rowdesc)->getFont()->setSize(10);
		$objWorksheet->setCellValue("E".$rowdesc,"Tested/measured by");

		$objWorksheet->mergeCells("L".$rowdesc.':'."R".$rowdesc);
		$objWorksheet->getStyle("L".$rowdesc.':'."R".$rowdesc)->applyFromArray($style);
		$objWorksheet->getStyle("L".$rowdesc.':'."R".$rowdesc)->getFont()->setSize(10);
		$objWorksheet->setCellValue("L".$rowdesc,"Coordinator");

		$objWorksheet->mergeCells("S".$rowdesc.':'."Y".$rowdesc);
		$objWorksheet->getStyle("S".$rowdesc.':'."Y".$rowdesc)->applyFromArray($style);
		$objWorksheet->getStyle("S".$rowdesc.':'."Y".$rowdesc)->getFont()->setSize(10);
		$objWorksheet->setCellValue("S".$rowdesc,"Quality Control");

		$objWorksheet->mergeCells("Z".$rowdesc.':'."AF".$rowdesc);
		$objWorksheet->getStyle("Z".$rowdesc.':'."AF".$rowdesc)->applyFromArray($style);
		$objWorksheet->getStyle("Z".$rowdesc.':'."AF".$rowdesc)->getFont()->setSize(10);
		$objWorksheet->setCellValue("Z".$rowdesc,"Witness");

		
		$objWorksheet->calculateColumnWidths();
	

		// $calculatedWidth = $objWorksheet->getColumnDimension('F')->getWidth();

		// print_r($calculatedWidth);exit;
		// $objWorksheet->getColumnDimension('F')->setWidth((int) $calculatedWidth * 1.05);

		// $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);
		// $objWorksheet->getRowDimension($rowref)->setRowHeight(-1);
		// $objWorksheet->getRowDimension($rownote)->setRowHeight(-1);
		$objWorksheet->getStyle("F".$rowref.':'."F".$rownote)
		->getAlignment()->setWrapText(true); 
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		// $objWorksheet->getColumnDimension('F')->setWidth(80);

		// $objWorksheet->getRowDimension($rowref)->setRowHeight(50);
		// $objWorksheet->getRowDimension($rownote)->setRowHeight(50);  
		// $objWorksheet->getColumnDimension('F')->setWidth(20);

		

	

		unset($set);

		// print_r($row);exit;
				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		$objWriter->save('template/download/ir_pi.xlsx');

		$down = 'template/download/ir_pi.xlsx';
		$filename= 'ir_pi.xlsx';
		ob_end_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, get-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($down));
		ob_end_clean();
		readfile($down);
	}

	function die_res()
	{
		$reqTipe= $this->input->get("reqTipe");
		$reqId= $this->input->get("reqId");
		// print_r($reqId);exit;
		$this->load->model('base-app/FormUji');

		 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/die_res.xlsx');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();
		$objDrawing = new PHPExcel_Worksheet_Drawing();

		$objDrawing->setPath('images/logo-pjb.png');

		$objDrawing->setCoordinates('A1');
		$objDrawing->setResizeProportional(false);
		$objDrawing->setWidth(75);
		$objDrawing->setHeight(47);
		$objDrawing->setOffsetX(20);    
		$objDrawing->setOffsetY(35); 

		$objDrawing->setWorksheet($objWorksheet);

		$style = StyleExcel(1);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqId= $set->getField("FORM_UJI_ID");
		$reqReference= $set->getField("REFERENCE");
		$reqResult= $set->getField("RESULT");
		$reqNote= $set->getField("NOTE");
		$reqNama= $set->getField("NAMA");

		$reqAirTemp= $set->getField("AIR_TEMP");
		$reqHumidity= $set->getField("HUMIDITY");
		$reqTapChanger=  $set->getField("TAP_CHANGER");

		$reqCalculatedMoisture=  $set->getField("CALCULATED_MOISTURE");
		$reqMoistureSaturation= $set->getField("MOISTURE_SATURATION");
		$reqOilTemperature=  $set->getField("OIL_TEMPERATURE");
		$reqOilConductivity=  $set->getField("OIL_CONDUCTIVITY");
		$reqCapacitance=  $set->getField("CAPACITANCE");
		$reqBarriers=  $set->getField("BARRIERS");
		$reqPolarizationIndex=  $set->getField("POLARIZATION_INDEX");

		$reqMoistureCategory=  $set->getField("MOISTURE_CATEGORY");
		$reqOilCategory=  $set->getField("OIL_CATEGORY");
		$reqTan=  $set->getField("TAN");
		$reqSpacers=  $set->getField("SPACERS");

		$reqDry=  $set->getField("DRY");
		$reqModeratelyWet=  $set->getField("MODERATELY_WET");
		$reqWet=  $set->getField("WET");
		$reqExtremeWet=  $set->getField("EXTREMELY_WET");

		$reqGambarDI=  $set->getField("LINK_GAMBAR");

		$objWorksheet1= $objPHPexcel->getActiveSheet();
		$objDrawing1 = new PHPExcel_Worksheet_Drawing();
		$objDrawing1->setPath($reqGambarDI);

		$objDrawing1->setCoordinates('C8');
		$objDrawing1->setResizeProportional(false);
		$objDrawing1->setWidth(600);
		$objDrawing1->setHeight(290);
		$objDrawing1->setOffsetX(0);    
		$objDrawing1->setOffsetY(0); 

		$objDrawing1->setWorksheet($objWorksheet);

		$tahun=date("Y");
		$objWorksheet->setCellValue("Q6",$tahun);

		$objWorksheet->setCellValue("F4",$reqNama);

		$row = 25;

		$objWorksheet->setCellValue("K".$row,'Grafik Tan Delta fungsi Frekuensi');
		
		$rowtemp= $row+2;
		$rowtapchanger= $row+3;

		$rowcalmois= $row+5;
		$rowmoissat= $row+6;
		$rowiltemp= $row+7;
		$rowoilcon= $row+8;
		$rowcap= $row+9;
		$rowbar= $row+10;
		$rowpolariza= $row+11;

		$rowmoiscat= $row+13;
		$rowdry= $row+14;
		$rowmodwet= $row+15;
		$rowwet= $row+16;
		$rowexwet= $row+17;

		$rowref= $row+19;
		$rowres= $row+20;
		$rownote= $row+21;


		$objWorksheet->setCellValue("D".$rowtemp,"Air Temp.");
		$objWorksheet->setCellValue("K".$rowtemp,":");
		$objWorksheet->setCellValue("L".$rowtemp,$reqAirTemp);
		$objWorksheet->setCellValue("T".$rowtemp,"Air Humidity");
		$objWorksheet->setCellValue("AC".$rowtemp,":");
		$objWorksheet->setCellValue("AD".$rowtemp,$reqHumidity);

		$objWorksheet->setCellValue("D".$rowtapchanger,"Tap Changer");
		$objWorksheet->setCellValue("K".$rowtapchanger,":");
		$objWorksheet->setCellValue("L".$rowtapchanger,$reqTapChanger);

		$objWorksheet->setCellValue("D".$rowcalmois,"Calculated Moisture");
		$objWorksheet->setCellValue("K".$rowcalmois,":");
		$objWorksheet->setCellValue("L".$rowcalmois,$reqCalculatedMoisture);
		$objWorksheet->setCellValue("T".$rowcalmois,"Moisture Category:");
		$objWorksheet->setCellValue("AC".$rowcalmois,":");
		$objWorksheet->setCellValue("AD".$rowcalmois,$reqMoistureCategory);

		$objWorksheet->setCellValue("D".$rowmoissat,"Moisture Saturation");
		$objWorksheet->setCellValue("K".$rowmoissat,":");
		$objWorksheet->setCellValue("L".$rowmoissat,$reqMoistureSaturation);
		$objWorksheet->setCellValue("T".$rowmoissat,"Bubbling Inception Temp.");
		$objWorksheet->setCellValue("AC".$rowmoissat,":");
		$objWorksheet->setCellValue("AD".$rowmoissat,"");

		$objWorksheet->setCellValue("D".$rowiltemp,"Oil Temperature");
		$objWorksheet->setCellValue("K".$rowiltemp,":");
		$objWorksheet->setCellValue("L".$rowiltemp,$reqOilTemperature);

		$objWorksheet->setCellValue("D".$rowoilcon,"Oil Conductivity");
		$objWorksheet->setCellValue("K".$rowoilcon,":");
		$objWorksheet->setCellValue("L".$rowoilcon,$reqOilConductivity);
		$objWorksheet->setCellValue("T".$rowoilcon,"Oil Category");
		$objWorksheet->setCellValue("AC".$rowoilcon,":");
		$objWorksheet->setCellValue("AD".$rowoilcon,$reqOilCategory);

		$objWorksheet->setCellValue("D".$rowcap,"Capacitance @ 50Hz");
		$objWorksheet->setCellValue("K".$rowcap,":");
		$objWorksheet->setCellValue("L".$rowcap,$reqCapacitance);
		$objWorksheet->setCellValue("T".$rowcap,"Tanδ @ 50Hz:");
		$objWorksheet->setCellValue("AC".$rowcap,":");
		$objWorksheet->setCellValue("AD".$rowcap,$reqTan);

		$objWorksheet->setCellValue("D".$rowbar,"Barriers");
		$objWorksheet->setCellValue("K".$rowbar,":");
		$objWorksheet->setCellValue("L".$rowbar,$reqBarriers);
		$objWorksheet->setCellValue("T".$rowbar,"Spacers");
		$objWorksheet->setCellValue("AC".$rowbar,":");
		$objWorksheet->setCellValue("AD".$rowbar,$reqSpacers);

		$objWorksheet->setCellValue("D".$rowpolariza,"Polarization Index");
		$objWorksheet->setCellValue("K".$rowpolariza,":");
		$objWorksheet->setCellValue("L".$rowpolariza,$reqPolarizationIndex);


		$objWorksheet->setCellValue("D".$rowmoiscat,"Moisture Categories:");

		$objWorksheet->setCellValue("D".$rowdry,"dry");
		$objWorksheet->setCellValue("K".$rowdry,":");
		$objWorksheet->setCellValue("L".$rowdry,$reqDry);

		$objWorksheet->setCellValue("D".$rowmodwet,"moderately wet");
		$objWorksheet->setCellValue("K".$rowmodwet,":");
		$objWorksheet->setCellValue("L".$rowmodwet,$reqModeratelyWet);

		$objWorksheet->setCellValue("D".$rowwet,"wet");
		$objWorksheet->setCellValue("K".$rowwet,":");
		$objWorksheet->setCellValue("L".$rowwet,$reqWet);

		$objWorksheet->setCellValue("D".$rowexwet,"extremely wet");
		$objWorksheet->setCellValue("K".$rowexwet,":");
		$objWorksheet->setCellValue("L".$rowexwet,$reqExtremeWet);



		$objWorksheet->setCellValue("B".$rowref,"Reference");
		$objWorksheet->getStyle("B".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->setCellValue("B".$rowres,"Result");
		$objWorksheet->setCellValue("B".$rownote,"Note");
		$objWorksheet->getStyle("B".$rownote)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->setCellValue("E".$rowref,":");
		$objWorksheet->getStyle("E".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->setCellValue("F".$rowref,$reqReference);
		$objWorksheet->setCellValue("F".$rowres,$reqResult);
		$objWorksheet->setCellValue("F".$rownote,$reqNote);

		$objWorksheet->mergeCells("F".$rowref.':'."AE".$rowref);
		$objWorksheet->mergeCells("F".$rowres.':'."AE".$rowres);
		$objWorksheet->mergeCells("F".$rownote.':'."AE".$rownote);

		$objWorksheet->calculateColumnWidths();

	

		// $calculatedWidth = $objWorksheet->getColumnDimension('F')->getWidth();

		// print_r($calculatedWidth);exit;
		// $objWorksheet->getColumnDimension('F')->setWidth((int) $calculatedWidth * 1.05);

		// $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);
		$objWorksheet->getRowDimension($rowref)->setRowHeight(-1);
		$objWorksheet->getRowDimension($rownote)->setRowHeight(-1);
			$objWorksheet->getStyle("F".$rowref.':'."F".$rownote)
		->getAlignment()->setWrapText(true); 
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		// $objWorksheet->getColumnDimension('F')->setWidth(80);

		// $objWorksheet->getRowDimension($rowref)->setRowHeight(50);
		// $objWorksheet->getRowDimension($rownote)->setRowHeight(50);  
		// $objWorksheet->getColumnDimension('F')->setWidth(20);

		

	

		unset($set);

		// print_r($row);exit;
				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		$objWriter->save('template/download/ex_curr.xlsx');

		$down = 'template/download/ex_curr.xlsx';
		$filename= 'ex_curr.xlsx';
		ob_end_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, get-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($down));
		ob_end_clean();
		readfile($down);
	}

	function hcb()
	{
		$reqTipe= $this->input->get("reqTipe");
		$reqId= $this->input->get("reqId");
		// print_r($reqId);exit;
		$this->load->model('base-app/FormUji');

		 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/hcb.xlsx');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();
		$objDrawing = new PHPExcel_Worksheet_Drawing();

		$objDrawing->setPath('images/logo-pjb.png');

		$objDrawing->setCoordinates('A1');
		$objDrawing->setResizeProportional(false);
		$objDrawing->setWidth(75);
		$objDrawing->setHeight(47);
		$objDrawing->setOffsetX(20);    
		$objDrawing->setOffsetY(35); 

		$objDrawing->setWorksheet($objWorksheet);

		$style = StyleExcel(1);

		$tahun=date("Y");
		$objWorksheet->setCellValue("Q6",$tahun);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParamsDetil(array(), -1, -1, $statement);

		// echo  $set->query;exit;

		$row = 11;
		$field= array();
		$field= array("BUSHING","SKIRT","TEGANGAN","IMA","WATTS");

		// $index_kolom= 4;
		while($set->nextRow())
		{
			for($i=0; $i<count($field); $i++)
			{
				// $kolom= getColoms($index_kolom);
				
				$objWorksheet->mergeCells("F".$row.':'."H".$row);
				$objWorksheet->mergeCells("I".$row.':'."J".$row);
				$objWorksheet->mergeCells("K".$row.':'."N".$row);
				$objWorksheet->mergeCells("O".$row.':'."R".$row);
				$objWorksheet->mergeCells("S".$row.':'."V".$row);
				
				if ($field[$i] == "BUSHING")
				{
					$objWorksheet->getStyle("F".$row.':'."H".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("F".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "SKIRT")
				{
					
					$objWorksheet->getStyle("I".$row.':'."J".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("I".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TEGANGAN")
				{
					$objWorksheet->getStyle("K".$row.':'."N".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("K".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "IMA")
				{
					$objWorksheet->getStyle("O".$row.':'."R".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("O".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "WATTS")
				{
					$objWorksheet->getStyle("S".$row.':'."V".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("S".$row,$set->getField($field[$i]));
				}
				// $index_kolom++;
			}	
			$row++;
		}

		unset($set);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqId= $set->getField("FORM_UJI_ID");
		$reqReference= $set->getField("REFERENCE");
		$reqResult= $set->getField("RESULT");
		$reqNote= $set->getField("NOTE");
		$reqNama= $set->getField("NAMA");
		$reqAirTemp= $set->getField("AIR_TEMP");
		$reqHumidity= $set->getField("HUMIDITY");
		$reqApparatusTemp= $set->getField("APPARATUS_TEMP");
		$reqWeather= $set->getField("WEATHER");

		$objWorksheet->setCellValue("F4",$reqNama);
		
		
		$rowtemp= $row+2;
		$rowhumidity= $row+3;

		$rowref= $row+5;
		$rowres= $row+6;
		$rownote= $row+7;

		$objWorksheet->setCellValue("D".$rowtemp,"Air Temp.");
		$objWorksheet->setCellValue("H".$rowtemp,":");
		$objWorksheet->setCellValue("I".$rowtemp,$reqAirTemp);

		$objWorksheet->setCellValue("P".$rowtemp,"Apparatus Temp.");
		$objWorksheet->setCellValue("V".$rowtemp,":");
		$objWorksheet->setCellValue("W".$rowtemp,$reqApparatusTemp);

		$objWorksheet->setCellValue("D".$rowhumidity,"Humidity");
		$objWorksheet->setCellValue("H".$rowhumidity,":");
		$objWorksheet->setCellValue("I".$rowhumidity,$reqHumidity);

		$objWorksheet->setCellValue("P".$rowhumidity,"Weather");
		$objWorksheet->setCellValue("V".$rowhumidity,":");
		$objWorksheet->setCellValue("W".$rowhumidity,$reqWeather);

		$objWorksheet->setCellValue("B".$rowref,"Reference");
		$objWorksheet->getStyle("B".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->setCellValue("B".$rowres,"Result");
		$objWorksheet->setCellValue("B".$rownote,"Note");
		$objWorksheet->getStyle("B".$rownote)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->setCellValue("E".$rowref,":");
		$objWorksheet->getStyle("E".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->setCellValue("F".$rowref,$reqReference);
		$objWorksheet->setCellValue("F".$rowres,$reqResult);
		$objWorksheet->setCellValue("F".$rownote,$reqNote);

		$objWorksheet->mergeCells("F".$rowref.':'."V".$rowref);
		$objWorksheet->mergeCells("F".$rowres.':'."V".$rowres);
		$objWorksheet->mergeCells("F".$rownote.':'."V".$rownote);

		$objWorksheet->calculateColumnWidths();

	

		// $calculatedWidth = $objWorksheet->getColumnDimension('F')->getWidth();

		// print_r($calculatedWidth);exit;
		// $objWorksheet->getColumnDimension('F')->setWidth((int) $calculatedWidth * 1.05);

		// $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);
		$objWorksheet->getRowDimension($rowref)->setRowHeight(-1);
		$objWorksheet->getRowDimension($rownote)->setRowHeight(-1);
			$objWorksheet->getStyle("F".$rowref.':'."F".$rownote)
		->getAlignment()->setWrapText(true); 
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		// $objWorksheet->getColumnDimension('F')->setWidth(80);

		// $objWorksheet->getRowDimension($rowref)->setRowHeight(50);
		// $objWorksheet->getRowDimension($rownote)->setRowHeight(50);  
		// $objWorksheet->getColumnDimension('F')->setWidth(20);

		

	

		unset($set);

		// print_r($row);exit;
				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		$objWriter->save('template/download/hcb.xlsx');

		$down = 'template/download/hcb.xlsx';
		$filename= 'hcb.xlsx';
		ob_end_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, get-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($down));
		ob_end_clean();
		readfile($down);
	}

	function rdc()
	{
		$reqTipe= $this->input->get("reqTipe");
		$reqId= $this->input->get("reqId");
		// print_r($reqId);exit;
		$this->load->model('base-app/FormUji');

		 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/rdc.xlsx');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();
		$objDrawing = new PHPExcel_Worksheet_Drawing();

		$objDrawing->setPath('images/logo-pjb.png');

		$objDrawing->setCoordinates('A1');
		$objDrawing->setResizeProportional(false);
		$objDrawing->setWidth(75);
		$objDrawing->setHeight(47);
		$objDrawing->setOffsetX(20);    
		$objDrawing->setOffsetY(35); 

		$objDrawing->setWorksheet($objWorksheet);

		$style = StyleExcel(1);

		$tahun=date("Y");
		$objWorksheet->setCellValue("Q6",$tahun);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParamsDetil(array(), -1, -1, $statement);
		// echo  $set->query;exit;
		$row = 13;
		$field= array();
		$field= array("SISI_RDC","TAP_RDC","FASA_RDC_R","ARUS_RDC_R","TEGANGAN_RDC_R","TAHANAN_RDC_R","TAHANAN_TEMP_RDC_R","DEV_RDC_R","FASA_RDC_S","ARUS_RDC_S","TEGANGAN_RDC_S","TAHANAN_RDC_S","TAHANAN_TEMP_RDC_S","DEV_RDC_S","FASA_RDC_T","ARUS_RDC_T","TEGANGAN_RDC_T","TAHANAN_RDC_T","TAHANAN_TEMP_RDC_T","DEV_RDC_T");

		// $index_kolom= 4;
		$no=1;
		while($set->nextRow())
		{
			for($i=0; $i<count($field); $i++)
			{
				if ($i=='0') 
				{
					$rowSisi= $row+3;
				}
				elseif ($i='2' || $i='8') 
				{
					$rowFasadll= $row+1;
				}

				if ($field[$i] == "SISI_RDC")
				{
					$objWorksheet->mergeCells("E".$row.':'."F".$row);
					$objWorksheet->mergeCells("E".$row.':'."E".$rowSisi);
					$objWorksheet->getStyle("E".$row.':'."F".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("E".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TAP_RDC")
				{
					$objWorksheet->mergeCells("G".$row.':'."H".$row);
					$objWorksheet->mergeCells("G".$row.':'."G".$rowSisi);
					$objWorksheet->getStyle("G".$row.':'."H".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("G".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "FASA_RDC_R")
				{
					$objWorksheet->mergeCells("I".$row.':'."K".$row);
					$objWorksheet->getStyle("I".$row.':'."K".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("I".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "ARUS_RDC_R")
				{
					$objWorksheet->mergeCells("L".$row.':'."N".$row);
					$objWorksheet->getStyle("L".$row.':'."N".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("L".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TEGANGAN_RDC_R")
				{
					$objWorksheet->mergeCells("O".$row.':'."Q".$row);
					$objWorksheet->getStyle("O".$row.':'."Q".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("O".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TAHANAN_RDC_R")
				{
					$objWorksheet->mergeCells("R".$row.':'."U".$row);
					$objWorksheet->getStyle("R".$row.':'."U".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("R".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TAHANAN_TEMP_RDC_R")
				{
					$objWorksheet->mergeCells("V".$row.':'."Y".$row);
					$objWorksheet->getStyle("V".$row.':'."Y".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("V".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "DEV_RDC_R")
				{
					$objWorksheet->mergeCells("Z".$row.':'."AD".$row);
					$objWorksheet->getStyle("Z".$row.':'."AD".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("Z".$row,$set->getField($field[$i]));
				}

				elseif ($field[$i] == "FASA_RDC_S")
				{
					$objWorksheet->mergeCells("I".$rowFasadll.':'."K".$rowFasadll);
					$objWorksheet->getStyle("I".$rowFasadll.':'."K".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("I".$rowFasadll,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "ARUS_RDC_S")
				{
					$objWorksheet->mergeCells("L".$rowFasadll.':'."N".$rowFasadll);
					$objWorksheet->getStyle("L".$rowFasadll.':'."N".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("L".$rowFasadll,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TEGANGAN_RDC_S")
				{
					$objWorksheet->mergeCells("O".$rowFasadll.':'."Q".$rowFasadll);
					$objWorksheet->getStyle("O".$rowFasadll.':'."Q".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("O".$rowFasadll,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TAHANAN_RDC_S")
				{
					$objWorksheet->mergeCells("R".$rowFasadll.':'."U".$rowFasadll);
					$objWorksheet->getStyle("R".$rowFasadll.':'."U".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("R".$rowFasadll,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TAHANAN_TEMP_RDC_S")
				{
					$objWorksheet->mergeCells("V".$rowFasadll.':'."Y".$rowFasadll);
					$objWorksheet->getStyle("V".$rowFasadll.':'."Y".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("V".$rowFasadll,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "DEV_RDC_S")
				{
					$objWorksheet->mergeCells("Z".$rowFasadll.':'."AD".$rowFasadll);
					$objWorksheet->getStyle("Z".$rowFasadll.':'."AD".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("Z".$rowFasadll,$set->getField($field[$i]));
				}

				elseif ($field[$i] == "FASA_RDC_T")
				{
					$objWorksheet->mergeCells("I".$rowFasadll.':'."K".$rowFasadll);
					$objWorksheet->getStyle("I".$rowFasadll.':'."K".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("I".$rowFasadll,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "ARUS_RDC_T")
				{
					$objWorksheet->mergeCells("L".$rowFasadll.':'."N".$rowFasadll);
					$objWorksheet->getStyle("L".$rowFasadll.':'."N".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("L".$rowFasadll,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TEGANGAN_RDC_T")
				{
					$objWorksheet->mergeCells("O".$rowFasadll.':'."Q".$rowFasadll);
					$objWorksheet->getStyle("O".$rowFasadll.':'."Q".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("O".$rowFasadll,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TAHANAN_RDC_T")
				{
					$objWorksheet->mergeCells("R".$rowFasadll.':'."U".$rowFasadll);
					$objWorksheet->getStyle("R".$rowFasadll.':'."U".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("R".$rowFasadll,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TAHANAN_TEMP_RDC_T")
				{
					$objWorksheet->mergeCells("V".$rowFasadll.':'."Y".$rowFasadll);
					$objWorksheet->getStyle("V".$rowFasadll.':'."Y".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("V".$rowFasadll,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "DEV_RDC_T")
				{
					$objWorksheet->mergeCells("Z".$rowFasadll.':'."AD".$rowFasadll);
					$objWorksheet->getStyle("Z".$rowFasadll.':'."AD".$rowFasadll)->applyFromArray($style);
					$objWorksheet->setCellValue("Z".$rowFasadll,$set->getField($field[$i]));
				}
				// $kolom= getColoms($index_kolom);
				// $index_kolom++;
			}	
			$row= $rowSisi+1;
			$no++;
		}

		unset($set);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqId= $set->getField("FORM_UJI_ID");
		$reqReference= $set->getField("REFERENCE");
		$reqMaxDev= $set->getField("MAX_DEV");
		$reqResult= $set->getField("RESULT");
		$reqNote= $set->getField("NOTE");
		$reqNama= $set->getField("NAMA");

		$objWorksheet->setCellValue("F4",$reqNama);
		

		$rowref= $row+2;
		$rowmaxdev= $row+3;
		$rowres= $row+4;
		$rownote= $row+5;

		$objWorksheet->setCellValue("B".$rowref,"Reference");
		$objWorksheet->setCellValue("B".$rowmaxdev,"Max Dev");
		$objWorksheet->setCellValue("B".$rowres,"Result");
		$objWorksheet->setCellValue("B".$rownote,"Note");

		$objWorksheet->setCellValue("E".$rowref,":");
		$objWorksheet->setCellValue("E".$rowmaxdev,":");
		$objWorksheet->setCellValue("E".$rowres,":");
		$objWorksheet->setCellValue("E".$rownote,":");

		$objWorksheet->getStyle("B".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("B".$rownote)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("E".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

		$objWorksheet->setCellValue("F".$rowref,$reqReference);
		$objWorksheet->setCellValue("F".$rowmaxdev,$reqMaxDev);
		$objWorksheet->setCellValue("F".$rowres,$reqResult);
		$objWorksheet->setCellValue("F".$rownote,$reqNote);

		$objWorksheet->mergeCells("F".$rowref.':'."AE".$rowref);
		$objWorksheet->mergeCells("F".$rowmaxdev.':'."AE".$rowmaxdev);
		$objWorksheet->mergeCells("F".$rowres.':'."AE".$rowres);
		$objWorksheet->mergeCells("F".$rownote.':'."AE".$rownote);

		$objWorksheet->calculateColumnWidths();

	

		// $calculatedWidth = $objWorksheet->getColumnDimension('F')->getWidth();

		// print_r($calculatedWidth);exit;
		// $objWorksheet->getColumnDimension('F')->setWidth((int) $calculatedWidth * 1.05);

		// $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);
		$objWorksheet->getRowDimension($rowref)->setRowHeight(-1);
		$objWorksheet->getRowDimension($rownote)->setRowHeight(-1);
			$objWorksheet->getStyle("F".$rowref.':'."F".$rownote)
		->getAlignment()->setWrapText(true); 
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		// $objWorksheet->getColumnDimension('F')->setWidth(80);

		// $objWorksheet->getRowDimension($rowref)->setRowHeight(50);
		// $objWorksheet->getRowDimension($rownote)->setRowHeight(50);  
		// $objWorksheet->getColumnDimension('F')->setWidth(20);

		

	

		unset($set);

		// print_r($row);exit;
				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		$objWriter->save('template/download/rdc.xlsx');

		$down = 'template/download/rdc.xlsx';
		$filename= 'rdc.xlsx';
		ob_end_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, get-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($down));
		ob_end_clean();
		readfile($down);
	}

	function tan_delta()
	{
		$reqTipe= $this->input->get("reqTipe");
		$reqId= $this->input->get("reqId");
		// print_r($reqId);exit;
		$this->load->model('base-app/FormUji');

		 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/tan_delta.xlsx');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();
		$objDrawing = new PHPExcel_Worksheet_Drawing();

		$objDrawing->setPath('images/logo-pjb.png');

		$objDrawing->setCoordinates('A1');
		$objDrawing->setResizeProportional(false);
		$objDrawing->setWidth(75);
		$objDrawing->setHeight(47);
		$objDrawing->setOffsetX(20);    
		$objDrawing->setOffsetY(35); 

		$objDrawing->setWorksheet($objWorksheet);

		$style = StyleExcel(1);

		$tahun=date("Y");
		$objWorksheet->setCellValue("Q6",$tahun);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";
		$statementDetil1= " AND A.TIPE_TAN = '1' ";

		$set->selectByParamsDetil(array(), -1, -1, $statement.$statementDetil1);

		// echo  $set->query;exit;
		$row = 12;
		$field= array();
		$field= array("FASA_RATIO","TAP_RATIO","HV_KV","LV_KV","RASIO_TEGANGAN","HV_V","DERAJAT_HV_V","LV_V","DERAJAT_LV_V","RASIO_HASIL","DEVIASI");

		// $index_kolom= 4;
		$no=1;
		while($set->nextRow())
		{
			for($i=0; $i<count($field); $i++)
			{
				// $kolom= getColoms($index_kolom);
				
				$objWorksheet->mergeCells("C".$row.':'."D".$row);
				$objWorksheet->mergeCells("E".$row.':'."F".$row);
				$objWorksheet->mergeCells("G".$row.':'."I".$row);
				$objWorksheet->mergeCells("J".$row.':'."L".$row);
				$objWorksheet->mergeCells("M".$row.':'."O".$row);
				$objWorksheet->mergeCells("P".$row.':'."R".$row);
				$objWorksheet->mergeCells("S".$row.':'."T".$row);
				$objWorksheet->mergeCells("U".$row.':'."W".$row);
				$objWorksheet->mergeCells("X".$row.':'."Y".$row);
				$objWorksheet->mergeCells("Z".$row.':'."AB".$row);
				$objWorksheet->mergeCells("AC".$row.':'."AE".$row);
				
				if ($field[$i] == "FASA_RATIO")
				{
					$objWorksheet->getStyle("C".$row.':'."D".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("C".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TAP_RATIO")
				{
					
					$objWorksheet->getStyle("E".$row.':'."F".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("E".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "HV_KV")
				{
					$objWorksheet->getStyle("G".$row.':'."I".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("K".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "LV_KV")
				{
					$objWorksheet->getStyle("J".$row.':'."L".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("J".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "RASIO_TEGANGAN")
				{
					$objWorksheet->getStyle("M".$row.':'."O".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("M".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "HV_V")
				{
					$objWorksheet->getStyle("P".$row.':'."R".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("P".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "DERAJAT_HV_V")
				{
					$objWorksheet->getStyle("S".$row.':'."T".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("S".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "LV_V")
				{
					$objWorksheet->getStyle("U".$row.':'."W".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("U".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "DERAJAT_LV_V")
				{
					$objWorksheet->getStyle("X".$row.':'."Y".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("X".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "RASIO_HASIL")
				{
					$objWorksheet->getStyle("Z".$row.':'."AB".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("Z".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "DEVIASI")
				{
					$objWorksheet->getStyle("AC".$row.':'."AE".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("AC".$row,$set->getField($field[$i]));
				}
				// $index_kolom++;
			}	
			$row++;
			$no++;
		}

		unset($set);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqId= $set->getField("FORM_UJI_ID");
		$reqReference= $set->getField("REFERENCE");
		$reqMaxDev= $set->getField("MAX_DEV");
		$reqResult= $set->getField("RESULT");
		$reqNote= $set->getField("NOTE");
		$reqNama= $set->getField("NAMA");

		$objWorksheet->setCellValue("F4",$reqNama);
		

		$rowref= $row+2;
		$rowmaxdev= $row+3;
		$rowres= $row+4;
		$rownote= $row+5;

		$objWorksheet->setCellValue("B".$rowref,"Reference");
		$objWorksheet->setCellValue("B".$rowmaxdev,"Max Dev");
		$objWorksheet->setCellValue("B".$rowres,"Result");
		$objWorksheet->setCellValue("B".$rownote,"Note");

		$objWorksheet->setCellValue("E".$rowref,":");
		$objWorksheet->setCellValue("E".$rowmaxdev,":");
		$objWorksheet->setCellValue("E".$rowres,":");
		$objWorksheet->setCellValue("E".$rownote,":");

		$objWorksheet->getStyle("B".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("B".$rownote)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("E".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

		$objWorksheet->setCellValue("F".$rowref,$reqReference);
		$objWorksheet->setCellValue("F".$rowmaxdev,$reqMaxDev);
		$objWorksheet->setCellValue("F".$rowres,$reqResult);
		$objWorksheet->setCellValue("F".$rownote,$reqNote);

		$objWorksheet->mergeCells("F".$rowref.':'."AE".$rowref);
		$objWorksheet->mergeCells("F".$rowmaxdev.':'."AE".$rowmaxdev);
		$objWorksheet->mergeCells("F".$rowres.':'."AE".$rowres);
		$objWorksheet->mergeCells("F".$rownote.':'."AE".$rownote);

		$objWorksheet->calculateColumnWidths();

	

		// $calculatedWidth = $objWorksheet->getColumnDimension('F')->getWidth();

		// print_r($calculatedWidth);exit;
		// $objWorksheet->getColumnDimension('F')->setWidth((int) $calculatedWidth * 1.05);

		// $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);
		$objWorksheet->getRowDimension($rowref)->setRowHeight(-1);
		$objWorksheet->getRowDimension($rownote)->setRowHeight(-1);
			$objWorksheet->getStyle("F".$rowref.':'."F".$rownote)
		->getAlignment()->setWrapText(true); 
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		// $objWorksheet->getColumnDimension('F')->setWidth(80);

		// $objWorksheet->getRowDimension($rowref)->setRowHeight(50);
		// $objWorksheet->getRowDimension($rownote)->setRowHeight(50);  
		// $objWorksheet->getColumnDimension('F')->setWidth(20);

		

	

		unset($set);

		// print_r($row);exit;
				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		$objWriter->save('template/download/ratio.xlsx');

		$down = 'template/download/ratio.xlsx';
		$filename= 'ratio.xlsx';
		ob_end_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, get-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($down));
		ob_end_clean();
		readfile($down);
	}

	function ex_curr()
	{
		$reqTipe= $this->input->get("reqTipe");
		$reqId= $this->input->get("reqId");
		// print_r($reqId);exit;
		$this->load->model('base-app/FormUji');

		 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/ex_curr.xlsx');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();
		$objDrawing = new PHPExcel_Worksheet_Drawing();

		$objDrawing->setPath('images/logo-pjb.png');

		$objDrawing->setCoordinates('A1');
		$objDrawing->setResizeProportional(false);
		$objDrawing->setWidth(75);
		$objDrawing->setHeight(47);
		$objDrawing->setOffsetX(20);    
		$objDrawing->setOffsetY(35); 

		$objDrawing->setWorksheet($objWorksheet);

		$style = StyleExcel(1);

		$tahun=date("Y");
		$objWorksheet->setCellValue("Q6",$tahun);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParamsDetil(array(), -1, -1, $statement);

		// echo  $set->query;exit;
		$row = 13;
		$field= array();
		$field= array("NO","TAP","TEGANGAN","IMA_RT","WATTS_RT","LC_RT","IMA_SR","WATTS_SR","LC_SR","IMA_TS","WATTS_TS","LC_TS");

		// $index_kolom= 4;
		$no=1;
		while($set->nextRow())
		{
			for($i=0; $i<count($field); $i++)
			{
				// $kolom= getColoms($index_kolom);
				
				$objWorksheet->mergeCells("C".$row.':'."D".$row);
				$objWorksheet->mergeCells("E".$row.':'."F".$row);
				$objWorksheet->mergeCells("G".$row.':'."J".$row);
				$objWorksheet->mergeCells("K".$row.':'."M".$row);
				$objWorksheet->mergeCells("N".$row.':'."P".$row);

				$objWorksheet->mergeCells("R".$row.':'."T".$row);
				$objWorksheet->mergeCells("U".$row.':'."W".$row);

				$objWorksheet->mergeCells("Y".$row.':'."AA".$row);
				$objWorksheet->mergeCells("AB".$row.':'."AD".$row);

				
				if ($field[$i] == "NO")
				{
					$objWorksheet->getStyle("C".$row.':'."D".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("C".$row,$no);
				}
				elseif ($field[$i] == "TAP")
				{
					$objWorksheet->getStyle("E".$row.':'."F".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("E".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TEGANGAN")
				{
					
					$objWorksheet->getStyle("G".$row.':'."J".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("G".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "IMA_RT")
				{
					$objWorksheet->getStyle("K".$row.':'."M".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("K".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "WATTS_RT")
				{
					$objWorksheet->getStyle("N".$row.':'."P".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("N".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "LC_RT")
				{
					$objWorksheet->getStyle("Q".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("Q".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "IMA_SR")
				{
					$objWorksheet->getStyle("R".$row.':'."T".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("R".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "WATTS_SR")
				{
					$objWorksheet->getStyle("U".$row.':'."W".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("U".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "LC_SR")
				{
					$objWorksheet->getStyle("X".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("X".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "IMA_TS")
				{
					$objWorksheet->getStyle("Y".$row.':'."AA".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("Y".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "WATTS_TS")
				{
					$objWorksheet->getStyle("AB".$row.':'."AD".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("AB".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "LC_TS")
				{
					$objWorksheet->getStyle("AE".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("AE".$row,$set->getField($field[$i]));
				}
				// $index_kolom++;
			}	
			$row++;
			$no++;
		}

		unset($set);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqId= $set->getField("FORM_UJI_ID");
		$reqReference= $set->getField("REFERENCE");
		$reqResult= $set->getField("RESULT");
		$reqNote= $set->getField("NOTE");
		$reqNama= $set->getField("NAMA");
		$reqAirTemp= $set->getField("AIR_TEMP");
		$reqHumidity= $set->getField("HUMIDITY");
		$reqApparatusTemp= $set->getField("APPARATUS_TEMP");

		$objWorksheet->setCellValue("F4",$reqNama);
		
		
		$rowtemp= $row+2;
		$rowhumidity= $row+3;

		$rowref= $row+5;
		$rowres= $row+6;
		$rownote= $row+7;

		$objWorksheet->setCellValue("D".$row,"Note : ");
		$objWorksheet->setCellValue("F".$row,"L : Inductive");
		$objWorksheet->setCellValue("J".$row,"C : Capacitive");
		$objWorksheet->setCellValue("O".$row,"N : Neutral");

		$objWorksheet->setCellValue("D".$rowtemp,"Air Temp.");
		$objWorksheet->setCellValue("H".$rowtemp,":");
		$objWorksheet->setCellValue("I".$rowtemp,$reqAirTemp);

		$objWorksheet->setCellValue("P".$rowtemp,"Apparatus Temp.");
		$objWorksheet->setCellValue("V".$rowtemp,":");
		$objWorksheet->setCellValue("W".$rowtemp,$reqApparatusTemp);

		$objWorksheet->setCellValue("D".$rowhumidity,"Humidity");
		$objWorksheet->setCellValue("H".$rowhumidity,":");
		$objWorksheet->setCellValue("I".$rowhumidity,$reqHumidity);

		$objWorksheet->setCellValue("B".$rowref,"Reference");
		$objWorksheet->getStyle("B".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->setCellValue("B".$rowres,"Result");
		$objWorksheet->setCellValue("B".$rownote,"Note");
		$objWorksheet->getStyle("B".$rownote)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->setCellValue("E".$rowref,":");
		$objWorksheet->getStyle("E".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->setCellValue("F".$rowref,$reqReference);
		$objWorksheet->setCellValue("F".$rowres,$reqResult);
		$objWorksheet->setCellValue("F".$rownote,$reqNote);

		$objWorksheet->mergeCells("F".$rowref.':'."AE".$rowref);
		$objWorksheet->mergeCells("F".$rowres.':'."AE".$rowres);
		$objWorksheet->mergeCells("F".$rownote.':'."AE".$rownote);

		$objWorksheet->calculateColumnWidths();

	

		// $calculatedWidth = $objWorksheet->getColumnDimension('F')->getWidth();

		// print_r($calculatedWidth);exit;
		// $objWorksheet->getColumnDimension('F')->setWidth((int) $calculatedWidth * 1.05);

		// $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);
		$objWorksheet->getRowDimension($rowref)->setRowHeight(-1);
		$objWorksheet->getRowDimension($rownote)->setRowHeight(-1);
			$objWorksheet->getStyle("F".$rowref.':'."F".$rownote)
		->getAlignment()->setWrapText(true); 
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		// $objWorksheet->getColumnDimension('F')->setWidth(80);

		// $objWorksheet->getRowDimension($rowref)->setRowHeight(50);
		// $objWorksheet->getRowDimension($rownote)->setRowHeight(50);  
		// $objWorksheet->getColumnDimension('F')->setWidth(20);

		

	

		unset($set);

		// print_r($row);exit;
				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		$objWriter->save('template/download/ex_curr.xlsx');

		$down = 'template/download/ex_curr.xlsx';
		$filename= 'ex_curr.xlsx';
		ob_end_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, get-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($down));
		ob_end_clean();
		readfile($down);
	}

	function ratio()
	{
		$reqTipe= $this->input->get("reqTipe");
		$reqId= $this->input->get("reqId");
		// print_r($reqId);exit;
		$this->load->model('base-app/FormUji');

		 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/ratio.xlsx');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();
		$objDrawing = new PHPExcel_Worksheet_Drawing();

		$objDrawing->setPath('images/logo-pjb.png');

		$objDrawing->setCoordinates('A1');
		$objDrawing->setResizeProportional(false);
		$objDrawing->setWidth(75);
		$objDrawing->setHeight(47);
		$objDrawing->setOffsetX(20);    
		$objDrawing->setOffsetY(35); 

		$objDrawing->setWorksheet($objWorksheet);

		$style = StyleExcel(1);

		$tahun=date("Y");
		$objWorksheet->setCellValue("Q6",$tahun);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParamsDetil(array(), -1, -1, $statement);

		// echo  $set->query;exit;
		$row = 12;
		$field= array();
		$field= array("FASA_RATIO","TAP_RATIO","HV_KV","LV_KV","RASIO_TEGANGAN","HV_V","DERAJAT_HV_V","LV_V","DERAJAT_LV_V","RASIO_HASIL","DEVIASI");

		// $index_kolom= 4;
		$no=1;
		while($set->nextRow())
		{
			for($i=0; $i<count($field); $i++)
			{
				// $kolom= getColoms($index_kolom);
				
				$objWorksheet->mergeCells("C".$row.':'."D".$row);
				$objWorksheet->mergeCells("E".$row.':'."F".$row);
				$objWorksheet->mergeCells("G".$row.':'."I".$row);
				$objWorksheet->mergeCells("J".$row.':'."L".$row);
				$objWorksheet->mergeCells("M".$row.':'."O".$row);
				$objWorksheet->mergeCells("P".$row.':'."R".$row);
				$objWorksheet->mergeCells("S".$row.':'."T".$row);
				$objWorksheet->mergeCells("U".$row.':'."W".$row);
				$objWorksheet->mergeCells("X".$row.':'."Y".$row);
				$objWorksheet->mergeCells("Z".$row.':'."AB".$row);
				$objWorksheet->mergeCells("AC".$row.':'."AE".$row);
				
				if ($field[$i] == "FASA_RATIO")
				{
					$objWorksheet->getStyle("C".$row.':'."D".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("C".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "TAP_RATIO")
				{
					
					$objWorksheet->getStyle("E".$row.':'."F".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("E".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "HV_KV")
				{
					$objWorksheet->getStyle("G".$row.':'."I".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("K".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "LV_KV")
				{
					$objWorksheet->getStyle("J".$row.':'."L".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("J".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "RASIO_TEGANGAN")
				{
					$objWorksheet->getStyle("M".$row.':'."O".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("M".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "HV_V")
				{
					$objWorksheet->getStyle("P".$row.':'."R".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("P".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "DERAJAT_HV_V")
				{
					$objWorksheet->getStyle("S".$row.':'."T".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("S".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "LV_V")
				{
					$objWorksheet->getStyle("U".$row.':'."W".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("U".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "DERAJAT_LV_V")
				{
					$objWorksheet->getStyle("X".$row.':'."Y".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("X".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "RASIO_HASIL")
				{
					$objWorksheet->getStyle("Z".$row.':'."AB".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("Z".$row,$set->getField($field[$i]));
				}
				elseif ($field[$i] == "DEVIASI")
				{
					$objWorksheet->getStyle("AC".$row.':'."AE".$row)->applyFromArray($style);
					$objWorksheet->setCellValue("AC".$row,$set->getField($field[$i]));
				}
				// $index_kolom++;
			}	
			$row++;
			$no++;
		}

		unset($set);

		$set= new FormUji();

		$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqId= $set->getField("FORM_UJI_ID");
		$reqReference= $set->getField("REFERENCE");
		$reqMaxDev= $set->getField("MAX_DEV");
		$reqResult= $set->getField("RESULT");
		$reqNote= $set->getField("NOTE");
		$reqNama= $set->getField("NAMA");

		$objWorksheet->setCellValue("F4",$reqNama);
		

		$rowref= $row+2;
		$rowmaxdev= $row+3;
		$rowres= $row+4;
		$rownote= $row+5;

		$objWorksheet->setCellValue("B".$rowref,"Reference");
		$objWorksheet->setCellValue("B".$rowmaxdev,"Max Dev");
		$objWorksheet->setCellValue("B".$rowres,"Result");
		$objWorksheet->setCellValue("B".$rownote,"Note");

		$objWorksheet->setCellValue("E".$rowref,":");
		$objWorksheet->setCellValue("E".$rowmaxdev,":");
		$objWorksheet->setCellValue("E".$rowres,":");
		$objWorksheet->setCellValue("E".$rownote,":");

		$objWorksheet->getStyle("B".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("B".$rownote)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$objWorksheet->getStyle("E".$rowref)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

		$objWorksheet->setCellValue("F".$rowref,$reqReference);
		$objWorksheet->setCellValue("F".$rowmaxdev,$reqMaxDev);
		$objWorksheet->setCellValue("F".$rowres,$reqResult);
		$objWorksheet->setCellValue("F".$rownote,$reqNote);

		$objWorksheet->mergeCells("F".$rowref.':'."AE".$rowref);
		$objWorksheet->mergeCells("F".$rowmaxdev.':'."AE".$rowmaxdev);
		$objWorksheet->mergeCells("F".$rowres.':'."AE".$rowres);
		$objWorksheet->mergeCells("F".$rownote.':'."AE".$rownote);

		$objWorksheet->calculateColumnWidths();

	

		// $calculatedWidth = $objWorksheet->getColumnDimension('F')->getWidth();

		// print_r($calculatedWidth);exit;
		// $objWorksheet->getColumnDimension('F')->setWidth((int) $calculatedWidth * 1.05);

		// $objWorksheet->getDefaultRowDimension()->setRowHeight(-1);
		$objWorksheet->getRowDimension($rowref)->setRowHeight(-1);
		$objWorksheet->getRowDimension($rownote)->setRowHeight(-1);
			$objWorksheet->getStyle("F".$rowref.':'."F".$rownote)
		->getAlignment()->setWrapText(true); 
		$objWorksheet->getColumnDimension('F')->setAutoSize(true);
		// $objWorksheet->getColumnDimension('F')->setWidth(80);

		// $objWorksheet->getRowDimension($rowref)->setRowHeight(50);
		// $objWorksheet->getRowDimension($rownote)->setRowHeight(50);  
		// $objWorksheet->getColumnDimension('F')->setWidth(20);

		

	

		unset($set);

		// print_r($row);exit;
				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		$objWriter->save('template/download/ratio.xlsx');

		$down = 'template/download/ratio.xlsx';
		$filename= 'ratio.xlsx';
		ob_end_clean();
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, get-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($down));
		ob_end_clean();
		readfile($down);
	}



	
}
?>