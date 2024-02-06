<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("functions/excel_reader2.php");

class import_form_uji_json extends CI_Controller
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
	}


	function form_uji_ir_pi() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=3; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";
				$set->setField("WAKTU", $data->val($i,1));
				$set->setField("HV_GND", $data->val($i,2));
				$set->setField("LV_GND", $data->val($i,3));
				$set->setField("HV_LV", $data->val($i,4));
				$set->setField("FORM_UJI_ID", $reqId);
				$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);
				if($set->insertdetil())
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

	function form_uji_sfra_hv() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";
			$set->setField("HV_SFRA",  $data->val($i,1));
			$set->setField("HV_DL_SFRA",  $data->val($i,2));
			$set->setField("HV_NCEPRI_SFRA",  $data->val($i,3));

			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);
			$set->setField("TIPE_SFRA", 1);

			if($set->insertdetil())
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

	function form_uji_sfra_lv() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";
			$set->setField("LV_SFRA",  $data->val($i,1));
			$set->setField("LV_DL_SFRA",  $data->val($i,2));
			$set->setField("LV_NCEPRI_SFRA",  $data->val($i,3));
			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);
			$set->setField("TIPE_SFRA", 2);

			if($set->insertdetil())
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

	function form_uji_sfra_hvlv() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";
			$set->setField("HVLV_SFRA",  $data->val($i,1));
			$set->setField("HVLV_DL_SFRA", $data->val($i,2));
			$set->setField("HVLV_NCEPRI_SFRA", $data->val($i,3));
			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);
			$set->setField("TIPE_SFRA", 3);

			if($set->insertdetil())
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

	function form_uji_sfra_hv_short() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";
			$set->setField("HV_SHORT_SFRA", $data->val($i,1));
			$set->setField("HV_SHORT_DL_SFRA", $data->val($i,2));
			$set->setField("HV_SHORT_NCEPRI_SFRA", $data->val($i,3));
			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);
			$set->setField("TIPE_SFRA", 4);

			if($set->insertdetil())
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

	function form_uji_sfra_hvlv_groud() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";
			$set->setField("HVLV_GROUND_SFRA", $data->val($i,1));
			$set->setField("HVLV_GROUND_DL_SFRA", $data->val($i,2));
			$set->setField("HVLV_GROUND_NCEPRI_SFRA", $data->val($i,3));

			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);
			$set->setField("TIPE_SFRA", 5);

			if($set->insertdetil())
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

	function form_uji_tandelta_winding() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		// $set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";
			if(empty($data->val($i,1)))
			{
				continue;
			}
			else
			{
				$set->setField("WINDING_TAN", $data->val($i,1));
				$set->setField("MEASURE_TAN_CH_CHL", $data->val($i,2));
				$set->setField("TEST_TAN_CH_CHL", $data->val($i,3));
				$set->setField("ARUS_TAN_CH_CHL", $data->val($i,4));
				$set->setField("DAYA_TAN_CH_CHL", $data->val($i,5));
				$set->setField("PF_CORR_TAN_CH_CHL", $data->val($i,6));
				$set->setField("CORR_FACT_TAN_CH_CHL", $data->val($i,7));
				$set->setField("CAP_TAN_CH_CHL",$data->val($i,8));

				$set->setField("MEASURE_TAN_CH", $data->val($i+1,2));
				$set->setField("TEST_TAN_CH", $data->val($i+1,3));
				$set->setField("ARUS_TAN_CH", $data->val($i+1,4));
				$set->setField("DAYA_TAN_CH", $data->val($i+1,5));
				$set->setField("PF_CORR_TAN_CH", $data->val($i+1,6));
				$set->setField("CORR_FACT_TAN_CH", $data->val($i+1,7));
				$set->setField("CAP_TAN_CH", $data->val($i+1,8));

				$set->setField("MEASURE_TAN_CHL_UST", $data->val($i+2,2));
				$set->setField("TEST_TAN_CHL_UST", $data->val($i+2,3));
				$set->setField("ARUS_TAN_CHL_UST", $data->val($i+2,4));
				$set->setField("DAYA_TAN_CHL_UST",$data->val($i+2,5));
				$set->setField("PF_CORR_TAN_CHL_UST", $data->val($i+2,6));
				$set->setField("CORR_FACT_TAN_CHL_UST", $data->val($i+2,7));
				$set->setField("CAP_TAN_CHL_UST", $data->val($i+2,8));

				$set->setField("MEASURE_TAN_CHL", $data->val($i+3,2));
				$set->setField("TEST_TAN_CHL", $data->val($i+3,3));
				$set->setField("ARUS_TAN_CHL", $data->val($i+3,4));
				$set->setField("DAYA_TAN_CHL",$data->val($i+3,5));
				$set->setField("PF_CORR_TAN_CHL", $data->val($i+3,6));
				$set->setField("CORR_FACT_TAN_CHL", $data->val($i+3,7));
				$set->setField("CAP_TAN_CHL", $data->val($i+3,8));
			}

			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);
			$set->setField("TIPE_TAN", 1);

			if($set->insertdetil())
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

	function form_uji_tandelta_winding_without() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";


			$set->setField("WINDING_WITHOUT_TAN_1", $data->val($i,1));
			$set->setField("WINDING_WITHOUT_TAN_2", $data->val($i,2));
			$set->setField("WINDING_WITHOUT_TAN_3", $data->val($i,3));
			$set->setField("WINDING_WITHOUT_TAN_4", $data->val($i,4));
			$set->setField("WINDING_WITHOUT_TAN_5", $data->val($i,5));
			$set->setField("WINDING_WITHOUT_TAN_6", $data->val($i,6));
			$set->setField("WINDING_WITHOUT_TAN_7", $data->val($i,7));
			$set->setField("WINDING_WITHOUT_TAN_8", $data->val($i,8));

			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", 6);
			$set->setField("TIPE_TAN", 2);

			if($set->insertdetil())
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

	function form_uji_tandelta_ref() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";


			$set->setField("CONDITION_TAN",  $data->val($i,1));
			$set->setField("GOOD_TAN", $data->val($i,2));
			$set->setField("MAYBE_TAN", $data->val($i,3));
			$set->setField("INVESTIGATED_TAN", $data->val($i,4));

			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", 6);
			$set->setField("TIPE_TAN", 3);

			if($set->insertdetil())
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

	function form_uji_hcb() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";

			$set->setField("BUSHING",  $data->val($i,1));
			$set->setField("SKIRT",  $data->val($i,2));
			$set->setField("TEGANGAN",  $data->val($i,3));
			$set->setField("IMA",  $data->val($i,4));
			$set->setField("WATTS", $data->val($i,5));

			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", 7);

			if($set->insertdetil())
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

	function form_uji_ex_curr() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=4; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";

			$set->setField("TAP", $data->val($i,1));
			$set->setField("TEGANGAN_EC", $data->val($i,2));
			$set->setField("IMA_RT", $data->val($i,3));
			$set->setField("WATTS_RT", $data->val($i,4));
			$set->setField("LC_RT", $data->val($i,5));

			$set->setField("IMA_SR", $data->val($i,6));
			$set->setField("WATTS_SR", $data->val($i,7));
			$set->setField("LC_SR", $data->val($i,8));

			$set->setField("IMA_TS", $data->val($i,9));
			$set->setField("WATTS_TS", $data->val($i,10));
			$set->setField("LC_TS", $data->val($i,11));

			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", 8);

			if($set->insertdetil())
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

	function form_uji_rdc() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";

			if(empty($data->val($i,1)) && empty($data->val($i,2)))
			{
				continue;
			}
			else
			{
				$set->setField("SISI_RDC", $data->val($i,1));
				$set->setField("TAP_RDC", $data->val($i,2));

				$set->setField("FASA_RDC_R", $data->val($i,3));
				$set->setField("ARUS_RDC_R", $data->val($i,4));
				$set->setField("TEGANGAN_RDC_R", $data->val($i,5));
				$set->setField("TAHANAN_RDC_R", $data->val($i,6));
				$set->setField("TAHANAN_TEMP_RDC_R", $data->val($i,7));
				$set->setField("DEV_RDC_R", $data->val($i,8));

				$set->setField("FASA_RDC_S", $data->val($i+1,3));
				$set->setField("ARUS_RDC_S", $data->val($i+1,4));
				$set->setField("TEGANGAN_RDC_S", $data->val($i+1,5));
				$set->setField("TAHANAN_RDC_S", $data->val($i+1,6));
				$set->setField("TAHANAN_TEMP_RDC_S", $data->val($i+1,7));
				$set->setField("DEV_RDC_S", $data->val($i+1,8));

				$set->setField("FASA_RDC_T", $data->val($i+2,3));
				$set->setField("ARUS_RDC_T", $data->val($i+2,4));
				$set->setField("TEGANGAN_RDC_T", $data->val($i+2,5));
				$set->setField("TAHANAN_RDC_T",$data->val($i+2,6));
				$set->setField("TAHANAN_TEMP_RDC_T", $data->val($i+2,7));
				$set->setField("DEV_RDC_T", $data->val($i+2,8));
			}

			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", 9);

			if($set->insertdetil())
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

	function form_uji_ratio() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTipeId = $this->input->post("reqTipeId");
		$reqId = $this->input->post("reqId");

		if(empty($tipefile))
		{
			echo "xxx***Pilih file terlebih dahulu";exit;
		}
		else
		{
			if($acceptable !== $tipefile) {
				echo "xxx***File gagal diupload, Pastikan File berformat XLS";exit;
			}
		}
		
		$data = new Spreadsheet_Excel_Reader($_FILES['reqLinkFile']['tmp_name']);

		$baris = $data->rowcount($sheet_index=0);

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			$set = new FormUji();
			// $reqSimpan="";

			$set->setField("FASA_RATIO", $data->val($i,1));
			$set->setField("TAP_RATIO", $data->val($i,2));
			$set->setField("HV_KV", $data->val($i,3));
			$set->setField("LV_KV", $data->val($i,4));
			$set->setField("RASIO_TEGANGAN", $data->val($i,5));
			$set->setField("HV_V", $data->val($i,6));
			$set->setField("DERAJAT_HV_V",  $data->val($i,7));
			$set->setField("LV_V", $data->val($i,8));
			$set->setField("DERAJAT_LV_V",  $data->val($i,9));
			$set->setField("RASIO_HASIL",  $data->val($i,10));
			$set->setField("DEVIASI", $data->val($i,11));

			$set->setField("FORM_UJI_ID", $reqId);
			$set->setField("FORM_UJI_TIPE_ID", 10);

			if($set->insertdetil())
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





}