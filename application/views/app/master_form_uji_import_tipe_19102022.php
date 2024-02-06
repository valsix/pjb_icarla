<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$pgreturn= str_replace("_add", "", $pg);

$this->load->model("base-app/FormUjiTipe");

$reqId = $this->input->get("reqId");
$reqTipeId = $this->input->get("reqTipeId");
$reqTipeDetilId = $this->input->get("reqTipeDetilId");


$set= new FormUjiTipe();
$statement = " AND A.FORM_UJI_TIPE_ID =".$reqTipeId;
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$reqNama=$set->getField("NAMA");
// echo  $reqNama;exit;

unset($set);


$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$fungsi="";
$link="";
if($reqTipeId==1)
{
    $fungsi="form_uji_ir_pi";

    $link="template/form_uji/import/template_ir_pi_before.xls";
}
else if($reqTipeId==2)
{
    $fungsi="form_uji_ir_pi";
    $link="template/form_uji/import/template_ir_pi_after.xls";
}
else if($reqTipeId==4)
{
    if($reqTipeDetilId==1)
    {
        $fungsi="form_uji_sfra_hv";
        $link="template/form_uji/import/template_sfra_hv.xls";
        $reqNama.= " HV";
    }
    elseif($reqTipeDetilId==2)
    {
        $fungsi="form_uji_sfra_lv";
        $link="template/form_uji/import/template_sfra_lv.xls"; 
        $reqNama.= " LV";
    }
    elseif($reqTipeDetilId==3)
    {
        $fungsi="form_uji_sfra_hvlv";
        $link="template/form_uji/import/template_sfra_hvlv.xls";
        $reqNama.= " HV LV";
    }
    elseif($reqTipeDetilId==4)
    {
        $fungsi="form_uji_sfra_hv_short";
        $link="template/form_uji/import/template_sfra_hv_short.xls";
        $reqNama.= " HV Short";
    }
    elseif($reqTipeDetilId==5)
    {
       $fungsi="form_uji_sfra_hvlv_groud";
       $link="template/form_uji/import/template_sfra_hvlv_ground.xls";
       $reqNama.= " HV Lv Ground";
    }
    
  
}
else if($reqTipeId==6)
{
    if($reqTipeDetilId==1)
    {
       $reqNama.= " Winding";
       $fungsi="form_uji_tandelta_winding";
       $link="template/form_uji/import/template_tandelta_winding.xls";
    }
    else if($reqTipeDetilId==2)
    {
        $reqNama.= " Winding Without";
        $fungsi="form_uji_tandelta_winding_without";
        $link="template/form_uji/import/template_tandelta_winding_without.xls";
    }
    else if($reqTipeDetilId==3)
    {
        $reqNama.= " Reference";
        $fungsi="form_uji_tandelta_ref";
        $link="template/form_uji/import/template_tandelta_ref.xls";
    }
}

else if($reqTipeId==7)
{
    $fungsi="form_uji_hcb";
    $link="template/form_uji/import/template_hcb.xls";
}
else if($reqTipeId==8)
{
    $fungsi="form_uji_ex_curr";
    $link="template/form_uji/import/template_ex_curr.xls";
}
else if($reqTipeId==9)
{
    $fungsi="form_uji_rdc";
    $link="template/form_uji/import/template_rdc.xls";
}
else if($reqTipeId==10)
{
    $fungsi="form_uji_ratio";
    $link="template/form_uji/import/template_ratio.xls";
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
                    <input type="hidden" name="reqTipePengukuranid" id="reqTipePengukuranid"; value="" />
                    <input type="hidden" name="reqTipeId" value="<?=$reqTipeId?>" />

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
        url:'json-app/import_form_uji_json/<?=$fungsi?>',
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