<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/SiteVisit");
$this->load->model("base-app/Distrik");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new SiteVisit();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.SITE_VISIT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("SITE_VISIT_ID");

    $reqSektor= $set->getField("GENERAL_SEKTOR");
    $reqDistrik= $set->getField("NAMA_DISTRIK");
    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqReport= $set->getField("GENERAL_REPORT");
    $reqTanggalSite= dateToPageCheck($set->getField("GENERAL_TANGGAL_SITE"));
    $reqName= $set->getField("GENERAL_NAME");
    $reqDrawing= $set->getField("GENERAL_DRAWING");

    $reqGangguan= $set->getField("KRONOLOGI_GANGGUAN");
    $reqDokRef= $set->getField("KRONOLOGI_DOKUMEN");
    $reqKronologiFile= $set->getField("KRONOLOGI_ATTACH_FILE");
    $reqWaitingTime= $set->getField("KRONOLOGI_WAITING_TIME");

    $reqSiteInvestigation= $set->getField("SITE_INVESTIGATION");
    $reqDokumenRef= $set->getField("SITE_DOKUMEN_REVERENCE");
    $reqSiteFile= $set->getField("SITE_ATTACH_FILE");
    $reqInvestigationTime= $set->getField("SITE_INVESTIGATION_TIME");

    $reqAnalisa= $set->getField("ANALISA");
    $reqAnalisaTime= $set->getField("ANALISA_TIME");

    $reqDeskripsi= $set->getField("TASK_DESCRIPTION");
    $reqExecutionTime= $set->getField("TASK_EXECUTION_TIME");

    $reqPostMaintenanceTesting= $set->getField("MAINTENANCE_POST");
    $reqDokumentasi= $set->getField("MAINTENANCE_DOKUMENTASI");
    $reqMaintenanceFile= $set->getField("MAINTENANCE_ATTACH_FILE");
    $reqPostMaintenanceTime= $set->getField("MAINTENANCE_POST_TIME");
    $reqStandartPengujian= $set->getField("MAINTENANCE_STANDART");

    $reqWrenchTime= $set->getField("KOMPARASI_WRENCH_TIME");
    $reqTotalDownTime= $set->getField("KOMPARASI_TOTAL_DOWN_TIME");
    $reqStartDate= dateToPageCheck($set->getField("KOMPARASI_START_DATE"));
    $reqFinishDate= dateToPageCheck($set->getField("KOMPARASI_FINISH_DATE"));

    $reqKesimpulan= $set->getField("KESIMPULAN_REKOMEN");
    $reqLessonLearned= $set->getField("KESIMPULAN_LESSON");
    $reqPemeriksaId= $set->getField("PEMERIKSA_ID");
    $reqPemeriksaNama= $set->getField("NAMA_PEMERIKSA");

    unset($set);

    $set= new SiteVisit();
    $arrtask= [];
    $statement = " AND A.SITE_VISIT_ID = '".$reqId."' ";
    $set->selectByParamsTask(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("SITE_VISIT_TASK_ID");
        $arrdata["deskripsi"]= $set->getField("DESKRIPSI");
        $arrdata["material"]= $set->getField("MATERIAL");
        $arrdata["tools"]= $set->getField("TOOLS");
        $arrdata["resource"]= $set->getField("RESOURCE");
        array_push($arrtask, $arrdata);
    }
    unset($set);

    $set= new SiteVisit();
    $arrmaintenance= [];
    $statement = " AND A.SITE_VISIT_ID = '".$reqId."' ";
    $set->selectByParamsMaintenance(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("SITE_VISIT_MAINTENANCE_ID");
        $arrdata["tools"]= $set->getField("TOOLS");
        array_push($arrmaintenance, $arrdata);
    }
    unset($set);

    $set= new SiteVisit();
    $arrkomparasi= [];
    $statement = " AND A.SITE_VISIT_ID = '".$reqId."' ";
    $set->selectByParamsKomparasi(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("SITE_VISIT_KOMPARASI_ID");
        $arrdata["parameter"]= $set->getField("PARAMETER");
        $arrdata["satuan"]= $set->getField("SATUAN");
        $arrdata["sebelum"]= $set->getField("SEBELUM");
        $arrdata["sesudah"]= $set->getField("SESUDAH");
        array_push($arrkomparasi, $arrdata);
    }
    unset($set);

    $set= new SiteVisit();
    $arrpersonal= [];
    $statement = " AND A.SITE_VISIT_ID = '".$reqId."' ";
    $set->selectByParamsPersonal(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("SITE_VISIT_PERSONAL_ID");
        $arrdata["nid"]= $set->getField("NID");
        $arrdata["nama"]= $set->getField("NAMA");
        $arrdata["unit"]= $set->getField("UNIT");
        array_push($arrpersonal, $arrdata);
    }
    unset($set);


}

 $distrik= new Distrik();
 $arrdistrik= [];
 $statement = " ";
 $distrik->selectByParams(array(), -1, -1, $statement);
 while($distrik->nextRow())
 {
    $arrdata= array();
    $arrdata["DISTRIK_ID"]= $distrik->getField("DISTRIK_ID");
    $arrdata["KODE"]= $distrik->getField("KODE");
    $arrdata["NAMA"]= $distrik->getField("NAMA");
    array_push($arrdistrik, $arrdata);
}
// print_r($arrdistrik);exit;
unset($distrik);


