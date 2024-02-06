<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");
$this->load->model("base-app/CetakFormUjiDinamis");
$this->load->model('base-app/PlanRla');
$this->load->model('base-app/FormUji');
$this->load->model('base-app/Nameplate');


$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));
$reqIdRla = $this->input->get("reqIdRla");
$reqId = $this->input->get("reqId");
$reqKelompokEquipmentId = $this->input->get("reqKelompokEquipmentId");
$reqKelompokEquipmentParentId = $this->input->get("reqKelompokEquipmentParentId");
$reqNameplateId = $this->input->get("reqNameplateId");
$reqIdParent = $this->input->get("reqIdParent");
$reqIdParent = substr($reqIdParent, 0, 3); 
$reqCheck = $this->input->get("reqCheck");

if($reqCheck==1)
{
$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND F.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."'  ";
}
else
{

$statement = " AND D.PLAN_RLA_ID = '".$reqId."'  AND LEFT(F.ID,3)  LIKE '%".$reqIdParent."%'  ";


}

$set= new CetakFormUjiDinamis();
$arrnameplate= [];


$set->selectByParamsFormUjiReportNameplateNew(array(), -1, -1, $statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["NAMEPLATE_ID"]= $set->getField("NAMEPLATE_ID");
    $arrdata["MASTER_ID"]= $set->getField("MASTER_ID");
    $arrdata["NAMA_NAMEPLATE"]= $set->getField("NAMA_NAMEPLATE");
    $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
    $arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
    $arrdata["PARENT_ID"]= $set->getField("PARENT_ID");
    $arrdata["ID"]= $set->getField("ID");

    if(!empty($arrdata["NAMEPLATE_ID"]))
    {
        array_push($arrnameplate, $arrdata);
    }
}

unset($set);


$set= new CetakFormUjiDinamis();

$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND F.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' OR F.KELOMPOK_EQUIPMENT_PARENT_ID = '".$reqKelompokEquipmentId."' ";

$set->selectByParamsFormUjiReportNameplateNew(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();

$reqNameplateNama= $set->getField("NAMA_NAMEPLATE");


unset($set);

// print_r($arrnameplate);exit;



$set= new CetakFormUjiDinamis();
$arrformuji= [];
if($reqCheck==1)
{
$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND D.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."'  ";
}
else
{

$statement = " AND D.PLAN_RLA_ID = '".$reqId."'  AND LEFT(E.ID,3)  LIKE '%".$reqIdParent."%'  ";

}

$set->selectByParamsFormUjiReport(array(), -1,-1,$statement);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
    $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["NAMA_KELOMPOK"]= $set->getField("NAMA_KELOMPOK");
    $arrdata["JUMLAH"]= $set->rowCount;
    $arrdata["NAMEPLATE_ID"]= $set->getField("NAMEPLATE_ID");
    $arrdata["PARENT_ID"]= $set->getField("PARENT_ID");
    $arrdata["ID"]= $set->getField("ID");

    array_push($arrformuji, $arrdata);
}
unset($set);

$set= new CetakFormUjiDinamis();

$statement = " AND A.PLAN_RLA_ID = '".$reqId."' ";
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$reqUnit = $set->getField("NAMA_UNIT");
$reqTahun = $set->getField("TAHUN");
$reqKodeMaster = $set->getField("KODE_MASTER_PLAN");
$reqIya = $set->getField("STATUS_CATATAN");
unset($set);

$tanggalsekarang=getFormattedDate(date("Y-m-d"));

$set= new CetakFormUjiDinamis();
$arrformnameplate= [];

$statement = " AND A.NAMEPLATE_ID=".$reqNameplateId." ";
$set->selectByParamsNameplate(array(), -1, -1, $statement);
                // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("NAMEPLATE_ID");
    $arrdata["NAMEPLATE_DETIL_ID"]= $set->getField("NAMEPLATE_DETIL_ID");
    $arrdata["MASTER_ID"]= $set->getField("MASTER_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["NAMA_NAMEPLATE"]= $set->getField("NAMA_NAMEPLATE");
    $arrdata["NAMA_TABEL"]= $set->getField("NAMA_TABEL");
    $arrdata["STATUS"]= $set->getField("STATUS");
    $arrdata["ISI"]= $set->getField("ISI");

    if(!empty($arrdata["id"]))
    {
        array_push($arrformnameplate, $arrdata);
    }
}

