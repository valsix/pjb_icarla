<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$pgreturn= str_replace("_add", "", $pg);

$this->load->model("base-app/Nameplate");

$reqId = $this->input->get("reqId");
$reqNameplateId = $this->input->get("reqNameplateId");

$set= new Nameplate();
$statement = " AND A.NAMEPLATE_ID =".$reqNameplateId;
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$reqNama=$set->getField("NAMA");
// echo  $reqNama;exit;

unset($set);


$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));


$link="app/loadUrl/app/master_form_uji_template_nameplate?reqId=".$reqId."&reqNameplateId=".$reqNameplateId;



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
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Master <?=$pgtitle?> <?=$reqNama?>  </a> &rsaquo; Form Import</div>

    <div class="konten-area">
        <div class="konten-inner">
            <div>
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?> <?=$reqNama?></h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                         <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-10 col-sm-12" style="font-size: 18px">Pastikan data import format <b>(xls)</b> sesuai dengan contoh template yang sudah ada</label>
                            </div>
                            <br>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-6 col-sm-12" style="font-size: 15px">Contoh Template <a class="link-button" href="<?=$link?>" target="_blank"><img src="images/icon-download.png" width="15" height="15" /> Download </a></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-4 col-sm-12" style="font-size: 15px;">File :</label>
                                <input type="file" name="reqLinkFile" id="reqLinkFile" class="easyui-validatebox" accept="application/vnd.ms-excel" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqNameplateId" id="reqNameplateId"; value="<?=$reqNameplateId?>" />

                </form>
            </div>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

            </div>
        </div>
    </div>
</div>

<script>

  

function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/import_form_uji_nameplate_json/form_uji_nameplate',
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
                    top.location.href= "app/index/master_form_uji_add?reqId=<?=$reqId?>";
                });
        }
    });
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>