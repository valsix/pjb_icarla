<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Form_uji_json extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if($this->session->userdata("appuserid") == "")
		{
			redirect('login');
		}
		
		$this->appuserid= $this->session->userdata("appuserid");
		$this->appusernama= $this->session->userdata("appusernama");
		$this->personaluserlogin= $this->session->userdata("personaluserlogin");
		$this->appusergroupid= $this->session->userdata("appusergroupid");

		$this->configtitle= $this->config->config["configtitle"];
		// print_r($this->configtitle);exit;
	}

	function json()
	{
		$this->load->model("base-app/FormUji");

		$set= new FormUji();


		if ( isset( $_REQUEST['columnsDef'] ) && is_array( $_REQUEST['columnsDef'] ) ) {
			$columnsDefault = [];
			foreach ( $_REQUEST['columnsDef'] as $field ) {
				$columnsDefault[ $field ] = "true";
			}
		}
		// print_r($columnsDefault);exit;

		$displaystart= -1;
		$displaylength= -1;

		$arrinfodata= [];

		$reqPencarian= $this->input->get("reqPencarian");
		$searchJson= "";
		if(!empty($reqPencarian))
		{
			$searchJson= " 
			AND 
			(
				UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
				OR UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
			)";
		}

		$sOrder = " ORDER BY FORM_UJI_ID ASC ";
		$set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

		// echo $set->query;exit;
		$infonomor= 0;
		while ($set->nextRow()) 
		{
			$infonomor++;

			$row= [];
			foreach($columnsDefault as $valkey => $valitem) 
			{
				if ($valkey == "SORDERDEFAULT")
				{
					$row[$valkey]= $set->getField("NAMA");
				}
				else if ($valkey == "NO")
				{
					$row[$valkey]= $infonomor;
				}
				else
					$row[$valkey]= $set->getField($valkey);
			}
			array_push($arrinfodata, $row);
		}

		// get all raw data
		$alldata = $arrinfodata;
		// print_r($alldata);exit;

		$data = [];
		// internal use; filter selected columns only from raw data
		foreach ( $alldata as $d ) {
			// $data[] = filterArray( $d, $columnsDefault );
			$data[] = $d;
		}

		// count data
		$totalRecords = $totalDisplay = count( $data );

		// filter by general search keyword
		if ( isset( $_REQUEST['search'] ) ) {
			$data         = filterKeyword( $data, $_REQUEST['search'] );
			$totalDisplay = count( $data );
		}

		if ( isset( $_REQUEST['columns'] ) && is_array( $_REQUEST['columns'] ) ) {
			foreach ( $_REQUEST['columns'] as $column ) {
				if ( isset( $column['search'] ) ) {
					$data         = filterKeyword( $data, $column['search'], $column['data'] );
					$totalDisplay = count( $data );
				}
			}
		}

		// sort
		if ( isset( $_REQUEST['order'][0]['column'] ) && $_REQUEST['order'][0]['dir'] ) {
			$column = $_REQUEST['order'][0]['column'];

				$dir    = $_REQUEST['order'][0]['dir'];
				usort( $data, function ( $a, $b ) use ( $column, $dir ) {
					$a = array_slice( $a, $column, 1 );
					$b = array_slice( $b, $column, 1 );
					$a = array_pop( $a );
					$b = array_pop( $b );

					if ( $dir === 'asc' ) {
						return $a > $b ? true : false;
					}

					return $a < $b ? true : false;
				} );
		}

		// pagination length
		if ( isset( $_REQUEST['length'] ) ) {
			$data = array_splice( $data, $_REQUEST['start'], $_REQUEST['length'] );
		}

		// return array values only without the keys
		if ( isset( $_REQUEST['array_values'] ) && $_REQUEST['array_values'] ) {
			$tmp  = $data;
			$data = [];
			foreach ( $tmp as $d ) {
				$data[] = array_values( $d );
			}
		}

		$result = [
		    'recordsTotal'    => $totalRecords,
		    'recordsFiltered' => $totalDisplay,
		    'data'            => $data,
		];

		header('Content-Type: application/json');
		echo json_encode( $result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function add()
	{
		$this->load->model("base-app/FormUji");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqNama= $this->input->post("reqNama");
		$reqKode= $this->input->post("reqKode");
		$reqStatus= $this->input->post("reqStatus");
		$reqTipeId= $this->input->post("reqTipeId");

		$reqNameplateId= $this->input->post("reqNameplateId");
		$reqNameplateDetilId= $this->input->post("reqNameplateDetilId");
		$reqKolomNameplate= $this->input->post("reqKolomNameplate");
		$reqMaster= $this->input->post("reqMaster");
		$reqNameplate= $this->input->post("reqNameplate");
		$reqNamaTabel= $this->input->post("reqNamaTabel");
		$reqStatusCheck= $this->input->post("reqStatusCheck");

		$reqMeasuringToolsId= $this->input->post("reqMeasuringToolsId");

		$reqNamaKolom= array_filter($this->input->post("reqNamaKolom"));
		$reqStatusTabel= $this->input->post("reqStatusTabel");
		$reqTabelId= $this->input->post("reqTabelId");
		$reqPengukuranId= $this->input->post("reqPengukuranId");
		$reqPengukuranTipeId= $this->input->post("reqPengukuranTipeId");
		$reqTipePengukuranId= $this->input->post("reqTipePengukuranId");
		$reqTipeInputId= $this->input->post("reqTipeInputId");
		$reqFormDetilId= $this->input->post("reqFormDetilId");
		$reqLinkFileKosong= $this->input->post("reqLinkFileKosong");
		$reqLinkFile=$_FILES["reqLinkFile"];
		$reqLinkFileType= $_FILES["reqLinkFile"]["type"];
		$reqLinkFileName= $_FILES["reqLinkFile"]["name"];
		$reqLinkFileTmp = $_FILES["reqLinkFile"]["tmp_name"];

		$reqNameplateGambar= $_FILES["reqNameplateGambar"];
		$reqNameplateGambarType= $_FILES["reqNameplateGambar"]["type"];
		$reqNameplateGambarName= $_FILES["reqNameplateGambar"]["name"];
		$reqNameplateGambarTmp = $_FILES["reqNameplateGambar"]["tmp_name"];

		$reqEquipmentId= $this->input->post("reqEquipmentId");


		// print_r($reqLinkFileKosong);exit;


		$set = new FormUji();
		$set->setField("NAMA", $reqNama);
		$set->setField("KODE", $reqKode);
		$set->setField("STATUS", $reqStatus);
		$set->setField("FORM_UJI_ID", $reqId);
		$set->setField("NAMEPLATE_ID", valToNullDB($reqNameplateId));
		$set->setField("MEASURING_TOOLS_ID", valToNullDB($reqMeasuringToolsId));
	

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->adminusernama);
			$set->setField("LAST_CREATE_DATE", 'SYSDATE');
			if($set->insert())
			{
				$reqSimpan= 1;
				$reqId= $set->id;
			}
		}
		else
		{	
			$set->setField("LAST_UPDATE_USER", $this->adminusernama);
			$set->setField("LAST_UPDATE_DATE", 'SYSDATE');
			if($set->update())
			{
				$reqSimpan= 1;
			}
		}

		if($reqSimpan==1)
		{

			if(!empty($reqNameplateGambarName))
			{
				// print_r($reqNameplateGambarName);
				$check = checkFile($reqNameplateGambarType,1);
				if(!$check)
				{
					$errors = 'xxx***File gagal diupload, Pastikan File Gambar nameplate berformat JPG/JPEG/PNG';
					echo  $errors;exit;
				}

				$FILE_DIR = "uploads/form_uji/".$reqId."/gambar_nameplate/".$reqNameplateId."/";

				if (!is_dir($FILE_DIR)) {
					makedirs($FILE_DIR);
				}

				$lokasiBaru=$FILE_DIR.$reqNameplateGambarName;
				$prosesUpload = move_uploaded_file($reqNameplateGambarTmp, $lokasiBaru);
				if ($prosesUpload) 
				{
	                $set = new FormUji();
	                $set->setField("FORM_UJI_ID", $reqId);
	                $set->setField("NAMEPLATE_ID", $reqNameplateId);
	                $set->setField("LINK_GAMBAR", $lokasiBaru);
	                if($set->updategambarNameplate())
	                {
	                }
				}
			}

			if (empty($reqNameplateId))
			{
				// print_r($reqNameplateId);exit;
				$set = new FormUji();
				$set->setField("FORM_UJI_ID", $reqId);
				$set->deletedetilnameplateall();
			}
			else
			{
				// print_r($reqNameplateDetilId);exit;
				if(!empty($reqKolomNameplate))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("NAMEPLATE_ID", $reqNameplateId);
					$set->deletedetilnameplate();
					foreach ($reqKolomNameplate as $key => $value) {
						$set->setField("NAMEPLATE_DETIL_ID", $reqNameplateDetilId[$key]);
						$set->setField("MASTER_ID", valToNullDB($reqMaster[$key]));
						$set->setField("NAMA", $reqKolomNameplate[$key]);
						$set->setField("NAMA_NAMEPLATE", $reqNameplate[$key]);
						$set->setField("NAMA_TABEL", $reqNamaTabel[$key]);
						$set->setField("STATUS", $reqStatusCheck[$key]);

						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("NAMEPLATE_ID", $reqNameplateId);

						if($set->insertdetilnameplate())
						{
							$reqSimpan= 1;
						}
					}
				}

			}

			if(!empty($reqTipeId))
			{
				$setdelete = new FormUji();
				$reqSimpan="";
				$setdelete->setField("FORM_UJI_ID", $reqId);
				$setdelete->deletepengukurantipe();
				foreach ($reqTipeId as $key => $value) 
				{
					$setpengukuran = new FormUji();
					$setpengukuran->setField("PENGUKURAN_ID", $reqTipeId[$key]);
					$setpengukuran->setField("FORM_UJI_ID", $reqId);

					if($setpengukuran->insertpengukuran())
					{
						$reqSimpan= 1;
					}
				}

			}



			if(!empty($reqTipePengukuranId))
			{
				if(!empty($reqNamaKolom))
				{
					$reqSimpan= "";
					$keyarr=[];
					foreach ($reqNamaKolom as $key => $value) 
					{
						$setdetil = new FormUji();
						$setdetil->setField("NAMA", $value);
						$setdetil->setField("STATUS_TABLE", $reqStatusTabel[$key]);
						$setdetil->setField("PENGUKURAN_ID", $reqPengukuranId[$key]);
						$setdetil->setField("TIPE_INPUT_ID", $reqTipeInputId[$key]);
						$setdetil->setField("TABEL_TEMPLATE_ID", valToNullDB($reqTabelId[$key]));
						$setdetil->setField("PENGUKURAN_TIPE_INPUT_ID", $reqPengukuranTipeId[$key]);
						$setdetil->setField("FORM_UJI_ID", $reqId);
						$setdetil->setField("FORM_UJI_DETIL_DINAMIS_ID", $reqFormDetilId[$key]);

						if (!empty($reqLinkFileKosong[$key]))
						{
							$keyarr[]=$key;
							
						}
					
						if(empty($reqFormDetilId[$key]))
						{
							if($setdetil->insertdetil())
							{
								$reqSimpan= 1;
							}
						}
						else
						{
							if($setdetil->updatedetil())
							{
								$reqSimpan= 1;
							}
						}
						
					}
					foreach ($keyarr as $filekey => $valuekey) {
						// print_r($reqLinkFileName[$filekey]);
						if(!empty($reqLinkFileName[$filekey]))
						{
							$check = checkFile($reqLinkFileType[$filekey],1);
							if(!$check)
							{
								$errors = 'xxx***File gagal diupload, Pastikan File Gambar berformat JPG/JPEG/PNG';
								echo  $errors;exit;
							}

							$FILE_DIR = "uploads/form_uji/".$reqId."/gambar_form_uji/".$reqPengukuranId[$valuekey]."/";

							if (!is_dir($FILE_DIR)) {
								makedirs($FILE_DIR);
							}

							$lokasiBaru=$FILE_DIR.$reqLinkFileName[$filekey];
							$prosesUpload = move_uploaded_file($reqLinkFileTmp[$filekey], $lokasiBaru);
							if ($prosesUpload) 
							{
								$setfile = new FormUji();
								$setfile->setField("LINK_FILE", $lokasiBaru);
								$setfile->setField("FORM_UJI_DETIL_DINAMIS_ID", $reqFormDetilId[$valuekey]);
								if($setfile->updatefiledetil())
								{
									$reqSimpan= 1;
								}
							}
						}
					}

				}
			}

			if(!empty($reqEquipmentId))
			{
				$setdelete = new FormUji();
				$reqSimpan="";
				$setdelete->setField("FORM_UJI_ID", $reqId);
				$setdelete->deleteequipment();
				foreach ($reqEquipmentId as $key => $value) 
				{
					$seteq = new FormUji();
					$seteq->setField("KELOMPOK_EQUIPMENT_ID", $reqEquipmentId[$key]);
					$seteq->setField("FORM_UJI_ID", $reqId);

					if($seteq->insertequipment())
					{
						$reqSimpan= 1;
					}
				}

			}
			
		}

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
				
	}

	function delete()
	{
		$this->load->model("base-app/FormUji");
		$set = new FormUji();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("FORM_UJI_ID", $reqId);

		if($set->delete())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deletepengukuran()
	{
		$this->load->model("base-app/FormUji");
		$set = new FormUji();

		$reqId =  $this->input->get('reqId');
		$reqPengukuranId =  $this->input->get('reqPengukuranId');
		$reqSimpan="";
		$set->setField("PENGUKURAN_ID", $reqPengukuranId);
		$set->setField("FORM_UJI_ID", $reqId);
		if($set->deletepengukuran())
		{
			$reqSimpan=1;
		}


		if($reqSimpan==1)
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function deletedetail()
	{
		$this->load->model("base-app/FormUji");
		$set = new FormUji();

		$reqId =  $this->input->get('reqId');
		$reqFormDetilId =  $this->input->get('reqFormDetilId');
		$reqPengukuranId =  $this->input->get('reqPengukuranId');
		$reqStatus =  $this->input->get('reqStatus');
		$reqSimpan="";
		$set->setField("FORM_UJI_DETIL_DINAMIS_ID", $reqFormDetilId);
		$set->setField("FORM_UJI_ID", $reqId);
		$set->setField("PENGUKURAN_ID", $reqPengukuranId);
		$set->setField("STATUS_TABLE", $reqStatus);
		if($set->deletedetil())
		{
			$reqSimpan=1;
		}


		if($reqSimpan==1)
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function deletegambar()
	{
		$this->load->model("base-app/FormUji");
		$check = new FormUji();
		$set = new FormUji();
		$reqId  = $this->input->get('reqId');
		$reqDetilId  = $this->input->get('reqDetilId');
		$reqTipeId  = $this->input->get('reqTipeId');

		$set->selectByParamsGambar(array("A.FORM_UJI_ID" => $reqId,"A.FORM_UJI_GAMBAR_ID" => $reqDetilId,"A.FORM_UJI_TIPE_ID" => $reqTipeId), -1, -1);
		$set->firstRow();
		$reqUrl= $set->getField("LINK_GAMBAR");
		if($reqUrl)
		{
			unlink($reqUrl);
		}
		
		$set->setField("FORM_UJI_ID", $reqId);
		$set->setField("FORM_UJI_GAMBAR_ID", $reqDetilId);
		$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);

		if($set->deletegambar())
		{
			$reqSimpan=1;
		}

		$reqSimpan=1;

		if($reqSimpan==1)
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

	}


}