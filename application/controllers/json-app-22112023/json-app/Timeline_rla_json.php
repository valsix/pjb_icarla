<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class timeline_rla_json extends CI_Controller
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
		$this->load->model("base-app/TimelineRla");

		$set= new TimelineRla();

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
				else if ($valkey == "RENCANA_TANGGAL_AWAL" || $valkey == "RENCANA_TANGGAL_AKHIR" || $valkey == "REALISASI_TANGGAL_AWAL" || $valkey == "REALISASI_TANGGAL_AKHIR")
				{
					$row[$valkey]= dateToPageCheck($set->getField($valkey));
				}
				else
				{
					$row[$valkey]= $set->getField($valkey);
				}
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
		$this->load->model("base-app/TimelineRla");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqNama= $this->input->post("reqNama");
		$reqRencanaTanggalAwal= $this->input->post("reqRencanaTanggalAwal");
		$reqRencanaTanggalAkhir= $this->input->post("reqRencanaTanggalAkhir");
		$reqRencanaDurasi= $this->input->post("reqRencanaDurasi");
		$reqRealisasiTanggalAwal= $this->input->post("reqRealisasiTanggalAwal");
		$reqRealisasiTanggalAkhir= $this->input->post("reqRealisasiTanggalAkhir");
		$reqRealisasiDurasi= $this->input->post("reqRealisasiDurasi");

		$set = new TimelineRla();
		$set->setField("NAMA", $reqNama);
		$set->setField("RENCANA_TANGGAL_AWAL", dateToDBCheck($reqRencanaTanggalAwal));
		$set->setField("RENCANA_TANGGAL_AKHIR", dateToDBCheck($reqRencanaTanggalAkhir));
		$set->setField("RENCANA_DURASI", $reqRencanaDurasi);
		$set->setField("REALISASI_TANGGAL_AWAL", dateToDBCheck($reqRealisasiTanggalAwal));
		$set->setField("REALISASI_TANGGAL_AKHIR", dateToDBCheck($reqRealisasiTanggalAkhir));
		$set->setField("REALISASI_DURASI", $reqRealisasiDurasi);
		$set->setField("TIMELINE_RLA_ID", $reqId);

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
		$this->load->model("base-app/TimelineRla");
		$set = new TimelineRla();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("TIMELINE_RLA_ID", $reqId);

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

	function gantt()
	{
		$this->load->model("base-app/TimelineRla");

		$timelinerla = new TimelineRla();

		$reqIdRla = $this->input->get("reqIdRla");
		$reqMonitoring = $this->input->get("reqMonitoring");
		$reqTahun = $this->input->get("reqTahun");
		
		$arr_data = array();
		$arr_links = array();
		$i = 0;
		
		$statement="";
		$statementtahun="";
		if ($reqIdRla) 
		{
			$statement=" AND PLAN_RLA_ID = ".$reqIdRla;
		}

		if ($reqMonitoring) 
		{
			$statement=" AND A.V_STATUS = 20";

			if($reqTahun)
			{
				$statementtahun =" AND ( DATE_PART('year',RENCANA_TANGGAL_AWAL) = '".$reqTahun."' OR DATE_PART('year',RENCANA_TANGGAL_AKHIR) = '".$reqTahun."'  OR DATE_PART('year',REALISASI_TANGGAL_AWAL) = '".$reqTahun."'  OR DATE_PART('year',REALISASI_TANGGAL_AKHIR) = '".$reqTahun."' )";
			}
		}
		
		$timelinerla->selectByParamsPlanRla(array(),-1,-1,$statement.$statementtahun);
		// echo $timelinerla->query; exit;

		while($timelinerla->nextRow())
		{
			// echo "1"; exit;
			$arr_data[$i]['id'] = $timelinerla->getField("PLAN_RLA_ID");
			$arr_data[$i]['text'] = $timelinerla->getField("KODE_MASTER_PLAN");	
			$arr_data[$i]['progress'] = $timelinerla->getField("PROGRESS");
			$arr_data[$i]['status_approve'] = $timelinerla->getField("STATUS_APPROVE_NAMA");
			$arr_data[$i]['open'] = true;
			$i++;		


		}

		if($reqTahun)
		{
			$statementtahun =" AND (TANGGAL_AWAL LIKE  '%".$reqTahun."%' OR TANGGAL_AKHIR LIKE  '%".$reqTahun."%'    )";
		}

		// var_dump($reqTahun);

		$timelinerla->selectByParamsPlanRlaWbs(array(),-1,-1,$statement.$statementtahun);
		// echo $timelinerla->query; exit;

		while($timelinerla->nextRow())
		{
			$id= $i+1;
			$arr_data[$i]['id'] = $id.".1";
			$arr_data[$i]['text'] = $timelinerla->getField("STATUS");	
			$arr_data[$i]['start_date'] = $timelinerla->getField("TANGGAL_AWAL");	
			$arr_data[$i]['end_date'] = $timelinerla->getField("TANGGAL_AKHIR");	
			$arr_data[$i]['durasi'] = $timelinerla->getField("SELISIH");
			$arr_data[$i]['progress'] = $timelinerla->getField("NAMA_PROGRESS");
			$arr_data[$i]['open'] = true;	
			$arr_data[$i]['parent'] = $timelinerla->getField("PLAN_RLA_ID");
			$arr_data[$i]['parent_id'] = $i+1;
			$i++;		


		}

		// print_r( $arr_data);exit;
		
	
		$arr_json["data"] = $arr_data;
		$arr_json["links"] = $arr_links;
		
		
		echo json_encode($arr_json);
	}

}