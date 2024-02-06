<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/TPengukuranDetail");
$this->load->model("base-app/Komentar");
$this->load->model("base-app/TPengukuran");



$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));

$reqIdDetil = $this->input->get("reqIdDetil");
$reqFormUjiId = $this->input->get("reqFormUjiId");
$reqJenisPengukuranId = $this->input->get("reqJenisPengukuranId");
$reqIdPengukuran = $this->input->get("reqIdPengukuran");
$reqRlaId = $this->input->get("reqRlaId");


$set= new TPengukuranDetail();

if($reqIdDetil == "")
{
    $reqMode = "insert";
    if($reqJenisPengukuranId)
    {
        $statement = " AND A.FORM_UJI_ID = '".$reqFormUjiId."' AND  B.JENIS_PENGUKURAN_ID = '".$reqJenisPengukuranId."'";
    }
    else
    {
        $statement = " AND A.FORM_UJI_ID = '".$reqFormUjiId."' ";
    }
    
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqFormUjiNama= $set->getField("NM_FORM");
    $reqJenisPengukuranInfo= $set->getField("NM_JENIS");
    
}
else
{
    $reqMode = "update";

    $statement = " AND T_PENGUKURAN_DETAIL_ID = '".$reqIdDetil."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("T_PENGUKURAN_DETAIL_ID");
    $reqFormUjiId= $set->getField("FORM_UJI_ID");
    $reqJenisPengukuranId= $set->getField("JENIS_PENGUKURAN_ID");
    $reqFormUjiNama= $set->getField("FORM_UJI_INFO");
    $reqJenisPengukuranInfo= $set->getField("JENIS_PENGUKURAN_INFO");
    $reqNama= $set->getField("NAMA");
    $reqHasil= $set->getField("HASIL");
    $reqKomentarId= $set->getField("KOMENTAR_ID");
    $reqStatus= $set->getField("STATUS");
    // $reqKodeReadonly= " readonly ";
    // echo $reqTanggal;exit;
}

$set= new TPengukuran();
$arrlanjut= [];
$statement=" AND A.PLAN_RLA_ID=".$reqRlaId;
$statementdetil=" AND C.T_PENGUKURAN_ID = ".$reqIdPengukuran;

$set->selectByParamsDetailPlan(array(), -1, -1, $statement,$statementdetil);
    // echo  $set->query;exit();
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");
    $arrdata["JENIS_PENGUKURAN_ID"]= $set->getField("JENIS_PENGUKURAN_ID");
    $arrdata["T_PENGUKURAN_DETAIL_ID"]= $set->getField("T_PENGUKURAN_DETAIL_ID");
    array_push($arrlanjut, $arrdata);
}
unset($set);

$lanjutformuji="";
$lanjutjenis="";
$lanjutdetil="";
if(!empty($arrlanjut))
{
    //buat tombol next
    $lanjutformuji= findNextPrev($reqFormUjiId,$arrlanjut,1,'FORM_UJI_ID',2);
    $lanjutjenis= findNextPrev($reqJenisPengukuranId,$arrlanjut,1,'JENIS_PENGUKURAN_ID',2);
    $lanjutdetil= findNextPrev($reqIdDetil,$arrlanjut,1,'T_PENGUKURAN_DETAIL_ID',2);
}

