<script language="javascript" type="text/javascript" src="assets/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="assets/tiny_mce/configTextEditorAdm.js"></script>
<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Pengukuran");
$this->load->model("base-app/JenisPengukuran");
$this->load->model("base-app/TipeInput");
$this->load->model("base-app/GroupState");
$this->load->model("base-app/Uom");
$this->load->model("base-app/TabelTemplate");
$this->load->model("base-app/PlanRlaFormUjiDinamis");


$pgreturn= str_replace("_add", "", $pg);

$pgtitle= $pgreturn;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$reqId = $this->input->get("reqId");
$reqLihat = $this->input->get("reqLihat");


$set= new Pengukuran();

if($reqId == "")
{
    $reqMode = "insert";
}
else
{
    $reqMode = "update";

    $statement = " AND A.PENGUKURAN_ID = '".$reqId."' ";
    $set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
    $set->firstRow();
    $reqId= $set->getField("PENGUKURAN_ID");
    // $reqJenisPengukuran= array(1,2);
    // print_r($reqJenisPengukuran);exit;
    $reqJenisPengukuran= getmultiseparator($set->getField("JENIS_PENGUKURAN_INFO"));
    // print_r($reqJenisPengukuran);exit;
    $reqEnjiniringId= $set->getField("ENJINIRINGUNIT_ID");
    $reqGroupId= $set->getField("GROUP_STATE_ID");
    $reqNama= $set->getField("NAMA");
    $reqNamaPengukuran= $set->getField("NAMA_PENGUKURAN");
    $reqKode= $set->getField("KODE");
    $reqTipeInputId= $set->getField("TIPE_INPUT_ID");
    $reqFormula= $set->getField("FORMULA");
    $reqStatusPengukuran= $set->getField("STATUS_PENGUKURAN");
    $reqCatatan= $set->getField("CATATAN");
    $reqSequence= $set->getField("SEQUENCE");
    $reqIsInterval= $set->getField("IS_INTERVAL");
    $reqStatus= $set->getField("STATUS");
    $reqTipePengukuran= getmultiseparator($set->getField("TIPE_PENGUKURAN_ID_INFO"));
    $reqAnalog= dotToComma($set->getField("ANALOG"));
    $reqText= $set->getField("TEXT_TIPE");
    $reqLinkFile= $set->getField("LINK_FILE");
    $reqGroupState= $set->getField("GROUP_STATE_ID");
    $reqUomId= $set->getField("UOM_ID");

    // $checkvalidasi= new PlanRlaFormUjiDinamis();
    // $statement = "  AND A.PENGUKURAN_ID = ".$reqId."";

    // $checkvalidasi->selectByParamsValidasiPengukuranTipeInput(array(), -1, -1, $statement);
    // // echo  $checkvalidasi->query;exit;
    // $checkvalidasi->firstRow();
    // $pengukuranidval= $checkvalidasi->getField("PENGUKURAN_ID");
    // unset($checkvalidasi);

    $checkvalidasi= new PlanRlaFormUjiDinamis();
    $statement = "  AND A.PENGUKURAN_ID = ".$reqId."";

    $arrvalidasi= [];
    $checkvalidasi->selectByParamsValidasiPengukuranTipeInput(array(), -1, -1, $statement);
    // echo  $checkvalidasi->query;exit;
    while($checkvalidasi->nextRow())
    {
        $arrdata= array();
        $arrdata["PENGUKURAN_ID"]= $checkvalidasi->getField("PENGUKURAN_ID");
        $arrdata["TABEL_TEMPLATE_ID"]= $checkvalidasi->getField("TABEL_TEMPLATE_ID");
        array_push($arrvalidasi, $arrdata);
    }
    // print_r($arrvalidasi);exit;
}

$set= new JenisPengukuran();
$arrjenjang= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("JENIS_PENGUKURAN_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrjenjang, $arrdata);
}
unset($set);

