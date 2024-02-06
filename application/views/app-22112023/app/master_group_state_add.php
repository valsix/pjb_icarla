<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/GroupState");
$this->load->model("base-app/FlowApproval");

$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");

$set= new GroupState();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND A.GROUP_STATE_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("GROUP_STATE_ID");
    $reqNama= $set->getField("NAMA");
    $reqStatus= $set->getField("STATUS");
    // $reqKodeReadonly= " readonly ";
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
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Group State</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" <?=$disabled?>  data-options="required:true" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Status</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                    <input   name="reqStatus" class="easyui-combobox form-control" id="reqStatus"
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combostatusaktif'" value="<?=$reqStatus?>" <?=$disabled?>  required />
                                </div>
                            </div>
                        </div>
                    </div>

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
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Submit</a>

            </div>
            <?
            }
            ?>

            <div>
                <div class="page-header">
                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?> Detail</h3>       
                </div>
                <table class="table table-bordered table-striped table-hovered">
                    <thead>
                        <th>No</th>
                        <th>Nama State</th>
                        <th>Tipe</th>
                        <th>Index</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?
                        $statement =" AND 1=2";
                        if(!empty($reqId))
                        {
                            $statement =" AND A.GROUP_STATE_ID =".$reqId;
                        }
                        $sOrder=" ORDER BY A.URUT ASC";
                        
                        $setDetil= new GroupState();
                        $setDetil->selectByParamsDetail(array(), -1, -1, $statement,$sOrder);
                        // echo $setDetil->query;exit;
                        $i=1;
                        while ($setDetil->nextRow()) 
                        {
                            $reqIdDetil= $setDetil->getField("GROUP_STATE_DETAIL_ID");
                            $reqNamaState= $setDetil->getField("NAMA_STATE");
                            $reqTipeState= $setDetil->getField("INFO_TIPE");
                            $reqIndex= $setDetil->getField("URUT");
                            ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$reqNamaState?></td>
                                <td><?=$reqTipeState?></td>
                                <td><?=$reqIndex?></td>
                                <?
                                if($reqLihat ==1)
                                {}
                                else
                                {
                                ?>
                                    <td>
                                        <span style="background-color: red;padding: 8px; border-radius: 5px;"><a onclick="hapus(<?=$reqIdDetil?>)"><i class="fa fa-trash fa-lg" style="color: white;" aria-hidden="true"></i></a></span>
                                        <span style="background-color: blue;padding: 8px; border-radius: 5px;"><a onclick="edit(<?=$reqIdDetil?>)"><i class="fa fa-pencil fa-lg" style="color: white;" aria-hidden="true"></i></a></span>
                                    </td>
                                <?
                                }
                                ?>
                            </tr>
                            <?
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>


                <?
                if($reqLihat ==1)
                {}
                else
                {
                    ?>
                    <div style="text-align:center;padding:5px">
                        <a id="triggerTambahDetail"  class='btn btn-primary btn-sm btn-flat' data-remote='false' data-target='#compose-modal' data-toggle='modal'>Tambah Detail</a>
                    </div>
                    <?
                }
                ?>
            </div>
            
        </div>
    </div>
    
</div>

<script>
function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/group_state_json/add',
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

$("#triggerTambahDetail").on("click", function () {
    // console.log('<?=$reqId?>')
    varurl= "app/index/master_group_state_detail_add?reqHead=<?=$reqId?>";
        document.location.href = varurl;
});  

function hapus(val){
    let text = "Hapus data terpilih?";
    if (confirm(text) == true) {
   
    $.getJSON("json-app/group_state_json/delete_detail/?reqId="+val,
        function(data){
            $.messager.alert('Info', data.PESAN, 'info');
            valinfoid= "";
            location.reload();
        });
    }
}

function edit(val){
    varurl= "app/index/master_group_state_detail_add?reqId="+val;
    document.location.href = varurl;
}
</script>