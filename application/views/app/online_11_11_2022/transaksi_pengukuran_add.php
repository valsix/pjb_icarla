<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/TPengukuran");
$this->load->model("base-app/TPengukuranDetail");

$this->load->model("base-app/PlanRla");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqIdRla = $this->input->get("reqIdRla");
$reqLihat = $this->input->get("reqLihat");


$set= new TPengukuran();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND T_PENGUKURAN_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("T_PENGUKURAN_ID");
    $reqNoPengukuran= $set->getField("NOMOR_PENGUKURAN");
    $reqManufakturId= $set->getField("MANUFAKTUR_ID");
    $reqInspeksi= $set->getField("INSPEKSI");
    $reqTanggal= dateToPageCheck($set->getField("TANGGAL"));
    $reqQpNo= $set->getField("QP_NO");
    $reqFuNo= $set->getField("FU_NO");
    $reqQemDocNo= $set->getField("QEM_DOC_NO");
    $reqRefTambahan= $set->getField("REF_TAMBAHAN");
    $reqCatatan= $set->getField("CATATAN");
    $reqRekomendasi= $set->getField("REKOMENDASI");
    $reqMeasuringToolId= $set->getField("MEASURING_TOOLS_ID");
    $reqApprovalId= $set->getField("APPROVAL_ID");
    // $reqKodeReadonly= " readonly ";
    // echo $reqTanggal;exit;

    $set= new TPengukuran();
    $arrdetil= [];
    $checkidform=[];
    $statement=" AND A.PLAN_RLA_ID=".$reqIdRla;
    $statementdetil=" AND C.T_PENGUKURAN_ID = ".$reqId;
    $set->selectByParamsDetailPlan(array(), -1, -1, $statement,$statementdetil);
    // echo  $set->query;exit();
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("T_PENGUKURAN_DETAIL_ID");
        $arrdata["PLAN_RLA_ID"]= $set->getField("PLAN_RLA_ID");
        $arrdata["FORM_UJI_ID"]= $set->getField("FORM_UJI_ID");

        $arrdata["JENIS_PENGUKURAN_ID"]= $set->getField("JENIS_PENGUKURAN_ID");
        $arrdata["NAMA_FORM"]= $set->getField("NAMA_FORM");
        $arrdata["NAMA_JENIS"]= $set->getField("NAMA_JENIS");
        $arrdata["NAMA_DETIL"]= $set->getField("NAMA_DETIL");
        $arrdata["HASIL_DETIL"]= $set->getField("HASIL_DETIL");
        $arrdata["KOMENTAR_DETIL"]= $set->getField("KOMENTAR_DETIL");
        $arrdata["STATUS_INFO"]= $set->getField("STATUS_INFO");
        array_push($arrdetil, $arrdata);
        $checkidform[]=$set->getField("FORM_UJI_ID");
    }
    unset($set);
 

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

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data" autocomplete="off">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Nomor Pengukuran</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqNoPengukuran"  id="reqNoPengukuran" value="<?=$reqNoPengukuran?>"  style="width:100%"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Manufaktur</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <!--  <input  class="easyui-validatebox textbox form-control" type="text" name="reqManufakturId"  id="reqManufakturId" value="<?=$reqManufakturId?>"  style="width:100%" /> -->
                                    <input  name="reqManufakturId" class="easyui-combobox form-control" id="reqDistrikId"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combomanufaktur'" value="<?=$reqManufakturId?>" <?=$disabled?>  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Inspeksi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqInspeksi"  id="reqInspeksi" value="<?=$reqInspeksi?>"  style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Tanggal</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input  id="reqTanggal" class="easyui-datebox textbox form-control" name="reqTanggal" value="<?=$reqTanggal ?>" style="width: 100%"  <?=$disabled?>/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">QP No</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqQpNo"  id="reqQpNo" value="<?=$reqQpNo?>"  style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">FU No</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqFuNo"  id="reqFuNo" value="<?=$reqFuNo?>"  style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">QEM Doc No</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqQemDocNo"  id="reqQemDocNo" value="<?=$reqQemDocNo?>"  style="width:100%"  <?=$disabled?>/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Referensi Tambahan</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqRefTambahan"  id="reqRefTambahan" value="<?=$reqRefTambahan?>"  <?=$disabled?>  style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Catatan</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <textarea name="reqCatatan" class="easyui-validatebox form-control" id="reqCatatan" <?=$disabled?>  ><?=$reqCatatan?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Rekomendasi</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input  class="easyui-validatebox textbox form-control" type="text" name="reqRekomendasi"  id="reqRekomendasi" value="<?=$reqRekomendasi?>"  style="width:100%"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">List Measuring Tools</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <!-- <input  class="easyui-validatebox textbox form-control" type="text" name="reqMeasuringToolId"  id="reqMeasuringToolId" value="<?=$reqMeasuringToolId?>"  style="width:100%" /> -->
                                     <input  name="reqMeasuringToolId" class="easyui-combobox form-control" id="reqMeasuringToolId"
                                     data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combomeasuring'" value="<?=$reqMeasuringToolId?>"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Approval</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <!--   <input  class="easyui-validatebox textbox form-control" type="text" name="reqApproval"  id="reqApproval" value="<?=$reqApproval?>"  style="width:100%" /> -->
                                   <input  name="reqApprovalId" class="easyui-combobox form-control" id="reqApprovalId"
                                     data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/combouser'" value="<?=$reqApprovalId?>"  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>

                    <?
                    if (!empty($reqId))
                    {
                    ?>
                        <?
                        if($reqLihat ==1)
                        {}
                        else
                        {
                            ?>
                            <div style="text-align:center;padding:5px">
                                <a href="javascript:void(0)" class="btn btn-success" onclick="submitNext()">Next</a>
                            </div>

                            <?
                        }
                        ?>
                        
                        <div class="page-header">
                            <h3><i class="fa fa-file-text fa-lg"></i> List Pengukuran</h3>       
                        </div>

                        <table class="table table-bordered table-striped table-hovered" id="uji">
                            <thead>
                                <th style="text-align: center;">Form Uji</th>
                                <th>Jenis Pengukuran</th>
                                <th>Nama</th>
                                <th>Hasil</th>
                                <th>Komentar</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            <?
                            foreach($arrdetil as $item) 
                            {
                                $reqIdDetil= $item["id"];
                                $reqRlaId= $item["PLAN_RLA_ID"];
                                $reqFormUjiId= $item["FORM_UJI_ID"];
                                $reqJenisPengukuranId= $item["JENIS_PENGUKURAN_ID"];
                                $reqNamaFormUji= $item["NAMA_FORM"];
                                $reqNamaJenis= $item["NAMA_JENIS"];
                                $reqNamaDetil= $item["NAMA_DETIL"];
                                $reqHasilDetil= $item["HASIL_DETIL"];
                                $reqKomentar= $item["KOMENTAR_DETIL"];
                                $reqStatus= $item["STATUS_INFO"];
                              
                            ?>
                                <tr>
                                    <td style="display: none;"><?=$reqFormUjiId?></td>
                                    <td style="display: none;"><?=$reqIdDetil?></td>
                                    <td id="idnama-<?=$reqIdDetil?>"><?=$reqNamaFormUji?></td>
                                    <td><?=$reqNamaJenis?></td>
                                    <td><?=$reqNamaDetil?></td>
                                    <td><?=$reqHasilDetil?></td>
                                    <td><?=$reqKomentar?></td>
                                    <td><?=$reqStatus?></td>
                                    <td>
                                        <? if($reqIdDetil)
                                        {
                                            ?>
                                            <span style="background-color: red;padding: 8px; border-radius: 5px;"><a onclick="hapus(<?=$reqIdDetil?>)"><i class="fa fa-trash fa-lg" style="color: white;" aria-hidden="true"></i></a></span>
                                            <?
                                        }
                                        ?>
                                        <?
                                        if($reqLihat ==1)
                                        {}
                                        else
                                        {
                                            ?>
                                        <span style="background-color: blue;padding: 8px; border-radius: 5px;"><a onclick="edit('<?=$reqIdDetil?>','<?=$reqId?>','<?=$reqFormUjiId?>','<?=$reqJenisPengukuranId?>','<?=$reqRlaId?>')"><i class="fa fa-pencil fa-lg" style="color: white;" aria-hidden="true"></i></a></span>
                                        <?
                                        }
                                        ?>

                                    </td>
                                </tr>
                            <?
                            $i++;
                            }
                            ?>
                              
                            </tbody>
                        </table>

                    <?
                      
                    }   
                    ?>

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
var seen = {};
table = document.getElementById("uji");
tr = table.getElementsByTagName("tr");
for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    tddetil = tr[i].getElementsByTagName("td")[1];
    var iduji=td.textContent;
    var iddetil=tddetil.textContent;
    if (seen[iduji]) {
        $("#idnama-"+iddetil).html('');
    } else {
        seen[iduji]=true;
    }
}

