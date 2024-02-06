<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$pgreturn= str_replace("_add", "", $pg);

$this->load->model("base-app/Pengukuran");
$this->load->model("base-app/FormUji");


$reqId = $this->input->get("reqId");
$reqPengukuranId = $this->input->get("reqPengukuranId");
$reqTipePengukuranId = $this->input->get("reqTipePengukuranId");
$reqTipeInputId = $this->input->get("reqTipeInputId");


$reqTabelId = $this->input->get("reqTabelId");


$set= new Pengukuran();
$statement = " AND A.PENGUKURAN_ID =".$reqPengukuranId;
$set->selectByParamsComboPengukuran(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$reqNama=$set->getField("NAMA");
// echo  $reqNama;exit;

unset($set);


$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$fungsi="";
$link="";


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

.box {
  width: 100%;
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

<div class="col-md-12">
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Master Form Uji Import <?=$reqNama?>  </a> &rsaquo; Form Import</div>

    <div class="konten-area">
        <div class="konten-inner">
            <div>
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> Master Form Uji Import <?=$reqNama?></h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                         <div class="card-body">
                            <div class="warning box" style="text-align: justify;font-size: 18px">
                                <ol>
                                    <li>Pastikan data import format <b>(xls)</b> sesuai dengan contoh template yang sudah ada</li>
                                    <li>Pastikan anda tidak mengisi/mengedit <b>kolom yang berwarna hitam</b> dan hanya mengisi <b>kolom pertama yaitu kolom A</b></li>

                                </ol>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-6 col-sm-12" style="font-size: 15px">Contoh Template <a class="link-button"  onclick="template_dinamis('<?=$reqPengukuranId?>','<?=$reqId?>','<?=$reqTabelId?>');" target="_blank"><img src="images/icon-download.png" width="15" height="15" /> Download </a></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-4 col-sm-12" style="font-size: 15px;">File :</label>
                                <input type="file" name="reqLinkFile" id="reqLinkFile" class="easyui-validatebox" accept="application/vnd.ms-excel" />
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqTabelId" id="reqTabelId" value="<?=$reqTabelId?>" />
                    <input type="hidden" name="reqPengukuranId" value="<?=$reqPengukuranId?>" />
                    <input type="hidden" name="reqPengukuranTipeId" value="<?=$reqPengukuranId?>" />
                    <input type="hidden" name="reqTipePengukuranId" value="<?=$reqTipePengukuranId?>" />
                    <input type="hidden" name="reqTipeInputId" value="<?=$reqTipeInputId?>" />

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
        url:'json-app/import_form_uji_dinamis_json/import_dinamis',
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
function template_dinamis(reqTipe,reqId,tabelid)
{
    urlExcel = 'json-app/form_uji_template_dinamis_json/template_dinamis?reqId='+reqId+'&reqPengukuranId='+reqTipe+'&reqTabelId='+tabelid;
    // console.log(urlExcel);
    newWindow = window.open(urlExcel, 'Cetak');
    newWindow.focus();
}    
</script>