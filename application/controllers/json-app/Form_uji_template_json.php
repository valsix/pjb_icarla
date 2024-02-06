<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/excel.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("functions/excel_reader2.php");


class form_uji_template_json extends CI_Controller {

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

	function upload() {
	    $reqTipe= $this->input->post("reqTipe");
	    $reqId= $this->input->post("reqId");
	    $reqFormUjiId= $this->input->post("reqFormUjiId");
	    $this->load->model("base-app/PlanRlaFormUjiDetil");
	    // print_r($reqTipe);exit;

		$rowawal=3;
	    foreach ($reqTipe as $key => $value) {
	    	$tmp_name = $_FILES['reqLinkFile']['tmp_name'][$key];

	    	$data = new Spreadsheet_Excel_Reader($tmp_name);
	    	$baris = $data->rowcount($sheet_index=0);
	    	if(!empty($tmp_name))
	    	{
		    	if($value==1)
		    	{
		    		$delete = new PlanRlaFormUjiDetil();
		    		$delete->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
		    		$delete->setField("FORM_UJI_TIPE_ID", $value);
		    		$delete->setField("PLAN_RLA_ID", $reqId);
		    		$delete->deletedetil();

		    		$rowawal=3;
		    		for ($z=$rowawal; $z<=$baris; $z++){
		    			$set = new PlanRlaFormUjiDetil();
		    			$set->setField("WAKTU", $data->val($z,1));
		    			$set->setField("HV_GND", $data->val($z,2));
		    			$set->setField("LV_GND", $data->val($z,3));
		    			$set->setField("HV_LV", $data->val($z,4));
		    			$set->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
		    			$set->setField("FORM_UJI_TIPE_ID", $reqTipe[$key]);
		    			$set->setField("PLAN_RLA_ID", $reqId);

		    			if($set->insert())
		    			{
		    				$reqSimpan= 1;
		    			}
		    		}
		    	}
		    	elseif($value==2)
		    	{
		    		$delete = new PlanRlaFormUjiDetil();
		    		$delete->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
		    		$delete->setField("FORM_UJI_TIPE_ID", $value);
		    		$delete->setField("PLAN_RLA_ID", $reqId);
		    		$delete->deletedetil();

		    		$rowawal=3;
		    		for ($z=$rowawal; $z<=$baris; $z++){
		    			$set = new PlanRlaFormUjiDetil();
		    			$set->setField("WAKTU", $data->val($z,1));
		    			$set->setField("HV_GND", $data->val($z,2));
		    			$set->setField("LV_GND", $data->val($z,3));
		    			$set->setField("HV_LV", $data->val($z,4));
		    			$set->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
		    			$set->setField("FORM_UJI_TIPE_ID", $value);
		    			$set->setField("PLAN_RLA_ID", $reqId);

		    			if($set->insert())
		    			{
		    				$reqSimpan= 1;
		    			}
		    		}
		    	}
		    	elseif($value==4)
		    	{
		    		
		    	}
		    	elseif($value==5)
		    	{
		    		
		    	}
		    	elseif($value==6)
		    	{
		    		
		    	}
		    	elseif($value==7)
		    	{
		    		
		    	}
		    	elseif($value==8)
		    	{
		    		$delete = new PlanRlaFormUjiDetil();
		    		$delete->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
		    		$delete->setField("FORM_UJI_TIPE_ID", $value);
		    		$delete->setField("PLAN_RLA_ID", $reqId);
		    		$delete->deletedetil();

		    		$rowawal=4;
		    		for ($z=$rowawal; $z<=$baris; $z++){
		    			$set = new PlanRlaFormUjiDetil();
		    			$set->setField("TAP", $data->val($z,1));
		    			$set->setField("TEGANGAN_EC", $data->val($z,2));
		    			$set->setField("IMA_RT", $data->val($z,3));
		    			$set->setField("WATTS_RT", $data->val($z,4));
		    			$set->setField("LC_RT", $data->val($z,5));
		    			$set->setField("IMA_SR", $data->val($z,6));
		    			$set->setField("WATTS_SR", $data->val($z,7));
		    			$set->setField("LC_SR", $data->val($z,8));
		    			$set->setField("IMA_TS", $data->val($z,9));
		    			$set->setField("WATTS_TS", $data->val($z,10));
		    			$set->setField("LC_TS", $data->val($z,11));

		    			$set->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
		    			$set->setField("FORM_UJI_TIPE_ID", $value);
		    			$set->setField("PLAN_RLA_ID", $reqId);

		    			if($set->insert())
		    			{
		    				$reqSimpan= 1;
		    			}
		    		}
		    	}
		    	elseif($value==9)
		    	{
		    		
		    	}
		    	elseif($value==10)
		    	{
		    		// print_r($value);exit;
		    		$delete = new PlanRlaFormUjiDetil();
		    		$delete->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
		    		$delete->setField("FORM_UJI_TIPE_ID", $value);
		    		$delete->setField("PLAN_RLA_ID", $reqId);
		    		$delete->deletedetil();

		    		$rowawal=3;
		    		for ($z=$rowawal; $z<=$baris; $z++){
		    			$set = new PlanRlaFormUjiDetil();
		    			$set->setField("FASA_RATIO", $data->val($z,1));
		    			$set->setField("TAP_RATIO", $data->val($z,2));
		    			$set->setField("HV_KV", $data->val($z,3));
		    			$set->setField("LV_KV", $data->val($z,4));
		    			$set->setField("RASIO_TEGANGAN", $data->val($z,5));
		    			$set->setField("HV_V", $data->val($z,6));
		    			$set->setField("DERAJAT_HV_V",  $data->val($z,7));
		    			$set->setField("LV_V", $data->val($z,8));
		    			$set->setField("DERAJAT_LV_V",  $data->val($z,9));
		    			$set->setField("RASIO_HASIL",  $data->val($z,10));
		    			$set->setField("DEVIASI", $data->val($z,11));
		    			$set->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
		    			$set->setField("FORM_UJI_TIPE_ID", $value);
		    			$set->setField("PLAN_RLA_ID", $reqId);

		    			if($set->insert())
		    			{
		    				$reqSimpan= 1;
		    			}
		    		}
		    	}
	    	}
	    }
	    // exit;

	    if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
	}