$set= new TipeInput();
$arrtipe= [];
$arrShowHideAll= [];
$statementcombo=" AND A.STATUS <> '1'  AND STATUS_TABLE IS NOT NULL ";
$set->selectByParamsCombo(array(), -1,-1, $statementcombo );
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("TIPE_INPUT_ID");
    $arrdata["idpeng"]= $set->getField("TIPE_PENGUKURAN_ID");
    $arrdata["idtipe"]= $set->getField("TIPE_INPUT_ID")."-".$set->getField("TIPE_PENGUKURAN_ID");
    $arrdata["nama"]= $set->getField("NAMA_TIPE_PENGUKURAN");
    $arrdata["text"]= $set->getField("NAMA");
    if($set->getField("STATUS_TABLE")=='PIC'){
        $arrShowHide['PIC'][]= $set->getField("TIPE_INPUT_ID");
    }
    if($set->getField("STATUS_TABLE")=='TEXT'){
        $arrShowHide['TEXT'][]= $set->getField("TIPE_INPUT_ID");
    }
    if($set->getField("STATUS_TABLE")=='TABLE'){
        $arrShowHide['TABLE'][]= $set->getField("TIPE_INPUT_ID");
    }
    if($set->getField("STATUS_TABLE")=='ANALOG'){
        $arrShowHide['ANALOG'][]= $set->getField("TIPE_INPUT_ID");
    }
    if($set->getField("STATUS_TABLE")=='BINARY'){
        $arrShowHide['BINARY'][]= $set->getField("TIPE_INPUT_ID");
    }
    array_push($arrtipe, $arrdata);
}
unset($set);
// print_r($arrShowHide);exit;

// if(in_array( 9 ,$arrShowHide['TABLE'] ))
// if(in_array( 5 ,$arrShowHide['PIC'] ))
// {
//     echo "A";
// }
// else
// {
//     echo "B";
// }
// exit;

$set= new GroupState();
$arrgroup= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("GROUP_STATE_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrgroup, $arrdata);
}
unset($set);

$set= new Uom();
$arruom= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("UOM_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arruom, $arrdata);
}
unset($set);

$disabled="";


if($reqLihat ==1)
{
    $disabled="disabled";  
}

$set= new Pengukuran();
$arrTipeInput= [];
$set->selectByParamsTipeInput(array("pengukuran_id"=>$reqId), -1,-1);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata["pengukuran_tipe_input_id"]= $set->getField("PENGUKURAN_TIPE_INPUT_ID");
    $arrdata["tipe_input_id"]= $set->getField("TIPE_INPUT_ID");
    $arrdata["seq"]= $set->getField("SEQ");
    $arrdata["master_table_id"]= $set->getField("MASTER_TABEL_ID");
    $arrdata["master_table_nama"]= $set->getField("TABEL_TEMPLATE_NAMA");
    $arrdata["value"]= $set->getField("value");
    array_push($arrTipeInput, $arrdata);
}
// print_r($arrTipeInput);exit;

$set= new TabelTemplate();
$arrComboTipePengukuran= [];
$set->selectByParams(array(), -1,-1);
$arrdata["id"]= '0';
$arrdata["text"]= 'Pilih';
array_push($arrComboTipePengukuran, $arrdata);
// echo $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("TABEL_TEMPLATE_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrComboTipePengukuran, $arrdata);
}
// print_r($arrComboTipePengukuran); exit;

unset($set);
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

.select2-selection__rendered {
    line-height: 31px !important;
}
.select2-container .select2-selection--single {
    height: 35px !important;
}
.select2-selection__arrow {
    height: 34px !important;
}


