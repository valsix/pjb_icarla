<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/PlanRlaFormUjiDinamis");
$this->load->model('base-app/PlanRla');
$this->load->model('base-app/TabelTemplate');
$this->load->model('base-app/FormUji');
$this->load->model("base-app/Crud");


$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));
$reqIdRla = $this->input->get("reqIdRla");
$reqLihat = $this->input->get("reqLihat");

$set= new PlanRla();
$arrformuji= [];
$statement = " AND D.PLAN_RLA_ID = '".$reqIdRla."' ";

$set->selectByParamsFormUjiReport(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
    $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
    array_push($arrformuji, $arrdata);
}
unset($set);

// print_r($arrformuji);

$set= new PlanRla();

$statement = " AND A.PLAN_RLA_ID = '".$reqIdRla."' ";
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$reqIya = $set->getField("STATUS_CATATAN");
unset($set);


$statement = " AND A.PLAN_RLA_ID = '".$reqIdRla."' ";
$set= new PlanRla();
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$vstatus= $set->getField("V_STATUS");
unset($set);

$adadata=0;

$kode= $appuserkodehak;
$set= new Crud();
$statement=" AND (A.PENGGUNA_HAK_ID = 1 OR A.PENGGUNA_HAK_ID = 8)   AND KODE_MODUL ='0501' AND A.KODE_HAK =  '".$kode."'  ";
$set->selectByParamsCrudHak(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqMenuUmro= $set->getField("MENU");

unset($set);

// var_dump($reqIya);exit;


?>
<script type="text/javascript" language="javascript" class="init">
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/plan_rla_json/addreport',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/report_form_uji_plan_rla_dinamis?reqIdRla=<?=$reqIdRla?>");
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
                    <li class="nav-item active">
                        <a class="nav-link active" href="app/index/report_form_uji_plan_rla_dinamis?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Report</a>
                    </li>
                    <?
                }
                ?>
            </ul>
            <hr style="height:0.8px;border:none;color:#333;background-color:#333;">
        </div>

        <div class='form-group'>
            <div class='col-md-12'>
               <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> Catatan/Log</h3> 

                </div>
                <div class="form-group">  
                    <label class="control-label col-md-2">Tampil Catatan/Log di report</label>
                    <div class='col-md-8'>
                        <div class='form-group'>
                            <div class='col-md-11'>
                                <input type="radio" id="reqYa" name="reqYa" <?if($reqIya==1)echo 'checked' ?> value="1">
                                <label for="reqYa"> Tampilkan</label><br>
                                <input type="radio" id="reqYa" name="reqYa" <?if($reqIya=="")echo 'checked' ?>   value="">
                                <label for="reqYa"> Tidak</label><br>

                            </div>
                        </div>
                    </div>
                </div>   

                <?
                if(!empty($arrformuji))
                {
                ?>
                    <?
                    foreach ($arrformuji as $key => $value) 
                    {
                        $reqFormUjiId=$value["FORM_UJI_ID"]; 
                        $reqKelompokEquipmentId=$value["KELOMPOK_EQUIPMENT_ID"]; 
                        $reqNamaKelompok=$value["NAMA_KELOMPOK"]; 
                        $reqNamaFormUji= $value["NAMA"]; 
                    ?>
                    <div class="container">
                            <div class="page-header headernew" id="<?=$reqKelompokEquipmentId?>_<?=$reqFormUjiId?>" style="background: #ff0655">
                                <h3><i class="fa fa-id-badge fa-lg"></i> <?=$reqNamaKelompok?></h3>

                            </div>
                            <br>
                            <?
                            if(!empty($reqKelompokEquipmentId))
                            {
                                ?>
                                <a href="javascript:void(0)" class="btn btn-success" onclick="cetak_excel('<?=$reqKelompokEquipmentId?>')">Cetak</a>
                                <?
                            }
                            ?>      
                        <div class="content" id="tabel_<?=$reqKelompokEquipmentId?>_<?=$reqFormUjiId?>">

                            <div class="page-header" style="text-align: center;background-color: #0bb15e;">
                                <h3> <?=$reqNamaFormUji?></h3>       
                            </div>
                            <?
                            $setlist= new PlanRlaFormUjiDinamis();

                            $statement = " AND B.PLAN_RLA_ID = '".$reqIdRla."' AND A.FORM_UJI_ID = '".$reqFormUjiId."' AND F.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' ";
                            $setlist->selectByParamsReport(array(), -1, -1, $statement);
                            // echo $setlist->query;
                       
                            while ($setlist->nextRow())
                            {

                                $reqTabelId= $setlist->getField("TABEL_TEMPLATE_ID");
                                $reqTabelNama= $setlist->getField("TABEL_NAMA");
                                $reqPengukuranId= $setlist->getField("PENGUKURAN_ID");

                                $setmax= new TabelTemplate();
                                $statement = " AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' ";
                                $setmax->selectByParamsMaxBaris(array(), -1, -1, $statement);
                                // echo $set->query;exit; 
                                $setmax->firstRow();
                                $maxbaris= $setmax->getField("MAX");

                            ?>

                        <div class="content_check_<?=$reqKelompokEquipmentId?>_<?=$reqFormUjiId?>" id="tabel_<?=$reqKelompokEquipmentId?>_<?=$reqFormUjiId?>_<?=$reqTabelId?>">
                            <div class="page-header">
                                <h3><i class="fa fa-file-text fa-lg"></i> <?=$reqTabelNama?></h3>       
                            </div>

                            <br>

                            <a href="javascript:void(0)" class="btn btn-primary" onclick="EditTabel('<?=$reqTabelId?>','<?=$reqPengukuranId?>','<?=$reqFormUjiId?>','<?=$reqKelompokEquipmentId?>')">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-danger" onclick="delete_data('<?=$reqTabelId?>','<?=$reqPengukuranId?>','<?=$reqFormUjiId?>','<?=$reqKelompokEquipmentId?>')">Hapus Tabel</a>

                      
                            <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                                <thead>
                                    <?
                                    if(!empty($maxbaris))
                                    {
                                      for ($baris=1; $baris < $maxbaris + 1; $baris++) 
                                      {
                                        ?>
                                            <tr>
                                                <?
                                                $setheader= new TabelTemplate();

                                                $statement = "  AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' AND B.BARIS = '".$baris."'";
                                                $setheader->selectByParamsDetil(array(), -1, -1, $statement);
                                                // echo  $setheader->query;exit;
                                                while($setheader->nextRow())
                                                {
                                                  $reqDetilId= $setheader->getField("TABEL_DETIL_ID");
                                                  $reqBaris= $setheader->getField("BARIS");
                                                  $reqKolom= $setheader->getField("NAMA_TEMPLATE");
                                                  $reqRowspan= $setheader->getField("ROWSPAN");
                                                  $reqColspan= $setheader->getField("COLSPAN");

                                                  ?>
                                                  <th rowspan="<?=$reqRowspan?>" colspan="<?=$reqColspan?>" style="vertical-align : middle;text-align:center;"><?=$reqKolom?></th>
                                                  <?
                                              }
                                              ?>
                                          </tr>
                                          <?
                                      }
                                  }
                                  ?>
                                </thead>
                                <tbody>
                                    <?
                                    $isimaster= new FormUji();
                                    $statement = " AND A.PENGUKURAN_ID =".$reqPengukuranId." AND STATUS_TABLE = 'TABLE' AND A.FORM_UJI_ID = ".$reqFormUjiId."   AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."'  ";
                                    $isimaster->selectByParamsDetilDinamis(array(), -1, -1, $statement);
                                    // echo $isimaster->query; 

                                
                                    while($isimaster->nextRow())
                                    {
                                        $reqNamaMaster= $isimaster->getField("NAMA");
                                        $reqIdDetil= $isimaster->getField("FORM_UJI_DETIL_DINAMIS_ID");
                                        ?>
                                    
                                        <tr>
                                            <?
                                            $setisi= new PlanRlaFormUjiDinamis();

                                            $statement = " AND A.PLAN_RLA_ID = '".$reqIdRla."' AND A.FORM_UJI_ID = '".$reqFormUjiId."' AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' AND A.FORM_UJI_DETIL_DINAMIS_ID = '".$reqIdDetil."' AND A.PENGUKURAN_ID =".$reqPengukuranId." ";
                                            $setisi->selectByParamsDetil(array(), -1, -1, $statement);
                                            // echo $setisi->query;
                                            $i=1;
                                            while ($setisi->nextRow())
                                            {
                                                $reqIsi= $setisi->getField("NAMA");
                                                $reqIdDetilRla= $setisi->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID");
                                                // var_dump($reqIdDetilRla);
                                               ?>
                                                    <?
                                                    if($i==1)
                                                    {
                                                    ?>
                                                        <td ><?=$reqIsi?></td>
                                                    <?
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                      <td id="edit-<?=$reqTabelId?>-<?=$reqPengukuranId?>-<?=$reqFormUjiId?>-<?=$reqKelompokEquipmentId?>" ><input id="reqIsi-<?=$reqTabelId?>-<?=$reqPengukuranId?>" class='easyui-validatebox textbox form-control isitext-<?=$reqTabelId?>-<?=$reqPengukuranId?>-<?=$reqFormUjiId?>-<?=$reqKelompokEquipmentId?>'  type="hidden" name="reqIsi[]" value="<?=$reqIsi?>"> <span><?=$reqIsi?></span></td>
                                                      <input id="reqIdDetilRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdDetilRla[]" value="<?=$reqIdDetilRla?>">
                                                      <input id="reqIdRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdRla[]" value="<?=$reqIdRla?>">
                                                      <input id="reqFormUjiId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqFormUjiId[]" value="<?=$reqFormUjiId?>">
                                                      <input id="reqKelompokEquipmentId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqKelompokEquipmentId[]" value="<?=$reqKelompokEquipmentId?>">
                                                     
                                                     

                                                    <?
                                                    }
                                                    ?>

                                                <?
                                                $i++;
                                            }
                                            ?>
                                        </tr>
                                        <?
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        </div>
                            <?
                            }
                         ?>
                     </div>
                    
                <?
                    $adadata++;
                    }
                }
                else
                {   
                ?>
                    <div class="page-header" style="text-align: center;background-color: #fe1414;">
                        <h3> Data Form Uji belum di upload</h3>       
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
                        <div id="reqSimpan">
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
    $("#reqSimpan").hide();

    $(function() {
        $(document).on('change', 'input[name="reqYa"]', function() {
            $.ajax({
                type: 'POST',
                url: 'json-app/plan_rla_json/simpan_catatan',
                data:'reqIdRla=<?=$reqIdRla?>&reqYa='+$(this).val(),
                beforeSend: function () {
                },
                success: function (data) {
                   //  console.log(data);return false;
                   // location.reload();
                }
            });
        });
    });
    function EditTabel(tabelid,pengukuranid,reqFormUjiId,reqKelompokEquipmentId)
    {
        $("#edit-"+tabelid+"-"+pengukuranid+"-"+reqFormUjiId+"-"+reqKelompokEquipmentId+" span").html("");
        $(".isitext-"+tabelid+"-"+pengukuranid+"-"+reqFormUjiId+"-"+reqKelompokEquipmentId).prop("type",  'text');
        $("#reqSimpan").show();
    }
    function cetak_excel(id)
    {
        urlExcel = 'json-app/form_uji_cetak_dinamis_json/cetak_dinamis?reqId=<?=$reqIdRla?>&reqKelompokEquipmentId='+id;
        newWindow = window.open(urlExcel, 'Cetak');
        newWindow.focus();

    }
    function delete_data(tabelid,pengukuranid,reqFormUjiId,reqKelompokEquipmentId) {
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/plan_rla_json/delete_report/?reqId=<?=$reqIdRla?>&reqTabelId="+tabelid+"&reqPengukuranId="+pengukuranid+"&reqFormUjiId="+reqFormUjiId+"&reqKelompokEquipmentId="+reqKelompokEquipmentId,
                function(data){
                    // console.log(data);return false;

                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload();

                });
        }
    }); 
}

$(".headernew").click(function () {
    var bidValue = this.id;
    $( "#tabel_"+bidValue ).slideToggle(300); //animate and show/hide it
    $(".content_check_"+bidValue).each(function(){
        $( "#"+$(this).attr('id') ).slideToggle(300); 
    });
});


</script>