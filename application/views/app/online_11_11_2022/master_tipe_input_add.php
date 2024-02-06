<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/TipeInput");
$this->load->model("base-app/TipePengukuran");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");

$set= new TipeInput();

if($reqId == "")
{
    $reqMode = "insert";
    $reqTipe="External";
}
else
{
    $reqMode = "update";

	$statement = " AND A.TIPE_INPUT_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("TIPE_INPUT_ID");
    $reqNama= $set->getField("NAMA");
    $reqStatus= $set->getField("STATUS");
    $reqFunction= $set->getField("FUNCTION_INPUT");
    $reqKeterangan= $set->getField("KETERANGAN");
    $reqStatusTabel= $set->getField("STATUS_TABLE");
    $reqTipePengukuran= getmultiseparator($set->getField("TIPE_PENGUKURAN_ID_INFO"));
    $reqStatusTable= $set->getField("STATUS_TABLE");

}

$set= new TipePengukuran();
$arrtipe= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("TIPE_PENGUKURAN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrtipe, $arrdata);
}
unset($set);

$disabled="";


if($reqLihat ==1)
{
    $disabled="disabled";  
}


?>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">

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
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Tipe </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" data-options="required:true" style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Status</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input  name="reqStatus" class="easyui-combobox form-control" id="reqStatus"
                                    data-options="width:'100',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combostatusaktif'" value="<?=$reqStatus?>" required <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Function Input</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqFunction"  id="reqFunction" value="<?=$reqFunction?>" style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Keterangan</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKeterangan"  id="reqKeterangan" value="<?=$reqKeterangan?>" style="width:100%"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                   <!--  <div class="form-group">  
                        <label class="control-label col-md-2">Tipe</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple" id="reqTipePengukuran" <?=$disabled?> name="reqTipePengukuran[]" style="width:100%;" multiple="multiple">
                                    <?
                                    foreach($arrtipe as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if(in_array($selectvalid, $reqTipePengukuran))
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
                    </div> -->

                    <div class="form-group">  
                        <label class="control-label col-md-2">Status </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                <input type="radio" id="reqStatusTable" name="reqStatusTable" value="PIC" <?if($reqStatusTable=='PIC'){?>checked<?}?>><label style="margin-left: 10px;">Gambar</label><br>
                                <input type="radio" id="reqStatusTable" name="reqStatusTable" value="TEXT" <?if($reqStatusTable=='TEXT'){?>checked<?}?>><label style="margin-left: 10px;">Teks</label><br>
                                <input type="radio" id="reqStatusTable" name="reqStatusTable" value="TABLE" <?if($reqStatusTable=='TABLE'){?>checked<?}?>><label style="margin-left: 10px;">Tabel</label>
                                <br>
                                <input type="radio" id="reqStatusTable" name="reqStatusTable" value="ANALOG" <?if($reqStatusTable=='ANALOG'){?>checked<?}?>><label style="margin-left: 10px;">Analog</label>
                                <br>
                                <input type="radio" id="reqStatusTable" name="reqStatusTable" value="BINARY" <?if($reqStatusTable=='BINARY'){?>checked<?}?>><label style="margin-left: 10px;">Binary</label>

                                </div>
                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

                </form>

            </div>
            <?
            if($reqLihat ==1)
            {}
            else
            {
            ?>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

            </div>
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script>
function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/tipe_input_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>