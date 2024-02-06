<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Pengukuran_json extends CI_Controller
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
		$this->load->model("base-app/Pengukuran");

		$set= new Pengukuran();

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
		// if(!empty($reqPencarian))
		// {
		// 	$searchJson= " 
		// 	AND 
		// 	(
		// 		UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
		// 		OR UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
		// 	)";
		// }

		$sOrder = " ORDER BY PENGUKURAN_ID ASC";
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
		$this->load->model("base-app/Pengukuran");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqNama= $this->input->post("reqNama");
		$reqNamaPengukuran= $this->input->post("reqNamaPengukuran");
		$reqKode= $this->input->post("reqKode");
		$reqJenisPengukuran= $this->input->post("reqJenisPengukuran");
		
		$reqEnjiniringId= $this->input->post("reqEnjiniringId");
		// print_r($reqEnjiniringId);exit;
		$reqGroupState= $this->input->post("reqGroupState");
		$reqTipeInputId= $this->input->post("reqTipeInputId");
		// print_r($reqType);exit;
		$reqFormula= $this->input->post("reqFormula");
		$reqStatusPengukuran= $this->input->post("reqStatusPengukuran");
		$reqCatatan= $this->input->post("reqCatatan");
		$reqSequence= $this->input->post("reqSequence");
		$reqIsInterval= $this->input->post("reqIsInterval");
		$reqStatus= $this->input->post("reqStatus");
		$reqAnalog= $this->input->post("reqAnalog");
		$reqText= $this->input->post("reqText");
		$reqLinkFileName = $_FILES['reqLinkFile']['name'];
		$reqUomId= $this->input->post("reqUomId");

		$reqPengukuranTipeInputId= $this->input->post("reqPengukuranTipeInputId");
		$reqTipePengukuranDetail= $this->input->post("reqTipePengukuranDetail");
		$reqSeq= $this->input->post("reqSeq");

		$reqTipePengukuranTable= $this->input->post("reqTipePengukuranTable");
		$reqTipePengukuranFile= $this->input->post("reqTipePengukuranFile");
		$reqTipePengukuranFileTemp= $this->input->post("reqTipePengukuranFileTemp");
		$reqTipePengukuranDesc= $this->input->post("reqTipePengukuranDesc");
		$reqTipePengukuranGambar= $this->input->post("reqTipePengukuranGambar");
		$reqTipePengukuranAnalog= $this->input->post("reqTipePengukuranAnalog");
		$reqTipePengukuranBinary= $this->input->post("reqTipePengukuranBinary");

		$vTipePengukuranTable= $this->input->post("vTipePengukuranTable");
		$vTipePengukuranGambar= $this->input->post("vTipePengukuranGambar");
		$vTipePengukuranDesc= $this->input->post("vTipePengukuranDesc");
		$vTipePengukuranAnalog= $this->input->post("vTipePengukuranAnalog");
		$vTipePengukuranBinary= $this->input->post("vTipePengukuranBinary");
		// print_r($_POST);exit;

		$set = new Pengukuran();
		$set->setField("NAMA", htmlentities($reqNama));
		$set->setField("NAMA_PENGUKURAN", $reqNamaPengukuran);
		$set->setField("KODE", $reqKode);
		$set->setField("ENJINIRINGUNIT_ID", ValToNullDB($reqEnjiniringId));
		$set->setField("GROUP_STATE_ID", ValToNullDB($reqGroupState));
		$set->setField("TIPE_INPUT_ID", ValToNullDB($reqTipeInputId));
		$set->setField("FORMULA", $reqFormula);
		$set->setField("STATUS_PENGUKURAN", $reqStatusPengukuran);
		$set->setField("CATATAN", $reqCatatan);
		$set->setField("SEQUENCE", $reqSequence);
		$set->setField("IS_INTERVAL", $reqIsInterval);
		$set->setField("STATUS", $reqStatus);
		$set->setField("PENGUKURAN_ID", $reqId);
		$set->setField("ANALOG", ValToNullDB(CommaToDot($reqAnalog)));
		$set->setField("TEXT_TIPE", $reqText);
		$set->setField("UOM_ID", ValToNullDB($reqUomId));

		if ( preg_match('/\s/',$reqKode) )
		{
			echo "xxx***Kolom kode tidak boleh terdapat spasi";exit;
		}

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("LAST_CREATE_DATE", 'NOW()');


			$statement=" AND A.KODE =  '".$reqKode."' ";
			$check = new Pengukuran();
			$check->selectByParams(array(), -1, -1, $statement);
			// echo $check->query;exit;
			$check->firstRow();
			$checkKode= $check->getField("KODE");

			if(!empty($checkKode))
			{
				echo "xxx***Kode Pengukuran ".$checkKode." sudah ada";exit;	
			}
			if($set->insert())
			{
				$reqId=$set->id;
				$reqSimpan= 1;
			}
		}
		else
		{	
			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->update())
			{
				$reqSimpan= 1;
			}
		}

		if($reqSimpan == 1 )
		{
			if(!empty($reqJenisPengukuran))
			{
				$setinsert = new Pengukuran();
				$setinsert->setField("PENGUKURAN_ID", $reqId);
				$setinsert->deletejenis();
				foreach ($reqJenisPengukuran as $key => $value) {
					
					$setinsert->setField("JENIS_PENGUKURAN_ID", $value);
					
					if($setinsert->insertjenis())
					{
						$reqSimpan= 1;
					}
				}
			}

			if(!empty($reqLinkFileName))
			{
				$reqSimpan="";
				$linkupload="uploads/pengukuran/".$reqId."/";
				if (!is_dir($linkupload)) {
					makedirs($linkupload);
				}
				$reqLinkFile=$_FILES['reqLinkFile']['tmp_name'];
				$namefile= $linkupload.$reqLinkFileName;
				// print_r($namefile);exit;
				if(move_uploaded_file($reqLinkFile, $namefile))
				{
					$set = new Pengukuran();
					$reqSimpan="";
					$set->setField("PENGUKURAN_ID", $reqId);
					$set->setField("LINK_FILE", $namefile);
					if($set->updateupload())
					{
						$reqSimpan= 1;
					}
				}
			}

			$reqLampiran = $_FILES['reqTipePengukuranFile']['name'];
			$reqLinkFile = $_FILES['reqTipePengukuranFile']['tmp_name'];

			for($i=0;$i<count($reqPengukuranTipeInputId);$i++){
				$set = new Pengukuran();
				$set->setField("PENGUKURAN_TIPE_INPUT_ID", ValToNullDB($reqPengukuranTipeInputId[$i]));
				$set->setField("TIPE_INPUT_ID", ValToNullDB($reqTipePengukuranDetail[$i]));
				$set->setField("SEQ", ValToNullDB($reqSeq[$i]));
				$set->setField("PENGUKURAN_ID", ValToNullDB($reqId));

				if(!empty($reqLampiran[$i]))
				{
					$reqSimpan="";
					$linkupload="uploads/pengukuran/".$reqId."/";
					if (!is_dir($linkupload)) {
						makedirs($linkupload);
					}
					$namefile= $linkupload.$reqLampiran[$i];
					// print_r($reqLinkFile);exit;
					if(move_uploaded_file($reqLinkFile[$i], $namefile))
					{
						$set->setField("VALUE", $namefile);
					}
					else if($reqTipePengukuranDesc[$i]!=''){
						$set->setField("VALUE", $reqTipePengukuranDesc[$i]);
					}
					else{
						$set->setField("VALUE", $reqTipePengukuranFileTemp[$i]);
					}
				}

				if(empty($vTipePengukuranGambar[$i]))
				{
					$set->setField("VALUE", $reqTipePengukuranGambar[$i]);
				}

				if(empty($vTipePengukuranDesc[$i]))
				{
					$set->setField("VALUE", $reqTipePengukuranDesc[$i]);
				}

				if(empty($vTipePengukuranAnalog[$i]))
				{
					$set->setField("VALUE", $reqTipePengukuranAnalog[$i]);
				}

				if(empty($vTipePengukuranBinary[$i]))
				{
					$set->setField("VALUE", $reqTipePengukuranBinary[$i]);
				}

				/*else if($reqTipePengukuranGambar[$i]!=''){
					$set->setField("VALUE", $reqTipePengukuranGambar[$i]);
				}
				else if($reqTipePengukuranDesc[$i]!=''){
					$set->setField("VALUE", $reqTipePengukuranDesc[$i]);
				}
				else if($reqTipePengukuranAnalog[$i]!=''){
					$set->setField("VALUE", $reqTipePengukuranAnalog[$i]);
				}
				else if($reqTipePengukuranBinary[$i]!=''){
					$set->setField("VALUE", $reqTipePengukuranBinary[$i]);
				}
				else{
					$set->setField("VALUE", $reqTipePengukuranFileTemp[$i]);
				}*/

				if($reqTipePengukuranTable[$i]=='0'){
					$jadi='';
				}
				else{
					$jadi=$reqTipePengukuranTable[$i];
				}
				$set->setField("MASTER_TABEL_ID", ValToNullDB($jadi));

				if($reqPengukuranTipeInputId[$i]==''){
					$set->insertTipe();
				}
				else{
					$set->updateTipe();
				}
			}

			$reqSimpan=1;
		}
		// exit;

		if($reqSimpan == 1 )
		{
			echo $reqId."***Data berhasil disimpan";
			// echo "xxx***Data berhasil disimpan";			
		}
		else
		{
			echo "xxx***Data gagal disimpan";
		}
				
	}

	function delete()
	{
		$this->load->model("base-app/Pengukuran");
		$set = new Pengukuran();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("PENGUKURAN_ID", $reqId);

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

	function delete_gambar()
	{
		$this->load->model("base-app/Pengukuran");
		$set = new Pengukuran();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("PENGUKURAN_ID", $reqId);

		$check = new Pengukuran();
		$statement = " AND PENGUKURAN_ID = '".$reqId."' ";
		$check->selectByParams(array(), -1, -1, $statement);
  		  // echo $check->query;exit;
		$check->firstRow();
		$reqLinkFoto= $check->getField("LINK_FILE");

		if(file_exists($reqLinkFoto))
		{
			unlink($reqLinkFoto);
		}

		if($set->delete_gambar())
		{
			$arrJson["PESAN"] = "Gambar berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Gambar gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function delete_tipeinput()
	{
		$this->load->model("base-app/Pengukuran");
		$set = new Pengukuran();
		
		$reqId =  $this->input->get('reqId');
		$reqPengukuranId =  $this->input->get('reqPengukuranId');

		$set->setField("pengukuran_tipe_input_id", $reqId);
		$set->setField("PENGUKURAN_ID", $reqPengukuranId);

		if($set->delete_tipeinput())
		{
			$arrJson["PESAN"] = "Berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Gagal dihapus.";	
		}

		echo $set->query;exit;

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


	function addtipe()
	{
		$this->load->model("base-app/PengukuranTipe");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");
		$reqHeaderId= $this->input->post("reqHeaderId");
		$reqTipeHeaderId= $this->input->post("reqTipeHeaderId");
		$reqDetilId= $this->input->post("reqDetilId");

		$reqKolom= $this->input->post("reqKolom");
		
		$reqRowspan= $this->input->post("reqRowspan");
		$reqColspan= $this->input->post("reqColspan");

		$reqStatusTabel= $this->input->post("reqStatusTabel");
		$reqTipeInputId= $this->input->post("reqTipeInputId");
		$reqTipeInputDetailId= $this->input->post("reqTipeInputDetailId");

		// print_r($reqTipeHeaderId);exit;
		
		$set = new PengukuranTipe();

		$reqSimpan="";

		if(!empty($reqKolom))
		{
			$setheader = new PengukuranTipe();
			foreach ($reqTipeHeaderId as $hkey => $header) 
			{
				$setheader->setField("PENGUKURAN_TIPE_HEADER_ID", $header);
				$setheader->setField("PENGUKURAN_ID", $reqId);
				$setheader->deleteheader();
				if($setheader->insertheader())
				{
				}
				
			}
			
			foreach ($reqKolom as $key => $value) {
				$set->setField("NAMA", htmlentities($value));
				$set->setField("PENGUKURAN_ID", $reqId);
				$set->setField("TIPE_INPUT_ID", ValToNullDB($reqTipeInputId[$key]));
				$set->setField("TIPE_INPUT_DETAIL_ID", ValToNullDB($reqTipeInputDetailId[$key]));
				$set->setField("ROWSPAN", ValToNullDB($reqRowspan[$key]));
				$set->setField("COLSPAN", ValToNullDB($reqColspan[$key]));
				$set->setField("STATUS_TABEL", $reqStatusTabel[$key]);
				$set->setField("PENGUKURAN_TIPE_HEADER_ID", $reqHeaderId[$key]);
				$set->setField("PENGUKURAN_TIPE_ID", $reqDetilId[$key]);

				


				if (empty($reqDetilId[$key]))
				{
					$set->setField("LAST_CREATE_USER", $this->adminusernama);
					$set->setField("LAST_CREATE_DATE", 'SYSDATE');
					
					if($set->insert())
					{
						$reqSimpan= 1;
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

	function delete_tipe_header()
	{
		$this->load->model("base-app/PengukuranTipe");
		$set = new PengukuranTipe();
		
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqHeaderId =  $this->input->get('reqHeaderId');
		$reqMode =  $this->input->get('reqMode');

		
		$set->setField("PENGUKURAN_TIPE_ID", $reqDetilId);
		$set->setField("PENGUKURAN_TIPE_HEADER_ID", $reqHeaderId);

		if($reqMode=='header')
		{
			
			if($set->deleteallheader())
			{
				$arrJson["PESAN"] = "Data berhasil dihapus.";
			}
			else
			{
				$arrJson["PESAN"] = "Data gagal dihapus.";	
			}
		}
		else
		{
			if($set->delete())
			{
				$arrJson["PESAN"] = "Data berhasil dihapus.";
			}
			else
			{
				$arrJson["PESAN"] = "Data gagal dihapus.";	
			}
		}

	

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}


}