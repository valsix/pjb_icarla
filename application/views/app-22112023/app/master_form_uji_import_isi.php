<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$pgreturn= str_replace("_add", "", $pg);

$this->load->model("base-app/Nameplate");
$this->load->model("base-app/FormUjiTipe");

$reqId = $this->input->get("reqId");


$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));


$link="app/loadUrl/app/master_form_uji_template_isi";
$set= new Nameplate();
$arrnameplate= [];
$statement = "";
$set->selectByParams(array(), -1, -1, $statement);
// echo  $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("NAMEPLATE_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");

    array_push($arrnameplate, $arrdata);
}

unset($set);

$set= new FormUjiTipe();
$arrformujitipe= [];

$statement = "";
$set->selectByParams(array(), -1, -1, $statement);
    // echo  $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("FORM_UJI_TIPE_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrformujitipe, $arrdata);
}

unset($set);


?>

<style type="text/css">
.select2-container--default .select2-selection--multiple .select2-selection__choice {
  color: #000000;
}
.select2-container--default .select2-search--inline .select2-search__field:focus {
  outline: 0;
  border: 1px solid #ffff;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__display {
  cursor: default;
  padding-left: 6px;
  padding-right: 5px;
}


</style>

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
                                <label class="control-label col-md-4">Pilih Nameplate</label>
                                <div class='form-group row'>
                                    <div class='col-md-5'>
                                        <select class="form-control jscaribasicmultiple" name='reqNameplateId'  id='reqNameplateId' style="width:100%;" >
                                            <option value="">Pilih Nameplate</option>
                                            <?
                                            foreach($arrnameplate as $item) 
                                            {
                                                $selectvalid= $item["id"];
                                                $selectnama=$item["NAMA"];
                                                $selected="";
                                                if($reqNameplateId==$selectvalid)
                                                {
                                                    $selected="selected";
                                                }
                                                ?>
                                                <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectnama?></option>
                                            <?
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">  
                                <label class="control-label col-md-4">Tipe</label>
                                <div class='form-group row'>
                                    <div class='col-md-8'>
                                        <select class="form-control jscaribasicmultiple" id="reqTipeId" <?=$disabled?> name="reqTipeId[]" style="width:100%;" multiple="multiple">
                                                <?
                                                foreach($arrformujitipe as $item) 
                                                {
                                                    $selectvalid= $item["id"];
                                                    $selectvaltext= $item["text"];

                                                    $selected="";
                                                    if(in_array($selectvalid, $reqTipeId))
                                                    {
                                                        $selected="selected";
                                                    }
                                                    ?>
                                                    <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                                    <?
                                                }
                                                ?>
                                            </select>
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

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
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

    var tipe = $("#reqTipeId");
        tipe.on("select2:select", function(event) {
          var values = [];
          $(event.currentTarget).find("option:selected").each(function(i, selected){ 
            values[i] = selected.value;
        });
        var reqTipeId = values.join(",");
        // var reqTipeId = encodeURIComponent(reqTipeId);
        var reqNameplateId= $('#reqNameplateId').val();
        $('#template').html('');
        var reqTipeText='';
        var  link="app/loadUrl/app/master_form_uji_template_isi?reqTipeId="+reqTipeId+"&reqNameplateId="+reqNameplateId+"&reqId=<?=$reqId?>";
        console.log(reqTipeId);
        var mySecondDiv=$("<label class='col-form-label text-right col-lg-6 col-sm-12' style='font-size: 15px'>Contoh Template <a class='link-button' href="+link+" target='_blank'><img src='images/icon-download.png' width='15' height='15' /> Download </a></label>");
        $('#template').append(mySecondDiv);

      });

    $('#reqTipeId').on("select2:unselecting", function(e){
       var check= $('#reqTipeId').val();
       //  console.log( check);
       // var reqTipeId = e.params.args.data.id;
       // var reqTipeText='';
       // $('#template').html('');
       // var  link="app/loadUrl/app/master_form_uji_template_isi?reqTipeId="+reqTipeId+"&reqTipeText="+reqTipeText;
       // var mySecondDiv=$("<label class='col-form-label text-right col-lg-6 col-sm-12' style='font-size: 15px'>Contoh Template <a class='link-button' href="+link+" target='_blank'><img src='images/icon-download.png' width='15' height='15' /> Download </a></label>");
       // $('#template').append(mySecondDiv);
       // console.log(link);
     }).trigger('change');


function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/import_json/form_uji_isi',
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
                    top.location.href= "app/index/master_form_uji";
                });
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>