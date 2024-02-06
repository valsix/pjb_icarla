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
$set->selectByParamsFormUjiReportNew(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
    $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
    $arrdata["ID"]= $set->getField("ID");
    $arrdata["KELOMPOK_EQUIPMENT_PARENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_PARENT_ID");
    $arrdata["PARENT_ID"]= $set->getField("PARENT_ID");
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
$reqFinish= $set->getField("STATUS_FINISH");

unset($set);

$adadata=0;

$kode= $appuserkodehak;
$set= new Crud();
$statement=" AND (A.PENGGUNA_HAK_ID = 1 OR A.PENGGUNA_HAK_ID = 8 )   AND KODE_MODUL ='0501' AND A.KODE_HAK =  '".$kode."'  ";
$set->selectByParamsCrudHak(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqMenuUmro= $set->getField("MENU");
unset($set);


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


$set= new Crud();
$statement=" AND (A.PENGGUNA_HAK_ID = 1 OR A.PENGGUNA_HAK_ID = 9)   AND KODE_MODUL ='0501' AND A.KODE_HAK =  '".$kode."'  ";
$set->selectByParamsCrudHak(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqTimMenuUmro= $set->getField("MENU");

unset($set);


// print_r($arrkelompokequipment);

// var_dump($reqIya);exit;
?>
<script language="javascript" type="text/javascript" src="assets/editors/ckeditor/ckeditor.js"></script>
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

function hapusdata(id)
{
    mbox.custom({
        message: 'Anda Yakin Hapus File?',
        options: {},
        buttons: [
            {
                label: 'Ya',
                color: 'orange darken-2',
                callback: function() {

                    var url= 'json-app/plan_rla_json/hapusdata?reqId='+id;
                    $.ajax({
                        type: 'GET',
                        url: url,
                        // data: {kode:kode,ref_id:ref_id,tabel:tabel,id:id,status:status,reqwaktu:reqwaktu},
                        success: function(data)
                        {
                            mbox.custom({
                                message: data,
                                options: {}, // see Options below for options and defaults
                                buttons: [
                                {
                                    label: 'OK',
                                    color: 'orange darken-2',
                                    callback: function() {
                                        location.reload();
                                    }
                                }
                            ]
                            });
                        }
                    });
                    mbox.close();
                }
            },
            {
                label: 'Tidak',
                color: 'red darken-2',
                callback: function() {
                    mbox.close();
                }
            }
        ]
      })
}
</script>

<style>
    thead.stick-datatable th:nth-child(1){  width:440px !important; *border:1px solid cyan;}
    thead.stick-datatable ~ tbody td:nth-child(1){  width:440px !important; *border:1px solid yellow;}
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
                        <li class="nav-item ">
                            <a class="nav-link " href="app/index/summary_rekomendasi?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Summary dan Rekomendasi</a>
                        </li>
                        <?
                    }
                    ?>

                    <li class="nav-item active">
                        <a class="nav-link active" href="app/index/report_form_uji_plan_rla_dinamis?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Report</a>
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
                $idcheck=[];
                $idcheckpengukuran=[];
                if(!empty($arrkelompokequipment))
                {
                ?>
                    <?
                    foreach ($arrkelompokequipment as $key => $value) 
                    {

                        $reqKelompokEquipmentId=$value["KELOMPOK_EQUIPMENT_ID"];
                        $reqKelompokEquipmentParentId=$value["KELOMPOK_EQUIPMENT_PARENT_ID"];
                        $reqKelId=$value["ID"];  
                        $reqNamaKelompok=$value["NAMA"]; 
                        $idcheck[]= $reqKelompokEquipmentId;

                        $hitung=strlen($reqKelId);
                        $reqIdParent= $value["PARENT_ID"];
                        $hitungparent=strlen($reqIdParent);
                        $reqKelompokEquipment= $value["NAMA_KELOMPOK"];
                        if($reqIdParent==0)
                        {
                            $reqIdParent= $value["ID"];
                        }


                        $check="";
                        if($hitung > 3)
                        {
                            $check="1";
                        }
                        // $margin=""; 
                        // if($hitung > 3)
                        // {
                        //     $margin="margin-left: 50px";
                        //     $check="1";
                        // }


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

                        $set= new PlanRla();
                        $arrformuji= [];
                        $statement = " AND D.PLAN_RLA_ID = '".$reqIdRla."'  AND E.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' ";
                        $set->selectByParamsFormUjiReportNew(array(), -1,-1,$statement);
                        // echo $set->query;exit;
                        while($set->nextRow())
                        {
                            $arrdata= array();
                            $arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
                            $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
                            $arrdata["NAMA"]= $set->getField("NAMA");
                            $arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
                            $arrdata["ID"]= $set->getField("ID");
                            $arrdata["KELOMPOK_EQUIPMENT_PARENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_PARENT_ID");
                            $arrdata["PARENT_ID"]= $set->getField("PARENT_ID");
                            array_push($arrformuji, $arrdata);
                        }
                        unset($set);

                    ?>
                        <div>
                            
                            <?
                            if($reqIdParent==0)
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
                            <br> 
                          
                            <div style="<?=$margin?>" class="class_header_parent_<?=$result?>">

                                <a href="javascript:void(0)" class="btn btn-success class_cetak_<?=$reqKelompokEquipmentId?>" onclick="cetak_excel('<?=$reqKelompokEquipmentId?>','<?=$reqKelompokEquipmentParentId?>','<?=$check?>','<?=$reqIdParent?>')">Cetak Excel</a>
                                <a href="javascript:void(0)" class="btn btn-danger class_pdf_<?=$reqKelompokEquipmentId?>" onclick="cetak_pdf('<?=$reqKelompokEquipmentId?>','<?=$reqKelompokEquipmentParentId?>','<?=$check?>','<?=$reqIdParent?>')">Cetak Pdf</a>
                                <a href="javascript:void(0)" class="btn btn-primary class_preview_<?=$reqKelompokEquipmentId?>" onclick="cetak_preview('<?=$reqKelompokEquipmentId?>','<?=$reqKelompokEquipmentParentId?>','<?=$check?>','<?=$reqIdParent?>')">Preview Cetak</a>

                            </div>

                            <?
                            foreach ($arrformuji as $key => $value) 
                            {
                                $reqFormUjiId=$value["FORM_UJI_ID"]; 
                                $reqKelompokEquipmentId=$value["KELOMPOK_EQUIPMENT_ID"];
                                $reqKelompokEquipmentParentId=$value["KELOMPOK_EQUIPMENT_PARENT_ID"];
                                $reqKelId=$value["ID"];  
                                $reqNamaKelompok=$value["NAMA_KELOMPOK"]; 
                                $reqNamaFormUji= $value["NAMA"];

                            ?>
                            <!-- <div class="content  class_form" id="tabel_<?=$reqKelompokEquipmentId?>" style="<?=$margin?>"> -->
                            <div style="<?=$margin?>" class="content class_form_<?=$reqKelompokEquipmentId?> class_form_parent_<?=$result?>" >

                                <div class="page-header class_form_<?=$reqKelompokEquipmentId?>" style="text-align: center;background-color: #0bb15e;">
                                    <h3> <?=$reqNamaFormUji?></h3>       
                                </div>
                                <?
                                $setlist= new PlanRlaFormUjiDinamis();

                                $statement = " AND B.PLAN_RLA_ID = '".$reqIdRla."' AND A.FORM_UJI_ID = '".$reqFormUjiId."' AND F.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' ";
                                $setlist->selectByParamsReportAllStatus(array(), -1, -1, $statement);
                                // echo $setlist->query;
                           
                                while ($setlist->nextRow())
                                {
                                    $reqTabelId= $setlist->getField("TABEL_TEMPLATE_ID");
                                    $reqTabelNama= $setlist->getField("TABEL_NAMA");
                                    $reqPengukuranId= $setlist->getField("PENGUKURAN_ID");
                                    $reqPengukuranNama= $setlist->getField("PENGUKURAN_NAMA");
                                    $idcheckpengukuran[]= $reqKelompokEquipmentId."_".$reqPengukuranId;

                                    $set= new FormUji();
                                    $arrpengukuran= [];

                                    $statement = " AND A.PENGUKURAN_ID = ".$reqPengukuranId." ";
                                    $set->selectByParamsPengukuran(array(), -1, -1, $statement);
                                     // echo $set->query;
                                    while($set->nextRow())
                                    {
                                        $arrdata= array();
                                        $arrdata["TABEL_TEMPLATE_ID"]= $set->getField("TABEL_TEMPLATE_ID");
                                        $arrdata["PENGUKURAN_TIPE_INPUT_ID"]= $set->getField("PENGUKURAN_TIPE_INPUT_ID");
                                        $arrdata["TABEL_NAMA"]= $set->getField("TABEL_NAMA");
                                        $arrdata["STATUS_TABLE"]= $set->getField("STATUS_TABLE");
                                        $arrdata["MASTER_TABEL_ID"]= $set->getField("MASTER_TABEL_ID");
                                        $arrdata["PENGUKURAN_ID"]= $set->getField("PENGUKURAN_ID");
                                        $arrdata["TIPE_INPUT_ID"]= $set->getField("TIPE_INPUT_ID");
                                        $arrdata["VALUE"]= $set->getField("VALUE");
                                        $arrdata["SEQ"]= $set->getField("SEQ");
                                        array_push($arrpengukuran, $arrdata);
                                    }
                                    // print_r($arrpengukuran);
                                ?>

                                    <div class="content_check_<?=$reqKelompokEquipmentId?>" id="tabel_<?=$reqKelompokEquipmentId?>_<?=$reqFormUjiId?>_<?=$reqPengukuranId?>">

                                        <div class="page-header pengukuran_head_<?=$reqKelompokEquipmentId?>_<?=$reqPengukuranId?>" style="background: #adb000">
                                            <h3><i class="fa fa-file-text fa-lg"></i> <?=$reqPengukuranNama?></h3>       
                                        </div>

                                        <?

                                        $multi="";
                                        foreach ($arrpengukuran as $key => $value) 
                                        {
                                           $tabelnama= $value["TABEL_NAMA"];
                                           $statustabel= $value["STATUS_TABLE"];
                                           $tabelid= $value["MASTER_TABEL_ID"];
                                           $pengukuranid= $value["PENGUKURAN_ID"];
                                           $pengukurantipeid= $value["PENGUKURAN_TIPE_INPUT_ID"];
                                           $tipeinputid= $value["TIPE_INPUT_ID"];
                                           $valuenama= $value["VALUE"];  
                                           $seq= $value["SEQ"]; 
                                           // var_dump($seq);

                                           $searchForValue = '.';
                                           if( strpos($seq, $searchForValue) !== false ) {
                                               $multi="multiple";
                                               // echo 'found';
                                           }           

                                         ?>

                                        <?
                                        if($statustabel== 'TABLE')
                                        { 
                                            $setmax= new TabelTemplate();
                                            $statement = " AND A.TABEL_TEMPLATE_ID = '".$tabelid."' ";
                                            $setmax->selectByParamsMaxBaris(array(), -1, -1, $statement);
                                             // echo $setmax->query;exit; 
                                            $setmax->firstRow();
                                            $maxbaris= $setmax->getField("MAX");
                                         ?>   
                                            <div class="page-header">
                                            <h3><i class="fa fa-file-text fa-lg"></i>Tabel <?=$tabelnama?></h3>       
                                            </div>

                                            <br>
                                            <?
                                            if(empty($reqFinish))
                                            {
                                            ?>
                                            <a href="javascript:void(0)" class="btn btn-primary" onclick="EditTabel('<?=$tabelid?>','<?=$reqPengukuranId?>','<?=$reqFormUjiId?>','<?=$reqKelompokEquipmentId?>','<?=$pengukurantipeid?>')">Edit</a>
                                            <a href="javascript:void(0)" class="btn btn-danger" onclick="delete_data('<?=$tabelid?>','<?=$reqPengukuranId?>','<?=$reqFormUjiId?>','<?=$reqKelompokEquipmentId?>','<?=$pengukurantipeid?>')">Hapus Tabel</a>
                                            <?
                                            }
                                            ?>

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

                                                                $statement = "  AND A.TABEL_TEMPLATE_ID = '".$tabelid."' AND B.BARIS = '".$baris."'";
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
                                                    $reqIdDetilRla="";
                                                    $isimaster= new FormUji();
                                                    $statement = " AND A.PENGUKURAN_ID =".$reqPengukuranId." AND STATUS_TABLE = 'TABLE' AND A.FORM_UJI_ID = ".$reqFormUjiId."   AND A.TABEL_TEMPLATE_ID = '".$tabelid."' AND A.PENGUKURAN_TIPE_INPUT_ID='".$pengukurantipeid."'  ";
                                                    $isimaster->selectByParamsDetilDinamis(array(), -1, -1, $statement);
                                                    // echo $isimaster->query; 
                                                    while($isimaster->nextRow())
                                                    {
                                                        $reqNamaMaster= $isimaster->getField("NAMA");
                                                        $reqIdDetil= $isimaster->getField("FORM_UJI_DETIL_DINAMIS_ID");
                                                        $reqPengukuranTipeInputId= $isimaster->getField("PENGUKURAN_TIPE_INPUT_ID");
                                                    ?>
                                                        <tr>
                                                    <?
                                                            $setisi= new PlanRlaFormUjiDinamis();
                                                            $statement = " AND A.PLAN_RLA_ID = '".$reqIdRla."' AND A.FORM_UJI_ID = '".$reqFormUjiId."' AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' AND A.TABEL_TEMPLATE_ID = '".$tabelid."' AND A.FORM_UJI_DETIL_DINAMIS_ID = '".$reqIdDetil."' AND A.PENGUKURAN_ID =".$reqPengukuranId." AND A.PENGUKURAN_TIPE_INPUT_ID =".$reqPengukuranTipeInputId." ";
                                                            $setisi->selectByParamsDetil(array(), -1, -1, $statement);
                                                            // echo $setisi->query;
                                                            $i=1;
                                                            while ($setisi->nextRow())
                                                            {
                                                                $reqNamaKolom= $setisi->getField("NAMA");
                                                                $reqIdDetilRla= $setisi->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID");
                                                                $reqFormDetilId= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID"); 
                                                                $reqBaris= $setisi->getField("BARIS");
                                                                // var_dump($reqIdDetilRla);
                                                                ?>
                                                                <?
                                                                    if($i==1)
                                                                    {
                                                                ?>
                                                                        <td ><?=$reqNamaKolom?></td>
                                                                <?
                                                                    }
                                                                    else
                                                                    {
                                                                ?>
                                                                    <td id="edit-<?=$tabelid?>-<?=$reqPengukuranId?>-<?=$reqFormUjiId?>-<?=$reqKelompokEquipmentId?>-<?=$pengukurantipeid?>" ><input id="reqNamaKolom-<?=$tabelid?>-<?=$reqPengukuranId?>-<?=$pengukurantipeid?>" class='easyui-validatebox textbox form-control isitext-<?=$tabelid?>-<?=$reqPengukuranId?>-<?=$reqFormUjiId?>-<?=$reqKelompokEquipmentId?>-<?=$pengukurantipeid?>'  type="hidden" name="reqNamaKolom[]" value="<?=$reqNamaKolom?>"> <span><?=$reqNamaKolom?></span></td>

                                                                    <input id="reqIdDetilRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdDetilRla[]" value="<?=$reqIdDetilRla?>">

                                                                    <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='TABLE' data-options='' style='width:100%'>

                                                                    <input type='hidden' name='reqFormDetilId[]' class="iddetil"  id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                                                                    <input id="reqIdRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdRla[]" value="<?=$reqIdRla?>">
                                                                    <input id="reqFormUjiId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqFormUjiId[]" value="<?=$reqFormUjiId?>">
                                                                    <input id="reqKelompokEquipmentId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqKelompokEquipmentId[]" value="<?=$reqKelompokEquipmentId?>">
                                                                    <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='<?=$tabelid?>' >
                                                                    <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$reqPengukuranId?>' >
                                                                    <input type='hidden' name='reqPengukuranTipeInputId[]' id='reqPengukuranTipeInputId' value='<?=$pengukurantipeid?>' >
                                                                    <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                                                                    <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                                                                    <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >

                                                                    <input type='hidden' name='reqBaris[]' id='reqBaris' value='<?=$reqBaris?>' >
                                                                    <!-- <input type="file" style="display: none" name="reqLinkFile[]" <?=$disabled?> id="reqLinkFile" >  -->
                                                                <?
                                                                }
                                                                ?>

                                                                <?
                                                                $i++;
                                                            }
                                                            ?>
                                                            <?
                                                            if(empty($reqIdDetilRla))
                                                            {
                                                               $settabel= new TabelTemplate();
                                                               $statement = " AND A.TABEL_TEMPLATE_ID = '".$tabelid."' ";
                                                               $settabel->selectByParamsMonitoring(array(), -1, -1, $statement);
                                                                // echo $settabel->query;exit; 
                                                               $settabel->firstRow();
                                                               $total= $settabel->getField("TOTAL");

                                                            ?>

                                                                <?
                                                                for ($z=1; $z < $total + 1; $z++) 
                                                                { 
                                                                ?>
                                                                    <?
                                                                    if($z==1)
                                                                    {
                                                                        ?>
                                                                        <td ><?=$reqNamaMaster?>
                                                                            <input class='easyui-validatebox textbox form-control'  type="hidden" name="reqNamaKolom[]" value="<?=$reqNamaMaster?>">
                                                                        </td>
                                                                        <?
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <td id="edit-<?=$tabelid?>-<?=$reqPengukuranId?>-<?=$reqFormUjiId?>-<?=$reqKelompokEquipmentId?>-<?=$pengukurantipeid?>" ><input id="reqNamaKolom-<?=$tabelid?>-<?=$reqPengukuranId?>-<?=$pengukurantipeid?>" class='easyui-validatebox textbox form-control isitext-<?=$tabelid?>-<?=$reqPengukuranId?>-<?=$reqFormUjiId?>-<?=$reqKelompokEquipmentId?>-<?=$pengukurantipeid?>'  type="hidden" name="reqNamaKolom[]" value=""> <span></span>
                                                                        </td>

                                                                        <?
                                                                    }
                                                                    ?>

                                                                    <input id="reqIdDetilRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdDetilRla[]" value="">
                                                                    <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='TABLE' data-options='' style='width:100%'>

                                                                    <input type='hidden' name='reqFormDetilId[]' class="iddetil"  id='reqFormDetilId' value='<?=$reqIdDetil?>' >
                                                                    <input id="reqIdRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdRla[]" value="<?=$reqIdRla?>">
                                                                    <input id="reqFormUjiId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqFormUjiId[]" value="<?=$reqFormUjiId?>">
                                                                    <input id="reqKelompokEquipmentId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqKelompokEquipmentId[]" value="<?=$reqKelompokEquipmentId?>">
                                                                    <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='<?=$tabelid?>' >
                                                                    <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$reqPengukuranId?>' >
                                                                    <input type='hidden' name='reqPengukuranTipeInputId[]' id='reqPengukuranTipeInputId' value='<?=$pengukurantipeid?>' >
                                                                    <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                                                                    <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                                                                    <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >

                                                                    <input type='hidden' name='reqBaris[]' id='reqBaris' value='<?=$reqBaris?>' >

                                                                <?
                                                                }
                                                                ?>
                                                            <?
                                                            }
                                                            ?>
                                                        </tr>
                                                        <?
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>

                                         <?
                                        }
                                        else if ($statustabel== 'TEXT')
                                        {
                                        ?>
                                        <br>
                                        <div class="page-header">
                                            <h3><i class="fa fa-file-text fa-lg"></i> KETERANGAN </h3>       
                                        </div>
                                        <div class="form-group">  
                                            <label class="control-label col-md-2"><?=$valuenama?></label>
                                            <div class='col-md-8'>
                                                <div class='form-group'>
                                                    <div class='col-md-11'>
                                                        <?
                                                        $reqFormDetilId="";
                                                        $reqIdDetilRla="";
                                                        $reqNamaKolom="";
                                                        $setisi= new PlanRlaFormUjiDinamis();
                                                        $statement = "AND A.PENGUKURAN_ID =".$pengukuranid." AND A.STATUS_TABLE = 'TEXT' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." ";
                                                        $setisi->selectByParamsDetilNew(array(), -1, -1, $statement);
                                                        // echo $setisi->query;
                                                        while($setisi->nextRow())
                                                        {

                                                            $reqFormDetilId= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");

                                                            $setplan= new PlanRlaFormUjiDinamis();
                                                            $statement = " AND A.PLAN_RLA_ID = ".$reqIdRla." AND A.PENGUKURAN_ID =".$pengukuranid." AND A.STATUS_TABLE = 'TEXT' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' ";
                                                            $setplan->selectByParamsDetil(array(), -1, -1, $statement);
                                                            // echo $setplan->query;
                                                            $setplan->firstRow();
                                                            $reqNamaKolom= $setplan->getField("NAMA");
                                                            $reqIdDetilRla= $setplan->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID");

                                                            ?>
                                                            <textarea id="check-<?=$reqFormDetilId?>" <?=$disabled?> <?=$disabledfinish?>  name="reqNamaKolom[]" style="width:100%;"><?=$reqNamaKolom?></textarea>

                                         
                                                            <input id="reqIdDetilRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdDetilRla[]" value="<?=$reqIdDetilRla?>">

                                                            <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='TEXT' data-options='' style='width:100%'>
                                                            <input type='hidden' name='reqFormDetilId[]' class="iddetil"  id='reqFormDetilId' value='<?=$reqFormDetilId?>' >


                                                            <input id="reqIdRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdRla[]" value="<?=$reqIdRla?>">
                                                            <input id="reqFormUjiId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqFormUjiId[]" value="<?=$reqFormUjiId?>">
                                                            <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                                                            <input id="reqKelompokEquipmentId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqKelompokEquipmentId[]" value="<?=$reqKelompokEquipmentId?>">

                                                            <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                                                            <input type='hidden' name='reqPengukuranTipeInputId[]' id='reqPengukuranTipeInputId' value='<?=$pengukurantipeid?>' >
                                                            <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                                                              <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong" value="1">
                                                            <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
                                                            <input type='hidden' name='reqBaris[]' id='reqBaris' value='' >

                                                            <!-- <input type="file" style="display: none" name="reqLinkFile[]" <?=$disabled?> id="reqLinkFile" >  -->


                                                            <?
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?
                                        }
                                        else if ($statustabel== 'PIC')
                                        {
                                            $vmultipic= "";
                                            if( strpos($seq, ".") !== false )
                                            {
                                                $vmultipic= "multiple";
                                            }
                                        ?>
                                            <div class="page-header">
                                                <h3><i class="fa fa-file-text fa-lg"></i> GAMBAR</h3>       
                                            </div>
                                            <div class="form-group">  
                                                <label class="control-label col-md-2"><?=$valuenama?></label>
                                                <div class='col-md-8'>
                                                    <div class='form-group'>
                                                        <div class='col-md-11'>
                                                            <?
                                                            $reqFormDetilId="";
                                                            $reqIdDetilRla="";
                                                            $reqNamaKolom="";
                                                            $setisi= new PlanRlaFormUjiDinamis();
                                                            $statement = "AND A.PENGUKURAN_ID =".$pengukuranid." AND A.STATUS_TABLE = 'PIC' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." ";
                                                            $setisi->selectByParamsDetilNew(array(), -1, -1, $statement);
                                                            // echo $setisi->query;exit;
                                                            while($setisi->nextRow())
                                                            {
                                                                $reqFormDetilId= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");

                                                                $setplan= new PlanRlaFormUjiDinamis();
                                                                $statement = " AND A.PLAN_RLA_ID = ".$reqIdRla." AND A.PENGUKURAN_ID =".$pengukuranid." AND A.STATUS_TABLE = 'PIC' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' ";
                                                                $setplan->selectByParamsDetil(array(), -1, -1, $statement);
                                                                // echo $setplan->query;
                                                                // $setplan->firstRow();
                                                                while($setplan->nextRow())
                                                                {
                                                                    $reqNamaKolom= $setplan->getField("NAMA");
                                                                    $reqLinkFile= $setplan->getField("LINK_FILE");
                                                                    $reqIdDetilRla= $setplan->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID");

                                                                    $infokunci= $reqFormDetilId."-".$reqIdRla."-".$reqFormUjiId."-".$pengukuranid."-".$tipeinputid."-".$pengukurantipeid."-".$reqIdDetilRla;
                                                                    // echo $infokunci;

                                                                    $vmultipic= "";
                                                                    if( strpos($seq, ".") !== false )
                                                                    {
                                                                        $vmultipic= "multiple";
                                                                    }

                                                                    if(!empty($reqLinkFile) && !empty($vmultipic))
                                                                    {
                                                                        $vmultipic= "";
                                                                    }
                                                                    // echo $vmultipic."-".$infokunci."<br/>";
                                                                ?>

                                                                <?
                                                                if(empty($reqFinish))
                                                                {
                                                                    ?>
                                                                    <input type="file" name="reqLinkFile[<?=$infokunci?>][]" <?=$disabled?> id="reqLinkFile" accept=".jpg,.jpeg,.png,image/png" <?=$vmultipic?> />
                                                                <?
                                                                }
                                                                ?>

                                                                <?

                                                                    if(!empty($reqLinkFile))
                                                                    {
                                                                ?>
                                                                        <a href="<?=$reqLinkFile?>" target="_blank"> <img src="<?=$reqLinkFile?>" width="300px" height = "300px" ></a>

                                                                        <?
                                                                        if(empty($reqFinish))
                                                                        {
                                                                            ?>
                                                                        <a href="javascript:void(0)" class="btn btn-danger" onclick="hapusdata('<?=$reqIdDetilRla?>')">Hapus Gambar</a>
                                                                        <?
                                                                        }
                                                                        ?>
                                                                <?
                                                                    }
                                                                ?>
                                                                    <input type="hidden" name="infolinkfilemulti[<?=$infokunci?>]" value="<?=$vmultipic?>" />
                                                                    <input type="hidden" name="infolinkfile[<?=$infokunci?>]" value="<?=$reqLinkFile?>" />

                                                                    <input type="hidden" name="reqIdDetilRla[<?=$infokunci?>]" id="reqIdDetilRla" value="<?=$reqIdDetilRla?>" />
                                                                    <input type='hidden' name='reqStatusTabel[<?=$infokunci?>]' id='reqStatusTabel' value='PIC' />
                                                                    <input type='hidden' name='reqFormDetilId[<?=$infokunci?>]' id='reqFormDetilId' value='<?=$reqFormDetilId?>' />
                                                                    <input type="hidden" name="reqIdRla[<?=$infokunci?>]" id="reqIdRla" value="<?=$reqIdRla?>" />
                                                                    <input type="hidden" name="reqFormUjiId[<?=$infokunci?>]" id="reqFormUjiId" value="<?=$reqFormUjiId?>" />
                                                                    <input type='hidden' name='reqTabelId[<?=$infokunci?>]' id='reqTabelId' value='' />
                                                                    <input type="hidden" name="reqKelompokEquipmentId[<?=$infokunci?>]" id="reqKelompokEquipmentId" value="<?=$reqKelompokEquipmentId?>" />
                                                                    <input type='hidden' name='reqPengukuranId[<?=$infokunci?>]' id='reqPengukuranId' value='<?=$pengukuranid?>' />
                                                                    <input type='hidden' name='reqPengukuranTipeInputId[<?=$infokunci?>]' id='reqPengukuranTipeInputId' value='<?=$pengukurantipeid?>' />
                                                                    <input type='hidden' name='reqTipePengukuranId[<?=$infokunci?>]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' />
                                                                    <input type='hidden' name='reqTipeInputId[<?=$infokunci?>]' id='reqTipeInputId' value='<?=$tipeinputid?>' />
                                                                    <input type='hidden' name='reqBaris[<?=$infokunci?>]' id='reqBaris' value='' />
                                                                    <input type='hidden' name='reqNamaKolom[<?=$infokunci?>]' id='reqNamaKolom' value='<?=$reqNamaKolom?>' />
                                                            <?
                                                                }

                                                                // belum di cek
                                                                if(empty($reqIdDetilRla))
                                                                {
                                                                    $infokunci= $reqFormDetilId."-".$reqIdRla."-".$reqFormUjiId."-".$pengukuranid."-".$tipeinputid."-".$pengukurantipeid."-".$reqIdDetilRla;

                                                                    $vmultipic= "";
                                                                    if( strpos($seq, ".") !== false )
                                                                    {
                                                                        $vmultipic= "multiple";
                                                                    }
                                                            ?>
                                                                    <?
                                                                    if(empty($reqFinish))
                                                                    {
                                                                        ?>
                                                                    <input type="file" name="reqLinkFile[<?=$infokunci?>][]" <?=$disabled?> id="reqLinkFile" accept=".jpg,.jpeg,.png,image/png" <?=$vmultipic?> />
                                                                    <?
                                                                    }
                                                                    ?>

                                                                    <input type="hidden" name="infolinkfilemulti[<?=$infokunci?>]" value="<?=$vmultipic?>" />
                                                                    <input type="hidden" name="infolinkfile[<?=$infokunci?>]" value="<?=$reqLinkFile?>" />

                                                                    <input type="hidden" name="reqIdDetilRla[<?=$infokunci?>]" id="reqIdDetilRla" value="<?=$reqIdDetilRla?>" />
                                                                    <input type='hidden' name='reqStatusTabel[<?=$infokunci?>]' id='reqStatusTabel' value='PIC' />
                                                                    <input type='hidden' name='reqFormDetilId[<?=$infokunci?>]' id='reqFormDetilId' value='<?=$reqFormDetilId?>' />
                                                                    <input type="hidden" name="reqIdRla[<?=$infokunci?>]" id="reqIdRla" value="<?=$reqIdRla?>" />
                                                                    <input type="hidden" name="reqFormUjiId[<?=$infokunci?>]" id="reqFormUjiId" value="<?=$reqFormUjiId?>" />
                                                                    <input type='hidden' name='reqTabelId[<?=$infokunci?>]' id='reqTabelId' value='' />
                                                                    <input type="hidden" name="reqKelompokEquipmentId[<?=$infokunci?>]" id="reqKelompokEquipmentId" value="<?=$reqKelompokEquipmentId?>" />
                                                                    <input type='hidden' name='reqPengukuranId[<?=$infokunci?>]' id='reqPengukuranId' value='<?=$pengukuranid?>' />
                                                                    <input type='hidden' name='reqPengukuranTipeInputId[<?=$infokunci?>]' id='reqPengukuranTipeInputId' value='<?=$pengukurantipeid?>' />
                                                                    <input type='hidden' name='reqTipePengukuranId[<?=$infokunci?>]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' />
                                                                    <input type='hidden' name='reqTipeInputId[<?=$infokunci?>]' id='reqTipeInputId' value='<?=$tipeinputid?>' />
                                                                    <input type='hidden' name='reqBaris[<?=$infokunci?>]' id='reqBaris' value='' />
                                                                    <input type='hidden' name='reqNamaKolom[<?=$infokunci?>]' id='reqNamaKolom' value='<?=$reqNamaKolom?>' />
                                                                <?
                                                                }
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                        <?
                                        }
                                        else if ($statustabel== 'ANALOG')
                                        {
                                        ?>

                                            <br>
                                            <div class="page-header">
                                                <h3><i class="fa fa-file-text fa-lg"></i> ANALOG </h3>       
                                            </div>
                                            <div class="form-group">  
                                                <label class="control-label col-md-2"><?=$valuenama?></label>
                                                <div class='col-md-8'>
                                                    <div class='form-group'>
                                                        <div class='col-md-11'>

                                                            <?
                                                            $reqFormDetilId="";
                                                            $reqIdDetilRla="";
                                                            $reqNamaKolom="";
                                                            $setisi= new PlanRlaFormUjiDinamis();
                                                            $statement = "AND A.PENGUKURAN_ID =".$pengukuranid." AND A.STATUS_TABLE = 'ANALOG' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid."  ";
                                                            $setisi->selectByParamsDetilNew(array(), -1, -1, $statement);
                                                            // echo  $setisi->query;
                                                            while($setisi->nextRow())
                                                            {

                                                                $reqFormDetilId= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");

                                                                $setplan= new PlanRlaFormUjiDinamis();
                                                                $statement = " AND A.PLAN_RLA_ID = ".$reqIdRla." AND A.PENGUKURAN_ID =".$pengukuranid." AND A.STATUS_TABLE = 'ANALOG' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." ";
                                                                $setplan->selectByParamsDetil(array(), -1, -1, $statement);
                                                                // echo $setplan->query;
                                                                $setplan->firstRow();
                                                                $reqNamaKolom= $setplan->getField("NAMA");
                                                                $reqIdDetilRla= $setplan->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID");

                                                                ?>

                                                                <input class='easyui-validatebox textbox form-control' <?=$disabled?> <?=$disabledfinish?> type='text' name='reqNamaKolom[]' id='reqNamaKolom' value='<?=$reqNamaKolom?>' data-options='' style='width:100%' maxlength="25">

                                                                <input id="reqIdDetilRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdDetilRla[]" value="<?=$reqIdDetilRla?>">

                                                                <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='ANALOG' data-options='' style='width:100%'>
                                                                <input type='hidden' name='reqFormDetilId[]' class="iddetil"  id='reqFormDetilId' value='<?=$reqFormDetilId?>' >


                                                                <input id="reqIdRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdRla[]" value="<?=$reqIdRla?>">
                                                                <input id="reqFormUjiId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqFormUjiId[]" value="<?=$reqFormUjiId?>">
                                                                <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                                                                <input id="reqKelompokEquipmentId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqKelompokEquipmentId[]" value="<?=$reqKelompokEquipmentId?>">

                                                                <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                                                                <input type='hidden' name='reqPengukuranTipeInputId[]' id='reqPengukuranTipeInputId' value='<?=$pengukurantipeid?>' >
                                                                <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                                                                <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                                                                <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
                                                                <input type='hidden' name='reqBaris[]' id='reqBaris' value='' >

                                                                <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong" value="">

                                                                <!-- <input type="file" style="display: none" name="reqLinkFile[]" <?=$disabled?> id="reqLinkFile" >  -->

                                   
                                                            <?
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        <?
                                        }
                                        else if ($statustabel== 'BINARY')
                                        {
                                        ?>
                                            <br>
                                            <div class="page-header">
                                                <h3><i class="fa fa-file-text fa-lg"></i> BINARY </h3>       
                                            </div>
                                            <div class="form-group">  
                                                <label class="control-label col-md-2"><?=$valuenama?></label>
                                                <div class='col-md-8'>
                                                    <div class='form-group'>
                                                        <div class='col-md-11'>

                                                            <?
                                                            $reqFormDetilId="";
                                                            $reqIdDetilRla="";
                                                            $reqNamaKolom="";
                                                            $setisi= new PlanRlaFormUjiDinamis();
                                                            $statement = "AND A.PENGUKURAN_ID =".$pengukuranid." AND A.STATUS_TABLE = 'BINARY' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." ";
                                                            $setisi->selectByParamsDetilNew(array(), -1, -1, $statement);
                                                            // echo $setisi->query;
                                                            while($setisi->nextRow())
                                                            {

                                                                $reqFormDetilId= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");

                                                                $setplan= new PlanRlaFormUjiDinamis();
                                                                $statement = " AND A.PLAN_RLA_ID = ".$reqIdRla." AND A.PENGUKURAN_ID =".$pengukuranid." AND A.STATUS_TABLE = 'BINARY' AND A.FORM_UJI_ID = ".$reqFormUjiId." AND A.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." ";
                                                                $setplan->selectByParamsDetil(array(), -1, -1, $statement);
                                                                // echo $setplan->query;
                                                                $setplan->firstRow();
                                                                $reqNamaKolom= $setplan->getField("NAMA");
                                                                $reqIdDetilRla= $setplan->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID");

                                                              ?>

                                                              <input class='easyui-validatebox textbox form-control' <?=$disabled?> <?=$disabledfinish?> type='text' name='reqNamaKolom[]' id='reqNamaKolom' value='<?=$reqNamaKolom?>' data-options='' style='width:100%' maxlength="25">

                                                              <input id="reqIdDetilRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdDetilRla[]" value="<?=$reqIdDetilRla?>">

                                                              <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='BINARY' data-options='' style='width:100%'>
                                                              <input type='hidden' name='reqFormDetilId[]' class="iddetil"  id='reqFormDetilId' value='<?=$reqFormDetilId?>' >


                                                              <input id="reqIdRla" class='easyui-validatebox textbox form-control'  type="hidden" name="reqIdRla[]" value="<?=$reqIdRla?>">
                                                              <input id="reqFormUjiId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqFormUjiId[]" value="<?=$reqFormUjiId?>">
                                                              <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                                                              <input id="reqKelompokEquipmentId" class='easyui-validatebox textbox form-control'  type="hidden" name="reqKelompokEquipmentId[]" value="<?=$reqKelompokEquipmentId?>">

                                                              <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                                                              <input type='hidden' name='reqPengukuranTipeInputId[]' id='reqPengukuranTipeInputId' value='<?=$pengukurantipeid?>' >
                                                              <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                                                              <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                                                              <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
                                                              <input type='hidden' name='reqBaris[]' id='reqBaris' value='' >


                                                              <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong" value="">

                                                              <!-- <input type="file" style="display: none" name="reqLinkFile[]" <?=$disabled?> id="reqLinkFile" >  -->

                                                              <?
                                                          }
                                                          ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        <?
                                        }
                                        ?>
                                    <?
                                    }
                                    ?>
                                <?
                                }
                                ?>
                            </div>
                            <?
                            }
                            ?>
                        </div>
                    <?
                    }
                    ?>
 
                <?
                }
                else
                {   
                ?>
                    <div class="page-header" style="text-align: center;background-color: #fe1414;">
                        <h3> Data Form Uji belum di isi</h3>       
                    </div>
                <?
                }
                ?>


                <?
                if($reqLihat ==1 || !empty($reqFinish))
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
                }
            });
        });
    });
    function EditTabel(tabelid,pengukuranid,reqFormUjiId,reqKelompokEquipmentId,reqPengukuranTipeInputId)
    {
        $("#edit-"+tabelid+"-"+pengukuranid+"-"+reqFormUjiId+"-"+reqKelompokEquipmentId+"-"+reqPengukuranTipeInputId+" span").html("");
        $(".isitext-"+tabelid+"-"+pengukuranid+"-"+reqFormUjiId+"-"+reqKelompokEquipmentId+"-"+reqPengukuranTipeInputId).prop("type",  'text');
        $("#reqSimpan").show();
    }
    function cetak_excel(id,parentid,check,idparent)
    {
        urlExcel = 'json-app/form_uji_cetak_dinamis_json/cetak_dinamis?reqId=<?=$reqIdRla?>&reqKelompokEquipmentId='+id+'&reqKelompokEquipmentParentId='+parentid+'&reqCheck='+check+'&reqIdParent='+idparent;
        newWindow = window.open(urlExcel, '_blank');
        newWindow.focus();

    }
    function cetak_preview(id,parentid,check,idparent)
    {
        urlExcel = 'app/index/preview_report_plan_rla?reqId=<?=$reqIdRla?>&reqKelompokEquipmentId='+id+'&reqKelompokEquipmentParentId='+parentid+'&reqCheck='+check+'&reqIdParent='+idparent;
        newWindow = window.open(urlExcel, '_blank');
        newWindow.focus();
    }
    function cetak_pdf(id,parentid,check,idparent)
    {
        // urlExcel = 'app/index/cetak_pdf_plan_rla?reqId=<?=$reqIdRla?>&reqKelompokEquipmentId='+id+'&reqKelompokEquipmentParentId='+parentid+'&reqCheck='+check+'&reqIdParent='+idparent;
        urlExcel = 'report/loadUrl/report/templatewk?reqId=<?=$reqIdRla?>&reqKelompokEquipmentId='+id+'&reqKelompokEquipmentParentId='+parentid+'&reqCheck='+check+'&reqIdParent='+idparent;
        newWindow = window.open(urlExcel, '_blank');
        newWindow.focus();
    }
    function delete_data(tabelid,pengukuranid,reqFormUjiId,reqKelompokEquipmentId,reqPengukuranTipeInputId) {
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r)
        {
            $.getJSON("json-app/plan_rla_json/delete_report/?reqId=<?=$reqIdRla?>&reqTabelId="+tabelid+"&reqPengukuranId="+pengukuranid+"&reqFormUjiId="+reqFormUjiId+"&reqKelompokEquipmentId="+reqKelompokEquipmentId+"&reqPengukuranTipeInputId="+reqPengukuranTipeInputId,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload();

                });
        }
    }); 
}

