<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/TimelineRla");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));

$reqId = $this->input->get("reqId");

$set= new TimelineRla();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND TIMELINE_RLA_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("TIMELINE_RLA_ID");
    $reqNama= $set->getField("NAMA");
    $reqRencanaTanggalAwal= dateToPageCheck($set->getField("RENCANA_TANGGAL_AWAL"));
    $reqRencanaTanggalAkhir= dateToPageCheck($set->getField("RENCANA_TANGGAL_AKHIR"));
    $reqRencanaDurasi= $set->getField("RENCANA_DURASI");
    
    $reqRealisasiTanggalAwal= dateToPageCheck($set->getField("REALISASI_TANGGAL_AWAL"));
    $reqRealisasiTanggalAkhir= dateToPageCheck($set->getField("REALISASI_TANGGAL_AKHIR"));
    $reqRealisasiDurasi= $set->getField("REALISASI_DURASI");
}	
?>

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
                        <label class="control-label col-md-2">Item</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" data-options="required:true" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Rencana Tanggal Awal </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-12'>
                                    <input autocomplete="off" class="easyui-datebox form-control"  name="reqRencanaTanggalAwal"  id="reqRencanaTanggalAwal" value="<?=$reqRencanaTanggalAwal?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Rencana Tanggal Akhir </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-12'>
                                    <input autocomplete="off" class="easyui-datebox form-control" name="reqRencanaTanggalAkhir"  id="reqRencanaTanggalAkhir" value="<?=$reqRencanaTanggalAkhir?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Rencana Durasi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqRencanaDurasi"  id="reqRencanaDurasi" value="<?=$reqRencanaDurasi?>" style="width:20%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Realisasi Tanggal Awal </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-12'>
                                    <input autocomplete="off" class="easyui-datebox form-control"  name="reqRealisasiTanggalAwal"  id="reqRealisasiTanggalAwal" value="<?=$reqRealisasiTanggalAwal?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Realisasi Tanggal Akhir </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-12'>
                                    <input autocomplete="off" class="easyui-datebox form-control" name="reqRealisasiTanggalAkhir"  id="reqRealisasiTanggalAkhir" value="<?=$reqRealisasiTanggalAkhir?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Realisasi Durasi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqRealisasiDurasi"  id="reqRealisasiDurasi" value="<?=$reqRealisasiDurasi?>" style="width:20%" />
                                </div>
                            </div>
                        </div>
                    </div>



                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />

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
        url:'json-app/timeline_rla_json/add',
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