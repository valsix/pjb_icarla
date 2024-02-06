<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Pengukuran");
$this->load->model("base-app/JenisPengukuran");
$this->load->model("base-app/TipeInput");
$this->load->model("base-app/GroupState");
$this->load->model("base-app/Uom");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new Pengukuran();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.PENGUKURAN_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PENGUKURAN_ID");
    // $reqJenisPengukuran= array(1,2);
    // print_r($reqJenisPengukuran);exit;
    $reqJenisPengukuran= getmultiseparator($set->getField("JENIS_PENGUKURAN_INFO"));
    // print_r($reqJenisPengukuran);exit;
    $reqEnjiniringId= $set->getField("ENJINIRINGUNIT_ID");
    $reqGroupId= $set->getField("GROUP_STATE_ID");
    $reqNama= $set->getField("NAMA");
    $reqNamaPengukuran= $set->getField("NAMA_PENGUKURAN");
    $reqKode= $set->getField("KODE");
    $reqTipeInputId= $set->getField("TIPE_INPUT_ID");
    $reqFormula= $set->getField("FORMULA");
    $reqStatusPengukuran= $set->getField("STATUS_PENGUKURAN");
    $reqCatatan= $set->getField("CATATAN");
    $reqSequence= $set->getField("SEQUENCE");
    $reqIsInterval= $set->getField("IS_INTERVAL");
    $reqStatus= $set->getField("STATUS");
    $reqTipePengukuran= getmultiseparator($set->getField("TIPE_PENGUKURAN_ID_INFO"));
    $reqAnalog= dotToComma($set->getField("ANALOG"));
    $reqText= $set->getField("TEXT_TIPE");
    $reqLinkFile= $set->getField("LINK_FILE");
    $reqGroupState= $set->getField("GROUP_STATE_ID");
    $reqUomId= $set->getField("UOM_ID");


}

$set= new JenisPengukuran();
$arrjenjang= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("JENIS_PENGUKURAN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrjenjang, $arrdata);
}
unset($set);

$set= new TipeInput();
$arrtipe= [];
$set->selectByParamsCombo(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("TIPE_INPUT_ID");
    $arrdata["idpeng"]= $set->getField("TIPE_PENGUKURAN_ID");
    $arrdata["idtipe"]= $set->getField("TIPE_INPUT_ID")."-".$set->getField("TIPE_PENGUKURAN_ID");
    $arrdata["nama"]= $set->getField("NAMA_TIPE_PENGUKURAN");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrtipe, $arrdata);
}
unset($set);


$set= new GroupState();
$arrgroup= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("GROUP_STATE_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrgroup, $arrdata);
}
unset($set);

$set= new Uom();
$arruom= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("UOM_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arruom, $arrdata);
}
unset($set);

$disabled="";


if($reqLihat ==1)
{
    $disabled="disabled";  
}



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

.select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}


</style>

