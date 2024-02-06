<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/excel.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("functions/excel_reader2.php");


class form_uji_template_dinamis_jsoncoba extends CI_Controller {

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
		// $this->load->library('Classes/PHPExcel');
		$this->load->library('phpexcelnew/Classes/PHPExcel');
		
	}	

	function upload() {
	    $reqPengukuranId= $this->input->post("reqPengukuranId");
	    $reqId= $this->input->post("reqId");
	    $reqFormUjiId= $this->input->post("reqFormUjiId");
	    $reqTipeInputId= $this->input->post("reqTipeInputId");
	    $reqTabelId= $this->input->post("reqTabelId");
	    // print_r($reqPengukuranId);exit;
	    $this->load->model("base-app/TabelTemplate");
	    $this->load->model("base-app/PlanRlaFormUjiDinamis");

	
		// print_r($reqTotal);exit;
		foreach ($reqPengukuranId as $key => $value) {
	    	$tmp_name = $_FILES['reqLinkFile']['tmp_name'][$key];

	    	$data = new Spreadsheet_Excel_Reader($tmp_name);

	    	// print_r($data);
	    	$baris = $data->rowcount($sheet_index=0);

	    	if(!empty($tmp_name))
	    	{
	    		$setbaris= new TabelTemplate();
	    		$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId[$key]." ";
	    		$setbaris->selectByParamsMaxBaris(array(), -1, -1, $statement);
 				// echo $set->query;exit; 
	    		$setbaris->firstRow();
	    		$maxbarisrla= $setbaris->getField("MAX");

	    		$settotal= new TabelTemplate();
	    		$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId[$key]." ";
	    		$settotal->selectByParamsDetil(array(), -1, -1, $statement);
				// echo $set->query;exit;
	    		$settotal->firstRow();

	    		$reqRowspan = $settotal->getField("ROWSPAN");
	    		$reqColspan = $settotal->getField("COLSPAN");
	    		$reqBaris = intval($settotal->getField("BARIS"));
	    		$reqNama = $settotal->getField("NAMA_TEMPLATE");
	    		$reqTotal = $settotal->getField("TOTAL");
			


	    		$rowawal=$maxbarisrla + 1;
	    		
	    		$setbarisdetil= new PlanRlaFormUjiDinamis();
	    		$statement = " AND A.FORM_UJI_ID = ".$reqFormUjiId[$key]." AND A.TABEL_TEMPLATE_ID = ".$reqTabelId[$key]." AND A.TIPE_INPUT_ID = ".$reqTipeInputId[$key]." AND A.PENGUKURAN_ID = ".$reqPengukuranId[$key]." AND A.PLAN_RLA_ID = ".$reqId." ";
	    		$setbarisdetil->selectByParamsMaxBaris(array(), -1, -1, $statement);
 				// echo $set->query;exit; 
	    		$setbarisdetil->firstRow();
	    		$barisdetil= $setbarisdetil->getField("MAX") + 1;
	    		// var_dump($barisdetil);
	    		if(empty($barisdetil))
	    		{
	    			$barisdetil=1;
	    		}

	    		$setdelete= new PlanRlaFormUjiDinamis();
	    		$setdelete->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
	    		$setdelete->setField("TABEL_TEMPLATE_ID", $reqTabelId[$key]);
	    		$setdelete->setField("TIPE_INPUT_ID", $reqTipeInputId[$key]);
	    		$setdelete->setField("PENGUKURAN_ID", $reqPengukuranId[$key]);
	    		$setdelete->setField("PLAN_RLA_ID", $reqId);
	    		$setdelete->delete();


	    		for ($z=$rowawal; $z<=$baris; $z++){
	    			
	    			for ($i=1; $i < $reqTotal + 1 ; $i++) { 
	    				$set = new PlanRlaFormUjiDinamis();
	    				$set->setField("NAMA", $data->val($z,$i));
	    				$set->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
	    				$set->setField("TABEL_TEMPLATE_ID", $reqTabelId[$key]);
	    				$set->setField("TIPE_INPUT_ID", $reqTipeInputId[$key]);
	    				$set->setField("PENGUKURAN_ID", $reqPengukuranId[$key]);
	    				$set->setField("PLAN_RLA_ID", $reqId);
	    				$set->setField("BARIS", $barisdetil);
	    				$set->setField("FORM_UJI_DETIL_DINAMIS_ID", $data->val($z,64));

	    				if($set->insert())
	    				{
	    					$reqSimpan= 1;
	    				}
	    				
	    			}
	    			$barisdetil++;
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

	function template_dinamis()
	{
		$reqId= $this->input->get("reqId");
		$reqPengukuranId= $this->input->get("reqPengukuranId");
		$reqTipeInputId= $this->input->get("reqTipeInputId");
		$reqTabelId= $this->input->get("reqTabelId");
		$this->load->model('base-app/FormUji');
		$this->load->model('base-app/TabelTemplate');

		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/export/template_dinamis.xls');


		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();

		$style = StyleExcel(1);

		$set= new TabelTemplate();
		$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." ";
		$set->selectByParamsMaxBaris(array(), -1, -1, $statement);
 		// echo $set->query;exit; 
		$set->firstRow();
		$maxbaris= $set->getField("MAX");

		// var_dump($maxbaris);exit;
		unset($set);

		$set= new TabelTemplate();
		$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." ";
		$set->selectByParamsDetil(array(), -1, -1, $statement);
		// echo $set->query;exit;
		// $rowbaris=0;
		$rowawal=1;
		while ( $set->nextRow()) {
		
			$reqRowspan = $set->getField("ROWSPAN");
			$reqColspan = $set->getField("COLSPAN");
			$reqBaris = intval($set->getField("BARIS"));
			$reqNama = $set->getField("NAMA_TEMPLATE");
			$kolom=getColoms($rowawal);
			$kolomcol=getColoms($reqColspan);
			// print_r($kolom);
			if(!empty($reqRowspan))
			{
				// $objWorksheet->mergeCells($kolom.$rowawal.':'.$kolom.$reqRowspan);
				// $objWorksheet->getStyle($kolom.$rowawal.':'.$kolom.$reqRowspan)->applyFromArray($style);
				$objWorksheet->getStyle($kolom.$rowawal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				// print_r($reqNama.$reqRowspan);
				$objWorksheet->setCellValue($kolom.$rowawal,$reqNama);
				// print_r($reqNama);

				// print_r($kolom.$rowawal.':'.$kolom.$reqRowspan);
			}
			elseif(!empty($reqColspan))
			{
				$objWorksheet->getStyle($kolom.$rowawal)->applyFromArray($style);
				$objWorksheet->getStyle($kolom.$rowawal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				
				$setcol= new TabelTemplate();
				$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." AND B.BARIS =".$maxbaris;
				$setcol->selectByParamsDetil(array(), -1, -1, $statement);
				$setcol->firstRow();
				$reqNama = $setcol->getField("NAMA_TEMPLATE");
				$objWorksheet->setCellValue($kolom.$rowawal,$reqNama);
				// print_r($reqNama);
				// print_r($reqNama);


				// print_r($kolom.$rowawal.':'.$kolom.$reqRowspan);
			}

			elseif(empty($reqRowspan) && empty($reqColspan) )
			{
				$objWorksheet->getStyle($kolom.$rowawal)->applyFromArray($style);
				// print_r($reqNama);
				$setnew= new TabelTemplate();
				$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." ";
				$setnew->selectByParamsDetil(array(), -1, -1, $statement);
				$setnew->firstRow();
				$reqNama = $setnew->getField("NAMA_TEMPLATE");
				$objWorksheet->setCellValue($kolom.$rowawal,$reqNama);
				// print_r($reqNama);

			}
						

			// $rowawal++;
		}

		// exit;

		
		unset($set);

		$set= new FormUji();
		$statement = " AND A.FORM_UJI_ID = ".$reqId." ";
		$set->selectByParams(array(), -1, -1, $statement);
		$set->firstRow();
		$reqKode= $set->getField("KODE");
		unset($set);

		$set= new TabelTemplate();
		$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." ";
		$set->selectByParams(array(), -1, -1, $statement);
		$set->firstRow();
		$reqNamaTabel= $set->getField("NAMA");
		unset($set);

		// print_r($reqNamaTabel);exit;

		$name=$reqKode."_".$reqNamaTabel;
		$name = preg_replace('/\s+/', '_', $name);

		// print_r($name);exit;

				
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


	function template_dinamis_plan_rla()
	{
		// print_r(PHPExcel_Calculation_Functions::VERSION());

		$reqId= $this->input->get("reqId");
		$reqPengukuranId= $this->input->get("reqPengukuranId");
		$reqFormUjiId= $this->input->get("reqFormUjiId");
		$reqTipeInputId= $this->input->get("reqTipeInputId");
		$reqTabelId= $this->input->get("reqTabelId");
		$this->load->model('base-app/PlanRla');
		$this->load->model('base-app/FormUji');
		$this->load->model('base-app/TabelTemplate');
		$this->load->model('base-app/Pengukuran');

		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/export/template_dinamis.xls');


		$sheetIndex= 0;
		$objPHPexcel->setActiveSheetIndex($sheetIndex);
		$objWorksheet= $objPHPexcel->getActiveSheet();

		$style = StyleExcel(1);

		$set= new TabelTemplate();
		$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." ";
		$set->selectByParamsMaxBaris(array(), -1, -1, $statement);
 		// echo $set->query;exit;
		$set->firstRow();
		$maxbarisrla= $set->getField("MAX");

		// var_dump($maxbarisrla);exit;
		unset($set);

		$set= new TabelTemplate();
		$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." ";
		$set->selectByParamsDetil(array(), -1, -1, $statement);
		// echo $set->query;exit;

		$tabeltemplate= [];
		while ($set->nextRow())
		{
			$inforowspan= $set->getField("ROWSPAN");
			$infobaris= $set->getField("BARIS");

			$inforowspancheck= "";
			if(!empty($inforowspan))
				$inforowspancheck= "ADA";

			$arrdata= [];
			$arrdata["ROWSPAN"]= $inforowspan;
			$arrdata["COLSPAN"]= $set->getField("COLSPAN");
			$arrdata["BARIS"]= $infobaris;
			$arrdata["BARISROWSPAN"]= $infobaris.$inforowspancheck;
			$arrdata["NAMA_TEMPLATE"]= $set->getField("NAMA_TEMPLATE");
			$arrdata["TOTAL"]= $set->getField("TOTAL");
			array_push($tabeltemplate, $arrdata);
		}
		// print_r($tabeltemplate);exit;

		// $maxbarisrla= 2;
		for($index= 1; $index <= $maxbarisrla; $index++)
		{
			$kolomawal= 0;
			$infocarikey= $index;
			$arrcheck= in_array_column($infocarikey, "BARIS", $tabeltemplate);
			foreach ($arrcheck as $vindex)
			{
				// print_r($tabeltemplate[$vindex]);exit;
				$reqRowspan= $tabeltemplate[$vindex]["ROWSPAN"];
				$reqColspan= $tabeltemplate[$vindex]["COLSPAN"];
				$reqBaris= intval($tabeltemplate[$vindex]["BARIS"]);
				$reqNama= $tabeltemplate[$vindex]["NAMA_TEMPLATE"];
				$reqTotal= $tabeltemplate[$vindex]["TOTAL"];

				$kolom= toAlpha($kolomawal);
				// kalau ada rowspan
				if(!empty($reqRowspan))
				{
					$mergerow= ($reqBaris + $reqRowspan)-1;
					// echo $kolom.$reqBaris.':'.$kolom.$mergerow."<br/>";

					$objWorksheet->getStyle($kolom.$reqBaris.':'.$kolom.$mergerow)->applyFromArray($style);
					$objWorksheet->getStyle($kolom.$reqBaris.':'.$kolom.$mergerow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objWorksheet->mergeCells($kolom.$reqBaris.':'.$kolom.$mergerow);

					$kolomawal++;
				}
				// kalau ada colspan
				else if(!empty($reqColspan))
				{
					if($index > 1 && $kolomawal == 0)
					{
						$infocarikey= $index - 1;
						$infocarikey= $infocarikey."ADA";
						$arrcheckdetil= in_array_column($infocarikey, "BARISROWSPAN", $tabeltemplate);
						// echo $kolomawal."<br/>";
						$kolomawal= $kolomawal + count($arrcheckdetil);
						$kolom= toAlpha($kolomawal);
					}
					$kolomawal= $kolomawal+$reqColspan;
					$mergekolom= toAlpha(($kolomawal)-1);
					// echo $kolom.$reqBaris.':'.$mergekolom.$reqBaris.";".$reqNama.";".$index."<br/>";
					// exit;

					$objWorksheet->getStyle($kolom.$reqBaris.':'.$mergekolom.$reqBaris)->applyFromArray($style);
					$objWorksheet->getStyle($kolom.$reqBaris.':'.$mergekolom.$reqBaris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$objWorksheet->mergeCells($kolom.$reqBaris.':'.$mergekolom.$reqBaris);
				}
				// kalau normal
				else
				{
					if($index > 1)
					{
						if($kolomawal == 0)
						{
							$batascari= $index-1;
							// echo $batascari;exit;
							while($batascari >= 1)
							{
								$infocarikey= $batascari;
								// echo $infocarikey."<br/>";

								$infocarikey= $infocarikey."ADA";
								$arrcheckdetil= in_array_column($infocarikey, "BARISROWSPAN", $tabeltemplate);
								// print_r($arrcheckdetil);exit;
								if(!empty($arrcheckdetil))
								{
									$kolomawal= count($arrcheckdetil);
									// echo $infocarikey."<br/>";
									// print_r($arrcheckdetil);exit;
									$kolom= toAlpha($kolomawal);
									// echo "x".$kolom."<br/>";
								}
								// else
								// {
								// 	echo $kolomawal."<br/>";
								// 	$kolomawal++;
								// }

								$batascari--;	
							}
							// exit;
						}
					}
					
					$objWorksheet->getStyle($kolom.$reqBaris)->applyFromArray($style);
					$objWorksheet->getStyle($kolom.$reqBaris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$kolomawal++;
				}
				// echo $index.";".$kolom.$reqBaris."<br/>";

				$objWorksheet->setCellValue($kolom.$reqBaris, $reqNama);
			}
		}
		// exit;

		// untuk mengisi data
		$setisi= new FormUji();
		$statement = " AND A.PENGUKURAN_ID =".$reqPengukuranId." AND STATUS_TABLE = 'TABLE' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.TABEL_TEMPLATE_ID = ".$reqTabelId."  ";
		$setisi->selectByParamsDetilDinamis(array(), -1, -1, $statement);
		// echo $setisi->query; exit;

		$rowawalisi= 0;
		$rowisi= $maxbarisrla+1;
		// print_r($rowisi);exit;
		while($setisi->nextRow())
		{
			$kolom= toAlpha($rowawalisi);
			$kolomtotal=getColoms($reqTotal);

			$reqNamaKolom= $setisi->getField("NAMA");
			$reqIdDetil= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");

			$objWorksheet->setCellValue($kolom.$rowisi, $reqNamaKolom);
			$objWorksheet->setCellValue("BL".$rowisi,$reqIdDetil);

			// $objWorksheet->getStyle($kolom.$rowawalisi.':'.$kolom.$rowisi)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF33');
			// $objWorksheet->getStyle($kolom.$rowawalisi.':'.$kolomtotal.$rowisi)->applyFromArray($style);

			// echo $kolom.$rowisi.':'.$kolom.$rowisi;exit;
			$objWorksheet->getStyle($kolom.$rowisi.':'.$kolom.$rowisi)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF33');
			$objWorksheet->getStyle($kolom.$rowawalisi.':'.$kolomtotal.$rowisi)->applyFromArray($style);

			$rowisi++;
		}

		$set= new PlanRla();
		$statement = " AND A.PLAN_RLA_ID = ".$reqId." ";
		$set->selectByParams(array(), -1, -1, $statement);
		$set->firstRow();
		$reqKode= $set->getField("KODE_MASTER_PLAN");
		unset($set);

		$set= new TabelTemplate();
		$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." ";
		$set->selectByParams(array(), -1, -1, $statement);
		$set->firstRow();
		$reqNamaTabel= $set->getField("NAMA");
		unset($set);

		$set= new Pengukuran();
		$statement = " AND A.PENGUKURAN_ID = ".$reqPengukuranId." ";
		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query; exit;
		$set->firstRow();
		$reqKodePengukuran= $set->getField("KODE");
		unset($set);

		$name=$reqKode."_".$reqKodePengukuran."_".$reqNamaTabel;
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