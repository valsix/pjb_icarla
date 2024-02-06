<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/PlanRla");
$this->load->model("base-app/FormUji");
$this->load->model("base-app/Eam");
$this->load->model("base-app/PengadaanKontrak");
$this->load->library('libapproval');
$this->load->model("base-app/KelompokEquipment");
$this->load->model("base-app/Crud");
$appuserkodehak= $this->appuserkodehak;




$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new PlanRla();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.PLAN_RLA_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PLAN_RLA_ID");
    $reqKode= $set->getField("KODE_MASTER_PLAN");
    $reqDistrikId= $set->getField("DISTRIK_ID");
    $reqDistrik= $set->getField("NAMA_DISTRIK");
    $reqEntitas= $set->getField("ENTITAS");
    $reqUnitId= $set->getField("UNIT_ID");
    $reqEquipmentId= $set->getField("EQUIPMENT_ID");
    // $reqKelompokEquipment= $set->getField("KELOMPOK_EQUIPMENT_ID");
    $reqJudulKegiatan= $set->getField("JUDUL_KEGIATAN");
    $reqRlaLevel= $set->getField("RLA_LEVEL");
    $reqRlaIndex= $set->getField("RLA_INDEX");
    $reqAnggaranRencana= $set->getField("ANGGARAN_RENCANA");
    $reqAnggaranRealisasi= $set->getField("ANGGARAN_REALISASI");
    $reqWorkOrder= $set->getField("WORK_ORDER");
    $reqWorkRequest= $set->getField("WORK_REQUEST");
    $reqKodePrk= $set->getField("KODE_PRK");
    $reqRencanaTanggalAwal= dateToPageCheck($set->getField("RENCANA_TANGGAL_AWAL"));
    $reqDurasiRencana= $set->getField("RENCANA_DURASI");
    $reqRencanaTanggalAkhir= dateToPageCheck($set->getField("RENCANA_TANGGAL_AKHIR"));
    $reqRealisasiTanggalAwal= dateToPageCheck($set->getField("REALISASI_TANGGAL_AWAL"));
    $reqRealisasiTanggalAkhir= dateToPageCheck($set->getField("REALISASI_TANGGAL_AKHIR"));
    $reqDurasiRealisasi= $set->getField("REALISASI_DURASI");
    $reqTimelineRlaId= $set->getField("TIMELINE_RLA_ID");
    $reqPicId= $set->getField("PIC_ID");
    $reqPicNama= $set->getField("NAMA_PIC");
    $reqPemeriksaNama= $set->getField("NAMA_PEMERIKSA");
    $reqStatus= $set->getField("STATUS");
    $reqPemeriksaId= $set->getField("PEMERIKSA_ID");
    $reqListFormUji= getmultiseparator($set->getField("FORM_UJI_ID_INFO"));
    $reqLampiran= $set->getField("LAMPIRAN");
    $reqNomorPengadaan= getmultiseparator($set->getField("PENGADAAN_KONTRAK_ID_INFO"));
    $reqWorkOrderId= $set->getField("WORK_ORDER_ID");
    $reqWorkOrderNama= $set->getField("WO_DESC");
    $reqWorkRequestId= $set->getField("WORK_REQUEST_ID");
    $reqWorkRequestNama= $set->getField("WR_DESC");
    $reqProgress= $set->getField("PROGRESS");
    $reqUnit= $set->getField("NAMA_UNIT");
    // print_r($strformuji);exit;

    $vstatus= $set->getField("V_STATUS");
    $reqTahun= $set->getField("TAHUN");

    $reqKelompokEquipment= getmultiseparator($set->getField("PLAN_RLA_KELOMPOK_EQUIPMENT_ID_INFO"));


    unset($set);

    $set= new PlanRla();
    $arrlistformuji= [];
    $statement = " AND B.PLAN_RLA_ID = '".$reqId."' ";
    $set->selectByParamsListFormUji(array(), -1,-1,$statement);
    // echo $set->query;exit;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["PLAN_RLA_ID"]= $set->getField("PLAN_RLA_ID");
        $arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
        $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
        $arrdata["FORM_UJI_NAMA"]= $set->getField("FORM_UJI_NAMA");
        $arrdata["KELOMPOK_EQUIPMENT_NAMA"]= $set->getField("KELOMPOK_EQUIPMENT_NAMA");
        array_push($arrlistformuji, $arrdata);
    }
    unset($set);

    // print_r($arrlistformuji);exit;

    // print_r($vstatus);exit;
  
}