<script src='assets/multifile-master/jquery.form.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MetaData.js' type="text/javascript" language="javascript"></script> 
<script src='assets/multifile-master/jquery.MultiFile.js' type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" href="css/gaya-multifile.css" type="text/css">


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
                        <label class="control-label col-md-2">Kode Pengukuran</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" <?=$disabled?>  data-options="required:true" style="width:100%" />
                               </div>
                           </div>
                       </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Jenis Pengukuran</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple" id="reqJenisPengukuran" <?=$disabled?> name="reqJenisPengukuran[]" style="width:100%;" multiple="multiple" >
                                    <?
                                    foreach($arrjenjang as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if(in_array($selectvalid, $reqJenisPengukuran))
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
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Pengukuran</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNamaPengukuran"  id="reqNamaPengukuran" value="<?=$reqNamaPengukuran?>"  style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tipe Input</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple" id="reqTipePengukuran" <?=$disabled?> name="reqTipePengukuran[]" style="width:100%;">
                                    <?
                                    foreach($arrtipe as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvalidpeng= $item["idtipe"];
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
                    </div>


                    <div class="form-group">  
                        <label class="control-label col-md-2">Formula</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqFormula"  id="reqFormula" value="<?=$reqFormula?>" <?=$disabled?> style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="analog">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Analog</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <input autocomplete="off" class="easyui-validatebox textbox form-control allow_decimal" type="text" name="reqAnalog"  id="reqAnalog" value="<?=$reqAnalog?>" style="width:20%;display: inline;" />
                                        <select class="form-control jscaribasicmultiple" id="reqUomId" <?=$disabled?> name="reqUomId" style="width:20%;">
                                        <?
                                        foreach($arruom as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid==$reqUomId)
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
                       </div>
                    </div>

                    <div id="textbox">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Text</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <textarea id="reqText" <?=$disabled?> name="reqText" class="easyui-validatebox textbox form-control" style="width: 100%"><?=$reqText?></textarea>
                                   </div>
                               </div>
                           </div>
                       </div>
                    </div>
                    <div id="picture">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Gambar</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                      <input type="file" name="reqLinkFile" <?=$disabled?> accept="image/*">
                                      <?
                                      if(!empty($reqLinkFile))
                                      {
                                        ?>
                                        <br>
                                        <a href="<?=$reqLinkFile?>" target="_blank"><img src="images/icon-download.png"></a>
                                        <?
                                        if($reqLihat ==1)
                                        {}
                                        else
                                        {
                                            ?>
                                        <a onclick="delete_gambar()"><img src="images/delete-icon.png"></a>
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
                    </div>


                    <div id="binary">
                        <div class="form-group">  
                            <<label class="control-label col-md-2">Group State *) Instrument Type Binary</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <select class="form-control jscaribasicmultiple" id="reqGroupState" <?=$disabled?> name="reqGroupState" style="width:100%;" >
                                        <option value="" >Pilih Group State</option>
                                        <?
                                        foreach($arrgroup as $item) 
                                        {
                                            $selectvalid= $item["id"];
                                            $selectvaltext= $item["text"];

                                            $selected="";
                                            if($selectvalid==$reqGroupState)
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
                        </div>
                    </div>

                    <div id="status">
                        <div class="form-group">  
                            <label class="control-label col-md-2">Status Pengukuran</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <select name="reqStatusPengukuran" id="reqStatusPengukuran" class="easyui-validatebox textbox form-control" value="<?=$reqStatusPengukuran?>"  <?=$disabled?> >
                                            <option value=""></option>
                                            <option value="1"<?if($reqStatusPengukuran==1) echo 'selected' ?>>Normal</option>
                                            <option value="2"<?if($reqStatusPengukuran==2) echo 'selected' ?>>Alarm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Enjiniring Unit</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input  name="reqEnjiniringId" class="easyui-combobox form-control" id="reqEnjiniringId"
                                       data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/comboenjiniring'" value="<?=$reqEnjiniringId?>" <?=$disabled?>  />
                                   </div>
                               </div>
                           </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Catatan</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqCatatan"  id="reqCatatan" value="<?=$reqCatatan?>" <?=$disabled?> style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Sequence</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqSequence"  id="reqSequence" value="<?=$reqSequence?>" <?=$disabled?> style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div id="testnew"> -->
                        <div class="form-group">  
                            <label class="control-label col-md-2">Is Interval</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-5'>
                                        <select name="reqIsInterval" id="reqIsInterval"  <?=$disabled?> class="easyui-validatebox textbox form-control">
                                            <option value=""></option>
                                            <option value="1" <?if($reqIsInterval==1) echo 'selected' ?>>Y</option>
                                            <option value="2" <?if($reqIsInterval==2) echo 'selected' ?>>N</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Status</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <input   name="reqStatus" class="easyui-combobox form-control" id="reqStatus"
                                        data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combostatusaktif'" value="<?=$reqStatus?>" <?=$disabled?> required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->

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
$(document).ready(function(){

    $(".allow_decimal").on("input", function(evt) {
       var self = $(this);
       self.val(self.val().replace(/[^0-9\,]/g, ''));
       if ((evt.which != 46 || self.val().indexOf(',') != -1) && (evt.which < 48 || evt.which > 57)) 
       {
         evt.preventDefault();
       }
    });

    $('#textbox').hide();
    $('#picture').hide(); 
    // $('#testnew').hide();
    $('#status').hide();
    $('#binary').hide();
    $('#analog').hide();
    var str =$('#reqTipePengukuran').val();
    // console.log(str);
    var getInputId = str.split('-').slice(0,1);
    var str = str.substr(str.indexOf("-") + 1);
    var binary = str.indexOf('0') != -1;
    var analog = str.indexOf('1') != -1;
    var texttipe = str.indexOf('2') != -1;
    var pict = str.indexOf('3') != -1;
    var reqTipeInputId= getInputId[0];
    $('#reqTipeInputId').val(reqTipeInputId);
    if(binary==true)
    {
        $('#binary').show();  
        $('#status').show();
        $('#picture').hide(); 
        $('#textbox').hide();
    }
    if(analog==true)
    {
        $('#status').show();
        $('#analog').show();
        if(texttipe==false)
        {
            $('#textbox').hide(); 
        }
        $('#binary').hide();
        $('#picture').hide();
        $('#binary').hide(); 
    }
    if(texttipe==true)
    {
        if(pict==false)
        {
            $('#picture').hide(); 
        }
        if(analog==false)
        {
            $('#analog').hide(); 
        }
        $('#textbox').show(); 
        $('#status').show();
        $('#binary').hide();

    }
    if(pict==true)
    {
        if(texttipe==false)
        {
            $('#textbox').hide(); 
        }
        if(analog==false)
        {
            $('#analog').hide(); 
        }
        $('#picture').show();  
        $('#status').show();
        $('#binary').hide(); 
    }
    $('#reqTipePengukuran').change(function() { 
        var str =$('#reqTipePengukuran').val();
        var getInputId = str.split('-').slice(0,1);
        var str = str.substr(str.indexOf("-") + 1);

        var reqTipeInputId= getInputId[0];
       
        $('#reqTipeInputId').val(reqTipeInputId);
        var binary = str.indexOf('0') != -1;
        var analog = str.indexOf('1') != -1;
        var texttipe = str.indexOf('2') != -1;
        var pict = str.indexOf('3') != -1;
        if(binary==true)
        {
            $('#binary').show();  
            $('#status').show();
            $('#picture').hide(); 
            $('#textbox').hide();
            $('#analog').hide();
            $('#reqAnalog').val("");
            $('#reqText').val("");
         }
        if(analog==true)
        {
            $('#status').show();
            if(texttipe==false)
            {
                $('#textbox').hide(); 
            }
            $('#binary').hide();
            $('#picture').hide();
            $('#binary').hide();
            $('#analog').show(); 
            $('#reqText').val("");
            $('#reqGroupState').val("");
        }
        if(texttipe==true)
        {
            if(pict==false)
            {
                $('#picture').hide(); 
            }
            if(analog==false)
            {
                $('#analog').hide(); 
            }
            $('#textbox').show(); 
            $('#status').show();
            $('#binary').hide();
            
            $('#reqAnalog').val(""); 

        }
        if(pict==true)
        {
            if(texttipe==false)
            {
                $('#textbox').hide(); 
            }
            if(analog==false)
            {
                $('#analog').hide(); 
            }
            $('#picture').show();  
            $('#status').show();
            $('#binary').hide();
            $('#reqAnalog').val(""); 
            $('#reqText').val("");
        }  
    }); 

})

function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/pengukuran_json/add',
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

function delete_gambar()
{
    $.messager.confirm('Konfirmasi',"Hapus gambar?",function(r){
        if (r){
            $.getJSON("json-app/pengukuran_json/delete_gambar/?reqId=<?=$reqId?>",
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    valinfoid= "";
                    location.reload();
                });
        }
    }); 
} 
 
</script>