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


$set= new CetakFormUjiDinamis();
$arrnameplate= [];

$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND F.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' OR F.KELOMPOK_EQUIPMENT_PARENT_ID = '".$reqKelompokEquipmentId."' ";

$set->selectByParamsFormUjiReportNameplateNew(array(), -1, -1, $statement);
                // echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["NAMEPLATE_ID"]= $set->getField("NAMEPLATE_ID");
    $arrdata["MASTER_ID"]= $set->getField("MASTER_ID");
    $arrdata["NAMA_NAMEPLATE"]= $set->getField("NAMA_NAMEPLATE");
    $arrdata["KELOMPOK_EQUIPMENT_ID"]= $set->getField("KELOMPOK_EQUIPMENT_ID");

    if(!empty($arrdata["NAMEPLATE_ID"]))
    {
        array_push($arrnameplate, $arrdata);
    }
}

unset($set);

// print_r($arrnameplate);exit;



$set= new CetakFormUjiDinamis();
$arrformuji= [];
$statement = " AND D.PLAN_RLA_ID = '".$reqId."' AND D.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."'  ";


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
unset($set);

$tanggalsekarang=getFormattedDate(date("Y-m-d"));




// var_dump($reqIya);exit;
?>


<style>
    thead.stick-datatable th:nth-child(1){  width:440px !important; *border:1px solid cyan;}
    thead.stick-datatable ~ tbody td:nth-child(1){  width:440px !important; *border:1px solid yellow;}
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
                        foreach ($arrnameplate as $key => $vnameplate) 
                        {
                            $reqNameplateId= $vnameplate["NAMEPLATE_ID"];
                            $reqNamaNameplate= $vnameplate["NAMA_NAMEPLATE"];
                            $reqKelompokEquipmentId= $vnameplate["KELOMPOK_EQUIPMENT_ID"];
                            ?>
                            <li class="nav-item  active ">
                                <a class="nav-link active  tab  " data-toggle="tab" href="#nameplate_<?=$reqNameplateId?>_<?=$reqKelompokEquipmentId?>" > &nbsp;<?=$reqNamaNameplate?></a>
                            </li>
                        <?
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
                            $reqFormUjiId=$value["FORM_UJI_ID"];
                            $reqKelompokEquipmentId=$value["KELOMPOK_EQUIPMENT_ID"];  
                        ?>
                            <li class="nav-item  <?=$active?>  ">
                                <a class="nav-link <?=$active?>  tab  " data-toggle="tab" href="#formuji_<?=$reqFormUjiId?>_<?=$reqKelompokEquipmentId?>" > &nbsp;<?=$reqNamaFormUji?></a>
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
            <div class="tab-content" >

            <?
            if(!empty($arrnameplate))
            {
                foreach ($arrnameplate as $vnameplate)
                {
                    $reqNameplateId= $vnameplate["NAMEPLATE_ID"];
                    $reqNamaNameplate= $vnameplate["NAMA_NAMEPLATE"];
                    $reqKelompokEquipmentId= $vnameplate["KELOMPOK_EQUIPMENT_ID"];
                ?>

                            <div id="#nameplate_<?=$reqNameplateId?>_<?=$reqKelompokEquipmentId?>" class="tab-pane fade in active" >
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
                                                        <strong>LAPORAN ASSESSMENT <?=strtoupper($reqNamaNameplate)?></strong>
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
                                        <h4 style="margin-left:60px;"><b>Nameplate <?=$reqNamaNameplate?> </b></h4>
                                        <br>

                                        <table style="border-collapse: collapse;margin-left:80px;font-size:12px;font-family: tahoma" >
                                          
                                    
                                                        <tr style="">
                                                            <td style="vertical-align: top;width: 50px">-</td>
                                                            <td style="vertical-align: top;width: 200px"><?=$reqNameplateNama?></td>
                                                            <td style="vertical-align: top;">: &nbsp;</td>
                                                            <td><?=$reqIsiNameplate?></td>
                                                        </tr>
                                             
                                        </table>
                           
                                        <br>
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
                        $jumlahdata=  $value["JUMLAH"];
                        $reqNameplateId= $value["NAMEPLATE_ID"];

                        $arrisirla= [];
                        $statement = " AND F.KELOMPOK_EQUIPMENT_ID = ".$reqKelompokEquipmentId." AND F.FORM_UJI_ID= ".$reqFormUjiId."  AND F.PLAN_RLA_ID = '".$reqId."'";

                        $setlist= new CetakFormUjiDinamis();
                        $setlist->selectByParamsPengukuranTipeInputBaru(array(), -1,-1,$statement);
                        // echo $setlist->query;
                        $tabeli=1;

                        while($setlist->nextRow())
                        {
                            $vpengukuranid= $setlist->getField("PENGUKURAN_ID");
                            $vstatustable= $setlist->getField("STATUS_TABLE");
                            $vtabeltemplateid= $setlist->getField("TABEL_TEMPLATE_ID");
                            $vkeystatus= $vpengukuranid."-".$vstatustable."-".$vtabeltemplateid;
                            $vseq= $setlist->getField("SEQ");

                            $vseqgroup= "";
                            $vseqgroupurut= "";
                            if( strpos($vseq, ".") !== false )
                            {
                                $vseqgroup= substr($vseq, 2, 1);
                                $vseqgroupurut= substr($vseq, 3) % $vseqgroup;
                            }

                            $arrdata= [];
                            $arrdata["TABEL_TEMPLATE_ID"]= $vtabeltemplateid;
                            $arrdata["STATUS_TABLE"]= $vstatustable;
                            $arrdata["VALUE"]= $setlist->getField("VALUE");
                            $arrdata["PENGUKURAN_ID"]= $vpengukuranid;
                            $arrdata["PENGUKURAN_TIPE_INPUT_ID"]= $setlist->getField("PENGUKURAN_TIPE_INPUT_ID");
                            $arrdata["SEQ"]= $vseq;
                            $arrdata["SEQ_GROUP"]= $vseqgroup;
                            $arrdata["SEQ_GROUP_URUT"]= $vseqgroupurut;
                            $arrdata["SEQCHECK"]=$setlist->getField("SEQ").$setlist->getField("STATUS_TABLE");
                            $arrdata["KEY_STATUS"]= $vkeystatus;
                            array_push($arrisirla, $arrdata);
                        }


                    ?>
                        <div id="formuji_<?=$reqFormUjiId?>_<?=$reqKelompokEquipmentId?>" class="tab-pane fade in ">
                            <div class='col-md-12' style="border: 1px solid #000000;">
                                <br>
                                <div style="page-break-inside:avoid;">

                                    <table style="border-collapse: collapse; border: 1px solid black; font-size:13px; width: 100%;">
                                        <thead>
                                            <tr>
                                                <td rowspan="4" style="width:80px;">
                                                    <img src="images/logo-pjb.png" style="width: 120px;" class="logo-slip">
                                                </td>
                                                <td colspan="6" style="border: 1px solid black;" align="center"><strong>PT PEMBANGKITAN JAWA BALI</strong></td>
                                                <td style="width: 60px;">No. Dok.</td>
                                                <td style="width: 5px;">:</td>
                                                <td style="width: 150px;"> <?=$reqKodeMaster?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="border: 1px solid black;" align="center">
                                                    <strong>PJB INTEGRATED MANAGEMENT SYSTEM</strong>
                                                </td>
                                                <td style="width: 60px;">Tgl. Terbit</td>
                                                <td style="width: 5px;">:</td>
                                                <td style="width: 150px;"> <?=$tanggalsekarang?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="border: 1px solid black;" align="center">
                                                    <strong>FORM UJI</strong>
                                                </td>
                                                <td style="width: 60px;">Revisi</td>
                                                <td style="width: 5px;">:</td>
                                                <td style="width: 150px;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6" style="border: 1px solid black;" align="center">
                                                    <strong><?=$reqNamaFormUji?></strong>
                                                </td>
                                                <td style="width: 60px;">Halaman</td>
                                                <td style="width: 5px;">:</td>
                                                <td style="width: 150px;">1</td>
                                            </tr>

                                            <tr>
                                                <td style="border: 1px solid black;" colspan="2">Site :   </td>
                                                <td style="border: 1px solid black;">Manufaktur</td>
                                                <td style="border: 1px solid black;">:</td>
                                                <td style="border: 1px solid black;"></td>
                                                <td style="border: 1px solid black;" rowspan="2" style="word-wrap: break-word;">Tahun <?=$reqTahun?></td>
                                                <td style="border: 1px solid black;" colspan="2">QP No. </td>
                                                <td style="border: 1px solid black;" colspan="2">FU No. </td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid black;" colspan="2">Unit : <?=$reqUnit?> </td>
                                                <td style="border: 1px solid black;">Inspeksi</td>
                                                <td style="border: 1px solid black;">:</td>
                                                <td style="border: 1px solid black;"></td>
                                                <td style="border: 1px solid black;" colspan="4">OEM Doc. No. </td>
                                            </tr>
                                        </thead>
                                    </table>
                                    <br>
                                    <?

                                    $arrbarisgroup= [];
                                    $barisglobal= 8; $indexgroup= 1;
                                    $indextext= 0;
                                    foreach ($arrisirla as $keyisi => $isiv) 
                                    {
                                        $reqMasterTabelId= $isiv["TABEL_TEMPLATE_ID"]; 
                                        $reqStatusTable= $isiv["STATUS_TABLE"]; 
                                        $reqValue= $isiv["VALUE"]; 
                                        $reqTipePengukuranId= $isiv["PENGUKURAN_ID"]; 

                                        $reqPengukuranTipeInputId= $isiv["PENGUKURAN_TIPE_INPUT_ID"];
                                        $reqSeq = $isiv["SEQ"];
                                        $vseqgroup= $isiv["SEQ_GROUP"];
                                        $vseqgroupurut= $isiv["SEQ_GROUP_URUT"];
                                        $infocaristatus= $isiv["SEQCHECK"];

                                        $keybarisgroup= $reqFormUjiId."-".$reqStatusTable."-".$reqMasterTabelId."-".$reqTipePengukuranId."-".$reqSeq;
                                    ?>
                                        <?
                                        if($reqStatusTable == "TABLE")
                                        {
                                        ?>
                                           
                                            <table style=" font-size:13px; border: 1px; margin-left: auto; margin-right: auto; width: 60%;" >
                                                    <thead>
                                                        <tr>
                                                            <td style="border: 1px solid black;">Bushing Fasa</td>
                                                            <td style="border: 1px solid black;">Skirt</td>
                                                            <td style="border: 1px solid black;">Tegangan Injeksi (kV)</td>
                                                            <td style="border: 1px solid black;">I (mA)</td>
                                                            <td style="border: 1px solid black;">Watts</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="border: 1px solid black;">1</td>
                                                            <td style="border: 1px solid black;">2</td>
                                                            <td style="border: 1px solid black;">3</td>
                                                            <td style="border: 1px solid black;">4</td>
                                                            <td style="border: 1px solid black;">5</td>
                                                        </tr>
                                                    </tbody>
                                            </table>
                                            <br>
                                        <?
                                        }
                                        else if($reqStatusTable=="TEXT" )
                                        {

                                            $statementv = "  AND A.PENGUKURAN_TIPE_INPUT_ID= ".$reqPengukuranTipeInputId."  AND A.FORM_UJI_ID= ".$reqFormUjiId."  AND A.STATUS_TABLE ='TEXT' AND  A.PLAN_RLA_ID =".$reqId." AND  A.KELOMPOK_EQUIPMENT_ID =".$reqKelompokEquipmentId." ";
                                            $checkvalue= new CetakFormUjiDinamis();
                                            $checkvalue->selectplanrlaujidinamis(array(), -1,-1,$statementv);
                                            $baristextcheck=0;
                                            // echo $checkvalue->query;
                                            while ($checkvalue->nextRow())
                                            {
                                                $reqNamaText=  $checkvalue->getField("NAMA");
                                                $baristextcheck=$reqFormUjiId;
                                                $barisglobal++;
                                            
                                        ?>
                                                <table style="border-collapse: collapse;">
                                                    <tr>
                                                        <td style="vertical-align: top;"><?=$reqValue?></td>
                                                        <td style="vertical-align: top;">:</td>
                                                        <td><?=$reqNamaText?></td>
                                                    </tr>
                                                   
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
                                    <br>
                                    <table style="border-collapse: collapse; border: 1px solid black; font-size:13px; width: 100%;">
                                        <tr>
                                            <td style="border: 1px solid black;" colspan="2">RECOMENDATION</td>
                                            <td style="border: 1px solid black;" colspan="4">ACCEPTED/REWORK/REPLACE/REPAIR/MONITORING<br>(by Quality Control)</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;" colspan="2">MEASURING TOOL:</td>
                                            <td style="border: 1px solid black; text-align: center;" colspan="4">OMICRON DIRANA</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black; width: 10%;">Description</td>
                                            <td style="border: 1px solid black; width: 22.5%; text-align: center;" colspan="2">Tested/measured by</td>
                                            <td style="border: 1px solid black; width: 22.5%; text-align: center;">Coordinator</td>
                                            <td style="border: 1px solid black; width: 22.5%; text-align: center;">Quality Control</td>
                                            <td style="border: 1px solid black; width: 22.5%; text-align: center;">Witness</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">Name</td>
                                            <td style="border: 1px solid black; text-align: center;" colspan="2">Eka Sanjaya</td>
                                            <td style="border: 1px solid black; text-align: center;">Triyadi, N.S</td>
                                            <td style="border: 1px solid black; text-align: center;">Ramot Mangihut H.</td>
                                            <td style="border: 1px solid black; text-align: center;">Gregorius Sutrisno</td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black; height: 50px;">Signature</td>
                                            <td style="border: 1px solid black; text-align: center;" colspan="2"></td>
                                            <td style="border: 1px solid black; text-align: center;"></td>
                                            <td style="border: 1px solid black; text-align: center;"></td>
                                            <td style="border: 1px solid black; text-align: center;"></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black;">Date</td>
                                            <td style="border: 1px solid black; text-align: center;" colspan="2"><?=$tanggalsekarang?></td>
                                            <td style="border: 1px solid black; text-align: center;"><?=$tanggalsekarang?></td>
                                            <td style="border: 1px solid black; text-align: center;"><?=$tanggalsekarang?></td>
                                            <td style="border: 1px solid black; text-align: center;"><?=$tanggalsekarang?></td>
                                        </tr>
                                    </table>
                                </div>
                                 <br>
                            </div>
                        </div>
                    <?
                    }
                    ?>
                <?
                }
                ?>
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
