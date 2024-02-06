<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/TabelTemplate");
$this->load->model("base-app/PlanRlaFormUjiDinamis");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");
$kembali = $this->input->get("kembali");

$set= new TabelTemplate();
if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";
	$statement = " AND A.TABEL_TEMPLATE_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("TABEL_TEMPLATE_ID");
    $reqNama= $set->getField("NAMA");
    $reqTotal= $set->getField("TOTAL");
    $reqNoteAtas= $set->getField("NOTE_ATAS");
    $reqNoteBawah= $set->getField("NOTE_BAWAH");
    $reqStatus= $set->getField("STATUS");
    // var_dump($reqNoteAtas);exit;
}
unset($set);

$set= new TabelTemplate();
$statement = " AND A.TABEL_TEMPLATE_ID = '".$reqId."' ";
$set->selectByParamsMaxBaris(array(), -1, -1, $statement);
 // echo $set->query;exit; 
$set->firstRow();
$maxbaris= $set->getField("MAX");
unset($set);

$checkvalidasi= new PlanRlaFormUjiDinamis();
$statement = " AND A.TABEL_TEMPLATE_ID = ".$reqId."";

$arrvalidasi= [];
$checkvalidasi->selectByParamsDetil(array(), -1, -1, $statement);
// echo  $checkvalidasi->query;exit;
$checkvalidasi->firstRow();
$reqTabelValId= $checkvalidasi->getField("TABEL_TEMPLATE_ID");
// var_dump($reqTabelValId);
unset($checkvalidasiset);

