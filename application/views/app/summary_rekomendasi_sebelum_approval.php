<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/PlanRlaFormUjiDinamis");
$this->load->model('base-app/PlanRla');
$this->load->model('base-app/TabelTemplate');
$this->load->model('base-app/FormUji');
$this->load->model("base-app/Crud");
$this->load->model("base-app/Nameplate");



$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));
$reqIdRla = $this->input->get("reqIdRla");
$reqLihat = $this->input->get("reqLihat");

$set= new PlanRla();
$arrkelompokequipment= [];
$statement = " AND B.PLAN_RLA_ID = '".$reqIdRla."' ";

$set->selectByParamsKelompokEquipment(array(), -1,-1,$statement);
// echo $set->query;exit;;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["ID"]= $set->getField("ID");
    $arrdata["KELOMPOK_EQUIPMENT_PARENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_PARENT_ID");
    array_push($arrkelompokequipment, $arrdata);
}
unset($set);

// print_r($arrkelompokequipment);



$statement = " AND A.PLAN_RLA_ID = '".$reqIdRla."' ";
$set= new PlanRla();
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$vstatus= $set->getField("V_STATUS");
unset($set);

$adadata=0;

$kode= $appuserkodehak;
$set= new Crud();
$statement=" AND (A.PENGGUNA_HAK_ID = 1 OR A.PENGGUNA_HAK_ID = 8 OR A.PENGGUNA_HAK_ID = 9)   AND KODE_MODUL ='0501' AND A.KODE_HAK =  '".$kode."'  ";
$set->selectByParamsCrudHak(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqMenuUmro= $set->getField("MENU");

unset($set);

$set= new Nameplate();
$arrformnameplate= [];

$statement = " AND A.STATUS <> '1'";
$set->selectByParams(array(), -1, -1, $statement);
    // echo  $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("NAMEPLATE_ID");
    $arrdata["text"]= $set->getField("NAMA");

    array_push($arrformnameplate, $arrdata);
}

// var_dump($reqIya);exit;
?>
<script language="javascript" type="text/javascript" src="assets/editors/ckeditor/ckeditor.js"></script>
<script type="text/javascript" language="javascript" class="init">
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/plan_rla_json/addsummary',
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

            // console.log(reqId);

            if(reqId == 'xxx')
                $.messager.alert('Info', infoSimpan, 'warning');
            else
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/summary_rekomendasi?reqIdRla=<?=$reqIdRla?>");
        }
    });
}


</script>

<style>
	thead.stick-datatable th:nth-child(1){	width:440px !important; *border:1px solid cyan;}
	thead.stick-datatable ~ tbody td:nth-child(1){	width:440px !important; *border:1px solid yellow;}
</style>

