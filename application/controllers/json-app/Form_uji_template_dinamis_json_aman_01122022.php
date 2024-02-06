<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/excel.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("functions/excel_reader2.php");


class form_uji_template_dinamis_json extends CI_Controller {

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
	    $reqKelompokEquipmentId= $this->input->post("reqKelompokEquipmentId");
	    $this->load->model("base-app/TabelTemplate");
	    $this->load->model("base-app/PlanRlaFormUjiDinamis");

	    // print_r($reqKelompokEquipmentId);exit;
	    // print_r($_FILES['reqLinkFile']);exit;
		// print_r($reqTotal);exit;
		foreach ($reqPengukuranId as $key => $value) {
	    	$tmp_name= $_FILES['reqLinkFile']['tmp_name'][$key];
	    	// print_r($tmp_name);exit;

	    	if(!empty($tmp_name))
	    	{
	    		// echo $tmp_name;exit;
		    	$data = new Spreadsheet_Excel_Reader($tmp_name);
		    	// print_r(count($data->sheets[0]["cells"]));exit;
		    	// print_r($data);exit;

		    	// $baris= $data->rowcount($sheet_index=0);
		    	$baris= count($data->sheets[0]["cells"]);
		    	// print_r($baris);exit;

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
	    		$statement = " AND A.FORM_UJI_ID = ".$reqFormUjiId[$key]." AND A.TABEL_TEMPLATE_ID = ".$reqTabelId[$key]." AND A.TIPE_INPUT_ID = ".$reqTipeInputId[$key]." AND A.PENGUKURAN_ID = ".$reqPengukuranId[$key]." AND A.PLAN_RLA_ID = ".$reqId."  AND A.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId[$key]."";
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
	    		$setdelete->setField("KELOMPOK_EQUIPMENT_ID", $reqKelompokEquipmentId[$key]);
	    		$setdelete->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
	    		$setdelete->setField("TABEL_TEMPLATE_ID", $reqTabelId[$key]);
	    		$setdelete->setField("TIPE_INPUT_ID", $reqTipeInputId[$key]);
	    		$setdelete->setField("PENGUKURAN_ID", $reqPengukuranId[$key]);
	    		$setdelete->setField("PLAN_RLA_ID", $reqId);
	    		$setdelete->delete();

	    		// print_r($reqTotal);exit;
	    		for ($z=$rowawal; $z<=$baris; $z++){
	    			
	    			for ($i=1; $i < $reqTotal + 1 ; $i++) { 
	    				$set = new PlanRlaFormUjiDinamis();
	    				// print_r($data->val($z,$i));
	    				$set->setField("NAMA", $data->val($z,$i));
	    				$set->setField("FORM_UJI_ID", $reqFormUjiId[$key]);
	    				$set->setField("KELOMPOK_EQUIPMENT_ID", $reqKelompokEquipmentId[$key]);
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
		$statement = " AND A.PENGUKURAN_ID =".$reqPengukuranId." AND STATUS_TABLE = 'TABLE' AND A.FORM_UJI_ID = ".$reqId." AND A.TABEL_TEMPLATE_ID = ".$reqTabelId."  ";
		$setisi->selectByParamsDetilDinamis(array(), -1, -1, $statement);
		// echo $setisi->query; exit;

		$rowawalisi= 0;
		$rowisi= $maxbarisrla+1;
		// print_r($reqTotal);exit;
		$reqTotalIsi=$reqTotal;
		// while($setisi->nextRow())
		// {
			$kolom= toAlpha($rowawalisi);
			

			// $reqNamaKolom= $setisi->getField("NAMA");
			// $reqIdDetil= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");

			// $objWorksheet->setCellValue($kolom.$rowisi, $reqNamaKolom);
			// $objWorksheet->setCellValue("BL".$rowisi,$reqIdDetil);
			// $objWorksheet->getStyle($kolom.$rowisi)->applyFromArray($style);
			for ($i=2; $i < $reqTotalIsi + 1 ; $i++) { 
				$kolomtotal=getColoms($i);
				// print_r($kolomtotal);
				$objWorksheet->getStyle($kolomtotal.$rowisi)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('a5a5a5');
				$objWorksheet->getStyle($kolomtotal.$rowisi)->applyFromArray($style);
			}
			$rowisi++;
		// }
		
		// exit;

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

		$name="Master_".$reqKodePengukuran."_".$reqNamaTabel;
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

	function template_dinamis_plan_rla()
	{
		// print_r(PHPExcel_Calculation_Functions::VERSION());

		$reqId= $this->input->get("reqId");
		$reqPengukuranId= $this->input->get("reqPengukuranId");
		$reqFormUjiId= $this->input->get("reqFormUjiId");
		$reqTipeInputId= $this->input->get("reqTipeInputId");
		$reqTabelId= $this->input->get("reqTabelId");
		$reqKelompokEquipmentId= $this->input->get("reqKelompokEquipmentId");
		$this->load->model('base-app/PlanRla');
		$this->load->model('base-app/FormUji');
		$this->load->model('base-app/TabelTemplate');
		$this->load->model('base-app/Pengukuran');
		$this->load->model('base-app/KelompokEquipment');

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
		$reqTotalIsi=$reqTotal;
		while($setisi->nextRow())
		{
			$kolom= toAlpha($rowawalisi);
			$kolomtotal=getColoms(1);
			$koltotal=getColoms($reqTotalIsi);

			$reqNamaKolom= $setisi->getField("NAMA");
			$reqIdDetil= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");

			$objWorksheet->setCellValue($kolom.$rowisi, $reqNamaKolom);
			$objWorksheet->setCellValue("BL".$rowisi,$reqIdDetil);

			// echo $kolom.$rowisi.':'.$kolom.$rowisi;exit;
			// $objWorksheet->getStyle($kolom.$rowawalisi.':'.$kolom.$rowisi)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('a5a5a5');
			// // $objWorksheet->getStyle($kolom.$rowisi.':'.$kolom.$rowisi)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF33');
			// $objWorksheet->getStyle($kolom.$rowawalisi.':'.$kolomtotal.$rowisi)->applyFromArray($style);
			// print_r($kolom.$rowisi);
		
			$objWorksheet->getStyle($kolom.$rowisi)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('a5a5a5');
			$objWorksheet->getStyle($kolom.$rowisi)->applyFromArray($style);
			$objWorksheet->getStyle($kolom.$rowawalisi.':'.$koltotal.$rowisi)->applyFromArray($style);
			

			$rowisi++;
		}
		// exit;

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

		$set= new KelompokEquipment();
		$statement = " AND A.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." ";
		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query; exit;
		$set->firstRow();
		$reqNamaKolom= $set->getField("NAMA");
		unset($set);

		$name=$reqNamaKolom."_".$reqKodePengukuran."_".$reqNamaTabel;
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

	function template_dinamis_plan_rlabug()
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
		$rowbaris=1;
		$rowawal=1;
		$rowspani=1;
		$rowspan="";
		$baristest=1;
		while ( $set->nextRow()) {
		
			$reqRowspan = $set->getField("ROWSPAN");
			$reqColspan = $set->getField("COLSPAN");
			$reqBaris = intval($set->getField("BARIS"));
			$reqNama = $set->getField("NAMA_TEMPLATE");
			$reqTotal = $set->getField("TOTAL");
			$kolom=getColoms($rowawal);
			$kolomcol=getColoms($reqColspan);
			// print_r($kolom);
			if(!empty($reqRowspan))
			{

				$kolomcol=getColoms($reqColspan+$reqRowspan);
				$objWorksheet->mergeCells($kolom."1".':'.$kolom.$reqRowspan);
				$objWorksheet->getStyle($kolom."1".':'.$kolom.$reqRowspan)->applyFromArray($style);
				$objWorksheet->getStyle($kolom.'1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$objWorksheet->setCellValue($kolom.'1',$reqNama);

				$rowspan=$reqRowspan;
				$rowspani++;

			}
			else if(!empty($reqColspan))
			{
				// print_r($rowspan);
				if(!empty($rowspan))
				{
					$kolrowlanjut=getColoms($rowspan+$reqColspan);
					// if($reqBaris == 1)
					// {

						// print_r($reqColspan);
						
						$objWorksheet->getStyle($kolom.$reqBaris.':'.$kolrowlanjut.$reqBaris)->applyFromArray($style);
						$objWorksheet->getStyle($kolom.$reqBaris.':'.$kolrowlanjut.$reqBaris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						
						$objWorksheet->setCellValue($kolom.'1',$reqNama);
					
						if (!$objWorksheet->getCellByColumnAndRow( $rowawal, $reqBaris )->isInMergeRange() || $objWorksheet->getCellByColumnAndRow( $rowawal, $reqBaris )->isMergeRangeValueCell()) {
							// print_r($kolom.$reqBaris);
						} else {
             				

							$objWorksheet->mergeCells($kolom.$reqBaris.':'.$kolrowlanjut.$reqBaris);
            
						}

						// print_r($kolom.$reqBaris.':'.$kolrowlanjut.$reqBaris.'</br>');

						// print_r($objWorksheet->getMergeCells());


					// }
					// else
					// {
						// $kolawal=getColoms($rowspan+$reqColspan+1);
						// $kollanjut=getColoms($rowspan+$reqColspan+$reqColspan);
						// $kolrowlanjutspan=getColoms($rowspan+$reqColspan+1+$reqColspan);
						// $colspanbaris=getColoms($rowspan+1);
						// $colawal= $kolawal.$reqBaris;
						// $collanjut= $kollanjut.$reqBaris;
						// $collanjutspan= $kolrowlanjutspan.$reqBaris;
						// // print_r($collanjut.':'.$kolrowlanjut.$reqBaris.'</br>');
						// print_r($collanjut);
						// // print_r($kolrowlanjut);
						// for ($x=1; $x < $reqBaris+1 ; $x++) {

						// 	// print_r($rowspan+$reqColspan+$reqColspan);
						// 	// print_r($colspanbaris.$reqBaris.':'.$kolrowlanjut.$reqBaris.'</br>');
						// }
					 	
						
						// $objWorksheet->getStyle($colspanbaris.$reqBaris.':'.$kolrowlanjut.$reqBaris)->applyFromArray($style);
						// $objWorksheet->getStyle($colspanbaris.$reqBaris.':'.$kolrowlanjut.$reqBaris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

						// $objWorksheet->setCellValue($kolrowlanjut.'1',$reqNama);

						
					// }
					
				}
				else
				{

					// if($objWorksheet->getCellByColumnAndRow( $kolom, $reqBaris )->isInMergeRange())
					// {
					// 	print_r('a');exit;
					// } 
					// $objWorksheet->mergeCells($kolom.$reqBaris.':'.$kolomcol.$reqBaris);
					// // $objWorksheet->getMergeCells();
					// $objWorksheet->getStyle($kolom.$reqBaris.':'.$kolomcol.$reqBaris)->applyFromArray($style);
					// $objWorksheet->getStyle($kolom.$reqBaris.':'.$kolomcol.$reqBaris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					// $objWorksheet->setCellValue($kolom.$reqBaris,$reqNama);
				}

				
				
				// print_r($kolomrspan);
				

				// print_r($kolom.$rowawal.':'.$kolom.$reqRowspan);
			}
			else
			{
				if($reqBaris > 1)
				{
					
					if(!empty($rowspan))
					{
						$kolombaris=getColoms($maxbarisrla);
					}
					else
					{
						$kolombaris=getColoms($baristest);
					}
					
					
					$objWorksheet->setCellValue($kolombaris.$reqBaris,$reqNama);
					// print_r($kolombaris.$reqBaris);
					$baristest++;
					$maxbarisrla++;
					
				}
				else
				{

					$objWorksheet->getStyle($kolom.$reqBaris)->applyFromArray($style);
					$objWorksheet->getStyle($kolom.$reqBaris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					// print_r($kolom.$rowawal);
					$objWorksheet->setCellValue($kolom.$reqBaris,$reqNama);

				}
				
			}



			$rowawal++;
		}		
		unset($set);

		// exit;

		$setisi= new FormUji();
		$statement = " AND A.PENGUKURAN_ID =".$reqPengukuranId." AND STATUS_TABLE = 'TABLE' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.TABEL_TEMPLATE_ID = ".$reqTabelId."  ";
		$setisi->selectByParamsDetilDinamis(array(), -1, -1, $statement);
		// echo $setisi->query; exit;

		$rowawalisi = 1;
		$rowisi = $rowspan+1;
		// print_r($rowisi);exit;
		while($setisi->nextRow())
		{

			$kolom=getColoms($rowawalisi);
			$kolomtotal=getColoms($reqTotal);
			$reqNamaKolom= $setisi->getField("NAMA");
			$reqIdDetil= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");
			$objWorksheet->setCellValue($kolom.$rowisi,$reqNamaKolom);
			$objWorksheet->setCellValue("BL".$rowisi,$reqIdDetil);
			$objWorksheet->getStyle($kolom.$rowawalisi.':'.$kolom.$rowisi)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF33');
			$objWorksheet->getStyle($kolom.$rowawalisi.':'.$kolomtotal.$rowisi)->applyFromArray($style);
			$rowisi++;
		}

		// exit;

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
		// print_r($name);exit;

		// print_r($name);exit;

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
}
?>