<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Nameplate_json extends CI_Controller
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
		$this->load->model("base-app/Nameplate");

		$set= new Nameplate();


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

		$sOrder = " ORDER BY NAMEPLATE_ID ";
		$set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

		// echo $set->query;exit;
		$infobatasdetil= $_REQUEST['start'] + $_REQUEST['length'];
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
		$this->load->model("base-app/Nameplate");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqNama= $this->input->post("reqNama");
		$reqTipe= $this->input->post("reqTipe");

		// print_r($reqTipe);exit;
		$reqStatus= $this->input->post("reqStatus");

		$reqStatusDetil= $this->input->post("reqStatusDetil");
		$reqNamaDetil= $this->input->post("reqNamaDetil");
		$reqIsiDetil= $this->input->post("reqIsiDetil");

		$reqIdDetil= $this->input->post("reqIdDetil");

		$reqNamaDetil=array_filter($reqNamaDetil);
		$reqIsiDetil=array_filter($reqIsiDetil);

		$set = new Nameplate();
		$set->setField("NAMA", $reqNama);
		$set->setField("STATUS", $reqStatus);
		$set->setField("NAMEPLATE_ID", $reqId);

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

		if($reqSimpan == 1)
		{
			if(!empty($reqNamaDetil))
			{
				$set = new Nameplate();
				$reqSimpan="";
				// $set->setField("NAMEPLATE_ID", $reqId);
				// $set->deletedetil();
				foreach ($reqNamaDetil as $key => $value) {
					$set->setField("NAMA", $reqNamaDetil[$key]);
					$set->setField("ISI", $reqIsiDetil[$key]);

					$pos = strpos($reqTipe[$key], '-');


					if(false !== $pos) {
						$reqTipe[$key] = substr($reqTipe[$key], strpos($reqTipe[$key], "-") + 1); 
					}
					// print_r($reqTipe[$key].'</br>');
					
					$set->setField("NAMA_TABEL", strtoupper($reqTipe[$key]));
					$set->setField("STATUS", $reqStatusDetil[$key]);
					$set->setField("NAMEPLATE_ID", $reqId);
					$set->setField("NAMEPLATE_DETIL_ID", $reqIdDetil[$key]);

					if(empty($reqIdDetil[$key]))
					{
						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
					else
					{
						if($set->updatedetil())
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

	function delete()
	{
		$this->load->model("base-app/Nameplate");
		$set = new Nameplate();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("NAMEPLATE_ID", $reqId);

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

	function deletedetail()
	{
		$this->load->model("base-app/Nameplate");
		$set = new Nameplate();

		$reqId =  $this->input->get('reqId');
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqSimpan="";
		$set->setField("NAMEPLATE_DETIL_ID", $reqDetilId);
		$set->setField("NAMEPLATE_ID", $reqId);
		if($set->deletedetiltabel())
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


}