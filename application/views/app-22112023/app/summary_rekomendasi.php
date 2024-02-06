<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/PlanRlaFormUjiDinamis");
$this->load->model('base-app/PlanRla');
$this->load->model('base-app/TabelTemplate');
$this->load->model('base-app/FormUji');
$this->load->model("base-app/Crud");
$this->load->model("base-app/Nameplate");
$this->load->library('libapproval');



$appuserkodehak= $this->appuserkodehak;
$appuserroleid=$this->appuserroleid;


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
    $arrdata["PARENT_ID"]= $set->getField("PARENT_ID");
    array_push($arrkelompokequipment, $arrdata);
}
unset($set);

// print_r($arrkelompokequipment);


$statement = " AND A.PLAN_RLA_ID = '".$reqIdRla."' ";
$set= new PlanRla();
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$vstatus= $set->getField("V_STATUS");
$reqFinish= $set->getField("STATUS_FINISH");
unset($set);


$statement = " AND A.PLAN_RLA_ID = '".$reqIdRla."' ";
$set= new PlanRla();
$set->selectByParamsSummary(array(), -1, -1, $statement);
    // echo  $set->query;exit;

$set->firstRow();
$reqId= $set->getField("PLAN_RLA_SUMMARY_ID");
$vstatusSummary= $set->getField("V_STATUS");
$reqTestedId= $set->getField("TESTED_ID");
$reqTestedNama= $set->getField("TESTED_NAMA");
$reqTestedStatus= $set->getField("TESTED_STATUS");
$reqCoordinatorId= $set->getField("COORDINATOR_ID");
$reqCoordinatorNama= $set->getField("COORDINATOR_NAMA");
$reqCoordinatorStatus= $set->getField("COORDINATOR_STATUS");
$reqQualityId= $set->getField("QUALITY_ID");
$reqQualityNama= $set->getField("QUALITY_NAMA");
$reqQualityStatus= $set->getField("QUALITY_STATUS");

$reqWitnessId= $set->getField("WITNESS_ID");
$reqWitnessNama= $set->getField("WITNESS_NAMA");
$reqWitnessStatus= $set->getField("WITNESS_STATUS");

// var_dump($vstatusSummary);

unset($set);

$editable= ($vstatusSummary<10 || $vstatusSummary>=90) ? '':'style="display:none"';


$adadata=0;

$kode= $appuserkodehak;
$set= new Crud();
$statement=" AND (A.PENGGUNA_HAK_ID = 1 OR A.PENGGUNA_HAK_ID = 8 )   AND KODE_MODUL ='0501' AND A.KODE_HAK =  '".$kode."'  ";
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


