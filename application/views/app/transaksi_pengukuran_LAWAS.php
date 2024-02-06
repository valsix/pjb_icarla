<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/PlanRlaFormUjiDetil");
$this->load->model('base-app/PlanRla');
$this->load->model("base-app/Crud");


$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));
$reqIdRla = $this->input->get("reqIdRla");
$reqLihat = $this->input->get("reqLihat");

$statement = " AND A.PLAN_RLA_ID = '".$reqIdRla."' ";
$set= new PlanRla();
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$vstatus= $set->getField("V_STATUS");
unset($set);

$kode= $appuserkodehak;
$set= new Crud();
$statement=" AND (A.PENGGUNA_HAK_ID = 1 OR A.PENGGUNA_HAK_ID = 8 OR A.PENGGUNA_HAK_ID = 9)   AND KODE_MODUL ='0501' AND A.KODE_HAK =  '".$kode."'  ";
$set->selectByParamsCrudHak(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqMenuUmro= $set->getField("MENU");

unset($set);


$set= new PlanRla();

$statement = " AND B.PLAN_RLA_ID = '".$reqIdRla."' ";
$set->selectByParamsPlanRlaFormUjiTemplate(array(), -1, -1, $statement);
// echo $set->query;exit;


?>
<script type="text/javascript" language="javascript" class="init">  
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
                    <li class="nav-item active ">
                        <a class="nav-link active " href="app/index/transaksi_pengukuran?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Pengukuran</a>
                    </li>

                    <?
                    if($vstatus==20 &&  $reqMenuUmro == 1)
                    {
                        ?>
                        <li class="nav-item ">
                            <a class="nav-link " href="app/index/summary_rekomendasi?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Summary dan Rekomendasi</a>
                        </li>
                        <?
                    }
                    ?>

                    
                    <?
                    if($vstatus==20)
                    {
                        ?>
                        <li class="nav-item ">
                            <a class="nav-link " href="app/index/report_form_uji_plan_rla_dinamis?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Report</a>
                        </li>
                        <?
                    }
                    ?>
                   
                    <?
                }
                ?>
            </ul>
            <hr style="height:0.8px;border:none;color:#333;background-color:#333;">
        </div>

        <div class='form-group'>
            <div class='col-md-12'>
                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> List Form Uji </h3>       
                </div>
                <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                        <thead>
                            <tr>
                            <th style="vertical-align : middle;text-align:center;">Nama</th>
                            <th style="vertical-align : middle;text-align:center;">Url</th>
                            </tr>
                        </thead>
                        <tbody id="tabel">
                        <?
                        while ( $set->nextRow()) {
                            $reqNama=$set->getField("NAMA");
                            $reqFormUjiId=$set->getField("FORM_UJI_ID");
                        ?>
                            <tr >
                                <td style="width: 50%"><?=$reqNama?>
                                </td>
                                <td style="text-align: center"><a href="app/index/master_form_uji_add?reqId=<?=$reqFormUjiId?>&reqLihat=1" target="_blank">Link</a> 
                                </td>
                            </tr>
                        <?
                        }
                        ?>
                        </tbody>
                </table>
            </div>
        </div>


    </div>
</div>


<script type="text/javascript">

</script>