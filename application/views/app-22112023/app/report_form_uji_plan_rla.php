<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/PLanRlaFormUjiDetil");
$this->load->model('base-app/PlanRLa');

$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));
$reqIdRla = $this->input->get("reqIdRla");
$reqLihat = $this->input->get("reqLihat");





$set= new PlanRla();

$statement = " AND B.PLAN_RLA_ID = '".$reqIdRla."' ";
$set->selectByParamsPlanRlaFormUjiTemplate(array(), -1, -1, $statement);
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
            $reqId= $set->getField("PLAN_RLA_ID");
            $reqListFormUji= $set->getField("FORM_UJI_ID");


            $reqNamaFormUji= $set->getField("NAMA");

            ?>
            <?
            $tipe= new PlanRla();


            $statement = " AND A.FORM_UJI_ID = '".$reqListFormUji."' ";
            $tipe->selectByParamsPlanRlaFormUjiTemplateTipe(array(), -1, -1, $statement);

            while ($tipe->nextRow())
            {

                $reqNamaTipe= $tipe->getField("NAMA");
                $reqListFormUjiTipe= $tipe->getField("FORM_UJI_TIPE_ID");
                $hasil= new PLanRlaFormUjiDetil();
                $arrwaktuBefore= [];
                $arrRatio= [];
                $arrEc= [];
                $statement = " AND A.FORM_UJI_TIPE_ID =  ".$reqListFormUjiTipe." AND FORM_UJI_ID = '".$reqListFormUji."'";
                $hasil->selectByParamsDetil(array(), -1, -1, $statement);
                // echo  $hasil->query;

                while($hasil->nextRow())
                {
                     // print_r($reqListFormUjiTipe);
                    if($reqListFormUjiTipe==1 || $reqListFormUjiTipe==2)
                    {
                       $arrdata= array();
                       $arrdata["id"]= $hasil->getField("PLAN_RLA_FORM_UJI_DETIL_ID");
                       $arrdata["parent"]= $hasil->getField("FORM_UJI_ID");
                       $arrdata["tipe"]= $hasil->getField("FORM_UJI_TIPE_ID");
                       $arrdata["waktu"]= $hasil->getField("WAKTU");
                       $arrdata["hv_gnd"]= $hasil->getField("HV_GND");
                       $arrdata["lv_gnd"]= $hasil->getField("LV_GND");
                       $arrdata["hv_lv"]= $hasil->getField("HV_LV");

                       if(!empty($arrdata["id"]))
                       {
                            array_push($arrwaktuBefore, $arrdata);
                       }
                    }
                    elseif ($reqListFormUjiTipe==8) 
                    {
               
                        $arrdata= array();
                        $arrdata["id"]= $hasil->getField("PLAN_RLA_FORM_UJI_DETIL_ID");
                        $arrdata["parent"]= $hasil->getField("FORM_UJI_ID");
                        $arrdata["tipe"]= $hasil->getField("FORM_UJI_TIPE_ID");

                        $arrdata["TAP"]= $hasil->getField("TAP");
                        $arrdata["TEGANGAN_EC"]= $hasil->getField("TEGANGAN_EC");
                        $arrdata["IMA_RT"]= $hasil->getField("IMA_RT");
                        $arrdata["WATTS_RT"]= $hasil->getField("WATTS_RT");
                        $arrdata["LC_RT"]= $hasil->getField("LC_RT");

                        $arrdata["IMA_SR"]= $hasil->getField("IMA_SR");
                        $arrdata["WATTS_SR"]= $hasil->getField("WATTS_SR");
                        $arrdata["LC_SR"]= $hasil->getField("LC_SR");

                        $arrdata["IMA_TS"]= $hasil->getField("IMA_TS");
                        $arrdata["WATTS_TS"]= $hasil->getField("WATTS_TS");
                        $arrdata["LC_TS"]= $hasil->getField("LC_TS");
                      
                        if(!empty($arrdata["id"]))
                        {
                            array_push($arrEc, $arrdata);
                        }
                        // print_r($arrEc);
                    }
                    elseif ($reqListFormUjiTipe==10) 
                    {
               
                        $arrdata= array();
                        $arrdata["id"]= $hasil->getField("PLAN_RLA_FORM_UJI_DETIL_ID");
                        $arrdata["parent"]= $hasil->getField("FORM_UJI_ID");
                        $arrdata["tipe"]= $hasil->getField("FORM_UJI_TIPE_ID");

                        $arrdata["FASA_RATIO"]= $hasil->getField("FASA_RATIO");
                        $arrdata["TAP_RATIO"]= $hasil->getField("TAP_RATIO");

                        $arrdata["HV_KV"]= $hasil->getField("HV_KV");
                        $arrdata["LV_KV"]= $hasil->getField("LV_KV");
                        $arrdata["RASIO_TEGANGAN"]= $hasil->getField("RASIO_TEGANGAN");
                        $arrdata["HV_V"]= $hasil->getField("HV_V");
                        $arrdata["DERAJAT_HV_V"]= $hasil->getField("DERAJAT_HV_V");
                        $arrdata["LV_V"]= $hasil->getField("LV_V");

                        $arrdata["DERAJAT_LV_V"]= $hasil->getField("DERAJAT_LV_V");
                        $arrdata["RASIO_HASIL"]= $hasil->getField("RASIO_HASIL");
                        $arrdata["DEVIASI"]= $hasil->getField("DEVIASI");
                      
                        if(!empty($arrdata["id"]))
                        {
                            array_push($arrRatio, $arrdata);
                        }
                        // print_r($arrRatio);
                    }
                   

                }

                

                ?>
                        <?if($reqListFormUjiTipe==1 || $reqListFormUjiTipe==2)
                        {
                        ?>
                            <div class="page-header" style="text-align: center;background-color: #0bb15e;">
                                <h3> <?=$reqNamaFormUji?></h3>       
                            </div>
                            <div class="page-header">
                            <h3><i class="fa fa-file-text fa-lg"></i> <?=$reqNamaTipe?></h3>       
                            </div>

                            <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                                <thead>
                                    <tr>
                                      <th rowspan="2" style="vertical-align : middle;text-align:center;">Waktu (menit)</th>
                                      <th colspan="1" style="vertical-align : middle;text-align:center;" >HV - Gnd (GΩ)</th>
                                      <th colspan="1" style="vertical-align : middle;text-align:center;" >LV - Gnd (GΩ)</th>
                                      <th colspan="1" style="vertical-align : middle;text-align:center;">HV - LV (GΩ)</th>
                                  </tr>
                                  <tr>
                                    <th style="vertical-align : middle;text-align:center;">5000 Vdc</th>
                                    <th style="vertical-align : middle;text-align:center;">2500 Vdc</th>
                                    <th style="vertical-align : middle;text-align:center;">2500 Vdc</th>
                                </tr>
                            </thead>
                            <tbody id="tableIrpiBefore">

                                <?
                                foreach($arrwaktuBefore as $item) 
                                {
                                    $selectvalid= $item["id"];
                                    $selectparent=$item["parent"];
                                    $selecttipe=$item["tipe"];
                                    $selectwaktu= $item["waktu"];
                                    $selecthv_gnd= $item["hv_gnd"];
                                    $selectlv_gnd= $item["lv_gnd"];
                                    $selecthv_lv= $item["hv_lv"];
                                    ?>

                                <tr id="irpibeforedetil-<?=$selectvalid?>" >
                                    <td style="text-align: center"><?=$selectwaktu?>
                                    </td>
                                    <td style="text-align: center"><?=$selecthv_gnd?>
                                    </td>
                                    <td style="text-align: center"><?=$selectlv_gnd?>
                                    </td>
                                    <td style="text-align: center"><?=$selecthv_lv?>
                                    </td> 
                                </tr>
                                <?
                                }
                                ?>

                            </tbody>
                            </table>


                        <?
                        }
                        else if($reqListFormUjiTipe==10)
                        {
                        ?>

                            <div class="page-header" style="text-align: center;background-color: #0bb15e;">
                                <h3> <?=$reqNamaFormUji?></h3>       
                            </div>
                            <div class="page-header">
                                <h3><i class="fa fa-file-text fa-lg"></i> <?=$reqNamaTipe?></h3>       
                            </div>

                            <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Fasa</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Tap</th>
                                        <th rowspan="1" colspan="3" style="vertical-align : middle;text-align:center;">Tegangan Nameplate</th>
                                        <th rowspan="1" colspan="5" style="vertical-align : middle;text-align:center;">Hasil Ukur</th>
                                        <th rowspan="2" style="vertical-align : middle;text-align:center;">Deviasi (%)</th>
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
                                        foreach($arrRatio as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectparent=$item["parent"];
                                            $selecttipe=$item["tipe"];

                                            $reqFasaRatio= $item["FASA_RATIO"];
                                            $reqTapRatio= $item["TAP_RATIO"];
                                            $reqHvKv= $item["HV_KV"];
                                            $reqLvKv= $item["LV_KV"];
                                            $reqRasioTegangan= $item["RASIO_TEGANGAN"];
                                            $reqHvV= $item["HV_V"];
                                            $reqDerajatHvV= $item["DERAJAT_HV_V"];
                                            $reqLvV= $item["LV_V"];
                                            $reqDerajatLvV= $item["DERAJAT_LV_V"];
                                            $reqRasioHasil= $item["RASIO_HASIL"];
                                            $reqDeviasi= $item["DEVIASI"];

                                            ?>

                                            <tr id="ratiodetil-<?=$selectvalid?>" >
                                                <td style="text-align: center"><?=$reqFasaRatio?>
                                                </td>
                                                <td style="text-align: center"><?=$reqTapRatio?>
                                                </td>
                                                <td style="text-align: center"><?=$reqHvKv?>
                                                </td>
                                                <td style="text-align: center"><?=$reqLvKv?>
                                                </td>
                                                <td style="text-align: center"><?=$reqRasioTegangan?>
                                                </td>
                                                <td style="text-align: center"><?=$reqHvV?>
                                                </td> 
                                                <td style="text-align: center"><?=$reqDerajatHvV?>
                                                </td>
                                                <td style="text-align: center"><?=$reqLvV?>
                                                </td> 
                                                <td style="text-align: center"><?=$reqDerajatLvV?>
                                                </td> 
                                                <td style="text-align: center"><?=$reqRasioHasil?>
                                                </td>
                                                <td style="text-align: center"><?=$reqDeviasi?>
                                                </td> 
                                               
                                            </tr>

                                        <?
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?
                        }
                        else if($reqListFormUjiTipe==8)
                        {
                        ?>

                            <div class="page-header" style="text-align: center;background-color: #0bb15e;">
                                <h3> <?=$reqNamaFormUji?></h3>       
                            </div>
                            <div class="page-header">
                                <h3><i class="fa fa-file-text fa-lg"></i> <?=$reqNamaTipe?></h3>       
                            </div>

                            <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                                    <thead>
                                        <tr>
                                            <th rowspan="3" style="vertical-align : middle;text-align:center;">Tap</th>
                                            <th rowspan="3" style="vertical-align : middle;text-align:center;">Tegangan Injeksi (kV)</th>
                                            <th rowspan="1" colspan="9" style="vertical-align : middle;text-align:center;">Excitation current (mA) dan Daya (W)</th>
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
                                    foreach($arrEc as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectparent=$item["parent"];
                                        $selecttipe=$item["tipe"];

                                        $selecttap= $item["TAP"];
                                        $selecttegangan= $item["TEGANGAN_EC"];

                                        $selectimaRt= $item["IMA_RT"];
                                        $selectwattsRt= $item["WATTS_RT"];
                                        $selectlcRt= $item["LC_RT"];

                                        $selectimaSr= $item["IMA_SR"];
                                        $selectwattsSr= $item["WATTS_SR"];
                                        $selectlcsr= $item["LC_SR"];

                                        $selectimaTs= $item["IMA_TS"];
                                        $selectwattsTs= $item["WATTS_TS"];
                                        $selectlcTs= $item["LC_TS"];
                                    ?>

                                        <tr id="ecdetil-<?=$selectvalid?>" >
                                            <td style="text-align: center"><?=$selecttap?>
                                            </td>
                                            <td style="text-align: center"><?=$selecttegangan?>
                                            </td>
                                            <td style="text-align: center"><?=$selectimaRt?>
                                            </td>
                                            <td style="text-align: center"><?=$selectwattsRt?>
                                            </td>
                                            <td style="text-align: center"><?=$selectlcRt?>
                                            </td>
                                            <td style="text-align: center"><?=$selectimaSr?>
                                            </td>
                                            <td style="text-align: center"><?=$selectwattsSr?>
                                            </td>
                                            <td style="text-align: center"><?=$selectlcsr?>
                                            </td>
                                            <td style="text-align: center"><?=$selectimaTs?>
                                            </td>
                                            <td style="text-align: center"><?=$selectwattsTs?>
                                            </td>
                                            <td style="text-align: center"><?=$selectlcTs?>
                                            </td>   
                                           
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
        <?
        }
        ?>
   
    </div>
                </div>


    </div>
</div>


<script type="text/javascript">

</script>