$disabled="";


if($reqLihat ==1)
{
    $disabled="disabled";  
}


?>

<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">
            <div>
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data"  autocomplete="off">
                <!-- General Start -->
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>General</h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Sektor</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqSektor"  id="reqSektor" value="<?=$reqSektor?>" <?=$disabled?>  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Distrik</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <!--  <input  name="reqDistrikId" class="easyui-combobox form-control" id="reqDistrikId"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'campur',url:'json-app/combo_json/combodistrik'" value="<?=$reqDistrikId?>"  <?=$disabled?> /> -->
                                    <select class="easyui-validatebox textbox form-control select2" <?=$disabled?> id="reqDistrikAuto" name="reqDistrikId">
                                        <option value="<?=$reqDistrikId?>"><?=$reqDistrik?></option>
                                    </select>
                                    <input type="hidden" name="reqDistrikId" id="reqDistrikId"  value="<?=$reqDistrikId?>" >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Report Number</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input class="easyui-validatebox textbox form-control" type="text" name="reqReport"  id="reqReport" value="<?=$reqReport?>"  <?=$disabled?> style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tanggal Site Visit</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  id="reqTanggalSite" class="easyui-datebox textbox form-control" name="reqTanggalSite" value="<?=$reqTanggalSite?>" <?=$disabled?> style="width: 100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Name Of Part</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqName"  id="reqName" value="<?=$reqName?>" <?=$disabled?>  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Drawing No</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqDrawing"  id="reqDrawing" <?=$disabled?> value="<?=$reqDrawing?>"  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- General End -->

                <!-- Kronologi Start -->
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>Kronologi</h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Kronologi Gangguan</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <textarea  name="reqGangguan" <?=$disabled?> style="width: 100%"><?=$reqGangguan?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Dokumen Reference</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqDokRef"  id="reqDokRef" value="<?=$reqDokRef?>" <?=$disabled?>  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Attach File</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input  class="easyui-validatebox textbox form-control" type="file" name="reqKronologiFile"  id="reqKronologiFile"  <?=$disabled?> style="width:40%" />
                                    <?
                                    if(!empty($reqKronologiFile))
                                    {
                                    ?>
                                     <a href="<?=$reqKronologiFile?>">File</a>
                                    <?
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Waiting Time (WT)</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="time" name="reqWaitingTime"  id="reqWaitingTime" <?=$disabled?> value="<?=$reqWaitingTime?>"  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Kronologi End -->

                <!-- Site Investigation Start -->
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>Site Investigation</h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Site Investigation</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <textarea name="reqSiteInvestigation" <?=$disabled?> style="width: 100%"><?=$reqSiteInvestigation?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Dokumen Reference</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input class="easyui-validatebox textbox form-control" type="text" name="reqDokumenRef"  id="reqDokumenRef" <?=$disabled?> value="<?=$reqDokumenRef?>"  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Attach File</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input  class="easyui-validatebox textbox form-control" type="file" name="reqSiteFile"  id="reqSiteFile" <?=$disabled?> value="<?=$reqSiteFile?>"  style="width:100%" />
                                    <?
                                    if(!empty($reqSiteFile))
                                    {
                                        ?>
                                        <a href="<?=$reqSiteFile?>">File</a>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Investigation Time (IT)</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="time" name="reqInvestigationTime"  id="reqInvestigationTime" <?=$disabled?> value="<?=$reqInvestigationTime?>"  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Site Investigation End -->

                <!-- Analisa Start -->
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>Analisa</h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Analisa</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <textarea name="reqAnalisa"  <?=$disabled?> style="width: 100%"><?=$reqAnalisa?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Analisa Time (AT)</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="time" name="reqAnalisaTime"  id="reqAnalisaTime" <?=$disabled?> value="<?=$reqAnalisaTime?>"  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Analisa End -->

                <!-- Task Perbaikan Start -->
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>Task Perbaikan</h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Deskripsi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <textarea  name="reqDeskripsi" <?=$disabled?> style="width: 100%"><?=$reqDeskripsi?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Execution Time (ET)</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="time" name="reqExecutionTime"  id="reqExecutionTime" <?=$disabled?> value="<?=$reqExecutionTime?>"  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTaskPerbaikan()">Tambah</a>
                   
                    <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                        <thead>
                            <th>Deskripsi</th>
                            <th>Material</th>
                            <th>Tools</th>
                            <th>Resource</td>
                            <th>Actions</th>
                        </thead>
                        <tbody id="tableTaskPerbaikan">
                            <?
                            foreach($arrtask as $item) 
                            {
                                $selectvalid= $item["id"];
                                $selectdeskripsi= $item["deskripsi"];
                                $selectmaterial= $item["material"];
                                $selecttools= $item["tools"];
                                $selectresource= $item["resource"];
                            ?>

                                <tr id="task-<?=$selectvalid?>" >
                                    <td style="display: none"><input class='easyui-validatebox textbox form-control' type='hidden' name='reqSiteVisitIdTask[]' id='reqSiteVisitIdTask' value='<?=$selectvalid?>' <?=$disabled?> data-options='' style='width:100%'>
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTaskDeskripsi[]' id='reqTaskDeskripsi' value='<?=$selectdeskripsi?>' data-options='' <?=$disabled?> style='width:100%'>
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTaskMaterial[]' id='reqTaskMaterial' value='<?=$selectmaterial?>' data-options='' style='width:100%' <?=$disabled?> >
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTaskTools[]' id='reqTaskTools' value='<?=$selecttools?>' data-options='' style='width:100%' <?=$disabled?> >
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTaskResource[]' id='reqTaskResource' value='<?=$selectresource?>' data-options='' style='width:100%' <?=$disabled?> >
                                    </td>
                                    <?
                                    if($reqLihat ==1)
                                    {}
                                    else
                                    {
                                        ?>
                                        <td>
                                            <span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvalid?>","task")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                        </td>
                                        <?
                                    }
                                    ?>
                                </tr>

                            <?
                            }
                            ?>
                            
                        </tbody>
                    </table>
                <!-- Task Perbaikan End -->

                <!-- Maintenance Testing Start -->
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>Maintenance Testing</h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Post Maintenance Testing</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqPostMaintenanceTesting"  id="reqPostMaintenanceTesting" value="<?=$reqPostMaintenanceTesting?>" <?=$disabled?> style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Dokumentasi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqDokumentasi"  id="reqDokumentasi" value="<?=$reqDokumentasi?>"  style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Attach File</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input  class="easyui-validatebox textbox form-control" type="file" name="reqMaintenanceFile"  id="reqMaintenanceFile" value="<?=$reqMaintenanceFile?>"  style="width:100%" <?=$disabled?> />
                                    <?
                                    if(!empty($reqMaintenanceFile))
                                    {
                                        ?>
                                        <a href="<?=$reqMaintenanceFile?>">File</a>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Post Maintenance Time (PMT)</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="time" name="reqPostMaintenanceTime"  id="reqPostMaintenanceTime" value="<?=$reqPostMaintenanceTime?>"  style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Standart Pengujian</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqStandartPengujian"  id="reqStandartPengujian" value="<?=$reqStandartPengujian?>"  style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="AddMaintenanceTesting()">Tambah</a>
                   
                    <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                        <thead>
                            <th>Tools</th>
                            <th>Actions</th>
                        </thead>
                        <tbody id="tableMaintenanceTesting">

                            <?
                            foreach($arrmaintenance as $item) 
                            {
                                $selectvalid= $item["id"];
                                $selecttools=$item["tools"];
                            ?>
                                <tr id="maintenance-<?=$selectvalid?>" >
                                    <td style="display: none"><input class='easyui-validatebox textbox form-control' type='hidden' name='reqSiteVisitIdMaintenance[]' id='reqSiteVisitIdMaintenance' value='<?=$selectvalid?>' data-options='' style='width:100%' <?=$disabled?>>
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqMaintenanceTools[]' id='reqMaintenanceTools' value='<?=$selecttools?>' data-options='' style='width:100%' <?=$disabled?> >
                                    </td>
                                    <?
                                    if($reqLihat ==1)
                                    {}
                                    else
                                    {
                                        ?>
                                        <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvalid?>","maintenance")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                        </td>
                                    <?
                                    }
                                    ?>
                                </tr>

                            <?
                            }
                            ?>
                                
                        </tbody>
                    </table>
                <!-- Maintenance Testing End -->

                <!-- Komparasi Start -->
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>Komparasi</h3>       
                    </div>
                    <br>
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="AddKomparasi()">Tambah</a>
                   
                    <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;margin-bottom: 10px;">
                        <thead>
                            <th>Parameter</th>
                            <th>Satuan</th>
                            <th>Sebelum</th>
                            <th>Sesudah</th>
                            <th>Actions</th>
                        </thead>
                        <tbody id="tableKomparasi">

                             <?
                            foreach($arrkomparasi as $item) 
                            {
                                $selectvalid= $item["id"];
                                $selectparameter=$item["parameter"];
                                $selectsatuan=$item["satuan"];
                                $selectsebelum=$item["sebelum"];
                                $selectsesudah=$item["sesudah"];
                            ?>
                                <tr id="komparasi-<?=$selectvalid?>" >
                                    <td style="display: none"><input class='easyui-validatebox textbox form-control' type='hidden' name='reqSiteVisitIdKomparasi[]' id='reqSiteVisitIdKomparasi' value='<?=$selectvalid?>' data-options='' style='width:100%' <?=$disabled?>>
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqParameter[]' id='reqParameter' value='<?=$selectparameter?>' data-options='' style='width:100%' <?=$disabled?> >
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqSatuan[]' id='reqSatuan' value='<?=$selectsatuan?>' data-options='' style='width:100%'  <?=$disabled?>>
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqSebelum[]' id='reqSebelum' value='<?=$selectsebelum?>' data-options='' style='width:100%'  <?=$disabled?>>
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqSesudah[]' id='reqSesudah' value='<?=$selectsesudah?>' data-options='' style='width:100%' <?=$disabled?> >
                                    </td>
                                    <?
                                    if($reqLihat ==1)
                                    {}
                                    else
                                    {
                                        ?>
                                        <td>
                                            <span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvalid?>","komparasi")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a>
                                            </span>
                                        </td>
                                    <?
                                    }
                                    ?>
                                </tr>

                            <?
                            }
                            ?>
                                
                        </tbody>
                    </table>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Wrench Time</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="time" name="reqWrenchTime"  id="reqWrenchTime" value="<?=$reqWrenchTime?>" <?=$disabled?>  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Total Down Time</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="time" name="reqTotalDownTime"  id="reqTotalDownTime" value="<?=$reqTotalDownTime?>"  style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Start Date</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-datebox textbox form-control"  name="reqStartDate"  id="reqStartDate" value="<?=$reqStartDate?>"  style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Finish Date</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-datebox textbox form-control" name="reqFinishDate"  id="reqFinishDate" value="<?=$reqFinishDate?>"  style="width:100%"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Komparasi End -->

                <!-- Kesimpulan dan Tindak Lanjut Start -->
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>Kesimpulan dan Tindak Lanjut</h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Kesimpuan dan Rekomendasi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqKesimpulan"  id="reqKesimpulan" value="<?=$reqKesimpulan?>" <?=$disabled?>  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Lesson Learned</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input class="easyui-validatebox textbox form-control" type="text" name="reqLessonLearned"  id="reqLessonLearned" value="<?=$reqLessonLearned?>"  <?=$disabled?> style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Kesimpulan dan Tindak Lanjut End -->

                <!-- Personal Support Start -->
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>Personal Support</h3>       
                    </div>

                    <br>
                    
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="AddPersonalSupport()">Tambah</a>
                   
                    <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                        <thead>
                            <th>NID</th>
                            <th>Nama</th>
                            <th>Unit</th>
                            <th>Actions</th>
                        </thead>
                        <tbody id='tablePersonalSupport'>

                            <?
                            foreach($arrpersonal as $item) 
                            {
                                $selectvalid= $item["id"];
                                $selectnid=$item["nid"];
                                $selectnama= $item["nama"];
                                $selectunit= $item["unit"];
                            ?>
                                <tr id="personal-<?=$selectvalid?>" >
                                    <td style="display: none"><input class='easyui-validatebox textbox form-control' type='hidden' name='reqSiteVisitIdPersonal[]' id='reqSiteVisitIdPersonal' value='<?=$selectvalid?>' data-options='' style='width:100%' <?=$disabled?>>
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqPersonalNid[]' id='reqPersonalNid' value='<?=$selectnid?>' data-options='' style='width:100%' <?=$disabled?>>
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqPersonalNama[]' id='reqPersonalNama' value='<?=$selectnama?>' data-options='' style='width:100%' <?=$disabled?>>
                                    </td>
                                    <td><input class='easyui-validatebox textbox form-control' type='text' name='reqPersonalUnit[]' id='reqPersonalUnit' value='<?=$selectunit?>' data-options='' style='width:100%' <?=$disabled?>>
                                    </td>
                                    <?
                                    if($reqLihat ==1)
                                    {}
                                    else
                                    {
                                        ?>
                                        <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvalid?>","personal")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                        </td>
                                        <?
                                    }
                                    ?>
                                </tr>

                            <?
                            }
                            ?>
                            
                        </tbody>
                    </table>
                <!-- Personal Support End -->

                <!-- Pemeriksa Start -->
                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i>Pemeriksa</h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Pemeriksa</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="hidden" name="reqPemeriksaId" id="reqPemeriksaId" value="<?=$reqPemeriksaId?>" style="width:100%" />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqPicNama"  id="reqPemeriksaNama" value="<?=$reqPemeriksaNama?>" style="width:60%" readonly />
                                    <a id="btnAdd" onclick="openPemeriksa()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                    <a><input type="checkbox" id="reqSemuaPemeriksa" /> &nbsp;Semua Distrik</a>

                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Pemeriksa End -->

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>

                <?
                if($reqLihat ==1)
                {}
                else
                {
                    ?>
                    <div style="text-align:center;padding:5px">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

                    </div>
                    <?
                }
                ?>


            </div>            
        </div>
    </div>
    
</div>

<script>

    function tampilDistrik(val) {
        if (val.loading) return val.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'>" + val.description + "</div>" +
        "</div>" +
        "</div>";
        return markup;
    }
    function pilihDistrik(val) {
        $("#reqDistrikId").val(val.id);
        $("#reqDistrik").val(val.text);
        
        // console.log(val);
        return val.text;
    }

    $("#reqDistrikAuto").select2({
        placeholder: "Pilih Distrik",
        allowClear: true,
        ajax: {
            url: "json-app/combo_json/autocompletedistrik",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                    , page: params.page
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items
                    , pagination: {
                        more: (params.page * 30) < data.total_count && data.items != ""
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: tampilDistrik, // omitted for brevity, see the source of this page
        templateSelection: pilihDistrik // omitted for brevity, see the source of this page
    });

    $('#reqDistrikAuto').on("change", function(e) {
        $('#reqPemeriksaId').val("");
        $('#reqPemeriksaNama').val(""); 
    }); 

function openPemeriksa()
{
    if ($('#reqSemuaPemeriksa').is(":checked"))
    {
         var distrikid = '';
    }
    else
    {
        var distrikid = $('#reqDistrikId').val();
    }
   
    openAdd('app/index/lookup_pemeriksa?reqDistrikId='+distrikid+'&reqPemeriksa=1');
}

function setPemeriksa(values)
{
    $('#reqPemeriksaId').val(values.NID);
    $('#reqPemeriksaNama').val(values.NAMA_LENGKAP);
}

function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/site_visit_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>_add?reqId="+reqId);
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}

function HapusTable(id,form) {

    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/site_visit_json/deletedetail/?reqId="+id+"&reqForm="+form,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    $("#"+form+"-"+id+"").remove();
                });

        }
    }); 
}

