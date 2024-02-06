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
		$reqKelompokEquipmentGetId= $this->input->get("reqKelompokEquipmentId");
		$reqKelompokEquipmentParentId = $this->input->get("reqKelompokEquipmentParentId");

		$reqCheck = $this->input->get("reqCheck");
		$reqIdParent = $this->input->get("reqIdParent");
		$reqIdParent = substr($reqIdParent, 0, 3); 
		$reqCheck = $this->input->get("reqCheck");



		$this->load->model('base-app/FormUji');
		$this->load->model('base-app/PlanRla');
		$this->load->model('base-app/FormUji');
		$this->load->model('base-app/TabelTemplate');
		$this->load->model('base-app/Pengukuran');
		$this->load->model('base-app/KelompokEquipment');
		$this->load->model('base-app/CetakFormUjiDinamis');
		$this->load->model('base-app/PlanRlaFormUjiDinamis');
		$this->load->model('base-app/Nameplate');

		 // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
		$objPHPexcel = PHPExcel_IOFactory::load('template/form_uji/cetak/template_dinamis.xlsx');
		$sheetIndex= 0;

		$style = StyleExcel(1,"","","");
		$stylewarna = StyleExcel(3,"B8CCE4","","");

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
		// $statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND D.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' ";
		if($reqCheck==1)
		{
			$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND D.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentGetId."'  ";
		}
		else
		{

			$statement = " AND D.PLAN_RLA_ID = '".$reqId."'  AND LEFT(E.ID,3)  LIKE '%".$reqIdParent."%'  ";

		}

		$set->selectByParamsFormUjiReport(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
			$arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
			$arrdata["NAMA"]= $set->getField("NAMA");
			$arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
			$arrdata["JUMLAH"]= $set->rowCount;
			$arrdata["NAMEPLATE_ID"]= $set->getField("NAMEPLATE_ID");
			$arrdata["PARENT_ID"]= $set->getField("PARENT_ID");
			$arrdata["ID"]= $set->getField("ID");
			array_push($arrformuji, $arrdata);
		}
		unset($set);
		// print_r($arrformuji);exit;

		$set= new CetakFormUjiDinamis();
		$arrnameplate= [];
		// $statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND D.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."'  ";
		if($reqCheck==1)
		{
			$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND F.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentGetId."'  ";
		}
		else
		{

			$statement = " AND D.PLAN_RLA_ID = '".$reqId."'  AND LEFT(F.ID,3)  LIKE '%".$reqIdParent."%'  ";
		}

		$set->selectByParamsFormUjiReportNameplateNew(array(), -1,-1,$statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
			$arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
			$arrdata["NAMA"]= $set->getField("NAMA");
			$arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
			$arrdata["JUMLAH"]= $set->rowCount;
			$arrdata["NAMEPLATE_ID"]= $set->getField("NAMEPLATE_ID");
			$arrdata["NAMA_NAMEPLATE"]= $set->getField("NAMA_NAMEPLATE");
			$arrdata["PARENT_ID"]= $set->getField("PARENT_ID");
			$arrdata["ID"]= $set->getField("ID");
			$arrdata["MASTER_ID"]= $set->getField("MASTER_ID");
			array_push($arrnameplate, $arrdata);
		}
		unset($set);
		// print_r($arrnameplate);exit;

		$sheet = 2;
		if(!empty($arrnameplate))
		{
			foreach ($arrnameplate as $key => $value) 
			{
				$reqFormUjiId=$value["FORM_UJI_ID"]; 
				$reqKelompokEquipmentId=$value["KELOMPOK_EQUIPMENT_ID"]; 
				$reqKelompokEquipmentParentId= $vnameplate["KELOMPOK_EQUIPMENT_PARENT_ID"];
				$reqNamaKelompok=$value["NAMA_KELOMPOK"]; 
				$reqNamaFormUji= $value["NAMA"];
				$arrjudul = explode(' ',trim($reqNamaFormUji));
				$judulsheet= $arrjudul[0];
				$jumlahdata=  $value["JUMLAH"];
				$reqNameplateId= $value["NAMEPLATE_ID"];
				$reqNamaNameplate= $value["NAMA_NAMEPLATE"];
				$reqIdParent= $value["PARENT_ID"];
				$reqKelompokEquipment= $value["NAMA_KELOMPOK"];
				$arrjudulkelompok = explode(' ',trim($reqNamaKelompok));
				$arrjudulnameplate = explode(' ',trim($reqNamaNameplate));
				$judulnameplate= $arrjudulnameplate[0];
				$judulkelompok= $arrjudulkelompok[0];

				// print_r($reqKelompokEquipment_$reqNamaNameplate);exit;

				$barisawal=8;

				if($reqIdParent==0)
				{
					$reqIdParent= $vnameplate["ID"];
				}

				$kolomawal= 3;
				$kolomnameplate= toAlpha($kolomawal);

				$barisjudul=$barisawal-1;
				
				$objWorksheet = clone $objPHPexcel->setActiveSheetIndex(0);
				$objWorksheet->setTitle("$judulkelompok"."_$judulnameplate");
				$objPHPexcel->addSheet($objWorksheet);
				$objWorksheet =  $objPHPexcel->setActiveSheetIndex($sheet);


			    $objDrawing = new PHPExcel_Worksheet_Drawing();
			    $objDrawing->setPath('images/logo-pjb.png');

			    $objDrawing->setCoordinates('A1');
			    $objDrawing->setResizeProportional(false);
			    $objDrawing->setWidth(120);
			    $objDrawing->setHeight(50);
			    $objDrawing->setOffsetX(2);    
			    $objDrawing->setOffsetY(2); 

			    $objDrawing->setWorksheet($objWorksheet);

				$objWorksheet->getStyle("F3")->getFont()->setBold( true );
				$objWorksheet->getStyle("F4")->getFont()->setBold( true );
				$objWorksheet->setCellValue($kolomnameplate.$barisjudul,"Nameplate ".$reqNamaNameplate);
				$objWorksheet->setCellValue("F3","LAPORAN ASSESSMENT ".strtoupper($reqNamaNameplate));
				$objWorksheet->setCellValue("F4",strtoupper($reqUnit));
				
				$set= new CetakFormUjiDinamis();
				$arrformnameplate= [];

				$statement = " AND A.NAMEPLATE_ID=".$reqNameplateId." ";
				$set->selectByParamsNameplate(array(), -1, -1, $statement);
   				// echo $set->query;
				while($set->nextRow())
				{
					$arrdata= array();
					$arrdata["id"]= $set->getField("NAMEPLATE_ID");
					$arrdata["NAMEPLATE_DETIL_ID"]= $set->getField("NAMEPLATE_DETIL_ID");
					$arrdata["MASTER_ID"]= $set->getField("MASTER_ID");
					$arrdata["NAMA"]= $set->getField("NAMA");
					$arrdata["NAMA_NAMEPLATE"]= $set->getField("NAMA_NAMEPLATE");
					$arrdata["NAMA_TABEL"]= $set->getField("NAMA_TABEL");
					$arrdata["STATUS"]= $set->getField("STATUS");
					$arrdata["ISI"]= $set->getField("ISI");

					if(!empty($arrdata["id"]))
					{
						array_push($arrformnameplate, $arrdata);
					}
				}

				if(!empty($arrformnameplate))
				{
					foreach ($arrformnameplate as $vnameplate)
					{
						$reqFormUjiNameplateId= $vnameplate["FORM_UJI_NAMEPLATE_ID"];
						$reqNameplateDetilId= $vnameplate["NAMEPLATE_DETIL_ID"];
						$reqMasterId= $vnameplate["MASTER_ID"];
						$reqNameplateNama= $vnameplate["NAMA"];
						$reqNamaNameplate= $vnameplate["NAMA_NAMEPLATE"];
						$reqNamaTabel= $vnameplate["NAMA_TABEL"];
						$reqStatusTable= $vnameplate["STATUS"];
						$reqIsiNameplate= $vnameplate["ISI"];


						if(!empty($reqNamaTabel) && $reqStatusTable==1)
						{
							$statement= "AND ".$reqNamaTabel."_ID = ".$reqIsiNameplate;
							$setmaster= new Nameplate();
							$setmaster->selectByParamsCheckTabel(array(), -1, -1, $statement,$sOrder,$reqNamaTabel);
                            // echo $setmaster->query;                               
							$setmaster->firstRow();
							$reqIsiNameplate=$setmaster->getField("NAMA");

						}
						
						$kolomnnamenameplate= toAlpha(4);
						$kolomnnamatitik= toAlpha(5);
						$kolomnnama= toAlpha(6);

						$objWorksheet->setCellValue($kolomnameplate.$barisawal, "-");

						$objWorksheet->setCellValue($kolomnnamenameplate.$barisawal, $reqNameplateNama);

						$objWorksheet->setCellValue($kolomnnamatitik.$barisawal," : ");

						$objWorksheet->setCellValue($kolomnnama.$barisawal, $reqIsiNameplate);
						// print_r($barisawal."</br>");

						$barisawal++;
					}
				}
				$barisbreak=$barisawal+1;
				$objWorksheet->getPageSetup()->setPrintArea("A1".':'."AF".$barisbreak);

				$objWorksheet->
				getSheetView()->
				setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_BREAK_PREVIEW);

				$sheet++;
			}

		}
		$sheetuji=$sheet;

		// exit;
		// print_r($arrformuji);exit;

		if(!empty($arrformuji))
		{
			foreach ($arrformuji as $key => $value) 
			{
				$reqFormUjiId=$value["FORM_UJI_ID"]; 
				$reqKelompokEquipmentId=$value["KELOMPOK_EQUIPMENT_ID"]; 
				$reqNamaKelompok=$value["NAMA_KELOMPOK"]; 
				$reqNamaFormUji= $value["NAMA"];
				$arrjudul = explode(' ',trim($reqNamaFormUji));
				$judulsheet= $arrjudul[0];
				$jumlahdata=  $value["JUMLAH"];
				$reqNameplateId= $value["NAMEPLATE_ID"];
				$arrjudulkelompok = explode(' ',trim($reqNamaKelompok));
				$judulkelompok= $arrjudulkelompok[0];
				
			    // clone header dari template yg dihidden
				$objWorksheet = clone $objPHPexcel->setActiveSheetIndex(1);
				$objWorksheet->setTitle("$judulkelompok"."_$judulsheet");
			    $objPHPexcel->addSheet($objWorksheet);
			
			    $objWorksheet = $objPHPexcel->setActiveSheetIndex($sheetuji);
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
			    $objWorksheet->setCellValue("H6",$reqTahun);
			    $objWorksheet->setCellValue("C6",$reqUnit);
			    $objWorksheet->setCellValue("M1",": ".$reqKodeMaster);
			    $objWorksheet->setCellValue("M2",": ".$tanggalsekarang);
			    $objWorksheet->setCellValue("M3",": 1");
			    $objWorksheet->setCellValue("M4",": 1");

			    // isi

				$barisawal=8;

				$arrbarisrla= [];

				$barisrla= new CetakFormUjiDinamis();
				$statement = "   AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.PLAN_RLA_ID = ".$reqId." ";
				$barisrla->selectByParamsMaxBarisPlanRla(array(), -1, -1, $statement);
				// echo $barisrla->query;exit;
				$iarr=0;
				while ($barisrla->nextRow())
				{
					$arrdata= [];
					$arrdata["BARIS_RLA"]= $barisrla->getField("MAX");
					array_push($arrbarisrla, $arrdata);
				}
				// print_r($arrbarisrla);exit;

				$reqCheckValue=0;
				$statementv = "  AND F.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND F.FORM_UJI_ID= ".$reqFormUjiId."  AND F.PLAN_RLA_ID = '".$reqId."' AND D.VALUE <> '' AND A.STATUS_TABLE ='TEXT' ";
				$checkvalue= new CetakFormUjiDinamis();
				$checkvalue->selectByParamsPengukuranTipeInputBaruText(array(), -1,-1,$statementv);
				// echo $checkvalue->query;exit;
				$checkvalue->firstRow();
				$reqCheckValue= $checkvalue->rowCount;
				$reqNamaText= $checkvalue->getField("NAMA");

				// print_r($reqNamaText);
				$arrisirla= [];
				$statement = " AND F.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND F.FORM_UJI_ID= ".$reqFormUjiId."  AND F.PLAN_RLA_ID = '".$reqId."'";


				$setlist= new CetakFormUjiDinamis();
				$setlist->selectByParamsPengukuranTipeInputBaru(array(), -1,-1,$statement);
				// echo $setlist->query;exit;
				$tabeli=1;

				while($setlist->nextRow())
				{
					$vpengukuranid= $setlist->getField("PENGUKURAN_ID");
					$vstatustable= $setlist->getField("STATUS_TABLE");
					$vtabeltemplateid= $setlist->getField("TABEL_TEMPLATE_ID");
					$vkeystatus= $vpengukuranid."-".$vstatustable."-".$vtabeltemplateid;
					$vseq= $setlist->getField("SEQ");

					// masih mengkondisikan grouping
					$vseqgroup= "";
					$vseqgroupurut= "";
					if( strpos($vseq, ".") !== false )
					{
						//FIX kalau seq 10.XX
						$hitungvseq=strtok($vseq, '.');
						$totalseq = strlen($hitungvseq) + 1;
						//end
						$vseqgroup= substr($vseq, $totalseq, 1);
						$vseqgroupurut= substr($vseq, $totalseq) % $vseqgroup;

					}

					$arrdata= [];
					$arrdata["TABEL_TEMPLATE_ID"]= $vtabeltemplateid;
					$arrdata["STATUS_TABLE"]= $vstatustable;
					$arrdata["VALUE"]= $setlist->getField("VALUE");
					$arrdata["PENGUKURAN_ID"]= $vpengukuranid;
					$arrdata["PENGUKURAN_TIPE_INPUT_ID"]= $setlist->getField("PENGUKURAN_TIPE_INPUT_ID");
					$arrdata["SEQ"]= $vseq;
					$arrdata["SEQ_GROUP"]= $vseqgroup;
					$arrdata["SEQ_GROUP_URUT"]= $vseqgroupurut;
					$arrdata["SEQCHECK"]=$setlist->getField("SEQ").$setlist->getField("STATUS_TABLE");
					$arrdata["KEY_STATUS"]= $vkeystatus;
					array_push($arrisirla, $arrdata);
				}
				// print_r($arrisirla);exit;

				$arrbarisgroup= [];
				$barisglobal= 8; $indexgroup= 1;
				$zzz=0;
				$indextext= 0;
				foreach ($arrisirla as $keyisi => $isiv) {
					$reqMasterTabelId= $isiv["TABEL_TEMPLATE_ID"]; 
					$reqStatusTable= $isiv["STATUS_TABLE"]; 
					$reqValue= $isiv["VALUE"]; 
					$reqTipePengukuranId= $isiv["PENGUKURAN_ID"]; 

					$reqPengukuranTipeInputId= $isiv["PENGUKURAN_TIPE_INPUT_ID"];
					$reqSeq = $isiv["SEQ"];
					$vseqgroup= $isiv["SEQ_GROUP"];
					$vseqgroupurut= $isiv["SEQ_GROUP_URUT"];
					$infocaristatus= $isiv["SEQCHECK"];

					// kunci untuk baris grouping
					$keybarisgroup= $reqFormUjiId."-".$reqStatusTable."-".$reqMasterTabelId."-".$reqTipePengukuranId."-".$reqSeq;
					// echo $keybarisgroup."<br/>";


					if($reqStatusTable == "TABLE")
					{
						if($barisglobal > 8)
							$barisglobal++;

						if(!empty($vseqgroup))
						{
							// kalau awal simpan baris
							if($vseqgroupurut == "1")
							{
								$vkolom= 3;
								$tempbaris= $barisglobal;
								$indexgroup= 1;
							}
							else
							{
								$vkolom++;
							}
							$arrbarisgroup[$keybarisgroup."-BARIS"]= $tempbaris;
							$arrbarisgroup[$keybarisgroup."-KOLOM"]= $vkolom;
							// echo "<br/>kolom:".toAlpha($vkolom).$tempbaris."<br/>";
							// echo $vseqgroupurut."xx".$indexgroup."-".$vseqgroup."-".$tempbaris."<br/>";

							if($indexgroup == $vseqgroup && !empty($tempbaris))
							{
								$barisglobal= $tempbaris;
								$indexgroup= 1;
							}

						}
						else
						{
							$vkolom= 3;
						}

						// print_r($vkolom);
						$indexgroup++;
						// echo "<br/>";

						$statement = " AND A.PENGUKURAN_ID = ".$reqTipePengukuranId." AND A.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.PLAN_RLA_ID = '".$reqId."' AND A.TABEL_TEMPLATE_ID= ".$reqMasterTabelId." AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId;
						// echo $statement."<br/>";
						$setcheck= new CetakFormUjiDinamis();
						$setcheck->selectByParamsPlanRlaDinamis(array(), -1,-1,$statement);
						$setcheck->firstRow();
						// echo $setcheck->query;exit;
							
						$reqTabelId= $setcheck->getField("TABEL_TEMPLATE_ID");
						$reqTabelNama= $setcheck->getField("TABEL_NAMA");
						$reqPengukuranId= $setcheck->getField("PENGUKURAN_ID");
						$reqPengukuranNama= $setcheck->getField("PENGUKURAN_NAMA");

						if(!empty($reqTabelId))
						{
							$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." ";
							$set= new TabelTemplate();
							$set->selectByParamsMaxBaris(array(), -1, -1, $statement);
					 		// echo $set->query;exit;
							$set->firstRow();
							$maxbarisrla= $set->getField("MAX");
							// echo "max:".$maxbarisrla."<br/>";
							// exit;

							$tabeltemplate= [];
							$set= new CetakFormUjiDinamis();
							$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." AND C.FORM_UJI_ID = ".$reqFormUjiId." AND C.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId." ";
							$set->selectByParamsDetil(array(), -1, -1, $statement);
							// echo $set->query;
							while ($set->nextRow())
							{
								$inforowspan= $set->getField("ROWSPAN");
								$infobaris= $set->getField("BARIS");
								// print_r($infobaris."_".$reqFormUjiId."</br>");

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
							// print_r($tabeltemplate);exit;
							
							$loopbaris= $arrbarisgroup[$keybarisgroup."-BARIS"];
							if(!empty($loopbaris))
								$barisglobal= $loopbaris;

							// untuk membuat header excel
							for($index= 1; $index <= $maxbarisrla; $index++)
							{
								// kalau table ganti baris
								$barisglobal++;

								// if(!empty($vseqgroup)){}
								// else
								// 	$vkolom= 3;

								if(!empty($vseqgroup))
								{
									// fix bug sementara  kalau group ada rowspan 
									if($index > 1)
									{
										if($vseqgroupurut=="1")
										{
											$vkolom = 3;
										}
										else
										{
											$vkolom =  $loopbaris  + 1;
										}
									}	
								}
								else
								{
									$vkolom= 3;
								}

								$infocarikey= $index;
								$arrcheck= in_array_column($infocarikey, "BARIS", $tabeltemplate);
								// print_r($index);
								foreach ($arrcheck as $vindex)
								{
									$reqRowspan= $tabeltemplate[$vindex]["ROWSPAN"];
									$reqColspan= $tabeltemplate[$vindex]["COLSPAN"];
									$reqNama= $tabeltemplate[$vindex]["NAMA_TEMPLATE"];
									$reqJumlah= $tabeltemplate[$vindex]["JUMLAH"];
									$reqNoteAtas= $tabeltemplate[$vindex]["NOTE_ATAS"];
									$reqNoteBawah= $tabeltemplate[$vindex]["NOTE_BAWAH"];

									$setkolom= toAlpha($vkolom);

									// kalau ada rowspan
									if(!empty($reqRowspan))
									{
										$mergerow= ($barisglobal + $reqRowspan)-1;

										$objWorksheet->getStyle($setkolom.$barisglobal.':'.$setkolom.$mergerow)->applyFromArray($stylewarna);
										$objWorksheet->getStyle($setkolom.$barisglobal.':'.$setkolom.$mergerow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

										$objWorksheet->mergeCells($setkolom.$barisglobal.':'.$setkolom.$mergerow);

										$vkolom++;

									}
									// kalau ada colspan
									else if(!empty($reqColspan))
									{
										if($index > 1 && $vkolom == 3)
										{
											$infocarikey= $index - 1;
											$infocarikey= $infocarikey."ADA";
											$arrcheckdetil= in_array_column($infocarikey, "BARISROWSPAN", $tabeltemplate);
											// echo $vkolom."<br/>";
											$vkolom= $vkolom + count($arrcheckdetil);
											$setkolom= toAlpha($vkolom);
										}
										$vkolom= $vkolom+$reqColspan;
										// echo "$vkolom:".$vkolom."<br>";
										$mergekolom= toAlpha(($vkolom)-1);

										$objWorksheet->getStyle($setkolom.$barisglobal.':'.$mergekolom.$barisglobal)->applyFromArray($stylewarna);
										$objWorksheet->getStyle($setkolom.$barisglobal.':'.$mergekolom.$barisglobal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
										$objWorksheet->mergeCells($setkolom.$barisglobal.':'.$mergekolom.$barisglobal);
									}
									// kalau normal
									else
									{
										if($index > 1)
										{
											if($vkolom == 3)
											{
												$batascari= $index-1;
												while($batascari >= 1)
												{
													$infocarikey= $batascari;

													$infocarikey= $infocarikey."ADA";
													$arrcheckdetil= in_array_column($infocarikey, "BARISROWSPAN", $tabeltemplate);

													if(!empty($arrcheckdetil))
													{
														$vkolom= count($arrcheckdetil) + $vkolom;

														$setkolom= toAlpha($vkolom);
													}

													$batascari--;	
												}
											}
										}

										$objWorksheet->getStyle($setkolom.$barisglobal)->applyFromArray($stylewarna);
										$objWorksheet->getStyle($setkolom.$barisglobal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
										$vkolom++;
									}

									if($vindex == 0)
									{
										$setkolomjudul= $barisglobal - 1;
										$setkolomjudul= "D".$setkolomjudul;
										$objWorksheet->setCellValue($setkolomjudul, $reqNoteAtas);
									}

									$objWorksheet->setCellValue($setkolom.$barisglobal, $reqNama);
									// echo $vseqgroup.";".$vseqgroupurut.";";
									// echo $setkolom.$barisglobal."-".$reqNama."<br/>";

									$valuep = $objWorksheet->getCell($setkolom.$barisglobal)->getValue();
									$width = mb_strwidth ($valuep); //Return the width of the string
									$objWorksheet->getColumnDimension($setkolom)->setWidth($width * 2);
								}

							}

							// apabila ada grouping
							$vbarisgroup= $arrbarisgroup[$keybarisgroup."-BARIS"];
							// echo $vbarisgroup."<br/><br/>";
							if(!empty($vbarisgroup))
							{
								$barisglobal= $vbarisgroup + $maxbarisrla;
								if($vbarisgroup > 8)
								{
									$barisglobal+=2;
								}
								else
								{
									$barisglobal++;
								}
							}
							else
							{
								// echo "b<br/>";
								$barisglobal++;
							}
							// echo "xxbaris:".$zzz."<br/><br/>";

							// untuk membuat data excel
							$isimaster= new FormUji();
							$statement = " AND A.PENGUKURAN_ID = ".$reqPengukuranId." AND STATUS_TABLE = 'TABLE' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' AND B.SEQ = ".$reqSeq." AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId;
							$isimaster->selectformujipengukuran(array(), -1, -1, $statement);
							// echo $isimaster->query."<br/>";
							// exit;
							// tutup dulu
						   while($isimaster->nextRow())
							{
								// apabila ada grouping
								if(!empty($vbarisgroup))
								{
									$kolomisi= $arrbarisgroup[$keybarisgroup."-KOLOM"];
								}
								else
								{
									$kolomisi= 3;
								}

								$reqNamaMaster= $isimaster->getField("NAMA");
								$reqIdDetil= $isimaster->getField("FORM_UJI_DETIL_DINAMIS_ID");

								$setisi= new PlanRlaFormUjiDinamis();
								$statement = " AND A.PLAN_RLA_ID = '".$reqId."' AND A.FORM_UJI_ID = '".$reqFormUjiId."'  AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' AND A.FORM_UJI_DETIL_DINAMIS_ID = '".$reqIdDetil."' AND A.PENGUKURAN_ID = ".$reqPengukuranId." AND A.PENGUKURAN_TIPE_INPUT_ID = ".$reqPengukuranTipeInputId;
								$setisi->selectByParamsDetil(array(), -1, -1, $statement);
								// echo "<br/>".$setisi->query."<br/>";
								// exit;
								while($setisi->nextRow())
								{
									$reqIsi= $setisi->getField("NAMA");
									$kolomisitampil= toAlpha($kolomisi);
									// print_r($kolomisij."_".$baristes."_".$reqIsi."</br>");

									$objWorksheet->getStyle($kolomisitampil.$barisglobal)->applyFromArray($style);
									$objWorksheet->getStyle($kolomisitampil.$barisglobal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
									$objWorksheet->setCellValue($kolomisitampil.$barisglobal, $reqIsi);

									echo $kolomisitampil.$barisglobal."-".$reqIsi."<br/>";
									
									$kolomisi++;
								}
								// echo "<br/>";

								// kalau table ganti baris
								// echo $barisglobal."<br/><br/>";
								$barisglobal++;
							}

							$objWorksheet->setCellValue("D".$barisglobal, $reqNoteBawah);
						
							// exit;

							
						}
					}
					else if($reqStatusTable=="TEXT" )
					{
						if($barisglobal > 8)
							$barisglobal++;

						$baristexta= $barisglobal;
						$indextext++;
						$kolomtextnomorket=3;

						// buat nama label
						$kolomtextketerangan= toAlpha($kolomtextnomorket);
							$kolomtexttitik= toAlpha($kolomtextnomorket+1);
						$objWorksheet->setCellValue($kolomtextketerangan.$baristexta, $reqValue);

					
						$objWorksheet->getStyle($kolomtextketerangan.$baristexta)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						$objWorksheet->setCellValue($kolomtexttitik.$baristexta, ": ".$reqNamaText);

						$statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='TEXT' ";
						$checkvalue= new CetakFormUjiDinamis();
						$checkvalue->selectByParamsFormUjiDetilDinamis(array(), -1,-1,$statementv);
						// echo $checkvalue->query;
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

							$barisglobal++;
						}
					}
					else if($reqStatusTable=="PIC" )
					{
						$statementv = " AND A.PLAN_RLA_ID = ".$reqId." AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId." AND A.STATUS_TABLE ='PIC' ";
						$checkvalue= new CetakFormUjiDinamis();
						$checkvalue->selectplanrlaujidinamis(array(), -1,-1,$statementv);
						// echo $checkvalue->query."<br/>";
						// exit;
						$tambahbarispic= 12;
						$indexloop= 0;
						while ($checkvalue->nextRow())
						{
							$reqNamaGambar= $checkvalue->getField("NAMA");
							$reqLinkGambar= $checkvalue->getField("LINK_FILE");
							if(file_exists($reqLinkGambar))
							{
								if(!empty($vseqgroup))
								{
									if($vseqgroup == $indexloop)
									{
										$indexloop= 0;
										$vkolom=3;
										// echo $vseqgroup."xxx".$indexloop;
										$barisglobal= $barisglobal + $tambahbarispic;
									}
									else
									{
										if($indexloop == 0)
										{
											$vkolom=3;
											if($barisglobal <= 8)
											{
												$barisglobal= $barisglobal + $tambahbarispic;
											}
											else
											{
												$barisglobal= $barisglobal + 2;
											}
											// echo $vseqgroup."www".$indexloop;
										}
										else
										{
											$vkolom=6;
											// echo $vseqgroup."uuu".$indexloop;
										}
									}
								}
								else
								{
									if($indexloop == 0)
									{
										$vkolom=3;
										// echo $vseqgroup."zzz".$indexloop;
									}
									else
									{
										$vkolom=6;
										// echo $vseqgroup."yyy".$indexloop;
									}
								}
								$vkolom= toAlpha($vkolom);
								$indexloop++;

								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setPath($reqLinkGambar);

								// echo $vkolom.$barisglobal."<br>";
								$infovkolom= $vkolom.$barisglobal;

								$objDrawing->setCoordinates($infovkolom);
								$objDrawing->setResizeProportional(false);
								$objDrawing->setWidth(350);
								$objDrawing->setHeight(180);
								$objDrawing->setOffsetX(2);    
								$objDrawing->setOffsetY(2);
								// $barisglobal++;
								$objDrawing->setWorksheet($objWorksheet);

								// echo $vkolom.$barisglobal.";".$reqNamaGambar."<br/>";
								$objWorksheet->setCellValue($vkolom.$barisglobal, $reqNamaGambar);
							}
						}

						$vtempbaris= $barisglobal;
						if($indexloop > 0)
						{
							$barisglobal= $barisglobal + $tambahbarispic;
						}

						if($vtempbaris <= 8)
						{
							$barisglobal= $barisglobal - ($tambahbarispic / 2) + 2;
						}
					}
					else if($reqStatusTable=="BINARY" )
					{
						if($barisglobal > 8)
							$barisglobal++;

						if(!empty($vseqgroup))
						{
							// kalau awal simpan baris
							if($vseqgroupurut == "1")
							{
								$vkolom= 3;
								$tempbaris= $barisglobal;
								$indexgroup= 1;
							}
							else
							{
								$vkolom+= 4;
							}
							// echo "<br/>kolom:".toAlpha($vkolom).$tempbaris."<br/>";
							// echo $vseqgroupurut."xx".$indexgroup."-".$vseqgroup."-".$tempbaris."<br/>";

							if($indexgroup == $vseqgroup && !empty($tempbaris))
							{
								$barisglobal= $tempbaris;
								$indexgroup= 1;
							}

						}
						else
						{
							$vkolom= 3;
						}

						$indexgroup++;

						$vkolomisi= $vkolom + 1;
						$kolomjudul= toAlpha($vkolom);

						$objWorksheet->setCellValue($kolomjudul.$barisglobal, $reqValue);
						$objWorksheet->getStyle($kolomjudul.$barisglobal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

						$kolomisi= toAlpha($vkolomisi);
						$statementv = " AND A.PLAN_RLA_ID = ".$reqId." AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId." AND A.STATUS_TABLE ='BINARY' ";
						$checkvalue= new CetakFormUjiDinamis();
						$checkvalue->selectplanrlaujidinamis(array(), -1,-1,$statementv);
						// echo $checkvalue->query;exit;
						while($checkvalue->nextRow())
						{
							$reqNamaText=  $checkvalue->getField("NAMA");
							$renderhtml = new PHPExcel_Helper_HTML;
							$richText = $renderhtml->toRichTextObject($reqNamaText);

							$objWorksheet->getStyle($kolomisi.$barisglobal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

							$objWorksheet->setCellValue($kolomisi.$barisglobal, ": ". $richText);
							// echo $kolomisi.$barisglobal;exit;
							$barisglobal++;
						}
					}
					else if($reqStatusTable=="ANALOG" )
					{
						if($barisglobal > 8)
							$barisglobal++;

						if(!empty($vseqgroup))
						{
							// kalau awal simpan baris
							if($vseqgroupurut == "1")
							{
								$vkolom= 3;
								$tempbaris= $barisglobal;
								$indexgroup= 1;
							}
							else
							{
								$vkolom+= 4;
							}
							// echo "<br/>kolom:".toAlpha($vkolom).$tempbaris."<br/>";
							// echo $vseqgroupurut."xx".$indexgroup."-".$vseqgroup."-".$tempbaris."<br/>";

							if($indexgroup == $vseqgroup && !empty($tempbaris))
							{
								$barisglobal= $tempbaris;
								$indexgroup= 1;
							}
						}
						else
						{
							$vkolom= 3;
						}
						$indexgroup++;

						$vkolomisi= $vkolom + 1;
						$kolomjudul= toAlpha($vkolom);

						// echo $kolomjudul.$barisglobal.":".$reqValue."<br/>";
						$objWorksheet->setCellValue($kolomjudul.$barisglobal, $reqValue);
						$objWorksheet->getStyle($kolomjudul.$barisglobal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

						$kolomisi= toAlpha($vkolomisi);
						$statementv = " AND A.PLAN_RLA_ID = ".$reqId." AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId." AND A.STATUS_TABLE ='ANALOG' ";
						$checkvalue= new CetakFormUjiDinamis();
						$checkvalue->selectplanrlaujidinamis(array(), -1,-1,$statementv);
						// echo $checkvalue->query;exit;
						while($checkvalue->nextRow())
						{
							$reqNamaText=  $checkvalue->getField("NAMA");
							$renderhtml = new PHPExcel_Helper_HTML;
							$richText = $renderhtml->toRichTextObject($reqNamaText);

							// echo $kolomisi.$barisglobal.":".$reqNamaText."<br/>";
							$objWorksheet->getStyle($kolomisi.$barisglobal)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$objWorksheet->setCellValue($kolomisi.$barisglobal, ": ". $richText);
							$barisglobal++;
						}
					}
				}
				// exit;

				$barisglobal++;

				//footer
				$barisfooter= $barisglobal;
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
				$kolomaccakhir="Q";
				$objWorksheet->getStyle($kolomaccawal.$barisfooter.':'.$kolomaccakhir.$barisfooterlanjut)->applyFromArray($styledinamis);
				$objWorksheet->getStyle($kolomaccawal.$barisfooter.':'.$kolomaccakhir.$barisfooterlanjut)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

				$objWorksheet->mergeCells($kolomaccawal.$barisfooter.':'.$kolomaccakhir.$barisfooterlanjut);
				$objWorksheet->setCellValue($kolomaccawal.$barisfooter, "ACCEPTED/REWORK/REPLACE/REPAIR/MONITORING 
					(by Quality Control)");
				$objWorksheet->getStyle($kolomaccawal.$barisfooter)->getAlignment()->setWrapText(true);

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
				$kolomtestedakhir="D";
				$objWorksheet->getStyle($kolomtestedawal.$barisdesc.':'.$kolomtestedakhir.$barisdesc)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomtestedawal.$barisdesc.':'.$kolomtestedakhir.$barisdesc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomtestedawal.$barisdesc.':'.$kolomtestedakhir.$barisdesc);
				$objWorksheet->setCellValue($kolomtestedawal.$barisdesc, "Tested/measured by");

				$objWorksheet->getStyle($kolomtestedawal.$barisname.':'.$kolomtestedakhir.$barisname)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomtestedawal.$barisname.':'.$kolomtestedakhir.$barisname)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomtestedawal.$barisname.':'.$kolomtestedakhir.$barisname);
				$objWorksheet->setCellValue($kolomtestedawal.$barisname, "Eka Putra Widyananda");

				$kolomkordinatorawal="E";
				$kolomkordinatorakhir="F";
				$objWorksheet->getStyle($kolomkordinatorawal.$barisdesc.':'.$kolomkordinatorakhir.$barisdesc)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomkordinatorawal.$barisdesc.':'.$kolomkordinatorakhir.$barisdesc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomkordinatorawal.$barisdesc.':'.$kolomkordinatorakhir.$barisdesc);
				$objWorksheet->setCellValue($kolomkordinatorawal.$barisdesc, "Coordinator");

				$objWorksheet->getStyle($kolomkordinatorawal.$barisname.':'.$kolomkordinatorakhir.$barisname)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomkordinatorawal.$barisname.':'.$kolomkordinatorakhir.$barisname)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomkordinatorawal.$barisname.':'.$kolomkordinatorakhir.$barisname);
				$objWorksheet->setCellValue($kolomkordinatorawal.$barisname, "Triyadi N. S.");

				$kolomqualityawal="G";
				$kolomqualityakhir="K";
				$objWorksheet->getStyle($kolomqualityawal.$barisdesc.':'.$kolomqualityakhir.$barisdesc)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomqualityawal.$barisdesc.':'.$kolomqualityakhir.$barisdesc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomqualityawal.$barisdesc.':'.$kolomqualityakhir.$barisdesc);
				$objWorksheet->setCellValue($kolomqualityawal.$barisdesc, "Quality Control");

				$objWorksheet->getStyle($kolomqualityawal.$barisname.':'.$kolomqualityakhir.$barisname)->applyFromArray($styledescdinamis);
				$objWorksheet->getStyle($kolomqualityawal.$barisname.':'.$kolomqualityakhir.$barisname)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
				$objWorksheet->mergeCells($kolomqualityawal.$barisname.':'.$kolomqualityakhir.$barisname);
				$objWorksheet->setCellValue($kolomqualityawal.$barisname, "Ramot Mangihut H.");

				$kolomwitnessawal="L";
				$kolomwitnessakhir="Q";
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

				$objWorksheet->getPageSetup()->setPrintArea("A1".':'."Q".$barisdate);
				$objWorksheet->setBreak('A'. $barisdate , PHPExcel_Worksheet::BREAK_ROW );

				$objPHPexcel->
				getActiveSheet()->
				getSheetView()->
				setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_BREAK_PREVIEW);

			   
			    $sheetuji++;
			} 

		}
		$sheetcatatan=$sheetuji;

		// exit;


		$set= new CetakFormUjiDinamis();
		
		$statement = " AND A.PLAN_RLA_ID = '".$reqId."' AND A.STATUS_CATATAN = '1'  ";

		$set->selectByParamsPlanRla(array(), -1,-1,$statement);
		// echo $set->query;exit;
		$set->firstRow();
		$reqStatusCatatan= $set->getField("STATUS_CATATAN");
		unset($set);
		// print_r($reqStatusCatatan);exit;

		if(!empty($reqStatusCatatan))
		{
			$objWorksheet = $objPHPexcel->createSheet($sheetcatatan);
			$objWorksheet->setTitle("Catatan");

			$objWorksheet =  $objPHPexcel->setActiveSheetIndex($sheetcatatan); 

			$objWorksheet->setCellValue("A1","Nama/Nid");
			$objWorksheet->setCellValue("B1","Tanggal");
			$objWorksheet->setCellValue("C1","Catatan");

			$arrcatatan= [];
			$set= new CetakFormUjiDinamis();
			$arrcatatan= [];
			$statement = " AND A.PLAN_RLA_ID = '".$reqId."' AND A.STATUS_CATATAN = '1'  ";

			$set->selectByParamsPlanRlaCatatan(array(), -1,-1,$statement);
			// echo $set->query;exit;
			while($set->nextRow())
			{
				$arrdata= array();
				$arrdata["NAMA_CATATAN"]= $set->getField("NAMA_CATATAN");
				$arrdata["TANGGAL_CATATAN"]= $set->getField("TANGGAL_CATATAN");
				$arrdata["CATATAN"]= $set->getField("CATATAN");
				array_push($arrcatatan, $arrdata);
			}
			unset($set);

			$no=1;
			$kolomnama=0;
			$kolomtanggal=1;
			$kolomcatatan=2;
			$barisawal=2;

			$kolomnama= toAlpha($kolomnama);
			$kolomtanggal= toAlpha($kolomtanggal);
			$kolomcatatan= toAlpha($kolomcatatan);

			foreach ($arrcatatan as $key => $vcatatan) {

				$reqNamaCatatan=$vcatatan["NAMA_CATATAN"]; 
				$reqTanggalCatatan=$vcatatan["TANGGAL_CATATAN"]; 
				$reqCatatan=$vcatatan["CATATAN"];
				
				$objWorksheet->setCellValue($kolomnama.$barisawal,$reqNamaCatatan);

				$objWorksheet->setCellValue($kolomtanggal.$barisawal, $reqTanggalCatatan);
				$objWorksheet->setCellValue($kolomcatatan.$barisawal, $reqCatatan);

				$objWorksheet->getStyle($kolomnama."1".':'.$kolomcatatan.$barisawal)->applyFromArray($style);

				$valuep =  $objWorksheet->getCell($kolomnama.$barisawal)->getValue();
				$width = mb_strwidth ($valuep); 
				$objWorksheet->getColumnDimension($kolomnama)->setWidth($width * 2);

				$valuep =  $objWorksheet->getCell($kolomtanggal.$barisawal)->getValue();
				$width = mb_strwidth ($valuep); 
				$objWorksheet->getColumnDimension($kolomtanggal)->setWidth($width * 2);

				$valuep =  $objWorksheet->getCell($kolomcatatan.$barisawal)->getValue();
				$width = mb_strwidth ($valuep); 
				$objWorksheet->getColumnDimension($kolomcatatan)->setWidth($width * 2);

				$no++;
				$barisawal++;
			}
		}
		// exit;


		$objPHPexcel->setActiveSheetIndexByName('Nameplate');
		$sheetIndex= $objPHPexcel->getActiveSheetIndex();
		$objPHPexcel->removeSheetByIndex($sheetIndex);

		$objPHPexcel->setActiveSheetIndexByName('Sheet 1');
		$sheetIndex= $objPHPexcel->getActiveSheetIndex();
		$objPHPexcel->removeSheetByIndex($sheetIndex);

		$set= new KelompokEquipment();
		$statement = " AND A.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentGetId." ";
		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query; exit;
		$set->firstRow();
		$reqNamaKolom= $set->getField("NAMA");
		unset($set);

		$set= new CetakFormUjiDinamis();

		$statement = " AND A.PLAN_RLA_ID = '".$reqId."' ";
		$set->selectByParams(array(), -1, -1, $statement);
		$set->firstRow();
		$reqKodeMaster = $set->getField("KODE_MASTER_PLAN");

		
		$filename=$reqTahun.'_'.$reqKodeMaster.'_Asessment_'.$reqNamaKolom.'.xlsx';

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