<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/FormUji");
$this->load->model("base-app/Nameplate");
$this->load->model("base-app/FormUjiTipe");
$this->load->model("base-app/Pengukuran");
$this->load->model("base-app/PlanRlaFormUjiDinamis");
$this->load->model("base-app/Crud");
$this->load->model("base-app/KelompokEquipment");
$this->load->model("base-app/MeasuringTools");
$this->load->library('globalfunc');

$appuserkodehak= $this->appuserkodehak;
$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");

$set= new FormUji();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND A.FORM_UJI_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("FORM_UJI_ID");
    $reqKode= $set->getField("KODE");
    $reqNama= $set->getField("NAMA");
    $reqStatus= $set->getField("STATUS");
    $reqNameplateId=  $set->getField("NAMEPLATE_ID");
    $reqMeasuringToolsId=  $set->getField("MEASURING_TOOLS_ID");
    $reqTipeId= getmultiseparator($set->getField("FORM_UJI_PENGUKURAN_ID_INFO"));
    // print_r( $reqTipeId);exit;
    $reqNameplateGambar=  $set->getField("LINK_GAMBAR");
    $reqEquipmentId= getmultiseparator(str_replace(" ", "", $set->getField("FORM_UJI_KELOMPOK_EQUIPMENT_ID_INFO")));

    $reqKodeUnique= $reqId."_".$reqKode;
    // print_r($reqEquipmentId);exit;

    unset($set);

    $reqTipeString = implode(',',array_unique( $reqTipeId));
    $checkvalidasi= new PlanRlaFormUjiDinamis();

    $arrvalidasi= [];

    $statement = "  AND A.FORM_UJI_ID = '".$reqId."' AND A.PENGUKURAN_ID IN (".$reqTipeString.")";
    $checkvalidasi->selectByParamsValidasiPengukuran(array(), -1, -1, $statement);
    // echo  $checkvalidasi->query;exit;
    while($checkvalidasi->nextRow())
    {
        $arrdata= $checkvalidasi->getField("PENGUKURAN_ID");      
        array_push($arrvalidasi, $arrdata);
    }
    // print_r($arrvalidasi);exit;

    $set= new FormUji();
    $arrformnameplate= [];

    $statement = " AND A.NAMEPLATE_ID=".$reqNameplateId." AND A.FORM_UJI_ID=".$reqId."";
    $set->selectByParamsNameplate(array(), -1, -1, $statement);
    // echo  $set->query;exit;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("FORM_UJI_NAMEPLATE_ID");
        $arrdata["NAMEPLATE_DETIL_ID"]= $set->getField("NAMEPLATE_DETIL_ID");
        $arrdata["MASTER_ID"]= $set->getField("MASTER_ID");
        $arrdata["NAMA"]= $set->getField("NAMA");
        $arrdata["NAMA_NAMEPLATE"]= $set->getField("NAMA_NAMEPLATE");
        $arrdata["NAMA_TABEL"]= $set->getField("NAMA_TABEL");
        $arrdata["STATUS"]= $set->getField("STATUS");

        array_push($arrformnameplate, $arrdata);
    }
    // print_r($arrformnameplate);exit;

    $checkarrnameplate= array_filter($arrformnameplate[0]);
    unset($set);

    $set= new Pengukuran();
    $arrformujitipe= [];

    $statement = "";
    $set->selectByParamsComboPengukuran(array(), -1, -1, $statement);
    // echo  $set->query;exit;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("PENGUKURAN_ID");
        $arrdata["text"]= $set->getField("NAMA");
        array_push($arrformujitipe, $arrdata);
    }
    unset($set);

    
}

$vgl= new globalfunc();
$arrequipment= $vgl->getkelompokequipmenttree([]);
    // print_r($arrequipment);exit;

$set= new MeasuringTools();
$arrmeasuring= [];

$statement = "";
$set->selectByParams(array(), -1, -1, $statement);
    // echo  $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("MEASURING_TOOLS_ID");
    $arrdata["text"]= $set->getField("KODE")." - ".$set->getField("NAMA");
    array_push($arrmeasuring, $arrdata);
}

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
$disabled="";

$set= new Crud();
$statement=" AND KODE_MODUL ='0204'";
$kode= $appuserkodehak;
$set->selectByParamsMenus(array(), -1, -1, $statement, $kode);
// echo $set->query;exit;
$set->firstRow();
$reqMenu= $set->getField("MENU");
$reqCreate= $set->getField("MODUL_C");
$reqRead= $set->getField("MODUL_R");
$reqUpdate= $set->getField("MODUL_U");
$reqDelete= $set->getField("MODUL_D");