function Kembali()
{
    document.location.href="app/index/<?=$pgreturn?>?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>";
}
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/t_pengukuran_json/add',
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

function submitNext(){
    $.messager.confirm('Konfirmasi',"Apakah anda yakin untuk lanjut?",function(r){
        if (r)
        {
            $('#ff').form('submit',{
                url:'json-app/t_pengukuran_json/add',
                onSubmit:function(){

                    if($(this).form('validate'))
                    {
                    }

                    return $(this).form('enableValidation').form('validate');
                },
                success:function(data){
                   $.messager.progress('close');
                   varurl= "app/index/transaksi_pengukuran_add?reqId=&reqIdRla=<?=$reqIdRla?>";
                   document.location.href = varurl;
               }
            });
        }
    }); 
}

function clearForm(){
    $('#ff').form('clear');
}

function edit(reqIdDetil,reqId,reqFormUjiId,reqJenisPengukuranId,reqRlaId){

  varurl= "app/index/transaksi_detail_pengukuran_add?reqIdDetil="+reqIdDetil+"&reqIdPengukuran="+reqId+"&reqFormUjiId="+reqFormUjiId+"&reqJenisPengukuranId="+reqJenisPengukuranId+"&reqRlaId="+reqRlaId;
  document.location.href = varurl;

}

function hapus(reqIdDetil){
    if(reqIdDetil == "")
        return false; 
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/t_pengukuran_detail_json/delete/?reqId="+reqIdDetil,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload();
                });

        }
    }); 
}


</script>