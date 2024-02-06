<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Site_visit_json extends CI_Controller
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
		$this->load->model("base-app/SiteVisit");

		$set= new SiteVisit();

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
			// $searchJson= " 
			// AND 
			// (
			// 	UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
			// 	OR UPPER(A.NAMA) LIKE '%".strtoupper($reqPencarian)."%'
			// )";
		}

		$sOrder = " ORDER BY A.SITE_VISIT_ID ASC ";
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
					$row[$valkey]= $set->getField("TANGGAL_DISPOSISI");
				}
				else if ($valkey == "GENERAL_TANGGAL_SITE" || $valkey == "KOMPARASI_START_DATE"  || $valkey == "KOMPARASI_FINISH_DATE")
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
		$this->load->model("base-app/SiteVisit");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqSektor= $this->input->post("reqSektor");
		$reqDistrik= $this->input->post("reqDistrik");
		$reqDistrikId= $this->input->post("reqDistrikId");
		$reqReport= $this->input->post("reqReport");
		$reqTanggalSite= $this->input->post("reqTanggalSite");
		$reqName= $this->input->post("reqName");
		$reqDrawing= $this->input->post("reqDrawing");
		$reqGangguan= $this->input->post("reqGangguan");
		$reqDokRef= $this->input->post("reqDokRef");
		$reqKronologiFile = $_FILES['reqKronologiFile']['name'];

		$reqWaitingTime= $this->input->post("reqWaitingTime");
		$reqSiteInvestigation= $this->input->post("reqSiteInvestigation");
		$reqDokumenRef= $this->input->post("reqDokumenRef");
		$reqSiteFile = $_FILES['reqSiteFile']['name'];

		$reqInvestigationTime= $this->input->post("reqInvestigationTime");
		$reqAnalisa= $this->input->post("reqAnalisa");
		$reqAnalisaTime= $this->input->post("reqAnalisaTime");
		$reqDeskripsi= $this->input->post("reqDeskripsi");
		$reqExecutionTime= $this->input->post("reqExecutionTime");
		$reqPostMaintenanceTesting= $this->input->post("reqPostMaintenanceTesting");
		$reqDokumentasi= $this->input->post("reqDokumentasi");
		$reqMaintenanceFile = $_FILES['reqMaintenanceFile']['name'];

		$reqPostMaintenanceTime= $this->input->post("reqPostMaintenanceTime");
		$reqStandartPengujian= $this->input->post("reqStandartPengujian");
		$reqWrenchTime= $this->input->post("reqWrenchTime");
		$reqTotalDownTime= $this->input->post("reqTotalDownTime");
		$reqStartDate= $this->input->post("reqStartDate");
		$reqFinishDate= $this->input->post("reqFinishDate");
		$reqKesimpulan= $this->input->post("reqKesimpulan");
		$reqLessonLearned= $this->input->post("reqLessonLearned");
		$reqPemeriksaId= $this->input->post("reqPemeriksaId");

		$reqTaskDeskripsi= $this->input->post("reqTaskDeskripsi");
		$reqTaskMaterial= $this->input->post("reqTaskMaterial");
		$reqTaskTools= $this->input->post("reqTaskTools");
		$reqTaskResource= $this->input->post("reqTaskResource");

		$reqMaintenanceTools= $this->input->post("reqMaintenanceTools");

		$reqParameter= $this->input->post("reqParameter");
		$reqSatuan= $this->input->post("reqSatuan");
		$reqSebelum= $this->input->post("reqSebelum");
		$reqSesudah= $this->input->post("reqSesudah");

		$reqPersonalNid= $this->input->post("reqPersonalNid");
		$reqPersonalNama= $this->input->post("reqPersonalNama");
		$reqPersonalUnit= $this->input->post("reqPersonalUnit");

		
		$set = new SiteVisit();
		$set->setField("GENERAL_SEKTOR", $reqSektor);
		$set->setField("DISTRIK_ID", ValToNullDB($reqDistrikId));
		$set->setField("GENERAL_REPORT", $reqReport);
		$set->setField("GENERAL_TANGGAL_SITE", dateToDBCheck($reqTanggalSite));
		$set->setField("GENERAL_NAME", $reqName);
		$set->setField("GENERAL_DRAWING", $reqDrawing);

		$set->setField("KRONOLOGI_GANGGUAN", setQuote($reqGangguan, ""));
		$set->setField("KRONOLOGI_DOKUMEN", $reqDokRef);
		$set->setField("KRONOLOGI_WAITING_TIME", ValToNullDB($reqWaitingTime));

		$set->setField("SITE_INVESTIGATION", $reqSiteInvestigation);
		$set->setField("SITE_DOKUMEN_REVERENCE", $reqDokumenRef);
		$set->setField("SITE_INVESTIGATION_TIME", ValToNullDB($reqInvestigationTime));

		$set->setField("ANALISA", $reqAnalisa);
		$set->setField("ANALISA_TIME", ValToNullDB($reqAnalisaTime));

		$set->setField("TASK_DESCRIPTION", $reqDeskripsi);
		$set->setField("TASK_EXECUTION_TIME", ValToNullDB($reqExecutionTime));

		$set->setField("MAINTENANCE_POST", $reqPostMaintenanceTesting);
		$set->setField("MAINTENANCE_DOKUMENTASI", $reqDokumentasi);
		$set->setField("MAINTENANCE_POST_TIME", ValToNullDB($reqPostMaintenanceTime));
		$set->setField("MAINTENANCE_STANDART", $reqStandartPengujian);

		$set->setField("KOMPARASI_WRENCH_TIME", ValToNullDB($reqWrenchTime));
		$set->setField("KOMPARASI_TOTAL_DOWN_TIME", ValToNullDB($reqTotalDownTime));
		$set->setField("KOMPARASI_START_DATE", dateToDBCheck($reqStartDate));
		$set->setField("KOMPARASI_FINISH_DATE", dateToDBCheck($reqFinishDate));

		$set->setField("KESIMPULAN_REKOMEN", $reqKesimpulan);
		$set->setField("KESIMPULAN_LESSON", $reqLessonLearned);

		$set->setField("PEMERIKSA_ID", ValToNullDB($reqPemeriksaId));

		$set->setField("SITE_VISIT_ID", $reqId);

		$reqSimpan= "";
		if ($reqMode == "insert")
		{
			$set->setField("LAST_CREATE_USER", $this->adminusernama);
			$set->setField("LAST_CREATE_DATE", 'SYSDATE');
			if($set->insert())
			{
				$reqId= $set->id;
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

		if($reqSimpan==1)
		{
			if(!empty($reqTaskDeskripsi))
			{
				$set = new SiteVisit();
				$reqSimpan="";
				$set->setField("SITE_VISIT_ID", $reqId);
				$set->deletetask();
				foreach ($reqTaskDeskripsi as $key => $value) {
					$set->setField("DESKRIPSI", $value);
					$set->setField("MATERIAL", $reqTaskMaterial[$key]);
					$set->setField("TOOLS", $reqTaskTools[$key]);
					$set->setField("RESOURCE", $reqTaskResource[$key]);
					if($set->inserttask())
					{
						$reqSimpan= 1;
					}
				}
			}

			if(!empty($reqMaintenanceTools))
			{
				$set = new SiteVisit();
				$reqSimpan="";
				$set->setField("SITE_VISIT_ID", $reqId);
				$set->deletemaintenance();
				foreach ($reqMaintenanceTools as $key => $value) {
					$set->setField("TOOLS", $value);
					if($set->insertmaintenance())
					{
						$reqSimpan= 1;
					}
				}
			}

			if(!empty($reqParameter))
			{
				$set = new SiteVisit();
				$reqSimpan="";
				$set->setField("SITE_VISIT_ID", $reqId);
				$set->deletekomparasi();
				foreach ($reqParameter as $key => $value) {
					$set->setField("PARAMETER", $value);
					$set->setField("SATUAN", $reqSatuan[$key]);
					$set->setField("SEBELUM", $reqSebelum[$key]);
					$set->setField("SESUDAH", $reqSesudah[$key]);
					if($set->insertkomparasi())
					{
						$reqSimpan= 1;
					}
				}
			}

			if(!empty($reqPersonalNid))
			{
				$set = new SiteVisit();
				$reqSimpan="";
				$set->setField("SITE_VISIT_ID", $reqId);
				$set->deletepersonal();
				foreach ($reqPersonalNid as $key => $value) {
					$set->setField("NID", $value);
					$set->setField("NAMA", $reqPersonalNama[$key]);
					$set->setField("UNIT", $reqPersonalUnit[$key]);
					if($set->insertpersonal())
					{
						$reqSimpan= 1;
					}
				}
			}

			if(!empty($reqKronologiFile))
			{
				$reqSimpan="";
				$linkupload="uploads/sitevisit/kronologi/";
				if (!is_dir($linkupload)) {
					makedirs($linkupload);
				}
				$reqLinkFileKronologi=$_FILES['reqKronologiFile']['tmp_name'];
				$namefile= $linkupload.$reqKronologiFile;
				if(move_uploaded_file($reqLinkFileKronologi, $namefile))
				{
					$set = new SiteVisit();
					$reqSimpan="";
					$set->setField("SITE_VISIT_ID", $reqId);
					$set->setField("KRONOLOGI_ATTACH_FILE", $namefile);
					$field="KRONOLOGI_ATTACH_FILE";
					if($set->updateupload($field))
					{
						$reqSimpan= 1;
					}
					
				}
				
			}

			if(!empty($reqSiteFile))
			{
				$reqSimpan="";
				$linkupload="uploads/sitevisit/site/";
				if (!is_dir($linkupload)) {
					makedirs($linkupload);
				}
				$reqLinkFile=$_FILES['reqSiteFile']['tmp_name'];
				$namefile= $linkupload.$reqSiteFile;
				if(move_uploaded_file($reqLinkFile, $namefile))
				{
					$set = new SiteVisit();
					$reqSimpan="";
					$set->setField("SITE_VISIT_ID", $reqId);
					$set->setField("SITE_ATTACH_FILE", $namefile);
					$field="SITE_ATTACH_FILE";
					if($set->updateupload($field))
					{
						$reqSimpan= 1;
					}
				}
			}

			if(!empty($reqMaintenanceFile))
			{
				$reqSimpan="";
				$linkupload="uploads/sitevisit/maintenance/";
				if (!is_dir($linkupload)) {
					makedirs($linkupload);
				}
				$reqLinkFile=$_FILES['reqMaintenanceFile']['tmp_name'];
				$namefile= $linkupload.$reqMaintenanceFile;
				if(move_uploaded_file($reqLinkFile, $namefile))
				{
					$set = new SiteVisit();
					$reqSimpan="";
					$set->setField("SITE_VISIT_ID", $reqId);
					$set->setField("MAINTENANCE_ATTACH_FILE", $namefile);
					$field="MAINTENANCE_ATTACH_FILE";
					if($set->updateupload($field))
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
		$this->load->model("base-app/SiteVisit");
		$set = new SiteVisit();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("SITE_VISIT_ID", $reqId);

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
		$this->load->model("base-app/SiteVisit");
		$set = new SiteVisit();
		
		$reqId =  $this->input->get('reqId');
		$reqForm =  $this->input->get('reqForm');
		$reqSimpan="";
		if($reqForm=="task")
		{
			$set->setField("SITE_VISIT_TASK_ID", $reqId);
			if($set->deletetaskdetail())
			{
				$reqSimpan=1;
			}

		}
		elseif($reqForm=="maintenance")
		{
			$set->setField("SITE_VISIT_MAINTENANCE_ID", $reqId);
			if($set->deletemaintenancedetail())
			{
				$reqSimpan=1;
			}
		}
		elseif($reqForm=="komparasi")
		{
			$set->setField("SITE_VISIT_KOMPARASI_ID", $reqId);
			if($set->deletekomparasidetail())
			{
				$reqSimpan=1;
			}
		}
		elseif($reqForm=="personal")
		{
			$set->setField("SITE_VISIT_PERSONAL_ID", $reqId);
			if($set->deletepersonaldetail())
			{
				$reqSimpan=1;
			}
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