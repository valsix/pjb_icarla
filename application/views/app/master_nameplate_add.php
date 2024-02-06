<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Nameplate");
$this->load->model("base-app/MasterTabel");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");

$set= new Nameplate();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

	$statement = " AND NAMEPLATE_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("NAMEPLATE_ID");
    $reqNama= $set->getField("NAMA");
    $reqStatus= $set->getField("STATUS");
    // $reqKodeReadonly= " readonly ";

   
     // var_dump($arrtabel);
    unset($set);

    $set= new Nameplate();
    $arrdetil= [];
    $statement = " AND NAMEPLATE_ID= '".$reqId."' ";
    $set->selectByParamsDetil(array(), -1, -1, $statement);
    // echo  $set->query;exit;
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["iddetil"]= $set->getField("NAMEPLATE_DETIL_ID");
        $arrdata["id"]= $set->getField("NAMEPLATE_ID");
        $arrdata["NAMA"]= $set->getField("NAMA");
        $arrdata["NAMA_TABEL"]= $set->getField("NAMA_TABEL");
        $arrdata["STATUS"]= $set->getField("STATUS");
        $arrdata["ISI"]= $set->getField("ISI");

        array_push($arrdetil, $arrdata);
    }

    // print_r($arrdetil);exit;

    unset($set);


    $set= new MasterTabel();

    $arrtabel= [];
    $statement = "";
    $set->selectByParams(array(), -1, -1, $statement);
    while($set->nextRow())
    {
        $arrdata= array();
        $arrdata["id"]= $set->getField("MASTER_TABEL_ID");
        $arrdata["NAMA"]= ucfirst(strtolower($set->getField("NAMA")));
        $arrdata["NAMA_INFO"]= ucfirst(strtolower(str_replace("_", " ", $set->getField("NAMA"))));

        array_push($arrtabel, $arrdata);
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
    
  <div class="judul-halaman"> <a href="app/index/<?=$pgreturn?>">Data <?=$pgtitle?></a> &rsaquo; Kelola <?=$pgtitle?></div>

    <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data" autocomplete="off">

                    <div class="page-header">
                        <h3><i class="fa fa-file-text fa-lg"></i> <?=$pgtitle?></h3>       
                    </div>
                                                                             
                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Nameplate</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" data-options="required:true" style="width:100%"  <?=$disabled?> />
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
                                    data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combostatusaktif'" value="<?=$reqStatus?>" required  <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>
                      <div class="page-header">
                            <h3><i class="fa fa-file-text fa-lg"></i> Kolom Nameplate</h3>       
                        </div>
                        <br>
                        <?
                        if($reqLihat ==1)
                        {}
                        else
                        {
                        ?>
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddNameplate()">Tambah</a>
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddNameplate(1)">Tambah Master</a>
                        <?
                        }
                        ?>
                       
                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;width: 100%">
                            <thead>
                                <tr>
                                    <th style="vertical-align : middle;text-align:center;width: 15%">Tipe / Tabel</th>
                                    <th style="vertical-align : middle;text-align:center;width: 55%">Label</th>
                                    <th style="vertical-align : middle;text-align:center;width: 55%">Isi</th>

                                    <th style="vertical-align : middle;text-align:center;width: 10%">Action</th>
                                 </tr>
                            </thead>
                            <tbody id="tableNameplate">
                            <?
                            $arrMaster= [];
                            $nocheck=0;
                            $arrnocheck= [];
                            foreach($arrdetil as $itemdetil) 
                            {
                                $selectvaliddetil= $itemdetil["iddetil"];
                                $reqNamaDetil=$itemdetil["NAMA"];
                                $reqTipeName=$itemdetil["NAMA_TABEL"];
                                $reqStatusDetil=$itemdetil["STATUS"];
                                $reqIsiDetil=$itemdetil["ISI"];

                                $statement = " ";
                                $sOrder="";


                                // print_r($arrMaster);

                                ?>
                                <tr  id="nameplatedetil-<?=$selectvaliddetil?>">
                                    <?
                                    if($reqStatusDetil==1)
                                    { 
                                    ?>
                                        <td>
                                            <select class="form-control jscaribasicmultiple" name='reqTipe[]' id="reqTipe-<?=$nocheck?>" style="width:100%;" >
                                                <option value="">Pilih Tabel Master</option>
                                                <?
                                                foreach($arrtabel as $item) 
                                                {
                                                    $selectvalid= $item["id"];
                                                    $selectnama=$item["NAMA"];
                                                    $selectinfo=$item["NAMA_INFO"];
                                                    $selected="";
                                                    if(strtoupper($selectnama) == $reqTipeName)
                                                    {
                                                        $selected="selected";
                                                    }

                                                    ?>
                                                    <option value="<?=$nocheck?>-<?=$selectnama?>" <?=$selected?>><?=$selectinfo?></option>
                                                    <?
                                                }
                                                ?>  
                                            </select>
                                        </td>
                                        <td style="display: none"><input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusDetil[]' id='reqStatusDetil' value='1'  data-options='' value="<?=$reqStatusDetil?>"  style='text-align:center;'></td>
                                        <?
                                    }
                                    else
                                    {
                                        ?>
                                        <td><input class='easyui-validatebox textbox form-control' type='text' name='reqTipe[]' id='reqTipeText' value='Text'  data-options='' readonly style='text-align:center;'></td>
                                        <td style="display: none"><input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusDetil[]' id='reqStatusDetil' value='0'  data-options=''  style='text-align:center;'></td>
                                        <?
                                    }
                                    ?>
                                    <td ><input class='easyui-validatebox textbox form-control' type='text' name='reqNamaDetil[]' id='reqNamaDetil' data-options='' value="<?=$reqNamaDetil?>"></td>
                                    <?
                                    if($reqStatusDetil==1)
                                    { 
                                    ?>
                                        <td>
                                            <div id="isitabel_<?=$nocheck?>">
                                                <select class="form-control jscaribasicmultiple" name='reqIsiDetil[]' id="reqIsiDetil-<?=$nocheck?>" style="width:100%;" >
                                                    <?
                                                    if(!empty($reqTipeName) && $reqStatusDetil==1)
                                                    {
                                                        $set= new Nameplate();
                                                        $set->selectByParamsCheckTabel(array(), -1, -1, $statement,$sOrder,$reqTipeName);
                                                          // echo $set->query;
                                                        while($set->nextRow())
                                                        {
                                                            $arrdata= array();
                                                            $arrdata["id"]= $set->getField("".$reqTipeName."_ID");
                                                            $arrdata["NAMA"]= $set->getField("NAMA");

                                                            $selectvalid= $set->getField("".$reqTipeName."_ID");
                                                            $selectnama=$set->getField("NAMA");
                                                            $selectinfo=$itemisi["NAMA_INFO"];
                                                            $selected="";
                                                            if(strtoupper($selectvalid) == $reqIsiDetil)
                                                            {
                                                                $selected="selected";
                                                            }
                                                        ?>
                                                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectnama?></option>
                                                        <?
                                                        }
                                                    }
                                                    ?>  
                                                </select>
                                            </div>
                                        </td>
                                    <?
                                    $arrnocheck[]= $nocheck;
                                    $nocheck++;
                                    }
                                    else
                                    {
                                    ?>
                                        <td><input class='easyui-validatebox textbox form-control' type='text' name='reqIsiDetil[]' id='reqIsiText-<?=$nocheck?>'  data-options='' value="<?=$reqIsiDetil?>"></td>
                                    <?
                                    }
                                    ?>

                                    <input type="hidden" name="reqIdDetil[]" value="<?=$selectvaliddetil?>" />

                                    <?
                                    if($reqLihat ==1)
                                    {}
                                    else
                                    {
                                        ?>

                                    <td style="text-align:center"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvaliddetil?>","nameplatedetil")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                                      

                                    <?
                                    }
                                    ?>

                                </tr>
                                <?
                                $nocheck++;
                            }
                            ?>
                            </tbody>
                        </table>

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
            
        </div>
    </div>
    
</div>

<script>



$("#tableNameplate").on("click", ".btn-remove", function(){
    $(this).closest('tr').remove();
});
var arrayFromPHP = <?php echo json_encode($arrnocheck); ?>;

var check =0;


if(arrayFromPHP)
{
    arrayFromPHP.forEach(function(item) {
        $("#reqTipe-"+item).on("change", function () 
        { 

            var val=$(this).val();
            var reqTabel = val.substr(val.indexOf("-") + 1);
            // console.log(reqTabel);
            var url = "app/loadUrl/app/template_nameplate_add_master?reqTabel="+reqTabel;
            $.get(url, function(data) {
                $("#isitabel_"+item).empty();   
                $("#isitabel_"+item).append(data);
            });

        });

        check =item;

    });
}


const uniqId = (() => {
    
    if(check =="")
    {
        check=0;
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



function AddNameplate(tipe) {
    var idgenerate = uniqId();
    if(tipe==1)
    {
        var url = "app/loadUrl/app/template_nameplate_add?reqTipe="+tipe+"&reqIdGenerate="+idgenerate;
    }
    else
    {
        var url = "app/loadUrl/app/template_nameplate_add";
    }
    
    $.get(url, function(data) {   
       $("#tableNameplate").append(data);
    });
}

function submitForm(){
    
    $('#ff').form('submit',{
        url:'json-app/nameplate_json/add',
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
                $.messager.alertLink('Info', infoSimpan, 'info', "app/index/<?=$pgreturn?>_add?reqId="+reqId);
        }
    });
}


function HapusTable(iddetil,form) {
    var Id ='<?=$reqId?>';
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/nameplate_json/deletedetail/?reqDetilId="+iddetil+"&reqId="+Id,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    $("#"+form+"-"+iddetil+"").remove();

                });
        }
    }); 
}


function clearForm(){
    $('#ff').form('clear');
}   
</script>