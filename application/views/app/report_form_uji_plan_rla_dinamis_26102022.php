<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/PlanRlaFormUjiDinamis");
$this->load->model('base-app/PlanRLa');
$this->load->model('base-app/TabelTemplate');
$this->load->model('base-app/FormUji');



$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));
$reqIdRla = $this->input->get("reqIdRla");
$reqLihat = $this->input->get("reqLihat");





$set= new PlanRla();

$statement = " AND B.PLAN_RLA_ID = '".$reqIdRla."' ";
$set->selectByParamsFormUjiReport(array(), -1, -1, $statement);
// echo $set->query;exit;


?>
<script type="text/javascript" language="javascript" class="init">	
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
                    <li class="nav-item ">
                        <a class="nav-link "  href="app/index/transaksi_monitoring_pengadaan?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Monitoring Pengadaan & Kontrak</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link " href="app/index/transaksi_pengukuran?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Pengukuran</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link active" href="app/index/report_form_uji_plan_rla?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Report</a>
                    </li>
                    <?
                }
                ?>
            </ul>
            <hr style="height:0.8px;border:none;color:#333;background-color:#333;">
        </div>

        <div class='form-group'>
            <div class='col-md-12'>
                <?

                while ($set->nextRow())
                {

                    $reqFormUjiId= $set->getField("FORM_UJI_ID");
                    $reqNamaFormUji= $set->getField("NAMA");

                    ?>
                        <div class="page-header" style="text-align: center;background-color: #0bb15e;">
                            <h3> <?=$reqNamaFormUji?></h3>       
                        </div>
                        <?
                        $setlist= new PlanRlaFormUjiDinamis();

                        $statement = " AND B.PLAN_RLA_ID = '".$reqIdRla."' AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
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


                            // var_dump($maxbaris);exit;

                        ?>
                        <div class="page-header">
                            <h3><i class="fa fa-file-text fa-lg"></i> <?=$reqTabelNama?></h3>       
                        </div>

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

                                        $statement = " AND A.PLAN_RLA_ID = '".$reqIdRla."' AND A.FORM_UJI_ID = '".$reqFormUjiId."' AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' AND A.FORM_UJI_DETIL_DINAMIS_ID = '".$reqIdDetil."' AND A.PENGUKURAN_ID =".$reqPengukuranId." ";
                                        $setisi->selectByParamsDetil(array(), -1, -1, $statement);
                                        // echo $setisi->query;
// 
                                        while ($setisi->nextRow())
                                        {
                                            $reqIsi= $setisi->getField("NAMA");
                                           ?>

                                                <td> <?=$reqIsi?></th>

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
                        ?>
                <?
                }
                ?>
           
            </div>
        </div>


    </div>
</div>


<script type="text/javascript">

</script>