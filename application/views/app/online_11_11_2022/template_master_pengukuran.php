<?
$this->load->model("base-app/TipeInput");
$this->load->model("base-app/TabelTemplate");

$set= new TipeInput();
$arrtipe= [];
$statementcombo=" AND A.STATUS <> '1' ";

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
    array_push($arrtipe, $arrdata);
}

$set= new TabelTemplate();
$arrComboTipePengukuran= [];
$set->selectByParams(array(), -1,-1);
// echo $set->query;exit;
$arrdata["id"]= '0';
$arrdata["text"]= 'Pilih';
array_push($arrComboTipePengukuran, $arrdata);
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["id"]= $set->getField("TABEL_TEMPLATE_ID");
    $arrdata["text"]= $set->getField("NAMA");
    array_push($arrComboTipePengukuran, $arrdata);
}

$rand=rand();
?>
<tr>
	<script type="text/javascript">
	    $(document).ready(function() {
	        $('.jscaribasicmultiple').select2();
	    });
	</script>
	<input type="hidden" name="reqPengukuranTipeInputId[]">
	<td><input class='easyui-validatebox textbox form-control' type='text' name='reqSeq[]' id='reqSeq' value='' data-options='' style='width:100%'>
	</td>
	<td>
		<select class="form-control jscaribasicmultiple" id="reqTipePengukuranDetail-<?=$rand?>" <?=$disabled?> name="reqTipePengukuranDetail[]" style="width:100%;" onchange='showHideTipePengukuran(<?=$rand?>)'>
			<option value="" >Pilih Tipe Input</option>
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
	            <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectvaltext?></option>
	            <?
	        }
	        ?>
	    </select>
	</td>
	<td>
		<div id="reqTipePengukuranField-<?=$rand?>" style="display: none !important">
			<select class="form-control jscaribasicmultiple " id="reqTipePengukuran-<?=$rand?>" <?=$disabled?> name="reqTipePengukuranTable[]" style="width:50%; display: none;">
	            <?
                foreach($arrComboTipePengukuran as $item) 
                {
                    $selectvalid= $item["id"];
                    $selectvaltext= $item["text"];
                    ?>
                     <option value="<?=$selectvalid?>" <?=$selected?>  <?if($selectvalid=='0'){?> disabled selected <?}?>><?=$selectvaltext?></option>
                    <?
                }
                ?>
	        </select>
	        <span style="background-color: green;padding: 8px; border-radius: 5px;color: white"><a onclick="openPreview(<?=$rand?>)">Preview</a> </span>
        </div>
        <div id="reqTipePengukuranFieldPic-<?=$rand?>" style="display: none !important">
                                                                    
           <!--  <input  name="reqTipePengukuranFile[]"  id="reqLampiran" type="file"   <?=$disabled?>/>
            <input  name="reqTipePengukuranFileTemp[]"  id="reqLampiran" type="hidden"   <?=$disabled?>/> -->
            <input type="text" name="reqTipePengukuranGambar[]" value="" class="easyui-validatebox textbox form-control" >

            <?
            if(!empty($reqLampiran))
            {
            ?>
                <!-- <a href="<?=$reqLampiran?>" target="_blank"><img src="images/icon-download.png"></a> -->
            <? 
            }
            ?>

        </div>
        <div id="reqTipePengukuranFieldText-<?=$rand?>" style="display: none !important">
      		
            <!-- <textarea style="width:100%" name="reqTipePengukuranDesc[]" id="reqTipePengukuranDesc-<?=$rand?>"></textarea> -->
            <input type="text" name="reqTipePengukuranDesc[]"  id="reqTipePengukuranDesc-<?=$rand?>"class="easyui-validatebox textbox form-control" >

        </div>
        <div id="reqTipePengukuranFieldAnalog-<?=$rand?>" style="display: none !important">
      		
            <!-- <textarea style="width:100%" name="reqTipePengukuranDesc[]" id="reqTipePengukuranDesc-<?=$rand?>"></textarea> -->
            <input type="text" name="reqTipePengukuranAnalog[]"  id="reqTipePengukuranAnalog-<?=$rand?>"class="easyui-validatebox textbox form-control" >

        </div>
        <div id="reqTipePengukuranFieldBinary-<?=$rand?>" style="display: none !important">
      		
            <!-- <textarea style="width:100%" name="reqTipePengukuranDesc[]" id="reqTipePengukuranDesc-<?=$rand?>"></textarea> -->
            <input type="text" name="reqTipePengukuranBinary[]"  id="reqTipePengukuranBinary-<?=$rand?>"class="easyui-validatebox textbox form-control" >

        </div>
	</td>
	<td>
		<span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;' onclick="$(this).parent().parent().remove();">
		<a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a>
		</span>
	</td>
</tr>