var arridcheck = <?php echo json_encode($idcheck); ?>;

arridcheck.forEach(function(item) {
    // console.log(item);
    $('.class_header_'+item ).not(':first').hide();
    $('.class_cetak_'+item ).not(':first').hide();
    $('.class_preview_'+item ).not(':first').hide();

});

var arridcheckpengukuran = <?php echo json_encode($idcheckpengukuran); ?>;

arridcheckpengukuran.forEach(function(item) {
    $('.pengukuran_head_'+item ).not(':first').hide();

});


// $(".headernew").click(function () {

//     var bidValue = this.id;
//       // console.log(bidValue);
//     $('.class_header_'+bidValue ).not(':first').hide();
//     $('.class_cetak_'+bidValue ).not(':first').hide();
//     $('.class_preview_'+bidValue ).not(':first').hide();
//     $('.class_form_'+bidValue ).slideToggle(300);
//     $('.content_check_'+bidValue ).slideToggle(300);
    
// });


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
         $('.class_cetak_'+bidValue ).not(':first').hide();
         $('.class_preview_'+bidValue ).not(':first').hide();
         $('.class_form_'+bidValue ).slideToggle(300);
         $('.content_check_'+bidValue ).slideToggle(300);
    }    
    
});


for(k in CKEDITOR.instances){
    var instance = CKEDITOR.instances[k];
    instance.destroy()
}
CKEDITOR.replaceAll();


</script>