$readonly="";
if(!empty($reqTabelValId))
{
    $readonly="readonly";
}                              

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
                        <label class="control-label col-md-2">Nama  </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" data-options="required:true" style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Total Kolom Isi </label>
                        <div class='col-md-2'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqTotal"  id="reqTotal" value="<?=$reqTotal?>" data-options="required:true" style="width:100%" <?=$disabled?> <?=$readonly?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Note Atas</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <textarea autocomplete="off" class="easyui-validatebox textbox form-control" name="reqNoteAtas"  id="reqNoteAtas"  style="width:100%"><?=$reqNoteAtas?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Note Bawah</label>
                        <div class='col-md-8'>
                            <div class='form-group'> 
                                <div class='col-md-11'>
                                    <textarea autocomplete="off" class="easyui-validatebox textbox form-control"  name="reqNoteBawah"  id="reqNoteBawah"  style="width:100%"><?=$reqNoteBawah?></textarea>
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
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combostatusdraft'" value="<?=$reqStatus?>"  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <?
                    if(!empty($reqId))
                    {

                    ?>

                    <div class="form-group">  
                        <div class='col-md-12'>
                            <div class="page-header">
                                <h3><i class="fa fa-file-text fa-lg"></i> Header Tabel</h3>       
                            </div>
                                <br>
                                <div id="header">
                                <?
                                if(!empty($maxbaris))
                                {
                                    for ($baris=1; $baris < $maxbaris + 1; $baris++) 
                                             
                                     // print_r($i);
                                    {
                                ?>      
                                        <?
                                        if(empty($reqTabelValId))
                                        {
                                        ?>
                                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTabelHeaderBarisEdit('<?=$baris?>')">Tambah Kolom</a>
                                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTabelHeader('<?=$baris?>')">Tambah Baris </a>
                                        <a href="javascript:void(0)" class="btn btn-danger" onclick="delete_data('<?=$baris?>','header','')">Hapus Semua Baris</a>
                                        <?
                                        }
                                        ?>
                                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align : middle;text-align:center;width: 35%">Kolom</th>
                                                    <th style="vertical-align : middle;text-align:center;width: 15%">Rowspan</th>
                                                    <th style="vertical-align : middle;text-align:center;width: 15%">Colspan</th>
                                                    <th style="vertical-align : middle;text-align:center;width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableInputHeader<?=$baris?>">

                                                <?
                                                $set= new TabelTemplate();

                                                $statement = "  AND A.TABEL_TEMPLATE_ID = '".$reqId."' AND B.BARIS = '".$baris."'";
                                                $set->selectByParamsDetil(array(), -1, -1, $statement);
                                                    // echo  $set->query;exit;
                                                while($set->nextRow())
                                                {
                                                   $reqDetilId= $set->getField("TABEL_DETIL_ID");
                                                   $reqBaris= $set->getField("BARIS");

                                                   $reqKolom= $set->getField("NAMA_TEMPLATE");
                                                   $reqRowspan= $set->getField("ROWSPAN");
                                                   $reqColspan= $set->getField("COLSPAN");


                                                ?>
                                                    <tr>
                                                        <td style="display: none">
                                                            <input class='easyui-validatebox textbox form-control' type='text' name='reqDetilId[]' id='reqDetilId'  data-options='' style='' value="<?=$reqDetilId?>">
                                                        </td>
                                                        <td style="display: none">
                                                            <input class='easyui-validatebox textbox form-control' type='text' name='reqBaris[]' id='reqBaris'   data-options='' style='' value="<?=$reqBaris?>">
                                                        </td>
                                                        <td><input class='easyui-validatebox textbox form-control' type='text' name='reqKolom[]' id='reqKolom'  data-options=''  style='text-align:center;' value="<?=$reqKolom?>" ></td>
                                                        <td >
                                                            <input class='easyui-validatebox textbox form-control' type='text' name='reqRowspan[]' id='reqRowspan'   data-options='' style='' value="<?=$reqRowspan?>">
                                                        </td>
                                                        <td >
                                                            <input class='easyui-validatebox textbox form-control' type='text' name='reqColspan[]' id='reqColspan'   data-options='' style='' value="<?=$reqColspan?>">
                                                        </td>
                                                        <?
                                                        if(empty($reqTabelValId))
                                                        {
                                                        ?>
                                                        <td style="text-align:center"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove'  ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true' onclick="delete_data('<?=$reqBaris?>','isi','<?=$reqDetilId?>')"></i></a></span></td>
                                                        <?
                                                        }
                                                        ?>
                                                    </tr>


                                                <?
                                                }
                                                ?>
                                                
                                            </tbody>
                                        </table>
                                        <?
                                    }
                                }
                                else
                                {
                                    ?>
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTabelHeaderBaris(1)">Tambah Kolom</a>
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTabelHeader()">Tambah Baris</a>
                                    <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;width: 100%">
                                        <thead>
                                            <tr>
                                               <th style="vertical-align : middle;text-align:center;width: 35%">Kolom</th>

                                               <th style="vertical-align : middle;text-align:center;width: 15%">Rowspan</th>
                                               <th style="vertical-align : middle;text-align:center;width: 15%">Colspan</th>

                                               <th style="vertical-align : middle;text-align:center;width: 10%">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody id="tableInputHeader1">
                                        </tbody>
                                    </table>
                                <?
                                }
                                ?>
                                  
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    ?>

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
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Simpan</a>
                <?
                if(!empty($reqDetilId))
                {                ?>
                    <a href="javascript:void(0)" class="btn btn-success" onclick="preview()">Preview</a>
                <?
                }
                ?>

            </div>
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script>
var check ='<?=$reqBaris?>';
const uniqId = (() => {
    
    if(check =="")
    {
        check=2;
    }
    else
    {
       check= Number(check) + 1; 
    }
    // console.log(check);
    let i = check; 
    return () => {
        return i++;
    }
})();

$("#tableInputHeader1,#tableInputIsi").on("click", ".btn-remove", function(){
    $(this).closest('tr').remove();
});

function AddTabelHeader() {
    var idgenerate = uniqId();
    $.get("app/loadUrl/app/template_tabel_header?reqBaris="+idgenerate, function(data) { 
         $("#header").append(data);
    });
}

function AddTabelHeaderBaris(id) {
    // console.log(id);
    $.get("app/loadUrl/app/template_tabel_header_isi?reqBaris="+id, function(data) { 
       $("#tableInputHeader"+id).append(data);
    });
}
function AddTabelHeaderBarisEdit(id) {
    $.get("app/loadUrl/app/template_tabel_header_isi?reqBaris="+id, function(data) { 
       $("#tableInputHeader"+id).append(data);
    });
}

function AddTabelHeaderBarisDinamis(id) {
    $.get("app/loadUrl/app/template_tabel_header_isi?reqBaris="+id, function(data) { 
        $("#tableInputHeader"+id).append(data);
    });
}

function delete_baris(id) {
    $("#tableInputHeader"+id).on("click", ".btn-remove", function(){
        $(this).closest('tr').remove();
    });
}

function delete_data(id,reqMode,detilid) {
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/template_tabel_json/delete_tipe_header/?reqId=<?=$reqId?>&reqBaris="+id+"&reqMode="+reqMode+"&reqDetilId="+detilid,
                function(data){
                    // console.log(data);return false;

                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload();

                });
        }
    }); 
}

function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/template_tabel_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>_add?kembali=<?=$kembali?>&reqId="+reqId);
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   

$('#reqTotal,#reqRowspan,#reqColspan').bind('keyup paste', function(){
    this.value = this.value.replace(/[^0-9]/g, '');
});

function preview(){
   window.open('app/index/<?=$pgreturn?>_preview?reqId=<?=$reqId?>', '_blank'); 
}   
</script>