$set= new Komentar();
$arrkomentar= [];
$statement="";
$set->selectByParams(array(), -1, -1, $statement);
    // echo  $set->query;exit();
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("KOMENTAR_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    array_push($arrkomentar, $arrdata);
}
unset($set);  


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
                        <label class="control-label col-md-2">Form Uji</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqFormUjiNama"   id="reqFormUjiNama" value="<?=$reqFormUjiNama?>" disabled style="width:100%" />
                                     <input autocomplete="off" type="hidden" name="reqFormUjiId"   id="reqFormUjiId" value="<?=$reqFormUjiId?>"  style="width:100%" />

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Jenis Pengukuran</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqJenisPengukuranInfo"  id="reqJenisPengukuranInfo" disabled  value="<?=$reqJenisPengukuranInfo?>" style="width:100%" />
                                     <input autocomplete="off" type="hidden" name="reqJenisPengukuranId"   id="reqJenisPengukuranId" value="<?=$reqJenisPengukuranId?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Hasil</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqHasil"  id="reqHasil" value="<?=$reqHasil?>"  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Komentar</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <select class="form-control jscaribasicmultiple" name='reqKomentarId'  id='reqKomentarId' style="width:100%;" >
                                   <option value="">Pilih Komentar</option>
                                       <?
                                       foreach($arrkomentar as $item) 
                                       {
                                            $selectvalid= $item["id"];
                                            $selectnama= $item["NAMA"];

                                            $selected="";
                                            if($reqKomentarId == $selectvalid)
                                            {
                                                $selected="selected";
                                            }
                                          
                                        ?>
                                            < <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectnama?></option>
                                        <?
                                        }
                                        ?>
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
                                     <select name="reqStatus" class="easyui-combobox form-control" style="width: 150px">
                                       <option value=""> Pilih Status</option>
                                       <option value="1" <? if ($reqStatus == 1) echo 'selected' ?>> Normal</option>
                                       <option value="2" <? if ($reqStatus == 2) echo 'selected' ?>> Alarm</option>
                                     </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="reqId" value="<?=$reqId?>" />
                    <input type="hidden" name="reqMode" value="<?=$reqMode?>" />
                    <input type="hidden" name="reqIdPengukuran" value="<?=$reqIdPengukuran?>" />
                    <input type="hidden" name="reqRlaId" value="<?=$reqRlaId?>" />

                </form>

            </div>
            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-danger" onclick="Kembali()">Kembali</a>
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>
                <? if(!empty($lanjutformuji))
                {
                    ?>
                    <a href="javascript:void(0)" class="btn btn-success" onclick="submitNext('<?=$lanjutdetil?>','<?=$lanjutformuji?>','<?=$lanjutjenis?>')">Next</a>
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
    document.location.href="app/index/transaksi_pengukuran_add?reqId=<?=$reqIdPengukuran?>&reqIdRla=<?=$reqRlaId?>";
}
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/t_pengukuran_detail_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/transaksi_pengukuran_add?reqId=<?=$reqIdPengukuran?>&reqIdRla=<?=$reqRlaId?>");
        }
    });
}

function submitNext(iddetil,nextuji,nextjenis){
     // console.log(next);return false;
     var formuji="<?=$reqFormUjiNama?>";
    $.messager.confirm('Konfirmasi',"Lanjut input Form Uji "+formuji+" ?",function(r){
        if (r)
        {
            $('#ff').form('submit',{
                url:'json-app/t_pengukuran_detail_json/add',
                onSubmit:function(){

                    if($(this).form('validate'))
                    {
                    }

                    return $(this).form('enableValidation').form('validate');
                },
                success:function(data){
                   $.messager.progress('close');
                 
                   // varurl= "app/index/transaksi_detail_pengukuran_add?reqIdDetil="+iddetil+"&reqIdPengukuran=<?=$reqIdPengukuran?>&reqFormUjiId="+nextuji+"&reqJenisPengukuranId="+nextjenis+"&reqRlaId=<?=$reqRlaId?>";
                    varurl= "app/index/transaksi_detail_pengukuran_add?reqIdDetil=&reqIdPengukuran=<?=$reqIdPengukuran?>&reqFormUjiId=<?=$reqFormUjiId?>&reqJenisPengukuranId=<?=$reqJenisPengukuranId?>&reqRlaId=<?=$reqRlaId?>";
                   document.location.href = varurl;
               }
            });
        }
    }); 
}

function clearForm(){
    $('#ff').form('clear');
}   
</script>