$editable= ($vstatus<10 || $vstatus>=90) ? '':'style="display:none"';

$set= new FormUji();
$arrformuji= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("FORM_UJI_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrformuji, $arrdata);
}
unset($set);

$set= new Eam();
$arream= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("EAM_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arream, $arrdata);
}
unset($set);

$set= new PengadaanKontrak();
$arrpengadaan= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("PENGADAAN_KONTRAK_ID");
    $arrdata["text"]= $set->getField("NOMOR_KONTRAK");
    array_push($arrpengadaan, $arrdata);
}
unset($set);


$disabled="";


if($reqLihat ==1 || $vstatus==20)
{
    $disabled="disabled";  
}

$set= new KelompokEquipment();
$arrkelompokequipment= [];

$statement = " ";
$set->selectByParams(array(), -1, -1, $statement);
    // echo  $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrkelompokequipment, $arrdata);
}

unset($set);


$kode= $appuserkodehak;
$set= new Crud();
$statement=" AND (A.PENGGUNA_HAK_ID = 1 OR A.PENGGUNA_HAK_ID = 8)   AND KODE_MODUL ='0501' AND A.KODE_HAK =  '".$kode."'  ";
$set->selectByParamsCrudHak(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqMenuUmro= $set->getField("MENU");

unset($set);


// var_dump($vstatus);



?>
<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<script src='assets/moment/moment-with-locales.js' type="text/javascript" language="javascript"></script>
<script src='assets/moment/moment-precise-range-custom.js' type="text/javascript" language="javascript"></script> 

<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

<style type="text/css">
.select2-container--default .select2-selection--multiple .select2-selection__choice {
  color: #000000;
}
.select2-container--default .select2-search--inline .select2-search__field:focus {
  outline: 0;
  border: 1px solid #ffff;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__display {
  cursor: default;
  padding-left: 6px;
  padding-right: 5px;
}

.nav-link.active {
  color: red;
}
</style>
<script type="text/javascript">
    
// $(document).ready( function() {
//     $("#timelane").load("iframe/index/transaksi_timeline_rla?reqIdRla=<?=$reqId?>");
        
// });
</script>

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">
                    <ul class="nav nav-pills mr-auto">
                        <li class="nav-item active ">
                            <a class="nav-link active " data-toggle="tab" href="#master"> &nbsp;Master Plan RLA</a>
                        </li>
                        <?
                        if(!empty($reqId))
                        {
                        ?> 
                         <!-- <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#catatan"> &nbsp;Catatan/Log RLA</a>
                        </li> -->
                        <li class="nav-item " >
                            <a class="nav-link "  href="app/index/transaksi_timeline_rla?reqIdRla=<?=$reqId?>&reqLihat=<?=$reqLihat?>"> &nbsp;Timelane Rla</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="app/index/transaksi_catatan_rla?reqIdRla=<?=$reqId?>&reqLihat=<?=$reqLihat?>"> &nbsp;Catatan/Log RLA</a>
                        </li>
                        <?
                        if($vstatus==20 &&  $reqMenuUmro == 1)
                        {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link"  href="app/index/transaksi_monitoring_pengadaan?reqIdRla=<?=$reqId?>&reqLihat=<?=$reqLihat?>"> &nbsp;Monitoring Pengadaan & Kontrak</a>
                            </li>
                            <?
                        }
                        ?>
                       
                        <li class="nav-item">
                            <a class="nav-link" href="app/index/transaksi_pengukuran?reqIdRla=<?=$reqId?>&reqLihat=<?=$reqLihat?>"> &nbsp;Pengukuran</a>
                        </li>
                            <?
                            if($vstatus==20)
                            {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="app/index/report_form_uji_plan_rla_dinamis?reqIdRla=<?=$reqId?>&reqLihat=<?=$reqLihat?>"> &nbsp;Report</a>
                                </li>
                                <?
                            }
                            ?>
                       
                        <?
                        }
                        ?>

                    </ul>
                    <hr style="height:0.8px;border:none;color:#333;background-color:#333;">

                    <div class="tab-content">
                        <div id="master" class="tab-pane fade in active">

                            <?
                            // untuk approval
                            ?>
                            <input type="hidden" name="infopg" value="<?=$pg?>" />
                            <?
                            $approval_table= "plan_rla";
                            $approval_field_id= "PLAN_RLA_ID";
                            $approval_field_status= "V_STATUS";
                            $vappr= new libapproval();
                            $arrparam= ["approval_info_pg"=>$pg, "approval_info_id"=>$reqId, "approval_table"=>$approval_table, "approval_field_id"=>$approval_field_id, "approval_field_status"=>$approval_field_status];
                            $vappr->view($arrparam);
                            ?>

                            <div class="page-header">
                                <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                            </div>


                            <div class="form-group">  
                                <label class="control-label col-md-2">Tahun</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-2'>
                                           <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqTahun" maxlength="4"  id="reqTahun" value="<?=$reqTahun?>"  <?=$disabled?>  style="width:100%" />
                                       </div>
                                   </div>
                               </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Kode Master Plan</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>"  <?=$disabled?>  style="width:100%" />
                                       </div>
                                   </div>
                               </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Distrik</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <select class="easyui-validatebox textbox form-control select2" <?=$disabled?> id="reqDistrikAuto" name="reqDistrikId">
                                                <option value="<?=$reqDistrikId?>"><?=$reqDistrik?></option>
                                            </select>
                                            <input type="hidden" name="reqDistrikId" id="reqDistrikId"  value="<?=$reqDistrikId?>" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Entitas</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqEntitas"  id="reqEntitas" value="<?=$reqEntitas?>" style="width:100%"  <?=$disabled?> />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Unit</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <!--  <input  name="reqUnitId" class="easyui-combobox form-control" id="reqUnitId"
                                            data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combounit'" value="<?=$reqUnitId?>"   <?=$disabled?> /> -->

                                            <select class="easyui-validatebox textbox form-control select2" <?=$disabled?> id="reqUnitAuto" name="reqUnitId">
                                                <option value="<?=$reqUnitId?>"><?=$reqUnit?></option>
                                            </select>
                                            <input type="hidden" name="reqUnitId" id="reqUnitId"  value="<?=$reqUnitId?>" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Equipment</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <select class="form-control jscaribasicmultiple" id="reqEquipmentId" <?=$disabled?> name="reqEquipmentId" style="width:300px;"  >
                                                <?
                                                foreach($arream as $item) 
                                                {
                                                    $selectvalid= $item["id"];
                                                    $selectvaltext= $item["text"];

                                                    $selected="";
                                                    if($selectvalid==$reqEquipmentId)
                                                    {
                                                        $selected="selected";
                                                    }
                                                    ?>
                                                    <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="form-group">  
                                <label class="control-label col-md-2">Kelompok Equipment</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input  name="reqKelompokEquipment" class="easyui-combobox form-control" id="reqKelompokEquipment"
                                            data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combokelompokeq'" value="<?=$reqKelompokEquipment?>"  <?=$disabled?>  />
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group">  
                                <label class="control-label col-md-2">Kelompok Equipment</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <select class="form-control jscaribasicmultiple" id="reqKelompokEquipment" <?=$disabled?> name="reqKelompokEquipment[]" style="width:100%;" multiple="multiple">
                                                <?
                                                foreach($arrkelompokequipment as $item) 
                                                {
                                                    $selectvalid= $item["id"];
                                                    $selectvaltext= $item["text"];

                                                    $selected="";
                                                    if(in_array($selectvalid, $reqKelompokEquipment))
                                                    {
                                                        $selected="selected";
                                                    }
                                                    ?>
                                                    <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Judul Kegiatan</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqJudulKegiatan"  id="reqJudulKegiatan" value="<?=$reqJudulKegiatan?>" style="width:100%"  <?=$disabled?> />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Rla Level</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <select name ="reqRlaLevel"  <?=$disabled?> class="easyui-combobox form-control" data-options="width:'250',editable:false">
                                                <option value="">Pilih Rla Level</option>
                                                <option value="1" <? if ($reqRlaLevel == 1) echo 'selected' ?>>1</option>
                                                <option value="2" <? if ($reqRlaLevel == 2) echo 'selected' ?>>2</option>
                                                <option value="3" <? if ($reqRlaLevel == 3) echo 'selected' ?>>3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                          
                            <div class="form-group">  
                                <label class="control-label col-md-2">Healthy Index</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqRlaIndex"  id="reqRlaIndex" value="<?=$reqRlaIndex?>" style="width:100%"   <?=$disabled?>/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="form-group">  
                                <label class="control-label col-md-2">Anggaran Rencana</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqAnggaranRencana"  id="reqAnggaranRencana" value="<?=$reqAnggaranRencana?>" style="width:100%"  <?=$disabled?> />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Anggaran Realisasi</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqAnggaranRealisasi"  id="reqAnggaranRealisasi" value="<?=$reqAnggaranRealisasi?>" style="width:100%"   <?=$disabled?>/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                            <div class="form-group">  
                                <label class="control-label col-md-2">Work Order</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input type="hidden" name="reqWorkOrderId" id="reqWorkOrderId" value="<?=$reqWorkOrderId?>" style="width:100%" />
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqWorkOrderNama"  id="reqWorkOrderNama" value="<?=$reqWorkOrderNama?>" style="width:100%" readonly />
                                        </div>
                                        <?
                                        if($vstatus !== "20")
                                        {
                                            ?>
                                            <div class="col-md-1">
                                                <a id="btnAdd" onclick="openWork()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                            </div>
                                            <?
                                        }
                                        ?>
                                       
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Work Request</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input type="hidden" name="reqWorkRequestId" id="reqWorkRequestId" value="<?=$reqWorkRequestId?>" style="width:100%" />
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqWorkRequestNama"  id="reqWorkRequestNama" value="<?=$reqWorkRequestNama?>" style="width:100%" readonly />
                                        </div>
                                        <?
                                        if($vstatus !== "20")
                                        {
                                            ?>
                                            <div class="col-md-1">
                                                <a id="btnAdd" onclick="openWorkRequest()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                            </div>
                                            <?
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Kode PRK</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKodePrk"  id="reqKodePrk" value="<?=$reqKodePrk?>" style="width:100%"  <?=$disabled?> />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Rencana Eksekusi Tanggal Awal Pelaksanaan</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-12'>
                                            <input autocomplete="off" class="easyui-datebox form-control" type="text" name="reqRencanaTanggalAwal"  id="reqRencanaTanggalAwal" value="<?=$reqRencanaTanggalAwal?>" style="width:100%"   />
                                            <label style="margin-left: 15px">Tanggal Akhir</label>
                                            <input autocomplete="off" class="easyui-datebox form-control" type="text" name="reqRencanaTanggalAkhir"  id="reqRencanaTanggalAkhir" value="<?=$reqRencanaTanggalAkhir?>" style="width:100%"   <?=$disabled?> />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Durasi (Rencana)</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqDurasiRencana"  id="reqDurasiRencana" value="<?=$reqDurasiRencana?>" style="width:50%"  <?=$disabled?> />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">  
                                <label class="control-label col-md-2">Realisasi Eksekusi Tanggal Awal Pelaksanaan</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-12'>
                                            <input autocomplete="off" class="easyui-datebox form-control" type="text" name="reqRealisasiTanggalAwal"  id="reqRealisasiTanggalAwal" value="<?=$reqRealisasiTanggalAwal?>" style="width:100%"  <?=$disabled?> />
                                            <label style="margin-left: 15px">Tanggal Akhir</label>
                                            <input autocomplete="off" class="easyui-datebox form-control" type="text" name="reqRealisasiTanggalAkhir"  id="reqRealisasiTanggalAkhir" value="<?=$reqRealisasiTanggalAkhir?>" style="width:100%"   <?=$disabled?>/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">  
                                <label class="control-label col-md-2">Durasi (Realisasi)</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input autocomplete="off" readonly class="easyui-validatebox textbox form-control" type="text" name="reqDurasiRealisasi"  id="reqDurasiRealisasi" value="<?=$reqDurasiRealisasi?>" style="width:50%"  <?=$disabled?> />
                                        </div>
                                    </div>
                                </div>
                            </div>

                         
                            <div class="form-group">  
                                <label class="control-label col-md-2">Progress (%)</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-3'>
                                           <!--  <input  name="reqTimelineRlaId" class="easyui-combobox form-control" id="reqTimelineRlaId"
                                            data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combotimelinerla'" value="<?=$reqTimelineRlaId?>"  /> -->
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqProgress"  id="reqProgress" value="<?=$reqProgress?>" style="width:60%"   <?=$disabled?> />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">  
                                <label class="control-label col-md-2">Pic</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <!-- <input  name="reqPicId" class="easyui-combobox form-control" id="reqPicId"
                                            data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combouser'" value="<?=$reqPicId?>"  /> -->
                                            <input type="hidden" name="reqPicId" id="reqPicId" value="<?=$reqPicId?>" style="width:100%" />
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqPicNama"  id="reqPicNama" value="<?=$reqPicNama?>" style="width:60%" readonly />
                                            <?
                                            if($vstatus !== "20")
                                            {
                                            ?>
                                                <a id="btnAdd" onclick="openPic()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                                <a><input type="checkbox" id="reqSemua" /> &nbsp;Semua Distrik</a>

                                            <?
                                            }
                                            ?>
                                           
                                          
                                        </div>
                                      <!--   <div class="col-md-1">
                                            <a id="btnAdd" onclick="openPic()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i> </a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Status</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqStatus"  id="reqStatus" value="<?=$reqStatus?>" style="width:100%"  <?=$disabled?> />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Pemeriksa</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                           <!--  <input  name="reqPemeriksaId" class="easyui-combobox form-control" id="reqPemeriksaId"
                                            data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combouserpemeriksa'" value="<?=$reqPemeriksaId?>"  /> -->
                                            <input type="hidden" name="reqPemeriksaId" id="reqPemeriksaId" value="<?=$reqPemeriksaId?>" style="width:100%" />
                                            <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqPicNama"  id="reqPemeriksaNama" value="<?=$reqPemeriksaNama?>" style="width:60%" readonly />
                                            <?
                                            if($vstatus !== "20")
                                            {
                                            ?>
                                                 <a id="btnAdd" onclick="openPemeriksa()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                            <a><input type="checkbox" id="reqSemuaPemeriksa" /> &nbsp;Semua Distrik</a>


                                            <?
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Lampiran</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input  name="reqLampiran"  id="reqLampiran" type="file"   <?=$disabled?>/>
                                            <?
                                            if(!empty($reqLampiran))
                                            {
                                            ?>
                                                <a href="<?=$reqLampiran?>" target="_blank"><img src="images/icon-download.png"></a>
                                            <? 
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
<!-- 
                            <div class="form-group">  
                                <label class="control-label col-md-2">List Form Uji</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-9'>
                                           
                                        <select class="form-control jscaribasicmultiple" id="reqListFormUji" <?=$disabled?> name="reqListFormUji[]" style="width:100%;" multiple="multiple">
                                            <?/*
                                            foreach($arrformuji as $item) 
                                            {
                                                $selectvalid= $item["id"];
                                                $selectvaltext= $item["text"];

                                                $selected="";
                                                if(in_array($selectvalid, $reqListFormUji))
                                                {
                                                    $selected="selected";
                                                }
                                                ?>
                                                <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                                <?
                                            }
                                            */?>
                                        </select>
                                        <br>
                                        <br>
                                       

                                        </div>
                                    </div>
                                </div>
                            </div> -->


                            <div class="form-group">  
                                <label class="control-label col-md-2">List Form Uji</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input type="hidden" name="reqListFormUjiId" id="reqListFormUjiId" value="<?=$reqListFormUjiId?>" style="width:100%" />
                                            <?
                                            if($vstatus !== "20")
                                            {
                                            ?>
                                               <a id="btnAdd" onclick="openFormUji()"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                            <?
                                            }
                                            ?>

                                            <div class="inner" id="divlistform">
                                            <?
                                                if(!empty($arrlistformuji))
                                                {
                                                    foreach ($arrlistformuji as $key => $value) 
                                                    {
                                                        $valplanrlaid= $value["PLAN_RLA_ID"];
                                                        $valformujiid= $value["FORM_UJI_ID"];
                                                        $valkelompokequipmentid= $value["KELOMPOK_EQUIPMENT_ID"];
                                                        $valnama= $value["FORM_UJI_NAMA"];
                                                        $valequipmentnama= $value["KELOMPOK_EQUIPMENT_NAMA"];
                                                        ?>
                                                        <div class="item"><?=$valnama?> <?=$valequipmentnama?>
                                                        <?
                                                        if($vstatus !== "20")
                                                        {
                                                            ?>
                                                        <i class="fa fa-times-circle" onclick="$(this).parent().remove(); "></i>
                                                        <?
                                                        }
                                                        ?>
                                                        <input type="hidden" name="reqEquipmentFormUjiId[]" value="<?=$valkelompokequipmentid?>">
                                                        <input type="hidden" name="reqFormUjiEquipmentId[]" value="<?=$valformujiid?>">
                                                        </div>
                                                        <?
                                                    }
                                                }
                                            ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?
                            if($vstatus == 20)
                            {
                            ?>
                            <div class="form-group">  
                                <label class="control-label col-md-2">Download template</label>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <div class='col-md-12'>
                                             <span style="background-color: green;padding: 8px; border-radius: 5px;color: white"><a onclick="openTemplate('<?=$reqId?>')"><i class="fa fa-download fa-lg" style="color: white;" aria-hidden="true"></i></a> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                            }
                            ?>
                            <div class="form-group">  
                                <label class="control-label col-md-2">Nomor Pengadaan</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                        <select class="form-control jscaribasicmultiple" id="reqNomorPengadaan" <?=$disabled?> name="reqNomorPengadaan[]" style="width:100%;" multiple="multiple">
                                            <?
                                            foreach($arrpengadaan as $item) 
                                            {
                                                $selectvalid= $item["id"];
                                                $selectvaltext= $item["text"];

                                                $selected="";
                                                if(in_array($selectvalid, $reqNomorPengadaan))
                                                {
                                                    $selected="selected";
                                                }
                                                ?>
                                                <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                            if($reqLihat ==1)
                            {}
                            else
                            {
                                ?>
                            <div style="text-align:center;padding:5px">
                                <input type='hidden' name='is_draft' id="is_draft" value='<?php echo ($vstatus==1)?1:0?>'>
                                <?
                                if($vstatus==1 || $vstatus =='')
                                {
                                ?>
                                <a href="javascript:void(0)" class="btn btn-primary" id='draft'>Simpan Draft</a>
                                <?
                                }
                                ?>
                                <a href="javascript:void(0)" class="btn btn-warning" id='update' <?php echo  $editable?>>Kirim</a>
                            </div>
                            <?
                            }
                            ?>
                        </div>
                       <!--  <div id="timelane" class="tab-pane fade in">
                            <iframe style="width: 100%; height: calc(100vh - 200px); border: none;" src="iframe/index/transaksi_timeline_rla?reqIdRla=<?=$reqId?>"></iframe>
                        </div> -->
                        <div id="pengadaan" class="tab-pane fade in">
                            <iframe style="width: 100%; height: calc(100vh - 200px); border: none;" src="iframe/index/transaksi_monitoring_pengadaan?reqIdRla=<?=$reqId?>"></iframe>
                        </div>
                        <div id="catatan" class="tab-pane fade in">
                            <iframe style="width: 100%; height: calc(100vh - 200px); border: none;" src="iframe/index/transaksi_catatan_rla?reqIdRla=<?=$reqId?>"></iframe>
                        </div>
                        <div id="pengukuran" class="tab-pane fade in">
                            <iframe style="width: 100%; height: calc(100vh - 200px); border: none;" src="iframe/index/transaksi_pengukuran?reqIdRla=<?=$reqId?>"></iframe>
                        </div>
                        <div id="report" class="tab-pane fade in">
                            <iframe style="width: 100%; height: calc(100vh - 200px); border: none;" src="iframe/index/report_form_uji_plan_rla?reqIdRla=<?=$reqId?>"></iframe>
                        </div>
                    </div>


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>

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
        $('#reqPicId').val("");
        $('#reqPicNama').val("");  
    });

    function tampilUnit(val) {
        if (val.loading) return val.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'>" + val.description + "</div>" +
        "</div>" +
        "</div>";
        return markup;
    }
    function pilihUnit(val) {
        $("#reqUnitId").val(val.id);
        $("#reqUnit").val(val.text);
        
        // console.log(val);
        return val.text;
    }

    $("#reqUnitAuto").select2({
        placeholder: "Pilih Unit",
        allowClear: true,
        ajax: {
            url: "json-app/combo_json/autocompleteunit",
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
        templateResult: tampilUnit, // omitted for brevity, see the source of this page
        templateSelection: pilihUnit // omitted for brevity, see the source of this page
    });


$(document).on("input", "#reqProgress,#reqTahun", function() {
        this.value = this.value.replace(/\D/g,'');
});

var format = function(num){
    var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(",") > 0) {
        parts = str.split(",");
        str = parts[0];
    }
    str = str.split("").reverse();
    for(var j = 0, len = str.length; j < len; j++) {
        if(str[j] != ".") {
            output.push(str[j]);
            if(i%3 == 0 && j < (len - 1)) {
                output.push(".");
            }
            i++;
        }
    }
    formatted = output.reverse().join("");
    return( formatted + ((parts) ? "," + parts[1].substr(0, 2) : ""));
};


$('#reqAnggaranRencana').on('input blur paste', function(){
    var numeric = $(this).val().replace(/\D/g, '');
    $(this).val(format(numeric));
});

$('#reqAnggaranRealisasi').on('input blur paste', function(){
    var numeric = $(this).val().replace(/\D/g, '');
    $(this).val(format(numeric));
});

$('#reqRencanaTanggalAkhir,#reqRencanaTanggalAwal').datebox({
    onSelect: function(date){
        var reqRencanaTanggalAwal =  $('#reqRencanaTanggalAwal').datebox('getValue');
        var reqRencanaTanggalAkhir =  $('#reqRencanaTanggalAkhir').datebox('getValue');
        var checkawal = reqRencanaTanggalAwal.split('-');
        var checkakhir = reqRencanaTanggalAkhir.split('-');
        var checkawal = new Date(checkawal[2], checkawal[1] - 1, checkawal[0]);
        var checkakhir = new Date(checkakhir[2], checkakhir[1] - 1, checkakhir[0]);

        if(reqRencanaTanggalAwal !=="" && reqRencanaTanggalAkhir !=="")
        {
            if(checkawal > checkakhir)
            {
                $.messager.alert('Info', 'Rencana Eksekusi Tanggal Awal tidak boleh lebih dari Tanggal Akhir', 'warning');
                reqDurasiRencana = $('#reqDurasiRencana').val("");
            }
            else
            {
                var awal = moment(reqRencanaTanggalAwal,'DD-MM-YYYY');
                var akhir = moment(reqRencanaTanggalAkhir,'DD-MM-YYYY');
                var durasi = moment.preciseDiff(awal, akhir);
                if(durasi=="")
                {
                  reqDurasiRencana =  $('#reqDurasiRencana').val('0 Hari');
                }
                else
                {
                  reqDurasiRencana = $('#reqDurasiRencana').val(durasi);
                }
            }
           
        }
    }
});

$('#reqRealisasiTanggalAkhir,#reqRealisasiTanggalAwal').datebox({
    onSelect: function(date){
        var reqRealisasiTanggalAwal =  $('#reqRealisasiTanggalAwal').datebox('getValue');
        var reqRealisasiTanggalAkhir =  $('#reqRealisasiTanggalAkhir').datebox('getValue');
        var checkawal = reqRealisasiTanggalAwal.split('-');
        var checkakhir = reqRealisasiTanggalAkhir.split('-');
        var checkawal = new Date(checkawal[2], checkawal[1] - 1, checkawal[0]);
        var checkakhir = new Date(checkakhir[2], checkakhir[1] - 1, checkakhir[0]);

        if(reqRealisasiTanggalAwal !=="" && reqRealisasiTanggalAkhir !=="")
        {
            if(checkawal > checkakhir)
            {
                $.messager.alert('Info', 'Realisasi Eksekusi Tanggal Awal tidak boleh lebih dari Tanggal Akhir', 'warning');
                reqDurasiRealisasi = $('#reqDurasiRealisasi').val("");
            }
            else
            {
               var awal = moment(reqRealisasiTanggalAwal,'DD-MM-YYYY');
               var akhir = moment(reqRealisasiTanggalAkhir,'DD-MM-YYYY');
               var durasi = moment.preciseDiff(awal, akhir);
               if(durasi=="")
               {
                  reqDurasiRealisasi =  $('#reqDurasiRealisasi').val('0 Hari');
               }
               else
               {
                 reqDurasiRealisasi = $('#reqDurasiRealisasi').val(durasi);
               }
            }
        }
    }
});

$('#update,#update2').click(function() {
    $('#is_draft').val(0);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});

$('#draft,#draft2').click(function() {
    $('#is_draft').val(1);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});

function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/plan_rla_json/add',
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

// $('#reqDistrikId').combobox({
//     onChange: function(value){
//         $('#reqDistrikId').val(value);
//     }
// })

function openPic()
{
    if ($('#reqSemua').is(":checked"))
    {
         var distrikid = '';
    }
    else
    {
        var distrikid = $('#reqDistrikId').val();
    }
   
    openAdd('app/index/lookup_pengguna?reqDistrikId='+distrikid);
}

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

function setPengguna(values)
{
    $('#reqPicId').val(values.NID);
    $('#reqPicNama').val(values.NAMA_LENGKAP);
}
function setPemeriksa(values)
{
    $('#reqPemeriksaId').val(values.NID);
    $('#reqPemeriksaNama').val(values.NAMA_LENGKAP);
}

$(document).ready(function() {
    $(".nav-link").on("click", function(){
     $(".nav-link.active").removeClass("active");
     $(this).addClass("active");
 });
});

function openWork()
{
    var reqDistrikId= $('#reqDistrikId').val();
    var reqEquipmentId= $('#reqEquipmentId').val();
    if(reqDistrikId=="")
    {
        alert('pilih Distrik terlebih dahulu');return false;
    }

    if(reqEquipmentId=="")
    {
        alert('pilih Equipment terlebih dahulu');return false;
    }
    // console.log(reqDistrikId);return false;
    openAdd('iframe/index/work_order?reqDistrikId='+reqDistrikId+'&reqEquipmentId='+reqEquipmentId);
}

function setWO(values)
{
    $('#reqWorkOrderId').val(values.WORK_ORDER_ID);
    $('#reqWorkOrderNama').val(values.DESCRIPTION);
}

function openWorkRequest()
{
    var reqDistrikId= $('#reqDistrikId').val();
    var reqEquipmentId= $('#reqEquipmentId').val();
    if(reqDistrikId=="")
    {
        alert('pilih Distrik terlebih dahulu');return false;
    }

    if(reqEquipmentId=="")
    {
        alert('pilih Equipment terlebih dahulu');return false;
    }

    // console.log(reqEquipmentId);return false;
    openAdd('iframe/index/work_request?reqDistrikId='+reqDistrikId+'&reqEquipmentId='+reqEquipmentId);
}

function setWR(values)
{
    // console.log(values);
    $('#reqWorkRequestId').val(values.WORK_REQUEST_ID);
    $('#reqWorkRequestNama').val(values.DESCRIPTION);
}

function openTemplate(reqId)
{
    openAdd('app/index/template_plan_rla_form_uji_dinamis?reqId='+reqId); 
}


function openFormUji()
{
    var reqKelompokEquipmentId =  $('#reqKelompokEquipment').val(); 

    // console.log(reqKelompokEquipmentId);

    if(reqKelompokEquipmentId)
    {
        openAdd('app/loadUrl/app/lookup_plan_rla_form_uji_tree?reqKelompokEquipmentId='+reqKelompokEquipmentId);
    }
    else
    {
        alert('Pilih Kelompok Equipment terlebih dahulu');return false;
    }
    
}

function addmultisatuanKerja(equipmentid,formujiid, multiinfonama, IDFIELD) 
{
    batas= equipmentid.length;
        console.log(multiinfonama);

        if(batas > 0)
        {
            rekursivemultisatuanKerja(0, equipmentid,formujiid, multiinfonama, IDFIELD);
        }
}

 function rekursivemultisatuanKerja(index, equipmentid,formujiid, multiinfonama, IDFIELD) 
    {
        urllink= "app/loadUrl/app/template_equipment_form_uji";
        method= "POST";
        batas= equipmentid.length;
        if(index < batas)
        {
            EQUIPMENT_ID= equipmentid[index];
            FORM_UJI_ID= formujiid[index];
            NAMA= multiinfonama[index];

            var rv = true;
           
            $('[name^=reqTujuanSuratValidasi]').each(function() {

                if ($(this).val() == EQUIPMENT_ID) {
                    rv = false;
                    return false;
                }

            });
            
            if (rv == true) 
            {
                $.ajax({
                    url: urllink,
                    method: method,
                    data: {
                        reqFormUjiId: FORM_UJI_ID,
                        reqEquipmentId: EQUIPMENT_ID,
                        reqNama: NAMA
                    },
                    // dataType: 'json',
                    success: function (response) {
                        $("#"+IDFIELD).append(response);
                        // setinfovalidasi();

                        index= parseInt(index) + 1;
                        rekursivemultisatuanKerja(index,equipmentid,formujiid, multiinfonama, IDFIELD);
                    },
                    error: function (response) {
                    },
                    complete: function () {
                    }
                });
            }
            else
            {
                index= parseInt(index) + 1;
                rekursivemultisatuanKerja(index,equipmentid,formujiid, multiinfonama, IDFIELD);
            }
        }
    }



</script>