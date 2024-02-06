<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/CatatanRla");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqIdRla = $this->input->get("reqIdRla");
$reqLihat = $this->input->get("reqLihat");



$set= new CatatanRla();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND CATATAN_RLA_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("CATATAN_RLA_ID");
    $reqNid= $set->getField("NID");
    $reqNama= $set->getField("NAMA");
    $reqTanggal= dateToPageCheck3($set->getField("TANGGAL"));
    $reqCatatan= $set->getField("CATATAN");
    // $reqKodeReadonly= " readonly ";
    // echo $reqTanggal;exit;
}

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

<div class="col-md-12">
    
  <div class="judul-halaman" style="padding: 0px 0px"></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama/NID</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" data-options="required:true" style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tanggal</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input type="date" required id="reqTanggal" class="easyui-validatebox textbox form-control" name="reqTanggal" value="<?=$reqTanggal ?>" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Catatan</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <textarea name="reqCatatan" class="easyui-validatebox form-control" <?=$disabled?> id="reqCatatan"  ><?=$reqCatatan?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">  
                        <label class="control-label col-md-2">Status</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input   name="reqStatus" class="easyui-combobox form-control" id="reqStatus"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combostatusaktif'" value="<?=$reqStatus?>" required />
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqIdRla" value="<?=$reqIdRla?>" />


                </form>

            </div>
            <div style="text-align:center;padding:5px">
             <?
            if($reqLihat ==1)
            {}
            else
            {
            ?>
            <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

            <?
            }
            ?>
            <a href="javascript:void(0)" class="btn btn-danger" onclick="Kembali()">Kembali</a>

             </div>
            
        </div>
    </div>
    
</div>

<script>
function Kembali()
{
    document.location.href="app/index/<?=$pgreturn?>?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>";
}
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/catatan_rla_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>?reqIdRla=<?=$reqIdRla?>");
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>