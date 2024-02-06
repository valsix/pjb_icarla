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


        array_push($arrwaktu, $arrdata);
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
                        <!-- <a href="javascript:void(0)" class="btn btn-info" onclick="cetak_word()"><i class="fa fa-file-word-o" aria-hidden="true"></i> Cetak Word</a>
                        <a href="javascript:void(0)" class="btn btn-danger" onclick="cetak_pdf()"><i class="fa fa-file-pdf"></i> Cetak PDF</a> -->
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

function cetak_excel(){
    var url = 'ir_pi';
    var reqTipe =$('#reqTipeId').val();
    urlExcel = 'json-app/form_uji_cetak_json/'+url+'/?reqId='+reqId+'&reqTipe='+reqTipe;
    newWindow = window.open(urlExcel, 'Cetak');
    newWindow.focus();
} 

function cetak_word(){
 
} 

function cetak_pdf(){
   
}

$("#tableIrpi,#tableMaintenanceTesting").on("click", ".btn-remove", function(){
    $(this).closest('tr').remove();
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


function HapusTable(iddetil,form,tipe) {

    var Id ='<?=$reqId?>';
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/form_uji_json/deletedetail/?reqDetilId="+iddetil+"&reqId="+Id+"&reqTipeId="+tipe,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    $("#"+form+"-"+iddetil+"").remove();
                });

        }
    }); 
}

</script>