$kode= $appuserkodehak;
$set= new Crud();
$statement=" AND (A.PENGGUNA_HAK_ID = 1 OR A.PENGGUNA_HAK_ID = 9)   AND KODE_MODUL ='0501' AND A.KODE_HAK =  '".$kode."'  ";
$set->selectByParamsCrudHak(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqTimMenuUmro= $set->getField("MENU");

unset($set);


$disabledfinish="";

if($reqFinish==1)
{
    $disabledfinish="disabled"; 
}


$statement = " AND B.ROLE_ID = '".$appuserroleid."' ";
$reftabel = "summary_rekomendasi";
$set= new PlanRla();
$set->selectcheckapproval($reftabel, $reqId,$statement);
// echo $set->query;exit;
$set->firstRow();
$reqFlowIndex= $set->getField("FLOWD_INDEX");
// var_dump($reqFlowIndex);

unset($set);

function rand_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
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
                    if($vstatus==20 &&  ($reqMenuUmro == 1 ||  $reqTimMenuUmro == 1))
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
                // untuk approval
                ?>
                <input type="hidden" name="infopg" value="<?=$pg?>" />
                <?
                $approval_table= "plan_rla_summary";
                $approval_field_id= "PLAN_RLA_SUMMARY_ID";
                $approval_field_status= "V_STATUS";
                $vappr= new libapproval();
                $arrparam= ["approval_info_pg"=>$pg, "approval_info_id"=>$reqId, "approval_table"=>$approval_table, "approval_field_id"=>$approval_field_id, "approval_field_status"=>$approval_field_status];
                // print_r($arrparam);
                $vappr->view($arrparam);
                ?>

                <div class="page-header" >
                    <h3><i class="fa fa-id-badge fa-lg"></i> Penanda tangan</h3>
                </div>
                <div class="content" >
                    <div class="form-group" >  
                        <label class="control-label col-md-2">Tested/measured by</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="hidden" name="reqTestedId" id="reqTestedId" value="<?=$reqTestedId?>" style="width:100%" />
                                    <input type="hidden" name="reqTestedStatus" id="reqTestedStatus" value="<?=$reqTestedStatus?>" style="width:100%" />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqTestedNama"  id="reqTestedNama" value="<?=$reqTestedNama?>" style="width:60%" readonly />
                                    <?
                                    if($vstatusSummary !== 20)
                                    {
                                        ?>
                                        <a id="btnAdd" onclick="popup(1)"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                        <?
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-2">Coordinator</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="hidden" name="reqCoordinatorId" id="reqCoordinatorId" value="<?=$reqCoordinatorId?>" style="width:100%" />
                                    <input type="hidden" name="reqCoordinatorStatus" id="reqCoordinatorStatus" value="<?=$reqCoordinatorStatus?>" style="width:100%" />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqCoordinatorNama"  id="reqCoordinatorNama" value="<?=$reqCoordinatorNama?>" style="width:60%" readonly />
                                    <?
                                    if($vstatusSummary !== 20)
                                    {
                                        ?>
                                        <a id="btnAdd" onclick="popup(2)"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>

                                        <?
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-2">Quality Control</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="hidden" name="reqQualityId" id="reqQualityId" value="<?=$reqQualityId?>" style="width:100%" />
                                    <input type="hidden" name="reqQualityStatus" id="reqQualityStatus" value="<?=$reqQualityStatus?>" style="width:100%" />
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqQualityNama"  id="reqQualityNama" value="<?=$reqQualityNama?>" style="width:60%" readonly />
                                    <?
                                    if($vstatusSummary !== 20)
                                    {
                                        ?>
                                        <a id="btnAdd" onclick="popup(3)"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >  
                        <label class="control-label col-md-2">Witness</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input type="hidden" name="reqWitnessId" id="reqWitnessId" value="<?=$reqWitnessId?>" style="width:100%" />
                                   <input type="hidden" name="reqWitnessStatus" id="reqWitnessStatus" value="<?=$reqWitnessStatus?>" style="width:100%" />
                                   <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqWitnessNama"  id="reqWitnessNama" value="<?=$reqWitnessNama?>" style="width:60%" readonly />
                                    <?
                                    if($vstatusSummary !== 20)
                                    {
                                    ?>
                                        <a id="btnAdd" onclick="popup(4)"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp; </a>
                                    <?
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                        $reqParentId=$value["PARENT_ID"];

                        $set= new PlanRla();
                        $statement=" AND A.PLAN_RLA_ID = '".$reqIdRla."'  AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' AND A.PLAN_RLA_SUMMARY_ID = '".$reqId."'  ";
                        $set->selectByParamsNameplate(array(), -1, -1, $statement);
                        // echo $set->query;exit;
                        $set->firstRow();
                        $reqIdRlaNameplateId= $set->getField("PLAN_RLA_NAMEPLATE_ID");
                        $reqNameplateId= $set->getField("NAMEPLATE_ID");
                        $reqSummary= $set->getField("SUMMARY");
                        $reqRekomendasi= $set->getField("REKOMENDASI");

                        // var_dump($reqKelompokEquipmentParentId);
                        $hitung=strlen($reqKelId);
                        $hitungparent=strlen($reqParentId);

                        $margin="";

                        if($hitungparent==1)
                        {
                            $warnaparent="#e60049";
                        }
                        elseif($hitungparent==3)
                        {
                            $warnaparent="#f93d18";
                            $margin="margin-left: 10px";
                        }
                        elseif($hitungparent==6)
                        {
                            $warnaparent="#0000e6";
                            $margin="margin-left: 20px";
                        }
                        elseif($hitungparent==9)
                        {
                            $warnaparent="#1aff1a";
                            $margin="margin-left: 30px";
                        }
                        elseif($hitungparent==12)
                        {
                            $warnaparent="#009900";
                            $margin="margin-left: 40px";
                        }
                        elseif($hitungparent==15)
                        {
                            $warnaparent="#8c1aff";
                            $margin="margin-left: 50px";
                        }
                        elseif($hitungparent==18)
                        {
                            $warnaparent="#ff3377";
                            $margin="margin-left: 60px";
                        }
                        elseif($hitungparent==21)
                        {
                            $warnaparent="#b3b300";
                            $margin="margin-left: 70px";
                        }
                        elseif($hitungparent==24)
                        {
                            $warnaparent="#3399ff";
                            $margin="margin-left: 80px";
                        }
                        elseif($hitungparent==27)
                        {
                            $warnaparent="#669999";
                            $margin="margin-left: 90px";
                        }
                        elseif($hitungparent==30)
                        {
                            $warnaparent=rand_color();
                            $margin="margin-left: 100px";
                        }
                        elseif($hitungparent==33)
                        {
                            $warnaparent=rand_color();
                            $margin="margin-left: 110px";
                        }
                        elseif($hitungparent==36)
                        {
                            $warnaparent=rand_color();
                            $margin="margin-left: 120px";
                        }
                        elseif($hitungparent==39)
                        {
                            $warnaparent=rand_color();
                            $margin="margin-left: 130px";
                        }
                        else
                        {
                            $warnaparent="green";
                        }

                        $result = substr($reqKelId, 0, 3);
                        // var_dump($warnaparent);
                       
                    ?>
                            <?
                            if($reqParentId==0)
                            {
                            ?>
                                <div class="page-header headernew class_header_<?=$reqKelompokEquipmentId?> " id="<?=$result?>" style="background-color:  <?=$warnaparent?>; <?=$margin?>">
                                    <h3><i class="fa fa-id-badge fa-lg"></i> <?=$reqNamaKelompok?></h3>
                                </div>
                            <?
                            }
                            else
                            {
                            ?>
                                <div class="page-header headernew class_header_<?=$reqKelompokEquipmentId?> class_header_parent_<?=$result?> " id="<?=$reqKelompokEquipmentId?>" style="background-color:  <?=$warnaparent?>; <?=$margin?>">
                                    <h3><i class="fa fa-id-badge fa-lg"></i> <?=$reqNamaKelompok?></h3>
                                </div>
                            <?
                            }
                            ?>
                                  
                            <!-- <br> -->

                            <div style="<?=$margin?>" class="content class_form_<?=$reqKelompokEquipmentId?> class_form_parent_<?=$result?>" >
                                <div id="tabel_<?=$reqKelompokEquipmentId?>">
                                    <div class="form-group" >  
                                        <label class="control-label col-md-2">Nameplate</label>
                                        <div class='col-md-8'>
                                            <div class='form-group'>
                                                <div class='col-md-11'>
                                                    <select class="form-control jscaribasicmultiple" id="reqNameplateId" <?=$disabled?> <?=$disabledfinish?> name="reqNameplateId[]" style="width:100%;" >
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
                                                    <textarea id="check-<?=$reqFormDetilId?>" class="nd" <?=$disabled?> <?=$disabledfinish?>  name="reqSummary[]" style="width:100%;"><?=$reqSummary?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">  
                                        <label class="control-label col-md-2">Rekomendasi</label>
                                        <div class='col-md-8'>
                                            <div class='form-group'>
                                                <div class='col-md-11'>
                                                    <textarea id="check-<?=$reqFormDetilId?>"  <?=$disabled?> <?=$disabledfinish?>  name="reqRekomendasi[]" style="width:100%;"><?=$reqRekomendasi?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="reqIdRla[]" value="<?=$reqIdRla?>">
                            <input type="hidden" name="reqKelompokEquipmentId[]" value="<?=$reqKelompokEquipmentId?>">
                            <input type="hidden" name="reqIdRlaNameplateId[]" value="<?=$reqIdRlaNameplateId?>">
                            <input type="hidden" name="reqId" value="<?=$reqId?>">

                    <?
                    }
                    ?>
 
                <?
                }
                else
                {   
                ?>
                  <!--   <div class="page-header" style="text-align: center;background-color: #fe1414;">
                        <h3> Data Form Uji Belum Diisi</h3>       
                    </div> -->
                <?
                }
                ?>


                <?
                if($reqLihat ==1 || $reqFinish==1)
                {}
                else
                {
                    ?>
                    <div style="text-align:center;padding:5px" >
                        <input type='hidden' name='is_draft' id="is_draft" value='<?php echo ($vstatusSummary==1)?1:0?>'>
                     <!--    <div >
                            <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Simpan</a>
                        </div> -->

                        <?
                        if($vstatusSummary==1 || $vstatusSummary =='')
                        {
                            ?>
                            <a href="javascript:void(0)" class="btn btn-primary" id='draft'>Simpan Draft</a>
                            <?
                        }
                        ?>

                        <?
                        if($vstatusSummary==20 )
                        {
                            ?>
                            <!-- <a href="javascript:void(0)" class="btn btn-primary" id='updateapp'>Finish</a> -->
                            <?
                        }
                        ?>


                       <a href="javascript:void(0)" class="btn btn-warning" id='update' <?php echo  $editable?>>Kirim</a>
                      
                       
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

    var panjang = bidValue.length;
    var firstchar = bidValue.substring(0, 1);

    if(panjang==3 && firstchar ==0 )
    {
         $('.class_header_parent_'+bidValue ).slideToggle(300);
         $('.class_form_parent_'+bidValue ).slideToggle(300);
    }
    else
    {
        $('.class_header_'+bidValue ).not(':first').hide();
        $('.class_form_'+bidValue ).slideToggle(200);
        $('#tabel_'+bidValue ).slideToggle(100);
    }    
    
});

$('#update,#update2').click(function() {
    $('#is_draft').val(0);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});

$('#updateapp').click(function() {
    $('#is_draft').val(1);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});


$('#draft,#draft2').click(function() {
    $('#is_draft').val(1);
    submitForm();
    return false; // avoid to execute the actual submit of the form.
});

function popup(jenis)
{
    openAdd('app/index/lookup_pengguna?reqJenis='+jenis);
}

function setTestedBy(values)
{
    // console.log(values);
    $('#reqTestedId').val(values.USER_ID);
    $('#reqTestedNama').val(values.NAMA_LENGKAP);
    $('#reqTestedStatus').val(values.STATUS_TABEL);
}
function setCoordinator(values)
{
    // console.log(values);
    $('#reqCoordinatorId').val(values.USER_ID);
    $('#reqCoordinatorNama').val(values.NAMA_LENGKAP);
    $('#reqCoordinatorStatus').val(values.STATUS_TABEL);
}
function setQuality(values)
{
    // console.log(values);
    $('#reqQualityId').val(values.USER_ID);
    $('#reqQualityNama').val(values.NAMA_LENGKAP);
    $('#reqQualityStatus').val(values.STATUS_TABEL);
}
function setWitness(values)
{
    // console.log(values);
    $('#reqWitnessId').val(values.USER_ID);
    $('#reqWitnessNama').val(values.NAMA_LENGKAP);
    $('#reqWitnessStatus').val(values.STATUS_TABEL);
}

for(k in CKEDITOR.instances){
    var instance = CKEDITOR.instances[k];
    instance.destroy()
}
CKEDITOR.replaceAll();


</script>