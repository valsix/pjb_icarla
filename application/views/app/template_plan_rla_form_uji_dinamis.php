<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");


$reqTipe= $this->input->get("reqTipe");
$reqId=$this->input->get("reqId");
// print_r($reqId);exit;
$this->load->model('base-app/PlanRla');

$set= new PlanRla();

$statement = " AND B.PLAN_RLA_ID = '".$reqId."' ";
$set->selectByParamsPlanRlaFormUjiTemplateDinamis(array(), -1, -1, $statement);
// echo $set->query;exit;
?>
<style type="text/css">
  .kotak {
  width: 98%;
  height: 100%;
  border: 2px solid #000;
  margin: 0 auto 15px;
  text-align: center;
  padding: 20px;
  /*font-weight: bold;*/
  border-radius: 10px;
}
.warning {
  background-color: #FFF484;
  border-color: #DCC600;
}

div.box {
    overflow: auto;
    height: 8em;
    padding: 1em;
    /*! color: #444; */
    background-color: #FFF484;
    border: 1px solid #e0e0e0;
    margin-bottom: 2em;
}
</style>
<body>

    <script type="text/javascript">
    function submitForm(){
        $('#ff').form('submit',{
            url:'json-app/form_uji_template_dinamis_json/upload',
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
                {
                    $.messager.alert('Info', infoSimpan, 'info')
                     setTimeout( function() {top.closePopup(); }, 2000);
                }

                // top.closePopup();
            }
        });
    }
    </script>
   <div class="col-md-12">

      <div class="judul-halaman"> Upload &rsaquo; Tipe Form Uji</div>

      <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">
                 <div class="form-group">


                    <div class='col-md-12'>
                        <div class="warning kotak" style="text-align: justify;font-size: 18px">
                            <ol>
                                <li>Pastikan data import format <b>(xls)</b> sesuai dengan contoh template yang sudah ada</li>
                                <li>Pastikan anda tidak menambah/mengedit <b>kolom yang berwarna hitam</b></li>

                            </ol>
                        </div> 

                        <?
                        $totaldata=0;
                        while ($set->nextRow())
                        {
                            $reqFormUjiId= $set->getField("FORM_UJI_ID");
                            $reqKelompokEquipmentId= $set->getField("KELOMPOK_EQUIPMENT_ID");
                           
                            $reqNamaFormUji= $set->getField("NAMA");
                            $reqNamaKelompok= $set->getField("NAMA_KELOMPOK");

                            ?>
                            <div class='form-group'>
                                <div class='col-md-12'>

                                    <div class="page-header">
                                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$reqNamaKelompok?></h3>       
                                    </div>

                                    <table class="table table-bordered table-striped table-hovered" style="width: 100%">
                                        <thead>
                                            <tr>
                                                 <th colspan="5"  style="text-align: center"><?=$reqNamaFormUji?></th>
                                            </tr>
                                            <tr>
                                              <th style="width: 50%" >Tipe Pengukuran</th>
                                              <th>Nama Tabel</th>
                                              <th>Link Template</th>
                                              <th>Preview Tabel</th>
                                              <th>Upload</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $tipe= new PlanRla();
                                            $statement = " AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
                                            $tipe->selectByParamsPlanRlaFormUjiTemplatePengukuran(array(), -1, -1, $statement);
                                            // echo $tipe->query;
                                            while ($tipe->nextRow())
                                            {
                                                $reqNamaPengukuran= $tipe->getField("NAMA");
                                                $reqNamaTabel= $tipe->getField("NAMA_TABEL");
                                                $reqTabelId= $tipe->getField("TABEL_TEMPLATE_ID");
                                                $reqPengukuranId= $tipe->getField("PENGUKURAN_ID");
                                                $reqTipeInputId= $tipe->getField("TIPE_INPUT_ID");
                                                $reqPengukuranTipeInputId= $tipe->getField("PENGUKURAN_TIPE_INPUT_ID");
                                            ?>
                                            <tr>
                                                <td style="width: 50%"><?=$reqNamaPengukuran?></td>
                                                <td><?=$reqNamaTabel?></td>
                                                <td style="text-align: center"><span style="background-color: green;padding: 8px; border-radius: 5px;"><a onclick="cetak_excel('<?=$reqId?>','<?=$reqFormUjiId?>','<?=$reqPengukuranId?>','<?=$reqTabelId?>','<?=$reqKelompokEquipmentId?>','<?=$reqPengukuranTipeInputId?>')"><i class="fa fa-download fa-lg" style="color: white;" aria-hidden="true"></i></a></span></td>
                                                <td ><a href="app/index/master_template_tabel_preview?reqId=<?=$reqTabelId?>" target="_blank">Link</a></td>
                                                <td style="text-align: center"><input type="file" accept=".xls" name="reqLinkFile[]"></td>
                                                <input type="hidden" name="reqId" value="<?=$reqId?>" />
                                                <input type="hidden" name="reqTabelId[]" value="<?=$reqTabelId?>" />
                                                <input type="hidden" name="reqPengukuranId[]" value="<?=$reqPengukuranId?>" />
                                                <input type="hidden" name="reqFormUjiId[]" value="<?=$reqFormUjiId?>" />
                                                <input type="hidden" name="reqTipeInputId[]" value="<?=$reqTipeInputId?>" />
                                                <input type="hidden" name="reqKelompokEquipmentId[]" value="<?=$reqKelompokEquipmentId?>"
                                                 />
                                                <input type="hidden" name="reqPengukuranTipeInputId[]" value="<?=$reqPengukuranTipeInputId?>"
                                                 />
                                            </tr>
                                            <?
                                            }
                                            ?>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <?
                            $totaldata++;
                        }
                        ?>
                    </div>

                    <?
                    if($totaldata > 0)
                    {
                    ?>
                    <div style="text-align:center;padding:5px">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Upload</a>
                    </div> 
                    <?
                    }
                    else
                    {
                    ?>
                     <div class="page-header" style="text-align: center;background-color: #fe1414;margin-top: 150px">
                        <h3> Data Form Uji belum di isi</h3>       
                    </div>
                    <?
                    }
                    ?>
                </div> 
            </form>

        </div>


    </div>
</div>

</div>

<script type="text/javascript">
function cetak_excel(reqId,reqFormUjiId,reqPengukuranId,reqTabelId,reqKelompokEquipmentId,reqPengukuranTipeInputId)
{
    
    urlExcel = 'json-app/form_uji_template_dinamis_json/template_dinamis_plan_rla?reqId='+reqId+'&reqFormUjiId='+reqFormUjiId+'&reqPengukuranId='+reqPengukuranId+'&reqTabelId='+reqTabelId+'&reqKelompokEquipmentId='+reqKelompokEquipmentId+'&reqPengukuranTipeInputId='+reqPengukuranTipeInputId;
    // console.log(urlExcel);
    newWindow = window.open(urlExcel, 'Cetak');
    newWindow.focus();
} 

</script>

</body>
</html>