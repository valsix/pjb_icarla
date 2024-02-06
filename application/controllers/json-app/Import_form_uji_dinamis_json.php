<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("functions/excel_reader2.php");

class import_form_uji_dinamis_json extends CI_Controller
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


	function import_dinamis() 
	{
		$this->load->model("base-app/FormUji");

		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqTabelId = $this->input->post("reqTabelId");
		$reqId = $this->input->post("reqId");
		$reqPengukuranId = $this->input->post("reqPengukuranId");
		$reqTipePengukuranId = $this->input->post("reqTipePengukuranId");
		$reqTipeInputId = $this->input->post("reqTipeInputId");

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
		// $baris= count($data->sheets[0]["cells"]);
		// print_r($baris);exit;

		$this->load->model("base-app/Import");
		$this->load->model("base-app/TabelTemplate");

		$setbaris= new TabelTemplate();
		$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqTabelId." ";
		$setbaris->selectByParamsMaxBaris(array(), -1, -1, $statement);
		// echo $setbaris->query;exit; 
		$setbaris->firstRow();
		$maxbarisrla= $setbaris->getField("MAX");

		$set = new Import();

		$barisi=$maxbarisrla+1;
		
		$reqSimpan="";
		$index=1;
		for ($i=$barisi; $i<=$baris; $i++){
				$set = new FormUji();
				// print_r($i);
				if(empty($data->val($i,1)))
				{
					continue;
				}
				else
				{
					$set->setField("NAMA", $data->val($i,1));
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("PENGUKURAN_ID", $reqPengukuranId);
					$set->setField("TIPE_INPUT_ID", $reqTipeInputId);
					$set->setField("TABEL_TEMPLATE_ID", $reqTabelId);
					$set->setField("PENGUKURAN_TIPE_INPUT_ID", $reqTipePengukuranId);
					$set->setField("STATUS_TABLE", "TABLE");
					if($set->insertdetil())
					{
						$reqSimpan= 1;
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



}