	function ir_pi()
	{
		$reqId= $this->input->get("reqId");
		$reqTipe= $this->input->get("reqTipe");
		$reqFormUjiId= $this->input->get("reqFormUjiId");
		$this->load->model('base-app/PlanRla');

		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/export/template_ir_pi.xls');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();

		$set= new PlanRla();
		$statement = " AND FORM_UJI_TIPE_ID = ".$reqTipe." AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
		$set->selectByParamsPlanRlaFormUjiJumlah(array(), -1, -1, $statement);
		// echo $set->query;
		$set->firstRow();
		$reqJumlah= $set->getField("ROWCOUNT");
		unset($set);
		// exit;
		$rowawal=3;
		$style = StyleExcel(1);

		// print_r($reqJumlah);exit;

		$set= new PlanRla();
		$statement = " AND FORM_UJI_TIPE_ID = ".$reqTipe." AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
		$set->selectByParamsPlanRlaFormUjiDetilNama(array(), -1, -1, $statement);
		$i=$rowawal;
		while ( $set->nextRow()) {
			$reqNama = $set->getField("WAKTU");
			$objWorksheet->setCellValue("A".$i,$reqNama);
			$objWorksheet->getStyle("A".$i.':'."D".$i)->applyFromArray($style);
			$i++;
		}

		$set= new PlanRla();
		$statement = " AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
		$set->selectByParamsPlanRlaFormUjiNama(array(), -1, -1, $statement);
		// echo $set->query;
		$set->firstRow();
		$reqNamaForm= $set->getField("NAMA");
		unset($set);

		$name="ir_pi";
		if($reqTipe==1)
		{
			$name=strtolower($reqNamaForm."ir_pi_before");
		}
		elseif ($reqTipe==2) 
		{
			$name=strtolower($reqNamaForm."ir_pi_after");	
		}
		$name = preg_replace('/\s+/', '_', $name);

				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
		$objWriter->save('template/download/'.$name.'.xls');

		$down = 'template/download/'.$name.'.xls';
		$filename= ''.$name.'.xls';
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
		unlink($down);
	}

