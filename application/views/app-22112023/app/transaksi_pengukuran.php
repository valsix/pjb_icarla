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
$arrkelompokequipment= [];
$statement = " AND C.PLAN_RLA_ID = '".$reqIdRla."' ";

$set->selectByParamsKelompokEquipmentPengukuran(array(), -1,-1,$statement);
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


function rand_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}


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
              <?
              $idcheck=[];
              if(!empty($arrkelompokequipment))
              {
                    $idcheckpengukuran=[];

                    foreach ($arrkelompokequipment as $key => $value) 
                    {
                        $reqKelompokEquipmentId=$value["KELOMPOK_EQUIPMENT_ID"]; 
                        $reqNamaKelompok=$value["NAMA"];
                        $reqKelId=$value["ID"];  
                        $reqNamaKelompok=$value["NAMA"];  
                        $idcheck[]= $reqKelompokEquipmentId;
                        $reqParentId=$value["PARENT_ID"];

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
                        // print_r($result);

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

                        <div style="<?=$margin?>" class="content class_form_<?=$reqKelompokEquipmentId?> class_form_parent_<?=$result?>" >
                            <table  class="table table-bordered table-striped table-hovered " style="margin-top: 10px;" id="tabel_<?=$reqKelompokEquipmentId?>">
                                    <thead>
                                        <tr>
                                        <th style="vertical-align : middle;text-align:center;">Nama Form Uji</th>
                                        <th style="vertical-align : middle;text-align:center;">Url</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel">
                                    <?

                                    $set= new PlanRla();

                                    $statement = " AND B.PLAN_RLA_ID = '".$reqIdRla."' AND B.KELOMPOK_EQUIPMENT_ID = '".$reqKelompokEquipmentId."' ";
                                    $set->selectByParamsPlanRlaPengukuran(array(), -1, -1, $statement);
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
        $('#tabel_'+bidValue ).slideToggle(5);
    }    
    
});

</script>