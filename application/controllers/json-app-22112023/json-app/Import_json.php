<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("functions/excel_reader2.php");

class Import_json extends CI_Controller
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


	function distrik() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		// print_r($baris);exit;

		$arrField= array("NAMA","KODE_DISTRIK","KODE_PERUSAHAAN");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau baris ke 2 kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;

			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE_DISTRIK")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqDistrikId=$check->getField("DISTRIK_ID");
						$reqKodeDistrik=$check->getField("KODE");
						unset($check);

						if(empty($reqDistrikId))
						{
							$set->setField("KODE",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Distrik Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="KODE_PERUSAHAAN")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckPerusahaanExternal(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqPerusahaanId=$check->getField("PERUSAHAAN_EKSTERNAL_ID");
						$reqKodePerusahaan=$check->getField("KODE");
						unset($check);
						if(empty($reqPerusahaanId))
						{
							echo "xxx***Kode Perusahaan ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("PERUSAHAAN_EKSTERNAL_ID",$reqPerusahaanId);
						}
					}
					else
					{
						echo "xxx***Kode Perusahaan Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqDistrikId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("DISTRIK_ID",$reqDistrikId);			
				if($set->updatedistrik())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertdistrik())
				{
					$reqSimpan = 1;
					
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

	function perusahaan_eksternal() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("NAMA","KODE");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckPerusahaanExternal(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqPerusahaanId=$check->getField("PERUSAHAAN_EKSTERNAL_ID");
						unset($check);

						if(empty($reqPerusahaanId))
						{
							$set->setField("KODE",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Perusahaan baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqPerusahaanId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("PERUSAHAAN_EKSTERNAL_ID",$reqPerusahaanId);			
				if($set->updateperusahaaneksternal())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertperusahaaneksternal())
				{
					$reqSimpan = 1;
					
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

	function unit() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("KODE_DISTRIK","KODE_BLOK","KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE_DISTRIK")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqDistrikId=$check->getField("DISTRIK_ID");
						$reqKodeDistrik=$check->getField("KODE");
						unset($check);
						if(empty($reqDistrikId))
						{
							echo "xxx***Kode Distrik ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("DISTRIK_ID",$reqDistrikId);
						}

					}
					else
					{
						echo "xxx***Kode Distrik baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="KODE_BLOK")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqBlokId=$check->getField("BLOK_ID");
						$reqKodeBlok=$check->getField("KODE");
						unset($check);

						if(empty($reqBlokId))
						{
							echo "xxx***Kode Blok ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("BLOK_ID",$reqBlokId);
						}
					}
					else
					{
						echo "xxx***Kode Blok baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckUnit(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("UNIT_ID");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("KODE",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Unit baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("UNIT_ID",$reqId);			
				if($set->updateunit())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertunit())
				{
					$reqSimpan = 1;
					
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

	function enjiniring_unit() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("KODE","NAMA","STATUS");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckEnjiniringUnit(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("ENJINIRINGUNIT_ID");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("KODE",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Enjiniring Unit baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("ENJINIRINGUNIT_ID",$reqId);			
				if($set->updateenjiniringunit())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertenjiniringunit())
				{
					$reqSimpan = 1;
					
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

	function form_uji() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckFormUji(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("FORM_UJI_ID");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("KODE",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Form Uji baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("FORM_UJI_ID",$reqId);			
				if($set->updateformuji())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertformuji())
				{
					$reqSimpan = 1;
					
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

	function manufaktur() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("KODE","NAMA","STATUS");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckManufaktur(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("MANUFAKTUR_ID");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("KODE",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Manufaktur baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			// if (!empty($reqId))
			// {	
			// 	$set->setField("LAST_UPDATE_DATE", "NOW()");
			// 	$set->setField("LAST_UPDATE_USER", $this->appusernama);
			// 	$set->setField("MANUFAKTUR_ID",$reqId);			
			// 	if($set->updatemanufaktur())
			// 	{
			// 		$reqSimpan = 1;
					
			// 	}
			// }
			// else
			// {
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertmanufaktur())
				{
					$reqSimpan = 1;
					
				}
			// }
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

	function uom() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("NAMA","FUNCTION_INPUT","KETERANGAN");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="NAMA")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.NAMA LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsUom(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("UOM_ID");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("NAMA",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Uom baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("UOM_ID",$reqId);			
				if($set->updateuom())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertuom())
				{
					$reqSimpan = 1;
					
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

	function measuring_tools() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsMeasuringTools(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("MEASURING_TOOLS_ID");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("KODE",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Measuring Tools baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("MEASURING_TOOLS_ID",$reqId);			
				if($set->updatemeasuringtools())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertmeasuringtools())
				{
					$reqSimpan = 1;
					
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

	function jenis_pengukuran() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("KODE","KODE_UJI","NAMA","REFERENSI","CATATAN");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsJenisPengukuran(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("JENIS_PENGUKURAN_ID");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("KODE",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Jenis Pengukuran baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="KODE_UJI")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckFormUji(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqFormId=$check->getField("FORM_UJI_ID");
						unset($check);
						if(empty($reqFormId))
						{
							echo "xxx***Kode Form Uji ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("FORM_UJI_ID",$reqFormId);
						}
					}
					else
					{
						echo "xxx***Kode Form Uji Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("JENIS_PENGUKURAN_ID",$reqId);			
				if($set->updatejenispengukuran())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertjenispengukuran())
				{
					$reqSimpan = 1;
					
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

	function eam() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("NAMA","KETERANGAN","URL");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="NAMA")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.NAMA = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsEam(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("EAM_ID");
						$reqNamaEam =$check->getField("NAMA");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("NAMA",$tempValue);
						}
						else
						{
							$set->setField("NAMA",$reqNamaEam);
						}
					}
					else
					{
						echo "xxx***Kode Eam baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("EAM_ID",$reqId);			
				if($set->updateeam())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->inserteam())
				{
					$reqSimpan = 1;
					
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

	function komentar() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="NAMA")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.NAMA LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsKomentar(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("KOMENTAR_ID");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("NAMA",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Komentar baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("KOMENTAR_ID",$reqId);			
				if($set->updatekomentar())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertkomentar())
				{
					$reqSimpan = 1;
					
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

	function blok() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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
		// print_r($baris);exit;

		$arrField= array("KODE_DISTRIK","KODE","NAMA","JENIS_ENTERPRISE");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE_DISTRIK")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqDistrikId=$check->getField("DISTRIK_ID");
						unset($check);

						if(empty($reqDistrikId))
						{
							echo "xxx***Kode Distrik ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("DISTRIK_ID",$reqDistrikId);
						}
					}
					else
					{
						echo "xxx***Kode Distrik baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckBlok(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("BLOK_ID");
						unset($check);
						if(empty($reqId))
						{
							$set->setField("KODE",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Komentar baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="JENIS_ENTERPRISE")
				{
					if (!empty($tempValue) && is_numeric($tempValue))
					{
						$statement =" AND A.EAM_ID = ".$tempValue."";
						$check = new Import();
						$check->selectByParamsEam(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqEamId=$check->getField("EAM_ID");
						unset($check);
						if(empty($reqEamId))
						{
							echo "xxx***Kode Eam ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("JENIS_ENTERPRISE",$reqEamId);
						}
					}
					else
					{
						$set->setField("JENIS_ENTERPRISE",ValToNullDB($tempValue));
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			// if (!empty($reqId))
			// {	
			// 	$set->setField("LAST_UPDATE_DATE", "NOW()");
			// 	$set->setField("LAST_UPDATE_USER", $this->appusernama);
			// 	$set->setField("BLOK_ID",$reqId);			
			// 	if($set->updateblok())
			// 	{
			// 		$reqSimpan = 1;
					
			// 	}
			// }
			// else
			// {
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertblok())
				{
					$reqSimpan = 1;
					
				}
			// }
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

	function state() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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
		// print_r($baris);exit;

		$arrField= array("NAMA","TIPE_INPUT_ID");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="TIPE_INPUT_ID")
				{
					if (!empty($tempValue) && is_numeric($tempValue))
					{
						$statement =" AND A.TIPE_INPUT_ID = ".$tempValue."";
						$check = new Import();
						$check->selectByParamsCheckTipe(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqTipeInputId=$check->getField("TIPE_INPUT_ID");
						unset($check);
						if(empty($reqTipeInputId))
						{
							echo "xxx***Kode Tipe Input ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("TIPE_INPUT_ID",$reqTipeInputId);
						}
					}
					else
					{
						$set->setField("TIPE_INPUT_ID",ValToNullDB($tempValue));
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("STATE_ID",$reqId);			
				if($set->updatestate())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertstate())
				{
					$reqSimpan = 1;
					
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

	function group_state() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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
		// print_r($baris);exit;

		$arrField= array("NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="NAMA")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.NAMA = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckGroupState(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("GROUP_STATE_ID");
						unset($check);
		
						$set->setField("NAMA",$tempValue);
						
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("GROUP_STATE_ID",$reqId);			
				if($set->updategroupstate())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertgroupstate())
				{
					$reqSimpan = 1;
					$reqId=$set->id;
					
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

	function group_state_detail() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqId = $this->input->post("reqId");
		// print_r($reqId);exit;


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
		// print_r($baris);exit;

		$arrField= array("STATE_ID","TIPE_ID","INDEX");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="STATE_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.STATE_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckState(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqStateId=$check->getField("STATE_ID");
						unset($check);
						if(empty($reqStateId))
						{
							echo "xxx***State Id ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("STATE_ID",ValToNullDB($reqStateId));
						}
						
					}
					else
					{
						echo "xxx***State Id baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="TIPE_ID")
				{
					if (!empty($tempValue))
					{
						if($tempValue==1 || $tempValue==2)
						{	
							$set->setField("TIPE",$tempValue);
						}
						else 
						{
							echo "xxx***Tipe Id ".$tempValue." tidak ditemukan";
							exit();
						}
						
					}
					else
					{
						echo "xxx***Tipe Id baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="INDEX")
				{
					if(is_numeric($tempValue) && !empty($tempValue))
					{
						$statement =" AND A.URUT = '".$tempValue."' AND A.GROUP_STATE_ID ='".$reqId."'";
						$check = new Import();
						$check->selectByParamsCheckGroupStateDetail(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqGroupId=$check->getField("GROUP_STATE_DETAIL_ID");
						$reqUrut=$check->getField("URUT");
						unset($check);
						if (!empty($reqUrut))
						{
							echo "xxx***INDEX ke ".$tempValue." sudah ada";
							exit();
						}
						else
						{
							$set->setField("URUT",ValToNullDB($tempValue));
						}

					}
					else
					{
						echo "xxx***INDEX baris ke ".$baris." Belum Diisi atau pastikan kolom index berformat numeric";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqGroupId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("GROUP_STATE_DETAIL_ID",$reqGroupId);
				$set->setField("GROUP_STATE_ID",$reqId);			
				if($set->updateGroupStateDetail())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				$set->setField("GROUP_STATE_ID",$reqId);		
				if($set->insertGroupStateDetail())
				{
					$reqSimpan = 1;
					
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


	function tipe_input() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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
		// print_r($baris);exit;

		$arrField= array("NAMA","FUNCTION_INPUT","KETERANGAN","TIPE_PENGUKURAN_ID");

		$this->load->model("base-app/Import");

		$set = new Import();

		$arrtipe=[];
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="TIPE_PENGUKURAN_ID")
				{
					if (!empty($tempValue))
					{
						$tempValue = str_replace(".", ",", $tempValue);
						$searchForValue = ',';
						$stringValue = $tempValue;
						if( strpos($stringValue, $searchForValue) !== false ) {
							$arrtipe=explode(",", $stringValue);

						}
						else
						{
							$statement =" AND A.TIPE_PENGUKURAN_ID = ".$tempValue."";
							$check = new Import();
							$check->selectByParamsCheckTipePengukuran(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$check->firstRow();
							$reqTipePengukuranId=$check->getField("TIPE_PENGUKURAN_ID");
							unset($check);
							if(empty($reqTipePengukuranId))
							{
								echo "xxx***Kode Tipe Pengukuran ".$tempValue." tidak ditemukan";
								exit();
							}
							else
							{
								$set->setField("TIPE_PENGUKURAN_ID",$reqTipePengukuranId);
							}
							// echo "b";exit;
						}
						
					}
					else
					{
						$set->setField("TIPE_PENGUKURAN_ID",ValToNullDB($tempValue));
					}
				}
				else if($arrField[$row]=="NAMA")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.NAMA = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckTipe(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("TIPE_INPUT_ID");
						$reqNamaTipe=$check->getField("NAMA");
						unset($check);
						if(empty($reqId))
						{
							$set->setField("NAMA",$tempValue);
						}
						else
						{
							$set->setField("NAMA",$reqNamaTipe);
						}
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if(!empty($arrtipe))
			{
				foreach ($arrtipe as $key => $value) {
					$statement =" AND A.TIPE_PENGUKURAN_ID = ".$value."";
					$check = new Import();
					$check->selectByParamsCheckTipePengukuran(array(), -1, -1, $statement);
							// echo $check->query;exit;
					$check->firstRow();
					$reqTipePengukuranId=$check->getField("TIPE_PENGUKURAN_ID");
					unset($check);
					if(empty($reqTipePengukuranId))
					{
						echo "xxx***Kode Tipe Pengukuran ".$value." tidak ditemukan";
						exit();
					}

				}
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("TIPE_INPUT_ID",$reqId);			
				if($set->updatetipeinput())
				{
					$reqSimpan = 1;
					if($set->deletetipeinputdetail())
					{
						if($set->inserttipeinputdetail())
						{
							$reqSimpan = 1;
						}
					}
					
				}
			}
			else
			{

				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->inserttipeinput())
				{
					$reqSimpan = 1;
					$reqTipeInputId=$set->id;
					$set->setField("TIPE_INPUT_ID",$reqTipeInputId);
					
					if(!empty($arrtipe))
					{
						foreach ($arrtipe as $key => $value) {

							$set->setField("TIPE_PENGUKURAN_ID",$value);
							if($set->inserttipeinputdetail())
							{
								$reqSimpan = 1;

							}
						}
					}
					else
					{
						if($set->inserttipeinputdetail())
						{
							$reqSimpan = 1;

						}
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

	function user_eksternal() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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
		// print_r($baris);exit;

		$arrField= array("NID","NAMA","NO_TELP","EMAIL","DISTRIK_ID","POSITION_ID","ROLE_ID","PERUSAHAAN_EKSTERNAL_ID","EXPIRED_DATE");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="NID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.NID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckPenggunaEksternal(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("PENGGUNA_EXTERNAL_ID");
						$reqNid=$check->getField("NID");
						unset($check);
						if(empty($reqId))
						{
							$set->setField("NID",$tempValue);
						}
						else
						{
							$set->setField("NID",$reqNid);
						}
						$set->setField("NID",$reqNid);
					}
					else
					{
						echo "xxx***NID baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="NO_TELP")
				{
					if (is_numeric($tempValue))
					{
						$set->setField("NO_TELP",$tempValue);
					}
					else
					{
						echo "xxx***No telp baris ke ".$baris." harus berformat numeric";
						exit();
					}
				}
				else if($arrField[$row]=="POSITION_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.POSITION_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckMasterJabatan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqPositionId=$check->getField("POSITION_ID");
						unset($check);
						if(empty($reqPositionId))
						{
							echo "xxx***Id Jabatan ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("POSITION_ID",$reqPositionId);
						}
					}
					else
					{
						$set->setField("POSITION_ID",ValToNullDB($reqPositionId));
					}
				}
				else if($arrField[$row]=="ROLE_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.ROLE_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckRole(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqRoleId=$check->getField("ROLE_ID");
						unset($check);
						if(empty($reqRoleId))
						{
							echo "xxx***Id Role ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("ROLE_ID",$reqRoleId);
						}
					}
				}
				else if($arrField[$row]=="PERUSAHAAN_EKSTERNAL_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.PERUSAHAAN_EKSTERNAL_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckPerusahaanExternal(array(), -1, -1, $statement);
							// echo $check->query;exit;
						$check->firstRow();
						$reqPerusahaanId=$check->getField("PERUSAHAAN_EKSTERNAL_ID");
						unset($check);
						if(empty($reqPerusahaanId))
						{
							echo "xxx***Id Perusahaan ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("PERUSAHAAN_EKSTERNAL_ID",$reqPerusahaanId);
						}
					}
					else
					{
						$set->setField("PERUSAHAAN_EKSTERNAL_ID",ValToNullDB($reqPerusahaanId));
					}
				}
				else if($arrField[$row]=="EXPIRED_DATE")
				{

					if (!empty($tempValue))
					{
						$tempValue = date("d-m-Y", strtotime($tempValue));
						// print_r($tempValue);exit;

						$set->setField("EXPIRED_DATE",dateToDBCheck($tempValue));
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("PENGGUNA_EXTERNAL_ID",$reqId);			
				if($set->updatepenggunaeksternal())
				{
					$reqSimpan = 1;
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				$set->setField("PASSWORD", md5("admin"));
				if($set->insertpenggunaeksternal())
				{
					$reqSimpan = 1;
					// $reqTipeInputId=$set->id;
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

	function user_internal() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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
		// print_r($baris);exit;

		$arrField= array("NID","NAMA","NO_TELP","EMAIL","DISTRIK_ID","POSITION_ID","ROLE_ID","PERUSAHAAN_EKSTERNAL_ID","EXPIRED_DATE");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="NID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.NID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckPenggunaEksternal(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("PENGGUNA_INTERNAL_ID");
						$reqNid=$check->getField("NID");
						unset($check);
						if(empty($reqId))
						{
							$set->setField("NID",$tempValue);
						}
						else
						{
							$set->setField("NID",$reqNid);
						}
						// else
						// {
						// 	echo "xxx***NID baris ke ".$baris." Sudah Ada";
						// 	exit();
						// }
						
					}
					else
					{
						echo "xxx***NID baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="NO_TELP")
				{
					if (is_numeric($tempValue))
					{
						$set->setField("NO_TELP",$tempValue);
					}
					else
					{
						echo "xxx***No telp baris ke ".$baris." harus berformat numeric";
						exit();
					}
				}
				else if($arrField[$row]=="POSITION_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.POSITION_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckMasterJabatan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqPositionId=$check->getField("POSITION_ID");
						unset($check);
						if(empty($reqPositionId))
						{
							echo "xxx***Id Jabatan ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("POSITION_ID",$reqPositionId);
						}
					}
					else
					{
						$set->setField("POSITION_ID",ValToNullDB($reqPositionId));
					}
				}
				else if($arrField[$row]=="ROLE_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.ROLE_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckRole(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqRoleId=$check->getField("ROLE_ID");
						unset($check);
						if(empty($reqRoleId))
						{
							echo "xxx***Id Role ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("ROLE_ID",$reqRoleId);
						}
					}
				}
				else if($arrField[$row]=="PERUSAHAAN_EKSTERNAL_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.PERUSAHAAN_EKSTERNAL_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckPerusahaanExternal(array(), -1, -1, $statement);
							// echo $check->query;exit;
						$check->firstRow();
						$reqPerusahaanId=$check->getField("PERUSAHAAN_EKSTERNAL_ID");
						unset($check);
						if(empty($reqPerusahaanId))
						{
							echo "xxx***Id Perusahaan ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("PERUSAHAAN_EKSTERNAL_ID",$reqPerusahaanId);
						}
					}
					else
					{
						$set->setField("PERUSAHAAN_EKSTERNAL_ID",ValToNullDB($reqPerusahaanId));
					}
				}
				else if($arrField[$row]=="EXPIRED_DATE")
				{

					if (!empty($tempValue))
					{
						$tempValue = date("d-m-Y", strtotime($tempValue));
						// print_r($tempValue);exit;

						$set->setField("EXPIRED_DATE",dateToDBCheck($tempValue));
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("PENGGUNA_INTERNAL_ID",$reqId);			
				if($set->updatepenggunainternal())
				{
					$reqSimpan = 1;
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				$set->setField("PASSWORD", md5("admin"));
				if($set->insertpenggunainternal())
				{
					$reqSimpan = 1;
					// $reqTipeInputId=$set->id;
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

	function pengguna() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("USERNAME","NAMA","PENGGUNA_HAK_ID","ROLE_ID","PENGGUNA_EXTERNAL_ID","DISTRIK_ID");

		$this->load->model("base-app/Import");

		$set = new Import();

		$arrHakAkses= $arrDistrik=[];
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="PENGGUNA_HAK_ID")
				{
					if (!empty($tempValue))
					{
						$tempValue = str_replace(".", ",", $tempValue);
						$searchForValue = ',';
						$stringValue = $tempValue;
						if( strpos($stringValue, $searchForValue) !== false ) {
							$arrHakAkses=explode(",", $stringValue);
						}
						else
						{
							$statement =" AND A.PENGGUNA_HAK_ID ='".$tempValue."'";
							$check = new Import();
							$check->selectByParamsCheckHakAkses(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$check->firstRow();
							$reqPenggunaHakId=$check->getField("PENGGUNA_HAK_ID");
							unset($check);

							if(empty($reqPenggunaHakId))
							{
								$set->setField("PENGGUNA_HAK_ID",$tempValue);
							}
							else
							{
								$set->setField("PENGGUNA_HAK_ID",$reqPenggunaHakId);
							}
						}
					}
					else
					{
						$set->setField("PENGGUNA_HAK_ID",ValToNullDB($tempValue));
					}
				}
				else if($arrField[$row]=="ROLE_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.ROLE_ID ='".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckRole(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqRoleId=$check->getField("ROLE_ID");
						unset($check);

						if(empty($reqRoleId))
						{
							$set->setField("ROLE_ID",$tempValue);
						}
						else
						{
							$set->setField("ROLE_ID",$reqRoleId);
						}
					}
					else
					{
						$set->setField("ROLE_ID",ValToNullDB($tempValue));
					}
				}
				else if($arrField[$row]=="PENGGUNA_EXTERNAL_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.PENGGUNA_EXTERNAL_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckPenggunaEksternal(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqFormId=$check->getField("PENGGUNA_EXTERNAL_ID");
						unset($check);
						if(empty($reqFormId))
						{
							echo "xxx***Pengguna  ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("PENGGUNA_EXTERNAL_ID",$reqFormId);
						}
					}
					else
					{
						$set->setField("PENGGUNA_EXTERNAL_ID",ValToNullDB($tempValue));
					}
				}
				else if($arrField[$row]=="DISTRIK_ID")
				{
					if (!empty($tempValue))
					{
						$tempValue = str_replace(".", ",", $tempValue);
						$searchForValue = ',';
						$stringValue = $tempValue;
						if( strpos($stringValue, $searchForValue) !== false ) {
							$arrDistrik=explode(",", $stringValue);
						}
						else
						{
							$statement =" AND A.DISTRIK_ID ='".$tempValue."'";
							$check = new Import();
							$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$check->firstRow();
							$reqDistrikId=$check->getField("DISTRIK_ID");
							unset($check);

							if(empty($reqDistrikId))
							{
								$set->setField("DISTRIK_ID",$tempValue);
							}
							else
							{
								$set->setField("DISTRIK_ID",$reqDistrikId);
							}
						}
					}
					else
					{
						$set->setField("DISTRIK_ID",ValToNullDB($tempValue));
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
					$set->setField("PERUSAHAAN_ID",ValToNullDB($Perusahaan));
				}
				$colIndex++;
			}

			if(!empty($arrHakAkses))
			{
				// print_r($arrHakAkses);exit;
				foreach ($arrHakAkses as $key => $value) {
					$statement =" AND A.PENGGUNA_HAK_ID = ".$value."";
					$check = new Import();
					$check->selectByParamsCheckHakAkses(array(), -1, -1, $statement);
							// echo $check->query;exit;
					$check->firstRow();
					$reqHakAksesId=$check->getField("PENGGUNA_HAK_ID");
					unset($check);
					if(empty($reqHakAksesId))
					{
						echo "xxx***Kode Hak Akses ".$value." tidak ditemukan";
						exit();
					}

				}
			}

			if(!empty($arrDistrik))
			{
				foreach ($arrDistrik as $key => $value) {
					$statement =" AND A.DISTRIK_ID = ".$value."";
					$check = new Import();
					$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
							// echo $check->query;exit;
					$check->firstRow();
					$reqDistrikId=$check->getField("DISTRIK_ID");
					unset($check);
					if(empty($reqDistrikId))
					{
						echo "xxx***Kode Distrik ".$value." tidak ditemukan";
						exit();
					}

				}
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("PENGGUNA_ID",$reqId);			
				if($set->updatepengguna())
				{
					$reqSimpan = 1;
					if($set->deletePenggunaHakAkses())
					{
						if($set->insertPenggunaHakAkses())
						{
							$reqSimpan = 1;
						}
					}

					if($set->deletePenggunaDistrik())
					{
						if($set->insertPenggunaDistrik())
						{
							$reqSimpan = 1;
						}
					}
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertpengguna())
				{
					$reqSimpan = 1;
					
					$reqTipeInputId=$set->id;
					$set->setField("PENGGUNA_ID",$reqTipeInputId);
					
					if(!empty($arrHakAkses))
					{
						foreach ($arrHakAkses as $key => $value) {

							$set->setField("PENGGUNA_HAK_ID",$value);
							if($set->insertPenggunaHakAkses())
							{
								$reqSimpan = 1;

							}
						}
					}
					else
					{
						if($set->insertPenggunaHakAkses())
						{
							$reqSimpan = 1;

						}
					}

					if(!empty($arrDistrik))
					{
						foreach ($arrDistrik as $key => $value) {

							$set->setField("DISTRIK_ID",$value);
							if($set->insertPenggunaDistrik())
							{
								$reqSimpan = 1;

							}
						}
					}
					else
					{
						if($set->insertPenggunaDistrik())
						{
							$reqSimpan = 1;

						}
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

	function master_jabatan() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$reqSuperiorId= $this->input->post("reqSuperiorId");


		$baris = $data->rowcount($sheet_index=0);

		$arrField= array("POSITION_ID","NAMA_POSISI","DISTRIK_ID","KATEGORI","JENJANG_JABATAN","UNIT","DITBID");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="POSITION_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.POSITION_ID ='".$tempValue."' AND TIPE IS NULL";
						$check = new Import();
						$check->selectByParamsCheckJabatan(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqPositionId=$check->getField("POSITION_ID");
						unset($check);

						if(empty($reqPositionId))
						{
							$set->setField("POSITION_ID",$tempValue);
						}
						else
						{
							echo "xxx***Kode Jabatan ".$tempValue." sudah ada";
							exit();
						}
					}
					else
					{
						echo "xxx***Kode Jabatan ".$tempValue." belum Diisi";
							exit();
					}
				}
				else if($arrField[$row]=="DISTRIK_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.DISTRIK_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckDistrik(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqKode=$check->getField("KODE");
						unset($check);
						if(empty($reqKode))
						{
							echo "xxx***Kode Distrik  ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("KODE_DISTRIK",$reqKode);
						}
					}
					else
					{
						// $set->setField("KODE_DISTRIK",ValToNullDB($tempValue));
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			$set->setField("SUPERIOR_ID",$reqSuperiorId);

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("POSITION_ID",$reqId);			
				if($set->updatejabatan())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertjabatan())
				{
					$reqSimpan = 1;
					
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

	function pengukuran() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$reqTipePengukuranid= $this->input->post("reqTipePengukuranid");


		if($reqTipePengukuranid=="")
		{
			echo "xxx***Pilih Tipe terlebih dahulu";exit;
		}

		$arrcheck=[];
		$searchForValue = ',';
		$stringValue = $reqTipePengukuranid;
		if( strpos($stringValue, $searchForValue) !== false ) {
			$arrcheck=explode(",", $stringValue);
		}

		// print_r($arrcheck);exit;

		$baris = $data->rowcount($sheet_index=0);

		if(!empty($arrcheck))
		{
			foreach ($arrcheck as $key => $value) {
			 	if($value == 1 || $value == 2)
			 	{
					$arrFieldParent= array("KODE_PENGUKURAN","NAMA","JENIS_PENGUKURAN_ID","NAMA_PENGUKURAN","TIPE_INPUT_ID","FORMULA");
					if($value == 1)
					{
						$arrFieldChild= array("ANALOG","UOM_ID","STATUS_PENGUKURAN","ENJINIRINGUNIT_ID","CATATAN","SEQUENCE","IS_INTERVAL");
					}
					else if($value == 2)
					{
						$arrFieldChild= array("ANALOG","UOM_ID","TEXT_TIPE","STATUS_PENGUKURAN","ENJINIRINGUNIT_ID","CATATAN","SEQUENCE","IS_INTERVAL");
					}
					
			 	}

			}
			$arrField=array_merge($arrFieldParent,$arrFieldChild);
			// print_r($arrField);exit;
		}
		else
		{
			if($reqTipePengukuranid==0)
			{
				$arrField= array("KODE_PENGUKURAN","NAMA","JENIS_PENGUKURAN_ID","NAMA_PENGUKURAN","TIPE_INPUT_ID","FORMULA","GROUP_STATE_ID","STATUS_PENGUKURAN","ENJINIRINGUNIT_ID","CATATAN","SEQUENCE","IS_INTERVAL");
			}
			else if($reqTipePengukuranid==1)
			{
				$arrField= array("KODE_PENGUKURAN","NAMA","JENIS_PENGUKURAN_ID","NAMA_PENGUKURAN","TIPE_INPUT_ID","FORMULA","ANALOG","UOM_ID","STATUS_PENGUKURAN","ENJINIRINGUNIT_ID","CATATAN","SEQUENCE","IS_INTERVAL");
			}
			else if($reqTipePengukuranid==2)
			{
				$arrField= array("KODE_PENGUKURAN","NAMA","JENIS_PENGUKURAN_ID","NAMA_PENGUKURAN","TIPE_INPUT_ID","FORMULA","TEXT_TIPE","STATUS_PENGUKURAN","ENJINIRINGUNIT_ID","CATATAN","SEQUENCE","IS_INTERVAL");
			}
		}


		$this->load->model("base-app/Import");

		$set = new Import();

		$arrtipe=[];
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE_PENGUKURAN")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE_PENGUKURAN ='".$tempValue."' AND TIPE IS NULL";
						$check = new Import();
						$check->selectByParamsCheckPengukuran(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("PENGUKURAN_ID");
						unset($check);

						$set->setField("KODE",$tempValue);
					}
					else
					{
						echo "xxx***Kode Pengukuran ".$tempValue." belum Diisi";
							exit();
					}
				}
				else if($arrField[$row]=="JENIS_PENGUKURAN_ID")
				{
					if (!empty($tempValue))
					{
						$tempValue = str_replace(".", ",", $tempValue);
						$searchForValue = ',';
						$stringValue = $tempValue;
						if( strpos($stringValue, $searchForValue) !== false ) {
							$arrtipe=explode(",", $stringValue);
						}
						else
						{
							$statement =" AND A.JENIS_PENGUKURAN_ID = '".$tempValue."'";
							$check = new Import();
							$check->selectByParamsJenisPengukuran(array(), -1, -1, $statement);
							// echo $check->query;exit;
							$check->firstRow();
							$reqJenisId=$check->getField("JENIS_PENGUKURAN_ID");
							unset($check);
							if(empty($reqJenisId))
							{
								echo "xxx***Jenis Pengukuran ".$tempValue." tidak ditemukan";
								exit();
							}
							else
							{
								$set->setField("JENIS_PENGUKURAN_ID",$tempValue);
							}
						}
					}
					else
					{
						$set->setField("JENIS_PENGUKURAN_ID",ValToNullDB($tempValue));
					}
				}
				else if($arrField[$row]=="TIPE_INPUT_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.TIPE_INPUT_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckTipe(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqTipeId=$check->getField("TIPE_INPUT_ID");
						// $reqTipePengukuranId=$check->getField("TIPE_PENGUKURAN_ID");
						unset($check);
						if(empty($reqTipeId))
						{
							echo "xxx***Tipe Input ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("TIPE_INPUT_ID",$tempValue);
						}
					}
					else
					{
						if($reqTipePengukuranid==0)
						{
							$set->setField("TIPE_INPUT_ID",0);
						}
						else
						{
							$set->setField("TIPE_INPUT_ID",ValToNullDB($tempValue));
						}
						
					}
				}
				else if($arrField[$row]=="GROUP_STATE_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.GROUP_STATE_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckGroupState(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqGroupId=$check->getField("GROUP_STATE_ID");
						unset($check);
						if(empty($reqGroupId))
						{
							echo "xxx***Group State".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("GROUP_STATE_ID",$tempValue);
						}
					}
					else
					{
						$set->setField("GROUP_STATE_ID",ValToNullDB($tempValue));
					}
				}
				else if($arrField[$row]=="UOM_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.UOM_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsUom(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqUomId=$check->getField("UOM_ID");
						unset($check);
						if(empty($reqUomId))
						{
							echo "xxx***Uom".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("UOM_ID",$tempValue);
						}
					}
					else
					{
						$set->setField("UOM_ID",ValToNullDB($tempValue));
					}
				}
				else if($arrField[$row]=="ENJINIRINGUNIT_ID")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.ENJINIRINGUNIT_ID = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckEnjiniringUnit(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqEnjiniringId=$check->getField("ENJINIRINGUNIT_ID");
						unset($check);
						if(empty($reqEnjiniringId))
						{
							echo "xxx***Enjiniring".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("ENJINIRINGUNIT_ID",$tempValue);
						}
					}
					else
					{
						$set->setField("ENJINIRINGUNIT_ID",ValToNullDB($tempValue));
					}
				}
				else
				{
					if($reqTipePengukuranid==1 || $reqTipePengukuranid==2)
					{
						$set->setField("GROUP_STATE_ID",ValToNullDB(''));
					}
					
					if($reqTipePengukuranid==0 || $reqTipePengukuranid==2)
					{
						$set->setField("ANALOG",ValToNullDB(''));	
						$set->setField("UOM_ID",ValToNullDB(''));
					}
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if(!empty($arrtipe))
			{
				foreach ($arrtipe as $key => $value) {
					$statement =" AND A.JENIS_PENGUKURAN_ID = '".$value."'";
					$check = new Import();
					$check->selectByParamsJenisPengukuran(array(), -1, -1, $statement);
							// echo $check->query;exit;
					$check->firstRow();
					$reqJenisId=$check->getField("JENIS_PENGUKURAN_ID");
					unset($check);
					if(empty($reqJenisId))
					{
						echo "xxx***Jenis Pengukuran ".$tempValue." tidak ditemukan";
						exit();
					}
					else
					{
						$set->setField("JENIS_PENGUKURAN_ID",$tempValue);
					}

				}
			}


			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("PENGUKURAN_ID",$reqId);			
				if($set->updatepengukuran())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);

				if($set->insertpengukuran())
				{
					$reqSimpan = 1;
					if(!empty($reqJenisId))
					{
						$reqId=$set->id;
						$set->setField("PENGUKURAN_ID",$reqId);	
						if(!empty($arrtipe))
						{
							foreach ($arrtipe as $key => $value) {

								$set->setField("JENIS_PENGUKURAN_ID",$value);
								if($set->insertjenispengukurandetil())
								{
									$reqSimpan = 1;

								}
							}
						}
						else
						{
							if($set->insertjenispengukurandetil())
							{
								$reqSimpan = 1;

							}
						}		
					

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

	function nameplate() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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
		// print_r($baris);exit;

		$arrField= array("NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="NAMA")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.NAMA = '".$tempValue."'";
						$check = new Import();
						$check->selectByParamsCheckNameplate(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("NAMEPLATE_ID");
						unset($check);
		
						$set->setField("NAMA",$tempValue);
						
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("NAMEPLATE_ID",$reqId);			
				if($set->updatenameplate())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertnameplate())
				{
					$reqSimpan = 1;
					$reqId=$set->id;
					
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

	function nameplate_detail() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqId = $this->input->post("reqId");
		// print_r($reqId);exit;

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
		// print_r($baris);exit;

		$arrField= array("NAMA","NAMA_TABEL","STATUS","NAMEPLATE_ID");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="NAMEPLATE_ID")
				{
					if (!empty($reqId))
					{
						$statement =" AND A.NAMEPLATE_ID = '".$reqId."'";
						$check = new Import();
						$check->selectByParamsCheckNameplate(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqNameplateId=$check->getField("NAMEPLATE_ID");
						unset($check);
						if(empty($reqNameplateId))
						{
							echo "xxx***Nameplate Id ".$tempValue." tidak ditemukan";
							exit();
						}
						else
						{
							$set->setField("NAMEPLATE_ID",ValToNullDB($reqNameplateId));
						}
						
					}
					else
					{
						echo "xxx***Nameplate Id baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else if($arrField[$row]=="STATUS")
				{
					if(is_numeric($tempValue))
					{
						$set->setField($arrField[$row],$tempValue);

					}
					else
					{
						echo "xxx***Status baris ke ".$baris." Belum Diisi atau pastikan kolom status berformat numeric";
						exit();
					}
				}
				else
				{
					// print_r($tempValue);
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("NAMEPLATE_ID",$reqId);		
			if($set->insertNameplateDetail())
			{
				$reqSimpan = 1;

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

	function kelompok_equipment() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("KODE","NAMA");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckKelompokEquipment(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("KELOMPOK_EQUIPMENT_ID");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("KODE",$tempValue);
						}
					}
					else
					{
						echo "xxx***Kode Kelompok Equipment baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("KELOMPOK_EQUIPMENT_ID",$reqId);			
				if($set->updateKelompokEquipment())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertKelompokEquipment())
				{
					$reqSimpan = 1;
					
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

	function crud() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

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

		$arrField= array("KODE_HAK","NAMA_HAK","DESKRIPSI");

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		for ($i=2; $i<=$baris; $i++){
			// validasi kalau kode/id kosong
			// if(empty($data->val($i,2)))
			// 	continue;
			
			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="KODE_HAK")
				{
					if (!empty($tempValue))
					{
						$statement =" AND A.KODE_HAK LIKE '%".$tempValue."%'";
						$check = new Import();
						$check->selectByParamsCheckHak(array(), -1, -1, $statement);
						// echo $check->query;exit;
						$check->firstRow();
						$reqId=$check->getField("PENGGUNA_HAK_ID");
						unset($check);

						if(empty($reqId))
						{
							$set->setField("KODE_HAK",$tempValue);
						}
						else
						{
							echo "xxx***Kode Hak ".$tempValue." sudah ada ";
							exit();
						}
					}
					else
					{
						echo "xxx***Kode Hak baris ke ".$baris." Belum Diisi";
						exit();
					}
				}
				else
				{
					$set->setField($arrField[$row],$tempValue);
				}
				$colIndex++;
			}

			if (!empty($reqId))
			{	
				$set->setField("LAST_UPDATE_DATE", "NOW()");
				$set->setField("LAST_UPDATE_USER", $this->appusernama);
				$set->setField("PENGGUNA_HAK_ID",$reqId);			
				if($set->updatepenggunahak())
				{
					$reqSimpan = 1;
					
				}
			}
			else
			{
				$set->setField("LAST_CREATE_DATE", "NOW()");
				$set->setField("LAST_CREATE_USER", $this->appusernama);
				if($set->insertpenggunahak())
				{
					$reqSimpan = 1;
					
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