if($reqLihat ==1 )
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


</style>

<!--  <script language="javascript" type="text/javascript" src="assets/tiny_mce/tiny_mce.js"></script>
 <script language="javascript" type="text/javascript" src="assets/tiny_mce/configTextEditorAdm.js"></script>  -->
 <script language="javascript" type="text/javascript" src="assets/editors/ckeditor/ckeditor.js"></script>

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
                    <ul class="nav nav-pills mr-auto">
                       <!--  <li class="nav-item  ">
                            <a  class="nav-link  " data-toggle="tab" href="#nameplate"> &nbsp;Nameplate</a>
                        </li>  -->
                        <li class="nav-item active" >
                            <a class="nav-link active  " data-toggle="tab" href="#formuji"> &nbsp;Form Uji</a>
                        </li>
                    </ul>
                    <hr style="height:0.3px;border:none;color:#333;background-color:#333;">
                <div class="tab-content">
                    <div id="formuji" class="tab-pane fade in active ">
                        <div class="page-header">
                            <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Kode Unique</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" <?=$disabled?> class="easyui-validatebox textbox form-control" type="text" value="<?=$reqKodeUnique?>" disabled style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div>
                                                                                 
                        <div class="form-group">  
                            <label class="control-label col-md-2">Kode Form Uji</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" <?=$disabled?> class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" required style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Nama Form Uji</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" <?=$disabled?> class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" required style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Status</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <input   name="reqStatus"  <?=$disabled?> class="easyui-combobox form-control" id="reqStatus"
                                        data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combostatusaktifdraft'" value="<?=$reqStatus?>" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?
                        if(!empty($reqId))
                        {
                            ?>
                            <div class="form-group">  
                                <label class="control-label col-md-2">Tipe Pengukuran</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
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
                            </div>

                            <div class="form-group">  
                                <label class="control-label col-md-2">Measuring Tools</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <select class="form-control jscaribasicmultiple" id="reqMeasuringToolsId" <?=$disabled?> name="reqMeasuringToolsId" style="width:100%;" >
                                                <?
                                                foreach($arrmeasuring as $item) 
                                                {
                                                    $selectvalid= $item["id"];
                                                    $selectvaltext= $item["text"];

                                                    $selected="";
                                                    if($selectvalid == $reqMeasuringToolsId)
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

                            <!-- <div class="form-group">  
                                <label class="control-label col-md-2">Measuring Tools</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <input  <?=$disabled?>  name="reqMeasuringToolsId" class="easyui-combobox form-control" id="reqMeasuringToolsId"
                                            data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combomeasuring'" value="<?=$reqMeasuringToolsId?>" />
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="form-group">  
                                <label class="control-label col-md-2">Kelompok Equipment</label>
                                <div class='col-md-8'>
                                    <div class='form-group'>
                                        <div class='col-md-11'>
                                            <select class="form-control" id="reqEquipmentId" <?=$disabled?> required name="reqEquipmentId[]" style="width:100%;" multiple="multiple">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?
                        }
                        ?>

                        <div id="tabel">
                            <div id="tabelgenerate">
                               
                            </div>
                        </div>
              
               
                        <?
                        if($reqLihat ==1)
                        {}
                        else
                        {
                            ?>
                            <div style="text-align:center;padding:5px">
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>
                                <span id="cetak">

                                   <!--  <a href="javascript:void(0)" class="btn btn-danger" onclick="cetak_pdf()"><i class="fa fa-file-pdf"></i> Cetak PDF</a>  -->
                               </span>

                           </div>   
                           <?
                       }
                       ?>
            
                  
                    </div>
                   
                </div>

                <input type="hidden" name="reqId" value="<?=$reqId?>" />
                <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                <input type="hidden" id="reqDetilValid" value="" />

                </form>

            </div>
            
        </div>
    </div>
    
</div>

<script>


    $(document).on('keydown', '#reqKode', function(e) {
        if (e.keyCode == 32) return false;
    });

$('#gambar_nameplate').hide();

var reqNameplateCheck =$('#reqNameplateId').val();
// console.log(reqNameplateCheck);
if(reqNameplateCheck)
{
    $('#gambar_nameplate').show();
}

$('#reqNameplateId').on('change', function() {
    var reqNameplateId=this.value;
    $('#kolom_nameplate').html('');
    if(reqNameplateId)
    {
        $('#gambar_nameplate').show();

        $.get("app/loadUrl/app/template_nameplate_form_uji?reqNameplateId="+reqNameplateId, function(data) {   
            $("#kolom_nameplate").append(data);
        });
    }
});

var reqTipe =$('#reqTipeId').val();
var reqId ='<?=$reqId?>';

$(document).ready(function() {
    arrequipment= JSON.parse('<?=JSON_encode($arrequipment)?>');
    // console.log(arrequipment);

    $("#reqEquipmentId").select2ToTree({treeData: {dataArr: arrequipment}, placeholder: 'Pilih salah satu data'});
    // , maximumSelectionLength: 3
    // , dftVal:"<?=$reqEquipmentId?>"
    reqEquipmentId= JSON.parse('<?=JSON_encode($reqEquipmentId)?>');
    // console.log(reqEquipmentId);
    $('#reqEquipmentId').val(reqEquipmentId).trigger('change');

    setTimeout(
        function()
        {  
            kondisiTipe(reqTipe);
            function kondisiTipe(reqTipe){
                if(reqTipe)
                {
                    jQuery.each(reqTipe, function(index, value) 
                    {
                        $.ajax({  
                            type: "GET",
                            // async: false,                                    
                            url: "app/loadUrl/app/master_form_uji_tabel?reqTipePengukuranId="+reqTipe+"&reqId=<?=$reqId?>&reqLihat=<?=$reqLihat?>",
                            beforeSend: function(){

                            },
                            success: function(data)          
                            {
                                // replace ajax page content
                                $('#tabelgenerate').empty();   
                                $("#tabelgenerate").append(data);

                            },
                            complete: function() {
                                // for(k in CKEDITOR.instances){
                                //     var instance = CKEDITOR.instances[k];
                                //     instance.destroy()
                                // }
                                // CKEDITOR.replaceAll();
                            }
                        });
                    });
                }
            };
        }, 400);



    var tipe = $("#reqTipeId");
        tipe.on("select2:select", function(event) {
          var values = [];
          // var t = setTimeout(function() {
          //    for(k in CKEDITOR.instances){
          //       var instance = CKEDITOR.instances[k];
          //       instance.destroy()
          //   }
          //   CKEDITOR.replaceAll();
          //   clearTimeout(t);
          //   }, 300);
           $(event.currentTarget).find("option:selected").each(function(i, selected){ 
            values[i] = selected.value;

        });
        jQuery.each(values, function(index, value) {
            $.get("app/loadUrl/app/master_form_uji_tabel?reqTipePengukuranId="+values+"&reqId=<?=$reqId?>&reqLihat=<?=$reqLihat?>&reqRead=<?=$reqRead?>", function(data) {
                // $("#tabelgenerate tr").remove();
                $('#tabelgenerate').empty();   
                $("#tabelgenerate").append(data);
                
                // tinymceinit();
            });

            $.ajax({
                type: 'POST',
                url: 'json-app/form_uji_json/simpan_tipe',
                data:'reqId=<?=$reqId?>&reqTipePengukuranId='+values,
                beforeSend: function () {
                },
                success: function (data) {
                   //  console.log(data);return false;
                   // location.reload();
                }
            });
            
        });
    });

    $('#reqTipeId').on("select2:unselecting", function(e){
       var value = e.params.args.data.id;
       var keterangan = e.params.args.data.text;
       var ids = $('[id=divpengukuran' + value + ']');

       // var reqPengukuranId =$('#reqPengukuranId').val();
       var reqPengukuranId =<? echo json_encode($reqTipeId); ?>;
       reqPengukuranId = $.map(reqPengukuranId, function(nilai){
          return nilai.replace(/ /g, '');
        });
       

        var validasipengukuran= <?php echo json_encode($arrvalidasi); ?>;
        // var reqFormDetilId ="";
        $(".iddetil").each(function(){
            reqFormDetilId =$(this).val();
            // console.log(reqFormDetilId)
            // $('#reqDetilValid').val($(this).val());
        });

        var ada = "";
        if(jQuery.inArray(value, reqPengukuranId) != -1) {
            var ada = 1;
        } else {
            var ada = 0;
        } 

         // console.log(reqFormDetilId);

       if(ada !==1 || reqFormDetilId=="" )
       {
             ids.remove();
       }
       else
       {

            if(jQuery.inArray(value, validasipengukuran) != -1) {
                $.messager.alert('Info', 'Pengukuran '+keterangan+' tidak bisa dihapus, Karena sudah dipakai di RLA', 'info');return false;
            } else {
                $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
                    if (r){
                        $.getJSON("json-app/form_uji_json/deletepengukuran/?reqPengukuranId="+value+"&reqId=<?=$reqId?>",
                            function(data){
                                $.messager.alert('Info', data.PESAN, 'info');
                                ids.remove();

                                location.reload();

                            });
                    }
                });
            } 
            
        }

    }).trigger('change');

});

