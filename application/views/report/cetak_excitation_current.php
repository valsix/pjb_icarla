<html moznomarginboxes mozdisallowselectionprint>
<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");
include_once("functions/string.func.php");
// $this->load->model('base-mobile/PermohonanCutiTahunan');
// $permohonan_cuti_tahunan= new PermohonanCutiTahunan();

$reqTipe= $this->input->get("reqTipe");
$reqId= $this->input->get("reqId");
// print_r($reqId);exit;
$this->load->model('base-app/FormUji');

$tahun=date("Y");

$set= new FormUji();

$statement= " AND A.FORM_UJI_ID = ".$reqId." AND A.FORM_UJI_TIPE_ID = ".$reqTipe."";

$set->selectByParams(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqId= $set->getField("FORM_UJI_ID");
$reqReference= $set->getField("REFERENCE");
$reqResult= $set->getField("RESULT");
$reqNote= $set->getField("NOTE");
$reqNama= $set->getField("NAMA");
$reqAirTemp= $set->getField("AIR_TEMP");
$reqHumidity= $set->getField("HUMIDITY");
$reqApparatusTemp= $set->getField("APPARATUS_TEMP");
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <base href="<?=base_url();?>"> -->

    <link rel="stylesheet" href="<?=base_url()?>css/laporan.css" type="text/css">
    <link href="<?=base_url()?>lib/startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/css/btn.css" rel="stylesheet">

</head>

<body>
    <div style="page-break-inside:avoid;">
        <table style="border-collapse: collapse; border: 1px solid black; font-size:11px; width: 100%;">
            <thead>
                <tr>
                    <td rowspan="4" style="width:80px;">
                        <img src="images/logo-pjb.png" style="width: 120px;" class="logo-slip">
                    </td>
                    <td colspan="6" style="border: 1px solid black;" align="center"><strong>PT PEMBANGKITAN JAWA BALI</strong></td>
                    <td style="width: 60px;">No. Dok.</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 150px;"></td>
                </tr>
                <tr>
                    <td colspan="6" style="border: 1px solid black;" align="center">
                        <strong>PJB INTEGRATED MANAGEMENT SYSTEM</strong>
                    </td>
                    <td style="width: 60px;">Tgl. Terbit</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 150px;"></td>
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
                        <strong><?=$reqNama?></strong>
                    </td>
                    <td style="width: 60px;">Halaman</td>
                    <td style="width: 5px;">:</td>
                    <td style="width: 150px;"></td>
                </tr>

                <tr>
                    <td style="border: 1px solid black;" colspan="2">Site : </td>
                    <td style="border: 1px solid black;">Manufaktur</td>
                    <td style="border: 1px solid black;">:</td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;" rowspan="2" style="word-wrap: break-word;">Tahun <?=$tahun?></td>
                    <td style="border: 1px solid black;" colspan="2">QP No. </td>
                    <td style="border: 1px solid black;" colspan="2">FU No. </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;" colspan="2">Unit : </td>
                    <td style="border: 1px solid black;">Inspeksi</td>
                    <td style="border: 1px solid black;">:</td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black;" colspan="4">OEM Doc. No. </td>
                </tr>
            </thead>
        </table>
    </div>
    <br />

    <div class='judul-laporan'>

        <table style="border-collapse: collapse; font-size:11px; margin-left: auto; margin-right: auto; width: 80%;">
            <tr>
                <td colspan="12">Vector Group Trafo Dyn1</td>
            </tr>
            <tr><td style="height: 10px;"></td></tr>
            <thead>
                <tr>
                    <td style="border: 1px solid black;" rowspan="3">No</td>
                    <td style="border: 1px solid black;" rowspan="3">Tap</td>
                    <td style="border: 1px solid black;" rowspan="3">Tegangan Injeksi (kV)</td>
                    <td style="border: 1px solid black;" colspan="9">Excitation current (mA) dan Daya (W)</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;" colspan="3">R-T</td>
                    <td style="border: 1px solid black;" colspan="3">S-R</td>
                    <td style="border: 1px solid black;" colspan="3">T-S</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black;">I (mA)</td>
                    <td style="border: 1px solid black;">W (watts)</td>
                    <td style="border: 1px solid black;">L/C I (mA)</td>

                    <td style="border: 1px solid black;">I (mA)</td>
                    <td style="border: 1px solid black;">W (watts)</td>
                    <td style="border: 1px solid black;">L/C</td>

                    <td style="border: 1px solid black;">I (mA)</td>
                    <td style="border: 1px solid black;">W (watts)</td>
                    <td style="border: 1px solid black;">L/C</td>
                </tr>
            </thead>
            <tbody>
                <?
                $set->selectByParamsDetil(array(), -1, -1, $statement);

                $i=1;
                while($set->nextRow())
                {
                    ?>
                    <tr>
                        <td style="border: 1px solid black;"><?=$i?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("TAP")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("TEGANGAN")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("IMA_RT")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("WATTS_RT")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("LC_RT")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("IMA_SR")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("WATTS_SR")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("LC_SR")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("IMA_TS")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("WATTS_TS")?></td>
                        <td style="border: 1px solid black;"><?=$set->getField("LC_TS")?></td>
                    </tr>
                    <?
                    $i++;
                }
                ?>
            </tbody>
            <tr>
                <td style="height: 10px;"></td>
            </tr>            
            <tr>
                <td colspan="4">Note : L : Inductive</td>
                <td colspan="4">C : Capacitive</td>
            </tr>
            <tr>
                <td colspan="4">N : Neutral</td>
            </tr>
            <tr>
                <td style="height: 10px;"></td>
            </tr>
            <tr>
                <td colspan="3">Air Temp. : <?=$reqAirTemp?></td>
                <td colspan="2">Apparatus Temp. : <?=$reqApparatusTemp?></td>
            </tr>
            <tr>
                <td colspan="3">Humidity : <?=$reqHumidity?></td>
            </tr>
        </table>

        <br>
    </div>

    <!-- <div style="font-size:9px; text-align: center;"><b>Terbilang :</b></div> -->
    <br>
    <div>
        <table style="border-collapse: collapse;">
            <tr>
                <td style="vertical-align: top;">Reference</td>
                <td style="vertical-align: top;">:</td>
                <td><?=$reqReference?></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Results</td>
                <td style="vertical-align: top;">:</td>
                <td><?=$reqResult?></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Note</td>
                <td style="vertical-align: top;">:</td>
                <td><?=$reqNote?></td>
            </tr>
        </table>

        <br>
        <table style="border-collapse: collapse; border: 1px solid black; font-size:11px; width: 100%;">
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
                <td style="border: 1px solid black; text-align: center;" colspan="2">3 Agustus 2020</td>
                <td style="border: 1px solid black; text-align: center;">3 Agustus 2020</td>
                <td style="border: 1px solid black; text-align: center;">3 Agustus 2020</td>
                <td style="border: 1px solid black; text-align: center;">3 Agustus 2020</td>
            </tr>
        </table>
    </div>

    <div style='clear:both;'>&nbsp;</div>

    
</body>
</html>