<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$pgreturn= str_replace("_add", "", $pg);

$this->load->model("base-app/TipeInput");


$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));



$link="app/loadUrl/app/master_pengukuran_template";

$set= new TipeInput();
$arrtipe= [];
$set->selectByParamsCombo(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("TIPE_INPUT_ID");
    $arrdata["idpeng"]= str_replace(" ", "", $set->getField("TIPE_PENGUKURAN_ID"));
    $arrdata["idtipe"]= $set->getField("TIPE_INPUT_ID")."-".$set->getField("TIPE_PENGUKURAN_ID");
    $arrdata["nama"]= $set->getField("NAMA_TIPE_PENGUKURAN");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrtipe, $arrdata);
}
unset($set);


?>

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Master <?=$pgtitle?> </a> &rsaquo; Form Import</div>

    <div class="konten-area">
        <div class="konten-inner">
            <div>
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                         <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-10 col-sm-12" style="font-size: 18px">Pastikan data import format <b>(xls)</b> sesuai dengan contoh template yang sudah ada</label>
                            </div>
                            <br>
                            <div class="form-group">  
                                <label class="control-label col-md-4">Pilih Tipe</label>
                                <div class='form-group row'>
                                    <div class='col-md-5'>
                                        <select class="form-control jscaribasicmultiple"  <?=$disabled?> id="reqTipePengukuran"  style="width:100%;">
                                            <option value="">Pilih Tipe</option>
                                            <?
                                            foreach($arrtipe as $item) 
                                            {
                                                $selectvalid= $item["id"];
                                                $selectvalidpeng= $item["idpeng"];
                                                $selectvaltext= $item["text"];

                                                $selected="";
                                                if($selectvalid==$reqTipeInputId)
                                                {
                                                    $selected="selected";
                                                }
                                                ?>
                                                <option value="<?=$selectvalidpeng?>" <?=$selected?>><?=$selectvaltext?></option>
                                                <?
                                            }
                                            ?>
                                        </select>
                                        <input autocomplete="off" type="hidden" name="reqTipeInputId"  id="reqTipeInputId" value="<?=$reqTipeInputId?>" style="width:100%" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" id="template">
                                
                            </div>
                            <br>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-4 col-sm-12" style="font-size: 15px;">File :</label>
                                <input type="file" name="reqLinkFile" id="reqLinkFile" class="easyui-validatebox" accept="application/vnd.ms-excel" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqSuperiorId" value="<?=$reqSuperiorId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqTipePengukuranid" id="reqTipePengukuranid"; value="" />

                </form>
            </div>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

            </div>
        </div>
    </div>
</div>

<script>

$('#reqTipePengukuran').on('change', function() {
    $('#template').html('');
    var reqTipePengukuranid=this.value;
    $('#reqTipePengukuranid').val(reqTipePengukuranid);
    var reqTipePengukuranText = $("#reqTipePengukuran option:selected").text();
    var reqTipePengukuranText = encodeURIComponent(reqTipePengukuranText);

    var  link="app/loadUrl/app/master_pengukuran_template?reqTipePengukuranid="+reqTipePengukuranid+"&reqTipePengukuranText="+reqTipePengukuranText;
    // console.log(link);

    if (reqTipePengukuranid=='3') 
    {
        var mySecondDiv=$("<label class='col-form-label text-right col-lg-6 col-sm-12' style='font-size: 15px; color:red;'>Tipe "+reqTipePengukuranText+" Tidak dapat Import.</label>");
        document.getElementById("reqLinkFile").disabled = true;
    }
    else
    {
        var mySecondDiv=$("<label class='col-form-label text-right col-lg-6 col-sm-12' style='font-size: 15px'>Contoh Template <a class='link-button' href="+link+" target='_blank'><img src='images/icon-download.png' width='15' height='15' /> Download </a></label>");
        document.getElementById("reqLinkFile").disabled = false;
    }
    $('#template').append(mySecondDiv);
  
});

function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/import_json/pengukuran',
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

            if(reqId == 'xxx')
                $.messager.alert('Info', infoSimpan, 'warning');
            else
                $.messager.alert('Info', infoSimpan ,null,function(){
                    top.location.href= "app/index/master_pengukuran";
                });
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>