<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class plan_rla_json extends CI_Controller
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
		$this->appuserroleid= $this->session->userdata("appuserroleid");

		$this->configtitle= $this->config->config["configtitle"];
		// print_r($this->configtitle);exit;
	}

	function json()
	{
		$this->load->model("base-app/PlanRla");

		$set= new PlanRla();

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

		
		$statement="";
		// if(!empty($this->appuserroleid))
		// {
		// }

		$sOrder = " ORDER BY A.PLAN_RLA_ID";
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
				else if ($valkey == "RENCANA_TANGGAL_AWAL" || $valkey == "RENCANA_TANGGAL_AKHIR" || $valkey == "REALISASI_TANGGAL_AWAL" || $valkey == "REALISASI_TANGGAL_AKHIR")
				{
					$row[$valkey]= dateToPageCheck($set->getField($valkey));
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
		$this->load->model("base-app/PlanRla");

		$reqId= $this->input->post("reqId");
		// print_r($reqId);exit;
		$reqMode= $this->input->post("reqMode");

		$reqKode= $this->input->post("reqKode");
		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqEntitas= $this->input->post("reqEntitas");
		$reqUnitId= $this->input->post("reqUnitId");
		$reqEquipmentId= $this->input->post("reqEquipmentId");
		$reqKelompokEquipment= $this->input->post("reqKelompokEquipment");
		$reqJudulKegiatan= $this->input->post("reqJudulKegiatan");
		$reqRlaLevel= $this->input->post("reqRlaLevel");
		$reqRlaIndex= $this->input->post("reqRlaIndex");
		$reqAnggaranRencana= $this->input->post("reqAnggaranRencana");
		$reqAnggaranRealisasi= $this->input->post("reqAnggaranRealisasi");
		$reqWorkOrderId= $this->input->post("reqWorkOrderId");
		$reqWorkRequestId= $this->input->post("reqWorkRequestId");
		$reqKodePrk= $this->input->post("reqKodePrk");
		$reqRencanaTanggalAwal= $this->input->post("reqRencanaTanggalAwal");
		$reqDurasiRencana= $this->input->post("reqDurasiRencana");
		$reqRealisasiTanggalAwal= $this->input->post("reqRealisasiTanggalAwal");
		$reqDurasiRealisasi= $this->input->post("reqDurasiRealisasi");
		$reqPicId= $this->input->post("reqPicId");
		$reqStatus= $this->input->post("reqStatus");
		$reqPemeriksaId= $this->input->post("reqPemeriksaId");
		$reqListFormUji= $this->input->post("reqListFormUji");
		$reqTimelineRlaId= $this->input->post("reqTimelineRlaId");

		$reqRencanaTanggalAkhir= $this->input->post("reqRencanaTanggalAkhir");
		$reqRealisasiTanggalAkhir= $this->input->post("reqRealisasiTanggalAkhir");

		$reqRencanaTanggalAkhir= $this->input->post("reqRencanaTanggalAkhir");
		$reqRealisasiTanggalAkhir= $this->input->post("reqRealisasiTanggalAkhir");
		$reqNomorPengadaan= $this->input->post("reqNomorPengadaan");
		$reqProgress= $this->input->post("reqProgress");
		$reqTahun= $this->input->post("reqTahun");
		$reqEquipmentId= $this->input->post("reqEquipmentId");

		
		$reqLampiran = $_FILES['reqLampiran']['name'];

		$rencanaawal = new DateTime($reqRencanaTanggalAwal);
		$rencanaakhir = new DateTime($reqRencanaTanggalAkhir);

		$realisasiawal = new DateTime($reqRealisasiTanggalAwal);
		$realisasiakhir = new DateTime($reqRealisasiTanggalAkhir);

		if ($rencanaakhir < $rencanaawal)
		{
			echo "xxx***Rencana tanggal akhir tidak boleh kurang dari tanggal awal";exit;	
		}
		if ($realisasiakhir < $realisasiawal)
		{
			echo "xxx***Realisasi tanggal akhir tidak boleh kurang dari tanggal awal";exit;	
		}

		$set = new PlanRla();
		$set->setField("KODE_MASTER_PLAN", $reqKode);
		$set->setField("DISTRIK_ID", ValToNullDB($reqDistrikId));
		$set->setField("ENTITAS", $reqEntitas);
		$set->setField("UNIT_ID", ValToNullDB($reqUnitId));
		$set->setField("EQUIPMENT_ID", ValToNullDB($reqEquipmentId));
		// $set->setField("KELOMPOK_EQUIPMENT_ID", ValToNullDB($reqKelompokEquipment));
		$set->setField("JUDUL_KEGIATAN", $reqJudulKegiatan);
		$set->setField("RLA_LEVEL", $reqRlaLevel);
		$set->setField("RLA_INDEX", $reqRlaIndex);
		$set->setField("ANGGARAN_RENCANA", $reqAnggaranRencana);
		$set->setField("ANGGARAN_REALISASI", $reqAnggaranRealisasi);
		$set->setField("WORK_ORDER_ID", ValToNullDB($reqWorkOrderId));
		$set->setField("WORK_REQUEST_ID", ValToNullDB($reqWorkRequestId));
		$set->setField("KODE_PRK", $reqKodePrk);
		$set->setField("RENCANA_TANGGAL_AWAL", dateToDBCheck($reqRencanaTanggalAwal));
		$set->setField("RENCANA_DURASI", $reqDurasiRencana);
		$set->setField("RENCANA_TANGGAL_AKHIR", dateToDBCheck($reqRencanaTanggalAkhir));
		$set->setField("REALISASI_TANGGAL_AWAL", dateToDBCheck($reqRealisasiTanggalAwal));
		$set->setField("REALISASI_TANGGAL_AKHIR", dateToDBCheck($reqRealisasiTanggalAkhir));
		$set->setField("REALISASI_DURASI", $reqDurasiRealisasi);
		$set->setField("TIMELINE_RLA_ID", ValToNullDB($reqTimelineRlaId));
		// $set->setField("PIC_ID", ValToNullDB($reqPicId));
		$set->setField("PIC_ID", $reqPicId);
		$set->setField("STATUS", $reqStatus);
		$set->setField("PEMERIKSA_ID", $reqPemeriksaId);
		$set->setField("LAMPIRAN", $reqLampiran);
		$set->setField("PLAN_RLA_ID", $reqId);
		$set->setField("PROGRESS", $reqProgress);
		$set->setField("PENGGUNA_ID", $this->appuserid);
		$set->setField("ROLE_ID", ValToNullDB($this->appuserroleid));

		$is_draft= $this->input->post("is_draft");
		$set->setField("V_STATUS", ValToNullDB($is_draft));

		$set->setField("TAHUN", ValToNullDB($reqTahun));
	
		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->adminusernama);
			$set->setField("LAST_CREATE_DATE", 'SYSDATE');
			if($set->insert())
			{
				$reqId=$set->id;
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

		// print_r($reqSimpan);exit;

		if($reqSimpan == 1 )
		{
			// untuk approval
			if($is_draft !== "1")
			{
				$infopg= $this->input->post("infopg");
				$infoketerangan= "Kelola Management Master Plan";
				$this->load->library('libapproval');
				$vappr= new libapproval();
				$arrparam= ["ref_id"=>$reqId, "ref_tabel"=>$infopg, "infoketerangan"=>$infoketerangan];
				$vappr->approvaldata($arrparam);
			}
			// untuk approval
			
			if(!empty($reqListFormUji))
			{
				$setinsert = new PlanRla();
				$setinsert->setField("PLAN_RLA_ID", $reqId);
				$setinsert->deleteform();
				foreach ($reqListFormUji as $key => $value) {
					$setinsert->setField("FORM_UJI_ID", $value);
					
					if($setinsert->insertform())
					{
						$reqSimpan= 1;
					}
					
				}
			}
			if(!empty($reqLampiran))
			{
				$reqSimpan="";
				$linkupload="uploads/plan_rla/".$reqId."/";
				if (!is_dir($linkupload)) {
					makedirs($linkupload);
				}
				$reqLinkFile=$_FILES['reqLampiran']['tmp_name'];
				$namefile= $linkupload.$reqLampiran;
				// print_r($namefile);exit;
				if(move_uploaded_file($reqLinkFile, $namefile))
				{
					$set = new PlanRla();
					$reqSimpan="";
					$set->setField("PLAN_RLA_ID", $reqId);
					$set->setField("LAMPIRAN", $namefile);
					if($set->updateupload())
					{
						$reqSimpan= 1;
					}
				}
			}

			if(!empty($reqNomorPengadaan))
			{
				$setinsert = new PlanRla();
				$setinsert->setField("PLAN_RLA_ID", $reqId);
				$setinsert->deletepengadaan();
				foreach ($reqNomorPengadaan as $key => $value) {
					$setinsert->setField("PENGADAAN_KONTRAK_ID", $value);
					if($setinsert->insertpengadaan())
					{
						$reqSimpan= 1;
					}
				}
			}

			// print_r($reqKelompokEquipment);exit;

			if(!empty($reqKelompokEquipment))
			{
				$setdelete = new PlanRla();
				$reqSimpan="";
				$setdelete->setField("PLAN_RLA_ID", $reqId);
				$setdelete->deleteequipment();
				foreach ($reqKelompokEquipment as $key => $value) 
				{
					$seteq = new PlanRla();
					$seteq->setField("KELOMPOK_EQUIPMENT_ID", ValToNullDB($reqKelompokEquipment[$key]));
					$seteq->setField("PLAN_RLA_ID", $reqId);

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
		$this->load->model("base-app/PlanRla");
		$set = new PlanRla();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("PLAN_RLA_ID", $reqId);

		if($set->deleteall())
		{
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		}
		else
		{
			$arrJson["PESAN"] = "Data gagal dihapus.";	
		}

		echo json_encode( $arrJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);	
	}

	function addreport()
	{
		$this->load->model("base-app/PlanRlaFormUjiDinamis");

		$reqIdRla= $this->input->post("reqIdRla");
		$reqIdDetilRla= $this->input->post("reqIdDetilRla");
		$reqIsi= $this->input->post("reqIsi");
		// print_r($reqIdDetilRla);exit;
		

		foreach ($reqIsi as $key => $value) {
			$set = new PlanRlaFormUjiDinamis();
			$set->setField("PLAN_RLA_ID", $reqIdRla[$key]);
			$set->setField("PLAN_RLA_FORM_UJI_DINAMIS_ID", $reqIdDetilRla[$key]);
			$set->setField("NAMA", $value);

			$set->setField("LAST_UPDATE_USER", $this->appusernama);
			$set->setField("LAST_UPDATE_DATE", 'NOW()');
			if($set->updatenama())
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



	function delete_report()
	{
		$this->load->model("base-app/PlanRlaFormUjiDinamis");
		$set = new PlanRlaFormUjiDinamis();
		
		$reqId =  $this->input->get('reqId');
		$reqTabelId =  $this->input->get('reqTabelId');
		$reqPengukuranId =  $this->input->get('reqPengukuranId');
		$reqFormUjiId =  $this->input->get('reqFormUjiId');

		$set->setField("PLAN_RLA_ID", $reqId);
		$set->setField("TABEL_TEMPLATE_ID", $reqTabelId);
		$set->setField("PENGUKURAN_ID", $reqPengukuranId);
		$set->setField("FORM_UJI_ID", $reqFormUjiId);

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

	function tree_formuji() 
	{	
		$reqUnitKerjaId = $this->input->get("reqUnitKerjaId");
		$reqStatus = $this->input->get("reqStatus");
		
		if($reqUnitKerjaId == "")
			$reqUnitKerjaId = $this->CABANG_ID;
		
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rows = isset($_GET['rows']) ? intval($_GET['rows']) : 50;
		$id   = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$offset = ($page-1)*$rows;
		
		$reqPencarian = trim($this->input->get("reqPencarian"));
		$reqMode = $this->input->get("reqMode");
		$reqKelompokEquipmentId = $this->input->get("reqKelompokEquipmentId");
		
		$this->load->model("base-app/FormUji");

		$formuji = new FormUji();

		$statement="";

		if(!empty($reqKelompokEquipmentId))
		{
			$statement .= " AND B.KELOMPOK_EQUIPMENT_ID IN (".$reqKelompokEquipmentId.")";
		}

		if(!empty($reqPencarian))
		{
			$statement .= " AND (UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%' OR UPPER(B.NAMA_KELOMPOK) LIKE '%".strtoupper($reqPencarian)."%') ";
		}

		
		$rowCount = $formuji->getCountFormUjiKelompokEquipment($arrStatement, $statement.$statement_privacy);
		$formuji->selectByParamsKelompokEquipment($arrStatement, $rows, $offset, $statement.$statement_privacy, " ORDER BY B.KELOMPOK_EQUIPMENT_ID  ASC ");
		// echo $formuji->query;exit;
		$i = 0;
		$items = array();
		while($formuji->nextRow())
		{
			// print_r($check);exit;
			$this->TREETABLE_COUNT++;
			
			$row['id']				= $formuji->getField("KELOMPOK_EQUIPMENT_ID")."_".$formuji->getField("FORM_UJI_ID");
			$row['parentId']		= $formuji->getField("KODE_PARENT");
			$row['text']			= $formuji->getField("NAMA_KELOMPOK");
			$row['FORM_UJI_ID']	= $formuji->getField("FORM_UJI_ID");
			$row['NAMA']			= $formuji->getField("NAMA_FORM");
			$row['NAMA_KELOMPOK']			= $formuji->getField("NAMA_KELOMPOK");
			
		
			if(trim($reqPencarian) == "")
			{
				// $row['state'] 			= $this->has_child($row['id']);
				// $row['children'] 		= $this->children_master($formuji->getField("KELOMPOK_EQUIPMENT_ID"), $reqStatus);
			}
			$i++;
			array_push($items, $row);
			unset($row);
		}

		$result["rows"] = $items;
		$result["total"] = $this->TREETABLE_COUNT;
		
		// print_r($result);exit;
		echo json_encode($result);
	}


	function has_child($id)
	{
		$this->load->model("base-app/FormUji");
		$satuan_kerja = new FormUji();
		$adaData = $satuan_kerja->getCountFormUjiKelompokEquipment(array("B.KELOMPOK_EQUIPMENT_ID" => $id));
		// echo $satuan_kerja->query;exit;
		return $adaData > 0 ? true : false;
	}

	function children_master($id, $satkerId, $reqStatus="1")
	{
		$this->load->model("base-app/FormUji");
		$satuan_kerja = new FormUji();
		
		// if($reqStatus == "1")
		// {
		// 	$arrStatement = array("COALESCE(NULLIF(KODE_PARENT, ''), '0')" => $id, "NOT SATUAN_KERJA_ID_PARENT" => "SATKER", "SATUAN_KERJA_ID_PARENT" => $satkerId, "STATUS_AKTIF" => '1');
		// }
		// else
		// 	$arrStatement = array("COALESCE(NULLIF(KODE_PARENT, ''), '0')" => $id, "NOT SATUAN_KERJA_ID_PARENT" => "SATKER", "SATUAN_KERJA_ID_PARENT" => $satkerId);

		$rowCount = $satuan_kerja->getCountFormUjiKelompokEquipment($arrStatement, $statement.$statement_privacy);
		$satuan_kerja->selectByParamsKelompokEquipment($arrStatement, $rows, $offset, $statement.$statement_privacy, " ");
		// echo $satuan_kerja->query;exit;
		$i = 0;
		$items = array();
		while($satuan_kerja->nextRow())
		{
			$check =$satuan_kerja->getField("USER_BANTU");
			$this->TREETABLE_COUNT++;
			
			$row['id']				= coalesce($satuan_kerja->getField("KODE_SO"), $satuan_kerja->getField("SATUAN_KERJA_ID"));
			$row['parentId']		= $satuan_kerja->getField("KODE_PARENT");
			$row['text']			= $satuan_kerja->getField("NAMA");
			$row['SATUAN_KERJA_ID']	= $satuan_kerja->getField("SATUAN_KERJA_ID");
			$row['SATUAN_KERJA_ID_PARENT']	= $satuan_kerja->getField("SATUAN_KERJA_ID_PARENT");
			$row['NAMA']			= $satuan_kerja->getField("NAMA");
			if(!empty($check))
			{
				$row['NAMA_SATKER']	= $satuan_kerja->getField("NAMA").' - '.' Ada User Bantu';
			}
			else
			{
				$row['NAMA_SATKER']	= $satuan_kerja->getField("NAMA");
			}
			$row['NAMA_PEGAWAI']	= $satuan_kerja->getField("NAMA_PEGAWAI");
			$row['JABATAN']			= $satuan_kerja->getField("JABATAN")." - ".$satuan_kerja->getField("SATUAN_KERJA_ID_PARENT");
			$row['JABATAN_INFO'] = $satuan_kerja->getField("JABATAN");
			$row['NIP']				= $satuan_kerja->getField("NIP");
			$row['KODE_SURAT']				= $satuan_kerja->getField("KODE_SURAT");
			$row['KELOMPOK_JABATAN']		= $satuan_kerja->getField("KELOMPOK_JABATAN");
			$row['STATUS_AKTIF']			= $satuan_kerja->getField("STATUS_AKTIF");
			$row['STATUS_AKTIF_DESC']		= $satuan_kerja->getField("STATUS_AKTIF_DESC");

			$row['MUTASI_NIP']= $satuan_kerja->getField("NIP");
			$row['MUTASI_NAMA_PEGAWAI']= $satuan_kerja->getField("NAMA_PEGAWAI");
			$row['MUTASI_NAMA']= $satuan_kerja->getField("NAMA");
			$row['MUTASI_JABATAN']= str_replace("Plh", "", str_replace("Plt", "", $satuan_kerja->getField("JABATAN")));

			$row['LINK_URL']		= $satuan_kerja->getField("LINK_URL");
			$row['LINK_URL_PEGAWAI']= $satuan_kerja->getField("LINK_URL_PEGAWAI");
			
			$state = $this->has_child($row['id']);
	
	
			$row['state'] 			= $state;
			if($state)
				$row['children'] 		= $this->children_master($satuan_kerja->getField("KODE_SO"), $satkerId, $reqStatus);
	
			$i++;
			array_push($items, $row);
			unset($row);
		}
		
		return $items;
	}



}