$("#tableTaskPerbaikan,#tableMaintenanceTesting,#tableKomparasi,#tablePersonalSupport").on("click", ".btn-remove", function(){
    $(this).closest('tr').remove();
});


function AddTaskPerbaikan(array) {
    test = "<tr><td><input class='easyui-validatebox textbox form-control' type='text' name='reqTaskDeskripsi[]' id='reqTaskDeskripsi' value='' data-options='' style='width:100%'></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqTaskMaterial[]' id='reqTaskMaterial' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqTaskTools[]' id='reqTaskTools' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqTaskResource[]' id='reqTaskResource' value='' data-options='' style='width:100%' ></td><td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td></tr>";
    $("#tableTaskPerbaikan").append(test);
}

function AddMaintenanceTesting(array) {
            // console.log("masuk");
    test = "<tr><td><input class='easyui-validatebox textbox form-control' type='text' name='reqMaintenanceTools[]' id='reqMaintenanceTools' value='' data-options='' style='width:100%' ></td><td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td></tr>";
    $("#tableMaintenanceTesting").append(test);
}

function AddKomparasi(array) {
            // console.log("masuk");
    test = "<tr><td><input class='easyui-validatebox textbox form-control' type='text' name='reqParameter[]' id='reqParameter' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqSatuan[]' id='reqSatuan' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqSebelum[]' id='reqSebelum' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqSesudah[]' id='reqSesudah' value='' data-options='' style='width:100%' ></td><td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td></tr>";
    $("#tableKomparasi").append(test);
}

function AddPersonalSupport(array) {
            // console.log("masuk");
    test = "<tr><td><input class='easyui-validatebox textbox form-control' type='text' name='reqPersonalNid[]' id='reqPersonalNid' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqPersonalNama[]' id='reqPersonalNama' value='' data-options='' style='width:100%' ></td><td><input class='easyui-validatebox textbox form-control' type='text' name='reqPersonalUnit[]' id='reqPersonalUnit' value='' data-options='' style='width:100%' ></td><td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td></tr>";
    $("#tablePersonalSupport").append(test);
}
</script>