	function die_res()
	{
		$reqId= $this->input->get("reqId");
		$reqTipe= $this->input->get("reqTipe");
		$reqFormUjiId= $this->input->get("reqFormUjiId");
		$this->load->model('base-app/PlanRla');
		print_r('asdas');exit;
	}


	function tan_delta()
	{
		$reqId= $this->input->get("reqId");
		$reqTipe= $this->input->get("reqTipe");
		$reqFormUjiId= $this->input->get("reqFormUjiId");
		$this->load->model('base-app/PlanRla');

		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/export/template_tandelta.xls');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();

		$set= new PlanRla();
		$statement = " AND FORM_UJI_TIPE_ID = ".$reqTipe." AND A.FORM_UJI_ID = '".$reqFormUjiId."' AND TIPE_TAN = '1' ";
		$set->selectByParamsPlanRlaFormUjiJumlah(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqJumlah= $set->getField("ROWCOUNT");
		unset($set);
		// exit;
		$rowkelipatan=4;
		$rowawal=2;
		$style = StyleExcel(1);
		$total=($reqJumlah*$rowkelipatan) + $rowawal;

		$set= new PlanRla();
		$set->selectByParamsPlanRlaFormUjiDetilNama(array(), -1, -1, $statement);
					// echo $set->query;exit;
		$arrdata= array();
		while ( $set->nextRow()) {
			$arrdata[]= $set->getField("WINDING_TAN");
						
		}
		unset($set);

		$arrrow=[];

		for($i=$rowawal; $i< $total; $i++)
		{
			$bagi = $i / 4;
			if(is_numeric( $bagi ) && floor( $bagi ) != $bagi)
			{}
			else
			{
				$awal=$i-2;
				$akhir=$i+1;
		
				$objWorksheet->mergeCells('A'.$awal.':A'.$akhir);
				$arrrow[] = $awal;
			}
			
			$objWorksheet->getStyle("A".$i.':'."H".$i)->applyFromArray($style);

		}

		$arrisi = array_combine($arrrow, $arrdata);

		foreach ($arrisi as $key => $value) {
			$objWorksheet->setCellValue("A".$key,$value);
			$objWorksheet->getStyle("A".$key)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		}


		// WITHOUT

		$title = $akhir + 2;
		$objWorksheet->mergeCells('A'.$title.':H'.$title);
		$objWorksheet->getStyle("A".$title.':'."H".$title)->applyFromArray($style);
		$objWorksheet->setCellValue("A".$title,"Winding without Attached Bushing Calculation");
		$objWorksheet->getStyle("A".$title.':'."H".$title)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffef37');
		
		// print_r($akhir);exit;
		$set= new PlanRla();
		$statement = " AND FORM_UJI_TIPE_ID = ".$reqTipe." AND A.FORM_UJI_ID = '".$reqFormUjiId."' AND TIPE_TAN = '2' ";
		
		$set->selectByParamsPlanRlaFormUjiDetilNama(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$row = $title+1;
		while ( $set->nextRow()) {
			$reqNama = $set->getField("WINDING_WITHOUT_TAN_1");
			$objWorksheet->setCellValue("A".$row,$reqNama);
			$objWorksheet->getStyle("A".$row.':'."H".$row)->applyFromArray($style);
			$row++;
						
		}
		unset($set);

		// REF TABEL

		$title = $row + 1;
		// print_r($title);exit;
		$objWorksheet->mergeCells('A'.$title.':H'.$title);
		$objWorksheet->getStyle("A".$title.':'."H".$title)->applyFromArray($style);
		$objWorksheet->setCellValue("A".$title,"Reference Tabel");
		$objWorksheet->getStyle("A".$title.':'."H".$title)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffef37');
		
		// print_r($akhir);exit;
		$set= new PlanRla();
		$statement = " AND FORM_UJI_TIPE_ID = ".$reqTipe." AND A.FORM_UJI_ID = '".$reqFormUjiId."' AND TIPE_TAN = '3' ";
		
		$set->selectByParamsPlanRlaFormUjiDetilNama(array(), -1, -1, $statement);
		// echo $set->query;exit;
		$row = $title+1;
		while ( $set->nextRow()) {
			$reqNama = $set->getField("CONDITION_TAN");
			$objWorksheet->setCellValue("A".$row,$reqNama);
			$objWorksheet->getStyle("A".$row.':'."H".$row)->applyFromArray($style);
			$row++;
						
		}
		unset($set);

		$name="template_tandelta";
				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
		$objWriter->save('template/download/'.$name.'.xls');

		$down = 'template/download/'.$name.'.xls';
		$filename= ''.$name.'.xls';
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
		unlink($down);
	}

	function ratio()
	{
		$reqId= $this->input->get("reqId");
		$reqTipe= $this->input->get("reqTipe");
		$reqFormUjiId= $this->input->get("reqFormUjiId");
		$this->load->model('base-app/PlanRla');

		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/export/template_ratio.xls');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();

		$set= new PlanRla();
		$statement = " AND FORM_UJI_TIPE_ID = ".$reqTipe." AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
		$set->selectByParamsPlanRlaFormUjiJumlah(array(), -1, -1, $statement);
		// echo $set->query;
		$set->firstRow();
		$reqJumlah= $set->getField("ROWCOUNT");
		unset($set);
		// exit;
		$rowawal=3;
		$style = StyleExcel(1);

		// print_r($reqJumlah);exit;

		$set= new PlanRla();
		$statement = " AND FORM_UJI_TIPE_ID = ".$reqTipe." AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
		$set->selectByParamsPlanRlaFormUjiDetilNama(array(), -1, -1, $statement);
		$i=$rowawal;
		while ( $set->nextRow()) {
			$reqNama = $set->getField("FASA_RATIO");
			$objWorksheet->setCellValue("A".$i,$reqNama);
			$objWorksheet->getStyle("A".$i.':'."K".$i)->applyFromArray($style);
			$i++;
		}

		$set= new PlanRla();
		$statement = " AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
		$set->selectByParamsPlanRlaFormUjiNama(array(), -1, -1, $statement);
		// echo $set->query;
		$set->firstRow();
		$reqNamaForm= $set->getField("NAMA");
		unset($set);

		$name=strtolower($reqNamaForm."ratio");
		$name = preg_replace('/\s+/', '_', $name);

				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
		$objWriter->save('template/download/'.$name.'.xls');

		$down = 'template/download/'.$name.'.xls';
		$filename= ''.$name.'.xls';
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
		unlink($down);
	}

	function ex_curr()
	{
		$reqId= $this->input->get("reqId");
		$reqTipe= $this->input->get("reqTipe");
		$reqFormUjiId= $this->input->get("reqFormUjiId");
		$this->load->model('base-app/PlanRla');

		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/export/template_ex_curr.xls');

		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();

		$set= new PlanRla();
		$statement = " AND FORM_UJI_TIPE_ID = ".$reqTipe." AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
		$set->selectByParamsPlanRlaFormUjiJumlah(array(), -1, -1, $statement);
		// echo $set->query;
		$set->firstRow();
		$reqJumlah= $set->getField("ROWCOUNT");
		unset($set);
		// exit;
		$rowawal=4;
		$style = StyleExcel(1);

		// print_r($reqJumlah);exit;

		$set= new PlanRla();
		$statement = " AND FORM_UJI_TIPE_ID = ".$reqTipe." AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
		$set->selectByParamsPlanRlaFormUjiDetilNama(array(), -1, -1, $statement);
		$i=$rowawal;
		while ( $set->nextRow()) {
			$reqNama = $set->getField("TAP");
			$objWorksheet->setCellValue("A".$i,$reqNama);
			$objWorksheet->setCellValue("B".$i, $set->getField("TEGANGAN_EC"));
			$objWorksheet->getStyle("A".$i.':'."K".$i)->applyFromArray($style);
			$i++;
		}

		$set= new PlanRla();
		$statement = " AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
		$set->selectByParamsPlanRlaFormUjiNama(array(), -1, -1, $statement);
		// echo $set->query;
		$set->firstRow();
		$reqNamaForm= $set->getField("NAMA");
		unset($set);

		$name=strtolower($reqNamaForm."ex_curr");
		$name = preg_replace('/\s+/', '_', $name);

				
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
		$objWriter->save('template/download/'.$name.'.xls');

		$down = 'template/download/'.$name.'.xls';
		$filename= ''.$name.'.xls';
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
		unlink($down);
	}




	
}
?>