function submitForm(){
    // tinyMCE.triggerSave();
    $('#ff').form('submit',{
        url:'json-app/form_uji_json/add',
        onSubmit:function(event){

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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/master_form_uji_add?reqId="+reqId);
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}  

function cetak_excel()
{
    reqTipe= $('#reqTipeId').val();
    // console.log(reqTipe);

    url="";
    
    if (reqTipe=='1' || reqTipe=='2') 
    {
        url= 'ir_pi';
    }
    else if (reqTipe=='4') 
    {
        url= 'sfra';
    }


    urlExcel = 'json-app/form_uji_cetak_json/'+url+'/?reqId='+reqId+'&reqTipe='+reqTipe;
    // console.log(urlExcel);
    newWindow = window.open(urlExcel, 'Cetak');
    newWindow.focus();
} 

function cetak_word(){
 
} 

function cetak_pdf()
{
    reqTipe= $('#reqTipeId').val();
    reqNameplateId= $('#reqNameplateId').val();

    reqMode='';
    
    if (reqTipe=='1' || reqTipe=='2') 
    {
        reqMode= 'irpi_after_before';
    }
    else if (reqTipe=='4') 
    {
        reqMode= 'sfra';
    }
    

    openAdd('app/loadUrl/report/cetak_pdf?reqId=<?=$reqId?>&reqTipe='+reqTipe+'&reqMode='+reqMode+'&reqNameplateId='+reqNameplateId);
}

function HapusBaris(pengukuranid,tipeid,tabelid) {
    $("#tabelpengukuran"+pengukuranid+"-"+tipeid+"-"+tabelid).on("click", ".btn-remove", function(){
        $(this).closest('tr').remove();
    });
}


function AddBaris(pengukuranid,tipeid,tabelid) {
    $.get("app/loadUrl/app/template_form_uji_tabel_add?reqTipePengukuranId="+pengukuranid+"&reqTabelId="+tabelid, function(data) { 
        $("#tabelpengukuran"+pengukuranid+"-"+tipeid+"-"+tabelid).append(data);
    });
}
   

function HapusDetil(iddetil,status,tipe) {
    var Id ='<?=$reqId?>';
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/form_uji_json/deletedetail/?reqFormDetilId="+iddetil+"&reqId="+Id+"&reqPengukuranId="+tipe+"&reqStatus="+status,
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');                    
                    location.reload();
                });
        }
    }); 
}


function HapusGambar(iddetil,form,tipe) {
    // console.log(tipe);
    var Id ='<?=$reqId?>';
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/form_uji_json/deletegambar/?reqDetilId="+iddetil+"&reqId="+Id+"&reqTipeId="+tipe,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    $("#"+form+"-"+iddetil+"").remove();
                });
        }
    }); 
}

$(document).ready(function() {
    $(".nav-link").on("click", function(){
     $(".nav-link.active").removeClass("active");
     $(this).addClass("active");
 });
});

function import_nameplate() {
    var nameplateid= $("#reqNameplateId").val();
    if(nameplateid == "")
    {
        $.messager.alert('Info', "Pilih salah satu Nameplate terlebih dahulu.", 'warning');
        return false;
    }
    openAdd("app/index/master_form_uji_import_nameplate?reqId=<?=$reqId?>&reqNameplateId="+nameplateid);
}

function import_tipe(pengukuranid,tabelid,pengukurantipe,tipeinputid) {
    openAdd("app/index/master_form_uji_import_tipe?reqId=<?=$reqId?>&reqPengukuranId="+pengukuranid+"&reqTabelId="+tabelid+"&reqTipePengukuranId="+pengukurantipe+"&reqTipeInputId="+tipeinputid);
}
</script>