<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Enjiniring_unit_json extends CI_Controller
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
		$this->load->model("base-app/EnjiniringUnit");

		$set= new EnjiniringUnit();

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
				OR UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
			)";
		}

		$sOrder = " ";
		$set->selectByParams(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);

		// echo $set->query;exit;
		$infobatasdetil= $_REQUEST['start'] + $_REQUEST['length'];
		$infonomor= 0;
		while ($set->nextRow()) 
		{
			$infonomor++;
			$infojenisnaskahid= $set->getField("JENIS_NASKAH_ID");
			$infosuratmasukid= $set->getField("SURAT_MASUK_ID");

			$row= [];
			foreach($columnsDefault as $valkey => $valitem) 
			{
				if ($valkey == "SORDERDEFAULT")
				{
					// $row[$valkey]= "1";
					$row[$valkey]= $set->getField("TANGGAL_DISPOSISI");
				}
				else if($valkey == "NOMOR")
				{
					if($infojenisnaskahid == "1")
						$row[$valkey] = $set->getField("NOMOR_SURAT_INFO");
					else
						$row[$valkey] = $set->getField($valkey)."-".$infonomor."-".$infosuratmasukid;
				}
				else if ($valkey == "INFO_TERBACA")
				{
					$infoterbaca= "";
					if(in_array("SURAT", explode(",", $this->USER_GROUP)))
					{
						$infoterbaca= "1";
					}
					else
					{
						$infodisposisiuserid= $this->ID;
						$infodisposisiterbacainfo= $set->getField("TERBACA_INFO");

						$arrcheckterbaca= explode(";", $infodisposisiterbacainfo);
				        if(!empty($arrcheckterbaca) && !empty($infodisposisiterbacainfo))
				        {
				            while (list($key, $val) = each($arrcheckterbaca))
				            {
				                $arrcheckterbacadetil= explode(",", $val);
				                if($infodisposisiuserid == $arrcheckterbacadetil[0])
				                {
				                    $infoterbaca= "1";
				                    break;
				                }
				            }
				        }
				    }
					$row[$valkey] = $infoterbaca;
				}
				else if($valkey == "TANGGAL_DISPOSISI")
				{
					$inforeturn= "";
					if($infonomor <= $infobatasdetil)
					{
						if($set->getField("TERDISPOSISI") == "1")
						{
							$infoicondisposisi= "<i class='fa fa-share-alt' aria-hidden='true'></i> ";
							
						}
						// echo $infoteruskan;
						if ($infoteruskan == "0" )
						{
							$infoiconteruskan= "<i class='fa fa-share' aria-hidden='true'></i>";
						}

						$inforeturn= getFormattedExtDateTimeCheck($set->getField($valkey))." ".$infoicondisposisi.$infoiconteruskan;
					}

					$row[$valkey]= $inforeturn;
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
			// if(count($columnsDefault) - 2 == $column){}
			// else
			// {
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
			// }
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
		$this->load->model("base-app/EnjiniringUnit");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqKode= $this->input->post("reqKode");
		$reqNama= $this->input->post("reqNama");
		$reqStatus= $this->input->post("reqStatus");

		$set = new EnjiniringUnit();
		$set->setField("KODE", $reqKode);
		$set->setField("NAMA", $reqNama);
		$set->setField("STATUS", $reqStatus);
		$set->setField("ENJINIRINGUNIT_ID", $reqId);

		$reqSimpan= "";
		if ($reqMode == "insert")
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
		$this->load->model("base-app/EnjiniringUnit");
		$set = new EnjiniringUnit();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("ENJINIRINGUNIT_ID", $reqId);

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

}