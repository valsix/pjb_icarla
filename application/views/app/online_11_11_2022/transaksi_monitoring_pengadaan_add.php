<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/PengadaanKontrak");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqIdRla = $this->input->get("reqIdRla");
$reqLihat = $this->input->get("reqLihat");


$set= new PengadaanKontrak();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.PENGADAAN_KONTRAK_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PENGADAAN_KONTRAK_ID");
    $reqNama= $set->getField("NAMA_VENDOR");
    $reqNomor= $set->getField("NOMOR_KONTRAK");
    $reqJudul= $set->getField("JUDUL_KONTRAK");
    $reqTanggalKontrak= dateToPageCheck($set->getField("TANGGAL_KONTRAK"));
    $reqTanggalBerlaku= dateToPageCheck($set->getField("TANGGAL_BERLAKU"));
    $reqTanggalLevering= dateToPageCheck($set->getField("TANGGAL_LEVERING"));
    $reqNilai= $set->getField("NILAI");
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
                        <label class="control-label col-md-2">Nama Vendor</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>"  style="width:100%"  <?=$disabled?> />
                               </div>
                           </div>
                       </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nomor Kontrak</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNomor"  id="reqNomor" value="<?=$reqNomor?>" style="width:100%"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Judul Kontrak</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqJudul"  id="reqJudul" value="<?=$reqJudul?>" style="width:100%"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tanggal Kontrak</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-datebox  form-control"  name="reqTanggalKontrak"  id="reqTanggalKontrak" value="<?=$reqTanggalKontrak?>" style="width:100%"  <?=$disabled?>/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tanggal Berlaku</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                      <input autocomplete="off" class="easyui-datebox  form-control"  name="reqTanggalBerlaku"  id="reqTanggalBerlaku" value="<?=$reqTanggalBerlaku?>" style="width:100%"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tanggal Levering</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-datebox  form-control"  name="reqTanggalLevering"  id="reqTanggalLevering" value="<?=$reqTanggalLevering?>" style="width:100%"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nilai</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNilai"  id="reqNilai" value="<?=$reqNilai?>" style="width:100%"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqIdRla" value="<?=$reqIdRla?>" />

                </form>

            </div>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-danger" onclick="Kembali()">Kembali</a>
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
        url:'json-app/pengadaan_kontrak_json/add',
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