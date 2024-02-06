<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/FormUji");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");

$set= new FormUji();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND FORM_UJI_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("FORM_UJI_ID");
    $reqKode= $set->getField("KODE");
    $reqNama= $set->getField("NAMA");
    $reqStatus= $set->getField("STATUS");
    $reqTipeId= $set->getField("FORM_UJI_TIPE_ID");
    $reqReference= $set->getField("REFERENCE");
    $reqResult= $set->getField("RESULT");
    $reqNote= $set->getField("NOTE");
    $reqMaxDev= $set->getField("MAX_DEV");

    $reqAirTemperature= $set->getField("AIR_TEMP");
    $reqAirHumidity= $set->getField("HUMIDITY");
    $reqTapChanger=  $set->getField("TAP_CHANGER");
    $reqCalculatedMoisture=  $set->getField("CALCULATED_MOISTURE");
    $reqMoistureSaturation= $set->getField("MOISTURE_SATURATION");
    $reqMoistureCategory=  $set->getField("MOISTURE_CATEGORY");
    $reqOilTemperature=  $set->getField("OIL_TEMPERATURE");
    $reqOilConductivity=  $set->getField("OIL_CONDUCTIVITY");
    $reqOilCategory=  $set->getField("OIL_CATEGORY");
    $reqCapacitance=  $set->getField("CAPACITANCE");
    $reqBarriers=  $set->getField("BARRIERS");
    $reqPolarizationIndex=  $set->getField("POLARIZATION_INDEX");
    $reqTan=  $set->getField("TAN");
    $reqSpacers=  $set->getField("SPACERS");

    $reqDry=  $set->getField("DRY");
    $reqModeratelyWet=  $set->getField("MODERATELY_WET");
    $reqWet=  $set->getField("WET");
    $reqExtremeWet=  $set->getField("EXTREMELY_WET");

    $reqAparatusTemp=  $set->getField("APPARATUS_TEMP");
    $reqWeather =$set->getField("WEATHER");

    $reqOilTemp=  $set->getField("OIL_TEMP");

    $reqGambarDI=  $set->getField("LINK_GAMBAR");

    unset($set);

    $set= new FormUji();
    $arrwaktu= [];
    $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqTipeId." AND FORM_UJI_ID = '".$reqId."'";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
        $arrdata["parent"]= $set->getField("FORM_UJI_ID");
        $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");
        $arrdata["waktu"]= $set->getField("WAKTU");
        $arrdata["hv_gnd"]= $set->getField("HV_GND");
        $arrdata["lv_gnd"]= $set->getField("LV_GND");
        $arrdata["hv_lv"]= $set->getField("HV_LV");

        $arrdata["bushing"]= $set->getField("BUSHING");
        $arrdata["skirt"]= $set->getField("SKIRT");
        $arrdata["tegangan"]= $set->getField("TEGANGAN");
        $arrdata["ima"]= $set->getField("IMA");
        $arrdata["watts"]= $set->getField("WATTS");

        $arrdata["tap"]= $set->getField("TAP");
        $arrdata["ima_rt"]= $set->getField("IMA_RT");
        $arrdata["watts_rt"]= $set->getField("WATTS_RT");
        $arrdata["lc_rt"]= $set->getField("LC_RT");

        $arrdata["ima_sr"]= $set->getField("IMA_SR");
        $arrdata["watts_sr"]= $set->getField("WATTS_SR");
        $arrdata["lc_sr"]= $set->getField("LC_SR");

        $arrdata["ima_ts"]= $set->getField("IMA_TS");
        $arrdata["watts_ts"]= $set->getField("WATTS_TS");
        $arrdata["lc_ts"]= $set->getField("LC_TS");

        $arrdata["fasa_ratio"]= $set->getField("FASA_RATIO");
        $arrdata["tap_ratio"]= $set->getField("TAP_RATIO");
        $arrdata["hv_kv"]= $set->getField("HV_KV");
        $arrdata["lv_kv"]= $set->getField("LV_KV");
        $arrdata["rasio_tegangan"]= $set->getField("RASIO_TEGANGAN");
        $arrdata["hv_v"]= $set->getField("HV_V");
        $arrdata["DERAJAT_HV_V"]= $set->getField("DERAJAT_HV_V");
        $arrdata["LV_V"]= $set->getField("LV_V");
        $arrdata["DERAJAT_LV_V"]= $set->getField("DERAJAT_LV_V");
        $arrdata["RASIO_HASIL"]= $set->getField("RASIO_HASIL");
        $arrdata["DEVIASI"]= $set->getField("DEVIASI");

        $arrdata["SISI_RDC"]= $set->getField("SISI_RDC");
        $arrdata["TAP_RDC"]= $set->getField("TAP_RDC");

        $arrdata["FASA_RDC_R"]= $set->getField("FASA_RDC_R");
        $arrdata["ARUS_RDC_R"]= $set->getField("ARUS_RDC_R");
        $arrdata["TEGANGAN_RDC_R"]= $set->getField("TEGANGAN_RDC_R");
        $arrdata["TAHANAN_RDC_R"]= $set->getField("TAHANAN_RDC_R");
        $arrdata["TAHANAN_TEMP_RDC_R"]= $set->getField("TAHANAN_TEMP_RDC_R");
        $arrdata["DEV_RDC_R"]= $set->getField("DEV_RDC_R");

        $arrdata["FASA_RDC_S"]= $set->getField("FASA_RDC_S");
        $arrdata["ARUS_RDC_S"]= $set->getField("ARUS_RDC_S");
        $arrdata["TEGANGAN_RDC_S"]= $set->getField("TEGANGAN_RDC_S");
        $arrdata["TAHANAN_RDC_S"]= $set->getField("TAHANAN_RDC_S");
        $arrdata["TAHANAN_TEMP_RDC_S"]= $set->getField("TAHANAN_TEMP_RDC_S");
        $arrdata["DEV_RDC_S"]= $set->getField("DEV_RDC_S");

        $arrdata["FASA_RDC_T"]= $set->getField("FASA_RDC_T");
        $arrdata["ARUS_RDC_T"]= $set->getField("ARUS_RDC_T");
        $arrdata["TEGANGAN_RDC_T"]= $set->getField("TEGANGAN_RDC_T");
        $arrdata["TAHANAN_RDC_T"]= $set->getField("TAHANAN_RDC_T");
        $arrdata["TAHANAN_TEMP_RDC_T"]= $set->getField("TAHANAN_TEMP_RDC_T");
        $arrdata["DEV_RDC_T"]= $set->getField("DEV_RDC_T");
      

        array_push($arrwaktu, $arrdata);
    }
    unset($set);

    $set= new FormUji();
    $arrwindingtan= [];
    $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqTipeId." AND FORM_UJI_ID = '".$reqId."' AND TIPE_TAN = '1' ";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
        $arrdata["parent"]= $set->getField("FORM_UJI_ID");
        $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

        $arrdata["WINDING_TAN"]= $set->getField("WINDING_TAN");

        $arrdata["MEASURE_TAN_CH_CHL"]= $set->getField("MEASURE_TAN_CH_CHL");
        $arrdata["TEST_TAN_CH_CHL"]= $set->getField("TEST_TAN_CH_CHL");
        $arrdata["ARUS_TAN_CH_CHL"]= $set->getField("ARUS_TAN_CH_CHL");
        $arrdata["DAYA_TAN_CH_CHL"]= $set->getField("DAYA_TAN_CH_CHL");
        $arrdata["PF_CORR_TAN_CH_CHL"]= $set->getField("PF_CORR_TAN_CH_CHL");
        $arrdata["CORR_FACT_TAN_CH_CHL"]= $set->getField("CORR_FACT_TAN_CH_CHL");
        $arrdata["CAP_TAN_CH_CHL"]= $set->getField("CAP_TAN_CH_CHL");

        $arrdata["MEASURE_TAN_CH"]= $set->getField("MEASURE_TAN_CH");
        $arrdata["TEST_TAN_CH"]= $set->getField("TEST_TAN_CH");
        $arrdata["ARUS_TAN_CH"]= $set->getField("ARUS_TAN_CH");
        $arrdata["DAYA_TAN_CH"]= $set->getField("DAYA_TAN_CH");
        $arrdata["PF_CORR_TAN_CH"]= $set->getField("PF_CORR_TAN_CH");
        $arrdata["CORR_FACT_TAN_CH"]= $set->getField("CORR_FACT_TAN_CH");
        $arrdata["CAP_TAN_CH"]= $set->getField("CAP_TAN_CH");

        $arrdata["MEASURE_TAN_CHL_UST"]= $set->getField("MEASURE_TAN_CHL_UST");
        $arrdata["TEST_TAN_CHL_UST"]= $set->getField("TEST_TAN_CHL_UST");
        $arrdata["ARUS_TAN_CHL_UST"]= $set->getField("ARUS_TAN_CHL_UST");
        $arrdata["DAYA_TAN_CHL_UST"]= $set->getField("DAYA_TAN_CHL_UST");
        $arrdata["PF_CORR_TAN_CHL_UST"]= $set->getField("PF_CORR_TAN_CHL_UST");
        $arrdata["CORR_FACT_TAN_CHL_UST"]= $set->getField("CORR_FACT_TAN_CHL_UST");
        $arrdata["CAP_TAN_CHL_UST"]= $set->getField("CAP_TAN_CHL_UST");

        $arrdata["MEASURE_TAN_CHL"]= $set->getField("MEASURE_TAN_CHL");
        $arrdata["TEST_TAN_CHL"]= $set->getField("TEST_TAN_CHL");
        $arrdata["ARUS_TAN_CHL"]= $set->getField("ARUS_TAN_CHL");
        $arrdata["DAYA_TAN_CHL"]= $set->getField("DAYA_TAN_CHL");
        $arrdata["PF_CORR_TAN_CHL"]= $set->getField("PF_CORR_TAN_CHL");
        $arrdata["CORR_FACT_TAN_CHL"]= $set->getField("CORR_FACT_TAN_CHL");
        $arrdata["CAP_TAN_CHL"]= $set->getField("CAP_TAN_CHL");

        array_push($arrwindingtan, $arrdata);
    }
    unset($set);

    $set= new FormUji();
    $arrwindingwithouttan= [];
    $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqTipeId." AND FORM_UJI_ID = '".$reqId."' AND TIPE_TAN = '2' ";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
        $arrdata["parent"]= $set->getField("FORM_UJI_ID");
        $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

        $arrdata["WINDING_WITHOUT_TAN_1"]= $set->getField("WINDING_WITHOUT_TAN_1");
        $arrdata["WINDING_WITHOUT_TAN_2"]= $set->getField("WINDING_WITHOUT_TAN_2");
        $arrdata["WINDING_WITHOUT_TAN_3"]= $set->getField("WINDING_WITHOUT_TAN_3");
        $arrdata["WINDING_WITHOUT_TAN_4"]= $set->getField("WINDING_WITHOUT_TAN_4");
        $arrdata["WINDING_WITHOUT_TAN_5"]= $set->getField("WINDING_WITHOUT_TAN_5");
        $arrdata["WINDING_WITHOUT_TAN_6"]= $set->getField("WINDING_WITHOUT_TAN_6");
        $arrdata["WINDING_WITHOUT_TAN_7"]= $set->getField("WINDING_WITHOUT_TAN_7");
        $arrdata["WINDING_WITHOUT_TAN_8"]= $set->getField("WINDING_WITHOUT_TAN_8");

        array_push($arrwindingwithouttan, $arrdata);
    }
    unset($set);

    $set= new FormUji();
    $arrtanref= [];
    $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqTipeId." AND FORM_UJI_ID = '".$reqId."' AND TIPE_TAN = '3' ";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
        $arrdata["parent"]= $set->getField("FORM_UJI_ID");
        $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

        $arrdata["CONDITION_TAN"]= $set->getField("CONDITION_TAN");
        $arrdata["GOOD_TAN"]= $set->getField("GOOD_TAN");
        $arrdata["MAYBE_TAN"]= $set->getField("MAYBE_TAN");
        $arrdata["INVESTIGATED_TAN"]= $set->getField("INVESTIGATED_TAN");

       array_push($arrtanref, $arrdata);
    }
    unset($set);

    $set= new FormUji();
    $arrgambarsfra= [];
    $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqTipeId." AND FORM_UJI_ID = '".$reqId."'";
    $set->selectByParamsGambar(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_GAMBAR_ID");
        $arrdata["parent"]= $set->getField("FORM_UJI_ID");
        $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

        $arrdata["LINK_GAMBAR"]= $set->getField("LINK_GAMBAR");
        $arrdata["NAMA"]= $set->getField("NAMA");
       array_push($arrgambarsfra, $arrdata);
    }
    unset($set);

    $set= new FormUji();
    $arrsfraHv= [];
    $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqTipeId." AND FORM_UJI_ID = '".$reqId."' AND TIPE_SFRA = '1' ";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
        $arrdata["parent"]= $set->getField("FORM_UJI_ID");
        $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

        $arrdata["HV_SFRA"]= $set->getField("HV_SFRA");
        $arrdata["HV_DL_SFRA"]= $set->getField("HV_DL_SFRA");
        $arrdata["HV_NCEPRI_SFRA"]= $set->getField("HV_NCEPRI_SFRA");

       array_push($arrsfraHv, $arrdata);
    }
    unset($set);

    $set= new FormUji();
    $arrsfraLv= [];
    $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqTipeId." AND FORM_UJI_ID = '".$reqId."' AND TIPE_SFRA = '2' ";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
        $arrdata["parent"]= $set->getField("FORM_UJI_ID");
        $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

        $arrdata["LV_SFRA"]= $set->getField("LV_SFRA");
        $arrdata["LV_DL_SFRA"]= $set->getField("LV_DL_SFRA");
        $arrdata["LV_NCEPRI_SFRA"]= $set->getField("LV_NCEPRI_SFRA");

       array_push($arrsfraLv, $arrdata);
    }
    unset($set);

    $set= new FormUji();
    $arrsfraHvLv= [];
    $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqTipeId." AND FORM_UJI_ID = '".$reqId."' AND TIPE_SFRA = '3' ";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
        $arrdata["parent"]= $set->getField("FORM_UJI_ID");
        $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

        $arrdata["HVLV_SFRA"]= $set->getField("HVLV_SFRA");
        $arrdata["HVLV_DL_SFRA"]= $set->getField("HVLV_DL_SFRA");
        $arrdata["HVLV_NCEPRI_SFRA"]= $set->getField("HVLV_NCEPRI_SFRA");

       array_push($arrsfraHvLv, $arrdata);
    }
    unset($set);

    $set= new FormUji();
    $arrsfraHvShort= [];
    $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqTipeId." AND FORM_UJI_ID = '".$reqId."' AND TIPE_SFRA = '4' ";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
        $arrdata["parent"]= $set->getField("FORM_UJI_ID");
        $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

        $arrdata["HV_SHORT_SFRA"]= $set->getField("HV_SHORT_SFRA");
        $arrdata["HV_SHORT_DL_SFRA"]= $set->getField("HV_SHORT_DL_SFRA");
        $arrdata["HV_SHORT_NCEPRI_SFRA"]= $set->getField("HV_SHORT_NCEPRI_SFRA");

       array_push($arrsfraHvShort, $arrdata);
    }
    unset($set);

    $set= new FormUji();
    $arrsfraHvGround= [];
    $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqTipeId." AND FORM_UJI_ID = '".$reqId."' AND TIPE_SFRA = '5' ";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_DETIL_ID");
        $arrdata["parent"]= $set->getField("FORM_UJI_ID");
        $arrdata["tipe"]= $set->getField("FORM_UJI_TIPE_ID");

        $arrdata["HVLV_GROUND_SFRA"]= $set->getField("HVLV_GROUND_SFRA");
        $arrdata["HVLV_GROUND_DL_SFRA"]= $set->getField("HVLV_GROUND_DL_SFRA");
        $arrdata["HVLV_GROUND_NCEPRI_SFRA"]= $set->getField("HVLV_GROUND_NCEPRI_SFRA");

       array_push($arrsfraHvGround, $arrdata);
    }
    unset($set);
}	
?>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Kode Form Uji</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" required style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Form Uji</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" required style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Status</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input   name="reqStatus" class="easyui-combobox form-control" id="reqStatus"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combostatusaktif'" value="<?=$reqStatus?>" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tipe</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input   name="reqTipeId" class="easyui-combobox form-control" id="reqTipeId"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combotipeformuji'" value="<?=$reqTipeId?>" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="umum">
                        <div id="air_temperature">
                            <div class="form-group">  
                                <label class="control-label col-md-2">Air Temperature</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqAirTemperature"  id="reqAirTemperature" value="<?=$reqAirTemperature?>"  style="width:100%"/>
                                       </div>
                                   </div>
                               </div>
                           </div>
                        </div>
                        <div id="air_humidity">
                            <div class="form-group">  
                                <label class="control-label col-md-2">Air Humidity</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqAirHumidity"  id="reqAirHumidity" value="<?=$reqAirHumidity?>"  style="width:100%"/>
                                       </div>
                                   </div>
                               </div>
                           </div>
                        </div>
                        <div id="oil_temp">
                            <div class="form-group">  
                                <label class="control-label col-md-2">Oil Temp</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqOilTemp"  id="reqOilTemp" value="<?=$reqOilTemp?>"  style="width:100%"/>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                        <div id="tap_changer">
                            <div class="form-group">  
                                <label class="control-label col-md-2">Tap Changer</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqTapChanger"  id="reqTapChanger" value="<?=$reqTapChanger?>"  style="width:100%"/>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div id="aparatus">
                            <div class="form-group">  
                                <label class="control-label col-md-2">Apparatus Temp</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqAparatusTemp"  id="reqAparatusTemp" value="<?=$reqAparatusTemp?>"  style="width:100%"/>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div id="weather">
                            <div class="form-group">  
                                <label class="control-label col-md-2">Weather</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqWeather"  id="reqWeather" value="<?=$reqWeather?>"  style="width:100%"/>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                    </div>

                    <div id="di_electric">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Calculated Moisture</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqCalculatedMoisture"  id="reqCalculatedMoisture" value="<?=$reqCalculatedMoisture?>"  style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Moisture Saturation</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqMoistureSaturation"  id="reqMoistureSaturation" value="<?=$reqMoistureSaturation?>"  style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Moisture Category</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqMoistureCategory"  id="reqMoistureCategory" value="<?=$reqMoistureCategory?>"  style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Oil Temperature</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqOilTemperature"  id="reqOilTemperature" value="<?=$reqOilTemperature?>"  style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Oil Conductivity</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqOilConductivity"  id="reqOilConductivity"  value="<?=$reqOilConductivity?>" style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Oil Category</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqOilCategory"  id="reqOilCategory" value="<?=$reqOilCategory?>"  style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Capacitance</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqCapacitance"  id="reqCapacitance" value="<?=$reqCapacitance?>"  style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Barriers</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqBarriers"  id="reqBarriers" value="<?=$reqBarriers?>"  style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Polarization Index</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqPolarizationIndex" value="<?=$reqPolarizationIndex?>"  id="reqPolarizationIndex"  style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Tan</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqTan"  id="reqTan" value="<?=$reqTan?>" style="width:100%"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Spacers</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqSpacers"  id="reqSpacers" value="<?=$reqSpacers?>"  style="width:100%"/>
                                    </div>
                                </div>
                           </div>
                       </div>  
                    </div>

                    <div id="irpi">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Reference</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <textarea autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqReference"  id="reqReference"  style="width:100%"><?=$reqReference?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="max_dev">
                            <div class="form-group">  
                                <label class="control-label col-md-2">Max Dev</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <textarea autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqMaxDev"  id="reqMaxDev"  style="width:100%"><?=$reqMaxDev?></textarea>
                                       </div>
                                   </div>
                               </div>
                           </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Result</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqResult"  id="reqResult" value="<?=$reqResult?>"  style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Note</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <textarea autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNote"  id="reqNote"  style="width:100%"><?=$reqNote?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="moisture">
                        <div class="page-header">
                            <h3><i class="fa fa-file-text fa-lg"></i> Moisture Categories</h3>       
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Dry</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <textarea autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqDry"  id="reqDry"  style="width:100%"><?=$reqDry?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Moderately wet</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <textarea autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqModeratelyWet"  id="reqModeratelyWet"  style="width:100%"><?=$reqModeratelyWet?></textarea>
                                    </div>
                                </div>
                            </div>
                         </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Wet</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqWet"  id="reqWet" value="<?=$reqWet?>"  style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Extremely wet</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqExtremeWet"  id="reqExtremeWet" value="<?=$reqExtremeWet?>"  style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Upload Gambar</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input  class="easyui-validatebox textbox form-control" type="file" name="reqGambarDI"  id="reqGambarDI" accept=".jpg,.png,.jpeg"  style="width:100%" />
                                       <?
                                       if($reqGambarDI)
                                       {
                                           ?>
                                           <a href="<?=$reqGambarDI?>" target="_blank"><img src="<?=$reqGambarDI?>" width="200px" height="200px"></a>
                                           <?
                                       }
                                       ?>
                                   </div>
                               </div>
                           </div>
                       </div>
                    </div>
                    <div id="upload_sfra">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Upload Gambar</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input  class="easyui-validatebox textbox form-control" type="file" name="reqGambarSfra[]"  id="reqGambarSfra" accept=".jpg,.png,.jpeg" multiple style="width:100%" />
                                       <?
                                       if($reqGambarSfra)
                                       {
                                           ?>
                                           <a href="<?=$reqGambarSfra?>" target="_blank"><img src="<?=$reqGambarSfra?>" width="200px" height="200px"></a>
                                           <?
                                       }
                                       ?>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>


                    <?
                    if(!empty($arrgambarsfra))
                    {
                    ?>
                        <div id="upload_sfra_gambar">
                            <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                                <thead>
                                    <tr>
                                          <th style="vertical-align : middle;text-align:center;width: 40%">Gambar</th>
                                          <th style="vertical-align : middle;text-align:center;" >Nama File </th>
                                          <th style="vertical-align : middle;text-align:center;" >Action </th>
                                    </tr>
                                </thead>
                                <tbody id="tableSfra">
                                        <?
                                        foreach($arrgambarsfra as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectlink=$item["LINK_GAMBAR"];
                                            $selectnama=$item["NAMA"];
                                            $selecttipe=$item["tipe"];
                                            ?>
                                            <tr  id="sfradetil-<?=$selectvalid?>">
                                                <td><img src="<?=$selectlink?>" width="200px" height="200px">
                                                </td>
                                                <td><?=$selectnama?>
                                                </td>

                                                <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusGambar("<?=$selectvalid?>","sfradetil","<?=$selecttipe?>")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                                </td>
                                            </tr>
                                            <?
                                        }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    <?
                    }
                    ?>

                    <div id="irpitabel">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddIrpi()">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                      <th rowspan="2" style="vertical-align : middle;text-align:center;">Waktu (menit)</th>
                                      <th colspan="1" style="vertical-align : middle;text-align:center;" >HV - Gnd (GΩ)</th>
                                      <th colspan="1" style="vertical-align : middle;text-align:center;" >LV - Gnd (GΩ)</th>
                                      <th colspan="1" style="vertical-align : middle;text-align:center;">HV - LV (GΩ)</th>
                                      <th rowspan="2" style="vertical-align : middle;text-align:center;">Actions</th>
                                </tr>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">5000 Vdc</th>
                                    <th style="vertical-align : middle;text-align:center;">2500 Vdc</th>
                                    <th style="vertical-align : middle;text-align:center;">2500 Vdc</th>
                                </tr>
                            </thead>
                            <tbody id="tableIrpi">
                                    <?
                                    foreach($arrwaktu as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectparent=$item["parent"];
                                        $selecttipe=$item["tipe"];
                                        $selectwaktu= $item["waktu"];
                                        $selecthv_gnd= $item["hv_gnd"];
                                        $selectlv_gnd= $item["lv_gnd"];
                                        $selecthv_lv= $item["hv_lv"];
                                        ?>

                                        <tr id="irpidetil-<?=$selectvalid?>" >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWaktu[]' id='reqWaktu' value='<?=$selectwaktu?>' data-options='' style='width:100%'>
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvGnd[]' id='reqHvGnd' value='<?=$selecthv_gnd?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqLvGnd[]' id='reqLvGnd' value='<?=$selectlv_gnd?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvLv[]' id='reqHvLv' value='<?=$selecthv_lv?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvalid?>","irpidetil","<?=$selecttipe?>")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                            </td>
                                        </tr>

                                        <?
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="hottabel">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddHot()">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                      <th style="vertical-align : middle;text-align:center;">Bushing Fasa</th>
                                      <th style="vertical-align : middle;text-align:center;" >Skirt </th>
                                      <th style="vertical-align : middle;text-align:center;" >Tegangan Injeksi (kV)</th>
                                      <th style="vertical-align : middle;text-align:center;">I (mA)</th>
                                      <th style="vertical-align : middle;text-align:center;">Watts</th>
                                      <th style="vertical-align : middle;text-align:center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tableHot">
                                    <?
                                    foreach($arrwaktu as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectbushing=$item["bushing"];
                                        $selectskirt=$item["skirt"];
                                        $selecttegangan= $item["tegangan"];
                                        $selectima= $item["ima"];
                                        $selectwatts= $item["watts"];
                                        ?>

                                        <tr id="hotdetil-<?=$selectvalid?>" >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqBushing[]' id='reqBushing' value='<?=$selectbushing?>' data-options='' style='width:100%'>
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqSkirt[]' id='reqSkirt' value='<?=$selectskirt?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTeganganInjeksi[]' id='reqTeganganInjeksi' value='<?=$selecttegangan?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqIma[]' id='reqIma' value='<?=$selectima?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWatts[]' id='reqWatts' value='<?=$selectwatts?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvalid?>","hotdetil","<?=$selecttipe?>")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                            </td>
                                        </tr>

                                        <?
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="ectabel">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddEc()">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                  <th rowspan="3" style="vertical-align : middle;text-align:center;">Tap</th>
                                  <th rowspan="3" style="vertical-align : middle;text-align:center;">Tegangan Injeksi (kV)</th>
                                  <th rowspan="1" colspan="9" style="vertical-align : middle;text-align:center;">Excitation current (mA) dan Daya (W)</th>
                                  <th rowspan="3" style="vertical-align : middle;text-align:center;">Actions</th>
                                </tr>
                                <tr>
                                   <th colspan="3" style="vertical-align : middle;text-align:center;" >R-T</th>
                                   <th colspan="3" style="vertical-align : middle;text-align:center;" >S-R</th>
                                   <th colspan="3" style="vertical-align : middle;text-align:center;">T-S</th>
                                </tr>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">I (mA)</th>
                                    <th style="vertical-align : middle;text-align:center;">W (watts)</th>
                                    <th style="vertical-align : middle;text-align:center;">L/C</th>
                                    <th style="vertical-align : middle;text-align:center;">I (mA)</th>
                                    <th style="vertical-align : middle;text-align:center;">W (watts)</th>
                                    <th style="vertical-align : middle;text-align:center;">L/C</th>
                                    <th style="vertical-align : middle;text-align:center;">I (mA)</th>
                                    <th style="vertical-align : middle;text-align:center;">W (watts)</th>
                                    <th style="vertical-align : middle;text-align:center;">L/C</th>
                                </tr>

                            </thead>
                            <tbody id="tableEc">
                                    <?
                                    foreach($arrwaktu as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectparent=$item["parent"];
                                        $selecttipe=$item["tipe"];

                                        $selecttap= $item["tap"];
                                        $selecttegangan= $item["tegangan"];

                                        $selectimaRt= $item["ima_rt"];
                                        $selectwattsRt= $item["watts_rt"];
                                        $selectlcRt= $item["lc_rt"];

                                        $selectimaSr= $item["ima_sr"];
                                        $selectwattsSr= $item["watts_sr"];
                                        $selectlcsr= $item["lc_sr"];

                                        $selectimaTs= $item["ima_ts"];
                                        $selectwattsTs= $item["watts_ts"];
                                        $selectlcTs= $item["lc_ts"];
                                        ?>

                                        <tr id="ecdetil-<?=$selectvalid?>" >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTap[]' id='reqTap' value='<?=$selecttap?>' data-options='' style='width:100%'>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTeganganInjeksi[]' id='reqTeganganInjeksi' value='<?=$selecttegangan?>' data-options='' style='width:100%'>

                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqImaRt[]' id='reqImaRt' value='<?=$selectimaRt?>' data-options='' style='width:100%'>
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWattsRt[]' id='reqWattsRt' value='<?=$selectwattsRt?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqLcRt[]' id='reqLcRt' value='<?=$selectlcRt?>' data-options='' style='width:100%' >
                                            </td>

                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqImaSr[]' id='reqImaSr' value='<?=$selectimaSr?>' data-options='' style='width:100%'>
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWattsSr[]' id='reqWattsSr' value='<?=$selectwattsSr?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqLcRt[]' id='reqLcRt' value='<?=$selectlcRt?>' data-options='' style='width:100%' >
                                            </td>

                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqImaTs[]' id='reqImaTs' value='<?=$selectimaTs?>' data-options='' style='width:100%'>
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWattsTs[]' id='reqWattsTs' value='<?=$selectwattsTs?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqLcTs[]' id='reqLcTs' value='<?=$selectlcTs?>' data-options='' style='width:100%' >
                                            </td>
                                           
                                            </td>
                                            <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvalid?>","ecdetil","<?=$selecttipe?>")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                            </td>
                                        </tr>

                                        <?
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="ratiotabel">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddRatio()">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                  <th rowspan="2" style="vertical-align : middle;text-align:center;">Fasa</th>
                                  <th rowspan="2" style="vertical-align : middle;text-align:center;">Tap</th>
                                  <th rowspan="1" colspan="3" style="vertical-align : middle;text-align:center;">Tegangan Nameplate</th>
                                  <th rowspan="1" colspan="5" style="vertical-align : middle;text-align:center;">Hasil Ukur</th>
                                  <th rowspan="2" style="vertical-align : middle;text-align:center;">Deviasi (%)</th>
                                  <th rowspan="2" style="vertical-align : middle;text-align:center;">Actions</th>
                                </tr>
                                <tr>
                                    <th  style="vertical-align : middle;text-align:center;" >HV (kV)</th>
                                    <th  style="vertical-align : middle;text-align:center;" >LV (kV)</th>
                                    <th  style="vertical-align : middle;text-align:center;" >Rasio</th>

                                    <th  style="vertical-align : middle;text-align:center;" >HV (V)</th>
                                    <th  style="vertical-align : middle;text-align:center;" >°</th>
                                    <th  style="vertical-align : middle;text-align:center;" >LV (V)</th>
                                    <th  style="vertical-align : middle;text-align:center;" >°</th>
                                    <th  style="vertical-align : middle;text-align:center;" >Rasio</th>
                                </tr>
                            
                            </thead>
                            <tbody id="tableRatio">
                                    <?
                                    foreach($arrwaktu as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectparent=$item["parent"];
                                        $selecttipe=$item["tipe"];

                                        $reqFasaRatio= $item["fasa_ratio"];
                                        $reqTapRatio= $item["tap_ratio"];
                                        $reqHvKv= $item["hv_kv"];
                                        $reqLvKv= $item["lv_kv"];
                                        $reqRasioTegangan= $item["rasio_tegangan"];
                                        $reqHvV= $item["hv_v"];
                                        $reqDerajatHvV= $item["DERAJAT_HV_V"];
                                        $reqLvV= $item["LV_V"];
                                        $reqDerajatLvV= $item["DERAJAT_LV_V"];
                                        $reqRasioHasil= $item["RASIO_HASIL"];
                                        $reqDeviasi= $item["DEVIASI"];


                                        ?>

                                        <tr id="ratiodetil-<?=$selectvalid?>" >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqFasaRatio[]' id='reqFasaRatio' value='<?=$reqFasaRatio?>' data-options='' style='width:100%'>

                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTapRatio[]' id='reqTapRatio' value='<?=$reqTapRatio?>' data-options='' style='width:100%'>
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvKv[]' id='reqHvKv' value='<?=$reqHvKv?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqLvKv[]' id='reqLcRt' value='<?=$reqLvKv?>' data-options='' style='width:100%' >
                                            </td>

                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqRasioTegangan[]' id='reqRasioTegangan' value='<?=$reqRasioTegangan?>' data-options='' style='width:100%'>
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvV[]' id='reqHvV' value='<?=$reqHvV?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqDerajatHvV[]' id='reqDerajatHvV' value='<?=$reqDerajatHvV?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqLvV[]' id='reqLvV' value='<?=$reqLvV?>' data-options='' style='width:100%' >
                                            </td>

                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqDerajatLvV[]' id='reqDerajatLvV' value='<?=$reqDerajatLvV?>' data-options='' style='width:100%'>
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqRasioHasil[]' id='reqRasioHasil' value='<?=$reqRasioHasil?>' data-options='' style='width:100%' >
                                            </td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqDeviasi[]' id='reqDeviasi' value='<?=$reqDeviasi?>' data-options='' style='width:100%' >
                                            </td>
                                           
                                            </td>
                                            <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvalid?>","ratiodetil","<?=$selecttipe?>")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                            </td>
                                        </tr>

                                        <?
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>

                      <div id="rdctabel">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddRdc()">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">Sisi</th>
                                    <th  style="vertical-align : middle;text-align:center;">Tap</th>
                                    <th  style="vertical-align : middle;text-align:center;">Fasa **</th>
                                    <th  style="vertical-align : middle;text-align:center;">Arus DC Test (A)</th>
                                    <th  style="vertical-align : middle;text-align:center;">Tegangan DC (V)</th>
                                    <th  style="vertical-align : middle;text-align:center;">Tahanan ukur 34°C </th>
                                    <th  style="vertical-align : middle;text-align:center;">Tahanan temp ref 75°C </th>
                                    <th  style="vertical-align : middle;text-align:center;">Dev (%)* </th>
                                    <th  style="vertical-align : middle;text-align:center;">Action</th>
                                 </tr>

                            
                            </thead>
                            <tbody id="tableRdc">
                                    <?
                                    foreach($arrwaktu as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectparent=$item["parent"];
                                        $selecttipe=$item["tipe"];

                                        $reqSisiRdc= $item["SISI_RDC"];
                                        $reqTapRdc= $item["TAP_RDC"];

                                        $reqFasaRdcR= $item["FASA_RDC_R"];
                                        $reqArusRdcR= $item["ARUS_RDC_R"];
                                        $reqTeganganRdcR= $item["TEGANGAN_RDC_R"];
                                        $reqTahananRdcR= $item["TAHANAN_RDC_R"];
                                        $reqTahananTempRdcR= $item["TAHANAN_TEMP_RDC_R"];
                                        $reqDeviasiRdcR= $item["DEV_RDC_R"];

                                        $reqFasaRdcS= $item["FASA_RDC_S"];
                                        $reqArusRdcS= $item["ARUS_RDC_S"];
                                        $reqTeganganRdcS= $item["TEGANGAN_RDC_S"];
                                        $reqTahananRdcS= $item["TAHANAN_RDC_S"];
                                        $reqTahananTempRdcS= $item["TAHANAN_TEMP_RDC_S"];
                                        $reqDeviasiRdcS= $item["DEV_RDC_S"];

                                        $reqFasaRdcT= $item["FASA_RDC_T"];
                                        $reqArusRdcT= $item["ARUS_RDC_T"];
                                        $reqTeganganRdcT= $item["TEGANGAN_RDC_T"];
                                        $reqTahananRdcT= $item["TAHANAN_RDC_T"];
                                        $reqTahananTempRdcT= $item["TAHANAN_TEMP_RDC_T"];
                                        $reqDeviasiRdcT= $item["DEV_RDC_T"];

                                    ?>
                                        <tr  id="rdcdetil-<?=$selectvalid?>" >
                                            <td rowspan="3" style="vertical-align : middle;text-align:center;"><input class='easyui-validatebox textbox form-control' type='text' name='reqSisiRdc[]' id='reqSisiRdc' value='<?=$reqSisiRdc?>' data-options='' style='width:100%'></td>
                                            <td rowspan="3" style="vertical-align : middle;text-align:center;"><input class='easyui-validatebox textbox form-control' type='text' name='reqTapRdc[]' id='reqTapRdc' value='<?=$reqTapRdc?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqFasaRdcR[]' id='reqFasaRdcR' value='<?=$reqFasaRdcR?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqArusRdcR[]' id='reqArusRdcR' value='<?=$reqArusRdcR?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTeganganRdcR[]' id='reqTeganganRdcR' value='<?=$reqTeganganRdcR?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTahananRdcR[]' id='reqTahananRdcR' value='<?=$reqTahananRdcR?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTahananTempRdcR[]' id='reqTahananTempRdcR' value='<?=$reqTahananTempRdcR?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqDeviasiRdcR[]' id='reqDeviasiRdcR' value='<?=$reqDeviasiRdcR?>' data-options='' style='width:100%'></td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqFasaRdcS[]' id='reqFasaRdcS' value='<?=$reqFasaRdcS?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqArusRdcS[]' id='reqArusRdcS' value='<?=$reqArusRdcS?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTeganganRdcS[]' id='reqTeganganRdcS' value='<?=$reqTeganganRdcS?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTahananRdcS[]' id='reqTahananRdcS' value='<?=$reqTahananRdcS?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTahananTempRdcS[]' id='reqTahananTempRdcS' value='<?=$reqTahananTempRdcS?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqDeviasiRdcS[]' id='reqDeviasiRdcS' value='<?=$reqDeviasiRdcS?>' data-options='' style='width:100%'></td>
                                            <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvalid?>","rdcdetil","<?=$selecttipe?>")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqFasaRdcT[]' id='reqFasaRdcT' value='<?=$reqFasaRdcT?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqArusRdcT[]' id='reqArusRdcT' value='<?=$reqArusRdcT?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTeganganRdcT[]' id='reqTeganganRdcT' value='<?=$reqTeganganRdcT?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTahananRdcT[]' id='reqTahananRdcT' value='<?=$reqTahananRdcT?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTahananTempRdcT[]' id='reqTahananTempRdcT' value='<?=$reqTahananTempRdcT?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqDeviasiRdcT[]' id='reqDeviasiRdcT' value='<?=$reqDeviasiRdcT?>' data-options='' style='width:100%'></td>
                                            <td>
                                            </td>
                                        </tr>

                                        <?
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="tantabel">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTan()">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">Winding</th>
                                    <th  style="vertical-align : middle;text-align:center;">Measure</th>
                                    <th  style="vertical-align : middle;text-align:center;">Test (kV)</th>
                                    <th  style="vertical-align : middle;text-align:center;">Arus (mA)</th>
                                    <th  style="vertical-align : middle;text-align:center;">Daya (W)</th>
                                    <th  style="vertical-align : middle;text-align:center;">% PF corr</th>
                                    <th  style="vertical-align : middle;text-align:center;">Corr Fact </th>
                                    <th  style="vertical-align : middle;text-align:center;">Cap(pF) </th>
                                    <th  style="vertical-align : middle;text-align:center;">Action</th>
                                 </tr>
                            </thead>
                           <tbody id="tableTan">
                                    <?
                                    foreach($arrwindingtan as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectparent=$item["parent"];
                                        $selecttipe=$item["tipe"];

                                        $reqWindingTan= $item["WINDING_TAN"];

                                        $reqMeasureTanChChl= $item["MEASURE_TAN_CH_CHL"];
                                        $reqTestTanChChl= $item["TEST_TAN_CH_CHL"];
                                        $reqArusTanChChl= $item["ARUS_TAN_CH_CHL"];
                                        $reqDayaTanChChl= $item["DAYA_TAN_CH_CHL"];
                                        $reqPfCorrTanChChl= $item["PF_CORR_TAN_CH_CHL"];
                                        $reqCorrFactTanChChl= $item["CORR_FACT_TAN_CH_CHL"];
                                        $reqCapTanChChl= $item["CAP_TAN_CH_CHL"];

                                        $reqMeasureTanCh= $item["MEASURE_TAN_CH"];
                                        $reqTestTanCh= $item["TEST_TAN_CH"];
                                        $reqArusTanCh= $item["ARUS_TAN_CH"];
                                        $reqDayaTanCh= $item["DAYA_TAN_CH"];
                                        $reqPfCorrTanCh= $item["PF_CORR_TAN_CH"];
                                        $reqCorrFactTanCh= $item["CORR_FACT_TAN_CH"];
                                        $reqCapTanCh= $item["CAP_TAN_CH"];

                                        $reqMeasureTanChlUst= $item["MEASURE_TAN_CHL_UST"];
                                        $reqTestTanChlUst= $item["TEST_TAN_CHL_UST"];
                                        $reqArusTanChlUst= $item["ARUS_TAN_CHL_UST"];
                                        $reqDayaTanChlUst= $item["DAYA_TAN_CHL_UST"];
                                        $reqPfCorrTanChlUst= $item["PF_CORR_TAN_CHL_UST"];
                                        $reqCorrFactTanChlUst= $item["CORR_FACT_TAN_CHL_UST"];
                                        $reqCapTanChlUst= $item["CAP_TAN_CHL_UST"];

                                        $reqMeasureTanChl= $item["MEASURE_TAN_CHL"];
                                        $reqTestTanChl= $item["TEST_TAN_CHL"];
                                        $reqArusTanChl= $item["ARUS_TAN_CHL"];
                                        $reqDayaTanChl= $item["DAYA_TAN_CHL"];
                                        $reqPfCorrTanChl= $item["PF_CORR_TAN_CHL"];
                                        $reqCorrFactTanChl= $item["CORR_FACT_TAN_CHL"];
                                        $reqCapTanChl= $item["CAP_TAN_CHL"];


                                    ?>
                                        <tr id="tandetil-<?=$selectvalid?>" >
                                            <td rowspan="4" style="vertical-align : middle;text-align:center;"><input class='easyui-validatebox textbox form-control' type='text' name='reqWindingTan[]' id='reqWindingTan' value='<?=$reqWindingTan?>' data-options='' style='width:100%'></td>
                                            <td  style="vertical-align : middle;text-align:center;"><input class='easyui-validatebox textbox form-control' type='text' name='reqMeasureTanChChl[]' id='reqMeasureTanChChl' value='<?=$reqMeasureTanChChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTestTanChChl[]' id='reqTestTanChChl' value='<?=$reqTestTanChChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqArusTanChChl[]' id='reqArusTanChChl' value='<?=$reqArusTanChChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqDayaTanChChl[]' id='reqDayaTanChChl' value='<?=$reqDayaTanChChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqPfCorrTanChChl[]' id='reqPfCorrTanChChl' value='<?=$reqPfCorrTanChChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqCorrFactTanChChl[]' id='reqCorrFactTanChChl' value='<?=$reqCorrFactTanChChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqCapTanChChl[]' id='reqCapTanChChl' value='<?=$reqCapTanChChl?>' data-options='' style='width:100%'></td>
                                            <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTableTan("<?=$selectvalid?>","tandetil","<?=$selecttipe?>",1)'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  style="vertical-align : middle;text-align:center;"><input class='easyui-validatebox textbox form-control' type='text' name='reqMeasureTanCh[]' id='reqMeasureTanCh' value='<?=$reqMeasureTanCh?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTestTanCh[]' id='reqTestTanCh' value='<?=$reqTestTanCh?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqArusTanCh[]' id='reqArusTanCh' value='<?=$reqArusTanCh?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqDayaTanCh[]' id='reqDayaTanCh' value='<?=$reqDayaTanCh?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqPfCorrTanCh[]' id='reqPfCorrTanCh' value='<?=$reqPfCorrTanCh?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqCorrFactTanCh[]' id='reqCorrFactTanCh' value='<?=$reqCorrFactTanCh?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqCapTanCh[]' id='reqCapTanCh' value='<?=$reqCapTanCh?>' data-options='' style='width:100%'></td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr >
                                            <td  style="vertical-align : middle;text-align:center;"><input class='easyui-validatebox textbox form-control' type='text' name='reqMeasureTanChlUst[]' id='reqMeasureTanChlUst' value='<?=$reqMeasureTanChlUst?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTestTanChlUst[]' id='reqTestTanChlUst' value='<?=$reqTestTanChlUst?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqArusTanChlUst[]' id='reqArusTanChlUst' value='<?=$reqArusTanChlUst?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqDayaTanChlUst[]' id='reqDayaTanChlUst' value='<?=$reqDayaTanChlUst?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqPfCorrTanChlUst[]' id='reqPfCorrTanChlUst' value='<?=$reqPfCorrTanChlUst?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqCorrFactTanChlUst[]' id='reqCorrFactTanChlUst' value='<?=$reqCorrFactTanChlUst?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqCapTanChlUst[]' id='reqCapTanChlUst' value='<?=$reqCapTanChlUst?>' data-options='' style='width:100%'></td>
                                            <td>
                                            </td>
                                        </tr>
                                        <tr >

                                            <td  style="vertical-align : middle;text-align:center;"><input class='easyui-validatebox textbox form-control' type='text' name='reqMeasureTanChl[]' id='reqMeasureTanChl' value='<?=$reqMeasureTanChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTestTanChl[]' id='reqTestTanChl' value='<?=$reqTestTanChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqArusTanChl[]' id='reqArusTanChl' value='<?=$reqArusTanChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqDayaTanChl[]' id='reqDayaTanChl' value='<?=$reqDayaTanChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqPfCorrTanChl[]' id='reqPfCorrTanChl' value='<?=$reqPfCorrTanChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqCorrFactTanChl[]' id='reqCorrFactTanChl' value='<?=$reqCorrFactTanChl?>' data-options='' style='width:100%'></td>
                                            <td><input class='easyui-validatebox textbox form-control' type='text' name='reqCapTanChl[]' id='reqCapTanChl' value='<?=$reqCapTanChl?>' data-options='' style='width:100%'></td>
                                            <td>
                                            </td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                            </tbody>
                        </table>
                        <div class="page-header">
                            <h3><i class="fa fa-file-text fa-lg"></i> Winding without Attached Bushing Calculation</h3>       
                        </div>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTanWinding()">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <tbody id="tableWinding">
                            <?
                            foreach($arrwindingwithouttan as $item) 
                             {
                                $selectvalid= $item["id"];
                                $selectparent=$item["parent"];
                                $selecttipe=$item["tipe"];

                                $reqWindingWithoutTan1= $item["WINDING_WITHOUT_TAN_1"];
                                $reqWindingWithoutTan2= $item["WINDING_WITHOUT_TAN_2"];
                                $reqWindingWithoutTan3= $item["WINDING_WITHOUT_TAN_3"];
                                $reqWindingWithoutTan4= $item["WINDING_WITHOUT_TAN_4"];
                                $reqWindingWithoutTan5= $item["WINDING_WITHOUT_TAN_5"];
                                $reqWindingWithoutTan6= $item["WINDING_WITHOUT_TAN_6"];
                                $reqWindingWithoutTan7= $item["WINDING_WITHOUT_TAN_7"];
                                $reqWindingWithoutTan8= $item["WINDING_WITHOUT_TAN_8"];
                            ?>
                                <tr id="windingdetil-<?=$selectvalid?>">
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWindingWithoutTan1[]' id='reqWindingWithoutTan1' value='<?=$reqWindingWithoutTan1?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWindingWithoutTan2[]' id='reqWindingWithoutTan2' value='<?=$reqWindingWithoutTan2?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWindingWithoutTan3[]' id='reqWindingWithoutTan3' value='<?=$reqWindingWithoutTan3?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWindingWithoutTan4[]' id='reqWindingWithoutTan4' value='<?=$reqWindingWithoutTan4?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWindingWithoutTan5[]' id='reqWindingWithoutTan5' value='<?=$reqWindingWithoutTan5?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWindingWithoutTan6[]' id='reqWindingWithoutTan6' value='<?=$reqWindingWithoutTan6?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWindingWithoutTan7[]' id='reqWindingWithoutTan7' value='<?=$reqWindingWithoutTan7?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqWindingWithoutTan8[]' id='reqWindingWithoutTan8' value='<?=$reqWindingWithoutTan8?>'  data-options='' style='width:100%'></td>
                                    <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTableTan("<?=$selectvalid?>","windingdetil","<?=$selecttipe?>",2)'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                    </td>
                                </tr>
                            <?
                            }
                            ?>
                            </tbody>
                        </table>
                        <div class="page-header">
                            <h3><i class="fa fa-file-text fa-lg"></i> Reference Tabel</h3>       
                        </div>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTanRef()">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">Condition</th>
                                    <th  style="vertical-align : middle;text-align:center;">Good</th>
                                    <th  style="vertical-align : middle;text-align:center;">Maybe acceptable</th>
                                    <th  style="vertical-align : middle;text-align:center;">Investigated</th>
                                    <th  style="vertical-align : middle;text-align:center;">Action</th>
                                 </tr>
                            </thead>
                            <tbody id="tableRef">
                               <?
                               foreach($arrtanref as $item) 
                               {
                                    $selectvalid= $item["id"];
                                    $selectparent=$item["parent"];
                                    $selecttipe=$item["tipe"];

                                    $reqConditionTan= $item["CONDITION_TAN"];
                                    $reqGoodTan= $item["GOOD_TAN"];
                                    $reqMaybeTan= $item["MAYBE_TAN"];
                                    $reqInvestigatedTan= $item["INVESTIGATED_TAN"];

                                ?>
                                <tr id="refdetil-<?=$selectvalid?>">
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqConditionTan[]' id='reqConditionTan' value='<?=$reqConditionTan?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqGoodTan[]' id='reqGoodTan' value='<?=$reqGoodTan?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqMaybeTan[]' id='reqMaybeTan' value='<?=$reqMaybeTan?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqInvestigatedTan[]' id='reqInvestigatedTan' value='<?=$reqInvestigatedTan?>'  data-options='' style='width:100%'></td>
                                    <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTableTan("<?=$selectvalid?>","refdetil","<?=$selecttipe?>",3)'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                    </td>
                                </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="sfratabelHv">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddSfra(1)">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">HV</th>
                                    <th  style="vertical-align : middle;text-align:center;">DL/T911-2004</th>
                                    <th  style="vertical-align : middle;text-align:center;">NCEPRI</th>
                                    <th  style="vertical-align : middle;text-align:center;">Action</th>
                                 </tr>
                            </thead>
                            <tbody id="tableSfraHv">
                               <?
                               foreach($arrsfraHv as $item) 
                               {
                                    $selectvalid= $item["id"];
                                    $selectparent=$item["parent"];
                                    $selecttipe=$item["tipe"];

                                    $reqHvSfra= $item["HV_SFRA"];
                                    $reqHvDlSfra= $item["HV_DL_SFRA"];
                                    $reqHvNcepriSfra= $item["HV_NCEPRI_SFRA"];

                                ?>
                                <tr id="sfraHvdetil-<?=$selectvalid?>">
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvSfra[]' id='reqHvSfra' value='<?=$reqHvSfra?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvDlSfra[]' id='reqHvDlSfra' value='<?=$reqHvDlSfra?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvNcepriSfra[]' id='reqHvNcepriSfra' value='<?=$reqHvNcepriSfra?>'  data-options='' style='width:100%'></td>
                                    <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTableSfra("<?=$selectvalid?>","sfraHvdetil","<?=$selecttipe?>",1)'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                    </td>
                                </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                        
                    </div>

                    <div id="sfratabelLv">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddSfra(2)">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">LV</th>
                                    <th  style="vertical-align : middle;text-align:center;">DL/T911-2004</th>
                                    <th  style="vertical-align : middle;text-align:center;">NCEPRI</th>
                                    <th  style="vertical-align : middle;text-align:center;">Action</th>
                                 </tr>
                            </thead>
                            <tbody id="tableSfraLv">
                               <?
                               foreach($arrsfraLv as $item) 
                               {
                                    $selectvalid= $item["id"];
                                    $selectparent=$item["parent"];
                                    $selecttipe=$item["tipe"];

                                    $reqLvSfra= $item["LV_SFRA"];
                                    $reqLvDlSfra= $item["LV_DL_SFRA"];
                                    $reqLvNcepriSfra= $item["LV_NCEPRI_SFRA"];

                                ?>
                                <tr id="sfraLvdetil-<?=$selectvalid?>">
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqLvSfra[]' id='reqLvSfra' value='<?=$reqLvSfra?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqLvDlSfra[]' id='reqHvDlSfra' value='<?=$reqLvDlSfra?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqLvNcepriSfra[]' id='reqLvNcepriSfra' value='<?=$reqLvNcepriSfra?>'  data-options='' style='width:100%'></td>
                                    <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTableSfra("<?=$selectvalid?>","sfraLvdetil","<?=$selecttipe?>",2)'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                    </td>
                                </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="sfratabelHvLv">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddSfra(3)">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">HV-LV</th>
                                    <th  style="vertical-align : middle;text-align:center;">DL/T911-2004</th>
                                    <th  style="vertical-align : middle;text-align:center;">NCEPRI</th>
                                    <th  style="vertical-align : middle;text-align:center;">Action</th>
                                 </tr>
                            </thead>
                            <tbody id="tableSfraHvLv">
                               <?
                               foreach($arrsfraHvLv as $item) 
                               {
                                    $selectvalid= $item["id"];
                                    $selectparent=$item["parent"];
                                    $selecttipe=$item["tipe"];

                                    $reqHvLvSfra= $item["HVLV_SFRA"];
                                    $reqHvLvDlSfra= $item["HVLV_DL_SFRA"];
                                    $reqHvLvNcepriSfra= $item["HVLV_NCEPRI_SFRA"];

                                ?>
                                <tr id="sfraHvLvdetil-<?=$selectvalid?>">
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvLvSfra[]' id='reqHvLvSfra' value='<?=$reqHvLvSfra?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvLvDlSfra[]' id='reqHvLvDlSfra' value='<?=$reqHvLvDlSfra?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvLvNcepriSfra[]' id='reqHvLvNcepriSfra' value='<?=$reqHvLvNcepriSfra?>'  data-options='' style='width:100%'></td>
                                    <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTableSfra("<?=$selectvalid?>","sfraHvLvdetil","<?=$selecttipe?>",3)'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                    </td>
                                </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                        
                    </div>

                    <div id="sfratabelHvShort">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddSfra(4)">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">HV (Shorted)</th>
                                    <th  style="vertical-align : middle;text-align:center;">DL/T911-2004</th>
                                    <th  style="vertical-align : middle;text-align:center;">NCEPRI</th>
                                    <th  style="vertical-align : middle;text-align:center;">Action</th>
                                 </tr>
                            </thead>
                            <tbody id="tableSfraHvShort">
                               <?
                               foreach($arrsfraHvShort as $item) 
                               {
                                    $selectvalid= $item["id"];
                                    $selectparent=$item["parent"];
                                    $selecttipe=$item["tipe"];

                                    $reqHvShortSfra= $item["HV_SHORT_SFRA"];
                                    $reqHvShortDlSfra= $item["HV_SHORT_DL_SFRA"];
                                    $reqHvShortNcepriSfra= $item["HV_SHORT_NCEPRI_SFRA"];

                                ?>
                                <tr id="sfraHvShortdetil-<?=$selectvalid?>">
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvShortSfra[]' id='reqHvShortSfra' value='<?=$reqHvShortSfra?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvShortDlSfra[]' id='reqHvShortDlSfra' value='<?=$reqHvShortDlSfra?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvShortNcepriSfra[]' id='reqHvShortNcepriSfra' value='<?=$reqHvShortNcepriSfra?>'  data-options='' style='width:100%'></td>
                                    <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTableSfra("<?=$selectvalid?>","sfraHvShortdetil","<?=$selecttipe?>",4)'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                    </td>
                                </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                        
                    </div>

                    <div id="sfratabelHvGround">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddSfra(5)">Tambah</a>
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                            <thead>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;">HV-LV(Grounded)</th>
                                    <th  style="vertical-align : middle;text-align:center;">DL/T911-2004</th>
                                    <th  style="vertical-align : middle;text-align:center;">NCEPRI</th>
                                    <th  style="vertical-align : middle;text-align:center;">Action</th>
                                 </tr>
                            </thead>
                            <tbody id="tableSfraHvGround">
                               <?
                               foreach($arrsfraHvGround as $item) 
                               {
                                    $selectvalid= $item["id"];
                                    $selectparent=$item["parent"];
                                    $selecttipe=$item["tipe"];

                                    $reqHvLvGroundSfra= $item["HVLV_GROUND_SFRA"];
                                    $reqHvLvGroundDlSfra= $item["HVLV_GROUND_DL_SFRA"];
                                    $reqHvLvGroundNcepriSfra= $item["HVLV_GROUND_NCEPRI_SFRA"];

                                ?>
                                <tr id="sfraHvGrounddetil-<?=$selectvalid?>">
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvLvGroundSfra[]' id='reqHvLvGroundSfra' value='<?=$reqHvLvGroundSfra?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvLvGroundDlSfra[]' id='reqHvLvGroundDlSfra' value='<?=$reqHvLvGroundDlSfra?>'  data-options='' style='width:100%'></td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvLvGroundNcepriSfra[]' id='reqHvLvGroundNcepriSfra' value='<?=$reqHvLvGroundNcepriSfra?>'  data-options='' style='width:100%'></td>
                                    <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTableSfra("<?=$selectvalid?>","sfraHvGrounddetil","<?=$selecttipe?>",5)'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                    </td>
                                </tr>
                                <?
                                }
                                ?>
                            </tbody>
                        </table>
                        
                    </div>
                    
                    
                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>

            </div>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>
                <?
                if(!empty($reqId))
                {
                ?>
                    <span id="cetak">
                        <a href="javascript:void(0)" class="btn btn-success" onclick="cetak_excel()"><i class="fa fa-file-word-o" aria-hidden="true"></i> Cetak Excel</a>
                        <!-- <a href="javascript:void(0)" class="btn btn-info" onclick="cetak_word()"><i class="fa fa-file-word-o" aria-hidden="true"></i> Cetak Word</a> -->
                        <a href="javascript:void(0)" class="btn btn-danger" onclick="cetak_pdf()"><i class="fa fa-file-pdf"></i> Cetak PDF</a>
                    </span>
                <?
                }
                ?>
              
            </div>
            
        </div>
    </div>
    
</div>

<script>

var reqTipe =$('#reqTipeId').val();
var reqId ='<?=$reqId?>';

kondisiTipe(reqTipe);

function kondisiTipe(reqTipe){
    // console.log(reqTipe);
    if(reqTipe==1 || reqTipe==2 )
    {
        //ir pi
        $('#irpi').show();
        $('#irpitabel').show();
        $('#sfra').hide();
        $('#max_dev').hide();
        $('#di_electric').hide();
        $('#umum').hide();
        $('#moisture').hide();
        $('#tap_changer').hide();
        $('#aparatus').hide();
        $('#weather').hide();
        $('#hottabel').hide();
        $('#ectabel').hide();
        $('#ratiotabel').hide();
        $('#rdctabel').hide();
        $('#tantabel').hide();
        $('#upload_sfra').hide();
        $('#upload_sfra_gambar').hide();
        $('#sfratabelHv').hide();
        $('#sfratabelLv').hide(); 
        $('#sfratabelHvLv').hide();
        $('#sfratabelHvShort').hide();
        $('#sfratabelHvGround').hide();        
     }
    else if(reqTipe==4)
     {
        //sfra
        $('#irpi').show();
        $('#irpitabel').hide();
        $('#sfra').hide();
        $('#max_dev').hide();
        $('#di_electric').hide();
        $('#umum').show();
        $('#moisture').hide();
        $('#tap_changer').show();
        $('#air_humidity').hide();
        $('#air_temperature').hide();
        $('#aparatus').hide();
        $('#weather').hide();
        $('#hottabel').hide();
        $('#ectabel').hide();
        $('#ratiotabel').hide();
        $('#rdctabel').hide();
        $('#tantabel').hide();
        $('#upload_sfra').show();
        $('#upload_sfra_gambar').show();
        $('#sfratabelHv').show();
        $('#sfratabelLv').show(); 
        $('#sfratabelHvLv').show();
        $('#sfratabelHvShort').show();
        $('#sfratabelHvGround').show();    

    }
    else if(reqTipe==6)
    {
        //Tan Delta
        $('#irpi').show();
        $('#irpitabel').hide();
        $('#sfra').hide();
        $('#max_dev').hide();
        $('#di_electric').hide();
        $('#umum').show();
        $('#moisture').hide();
        $('#tap_changer').hide();
        $('#aparatus').show();
        $('#weather').hide();
        $('#hottabel').hide();
        $('#ectabel').hide();
        $('#ratiotabel').hide();
        $('#rdctabel').hide();
        $('#tantabel').show();
        $('#upload_sfra').hide();
        $('#upload_sfra_gambar').hide();
        $('#sfratabelHv').hide();
        $('#sfratabelLv').hide(); 
        $('#sfratabelHvLv').hide();
        $('#sfratabelHvShort').hide();
        $('#sfratabelHvGround').hide();    

    }

    else if(reqTipe==5)
    {
        // di electric
        $('#irpi').show();
        $('#irpitabel').hide();
        $('#sfra').hide();
        $('#max_dev').hide();
        $('#di_electric').show();
        $('#umum').show();
        $('#aparatus').hide();
        $('#weather').hide();
        $('#moisture').show();
        $('#tap_changer').show();
        $('#weather').hide();
        $('#hottabel').hide();
        $('#ectabel').hide();
        $('#ratiotabel').hide();
        $('#rdctabel').hide();
        $('#tantabel').hide();
        $('#upload_sfra').hide();
        $('#upload_sfra_gambar').hide();
        $('#sfratabelHv').hide();
        $('#sfratabelLv').hide(); 
        $('#sfratabelHvLv').hide();
        $('#sfratabelHvShort').hide();
        $('#sfratabelHvGround').hide();    

    }
    else if(reqTipe==7)
    {
        //hot collar
        $('#irpi').show();
        $('#irpitabel').hide();
        $('#sfra').hide();
        $('#max_dev').hide();
        $('#di_electric').hide();
        $('#umum').show();
        $('#moisture').hide();
        $('#tap_changer').hide();
        $('#aparatus').show();
        $('#weather').show();
        $('#hottabel').show();
        $('#ectabel').hide();
        $('#ratiotabel').hide();
        $('#rdctabel').hide();
        $('#tantabel').hide();
        $('#upload_sfra').hide();
        $('#upload_sfra_gambar').hide();
        $('#sfratabelHv').hide();
        $('#sfratabelLv').hide(); 
        $('#sfratabelHvLv').hide();
        $('#sfratabelHvShort').hide();
        $('#sfratabelHvGround').hide();    

    }
    else if(reqTipe==8)
    {
        //Excitation
        $('#irpi').show();
        $('#irpitabel').hide();
        $('#sfra').hide();
        $('#max_dev').hide();
        $('#di_electric').hide();
        $('#umum').show();
        $('#moisture').hide();
        $('#tap_changer').hide();
        $('#aparatus').show();
        $('#weather').hide();
        $('#hottabel').hide();
        $('#ectabel').show();
        $('#ratiotabel').hide();
        $('#rdctabel').hide();
        $('#tantabel').hide();
        $('#upload_sfra').hide();
        $('#upload_sfra_gambar').hide();
        $('#sfratabelHv').hide();
        $('#sfratabelLv').hide(); 
        $('#sfratabelHvLv').hide();
        $('#sfratabelHvShort').hide();
        $('#sfratabelHvGround').hide();    

    }
    else if(reqTipe==9)
    {
        //Rdc
        $('#irpi').show();
        $('#irpitabel').hide();
        $('#sfra').hide();
        $('#max_dev').show();
        $('#di_electric').hide();
        $('#umum').hide();
        $('#moisture').hide();
        $('#tap_changer').hide();
        $('#aparatus').hide();
        $('#weather').hide();
        $('#hottabel').hide();
        $('#ectabel').hide();
        $('#ratiotabel').hide();
        $('#rdctabel').show();
        $('#tantabel').hide();
        $('#upload_sfra').hide();
        $('#upload_sfra_gambar').hide();
        $('#sfratabelHv').hide();
        $('#sfratabelLv').hide(); 
        $('#sfratabelHvLv').hide();
        $('#sfratabelHvShort').hide();
        $('#sfratabelHvGround').hide();    
    }
    else if(reqTipe==10)
    {
        //Turn Ratio
        $('#irpi').show();
        $('#irpitabel').hide();
        $('#sfra').hide();
        $('#max_dev').show();
        $('#di_electric').hide();
        $('#umum').hide();
        $('#moisture').hide();
        $('#tap_changer').hide();
        $('#aparatus').hide();
        $('#weather').hide();
        $('#hottabel').hide();
        $('#ectabel').hide();
        $('#ratiotabel').show();
        $('#rdctabel').hide();
        $('#tantabel').hide();
        $('#upload_sfra').hide();
        $('#upload_sfra_gambar').hide();
        $('#sfratabelHv').hide();
        $('#sfratabelLv').hide(); 
        $('#sfratabelHvLv').hide();
        $('#sfratabelHvShort').hide();
        $('#sfratabelHvGround').hide();    

    }
    else 
    {
        $('#irpi').hide();
        $('#irpitabel').hide();
        $('#sfra').hide();
        $('#max_dev').hide();
        $('#di_electric').hide();
        $('#umum').hide();
        $('#moisture').hide();
        $('#tap_changer').hide();
        $('#aparatus').hide();
        $('#weather').hide();
        $('#hottabel').hide();
        $('#ectabel').hide();
        $('#ratiotabel').hide();
        $('#rdctabel').hide();
        $('#tantabel').hide();
        $('#upload_sfra').hide();
        $('#upload_sfra_gambar').hide();
        $('#sfratabelHv').hide();
        $('#sfratabelLv').hide(); 
        $('#sfratabelHvLv').hide();
        $('#sfratabelHvShort').hide();
        $('#sfratabelHvGround').hide();    
     
    }
}

$('#reqTipeId').combobox({
    onChange: function(value){
        console.log(value);
        $('#reqTipeId').val(value);
         // console.log(reqTipe);
        if(value==1 || value==2 )
        {
            //ir pi
            $('#irpi').show();
            $('#irpitabel').show();
            $('#sfra').hide();
            $('#max_dev').hide();
            $('#di_electric').hide();
            $('#umum').hide();
            $('#moisture').hide();
            $('#tap_changer').hide();
            $('#aparatus').hide();
            $('#weather').hide();
            $('#hottabel').hide();
            $('#ectabel').hide();
            $('#ratiotabel').hide();
            $('#rdctabel').hide();
            $('#tantabel').hide();
            $('#upload_sfra').hide();
            $('#upload_sfra_gambar').hide();
            $('#sfratabelHv').hide();
            $('#sfratabelLv').hide(); 
            $('#sfratabelHvLv').hide();
            $('#sfratabelHvShort').hide();
            $('#sfratabelHvGround').hide();    
        }
        else if(value==4)
        {
            //sfra
            $('#irpi').show();
            $('#irpitabel').hide();
            $('#sfra').hide();
            $('#max_dev').hide();
            $('#di_electric').hide();
            $('#umum').show();
            $('#moisture').hide();
            $('#tap_changer').show();
            $('#air_humidity').hide();
            $('#air_temperature').hide();
            $('#aparatus').hide();
            $('#weather').hide();
            $('#hottabel').hide();
            $('#ectabel').hide();
            $('#ratiotabel').hide();
            $('#rdctabel').hide();
            $('#tantabel').hide();
            $('#upload_sfra').show();
            $('#upload_sfra_gambar').show();
            $('#sfratabelHv').show();
            $('#sfratabelLv').show(); 
            $('#sfratabelHvLv').show();
            $('#sfratabelHvShort').show();
            $('#sfratabelHvGround').show();    

        }
        else if(value==6)
        {
            //Tan Delta
            $('#irpi').show();
            $('#irpitabel').hide();
            $('#sfra').hide();
            $('#max_dev').hide();
            $('#di_electric').hide();
            $('#umum').show();
            $('#moisture').hide();
            $('#tap_changer').hide();
            $('#aparatus').show();
            $('#weather').hide();
            $('#hottabel').hide();
            $('#ectabel').hide();
            $('#ratiotabel').hide();
            $('#rdctabel').hide();
            $('#tantabel').show();
            $('#upload_sfra').hide();
            $('#upload_sfra_gambar').hide();
            $('#sfratabelHv').hide();
            $('#sfratabelLv').hide(); 
            $('#sfratabelHvLv').hide();
            $('#sfratabelHvShort').hide();
            $('#sfratabelHvGround').hide();   

        }
        else if(value==5)
        {
            // di electric
            $('#irpi').show();
            $('#irpitabel').hide();
            $('#sfra').hide();
            $('#max_dev').hide();
            $('#di_electric').show();
            $('#umum').show();
            $('#aparatus').hide();
            $('#weather').hide();
            $('#moisture').show();
            $('#tap_changer').show();
            $('#aparatus').hide();
            $('#weather').hide();
            $('#hottabel').hide();
            $('#ectabel').hide();
            $('#ratiotabel').hide();
            $('#rdctabel').hide();
            $('#tantabel').hide();
            $('#upload_sfra').hide();
            $('#upload_sfra_gambar').hide();
            $('#sfratabelHv').hide();
            $('#sfratabelLv').hide(); 
            $('#sfratabelHvLv').hide();
            $('#sfratabelHvShort').hide();
            $('#sfratabelHvGround').hide();   
        }
        else if(value==7)
        {
            //hot collar
            $('#irpi').show();
            $('#irpitabel').hide();
            $('#sfra').hide();
            $('#max_dev').hide();
            $('#di_electric').hide();
            $('#umum').show();
            $('#moisture').hide();
            $('#tap_changer').hide();
            $('#aparatus').show();
            $('#weather').show();
            $('#hottabel').show();
            $('#ectabel').hide();
            $('#ratiotabel').hide();
            $('#rdctabel').hide();
            $('#tantabel').hide();
            $('#upload_sfra').hide();
            $('#upload_sfra_gambar').hide();
            $('#sfratabelHv').hide();
            $('#sfratabelLv').hide(); 
            $('#sfratabelHvLv').hide();
            $('#sfratabelHvShort').hide();
            $('#sfratabelHvGround').hide();   
        }
        else if(value==8)
        {
            //Excitation
            $('#irpi').show();
            $('#irpitabel').hide();
            $('#sfra').hide();
            $('#max_dev').hide();
            $('#di_electric').hide();
            $('#umum').show();
            $('#moisture').hide();
            $('#tap_changer').hide();
            $('#aparatus').show();
            $('#weather').show();
            $('#hottabel').show();
            $('#ectabel').show();
            $('#ratiotabel').hide();
            $('#rdctabel').hide();
            $('#tantabel').hide();
            $('#upload_sfra').hide();
            $('#upload_sfra_gambar').hide();
            $('#sfratabelHv').hide();
            $('#sfratabelLv').hide(); 
            $('#sfratabelHvLv').hide();
            $('#sfratabelHvShort').hide();
            $('#sfratabelHvGround').hide();   
        }
        else if(value==9)
        {
            //Rdc
            $('#irpi').show();
            $('#irpitabel').hide();
            $('#sfra').hide();
            $('#max_dev').show();
            $('#di_electric').hide();
            $('#umum').hide();
            $('#moisture').hide();
            $('#tap_changer').hide();
            $('#aparatus').hide();
            $('#weather').hide();
            $('#hottabel').hide();
            $('#ectabel').hide();
            $('#ratiotabel').hide();
            $('#rdctabel').show();
            $('#tantabel').hide();
            $('#upload_sfra').hide();
            $('#upload_sfra_gambar').hide();
            $('#sfratabelHv').hide();
            $('#sfratabelLv').hide(); 
            $('#sfratabelHvLv').hide();
            $('#sfratabelHvShort').hide();
            $('#sfratabelHvGround').hide();   

        }
        else if(value==10)
        {
            //Turn Ratio
            $('#irpi').show();
            $('#irpitabel').hide();
            $('#sfra').hide();
            $('#max_dev').show();
            $('#di_electric').hide();
            $('#umum').hide();
            $('#moisture').hide();
            $('#tap_changer').hide();
            $('#aparatus').hide();
            $('#weather').hide();
            $('#hottabel').hide();
            $('#ectabel').hide();
            $('#ratiotabel').show();
            $('#rdctabel').hide();
            $('#tantabel').hide();
            $('#upload_sfra').hide();
            $('#upload_sfra_gambar').hide();
            $('#sfratabelHv').hide();
            $('#sfratabelLv').hide(); 
            $('#sfratabelHvLv').hide();
            $('#sfratabelHvShort').hide();
            $('#sfratabelHvGround').hide();   
        }
        else 
        {
            $('#irpi').hide();
            $('#irpitabel').hide();
            $('#sfra').hide();
            $('#max_dev').hide();
            $('#di_electric').hide();
            $('#umum').hide();
            $('#moisture').hide();
            $('#tap_changer').hide();
            $('#aparatus').hide();
            $('#weather').hide();
            $('#hottabel').hide();
            $('#ectabel').hide();
            $('#ratiotabel').hide();
            $('#rdctabel').hide();
            $('#tantabel').hide();
            $('#upload_sfra').hide();
            $('#upload_sfra_gambar').hide();
            $('#sfratabelHv').hide();
            $('#sfratabelLv').hide(); 
            $('#sfratabelHvLv').hide();
            $('#sfratabelHvShort').hide();
            $('#sfratabelHvGround').hide();   
        }

        if(reqTipe !== value)
        {
            $('#irpi input[type="text"], textarea').val('');
            $('#di_electric input[type="text"], textarea').val('');
            $('#irpitabel input[type="text"], textarea').val('');
            $("#tableIrpi").empty();
            $('#moisture input[type="text"], textarea').val('');
            $('#hottabel input[type="text"], textarea').val('');
            $("#tableHot").empty();
            $('#ectabel input[type="text"], textarea').val('');
            $("#tableEc").empty();
            $('#ratiotabel input[type="text"], textarea').val('');
            $("#tableRatio").empty();
            $('#tantabel input[type="text"], textarea').val('');
            $("#tableTan").empty();
            $("#tableWinding").empty();
            $("#tableRef").empty();

            $('#sfratabelHv input[type="text"], textarea').val('');
            $("#tableSfraHv").empty();

            $('#sfratabelLv input[type="text"], textarea').val('');
            $("#tableSfraLv").empty();

            $('#sfratabelHvLv input[type="text"], textarea').val('');
            $("#tableSfraHvLv").empty();

            $('#sfratabelHvShort input[type="text"], textarea').val('');
            $("#tableSfraHvShort").empty();

            $('#sfratabelHvGround input[type="text"], textarea').val('');
            $("#tableSfraHvGround").empty();
            
        }
    }
})
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/form_uji_json/add',
        onSubmit:function(){

            if($(this).form('validate'))
            {
                var win = $.messager.progress({
                    title:'<?=$this->configtitle["progres"]?>',
                    msg:'proses data...'
                });
            }

            return $(this).form('enableValidation').form('validate');
        },
        success:function(data){
            $.messager.progress('close');
            // console.log(data);return false;

            data = data.split("***");
            reqId= data[0];
            infoSimpan= data[1];

            if(reqId == 'xxx')
                $.messager.alert('Info', infoSimpan, 'warning');
            else
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}  

function cetak_excel()
{
    reqTipe= $('#reqTipeId').val();
    // console.log(reqTipe);

    url="";
    
    if (reqTipe=='1' || reqTipe=='2') 
    {
        url= 'ir_pi';
    }
    else if (reqTipe=='5') 
    {
        url= 'die_res';
    }
    else if (reqTipe=='7') 
    {
        url= 'hcb';
    }
    else if (reqTipe=='8') 
    {
        url= 'ex_curr';
    }
    else if (reqTipe=='9') 
    {
        url= 'rdc';
    }
    else if (reqTipe=='10') 
    {
        url= 'ratio';
    }

    urlExcel = 'json-app/form_uji_cetak_json/'+url+'/?reqId='+reqId+'&reqTipe='+reqTipe;
    // console.log(urlExcel);
    newWindow = window.open(urlExcel, 'Cetak');
    newWindow.focus();
} 

function cetak_word(){
 
} 

function cetak_pdf()
{
    reqTipe= $('#reqTipeId').val();

    reqMode='';
    
    if (reqTipe=='1' || reqTipe=='2') 
    {
        reqMode= 'irpi_after_before';
    }
    else if (reqTipe=='4') 
    {
        reqMode= 'sfra';
    }
    else if (reqTipe=='5') 
    {
        reqMode= 'dielectric_response';
    }
    else if (reqTipe=='6') 
    {
        reqMode= 'tan_delta';
    }
    else if (reqTipe=='7') 
    {
        reqMode= 'hot_collar_bushing';
    }
    else if (reqTipe=='8') 
    {
        reqMode= 'excitation_current';
    }
    else if (reqTipe=='9') 
    {
        reqMode= 'rdc';
    }
    else if (reqTipe=='10') 
    {
        reqMode= 'ratio';
    }

    openAdd('app/loadUrl/report/cetak_pdf?reqId=<?=$reqId?>&reqTipe='+reqTipe+'&reqMode='+reqMode);
}

$("#tableIrpi,#tableHot,#tableEc,#tableRatio,#tableSfraHv,#tableSfraLv,#tableSfraHvLv,#tableSfraHvShort,#tableSfraHvGround").on("click", ".btn-remove", function(){
    $(this).closest('tr').remove();
});

$("#tableRdc").on("click", ".btn-remove", function(){
    $("#tableRdc tr").slice(-3).remove();
});

$("#tableTan").on("click", ".btn-remove", function(){
    $("#tableTan tr").slice(-4).remove();
});


function AddIrpi(array) {
    test = "<tr><td><input class='easyui-validatebox textbox form-control' type='text' name='reqWaktu[]' id='reqWaktu' value='' data-options='' style='width:100%'></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvGnd[]' id='reqHvGnd' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqLvGnd[]' id='reqLvGnd' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvLv[]' id='reqHvLv' value='' data-options='' style='width:100%' ></td><td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td></tr>";
    $("#tableIrpi").append(test);
}

function AddHot(array) {
    test = "<tr><td><input class='easyui-validatebox textbox form-control' type='text' name='reqBushing[]' id='reqBushing' value='' data-options='' style='width:100%'></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqSkirt[]' id='reqSkirt' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqTeganganInjeksi[]' id='reqTeganganInjeksi' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqIma[]' id='reqIma' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqWatts[]' id='reqWatts' value='' data-options='' style='width:100%' ></td><td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td></tr>";
    $("#tableHot").append(test);
}

function AddEc(array) {
    test = "<tr><td><input class='easyui-validatebox textbox form-control' type='text' name='reqTap[]' id='reqTap' value='' data-options='' style='width:100%'></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqTeganganInjeksi[]' id='reqTeganganInjeksi' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqImaRt[]' id='reqImaRt' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqWattsRt[]' id='reqWattsRt' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqLcRt[]' id='reqLcRt' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqImaSr[]' id='reqImaSr' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqWattsSr[]' id='reqWattsSr' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqLcSr[]' id='reqLcSr' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqImaTs[]' id='reqImaTs' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqWattsTs[]' id='reqWattsTs' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqLcTs[]' id='reqLcTs' value='' data-options='' style='width:100%' ></td><td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td></tr>";
    $("#tableEc").append(test);
}

function AddRatio(array) {
    test = "<tr><td><input class='easyui-validatebox textbox form-control' type='text' name='reqFasaRatio[]' id='reqFasaRatio' value='' data-options='' style='width:100%'></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqTapRatio[]' id='reqTapRatio' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvKv[]' id='reqHvKv' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqLvKv[]' id='reqLvKv' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqRasioTegangan[]' id='reqRasioTegangan' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqHvV[]' id='reqHvV' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqDerajatHvV[]' id='reqDerajatHvV' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqLvV[]' id='reqLvV' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqDerajatLvV[]' id='reqDerajatLvV' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqRasioHasil[]' id='reqRasioHasil' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqDeviasi[]' id='reqDeviasi' value='' data-options='' style='width:100%' ></td><td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td></tr>";
    $("#tableRatio").append(test);
}

function AddRdc(array) {
    $.get("app/loadUrl/app/template_rdc_add", function(data) {   
       $("#tableRdc").append(data);
    }); 
}

function AddTan(array) {
    $.get("app/loadUrl/app/template_tan_add", function(data) {   
       $("#tableTan").append(data);
    });
}

function AddTanWinding(array) {
    
    $.get("app/loadUrl/app/template_tan_winding_add", function(data) {   
       $("#tableWinding").append(data);
    });
}

function AddTanRef(array) {
    $.get("app/loadUrl/app/template_tan_ref_add", function(data) {   
       $("#tableRef").append(data);
    });
}

function AddSfra(tipe) {
    var url="";
    var tabel="";
    if(tipe==1)
    {
        url="app/loadUrl/app/template_sfra_hv_add";
        tabel="tableSfraHv";
    }
    else if(tipe==2)
    {
        url="app/loadUrl/app/template_sfra_lv_add";
        tabel="tableSfraLv";
    }
    else if(tipe==3)
    {
        url="app/loadUrl/app/template_sfra_hvlv_add";
        tabel="tableSfraHvLv";
    }
    else if(tipe==4)
    {
        url="app/loadUrl/app/template_sfra_hv_short_add";
        tabel="tableSfraHvShort";
    }
    else if(tipe==5)
    {
        url="app/loadUrl/app/template_sfra_hvlv_ground_add";
        tabel="tableSfraHvGround";
    }

    $.get(url, function(data) {   
       $("#"+tabel).append(data);
    });
}


function HapusTable(iddetil,form,tipe) {
    var Id ='<?=$reqId?>';
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/form_uji_json/deletedetail/?reqDetilId="+iddetil+"&reqId="+Id+"&reqTipeId="+tipe,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    if(tipe==9)
                    {
                        $("#tableRdc tr").slice(-3).remove();
                    }
                    else
                    {
                        $("#"+form+"-"+iddetil+"").remove();
                    }

                });
        }
    }); 
}

function HapusTableTan(iddetil,form,tipe,tipetan) {
    // console.log(tipe);
    var Id ='<?=$reqId?>';
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/form_uji_json/deletedetailtan/?reqDetilId="+iddetil+"&reqId="+Id+"&reqTipeId="+tipe+"&reqTipeTan="+tipetan,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    if(tipe==9)
                    {
                        $("#tableRdc tr").slice(-3).remove();
                    }
                    else if(tipe==6)
                    {
                        $("#tableTan tr").slice(-4).remove();
                    }
                    else
                    {
                        $("#"+form+"-"+iddetil+"").remove();
                    }

                });
        }
    }); 
}

function HapusTableSfra(iddetil,form,tipe,tipesfra) {
    // console.log(tipe);
    var Id ='<?=$reqId?>';
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/form_uji_json/deletedetailsfra/?reqDetilId="+iddetil+"&reqId="+Id+"&reqTipeId="+tipe+"&reqTipeSfra="+tipesfra,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
        
                    $("#"+form+"-"+iddetil+"").remove();

                });
        }
    }); 
}


function HapusGambar(iddetil,form,tipe) {
    // console.log(tipe);
    var Id ='<?=$reqId?>';
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/form_uji_json/deletegambar/?reqDetilId="+iddetil+"&reqId="+Id+"&reqTipeId="+tipe,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    $("#"+form+"-"+iddetil+"").remove();
                });
        }
    }); 
}

</script>