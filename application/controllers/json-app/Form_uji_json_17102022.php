<?php
defined('BASEPATH') or exit('No direct script access allowed');

include_once("functions/default.func.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/class-list-util.php");
include_once("functions/class-list-util-serverside.php");

class Form_uji_json extends CI_Controller
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
		$this->load->model("base-app/FormUji");

		$set= new FormUji();


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

		$sOrder = " ORDER BY FORM_UJI_ID ASC ";
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
		$this->load->model("base-app/FormUji");

		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");

		$reqNama= $this->input->post("reqNama");
		$reqKode= $this->input->post("reqKode");
		$reqStatus= $this->input->post("reqStatus");
		$reqTipeId= $this->input->post("reqTipeId");

		$reqNameplateId= $this->input->post("reqNameplateId");
		$reqNameplateDetilId= $this->input->post("reqNameplateDetilId");
		$reqKolomNameplate= $this->input->post("reqKolomNameplate");
		$reqMaster= $this->input->post("reqMaster");
		$reqNameplate= $this->input->post("reqNameplate");
		$reqNamaTabel= $this->input->post("reqNamaTabel");
		$reqStatusCheck= $this->input->post("reqStatusCheck");

		$reqMeasuringToolsId= $this->input->post("reqMeasuringToolsId");

		$reqReference= $this->input->post("reqReference");
		$reqResult= $this->input->post("reqResult");
		$reqOilTempSfra= $this->input->post("reqOilTempSfra");
		$reqTapChangerSfra= $this->input->post("reqTapChangerSfra");
		$reqMaxDev= $this->input->post("reqMaxDev");
		$reqNote= $this->input->post("reqNote");

		$reqWaktuBefore= $this->input->post("reqWaktuBefore");
		$reqHvGndBefore= $this->input->post("reqHvGndBefore");
		$reqLvGndBefore= $this->input->post("reqLvGndBefore");
		$reqHvLvBefore= $this->input->post("reqHvLvBefore");

		$reqWaktuAfter= $this->input->post("reqWaktuAfter");
		$reqHvGndAfter= $this->input->post("reqHvGndAfter");
		$reqLvGndAfter= $this->input->post("reqLvGndAfter");
		$reqHvLvAfter= $this->input->post("reqHvLvAfter");

		$reqHvSfra= $this->input->post("reqHvSfra");
		$reqHvDlSfra= $this->input->post("reqHvDlSfra");
		$reqHvNcepriSfra= $this->input->post("reqHvNcepriSfra");

		$reqLvSfra= $this->input->post("reqLvSfra");
		$reqLvDlSfra= $this->input->post("reqLvDlSfra");
		$reqLvNcepriSfra= $this->input->post("reqLvNcepriSfra");

		$reqHvLvSfra= $this->input->post("reqHvLvSfra");
		$reqHvLvDlSfra= $this->input->post("reqHvLvDlSfra");
		$reqHvLvNcepriSfra= $this->input->post("reqHvLvNcepriSfra");

		$reqHvShortSfra= $this->input->post("reqHvShortSfra");
		$reqHvShortDlSfra= $this->input->post("reqHvShortDlSfra");
		$reqHvShortNcepriSfra= $this->input->post("reqHvShortNcepriSfra");

		$reqHvLvGroundSfra= $this->input->post("reqHvLvGroundSfra");
		$reqHvLvGroundDlSfra= $this->input->post("reqHvLvGroundDlSfra");
		$reqHvLvGroundNcepriSfra= $this->input->post("reqHvLvGroundNcepriSfra");

		$reqAirTemperatureDI= $this->input->post("reqAirTemperatureDI");
		$reqAirHumidityDI= $this->input->post("reqAirHumidityDI");
		$reqTapChangerDI= $this->input->post("reqTapChangerDI");
		$reqCalculatedMoisture= $this->input->post("reqCalculatedMoisture");
		$reqMoistureSaturation= $this->input->post("reqMoistureSaturation");
		$reqMoistureCategory= $this->input->post("reqMoistureCategory");
		$reqBubblingInception= $this->input->post("reqBubblingInception");
		$reqOilTemperature= $this->input->post("reqOilTemperature");
		$reqOilConductivity= $this->input->post("reqOilConductivity");
		$reqOilCategory= $this->input->post("reqOilCategory");
		$reqCapacitance= $this->input->post("reqCapacitance");
		$reqBarriers= $this->input->post("reqBarriers");
		$reqPolarizationIndex= $this->input->post("reqPolarizationIndex");
		$reqTan= $this->input->post("reqTan");
		$reqSpacers= $this->input->post("reqSpacers");

		$reqDry= $this->input->post("reqDry");
		$reqModeratelyWet= $this->input->post("reqModeratelyWet");
		$reqWet= $this->input->post("reqWet");
		$reqExtremeWet= $this->input->post("reqExtremeWet");

		$reqAirTemperatureTan= $this->input->post("reqAirTemperatureTan");
		$reqAirHumidityTan= $this->input->post("reqAirHumidityTan");
		$reqAparatusTempTan= $this->input->post("reqAparatusTempTan");

		$reqWindingTan= $this->input->post("reqWindingTan");
		$reqMeasureTanChChl= $this->input->post("reqMeasureTanChChl");
		$reqTestTanChChl= $this->input->post("reqTestTanChChl");
		$reqArusTanChChl= $this->input->post("reqArusTanChChl");
		$reqDayaTanChChl= $this->input->post("reqDayaTanChChl");
		$reqPfCorrTanChChl= $this->input->post("reqPfCorrTanChChl");
		$reqCorrFactTanChChl= $this->input->post("reqCorrFactTanChChl");
		$reqCapTanChChl= $this->input->post("reqCapTanChChl");

		$reqMeasureTanCh= $this->input->post("reqMeasureTanCh");
		$reqTestTanCh= $this->input->post("reqTestTanCh");
		$reqArusTanCh= $this->input->post("reqArusTanCh");
		$reqDayaTanCh= $this->input->post("reqDayaTanCh");
		$reqPfCorrTanCh= $this->input->post("reqPfCorrTanCh");
		$reqCorrFactTanCh= $this->input->post("reqCorrFactTanCh");
		$reqCapTanCh= $this->input->post("reqCapTanCh");

		$reqMeasureTanChlUst= $this->input->post("reqMeasureTanChlUst");
		$reqTestTanChlUst= $this->input->post("reqTestTanChlUst");
		$reqArusTanChlUst= $this->input->post("reqArusTanChlUst");
		$reqDayaTanChlUst= $this->input->post("reqDayaTanChlUst");
		$reqPfCorrTanChlUst= $this->input->post("reqPfCorrTanChlUst");
		$reqCorrFactTanChlUst= $this->input->post("reqCorrFactTanChlUst");
		$reqCapTanChlUst= $this->input->post("reqCapTanChlUst");

		$reqMeasureTanChl= $this->input->post("reqMeasureTanChl");
		$reqTestTanChl= $this->input->post("reqTestTanChl");
		$reqArusTanChl= $this->input->post("reqArusTanChl");
		$reqDayaTanChl= $this->input->post("reqDayaTanChl");
		$reqPfCorrTanChl= $this->input->post("reqPfCorrTanChl");
		$reqCorrFactTanChl= $this->input->post("reqCorrFactTanChl");
		$reqCapTanChl= $this->input->post("reqCapTanChl");

		$reqWindingWithoutTan1= $this->input->post("reqWindingWithoutTan1");
		$reqWindingWithoutTan2= $this->input->post("reqWindingWithoutTan2");
		$reqWindingWithoutTan3= $this->input->post("reqWindingWithoutTan3");
		$reqWindingWithoutTan4= $this->input->post("reqWindingWithoutTan4");
		$reqWindingWithoutTan5= $this->input->post("reqWindingWithoutTan5");
		$reqWindingWithoutTan6= $this->input->post("reqWindingWithoutTan6");
		$reqWindingWithoutTan7= $this->input->post("reqWindingWithoutTan7");
		$reqWindingWithoutTan8= $this->input->post("reqWindingWithoutTan8");

		$reqConditionTan= $this->input->post("reqConditionTan");
		$reqGoodTan= $this->input->post("reqGoodTan");
		$reqMaybeTan= $this->input->post("reqMaybeTan");
		$reqInvestigatedTan= $this->input->post("reqInvestigatedTan");

		$reqAirTemperatureHot= $this->input->post("reqAirTemperatureHot");
		$reqAparatusTempHot= $this->input->post("reqAparatusTempHot");
		$reqAirHumidityHot= $this->input->post("reqAirHumidityHot");
		$reqWeatherHot= $this->input->post("reqWeatherHot");

		$reqBushing= $this->input->post("reqBushing");
		$reqSkirt= $this->input->post("reqSkirt");
		$reqTeganganInjeksi= $this->input->post("reqTeganganInjeksi");
		$reqIma= $this->input->post("reqIma");
		$reqWatts= $this->input->post("reqWatts");

		$reqAirTemperatureEc= $this->input->post("reqAirTemperatureEc");
		$reqAparatusTempEc= $this->input->post("reqAparatusTempEc");
		$reqAirHumidityEc= $this->input->post("reqAirHumidityEc");

		$reqTapEc= $this->input->post("reqTapEc");
		$reqTeganganInjeksiEc= $this->input->post("reqTeganganInjeksiEc");
		$reqImaRt= $this->input->post("reqImaRt");
		$reqWattsRt= $this->input->post("reqWattsRt");
		$reqLcRt= $this->input->post("reqLcRt");
		$reqImaSr= $this->input->post("reqImaSr");
		$reqWattsSr= $this->input->post("reqWattsSr");
		$reqLcSr= $this->input->post("reqLcSr");
		$reqImaTs= $this->input->post("reqImaTs");
		$reqWattsTs= $this->input->post("reqWattsTs");
		$reqLcTs= $this->input->post("reqLcTs");

		$reqMaxDevRdc= $this->input->post("reqMaxDevRdc");

		$reqSisiRdc= $this->input->post("reqSisiRdc");
		$reqTapRdc= $this->input->post("reqTapRdc");

		$reqFasaRdcR= $this->input->post("reqFasaRdcR");
		$reqArusRdcR= $this->input->post("reqArusRdcR");
		$reqTeganganRdcR= $this->input->post("reqTeganganRdcR");
		$reqTahananRdcR= $this->input->post("reqTahananRdcR");
		$reqTahananTempRdcR= $this->input->post("reqTahananTempRdcR");
		$reqDeviasiRdcR= $this->input->post("reqDeviasiRdcR");

		$reqFasaRdcS= $this->input->post("reqFasaRdcS");
		$reqArusRdcS= $this->input->post("reqArusRdcS");
		$reqTeganganRdcS= $this->input->post("reqTeganganRdcS");
		$reqTahananRdcS= $this->input->post("reqTahananRdcS");
		$reqTahananTempRdcS= $this->input->post("reqTahananTempRdcS");
		$reqDeviasiRdcS= $this->input->post("reqDeviasiRdcS");

		$reqFasaRdcT= $this->input->post("reqFasaRdcT");
		$reqArusRdcT= $this->input->post("reqArusRdcT");
		$reqTeganganRdcT= $this->input->post("reqTeganganRdcT");
		$reqTahananRdcT= $this->input->post("reqTahananRdcT");
		$reqTahananTempRdcT= $this->input->post("reqTahananTempRdcT");
		$reqDeviasiRdcT= $this->input->post("reqDeviasiRdcT");

		$reqMaxDevRatio= $this->input->post("reqMaxDevRatio");

		$reqFasaRatio= $this->input->post("reqFasaRatio");
		$reqTapRatio= $this->input->post("reqTapRatio");
		$reqHvKv= $this->input->post("reqHvKv");
		$reqLvKv= $this->input->post("reqLvKv");
		$reqRasioTegangan= $this->input->post("reqRasioTegangan");
		$reqHvV= $this->input->post("reqHvV");
		$reqDerajatHvV= $this->input->post("reqDerajatHvV");
		$reqLvV= $this->input->post("reqLvV");
		$reqDerajatLvV= $this->input->post("reqDerajatLvV");
		$reqRasioHasil= $this->input->post("reqRasioHasil");
		$reqDeviasi= $this->input->post("reqDeviasi");


		$reqMaster=array_filter($reqMaster);

		$reqReference=array_filter($reqReference);
		$reqResult=array_filter($reqResult);
		$reqNote=array_filter($reqNote);

		$reqWaktuBefore=array_filter($reqWaktuBefore);
		$reqWaktuAfter=array_filter($reqWaktuAfter);

		$reqHvSfra=array_filter($reqHvSfra);
		$reqLvSfra=array_filter($reqLvSfra);
		$reqHvLvSfra=array_filter($reqHvLvSfra);
		$reqHvShortSfra=array_filter($reqHvShortSfra);
		$reqHvLvGroundSfra=array_filter($reqHvLvGroundSfra);

		$reqGambarSfra= $_FILES["reqGambarSfra"];
		$reqGambarSfraUkuran= $_FILES["reqGambarSfra"]["size"];
		$reqGambarSfraTipe= $_FILES["reqGambarSfra"]["type"];
		$reqGambarSfraFileName= $_FILES["reqGambarSfra"]["name"];

		$reqGambarDI= $_FILES["reqGambarDI"];
		$reqGambarType= $_FILES["reqGambarDI"]["type"];
		$reqGambarName= $_FILES["reqGambarDI"]["name"];
		$reqGambarSize = $_FILES["reqGambarDI"]["size"];
		$reqGambarTmp = $_FILES["reqGambarDI"]["tmp_name"];


		$reqWindingTan=array_filter($reqWindingTan);
		$reqWindingWithoutTan1=array_filter($reqWindingWithoutTan1);
		$reqConditionTan=array_filter($reqConditionTan);

		$reqBushing=array_filter($reqBushing);
		$reqTapEc=array_filter($reqTapEc);
		$reqFasaRatio=array_filter($reqFasaRatio);
		$reqSisiRdc=array_filter($reqSisiRdc);

		$reqNameplateGambar= $_FILES["reqNameplateGambar"];
		$reqNameplateGambarType= $_FILES["reqNameplateGambar"]["type"];
		$reqNameplateGambarName= $_FILES["reqNameplateGambar"]["name"];
		$reqNameplateGambarTmp = $_FILES["reqNameplateGambar"]["tmp_name"];


		$set = new FormUji();
		$set->setField("NAMA", $reqNama);
		$set->setField("KODE", $reqKode);
		$set->setField("STATUS", $reqStatus);
		$set->setField("FORM_UJI_ID", $reqId);
		$set->setField("FORM_UJI_TIPE_ID", valToNullDB($reqTipeId));
		$set->setField("NAMEPLATE_ID", valToNullDB($reqNameplateId));
		$set->setField("MEASURING_TOOLS_ID", valToNullDB($reqMeasuringToolsId));
	

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

		if($reqSimpan==1)
		{

			if(!empty($reqNameplateGambarName))
			{
				// print_r($reqNameplateGambarName);
				$check = checkFile($reqNameplateGambarType,1);
				if(!$check)
				{
					$errors = 'xxx***File gagal diupload, Pastikan File Gambar nameplate berformat JPG/JPEG/PNG';
					echo  $errors;exit;
				}

				$FILE_DIR = "uploads/form_uji/".$reqId."/gambar_nameplate/".$reqNameplateId."/";

				if (!is_dir($FILE_DIR)) {
					makedirs($FILE_DIR);
				}

				$lokasiBaru=$FILE_DIR.$reqNameplateGambarName;
				$prosesUpload = move_uploaded_file($reqNameplateGambarTmp, $lokasiBaru);
				if ($prosesUpload) 
				{
	                $set = new FormUji();
	                $set->setField("FORM_UJI_ID", $reqId);
	                $set->setField("NAMEPLATE_ID", $reqNameplateId);
	                $set->setField("LINK_GAMBAR", $lokasiBaru);
	                if($set->updategambarNameplate())
	                {
	                }
				}
			}

			if(!empty($reqTipeId))
			{
				$set = new FormUji();
				$reqSimpan="";
				$set->setField("FORM_UJI_ID", $reqId);
				$set->deleteisi();

				$reqResult = array_values($reqResult);
				$reqReference = array_values($reqReference);
				$reqNote = array_values($reqNote);

				foreach ($reqTipeId as $key => $value) {
					$set->setField("FORM_UJI_TIPE_ID", $reqTipeId[$key]);
					$set->setField("REFERENCE", $reqReference[$key]);
					$set->setField("RESULT", $reqResult[$key]);
					$set->setField("NOTE", $reqNote[$key]);

					// print_r($reqNote[$key]);exit;

					if($reqTipeId[$key] == 4)
					{
						$set->setField("OIL_TEMP", $reqOilTempSfra);
						$set->setField("TAP_CHANGER", $reqTapChangerSfra);
					}
					if($reqTipeId[$key] == 5)
					{
						$set->setField("AIR_TEMP", $reqAirTemperatureDI);
						$set->setField("HUMIDITY", $reqAirHumidityDI);
						$set->setField("TAP_CHANGER", $reqTapChangerDI);
						$set->setField("CALCULATED_MOISTURE", $reqCalculatedMoisture);
						$set->setField("MOISTURE_SATURATION", $reqMoistureSaturation);
						$set->setField("MOISTURE_CATEGORY", $reqMoistureCategory);
						$set->setField("BUBBLING_INCEPTION", $reqBubblingInception);
						$set->setField("OIL_TEMPERATURE", $reqOilTemperature);
						$set->setField("OIL_CONDUCTIVITY", $reqOilConductivity);
						$set->setField("OIL_CATEGORY", $reqOilCategory);
						$set->setField("CAPACITANCE", $reqCapacitance);
						$set->setField("BARRIERS", $reqBarriers);
						$set->setField("POLARIZATION_INDEX", $reqPolarizationIndex);
						$set->setField("TAN", $reqTan);
						$set->setField("SPACERS", $reqSpacers);

						$set->setField("DRY", $reqDry);
						$set->setField("MODERATELY_WET", $reqModeratelyWet);
						$set->setField("WET", $reqWet);
						$set->setField("EXTREMELY_WET", $reqExtremeWet);
					}

					if($reqTipeId[$key] == 6)
					{
						$set->setField("AIR_TEMP", $reqAirTemperatureTan);
						$set->setField("HUMIDITY", $reqAirHumidityTan);
						$set->setField("APPARATUS_TEMP", $reqAparatusTempTan);
					}

					if($reqTipeId[$key] == 7)
					{
						$set->setField("AIR_TEMP", $reqAirTemperatureHot);
						$set->setField("HUMIDITY", $reqAirHumidityHot);
						$set->setField("APPARATUS_TEMP", $reqAparatusTempHot);
						$set->setField("WEATHER", $reqWeatherHot);
					}

					if($reqTipeId[$key] == 8)
					{
						$set->setField("AIR_TEMP", $reqAirTemperatureEc);
						$set->setField("HUMIDITY", $reqAirHumidityEc);
						$set->setField("APPARATUS_TEMP", $reqAparatusTempEc);
					}

					if($reqTipeId[$key] == 9)
					{
						$set->setField("MAX_DEV", $reqMaxDevRdc);
					}

					if($reqTipeId[$key] == 10)
					{
						$set->setField("MAX_DEV", $reqMaxDevRatio);
					}


					$set->setField("FORM_UJI_ID", $reqId);
					if($set->insertisi())
					{
						$reqSimpan= 1;
					}
				}


				if(!empty($reqWaktuBefore))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 1);
					$set->deletedetil();
					foreach ($reqWaktuBefore as $key => $value) {
						$set->setField("WAKTU", $reqWaktuBefore[$key]);
						$set->setField("HV_GND", $reqHvGndBefore[$key]);
						$set->setField("LV_GND", $reqLvGndBefore[$key]);
						$set->setField("HV_LV", $reqHvLvBefore[$key]);
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 1);
						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqWaktuAfter))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 2);
					$set->deletedetil();
					foreach ($reqWaktuAfter as $key => $value) {
						$set->setField("WAKTU", $reqWaktuAfter[$key]);
						$set->setField("HV_GND", $reqHvGndAfter[$key]);
						$set->setField("LV_GND", $reqLvGndAfter[$key]);
						$set->setField("HV_LV", $reqHvLvAfter[$key]);
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 2);
						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqHvSfra))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 4);
					$set->setField("TIPE_SFRA", 1);
					$set->deletedetilsfra();
					foreach ($reqHvSfra as $key => $value) {

						$set->setField("HV_SFRA", $reqHvSfra[$key]);
						$set->setField("HV_DL_SFRA", $reqHvDlSfra[$key]);
						$set->setField("HV_NCEPRI_SFRA", $reqHvNcepriSfra[$key]);

						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 4);
						$set->setField("TIPE_SFRA", 1);

						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqLvSfra))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 4);
					$set->setField("TIPE_SFRA", 2);
					$set->deletedetilsfra();
					foreach ($reqLvSfra as $key => $value) {

						$set->setField("LV_SFRA", $reqLvSfra[$key]);
						$set->setField("LV_DL_SFRA", $reqLvDlSfra[$key]);
						$set->setField("LV_NCEPRI_SFRA", $reqLvNcepriSfra[$key]);
						
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 4);
						$set->setField("TIPE_SFRA", 2);

						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqHvLvSfra))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 4);
					$set->setField("TIPE_SFRA", 3);
					$set->deletedetilsfra();
					foreach ($reqHvLvSfra as $key => $value) {

						$set->setField("HVLV_SFRA", $reqHvLvSfra[$key]);
						$set->setField("HVLV_DL_SFRA", $reqHvLvDlSfra[$key]);
						$set->setField("HVLV_NCEPRI_SFRA", $reqHvLvNcepriSfra[$key]);
						
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 4);
						$set->setField("TIPE_SFRA", 3);

						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqHvShortSfra))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 4);
					$set->setField("TIPE_SFRA", 4);
					$set->deletedetilsfra();
					foreach ($reqHvShortSfra as $key => $value) {

						$set->setField("HV_SHORT_SFRA", $reqHvShortSfra[$key]);
						$set->setField("HV_SHORT_DL_SFRA", $reqHvShortDlSfra[$key]);
						$set->setField("HV_SHORT_NCEPRI_SFRA", $reqHvShortNcepriSfra[$key]);
						
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 4);
						$set->setField("TIPE_SFRA", 4);

						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqHvLvGroundSfra))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 4);
					$set->setField("TIPE_SFRA", 5);
					$set->deletedetilsfra();
					foreach ($reqHvLvGroundSfra as $key => $value) {

						$set->setField("HVLV_GROUND_SFRA", $reqHvLvGroundSfra[$key]);
						$set->setField("HVLV_GROUND_DL_SFRA", $reqHvLvGroundDlSfra[$key]);
						$set->setField("HVLV_GROUND_NCEPRI_SFRA", $reqHvLvGroundNcepriSfra[$key]);
						
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 4);
						$set->setField("TIPE_SFRA", 5);

						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqGambarSfra['name'][0]))
				{
					$FILE_DIR = "uploads/form_uji/gambar/".$reqId."/4/";

					if (!is_dir($FILE_DIR)) {
						makedirs($FILE_DIR);
					}
					$jumlahFile = count($reqGambarSfra['name']);
					for ($i = 0; $i < $jumlahFile; $i++) {
						$namaFile = $reqGambarSfraFileName[$i];
						$lokasiTmp = $reqGambarSfra['tmp_name'][$i];
						$type = $reqGambarSfraTipe[$i];
						$ukuran = $reqGambarSfraUkuran[$i];

						$check = checkFile($type,1);
						if(!$check)
						{
							$errors = 'xxx***File gagal diupload, Pastikan File berformat JPG/JPEG/PNG';
							echo  $errors;exit;
						}

						$renameFile = $namaFile;
						$lokasiBaru=$FILE_DIR.$renameFile;
		            	// print_r($lokasiBaru);exit;
						$prosesUpload = move_uploaded_file($lokasiTmp, $lokasiBaru);
						if ($prosesUpload) 
						{
							$insertFile = $FILE_DIR.$renameFile;
							$set = new FormUji();
							$set->setField("FORM_UJI_ID", $reqId);
							$set->setField("FORM_UJI_TIPE_ID", 4);
							$set->setField("NAMA", $namaFile);
							$set->setField("LINK_GAMBAR", $lokasiBaru);
							if($set->insertgambarmulti())
							{
								$reqSimpan= 1;
							}
						}
					}
				}

				if(!empty($reqGambarName))
				{
					$check = checkFile($reqGambarType,1);
					if(!$check)
					{
						$errors = 'xxx***File gagal diupload, Pastikan File berformat JPG/JPEG/PNG';
						echo  $errors;exit;
					}

					$FILE_DIR = "uploads/form_uji/5/".$reqId."/";

					if (!is_dir($FILE_DIR)) {
						makedirs($FILE_DIR);
					}

					$lokasiBaru=$FILE_DIR.$reqGambarName;
					$prosesUpload = move_uploaded_file($reqGambarTmp, $lokasiBaru);
					if ($prosesUpload) 
					{
						$set = new FormUji();
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 5);
						$set->deletegambarAll();
						$insertFile = $FILE_DIR.$renameFile;
						$set = new FormUji();
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 5);
						$set->setField("NAMA", $namaFile);
						$set->setField("LINK_GAMBAR", $lokasiBaru);
						if($set->insertgambarmulti())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqWindingTan))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 6);
					$set->setField("TIPE_TAN", 1);
					$set->deletedetiltan();
					foreach ($reqWindingTan as $key => $value) {

						$set->setField("WINDING_TAN", $reqWindingTan[$key]);

						$set->setField("MEASURE_TAN_CH_CHL", $reqMeasureTanChChl[$key]);
						$set->setField("TEST_TAN_CH_CHL", $reqTestTanChChl[$key]);
						$set->setField("ARUS_TAN_CH_CHL", $reqArusTanChChl[$key]);
						$set->setField("DAYA_TAN_CH_CHL", $reqDayaTanChChl[$key]);
						$set->setField("PF_CORR_TAN_CH_CHL", $reqPfCorrTanChChl[$key]);
						$set->setField("CORR_FACT_TAN_CH_CHL", $reqCorrFactTanChChl[$key]);
						$set->setField("CAP_TAN_CH_CHL", $reqCapTanChChl[$key]);

						$set->setField("MEASURE_TAN_CH", $reqMeasureTanCh[$key]);
						$set->setField("TEST_TAN_CH", $reqTestTanCh[$key]);
						$set->setField("ARUS_TAN_CH", $reqArusTanCh[$key]);
						$set->setField("DAYA_TAN_CH", $reqDayaTanCh[$key]);
						$set->setField("PF_CORR_TAN_CH", $reqPfCorrTanCh[$key]);
						$set->setField("CORR_FACT_TAN_CH", $reqCorrFactTanCh[$key]);
						$set->setField("CAP_TAN_CH", $reqCapTanCh[$key]);

						$set->setField("MEASURE_TAN_CHL_UST", $reqMeasureTanChlUst[$key]);
						$set->setField("TEST_TAN_CHL_UST", $reqTestTanChlUst[$key]);
						$set->setField("ARUS_TAN_CHL_UST", $reqArusTanChlUst[$key]);
						$set->setField("DAYA_TAN_CHL_UST", $reqDayaTanChlUst[$key]);
						$set->setField("PF_CORR_TAN_CHL_UST", $reqPfCorrTanChlUst[$key]);
						$set->setField("CORR_FACT_TAN_CHL_UST", $reqCorrFactTanChlUst[$key]);
						$set->setField("CAP_TAN_CHL_UST", $reqCapTanChlUst[$key]);

						$set->setField("MEASURE_TAN_CHL", $reqMeasureTanChl[$key]);
						$set->setField("TEST_TAN_CHL", $reqTestTanChl[$key]);
						$set->setField("ARUS_TAN_CHL", $reqArusTanChl[$key]);
						$set->setField("DAYA_TAN_CHL", $reqDayaTanChl[$key]);
						$set->setField("PF_CORR_TAN_CHL", $reqPfCorrTanChl[$key]);
						$set->setField("CORR_FACT_TAN_CHL", $reqCorrFactTanChl[$key]);
						$set->setField("CAP_TAN_CHL", $reqCapTanChl[$key]);
						
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 6);
						$set->setField("TIPE_TAN", 1);

						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqWindingWithoutTan1))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 6);
					$set->setField("TIPE_TAN", 2);
					$set->deletedetiltan();
					foreach ($reqWindingWithoutTan1 as $key => $value) {

						$set->setField("WINDING_WITHOUT_TAN_1", $reqWindingWithoutTan1[$key]);
						$set->setField("WINDING_WITHOUT_TAN_2", $reqWindingWithoutTan2[$key]);
						$set->setField("WINDING_WITHOUT_TAN_3", $reqWindingWithoutTan3[$key]);
						$set->setField("WINDING_WITHOUT_TAN_4", $reqWindingWithoutTan4[$key]);
						$set->setField("WINDING_WITHOUT_TAN_5", $reqWindingWithoutTan5[$key]);
						$set->setField("WINDING_WITHOUT_TAN_6", $reqWindingWithoutTan6[$key]);
						$set->setField("WINDING_WITHOUT_TAN_7", $reqWindingWithoutTan7[$key]);
						$set->setField("WINDING_WITHOUT_TAN_8", $reqWindingWithoutTan8[$key]);

						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 6);
						$set->setField("TIPE_TAN", 2);

						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqConditionTan))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 6);
					$set->setField("TIPE_TAN", 3);
					$set->deletedetiltan();
					foreach ($reqConditionTan as $key => $value) {

						$set->setField("CONDITION_TAN", $reqConditionTan[$key]);
						$set->setField("GOOD_TAN", $reqGoodTan[$key]);
						$set->setField("MAYBE_TAN", $reqMaybeTan[$key]);
						$set->setField("INVESTIGATED_TAN", $reqInvestigatedTan[$key]);

						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 6);
						$set->setField("TIPE_TAN", 3);

						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				// print_r($reqTapEc);exit;

				if(!empty($reqBushing))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 7);
					$set->deletedetil();
					foreach ($reqBushing as $key => $value) {
						$set->setField("BUSHING", $reqBushing[$key]);
						$set->setField("SKIRT", $reqSkirt[$key]);
						$set->setField("TEGANGAN", $reqTeganganInjeksi[$key]);
						$set->setField("IMA", $reqIma[$key]);
						$set->setField("WATTS", $reqWatts[$key]);
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 7);
						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqTapEc))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 8);
					$set->deletedetil();
					foreach ($reqTapEc as $key => $value) {
						$set->setField("TAP", $reqTapEc[$key]);
						$set->setField("TEGANGAN_EC", $reqTeganganInjeksiEc[$key]);
						$set->setField("IMA_RT", $reqImaRt[$key]);
						$set->setField("WATTS_RT", $reqWattsRt[$key]);
						$set->setField("LC_RT", $reqLcRt[$key]);

						$set->setField("IMA_SR", $reqImaSr[$key]);
						$set->setField("WATTS_SR", $reqWattsSr[$key]);
						$set->setField("LC_SR", $reqLcSr[$key]);

						$set->setField("IMA_TS", $reqImaTs[$key]);
						$set->setField("WATTS_TS", $reqWattsTs[$key]);
						$set->setField("LC_TS", $reqLcTs[$key]);

						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 8);
						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqSisiRdc))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 9);
					$set->deletedetil();
					foreach ($reqSisiRdc as $key => $value) {

						$set->setField("SISI_RDC", $reqSisiRdc[$key]);
						$set->setField("TAP_RDC", $reqTapRdc[$key]);

						$set->setField("FASA_RDC_R", $reqFasaRdcR[$key]);
						$set->setField("ARUS_RDC_R", $reqArusRdcR[$key]);
						$set->setField("TEGANGAN_RDC_R", $reqTeganganRdcR[$key]);
						$set->setField("TAHANAN_RDC_R", $reqTahananRdcR[$key]);
						$set->setField("TAHANAN_TEMP_RDC_R", $reqTahananTempRdcR[$key]);
						$set->setField("DEV_RDC_R", $reqDeviasiRdcR[$key]);

						$set->setField("FASA_RDC_S", $reqFasaRdcS[$key]);
						$set->setField("ARUS_RDC_S", $reqArusRdcS[$key]);
						$set->setField("TEGANGAN_RDC_S", $reqTeganganRdcS[$key]);
						$set->setField("TAHANAN_RDC_S", $reqTahananRdcS[$key]);
						$set->setField("TAHANAN_TEMP_RDC_S", $reqTahananTempRdcS[$key]);
						$set->setField("DEV_RDC_S", $reqDeviasiRdcS[$key]);

						$set->setField("FASA_RDC_T", $reqFasaRdcT[$key]);
						$set->setField("ARUS_RDC_T", $reqArusRdcT[$key]);
						$set->setField("TEGANGAN_RDC_T", $reqTeganganRdcT[$key]);
						$set->setField("TAHANAN_RDC_T", $reqTahananRdcT[$key]);
						$set->setField("TAHANAN_TEMP_RDC_T", $reqTahananTempRdcT[$key]);
						$set->setField("DEV_RDC_T", $reqDeviasiRdcT[$key]);

						
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 9);
						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

				if(!empty($reqFasaRatio))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("FORM_UJI_TIPE_ID", 10);
					$set->deletedetil();
					foreach ($reqFasaRatio as $key => $value) {
						$set->setField("FASA_RATIO", $reqFasaRatio[$key]);
						$set->setField("TAP_RATIO", $reqTapRatio[$key]);
						$set->setField("HV_KV", $reqHvKv[$key]);
						$set->setField("LV_KV", $reqLvKv[$key]);
						$set->setField("RASIO_TEGANGAN", $reqRasioTegangan[$key]);
						$set->setField("HV_V",  $reqHvV[$key]);
						$set->setField("DERAJAT_HV_V",  $reqDerajatHvV[$key]);
						$set->setField("LV_V", $reqLvV[$key]);
						$set->setField("DERAJAT_LV_V",  $reqDerajatLvV[$key]);
						$set->setField("RASIO_HASIL",  $reqRasioHasil[$key]);
						$set->setField("DEVIASI", $reqDeviasi[$key]);
						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("FORM_UJI_TIPE_ID", 10);
						if($set->insertdetil())
						{
							$reqSimpan= 1;
						}
					}
				}

			}

	
			if (empty($reqNameplateId))
			{
				// print_r($reqNameplateId);exit;
				$set = new FormUji();
				$set->setField("FORM_UJI_ID", $reqId);
				$set->deletedetilnameplateall();
			}
			else
			{
				// print_r($reqNameplateDetilId);exit;
				if(!empty($reqKolomNameplate))
				{
					$set = new FormUji();
					$reqSimpan="";
					$set->setField("FORM_UJI_ID", $reqId);
					$set->setField("NAMEPLATE_ID", $reqNameplateId);
					$set->deletedetilnameplate();
					foreach ($reqKolomNameplate as $key => $value) {
						$set->setField("NAMEPLATE_DETIL_ID", $reqNameplateDetilId[$key]);
						$set->setField("MASTER_ID", valToNullDB($reqMaster[$key]));
						$set->setField("NAMA", $reqKolomNameplate[$key]);
						$set->setField("NAMA_NAMEPLATE", $reqNameplate[$key]);
						$set->setField("NAMA_TABEL", $reqNamaTabel[$key]);
						$set->setField("STATUS", $reqStatusCheck[$key]);

						$set->setField("FORM_UJI_ID", $reqId);
						$set->setField("NAMEPLATE_ID", $reqNameplateId);

						if($set->insertdetilnameplate())
						{
							$reqSimpan= 1;
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

	function delete()
	{
		$this->load->model("base-app/FormUji");
		$set = new FormUji();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');

		$set->setField("FORM_UJI_ID", $reqId);

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
		$this->load->model("base-app/FormUji");
		$set = new FormUji();

		$reqId =  $this->input->get('reqId');
		$reqTipeId =  $this->input->get('reqTipeId');
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqSimpan="";
		$set->setField("FORM_UJI_DETIL_ID", $reqDetilId);
		$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);
		$set->setField("FORM_UJI_ID", $reqId);
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

	function deletedetailtan()
	{
		$this->load->model("base-app/FormUji");
		$set = new FormUji();

		$reqId =  $this->input->get('reqId');
		$reqTipeId =  $this->input->get('reqTipeId');
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqTipeTan =  $this->input->get('reqTipeTan');
		$reqSimpan="";
		$set->setField("FORM_UJI_DETIL_ID", $reqDetilId);
		$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);
		$set->setField("FORM_UJI_ID", $reqId);
		$set->setField("TIPE_TAN", $reqTipeTan);
		if($set->deletedetiltabeltan())
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


	function deletegambar()
	{
		$this->load->model("base-app/FormUji");
		$check = new FormUji();
		$set = new FormUji();
		$reqId  = $this->input->get('reqId');
		$reqDetilId  = $this->input->get('reqDetilId');
		$reqTipeId  = $this->input->get('reqTipeId');

		$set->selectByParamsGambar(array("A.FORM_UJI_ID" => $reqId,"A.FORM_UJI_GAMBAR_ID" => $reqDetilId,"A.FORM_UJI_TIPE_ID" => $reqTipeId), -1, -1);
		$set->firstRow();
		$reqUrl= $set->getField("LINK_GAMBAR");
		if($reqUrl)
		{
			unlink($reqUrl);
		}
		
		$set->setField("FORM_UJI_ID", $reqId);
		$set->setField("FORM_UJI_GAMBAR_ID", $reqDetilId);
		$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);

		if($set->deletegambar())
		{
			$reqSimpan=1;
		}

		$reqSimpan=1;

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

	function deletedetailsfra()
	{
		$this->load->model("base-app/FormUji");
		$set = new FormUji();

		$reqId =  $this->input->get('reqId');
		$reqTipeId =  $this->input->get('reqTipeId');
		$reqDetilId =  $this->input->get('reqDetilId');
		$reqTipeSfra =  $this->input->get('reqTipeSfra');
		$reqSimpan="";
		$set->setField("FORM_UJI_DETIL_ID", $reqDetilId);
		$set->setField("FORM_UJI_TIPE_ID", $reqTipeId);
		$set->setField("FORM_UJI_ID", $reqId);
		$set->setField("TIPE_SFRA", $reqTipeSfra);
		if($set->deletedetiltabelSfra())
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