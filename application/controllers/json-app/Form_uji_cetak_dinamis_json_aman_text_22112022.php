<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/excel.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class form_uji_cetak_dinamis_json extends CI_Controller {

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

	function cetak_dinamis()
	{
		$reqTipe= $this->input->get("reqTipe");
		$reqId= $this->input->get("reqId");
		$reqKelompokEquipmentId= $this->input->get("reqKelompokEquipmentId");
		$this->load->model('base-app/FormUji');
		$this->load->model('base-app/PlanRla');
		$this->load->model('base-app/FormUji');
		$this->load->model('base-app/TabelTemplate');
		$this->load->model('base-app/Pengukuran');
		$this->load->model('base-app/KelompokEquipment');
		$this->load->model('base-app/CetakFormUjiDinamis');
		$this->load->model('base-app/PlanRlaFormUjiDinamis');


		 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/cetak/template_dinamis.xlsx');

		// print_r($reqId);exit;

		$sheetIndex= 0;

		$style = StyleExcel(1);

		$tahun=date("Y");
		$tanggalsekarang=getFormattedDate(date("Y-m-d"));

		$set= new CetakFormUjiDinamis();

		$statement = " AND A.PLAN_RLA_ID = '".$reqId."' ";
		$set->selectByParams(array(), -1, -1, $statement);
		$set->firstRow();
		$reqUnit = $set->getField("NAMA_UNIT");
		$reqTahun = $set->getField("TAHUN");
		$reqKodeMaster = $set->getField("KODE_MASTER_PLAN");
		unset($set);


		$set= new CetakFormUjiDinamis();
		$arrformuji= [];
		$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND D.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."'  ";

		$set->selectByParamsFormUjiReport(array(), -1,-1,$statement);
		// echo  $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
			$arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
			$arrdata["NAMA"]= $set->getField("NAMA");
			$arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
			$arrdata["JUMLAH"]= $set->rowCount;
			array_push($arrformuji, $arrdata);
		}
		unset($set);

		
		if(!empty($arrformuji))
		{
			$sheet = 1;

			foreach ($arrformuji as $key => $value) 
			{
				$reqFormUjiId=$value["FORM_UJI_ID"]; 
				$reqKelompokEquipmentId=$value["KELOMPOK_EQUIPMENT_ID"]; 
				$reqNamaKelompok=$value["NAMA_KELOMPOK"]; 
				$reqNamaFormUji= $value["NAMA"];
				$arrjudul = explode(' ',trim($reqNamaFormUji));
				$judulsheet= $arrjudul[0];
				$jumlahdata=  $value["JUMLAH"];
				
			    // $objWorksheet = clone $objPHPexcel->getActiveSheet();
				$objWorksheet = clone $objPHPexcel->setActiveSheetIndex(0);
				$objWorksheet->setTitle("$judulsheet");
			    $objPHPexcel->addSheet($objWorksheet);
 

			    $objDrawing = new PHPExcel_Worksheet_Drawing();


			    $objDrawing->setPath('images/logo-pjb.png');

			    $objDrawing->setCoordinates('A1');
			    $objDrawing->setResizeProportional(false);
			    $objDrawing->setWidth(120);
			    $objDrawing->setHeight(50);
			    $objDrawing->setOffsetX(2);    
			    $objDrawing->setOffsetY(2); 

			    $objDrawing->setWorksheet($objWorksheet);

			    $objWorksheet->setCellValue("F4",$reqNamaFormUji);
			    $objWorksheet->setCellValue("Q6",$reqTahun);
			    $objWorksheet->setCellValue("C6",$reqUnit);
			    $objWorksheet->setCellValue("Z1",": ".$reqKodeMaster);
			    $objWorksheet->setCellValue("Z2",": ".$tanggalsekarang);
			    $objWorksheet->setCellValue("Z3",": 1");
			    $objWorksheet->setCellValue("Z4",": 1");

				$tabeli=1;
				$tambahbaris=0;
				$baristext=8;
				$reqBaris=0;
				$barispengukuran= 8;
				$barisjudulatas=8;

				$barisisitabel=8;

				$objWorksheet =  $objPHPexcel->setActiveSheetIndex($sheet);

				$arrbarisrla= [];

				$barisrla= new CetakFormUjiDinamis();
				$statement = "   AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.PLAN_RLA_ID = ".$reqId." ";
				$barisrla->selectByParamsMaxBarisPlanRla(array(), -1, -1, $statement);
				// echo $barisrla->query;
				$iarr=0;
				while ($barisrla->nextRow())
				{
					$arrdata= [];
					$arrdata["BARIS_RLA"]= $barisrla->getField("MAX");
					array_push($arrbarisrla, $arrdata);
				}

				$baristextj=$barisisitabel+$arrbarisrla[0]["BARIS_RLA"];

				$reqCheckValue=0;
				$statementv = "  AND F.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND F.FORM_UJI_ID= ".$reqFormUjiId."  AND F.PLAN_RLA_ID = '".$reqId."' AND D.VALUE <> '' AND A.STATUS_TABLE ='TEXT' ";
				$checkvalue= new CetakFormUjiDinamis();
				$checkvalue->selectByParamsPengukuranTipeInputBaruText(array(), -1,-1,$statementv);
				// echo  $checkvalue->query;
				// $checkvalue->firstRow();
				$reqCheckValue=  $checkvalue->rowCount;
				$reqNamaText=  $checkvalue->getField("NAMA");

				// print_r($reqNamaText);

				$statement = "  AND F.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND F.FORM_UJI_ID= ".$reqFormUjiId."  AND F.PLAN_RLA_ID = '".$reqId."' ";
				$setlist= new CetakFormUjiDinamis();
				$setlist->selectByParamsPengukuranTipeInputBaru(array(), -1,-1,$statement);
				// echo  $setlist->query;

				while($setlist->nextRow())
				{

					$reqMasterTabelId= $setlist->getField("TABEL_TEMPLATE_ID");
					$reqStatusTable= $setlist->getField("STATUS_TABLE");
					$reqValue= $setlist->getField("VALUE");
					$reqTipePengukuranId= $setlist->getField("PENGUKURAN_ID");

					$reqPengukuranTipeInputId= $setlist->getField("PENGUKURAN_TIPE_INPUT_ID");

					print_r($reqPengukuranTipeInputId);


					if($reqStatusTable=="TABLE")
					{

						$statement = " AND A.PENGUKURAN_ID = ".$reqTipePengukuranId." AND A.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.PLAN_RLA_ID = '".$reqId."' AND A.TABEL_TEMPLATE_ID= ".$reqMasterTabelId."  ";
						$setcheck= new CetakFormUjiDinamis();
						$setcheck->selectByParamsPlanRlaDinamis(array(), -1,-1,$statement);
						$setcheck->firstRow();
							
						$reqTabelId= $setcheck->getField("TABEL_TEMPLATE_ID");
						$reqTabelNama= $setcheck->getField("TABEL_NAMA");
						$reqPengukuranId= $setcheck->getField("PENGUKURAN_ID");
						$reqPengukuranNama= $setcheck->getField("PENGUKURAN_NAMA");

						if(!empty($reqTabelId))
						{

							if($tabeli > 1)
							{

								$tambahbaris= 7 + $reqCheckValue;
								$barisjudulatas=$barisjudulatas+$tambahbaris;
								$barispengukuran=$barispengukuran+$tambahbaris;
							}

							
							$set= new CetakFormUjiDinamis();
							$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId."  AND B.FORM_UJI_ID = ".$reqFormUjiId." ";
							$set->selectByParamsMaxBaris(array(), -1, -1, $statement);
				 					// echo $set->query;exit;
							$set->firstRow();
							$maxbarisrla= $set->getField("MAX") + $barisisitabel + $tambahbaris;

							$set= new CetakFormUjiDinamis();
							$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." AND C.FORM_UJI_ID = ".$reqFormUjiId." ";
							$set->selectByParamsDetil(array(), -1, -1, $statement);
									// echo $set->query;

							$tabeltemplate= [];
							while ($set->nextRow())
							{
								$inforowspan= $set->getField("ROWSPAN");
								$infobaris= $set->getField("BARIS") + $barisisitabel + $tambahbaris;
										// var_dump($infobaris);

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
								$arrdata["JUMLAH"]= $set->rowCount;
								$arrdata["NOTE_ATAS"]= $set->getField("NOTE_ATAS");
								$arrdata["NOTE_BAWAH"]= $set->getField("NOTE_BAWAH");
								array_push($tabeltemplate, $arrdata);
							}
									// print_r($maxbarisrla);

							for($index= 1; $index <= $maxbarisrla; $index++)
							{
								$kolomawal= 3;
								$infocarikey= $index;

								$arrcheck= in_array_column($infocarikey, "BARIS", $tabeltemplate);
								foreach ($arrcheck as $vindex)
								{
									$reqRowspan= $tabeltemplate[$vindex]["ROWSPAN"];
									$reqColspan= $tabeltemplate[$vindex]["COLSPAN"];
									$reqBaris= intval($tabeltemplate[$vindex]["BARIS"]);

									$reqNama= $tabeltemplate[$vindex]["NAMA_TEMPLATE"];
									$reqTotal= $tabeltemplate[$vindex]["TOTAL"];
									$reqJumlah= $tabeltemplate[$vindex]["JUMLAH"];
									$reqNoteAtas= $tabeltemplate[$vindex]["NOTE_ATAS"];
									$reqNoteBawah= $tabeltemplate[$vindex]["NOTE_BAWAH"];

									$kolom= toAlpha($kolomawal);

									// kalau ada rowspan
									if(!empty($reqRowspan))
									{
										$mergerow= ($reqBaris + $reqRowspan)-1;

										$objWorksheet->getStyle($kolom.$reqBaris.':'.$kolom.$mergerow)->applyFromArray($style);
										$objWorksheet->getStyle($kolom.$reqBaris.':'.$kolom.$mergerow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

										$objWorksheet->mergeCells($kolom.$reqBaris.':'.$kolom.$mergerow);

										$kolomawal++;
									}
									// kalau ada colspan
									else if(!empty($reqColspan))
									{
										if($index > 1 && $kolomawal == 3)
										{
											$infocarikey= $index ;
											$infocarikey= $infocarikey."ADA";
													// echo $kolomawal."<br/>";
											$kolomawal= $kolomawal + count($arrcheckdetil);
											$kolom= toAlpha($kolomawal);
										}
										$kolomawal= $kolomawal+$reqColspan;

										$mergekolom= toAlpha(($kolomawal)-1);

										$objWorksheet->getStyle($kolom.$reqBaris.':'.$mergekolom.$reqBaris)->applyFromArray($style);
										$objWorksheet->getStyle($kolom.$reqBaris.':'.$mergekolom.$reqBaris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
										$objWorksheet->mergeCells($kolom.$reqBaris.':'.$mergekolom.$reqBaris);
											// print_r($kolom.$reqBaris.':'.$mergekolom.$reqBaris."</br>");
									}
									// kalau normal
									else
									{
										if($index > 1)
										{
											if($kolomawal == 3)
											{
												$batascari= $index;

												while($batascari >= 2)
												{
													$infocarikey= $batascari;

													$infocarikey= $infocarikey."ADA";
													$arrcheckdetil= in_array_column($infocarikey, "BARISROWSPAN", $tabeltemplate);

													if(!empty($arrcheckdetil))
													{
														$kolomawal= count($arrcheckdetil) + $kolomawal;
														$kolom= toAlpha($kolomawal);
													}

													$batascari--;	
												}
											}
										}

										$objWorksheet->getStyle($kolom.$reqBaris)->applyFromArray($style);
										$objWorksheet->getStyle($kolom.$reqBaris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
										$kolomawal++;
									}

										// print_r($kolom.$reqBaris."_".$reqNama."<br/>");
										// $objWorksheet->setCellValue("D".$barispengukuran, $reqPengukuranNama);
									$objWorksheet->setCellValue("D".$barisjudulatas, $reqNoteAtas);

									$objWorksheet->setCellValue($kolom.$reqBaris, $reqNama);

									foreach ($objWorksheet->getColumnIterator() as $column) {

										$objWorksheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
									}

								}
								$tabeli++;
							}

							$isimaster= new FormUji();
							$statement = " AND A.PENGUKURAN_ID =".$reqPengukuranId." AND STATUS_TABLE = 'TABLE' AND A.FORM_UJI_ID = ".$reqFormUjiId."   AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."'  ";
							$isimaster->selectByParamsDetilDinamis(array(), -1, -1, $statement);
			      				// echo $isimaster->query;

							$barismaster  =$reqBaris + 1;
							while($isimaster->nextRow())
							{

								$kolomisi  =3; 
								$reqNamaMaster= $isimaster->getField("NAMA");
								$reqIdDetil= $isimaster->getField("FORM_UJI_DETIL_DINAMIS_ID");

								$setisi= new PlanRlaFormUjiDinamis();

								$statement = " AND A.PLAN_RLA_ID = '".$reqId."' AND A.FORM_UJI_ID = '".$reqFormUjiId."'  AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' AND A.FORM_UJI_DETIL_DINAMIS_ID = '".$reqIdDetil."' AND A.PENGUKURAN_ID =".$reqPengukuranId." ";
								$setisi->selectByParamsDetil(array(), -1, -1, $statement);
									 // echo $setisi->query;

								while ($setisi->nextRow())
								{
									$reqIsi= $setisi->getField("NAMA");
									$reqBarisIsiDetil= $setisi->getField("BARIS");
									$reqBarisIsi = $reqBaris+$reqBarisIsiDetil;
									$reqKolomIsi =  $reqBarisIsiDetil + 2;

									$kolomisitampil= toAlpha($kolomisi);
											// print_r($kolomisij."_".$baristes."_".$reqIsi."</br>");
									$objWorksheet->getStyle($kolomisitampil.$reqBarisIsi)->applyFromArray($style);
									$objWorksheet->getStyle($kolomisitampil.$reqBarisIsi)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
									$objWorksheet->setCellValue($kolomisitampil.$reqBarisIsi, $reqIsi);
									$kolomisi++;
								}
								$barismaster++;	

							}

							$barisbawah= $barismaster+1;
							$objWorksheet->setCellValue("D".$barisbawah, $reqNoteBawah);

						}

						if(!empty($barismaster))
						{

							if($reqNoteBawah)
							{
								$baristext=$barismaster+ 3;
							}
							else
							{
								$baristext=$barismaster+ 2;
							}

						}

					}
					else if($reqStatusTable=="TEXT" )
					{
							
						if($barisbawah)
						{
							$baristexta=$baristextj+1+1+3;
						}
						else
						{
							$baristexta=$baristextj+1+ 2;
						}

						$kolomtextnomorket=3;

						$kolomtextketerangan= toAlpha($kolomtextnomorket);
							$kolomtexttitik= toAlpha($kolomtextnomorket+1);
						$objWorksheet->setCellValue($kolomtextketerangan.$baristexta, $reqValue);
						$objWorksheet->setCellValue($kolomtexttitik.$baristexta, ": ".$reqNamaText);

						$statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='TEXT' ";
						$checkvalue= new CetakFormUjiDinamis();
						$checkvalue->selectByParamsFormUjiDetilDinamis(array(), -1,-1,$statementv);
						// echo  $checkvalue->query;
						// $checkvalue->firstRow();
						while ($checkvalue->nextRow())
						{
							$reqNamaText=  $checkvalue->getField("NAMA");
							$objWorksheet->setCellValue($kolomtexttitik.$baristexta, ": ".strip_tags($reqNamaText));
						
						}
					
						$baristextj++;
					}

				}
			   
			    $sheet++;
			} 
		}


		$objPHPexcel->getSheetByName('Sheet 1')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);

		
		// exit;


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

	
	
}
?>