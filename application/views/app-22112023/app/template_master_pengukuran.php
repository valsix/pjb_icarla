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
        <input type="hidden" id="vTipePengukuranField-<?=$rand?>" name="vTipePengukuranTable[]" value="<?=$infodisplay?>" />
		<div id="reqTipePengukuranField-<?=$rand?>" style="display: none !important">
			<select class="form-control tipepengukurantable " id="reqTipePengukuran-<?=$rand?>" <?=$disabled?> name="reqTipePengukuranTable[]" style="width:50%; display: none;">
	            <?
                /*foreach($arrComboTipePengukuran as $item) 
                {
                    $selectvalid= $item["id"];
                    $selectvaltext= $item["text"];*/
                    ?>
                     <!-- <option value="<?=$selectvalid?>" <?=$selected?>  <?if($selectvalid=='0'){?> disabled selected <?}?>><?=$selectvaltext?></option> -->
                    <?
                // }
                ?>
	        </select>
            <br/><br/>
            <span style="background-color: green;padding: 8px; border-radius: 5px;color: white">
                <a onclick="copastemplatetable('<?=$rand?>')">
                    Copy
                </a>
            </span>
            &nbsp;
            <span style="background-color: green;padding: 8px; border-radius: 5px;color: white">
                <a onclick="openPreview(<?=$rand?>)">
                    Preview
                </a>
            </span>
            &nbsp;
            <span style="background-color: blue;padding: 8px; border-radius: 5px;color: white">
                <a onclick="popuptemplatetable('tambah', '<?=$rand?>')">
                     Tambah
                </a>
            </span>
            &nbsp;
            <span style="background-color: blue;padding: 8px; border-radius: 5px;color: white">
                <a onclick="popuptemplatetable('ubah', '<?=$rand?>')">
                     Ubah
                </a>
            </span>
        </div>

        <input type="hidden" id="vTipePengukuranFieldPic-<?=$rand?>" name="vTipePengukuranGambar[]" value="<?=$infodisplay?>" />
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

        <input type="hidden" id="vTipePengukuranFieldText-<?=$rand?>" name="vTipePengukuranDesc[]" value="<?=$infodisplay?>" />
        <div id="reqTipePengukuranFieldText-<?=$rand?>" style="display: none !important">
      		
            <!-- <textarea style="width:100%" name="reqTipePengukuranDesc[]" id="reqTipePengukuranDesc-<?=$rand?>"></textarea> -->
            <input type="text" name="reqTipePengukuranDesc[]"  id="reqTipePengukuranDesc-<?=$rand?>"class="easyui-validatebox textbox form-control" >

        </div>

        <input type="hidden" id="vTipePengukuranFieldAnalog-<?=$rand?>" name="vTipePengukuranAnalog[]" value="<?=$infodisplay?>" />
        <div id="reqTipePengukuranFieldAnalog-<?=$rand?>" style="display: none !important">
      		
            <!-- <textarea style="width:100%" name="reqTipePengukuranDesc[]" id="reqTipePengukuranDesc-<?=$rand?>"></textarea> -->
            <input type="text" name="reqTipePengukuranAnalog[]"  id="reqTipePengukuranAnalog-<?=$rand?>"class="easyui-validatebox textbox form-control" >

        </div>

        <input type="hidden" id="vTipePengukuranFieldBinary-<?=$rand?>" name="vTipePengukuranBinary[]" value="<?=$infodisplay?>" />
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

<script type="text/javascript">
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
</script>