unset($set);





// var_dump($reqIya);exit;
?>


<style>
	thead.stick-datatable th:nth-child(1){	width:440px !important; *border:1px solid cyan;}
	thead.stick-datatable ~ tbody td:nth-child(1){	width:440px !important; *border:1px solid yellow;}
</style>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="<?=base_url()?>lib/startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/css/btn.css" rel="stylesheet">

</head>
<body>
    <div class="col-md-12">
        <div class="judul-halaman"> <a href="app/index/transaksi_management_master_plan">Data Management Master Plan</a> › <a href="app/index/transaksi_management_master_plan_add?reqId=<?=$reqId?>">Kelola Management Master Plan </a> › <?=$pgtitle?></div>
        <div class="konten-area"  >
            <div class="konten-inner">
                <ul class="nav nav-pills mr-auto">
                    <?
                    $active="active";
                    if(!empty($arrnameplate))
                    {
                        $active="";
                        $i=0;
                        foreach ($arrnameplate as $key => $vnameplate) 
                        {
                            $reqNameplateNewId= $vnameplate["NAMEPLATE_ID"];
                            $reqNamaNameplate= $vnameplate["NAMA_NAMEPLATE"];
                            $reqKelompokEquipmentNewId= $vnameplate["KELOMPOK_EQUIPMENT_ID"];
                            $reqKelompokEquipmentParentId= $vnameplate["KELOMPOK_EQUIPMENT_PARENT_ID"];
                            $reqKelompokEquipment= $vnameplate["NAMA_KELOMPOK"];
                            $reqIdParent= $vnameplate["PARENT_ID"];
                            if($reqIdParent==0)
                            {
                                $reqIdParent= $vnameplate["ID"];
                            }
                            // var_dump($i);

                            if( $reqNameplateNewId ==  $reqNameplateId &&   $reqKelompokEquipmentNewId ==  $reqKelompokEquipmentId)
                            {
                                 $active="active";
                            }
                            else
                            {
                                 $active="";
                            }
                            ?>
                            <li class="nav-item  <?=$active?> ">
                                <a class="nav-link <?=$active?>  tab  " href="app/index/preview_report_plan_rla_nameplate?reqId=<?=$reqId?>&reqKelompokEquipmentId=<?=$reqKelompokEquipmentNewId?>&reqNameplateId=<?=$reqNameplateNewId?>&reqIdParent=<?=$reqIdParent?>&reqCheck=<?=$reqCheck?>" > &nbsp;<?=$reqKelompokEquipment?>_<?=$reqNamaNameplate?></a>
                            </li>
                        <?
                        $i++;
                        }
                        ?>
                    <?
                    }
                    ?>

                    <?
                    if(!empty($arrformuji))
                    {
                        foreach ($arrformuji as $key => $value) 
                        {
                            $reqNamaFormUji= $value["NAMA"];
                            $reqFormUjiNewId=$value["FORM_UJI_ID"];
                            $reqKelompokEquipmentNewId=$value["KELOMPOK_EQUIPMENT_ID"];
                            $reqIdParent= $value["PARENT_ID"];
                            $reqKelompokEquipment= $value["NAMA_KELOMPOK"];
                            if($reqIdParent==0)
                            {
                                $reqIdParent= $value["ID"];
                            }

                            if( $reqFormUjiNewId ==  $reqFormUjiId &&   $reqKelompokEquipmentNewId ==  $reqKelompokEquipmentId)
                            {
                                 $active="active";
                            }
                            else
                            {
                                 $active="";
                            }
                        ?>
                           <!--  <li class="nav-item  <?=$active?>  ">
                                <a class="nav-link <?=$active?>  tab  " data-toggle="tab" href="#formuji_<?=$reqFormUjiNewId?>_<?=$reqKelompokEquipmentNewId?>" > &nbsp;<?=$reqNamaFormUji?></a>
                            </li> -->
                             <li class="nav-item  <?=$active?> ">
                                <a class="nav-link <?=$active?>  tab  " href="app/index/preview_report_plan_rla_form_uji?reqId=<?=$reqId?>&reqKelompokEquipmentId=<?=$reqKelompokEquipmentNewId?>&reqFormUjiId=<?=$reqFormUjiNewId?>&reqIdParent=<?=$reqIdParent?>&reqCheck=<?=$reqCheck?>" > &nbsp;<?=$reqKelompokEquipment?>_<?=$reqNamaFormUji?></a>
                            </li>
                        <?
                        }
                        ?>
                    <?
                    }
                    ?>


                    <?
                    if($reqIya==1)
                    {
                    ?>
                     <li class="nav-item  <?=$active?> ">
                        <a class="nav-link <?=$active?>  tab  "  href="app/index/preview_report_plan_rla_catatan?reqId=<?=$reqId?>&reqKelompokEquipmentId=<?=$reqKelompokEquipmentNewId?>&reqIdParent=<?=$reqIdParent?>&reqCheck=<?=$reqCheck?>" > &nbsp;Catatan</a>
                    </li>
                    <?
                    }
                    ?>
                   
                </ul>
                <hr style="height:0.8px;border:none;color:#333;background-color:#333;">
            </div>
            <div class="tab-content" >

                <div id="nameplate" class="tab-pane fade in active" >
                    <div class='col-md-12'  style="border: 1px solid #000000;" >
                        <br>
                        <div style="page-break-inside:avoid;">
                            <table style="border-collapse: collapse; border: 1px solid black; font-size:11px; width: 100%;">
                                <thead>
                                    <tr>
                                        <td rowspan="4" style="width:80px;">
                                            <img src="images/logo-pjb.png" style="width: 120px;" class="logo-slip">
                                        </td>
                                        <td colspan="6" style="border: 1px solid black;" align="center"><strong>PT PEMBANGKITAN JAWA BALI</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="border: 1px solid black;" align="center">
                                            <strong>PJB INTEGRATED MANAGEMENT SYSTEM</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="border: 1px solid black;" align="center">
                                            <strong>LAPORAN ASSESSMENT <?=strtoupper($reqNameplateNama)?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="border: 1px solid black;" align="center">
                                            <strong> <?=$reqUnit?></strong>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <br />
                        <div class='judul-laporan' style="font-family: tahoma">
                            <br>
                            <br>
                            <h4 style="margin-left:60px;"><b>Nameplate <?=$reqNameplateNama?> </b></h4>
                            <br>

                            <table style="border-collapse: collapse;margin-left:80px;font-size:12px;font-family: tahoma" >
                                <?
                                if(!empty($arrformnameplate))
                                {
                                    foreach ($arrformnameplate as $vnameplate)
                                    {
                                        $reqFormUjiNameplateId= $vnameplate["FORM_UJI_NAMEPLATE_ID"];
                                        $reqNameplateDetilId= $vnameplate["NAMEPLATE_DETIL_ID"];
                                        $reqMasterId= $vnameplate["MASTER_ID"];
                                        $reqNameplateNama= $vnameplate["NAMA"];
                                        $reqNamaNameplate= $vnameplate["NAMA_NAMEPLATE"];
                                        $reqNamaTabel= $vnameplate["NAMA_TABEL"];
                                        $reqStatusTable= $vnameplate["STATUS"];
                                        $reqIsiNameplate= $vnameplate["ISI"];

                                        if(!empty($reqNamaTabel) && $reqStatusTable==1)
                                        {
                                            $statement= "AND ".$reqNamaTabel."_ID = ".$reqIsiNameplate;
                                            $setmaster= new Nameplate();
                                            $setmaster->selectByParamsCheckTabel(array(), -1, -1, $statement,$sOrder,$reqNamaTabel);
                                            $setmaster->firstRow();
                                            $reqIsiNameplate=$setmaster->getField("NAMA");

                                        }
                                        ?>

                                        <tr style="">
                                            <td style="vertical-align: top;width: 50px">-</td>
                                            <td style="vertical-align: top;width: 200px"><?=$reqNameplateNama?></td>
                                            <td style="vertical-align: top;">: &nbsp;</td>
                                            <td><?=$reqIsiNameplate?></td>
                                        </tr>
                                        <?
                                    }
                                    ?>
                                    <?
                                }
                                ?>
                            </table>

                            <br>
                        </div>
                    </div>
                </div>
                 

            </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.tab').on('click', function() {
                $('.tab').removeClass('active');
                $(this).addClass('active');
            });
        })
    </script>
</body>
