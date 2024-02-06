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
		$stylewarna = StyleExcel(3,"B8CCE4");

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
			    // clone header dari template yg dihidden
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

			    // isi

				$barisawal=8;
				$tambahbaris=0;
				$baristext=$barisawal;
				$reqBaris=$barisawal;
				$barispengukuran= $barisawal;
				$barisjudulatas=$barisawal;
				$barisfooter=$barisawal;

				$barisisitabel=$barisawal;

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

				$barisgambar=$barisisitabel+$arrbarisrla[0]["BARIS_RLA"];
				$barisbinary=$barisisitabel+$arrbarisrla[0]["BARIS_RLA"];
				$barisanalog=$barisisitabel+$arrbarisrla[0]["BARIS_RLA"];
				$barisfooter=$barisisitabel+$arrbarisrla[0]["BARIS_RLA"];
				// print_r($barisgambar);

				$reqCheckValue=0;
				$statementv = "  AND F.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND F.FORM_UJI_ID= ".$reqFormUjiId."  AND F.PLAN_RLA_ID = '".$reqId."' AND D.VALUE <> '' AND A.STATUS_TABLE ='TEXT' ";
				$checkvalue= new CetakFormUjiDinamis();
				$checkvalue->selectByParamsPengukuranTipeInputBaruText(array(), -1,-1,$statementv);
				// echo  $checkvalue->query;
				$checkvalue->firstRow();
				$reqCheckValue=  $checkvalue->rowCount;
				$reqNamaText=  $checkvalue->getField("NAMA");

				// print_r($reqNamaText);

				$statement = "  AND F.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND F.FORM_UJI_ID= ".$reqFormUjiId."  AND F.PLAN_RLA_ID = '".$reqId."' ";
				$setlist= new CetakFormUjiDinamis();
				$setlist->selectByParamsPengukuranTipeInputBaru(array(), -1,-1,$statement);
				// echo  $setlist->query;
				$tabeli=1;
				while($setlist->nextRow())
				{

					$reqMasterTabelId= $setlist->getField("TABEL_TEMPLATE_ID");
					$reqStatusTable= $setlist->getField("STATUS_TABLE");
					$reqValue= $setlist->getField("VALUE");
					$reqTipePengukuranId= $setlist->getField("PENGUKURAN_ID");

					$reqPengukuranTipeInputId= $setlist->getField("PENGUKURAN_TIPE_INPUT_ID");

					// print_r($reqPengukuranTipeInputId);


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

							// print_r($tabeli);
							if($tabeli > 1)
							{
								if( $reqCheckValue)
								{
									$tambahbaris= 7 + $reqCheckValue;
								}
								else
								{
									$tambahbaris= 7;
								}
								
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

									// foreach ($objWorksheet->getColumnIterator() as $column) {

									// 	$objWorksheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
									// }
									// $objWorksheet->calculateColumnWidths();

									// foreach ($objWorksheet->getColumnIterator() as $column) {

									// 	$objWorksheet->getColumnDimension($column->getColumnIndex())->setAutoSize(false);
									// }


								


									// kalau ada rowspan
									if(!empty($reqRowspan))
									{
										$mergerow= ($reqBaris + $reqRowspan)-1;

										$objWorksheet->getStyle($kolom.$reqBaris.':'.$kolom.$mergerow)->applyFromArray($stylewarna);
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

										$objWorksheet->getStyle($kolom.$reqBaris.':'.$mergekolom.$reqBaris)->applyFromArray($stylewarna);
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

										$objWorksheet->getStyle($kolom.$reqBaris)->applyFromArray($stylewarna);
										$objWorksheet->getStyle($kolom.$reqBaris)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
										$kolomawal++;
									}

										// print_r($kolom.$reqBaris."_".$reqNama."<br/>");
										// $objWorksheet->setCellValue("D".$barispengukuran, $reqPengukuranNama);
									$objWorksheet->setCellValue("D".$barisjudulatas, $reqNoteAtas);

									$objWorksheet->setCellValue($kolom.$reqBaris, $reqNama);

									// $objPHPexcel->getActiveSheet()->getColumnDimension($kolom)->setAutoSize(false);

									$valuep =  $objWorksheet->getCell($kolom.$reqBaris)->getValue();
									$width = mb_strwidth ($valuep); //Return the width of the string
									$objWorksheet->getColumnDimension($kolom)->setWidth($width * 2);


								}

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
								$barismastercheck=0;
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
									$barismastercheck=$reqFormUjiId;
									$kolomisi++;
								}
								$barismaster++;	

							}

							$barisbawah= $barismaster+1;
							$objWorksheet->setCellValue("D".$barisbawah, $reqNoteBawah);
							
							$arrjumlah[]=$tabeli;

							$tabeli++;


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
							$baristexta=$baristextj+5;
						}
						else
						{
							$baristexta=$baristextj+3;
						}


						$kolomtextnomorket=3;

						$kolomtextketerangan= toAlpha($kolomtextnomorket);
							$kolomtexttitik= toAlpha($kolomtextnomorket+1);
						$objWorksheet->setCellValue($kolomtextketerangan.$baristexta, $reqValue);
						$objWorksheet->getStyle($kolomtextketerangan.$baristexta)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

						$objWorksheet->setCellValue($kolomtexttitik.$baristexta, ": ".$reqNamaText);

						$statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='TEXT' ";
						$checkvalue= new CetakFormUjiDinamis();
						$checkvalue->selectByParamsFormUjiDetilDinamis(array(), -1,-1,$statementv);
						// echo  $checkvalue->query;
						// $checkvalue->firstRow();
						$baristextcheck=0;
						while ($checkvalue->nextRow())
						{
							$reqNamaText=  $checkvalue->getField("NAMA");
							$renderhtml = new PHPExcel_Helper_HTML;
							$richText = $renderhtml->toRichTextObject($reqNamaText);


							$objPHPexcel->getActiveSheet()->getStyle($kolomtexttitik.'1:'.$kolomtexttitik.$baristexta)
							->getAlignment()->setWrapText(true); 

							$objWorksheet->setCellValue($kolomtexttitik.$baristexta, ": ". $richText);
							$baristextcheck=$reqFormUjiId;
						
						}
						// print_r($arrcoba);
					
						$baristextj++;
					}
					else if($reqStatusTable=="PIC" )
					{
						$kolomgambar=3;
						$kolomgambar= toAlpha($kolomgambar);
						// if($baristexta)
						// {
						// 	$barisgambar=$baristexta+2;
						// }
						// else
						// {
						// 	if($barismaster)
						// 	{
						// 		$barisgambar=$barismaster+2;
						// 	}
						// 	else
						// 	{
						// 		$barisgambar=$barisawal;
						// 	}
							
						// }


						if($barismastercheck==$reqFormUjiId)
						{
							$barisgambar=$barismaster+5;
						}
						if($baristextcheck==$reqFormUjiId)
						{
							$barisgambar=$baristexta+5;
						}

				


						// print_r($reqFormUjiId);
						foreach ($arrjumlah as $key => $jumlahtabel) {
							if($jumlahtabel > 1)
							{
							  $barisgambar=$barismaster+1;
							}
						}

						// print_r($barisgambar."</br>");

						$statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='PIC' ";
						$checkvalue= new CetakFormUjiDinamis();
						$checkvalue->selectByParamsFormUjiDetilDinamis(array(), -1,-1,$statementv);
						// echo  $checkvalue->query;
						// $checkvalue->firstRow();
						$barisgambarcheck=0;
						while ($checkvalue->nextRow())
						{
							$reqNamaGambar=  $checkvalue->getField("NAMA");
							$reqLinkGambar=  $checkvalue->getField("LINK_FILE");
							$objDrawing = new PHPExcel_Worksheet_Drawing();

							$objDrawing->setPath($reqLinkGambar);

							$objDrawing->setCoordinates($kolomgambar.$barisgambar);
							$objDrawing->setResizeProportional(false);
							$objDrawing->setWidth(350);
							$objDrawing->setHeight(200);
							$objDrawing->setOffsetX(2);    
							$objDrawing->setOffsetY(2); 

							$objDrawing->setWorksheet($objWorksheet);
							$barisgambarket=$barisgambar+11;
							// print_r($barisgambarket);
							$objWorksheet->setCellValue($kolomgambar.$barisgambarket, $reqNamaGambar);
							$barisgambarcheck=$reqFormUjiId;

							// print_r($reqLinkGambar);
						}


						$barisgambar++;


					}
					else if($reqStatusTable=="BINARY" )
					{
							
						// if($baristexta)
						// {
						// 	$barisbinary=$baristexta+5;
						// }
						// else
						// {
						// 	$barisbinary=$barisbinary+3;
						// }
						// if($barisgambarket)
						// {
						// 	$barisbinary=$barisgambarket+2;
						// }
						// else
						// {
						// 	$barisbinary=$barisbinary+3;
						// }

						if($barismastercheck==$reqFormUjiId)
						{
							$barisbinary=$barismaster+5;
						}
						if($baristextcheck==$reqFormUjiId)
						{
							$barisbinary=$baristexta+5;
						}

						if($barisgambarcheck==$reqFormUjiId)
						{
							$barisbinary=$barisgambarket+2;
						}


						
						// print_r($barisgambarket);


						$kolombinarynomorket=3;

						$kolombinaryketerangan= toAlpha($kolombinarynomorket);
							$kolombinarytitik= toAlpha($kolombinarynomorket+1);
						$objWorksheet->setCellValue($kolombinaryketerangan.$barisbinary, $reqValue);
						$objWorksheet->getStyle($kolombinaryketerangan.$barisbinary)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

						$objWorksheet->setCellValue($kolombinarytitik.$barisbinary, ": ".$reqNamaText);

						$statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='BINARY' ";
						$checkvalue= new CetakFormUjiDinamis();
						$checkvalue->selectByParamsFormUjiDetilDinamis(array(), -1,-1,$statementv);
						// echo  $checkvalue->query;
						// $checkvalue->firstRow();
						$binarycheck=0;
						while ($checkvalue->nextRow())
						{
							$reqNamaText=  $checkvalue->getField("NAMA");
							$renderhtml = new PHPExcel_Helper_HTML;
							$richText = $renderhtml->toRichTextObject($reqNamaText);

							$objPHPexcel->getActiveSheet()->getStyle($kolombinarytitik.'1:'.$kolombinarytitik.$barisbinary)
							->getAlignment()->setWrapText(true); 

							$objWorksheet->setCellValue($kolombinarytitik.$barisbinary, ": ". $richText);
							$binarycheck=$reqFormUjiId;
						
						}
						// print_r($kolombinarytitik.$barisbinary);
					
						$barisbinary++;
					}
					else if($reqStatusTable=="ANALOG" )
					{
						// if($barismaster)
						// {
						// 	$barisanalog=$barismaster+5;
						// }
						// else
						// {
						// 	$barisanalog=$barisanalog+3;
						// }
							
						// if($baristexta)
						// {
						// 	$barisanalog=$baristexta+5;
						// }
						// else
						// {
						// 	$barisanalog=$barisanalog+3;
						// }
						// if($barisgambarket)
						// {
						// 	$barisanalog=$barisgambarket+2;
						// }
						// else
						// {
						// 	$barisanalog=$barisanalog+3;
						// }
						// if($barisbinary)
						// {
						// 	$barisanalog=$barisbinary+1;
						// }
						// else
						// {
						// 	$barisanalog=$barisanalog+3;

						// }

						if($barismastercheck==$reqFormUjiId)
						{
							$barisanalog=$barismaster+5;
						}
						if($baristextcheck==$reqFormUjiId)
						{
							$barisanalog=$baristexta+5;
						}

						if($barisgambarcheck==$reqFormUjiId)
						{
							$barisanalog=$barisgambarket+2;
						}

						if($binarycheck==$reqFormUjiId)
						{
							$barisanalog=$barisbinary;
						}


						$kolomanalognomorket=3;

						$kolomanalogketerangan= toAlpha($kolomanalognomorket);
							$kolomanalogtitik= toAlpha($kolomanalognomorket+1);
						$objWorksheet->setCellValue($kolomanalogketerangan.$barisanalog, $reqValue);
						$objWorksheet->getStyle($kolomanalogketerangan.$barisanalog)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

						$objWorksheet->setCellValue($kolomanalogtitik.$barisanalog, ": ".$reqNamaText);

						$statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='ANALOG' ";
						$checkvalue= new CetakFormUjiDinamis();
						$checkvalue->selectByParamsFormUjiDetilDinamis(array(), -1,-1,$statementv);
						// echo  $checkvalue->query;
						// $checkvalue->firstRow();
						$barisanalogcheck=0;
						while ($checkvalue->nextRow())
						{
							$reqNamaText=  $checkvalue->getField("NAMA");
							$renderhtml = new PHPExcel_Helper_HTML;
							$richText = $renderhtml->toRichTextObject($reqNamaText);

							$objPHPexcel->getActiveSheet()->getStyle($kolomanalogtitik.'1:'.$kolomanalogtitik.$barisanalog)
							->getAlignment()->setWrapText(true); 

							$objWorksheet->setCellValue($kolomanalogtitik.$barisanalog, ": ". $richText);
							$barisanalogcheck=$reqFormUjiId;
						
						}
						// print_r($kolomanalogtitik.$barisanalog);
					
						$barisanalog++;
					}

				}

				//footer
			
				if($barismastercheck==$reqFormUjiId)
				{
					$barisfooter=$barismaster+5;
				}
				if($baristextcheck==$reqFormUjiId)
				{
					$barisfooter=$baristexta+5;
				}
				
				if($barisgambarcheck==$reqFormUjiId)
				{
					$barisfooter=$barisgambarket+2;
				}
				
				if($binarycheck==$reqFormUjiId)
				{
					$barisfooter=$barisbinary+1;
				}
				
				if($barisanalogcheck==$reqFormUjiId)
				{
					$barisfooter=$barisanalog+1;
				}


				$kolomfooterawal="A";
				$kolomfooterakhir="C";
				$styledinamis = StyleExcel(4,"","left","horizontal");
				$barisfooterlanjut=$barisfooter+1;
				$objWorksheet->getStyle($kolomfooterawal.$barisfooter.':'.$kolomfooterakhir.$barisfooterlanjut)->applyFromArray($styledinamis);
				$objWorksheet->getStyle($kolomfooterawal.$barisfooter.':'.$kolomfooterakhir.$barisfooterlanjut)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomfooterawal.$barisfooter.':'.$kolomfooterakhir.$barisfooterlanjut);
				$objWorksheet->setCellValue($kolomfooterawal.$barisfooter, "RECOMMENDATION");
				$valuep =  $objWorksheet->getCell($kolomfooterawal.$barisfooter)->getValue();
				$width = mb_strwidth ($valuep); //Return the width of the string
				$objWorksheet->getColumnDimension($kolomfooterawal)->setWidth($width);

				$kolomaccawal="D";
				$kolomaccakhir="AF";

				$objWorksheet->getStyle($kolomaccawal.$barisfooter.':'.$kolomaccakhir.$barisfooterlanjut)->applyFromArray($styledinamis);
				$objWorksheet->getStyle($kolomaccawal.$barisfooter.':'.$kolomaccakhir.$barisfooterlanjut)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

				$objWorksheet->mergeCells($kolomaccawal.$barisfooter.':'.$kolomaccakhir.$barisfooterlanjut);
				$objWorksheet->setCellValue($kolomaccawal.$barisfooter, "ACCEPTED/REWORK/REPLACE/REPAIR/MONITORING 
					(by Quality Control)");
				$objWorksheet->getStyle($kolomaccawal.$barisfooter)->getAlignment()->setWrapText(true);

				// $valuep =  $objWorksheet->getCell($kolomaccawal.$barisfooter)->getValue();
				// $width = mb_strwidth ($valuep); //Return the width of the string
				// $objWorksheet->getColumnDimension($kolomaccawal)->setWidth($width);

				$barismeasuringtool=$barisfooterlanjut+1;
				$barismeasuringtoollanjut=$barismeasuringtool+1;

				$objWorksheet->getStyle($kolomfooterawal.$barismeasuringtool.':'.$kolomfooterakhir.$barismeasuringtoollanjut)->applyFromArray($styledinamis);
				$objWorksheet->getStyle($kolomfooterawal.$barismeasuringtool.':'.$kolomfooterakhir.$barismeasuringtoollanjut)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomfooterawal.$barismeasuringtool.':'.$kolomfooterakhir.$barismeasuringtoollanjut);
				$objWorksheet->setCellValue($kolomfooterawal.$barismeasuringtool, "Measuring Tool:");

				$objWorksheet->getStyle($kolomaccawal.$barismeasuringtool.':'.$kolomaccakhir.$barismeasuringtoollanjut)->applyFromArray($styledinamis);
				$objWorksheet->getStyle($kolomaccawal.$barismeasuringtool.':'.$kolomaccakhir.$barismeasuringtoollanjut)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

				$objWorksheet->mergeCells($kolomaccawal.$barismeasuringtool.':'.$kolomaccakhir.$barismeasuringtoollanjut);
				$objWorksheet->setCellValue($kolomaccawal.$barismeasuringtool, "Insulation Tester MEGER MIT 525");
				$objWorksheet->getStyle($kolomaccawal.$barismeasuringtool)->getAlignment()->setWrapText(true);

				$styledescdinamis = StyleExcel(4,"","center","horizontal");

				$kolomdescawal="A";
				$kolomdescakhir="B";

				$barisdesc=$barismeasuringtool+2;

				$objWorksheet->getStyle($kolomdescawal.$barisdesc.':'.$kolomdescakhir.$barisdesc)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomdescawal.$barisdesc.':'.$kolomdescakhir.$barisdesc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomdescawal.$barisdesc.':'.$kolomdescakhir.$barisdesc);
				$objWorksheet->setCellValue($kolomdescawal.$barisdesc, "Description");

				$kolomdescawal="A";
				$kolomdescakhir="B";

				$barisname=$barisdesc+1;


				$objWorksheet->getStyle($kolomdescawal.$barisname.':'.$kolomdescakhir.$barisname)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomdescawal.$barisname.':'.$kolomdescakhir.$barisname)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomdescawal.$barisname.':'.$kolomdescakhir.$barisname);
				$objWorksheet->setCellValue($kolomdescawal.$barisname, "Name");

				$kolomtestedawal="C";
				$kolomtestedakhir="I";

				$objWorksheet->getStyle($kolomtestedawal.$barisdesc.':'.$kolomtestedakhir.$barisdesc)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomtestedawal.$barisdesc.':'.$kolomtestedakhir.$barisdesc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomtestedawal.$barisdesc.':'.$kolomtestedakhir.$barisdesc);
				$objWorksheet->setCellValue($kolomtestedawal.$barisdesc, "Tested/measured by");

				$objWorksheet->getStyle($kolomtestedawal.$barisname.':'.$kolomtestedakhir.$barisname)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomtestedawal.$barisname.':'.$kolomtestedakhir.$barisname)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomtestedawal.$barisname.':'.$kolomtestedakhir.$barisname);
				$objWorksheet->setCellValue($kolomtestedawal.$barisname, "Eka Putra Widyananda");

				$kolomkordinatorawal="J";
				$kolomkordinatorakhir="Q";

				$objWorksheet->getStyle($kolomkordinatorawal.$barisdesc.':'.$kolomkordinatorakhir.$barisdesc)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomkordinatorawal.$barisdesc.':'.$kolomkordinatorakhir.$barisdesc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomkordinatorawal.$barisdesc.':'.$kolomkordinatorakhir.$barisdesc);
				$objWorksheet->setCellValue($kolomkordinatorawal.$barisdesc, "Coordinator");


				$objWorksheet->getStyle($kolomkordinatorawal.$barisname.':'.$kolomkordinatorakhir.$barisname)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomkordinatorawal.$barisname.':'.$kolomkordinatorakhir.$barisname)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomkordinatorawal.$barisname.':'.$kolomkordinatorakhir.$barisname);
				$objWorksheet->setCellValue($kolomkordinatorawal.$barisname, "Triyadi N. S.");


				$kolomqualityawal="R";
				$kolomqualityakhir="Y";

				$objWorksheet->getStyle($kolomqualityawal.$barisdesc.':'.$kolomqualityakhir.$barisdesc)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomqualityawal.$barisdesc.':'.$kolomqualityakhir.$barisdesc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomqualityawal.$barisdesc.':'.$kolomqualityakhir.$barisdesc);
				$objWorksheet->setCellValue($kolomqualityawal.$barisdesc, "Quality Control");

				$objWorksheet->getStyle($kolomqualityawal.$barisname.':'.$kolomqualityakhir.$barisname)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomqualityawal.$barisname.':'.$kolomqualityakhir.$barisname)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomqualityawal.$barisname.':'.$kolomqualityakhir.$barisname);
				$objWorksheet->setCellValue($kolomqualityawal.$barisname, "Ramot Mangihut H.");

				$kolomwitnessawal="Z";
				$kolomwitnessakhir="AF";

				$objWorksheet->getStyle($kolomwitnessawal.$barisdesc.':'.$kolomwitnessakhir.$barisdesc)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomwitnessawal.$barisdesc.':'.$kolomwitnessakhir.$barisdesc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomwitnessawal.$barisdesc.':'.$kolomwitnessakhir.$barisdesc);
				$objWorksheet->setCellValue($kolomwitnessawal.$barisdesc, "Witness");

				$objWorksheet->getStyle($kolomwitnessawal.$barisname.':'.$kolomwitnessakhir.$barisname)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomwitnessawal.$barisname.':'.$kolomwitnessakhir.$barisname)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomwitnessawal.$barisname.':'.$kolomwitnessakhir.$barisname);
				$objWorksheet->setCellValue($kolomwitnessawal.$barisname, "Gregorius Sutrisno");

				$barissignature=$barisname+1;
				$barissignatureakhir=$barisname+3;

				$objWorksheet->getStyle($kolomdescawal.$barissignature.':'.$kolomdescakhir.$barissignatureakhir)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomdescawal.$barissignature.':'.$kolomdescakhir.$barissignatureakhir)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objWorksheet->mergeCells($kolomdescawal.$barissignature.':'.$kolomdescakhir.$barissignatureakhir);
				$objWorksheet->setCellValue($kolomdescawal.$barissignature, "Signature");

				$objWorksheet->getStyle($kolomtestedawal.$barissignature.':'.$kolomtestedakhir.$barissignatureakhir)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomtestedawal.$barissignature.':'.$kolomtestedakhir.$barissignatureakhir)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objWorksheet->mergeCells($kolomtestedawal.$barissignature.':'.$kolomtestedakhir.$barissignatureakhir);
				$objWorksheet->setCellValue($kolomtestedawal.$barissignature, "");

				$objWorksheet->getStyle($kolomkordinatorawal.$barissignature.':'.$kolomkordinatorakhir.$barissignatureakhir)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomkordinatorawal.$barissignature.':'.$kolomkordinatorakhir.$barissignatureakhir)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objWorksheet->mergeCells($kolomkordinatorawal.$barissignature.':'.$kolomkordinatorakhir.$barissignatureakhir);
				$objWorksheet->setCellValue($kolomkordinatorawal.$barissignature, "");

				$objWorksheet->getStyle($kolomqualityawal.$barissignature.':'.$kolomqualityakhir.$barissignatureakhir)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomqualityawal.$barissignature.':'.$kolomqualityakhir.$barissignatureakhir)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objWorksheet->mergeCells($kolomqualityawal.$barissignature.':'.$kolomqualityakhir.$barissignatureakhir);
				$objWorksheet->setCellValue($kolomqualityawal.$barissignature, "");

				$objWorksheet->getStyle($kolomwitnessawal.$barissignature.':'.$kolomwitnessakhir.$barissignatureakhir)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomwitnessawal.$barissignature.':'.$kolomwitnessakhir.$barissignatureakhir)->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$objWorksheet->mergeCells($kolomwitnessawal.$barissignature.':'.$kolomwitnessakhir.$barissignatureakhir);
				$objWorksheet->setCellValue($kolomwitnessawal.$barissignature, "");


				$barisdate=$barissignature + 3;
				$objWorksheet->getStyle($kolomdescawal.$barisdate.':'.$kolomdescakhir.$barisdate)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomdescawal.$barisdate.':'.$kolomdescakhir.$barisdate)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomdescawal.$barisdate.':'.$kolomdescakhir.$barisdate);
				$objWorksheet->setCellValue($kolomdescawal.$barisdate, "Date");

				// print_r($barisdate."</br>");

	
				$objWorksheet->getStyle($kolomtestedawal.$barisdate.':'.$kolomtestedakhir.$barisdate)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomtestedawal.$barisdate.':'.$kolomtestedakhir.$barisdate)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomtestedawal.$barisdate.':'.$kolomtestedakhir.$barisdate);
				$objWorksheet->setCellValue($kolomtestedawal.$barisdate, $tanggalsekarang);


				$objWorksheet->getStyle($kolomkordinatorawal.$barisdate.':'.$kolomkordinatorakhir.$barisdate)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomkordinatorawal.$barisdate.':'.$kolomkordinatorakhir.$barisdate)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomkordinatorawal.$barisdate.':'.$kolomkordinatorakhir.$barisdate);
				$objWorksheet->setCellValue($kolomkordinatorawal.$barisdate, $tanggalsekarang);


				$objWorksheet->getStyle($kolomqualityawal.$barisdate.':'.$kolomqualityakhir.$barisdate)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomqualityawal.$barisdate.':'.$kolomqualityakhir.$barisdate)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomqualityawal.$barisdate.':'.$kolomqualityakhir.$barisdate);
				$objWorksheet->setCellValue($kolomqualityawal.$barisdate, $tanggalsekarang);

				$objWorksheet->getStyle($kolomwitnessawal.$barisdate.':'.$kolomwitnessakhir.$barisdate)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomwitnessawal.$barisdate.':'.$kolomwitnessakhir.$barisdate)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomwitnessawal.$barisdate.':'.$kolomwitnessakhir.$barisdate);
				$objWorksheet->setCellValue($kolomwitnessawal.$barisdate, $tanggalsekarang);

				// print_r($kolomfooterawal.$barisdesc.':'.$kolomfooterakhir.$barisdesc."</br>");
			   
			    $sheet++;
			} 
		}


		$objPHPexcel->getSheetByName('Sheet 1')->setSheetState(PHPExcel_Worksheet::SHEETSTATE_HIDDEN);


		$set= new KelompokEquipment();
		$statement = " AND A.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." ";
		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query; exit;
		$set->firstRow();
		$reqNamaKolom= $set->getField("NAMA");
		unset($set);

		
		// exit;
		$filename=$reqTahun.'_Asessment_'.$reqNamaKolom.'.xlsx';

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel2007');
		$objWriter->save('template/download/'.$filename);

		$down = 'template/download/'.$filename;
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