</style>

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
                        <label class="control-label col-md-2">Kode Pengukuran</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                   <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKode"  id="reqKode" value="<?=$reqKode?>" <?=$disabled?>  data-options="required:true" style="width:100%" />
                               </div>
                           </div>
                       </div>
                    </div>

                    <div class="form-group">  
                        <label class="control-label col-md-2">Nama </label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="<?=$reqNama?>" <?=$disabled?> data-options="required:true" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                 <!--    <div class="form-group">  
                        <label class="control-label col-md-2">Nama Pengukuran</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNamaPengukuran"  id="reqNamaPengukuran" value="<?=$reqNamaPengukuran?>"  style="width:100%" <?=$disabled?> />
                                </div>
                            </div>
                        </div>
                    </div>
 -->
                    <div class="form-group" style="display: none">  
                        <label class="control-label col-md-2">Tipe Input</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                <select class="form-control jscaribasicmultiple" id="reqTipePengukuran" <?=$disabled?> name="reqTipePengukuran[]" style="width:100%;" >
                                    <?
                                    foreach($arrtipe as $item) 
                                    {
                                        $selectvalid= $item["id"];
                                        $selectvalidpeng= $item["idtipe"];
                                        $selectvaltext= $item["text"];

                                        $selected="";
                                        if($selectvalid==$reqTipeInputId)
                                        {
                                            $selected="selected";
                                        }
                                        ?>
                                        <option value="<?=$selectvalidpeng?>" <?=$selected?>><?=$selectvaltext?></option>
                                        <?
                                    }
                                    ?>
                                </select>
                                <input autocomplete="off" type="hidden" name="reqTipeInputId"  id="reqTipeInputId" value="<?=$reqTipeInputId?>" style="width:100%" />
                                 
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">  
                        <label class="control-label col-md-2">Formula</label>
                        <div class='col-md-8'>
                            <div class='form-group'>
                                <div class='col-md-11'>
                                     <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqFormula"  id="reqFormula" value="<?=$reqFormula?>" <?=$disabled?> style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="status">
                        <div class="form-group" style="display: none">  
                            <label class="control-label col-md-2">Status Pengukuran</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                        <select name="reqStatusPengukuran" id="reqStatusPengukuran" class="easyui-validatebox textbox form-control" value="<?=$reqStatusPengukuran?>"  <?=$disabled?> >
                                            <option value=""></option>
                                            <option value="1"<?if($reqStatusPengukuran==1) echo 'selected' ?>>Normal</option>
                                            <option value="2"<?if($reqStatusPengukuran==2) echo 'selected' ?>>Alarm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Enjiniring Unit</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input  name="reqEnjiniringId" class="easyui-combobox form-control" id="reqEnjiniringId"
                                       data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/combo_json/comboenjiniring'" value="<?=$reqEnjiniringId?>" <?=$disabled?>  />
                                   </div>
                               </div>
                           </div>
                        </div>

                        <div class="form-group">  
                            <label class="control-label col-md-2">Catatan</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqCatatan"  id="reqCatatan" value="<?=$reqCatatan?>" <?=$disabled?> style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div>

                       <!--  <div class="form-group">  
                            <label class="control-label col-md-2">Sequence</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                         <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqSequence"  id="reqSequence" value="<?=$reqSequence?>" <?=$disabled?> style="width:100%" />
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <!-- <div id="testnew"> -->
                        <div class="form-group">  
                            <label class="control-label col-md-2">Is Interval</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-5'>
                                        <select name="reqIsInterval" id="reqIsInterval"  <?=$disabled?> class="easyui-validatebox textbox form-control">
                                            <option value=""></option>
                                            <option value="1" <?if($reqIsInterval==1) echo 'selected' ?>>Y</option>
                                            <option value="2" <?if($reqIsInterval==2) echo 'selected' ?>>N</option>
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
                                        <input   name="reqStatus" class="easyui-combobox form-control" id="reqStatus"
                                        data-options="width:'300',editable:false,valueField:'id',textField:'text',url:'json-app/Combo_json/combostatusaktif'" value="<?=$reqStatus?>" <?=$disabled?> required />
                                    </div>
                                </div>
                            </div>
                        </div>

                       <!--  <div class="form-group">  
                            <label class="control-label col-md-2">Catatan</label>
                            <div class='col-md-8'>
                                <div class='form-group'>
                                    <div class='col-md-11'>
                                       <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqCatatan"  id="reqCatatan" value="<?=$reqCatatan?>" <?=$disabled?> style="width:100%" />
                                   </div>
                               </div>
                           </div>
                        </div> -->
                        <?
                        if(!empty($reqId))
                        {
                        ?>
                        <div class="form-group">  
                            <label class="control-label col-md-2">Input Tipe Pengukuran</label>
                            <div class='col-md-4'>
                                <div class='form-group'>
                                    <div class='col-md-12'>
                                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddRowTable()">Tambah</a>
                                        <!-- <div style="width:300%; overflow: scroll; height: 300px;margin-top: 30px;"> -->
                                        <div style="width:200%; height: 100%;margin-top: 30px;">
                                            <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;max-width: 10000px !important;width: 125%;">
                                                <thead>
                                                    <tr>
                                                          <th style="vertical-align : middle;text-align:center;" width="10%">Seq</th>
                                                          <th style="vertical-align : middle;text-align:center;" >Tipe Input</th>
                                                          <th style="vertical-align : middle;text-align:center;" >Label / Template Tabel</th>
                                                          <th style="vertical-align : middle;text-align:center;" width="10%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableTipeUkuran">
                                                    <?
                                                    $keyvalidasi=0;
                                                    $arrchecktipeinput=[];
                                                    foreach($arrTipeInput as $item) 
                                                    {
                                                        $tipe_input_id= $item["tipe_input_id"];
                                                        $pengukuran_tipe_input_id= $item["pengukuran_tipe_input_id"];
                                                        $seq= $item["seq"];
                                                        $master_table_id= $item["master_table_id"];
                                                        $master_table_nama= $item["master_table_nama"];
                                                        $value= $item["value"];
                                                        $arrchecktipeinput[]=$pengukuran_tipe_input_id;
                                                    ?>

                                                        <tr id="irpibeforedetil-<?=$selectvalid?>" >
                                                            <input type="hidden" name="reqPengukuranTipeInputId[]" value="<?=$pengukuran_tipe_input_id?>">
                                                            <td>
                                                                <input class='easyui-validatebox textbox form-control' type='text' name='reqSeq[]' id='reqSeq' value='<?=$seq?>' data-options='' style='width:100%'>
                                                            </td>
                                                            <td>
                                                                <!-- <?=$tipe_input_id?> -->
                                                                <select class="form-control jscaribasicmultiple" id="reqTipePengukuranDetail-<?=$pengukuran_tipe_input_id?>" <?=$disabled?> name="reqTipePengukuranDetail[]" style="width:100%;" onchange="showHideTipePengukuran(<?=$pengukuran_tipe_input_id?>)">
                                                                    <?
                                                                    foreach($arrtipe as $item) 
                                                                    {
                                                                        $selectvalid= $item["id"];
                                                                        $selectvalidpeng= $item["idtipe"];
                                                                        $selectvaltext= $item["text"];

                                                                        $selected="";
                                                                        if($selectvalid==$tipe_input_id)
                                                                        {
                                                                            $selected="selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
                                                                        <?
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <?
                                                                $infodisplay= "none";
                                                                if(in_array( $tipe_input_id ,$arrShowHide['TABLE'] ))
                                                                    $infodisplay= "";
                                                                ?>
                                                                <input type="hidden" id="vTipePengukuranField-<?=$pengukuran_tipe_input_id?>" name="vTipePengukuranTable[]" value="<?=$infodisplay?>" />
                                                                <!-- <br/>TABLE:<?=$tipe_input_id?><br/> -->
                                                                <div id="reqTipePengukuranField-<?=$pengukuran_tipe_input_id?>" style="display: <?=$infodisplay?> !important">
                                                                    <select class="form-control tipepengukurantable " id="reqTipePengukuran-<?=$pengukuran_tipe_input_id?>" <?=$disabled?> name="reqTipePengukuranTable[]" style="width:50%; <?if(in_array( $tipe_input_id ,$arrShowHide )){}else{?> display: none !important<?}?>;">
                                                                        <option value="<?=$master_table_id?>"><?=$master_table_nama?></option>
                                                                        <?
                                                                        /*foreach($arrComboTipePengukuran as $item) 
                                                                        {
                                                                            $selectvalid= $item["id"];
                                                                            $selectvaltext= $item["text"];

                                                                            $selected="";
                                                                            if($selectvalid==$master_table_id)
                                                                            {
                                                                                $selected="selected";
                                                                            }*/
                                                                            ?>
                                                                            <!-- <option value="<?=$selectvalid?>" <?=$selected?>  <?if($selectvalid==''){?> disabled <?}?>><?=$selectvaltext?></option> -->
                                                                            <?
                                                                        // }
                                                                        ?>
                                                                    </select>
                                                                    <br/><br/>
                                                                    <span style="background-color: green;padding: 8px; border-radius: 5px;color: white">
                                                                        <a onclick="copastemplatetable('<?=$pengukuran_tipe_input_id?>')">
                                                                            Copy
                                                                        </a>
                                                                    </span>
                                                                    &nbsp;
                                                                    <span style="background-color: green;padding: 8px; border-radius: 5px;color: white">
                                                                        <a onclick="openPreview(<?=$pengukuran_tipe_input_id?>)">
                                                                            Preview
                                                                        </a>
                                                                    </span>
                                                                    &nbsp;
                                                                    <span style="background-color: blue;padding: 8px; border-radius: 5px;color: white">
                                                                        <a onclick="popuptemplatetable('tambah', '<?=$pengukuran_tipe_input_id?>')">
                                                                             Tambah
                                                                        </a>
                                                                    </span>
                                                                    &nbsp;
                                                                    <span style="background-color: blue;padding: 8px; border-radius: 5px;color: white">
                                                                        <a onclick="popuptemplatetable('ubah', '<?=$pengukuran_tipe_input_id?>')">
                                                                             Ubah
                                                                        </a>
                                                                    </span>
                                                                    <!-- <i class="fa fa-plus-square fa-lg" aria-hidden="true"></i>&nbsp;  -->
                                                                </div>

                                                                <?
                                                                $infodisplay= "none";
                                                                if(in_array( $tipe_input_id ,$arrShowHide['PIC'] ))
                                                                    $infodisplay= "";
                                                                ?>
                                                                <input type="hidden" id="vTipePengukuranFieldPic-<?=$pengukuran_tipe_input_id?>" name="vTipePengukuranGambar[]" value="<?=$infodisplay?>" />
                                                                <!-- <br/>PIC:<?=$tipe_input_id?><br/> -->
                                                                <div id="reqTipePengukuranFieldPic-<?=$pengukuran_tipe_input_id?>" style="display: <?=$infodisplay?> !important">
                                                                    
                                                                    <!-- <input  name="reqTipePengukuranFile[]"  id="reqLampiran" type="file"   <?=$disabled?>/> -->
                                                                    <!-- <input  name="reqTipePengukuranFileTemp[]"  id="reqLampiran" type="hidden"  value="<?=$value?>" <?=$disabled?>/> -->

                                                                    <input type="text" name="reqTipePengukuranGambar[]" id="reqPic-<?=$pengukuran_tipe_input_id?>" value="<?=$value?>" class="easyui-validatebox textbox form-control" >
                                                                    <?
                                                                    if(!empty($value))
                                                                    {
                                                                    ?>
                                                                       <!--  <img src="<?=$value?>" style="width: 200px;" /> -->
                                                                    <? 
                                                                    }
                                                                    ?>
                                                                </div>

                                                                <?
                                                                $infodisplay= "none";
                                                                if(in_array( $tipe_input_id ,$arrShowHide['TEXT'] ))
                                                                    $infodisplay= "";
                                                                ?>
                                                                <input type="hidden" id="vTipePengukuranFieldText-<?=$pengukuran_tipe_input_id?>" name="vTipePengukuranDesc[]" value="<?=$infodisplay?>" />
                                                                <!-- <br/>TEXT:<?=$tipe_input_id?><br/> -->
                                                                <div id="reqTipePengukuranFieldText-<?=$pengukuran_tipe_input_id?>" style="display: <?=$infodisplay?> !important">
                                                                    <!-- <textarea style="width:100%" name="reqTipePengukuranDesc[]"><?=$value?></textarea> -->

                                                                    <input type="text" name="reqTipePengukuranDesc[]" id="reqText-<?=$pengukuran_tipe_input_id?>" value="<?=$value?>" class="easyui-validatebox textbox form-control" >
                                                                </div>

                                                                <?
                                                                $infodisplay= "none";
                                                                if(in_array( $tipe_input_id ,$arrShowHide['ANALOG'] ))
                                                                    $infodisplay= "";
                                                                ?>
                                                                <input type="hidden" id="vTipePengukuranFieldAnalog-<?=$pengukuran_tipe_input_id?>" name="vTipePengukuranAnalog[]" value="<?=$infodisplay?>" />
                                                                <!-- <br/>ANALOG:<?=$tipe_input_id?><br/> -->
                                                                <div id="reqTipePengukuranFieldAnalog-<?=$pengukuran_tipe_input_id?>" style="display: <?=$infodisplay?> !important">
                                                                    <input type="text" name="reqTipePengukuranAnalog[]" id="reqAnalog-<?=$pengukuran_tipe_input_id?>" value="<?=$value?>" class="easyui-validatebox textbox form-control" >
                                                                </div>

                                                                <?
                                                                $infodisplay= "none";
                                                                if(in_array( $tipe_input_id ,$arrShowHide['BINARY'] ))
                                                                    $infodisplay= "";
                                                                ?>
                                                                <input type="hidden" id="vTipePengukuranFieldBinary-<?=$pengukuran_tipe_input_id?>" name="vTipePengukuranBinary[]" value="<?=$infodisplay?>" />
                                                                <!-- <br/>BINARY:<?=$tipe_input_id?><br/> -->
                                                                <div id="reqTipePengukuranFieldBinary-<?=$pengukuran_tipe_input_id?>" style="display: <?=$infodisplay?> !important">
                                                                    <input type="text" name="reqTipePengukuranBinary[]" id="reqBinary-<?=$pengukuran_tipe_input_id?>" value="<?=$value?>" class="easyui-validatebox textbox form-control " >
                                                                </div>
                                                            </td>
                                                            <?
                                                            if(empty($arrvalidasi[$keyvalidasi]["TABEL_TEMPLATE_ID"]))
                                                            {
                                                            ?>
                                                            <td>
                                                                <span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;' onclick="hapusTipeInput(<?=$pengukuran_tipe_input_id?>)">
                                                                <a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a>
                                                                </span>
                                                            </td>
                                                            <?
                                                            }
                                                            ?>
                                                        </tr>

                                                    <?
                                                        $keyvalidasi++;
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                               </div>
                           </div>
                        </div>
                        <?
                        }
                        ?>
                    <!-- </div> -->

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
                <?
                if(!empty($arrTipeInput) && !empty($reqId) )
                {
                ?>
                <a class="btn btn-success" onclick="openPreviewAll()">Preview</a>
                <?
                 }
                ?>
            </div>
            <?
            }
            ?>
            
        </div>
    </div>
    
</div>

<script>
$(document).ready(function(){

    $(document).on('keydown', '#reqKode', function(e) {
        if (e.keyCode == 32) return false;
    });

    $(".allow_decimal").on("input", function(evt) {
       var self = $(this);
       self.val(self.val().replace(/[^0-9\,]/g, ''));
       if ((evt.which != 46 || self.val().indexOf(',') != -1) && (evt.which < 48 || evt.which > 57)) 
       {
         evt.preventDefault();
       }
    });

    function tampiltabletemplate(val) {
        if (val.loading) return val.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'>" + val.description + "</div>" +
        "</div>" +
        "</div>";
        return markup;
    }

    function pilihtabletemplate(val) {
        // $("#reqUnitId").val(val.id);
        // $("#reqUnit").val(val.text);
        
        // console.log(val);
        return val.text;
    }

    $(".tipepengukurantable").select2({
        placeholder: "Pilih Ta",
        allowClear: true,
        ajax: {
            url: "json-app/combo_json/autocompletetabletemplate",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                    , page: params.page
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items
                    , pagination: {
                        more: (params.page * 30) < data.total_count && data.items != ""
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: tampiltabletemplate, // omitted for brevity, see the source of this page
        templateSelection: pilihtabletemplate // omitted for brevity, see the source of this page
    });

    /*$('#textbox').hide();
    $('#picture').hide(); 
    // $('#testnew').hide();
    $('#status').hide();
    $('#binary').hide();
    $('#analog').hide();
    var str =$('#reqTipePengukuran').val();
    // console.log(str);
    var getInputId = str.split('-').slice(0,1);
    var str = str.substr(str.indexOf("-") + 1);
    var binary = str.indexOf('0') != -1;
    var analog = str.indexOf('1') != -1;
    var texttipe = str.indexOf('2') != -1;
    var pict = str.indexOf('3') != -1;
    var reqTipeInputId= getInputId[0];

    $('#reqTipeInputId').val(reqTipeInputId);
    if(binary==true)
    {
        $('#binary').show();  
        $('#status').show();
        $('#picture').hide(); 
        $('#textbox').hide();
    }
    if(analog==true)
    {
        $('#status').show();
        $('#analog').show();
        if(texttipe==false)
        {
            $('#textbox').hide(); 
        }
        $('#binary').hide();
        $('#picture').hide();
        $('#binary').hide(); 
    }
    if(texttipe==true)
    {
        if(pict==false)
        {
            $('#picture').hide(); 
        }
        if(analog==false)
        {
            $('#analog').hide(); 
        }
        $('#textbox').show(); 
        $('#status').show();
        $('#binary').hide();

    }
    if(pict==true)
    {
        if(texttipe==false)
        {
            $('#textbox').hide(); 
        }
        if(analog==false)
        {
            $('#analog').hide(); 
        }
        $('#picture').show();  
        $('#status').show();
        $('#binary').hide(); 
    }

    $('#reqTipePengukuran').change(function() { 
        var str =$('#reqTipePengukuran').val();
        var getInputId = str.split('-').slice(0,1);
        var str = str.substr(str.indexOf("-") + 1);

        var reqTipeInputId= getInputId[0];
       
        $('#reqTipeInputId').val(reqTipeInputId);
        var binary = str.indexOf('0') != -1;
        var analog = str.indexOf('1') != -1;
        var texttipe = str.indexOf('2') != -1;
        var pict = str.indexOf('3') != -1;
        if(binary==true)
        {
            $('#binary').show();  
            $('#status').show();
            $('#picture').hide(); 
            $('#textbox').hide();
            $('#analog').hide();
            $('#reqAnalog').val("");
            $('#reqText').val("");
         }
        if(analog==true)
        {
            $('#status').show();
            if(texttipe==false)
            {
                $('#textbox').hide(); 
            }
            $('#binary').hide();
            $('#picture').hide();
            $('#binary').hide();
            $('#analog').show(); 
            $('#reqText').val("");
            $('#reqGroupState').val("");
        }
        if(texttipe==true)
        {
            if(pict==false)
            {
                $('#picture').hide(); 
            }
            if(analog==false)
            {
                $('#analog').hide(); 
            }
            $('#textbox').show(); 
            $('#status').show();
            $('#binary').hide();
            
            $('#reqAnalog').val(""); 

        }
        if(pict==true)
        {
            if(texttipe==false)
            {
                $('#textbox').hide(); 
            }
            if(analog==false)
            {
                $('#analog').hide(); 
            }
            $('#picture').show();  
            $('#status').show();
            $('#binary').hide();
            $('#reqAnalog').val(""); 
            $('#reqText').val("");
        }  
    }); */

})

function submitForm(){
    $('#ff').form('submit',{
        url:'json-app/pengukuran_json/add',
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

function clearForm(){
    $('#ff').form('clear');
}

function delete_gambar()
{
    $.messager.confirm('Konfirmasi',"Hapus gambar?",function(r){
        if (r){
            $.getJSON("json-app/pengukuran_json/delete_gambar/?reqId=<?=$reqId?>",
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    valinfoid= "";
                    location.reload();
                });
        }
    }); 
}

function hapusTipeInput(val)
{
    $.messager.confirm('Konfirmasi',"Hapus Tipe Input?",function(r){
        if (r){
            $.getJSON("json-app/pengukuran_json/delete_tipeinput/?reqId="+val+"&reqPengukuranId=<?=$reqId?>",
                function(data){
                    // console.log(data);return false;
                    $.messager.alert('Info', data.PESAN, 'info');
                    valinfoid= "";
                    location.reload();
                });
        }
    }); 
}

function copastemplatetable(vindex)
{
    vid= $("#reqTipePengukuran-"+vindex).val();
    // console.log(vid); return false;
    openAdd('app/index/master_template_tabel_copas?reqId='+vid);
}

function popuptemplatetable(vmode, vindex)
{
    vid= "";
    if(vmode == "ubah")
    {
        vid= $("#reqTipePengukuran-"+vindex).val();
    }
    // console.log(vindex+"--"+vid);
    openAdd('app/index/master_template_tabel_add?kembali=master_template_tabel_add&reqId='+vid);
}

function openPreview(reqId)
{
    var tempValId= $('#reqTipePengukuran-'+reqId).val();
    // console.log(tempValId); return false;
    openAdd('app/index/master_template_tabel_preview?reqId='+tempValId);
}

function openPreviewAll(reqId)
{
    openAdd('app/index/master_template_tabel_preview_all?reqId=<?=$reqId?>');
} 

function AddRowTable() {
    $.get("app/loadUrl/app/template_master_pengukuran", function(data) { 
        $("#tableTipeUkuran").append(data);
    });
}

function showHideTipePengukuran(val){
    var tempValId= $('#reqTipePengukuranDetail-'+val).val();
    var checktipe = <?php echo json_encode($arrchecktipeinput)?>;

    var data = <?php echo json_encode($arrShowHide['TABLE'])?>;
    if(data.includes(tempValId)==true){
        $("#reqText-"+val+", #reqPic-"+val+", #reqBinary-"+val+", #reqAnalog-"+val).val("");

        $("#vTipePengukuranField-"+val+", #vTipePengukuranFieldPic-"+val+", #vTipePengukuranFieldText-"+val+", #vTipePengukuranFieldAnalog-"+val+", #vTipePengukuranFieldBinary-"+val).val("none");
        $("#vTipePengukuranField-"+val).val("");

        document.getElementById("reqTipePengukuranField-"+val).style.display = "block";
        document.getElementById("reqTipePengukuranFieldPic-"+val).style.display = "none";
        document.getElementById("reqTipePengukuranFieldText-"+val).style.display = "none";
        document.getElementById("reqTipePengukuranFieldAnalog-"+val).style.display = "none";
        document.getElementById("reqTipePengukuranFieldBinary-"+val).style.display = "none";

        jQuery.each(checktipe, function(index, item) {

            if(item==val)
            {}
            else
            {
                $('#reqTipePengukuranField-'+item+':hidden').val(""); 
            }
        
        }); 
    }

    var data = <?php echo json_encode($arrShowHide['TEXT'])?>;
    // console.log(data);
    if(data.includes(tempValId)==true){
        // reqTipePengukuranDesc
        // tinymceinit();

        $("#reqTipePengukuranField-"+val+", #reqPic-"+val+", #reqBinary-"+val+", #reqAnalog-"+val).val(""); 

        $("#vTipePengukuranField-"+val+", #vTipePengukuranFieldPic-"+val+", #vTipePengukuranFieldText-"+val+", #vTipePengukuranFieldAnalog-"+val+", #vTipePengukuranFieldBinary-"+val).val("none");
        $("#vTipePengukuranFieldText-"+val).val("");

        document.getElementById("reqTipePengukuranField-"+val).style.display = "none"; 
        document.getElementById("reqTipePengukuranFieldPic-"+val).style.display = "none"; 
        document.getElementById("reqTipePengukuranFieldText-"+val).style.display = "block";
        document.getElementById("reqTipePengukuranFieldAnalog-"+val).style.display = "none"; 
        document.getElementById("reqTipePengukuranFieldBinary-"+val).style.display = "none";  

        jQuery.each(checktipe, function(index, item) {

            if(item==val)
            {}
            else
            {
                $('#reqText-'+item+':hidden').val(""); 
            }
        
        }); 
    }

    var data = <?php echo json_encode($arrShowHide['PIC'])?>;
    if(data.includes(tempValId)==true){
        $("#reqTipePengukuranField-"+val+", #reqText-"+val+", #reqBinary-"+val+", #reqAnalog-"+val).val(""); 

        $("#vTipePengukuranField-"+val+", #vTipePengukuranFieldPic-"+val+", #vTipePengukuranFieldText-"+val+", #vTipePengukuranFieldAnalog-"+val+", #vTipePengukuranFieldBinary-"+val).val("none");
        $("#vTipePengukuranFieldPic-"+val).val("");

        document.getElementById("reqTipePengukuranField-"+val).style.display = "none"; 
        document.getElementById("reqTipePengukuranFieldPic-"+val).style.display = "block"; 
        document.getElementById("reqTipePengukuranFieldText-"+val).style.display = "none";
        document.getElementById("reqTipePengukuranFieldAnalog-"+val).style.display = "none"; 
        document.getElementById("reqTipePengukuranFieldBinary-"+val).style.display = "none"; 

        jQuery.each(checktipe, function(index, item) {

            if(item==val)
            {}
            else
            {
                $('#reqPic-'+item+':hidden').val(""); 
            }
        
        }); 
    }

    var data = <?php echo json_encode($arrShowHide['ANALOG'])?>;
    if(data.includes(tempValId)==true){
        $("#reqTipePengukuranField-"+val+", #reqText-"+val+", #reqPic-"+val+", #reqBinary-"+val).val(""); 

        $("#vTipePengukuranField-"+val+", #vTipePengukuranFieldPic-"+val+", #vTipePengukuranFieldText-"+val+", #vTipePengukuranFieldAnalog-"+val+", #vTipePengukuranFieldBinary-"+val).val("none");
        $("#vTipePengukuranFieldAnalog-"+val).val("");

        document.getElementById("reqTipePengukuranField-"+val).style.display = "none"; 
        document.getElementById("reqTipePengukuranFieldPic-"+val).style.display = "none"; 
        document.getElementById("reqTipePengukuranFieldText-"+val).style.display = "none";
        document.getElementById("reqTipePengukuranFieldAnalog-"+val).style.display = "block"; 
        document.getElementById("reqTipePengukuranFieldBinary-"+val).style.display = "none";  

        jQuery.each(checktipe, function(index, item) {

            if(item==val)
            {}
            else
            {
                $('#reqAnalog-'+item+':hidden').val(""); 
            }
        
        }); 
    }

    var data = <?php echo json_encode($arrShowHide['BINARY'])?>;
    if(data.includes(tempValId)==true){
        console.log(val);
        // $("#reqTipePengukuranField-"+val+", #reqText-"+val+", #reqPic-"+val+", #reqAnalog-"+val).val(""); 
        $("#reqTipePengukuranField-"+val+", #reqText-"+val+", #reqPic-"+val+", #reqAnalog-"+val).val(""); 

        $("#vTipePengukuranField-"+val+", #vTipePengukuranFieldPic-"+val+", #vTipePengukuranFieldText-"+val+", #vTipePengukuranFieldAnalog-"+val+", #vTipePengukuranFieldBinary-"+val).val("none");
        $("#vTipePengukuranFieldBinary-"+val).val("");

        document.getElementById("reqTipePengukuranField-"+val).style.display = "none"; 
        document.getElementById("reqTipePengukuranFieldPic-"+val).style.display = "none"; 
        document.getElementById("reqTipePengukuranFieldText-"+val).style.display = "none";
        document.getElementById("reqTipePengukuranFieldAnalog-"+val).style.display = "none"; 
        document.getElementById("reqTipePengukuranFieldBinary-"+val).style.display = "block"; 
        jQuery.each(checktipe, function(index, item) {
           
            if(item==val)
            {

            }
            else
            {
                $('#reqBinary-'+item+':hidden').val("");
            }
        
        }); 
    }
}
</script>