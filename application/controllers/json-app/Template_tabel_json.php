<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Template_tabel_json extends CI_Controller
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
		$this->load->model("base-app/TabelTemplate");

		$set= new TabelTemplate();

		$reqJenisNaskahId= $this->input->get("reqJenisNaskahId");

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
			)";
		}

		$sOrder = " ORDER BY A.TABEL_TEMPLATE_ID ";
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
					$row[$valkey]= $set->getField("TANGGAL_DISPOSISI");
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
		$this->load->model("base-app/TabelTemplate");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqNama= $this->input->post("reqNama");
		$reqTotal= $this->input->post("reqTotal");

		$reqHeaderId= $this->input->post("reqHeaderId");
		$reqBaris= $this->input->post("reqBaris");
		$reqDetilId= $this->input->post("reqDetilId");

		$reqKolom= $this->input->post("reqKolom");
		
		$reqRowspan= $this->input->post("reqRowspan");
		$reqColspan= $this->input->post("reqColspan");

		$reqNoteAtas= $this->input->post("reqNoteAtas");
		$reqNoteBawah= $this->input->post("reqNoteBawah");
		$reqStatus= $this->input->post("reqStatus");

		// var_dump($reqBaris);exit;


		$set = new TabelTemplate();
		$set->setField("NAMA", $reqNama);
		$set->setField("TOTAL", $reqTotal);
		$set->setField("TABEL_TEMPLATE_ID", $reqId);
		$set->setField("NOTE_ATAS", setQuote($reqNoteAtas));
		$set->setField("NOTE_BAWAH", setQuote($reqNoteBawah));
		$set->setField("STATUS", $reqStatus);

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


		if(!empty($reqKolom))
		{
			$reqSimpan= "";

			$setheader = new TabelTemplate();

			// print_r($reqBaris);exit;
			$setisi = new TabelTemplate();

			foreach ($reqKolom as $key => $value) {
					// print_r($arrReqHeaderId[$key]);
				$setisi->setField("NAMA", htmlentities($value));
				$setisi->setField("TABEL_TEMPLATE_ID", $reqId);
				$setisi->setField("ROWSPAN", ValToNullDB($reqRowspan[$key]));
				$setisi->setField("COLSPAN", ValToNullDB($reqColspan[$key]));
				$setisi->setField("BARIS", $reqBaris[$key]);
				$setisi->setField("TABEL_DETIL_ID", $reqDetilId[$key]);


				if (empty($reqDetilId[$key]))
				{
					$setisi->setField("LAST_CREATE_USER", $this->adminusernama);
					$setisi->setField("LAST_CREATE_DATE", 'SYSDATE');

					if($setisi->insertdetil())
					{
						$reqSimpan= 1;
					}
				}
				else
				{	

					$setisi->setField("LAST_UPDATE_USER", $this->adminusernama);
					$setisi->setField("LAST_UPDATE_DATE", 'SYSDATE');
					if($setisi->updatedetil())
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


	function delete_tipe_header()
	{
		$this->load->model("base-app/TabelTemplate");
		$set = new TabelTemplate();
		
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqBaris =  $this->input->get('reqBaris');
		$reqMode =  $this->input->get('reqMode');
		$reqId =  $this->input->get('reqId');

		
		$set->setField("TABEL_DETIL_ID", $reqDetilId);
		$set->setField("BARIS", $reqBaris);

		$set->setField("TABEL_TEMPLATE_ID", $reqId);

		if($reqMode=='header')
		{
			
			if($set->deleteheader())
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
			if($set->deleteisi())
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

	function delete()
	{
		$this->load->model("base-app/TabelTemplate");
		$set = new TabelTemplate();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("TABEL_TEMPLATE_ID", $reqId);

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

	function copy()
	{
		$this->load->model("base-app/TabelTemplate");
		$set = new TabelTemplate();
		
		$reqId =  $this->input->post('reqId');
		$reqNama =  $this->input->post('reqNama');

		$set->setField("TABEL_DETIL_ID", $reqDetilId);
		$set->setField("NAMA", $reqNama);

		$set->setField("TABEL_ID", $reqId);

		$reqSimpan="";

		if($set->copy())
		{
			$reqSimpan= 1;
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

	function copymaster()
	{
		$this->load->model("base-app/TabelTemplate");
		$set = new TabelTemplate();
		
		$reqId =  $this->input->get('reqId');
		$reqNama =  $this->input->post('reqNama');

		$set->setField("TABEL_ID", $reqId);

		$reqSimpan="";

		if($set->copymaster())
		{
			$reqSimpan= 1;
		}

		if($reqSimpan == 1 )
		{
			$arrJson["PESAN"] = "Data berhasil dicopy.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dicopy.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
		
	}

}