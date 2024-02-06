<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Kelompok_Equipment_Json extends CI_Controller
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
		$this->load->model("base-app/KelompokEquipment");

		$set= new KelompokEquipment();

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
		$this->load->model("base-app/KelompokEquipment");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqKode= $this->input->post("reqKode");
		$reqNama= $this->input->post("reqNama");
		$reqStatus= $this->input->post("reqStatus");

		$set = new KelompokEquipment();
		$set->setField("KODE", $reqKode);
		$set->setField("NAMA", $reqNama);
		$set->setField("STATUS", $reqStatus);
		$set->setField("KELOMPOK_EQUIPMENT_ID", $reqId);
		
		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("KELOMPOK_EQUIPMENT_PARENT_ID", $reqId);
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

	function deletestatus()
	{
		$this->load->model("base-app/KelompokEquipment");
		$set = new KelompokEquipment();
		
		$reqId=  $this->input->get('reqId');
		$reqMode=  $this->input->get('reqMode');
		// $set->setField("LAST_USER", $this->LOGIN_USER);
		// $set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		// $set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
		// $set->setField("LAST_DATE", "NOW()");
		$set->setField("ID", $reqId);
		
		if($reqMode == "mode_0")
		{
			$set->setField("STATUS", "1");
			if($set->updateStatus())
				$arrJson["PESAN"] = "Data berhasil dihapus.";
			else
				$arrJson["PESAN"] = "Data gagal dihapus.";	
		}
		elseif($reqMode == "mode_1")
		{
			$set->setField("STATUS", ValToNullDB($req));
			if($set->updateStatus())
				$arrJson["PESAN"] = "Data berhasil dihapus.";
			else
				$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function delete()
	{
		$this->load->model("base-app/KelompokEquipment");
		$set = new KelompokEquipment();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("KELOMPOK_EQUIPMENT_ID", $reqId);

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

	function tree() 
	{
		$this->load->model("base-app/KelompokEquipment");

		$reqStatus= $this->input->get("reqStatus");
		
		$page= isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows= isset($_GET['rows']) ? intval($_GET['rows']) : 50;
		$id= isset($_POST['id']) ? intval($_POST['id']) : 0;
		$offset= ($page-1)*$rows;
		
		$reqPencarian = trim($this->input->get("reqPencarian"));
		$reqMode = $this->input->get("reqMode");

		$statement= "";
		$set= new KelompokEquipment();
		if(!empty($reqPencarian))
		{
			$statement.= " AND (UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'  ";
		}
		else
		{
			if($id == 0)
				$statement.= " AND COALESCE(NULLIF(A.PARENT_ID, ''), '0') = '0'";
			else
				$statement.= " AND COALESCE(NULLIF(A.PARENT_ID, ''), '0') = '".$id."'";
		}

		$rowCount = 0;
		$set->selectByParams(array(), $rows, $offset, $statement, " ORDER BY A.ID ASC ");
		// echo $set->query;exit;
		$i = 0;
		$items = array();
		while($set->nextRow())
		{
			$infoid= $set->getField("ID");
			$this->TREETABLE_COUNT++;
			
			$row['id']= $infoid;
			$row['parentId']= $set->getField("PARENT_ID");
			$row['NAMA']= $set->getField("NAMA");
			$row['LINK_URL_INFO']= $set->getField("LINK_URL_INFO");
		
			if(trim($reqPencarian) == "")
			{
				$row['state']= $this->haschild($infoid,"");
				$row['children']= $this->children($infoid, "");
			}
			$i++;
			array_push($items, $row);
			unset($row);
		}

		$result["rows"] = $items;
		$result["total"] = $this->TREETABLE_COUNT;
		echo json_encode($result);


		/*if ($id == 0)
		{
			$result["total"] = 0;
			$set->selectByParams(array(), -1, -1, $statement);
			//echo $set->query;exit;
			$i=0;
			while($set->nextRow())
			{
				$infoid= $set->getField("ID");
				$items[$i]['ID'] = $infoid;
				$items[$i]['NAMA'] = $set->getField("NAMA");
				// $items[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
				// $items[$i]['state'] = $this->haschild($infoid, $statementAktif) ? 'closed' : 'open';
				$items[$i]['state'] = $this->haschild($infoid, $statementAktif);
				$i++;
			}
			$result["rows"] = $items;
		} 
		else 
		{
			$set->selectByParams(array(), -1, -1, $statement);
			//echo $set->query;exit;
			$i=0;
			while($set->nextRow())
			{
				$infoid= $set->getField("ID");
				$result[$i]['ID'] = $infoid;
				$result[$i]['NAMA'] = $set->getField("NAMA");
				// $result[$i]['LINK_URL_INFO'] = $set->getField("LINK_URL_INFO");
				// $result[$i]['state'] = $this->haschild($infoid, $statementAktif) ? 'closed' : 'open';
				$i++;
			}
		}
		echo json_encode($result);*/
	}

	function haschild($id, $stat)
	{
		$child = new KelompokEquipment();
		$adaData = $child->getCountByParams(array("A.PARENT_ID" => $id), $stat);
		// echo $child->query;exit;
		return $adaData > 0 ? true : false;
	}

	function children($id, $stat)
	{
		$this->load->model("base-app/KelompokEquipment");
		$set= new KelompokEquipment();

		$statement= " AND COALESCE(NULLIF(A.PARENT_ID, ''), '0') = '".$id."'";
		$set->selectByParams(array(), -1, -1, $statement);
		// echo $set->query;
		$i = 0;
		$items = array();
		while($set->nextRow())
		{
			$infoid= $set->getField("ID");
			$this->TREETABLE_COUNT++;
			$row['id']= $infoid;
			$row['parentId']= $set->getField("PARENT_ID");
			$row['NAMA']= $set->getField("NAMA");
			$row['LINK_URL_INFO']= $set->getField("LINK_URL_INFO");
			$state= $this->haschild($infoid, "");
			$row['state']= $state;
			if($state)
			{
				$row['children']= $this->children($infoid, "");
			}
	
			$i++;
			array_push($items, $row);
			unset($row);
		}
		return $items;
	}

}