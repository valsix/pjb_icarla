<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");
include_once("functions/excel_reader2.php");

class import_form_uji_nameplate_json extends CI_Controller
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


	function form_uji_nameplate() 
	{
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$acceptable = 'application/vnd.ms-excel';
		$tipefile=$_FILES['reqLinkFile']['type'];

		$reqId = $this->input->post("reqId");
		$reqNameplateId = $this->input->post("reqNameplateId");
		$this->load->model("base-app/Nameplate");

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
		if($baris > 2)
		{
			echo "xxx*** Input data tidak boleh lebih dari 1 baris";exit;
		}
		// print_r($baris);exit;
		$set= new Nameplate();
		$arrField=array();
		$statement = " AND A.NAMEPLATE_ID =  ".$reqNameplateId." ";
		$set->selectByParamsDetil(array(), -1, -1, $statement);
		// echo $set->query;exit;
		while($set->nextRow())
		{
			$status= $set->getField("STATUS");

			if($status == 0)
			{
				array_push($arrField, "NAMA");
			}
			else
			{
				array_push($arrField, "MASTER_ID");
			}
		}
		unset($set);

		$set= new Nameplate();
		$arrnameplate= [];

		$statement = " AND A.NAMEPLATE_ID=".$reqNameplateId." AND A.STATUS = '1'";
		$set->selectByParamsDetil(array(), -1, -1, $statement);
		    // echo  $set->query;exit;
		while($set->nextRow())
		{
			$arrdata= array();
			$arrdata["iddetil"]= $set->getField("NAMEPLATE_DETIL_ID");
			$arrdata["id"]= $set->getField("NAMEPLATE_ID");
			$arrdata["NAMA"]= $set->getField("NAMA");
			$arrdata["NAMA_TABEL"]= $set->getField("NAMA_TABEL");
			$arrdata["STATUS"]= $set->getField("STATUS");

			array_push($arrnameplate, $arrdata);
		}
		unset($set);
	
		// print_r($arrnameplate);exit;

		$this->load->model("base-app/Import");

		$set = new Import();
		
		$reqSimpan="";
		$index=2;
		$lanjut="";
		$string="";
		for ($i=2; $i<=$baris; $i++){

			$colIndex=1;
			$arrData= [];

			for($row=0; $row < count($arrField); $row++){

				$tempValue= $data->val($i,$colIndex);
				$string .= ",$tempValue";
				$string =trim($string,",");
				
				$arrData[$arrField[$row]]['VALUE']= $data->val($i,$colIndex);
				if($arrField[$row]=="MASTER_ID")
				{
				}
				$colIndex++;
			}
			// print_r($string);
			$arrString=explode(',', $string);

			$set->setField("LAST_CREATE_DATE", "NOW()");
			$set->setField("LAST_CREATE_USER", $this->appusernama);
			$set->setField("FORM_UJI_ID",$reqId);	
			$set->setField("NAMEPLATE_ID",$reqNameplateId);
			if($set->updatedetilnameplate())
			{
			}	

		}
			// print_r($arrupdatenameplate);exit;
		$set->deletedetilnameplatenew();
		$x=0;
		foreach($arrString as $value) 
		{
			if(is_numeric($value))
			{
				$set->setField("MASTER_ID",$value);	
				$set->setField("NAMA",'');
				$set->setField("STATUS",1);
			}
			else
			{
				$set->setField("MASTER_ID",ValToNullDB(''));	
				$set->setField("NAMA",$value);
				$set->setField("STATUS",'');	
			}

			$set->setField("NAMEPLATE_DETIL_ID",ValToNullDB(''));	

			if($set->insertdetilnameplate())
			{
				$id=$set->id;
				$reqSimpan = 1;

			}
			$x++;
		}

		$checknameplate= new Nameplate();
		$arrupdatenameplate= [];

		$statement = " AND A.NAMEPLATE_ID=".$reqNameplateId."";
		$checknameplate->selectByParamsDetil(array(), -1, -1, $statement);
			    // echo  $set->query;exit;
		while($checknameplate->nextRow())
		{
			$arrdata= array();
			$arrdata["iddetil"]= $checknameplate->getField("NAMEPLATE_DETIL_ID");
			$arrdata["id"]= $checknameplate->getField("NAMEPLATE_ID");
			$arrdata["NAMA"]= $checknameplate->getField("NAMA");
			$arrdata["NAMA_TABEL"]= $checknameplate->getField("NAMA_TABEL");
			$arrdata["STATUS"]= $checknameplate->getField("STATUS");

			array_push($arrupdatenameplate, $arrdata);
		}
		unset($checknameplate);

		$i= $id - $x + 1;

		foreach($arrupdatenameplate as $detil) 
		{
			$idmaster= $detil["iddetil"];
			$nama=$detil["NAMA"];
			$namatabel=$detil["NAMA_TABEL"];
			$setdetil = new Import();
			$setdetil->setField("NAMEPLATE_DETIL_ID",$idmaster);
			$setdetil->setField("NAMA_TABEL",$namatabel);
			$setdetil->setField("NAMA_NAMEPLATE",$nama);
			$setdetil->setField("FORM_UJI_ID",$reqId);	
			$setdetil->setField("NAMEPLATE_ID",$reqNameplateId);
			$statement =" AND A.FORM_UJI_ID =".$reqId." AND A.NAMEPLATE_ID=".$reqNameplateId." AND A.FORM_UJI_NAMEPLATE_ID=".$i;
			$check = new Import();
			$check->selectByParamsCheckDetilNameplate(array(), -1, -1, $statement);
				// echo $check->query;exit;
			$check->firstRow();
			$reqIdDetil=$check->getField("FORM_UJI_NAMEPLATE_ID");
			$setdetil->setField("FORM_UJI_NAMEPLATE_ID",$reqIdDetil);
			if($setdetil->updatedetilnameplatenew())
			{
				$reqSimpan = 1;

			}
			$i++;

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