<div class="col-md-12">
    <!-- <div class="judul-halaman"> Data <?=$pgtitle?></div> -->
    <div class="judul-halaman"> <a href="app/index/transaksi_management_master_plan">Data Management Master Plan</a> › <a href="app/index/transaksi_management_master_plan_add?reqId=<?=$reqIdRla?>">Kelola Management Master Plan </a> › <?=$pgtitle?></div>
    <div class="konten-area">
        <div class="konten-inner">
            <ul class="nav nav-pills mr-auto">
                <li class="nav-item  ">
                    <a class="nav-link  " href="app/index/transaksi_management_master_plan_add?reqId=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Master Plan RLA</a>
                </li>
                <?
                if(!empty($reqIdRla))
                {
                    ?> 
                    <li class="nav-item " >
                        <a class="nav-link "  href="app/index/transaksi_timeline_rla?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Timelane Rla</a>
                    </li>
                    <li class="nav-item  ">
                        <a class="nav-link  " href="app/index/transaksi_catatan_rla?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Catatan/Log RLA</a>
                    </li>

                    <?
                    if($vstatus==20 &&  $reqMenuUmro == 1)
                    {
                        ?>
                        <li class="nav-item ">
                            <a class="nav-link "  href="app/index/transaksi_monitoring_pengadaan?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Monitoring Pengadaan & Kontrak</a>
                        </li>
                        <?
                    }
                    ?>
                  
                    <li class="nav-item ">
                        <a class="nav-link " href="app/index/transaksi_pengukuran?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Pengukuran</a>
                    </li>

                    <?
                    if($vstatus==20 &&  $reqMenuUmro == 1)
                    {
                        ?>
                        <li class="nav-item active ">
                            <a class="nav-link active" href="app/index/summary_rekomendasi?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Summary dan Rekomendasi</a>
                        </li>
                        <?
                    }
                    ?>
                    <li class="nav-item ">
                        <a class="nav-link " href="app/index/report_form_uji_plan_rla_dinamis?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Report</a>
                    </li>
                    <?
                }
                ?>
            </ul>
            <hr style="height:0.8px;border:none;color:#333;background-color:#333;">
        </div>

        <div >
            <div class='col-md-12'>
               <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data" autocomplete="off">

                <?
                if(!empty($arrkelompokequipment))
                {
                     $idcheck=[];
                     $idcheckpengukuran=[];
                ?>
                    <?
                    foreach ($arrkelompokequipment as $key => $value) 
                    {
                        $reqKelompokEquipmentId=$value["KELOMPOK_EQUIPMENT_ID"];
                        $reqKelompokEquipmentParentId=$value["KELOMPOK_EQUIPMENT_PARENT_ID"];
                        $reqKelId=$value["ID"];  
                        $reqNamaKelompok=$value["NAMA"]; 
                        $idcheck[]= $reqKelompokEquipmentId;

                        $set= new PlanRla();
                        $statement=" AND A.PLAN_RLA_ID = '".$reqIdRla."'  AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."'  ";
                        $set->selectByParamsNameplate(array(), -1, -1, $statement);
                        // echo $set->query;exit;
                        $set->firstRow();
                        $reqIdRlaNameplateId= $set->getField("PLAN_RLA_NAMEPLATE_ID");
                        $reqNameplateId= $set->getField("NAMEPLATE_ID");
                        $reqSummary= $set->getField("SUMMARY");
                        $reqRekomendasi= $set->getField("REKOMENDASI");

                        // var_dump($reqKelompokEquipmentParentId);
                        $hitung=strlen($reqKelId);
                        $margin="";
                        if($hitung > 3)
                        {
                            $margin="margin-left: 50px";
                        }
                        // var_dump($hitung);
                    ?>
                            <div class="page-header headernew class_header_<?=$reqKelompokEquipmentId?>" id="<?=$reqKelompokEquipmentId?>" style="background-color: #ff0655; <?=$margin?>">
                                <h3><i class="fa fa-id-badge fa-lg"></i> <?=$reqNamaKelompok?></h3>

                            </div>
                            <br>

                            <div class="content  class_form_<?=$reqKelompokEquipmentId?>" id="tabel_<?=$reqKelompokEquipmentId?>">

                                <div class="form-group">  
                                    <label class="control-label col-md-2">Nameplate</label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <select class="form-control jscaribasicmultiple" id="reqNameplateId" <?=$disabled?> name="reqNameplateId[]" style="width:100%;" >
                                                    <option value="" >Pilih Nameplate</option>
                                                    <?
                                                    foreach($arrformnameplate as $item) 
                                                    {
                                                        $selectvalid= $item["id"];
                                                        $selectvaltext= $item["text"];

                                                        $selected="";
                                                        if($selectvalid == $reqNameplateId)
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
                                    <label class="control-label col-md-2">Summary</label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <textarea id="check-<?=$reqFormDetilId?>" <?=$disabled?>  name="reqSummary[]" style="width:100%;"><?=$reqSummary?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">  
                                    <label class="control-label col-md-2">Rekomendasi</label>
                                    <div class='col-md-8'>
                                        <div class='form-group'>
                                            <div class='col-md-11'>
                                                <textarea id="check-<?=$reqFormDetilId?>" <?=$disabled?>  name="reqRekomendasi[]" style="width:100%;"><?=$reqRekomendasi?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="reqIdRla[]" value="<?=$reqIdRla?>">
                            <input type="hidden" name="reqKelompokEquipmentId[]" value="<?=$reqKelompokEquipmentId?>">
                            <input type="hidden" name="reqIdRlaNameplateId[]" value="<?=$reqIdRlaNameplateId?>">

                    <?
                    }
                    ?>
 
                <?
                }
                else
                {   
                ?>
                    <div class="page-header" style="text-align: center;background-color: #fe1414;">
                        <h3> Data Form Uji Belum Diisi</h3>       
                    </div>
                <?
                }
                ?>


                <?
                if($reqLihat ==1)
                {}
                else
                {
                    ?>
                    <div style="text-align:center;padding:5px" >
                        <div >
                            <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Simpan</a>
                        </div>
                       
                    </div>
                    <?
                }
                ?>

               
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">


var arridcheck = <?php echo json_encode($idcheck); ?>;

arridcheck.forEach(function(item) {
    // console.log(item);
    $('.class_header_'+item ).not(':first').hide();

});


$(".headernew").click(function () {

    var bidValue = this.id;
      // console.log(bidValue);
    $('.class_header_'+bidValue ).not(':first').hide();
    $('.class_form_'+bidValue ).slideToggle(300);
});

for(k in CKEDITOR.instances){
    var instance = CKEDITOR.instances[k];
    instance.destroy()
}
CKEDITOR.replaceAll();


</script>