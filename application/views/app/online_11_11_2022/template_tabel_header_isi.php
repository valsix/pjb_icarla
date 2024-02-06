<?
$reqBaris=$this->input->get("reqBaris");

// print_r(expression);exit;

?>
<tr >
	<td style="display: none">
		<input class='easyui-validatebox textbox form-control' type='text' name='reqDetilId[]' id='reqDetilId'  data-options='' style='' value="<?=$reqDetilId?>">
	</td>
	<td><input class='easyui-validatebox textbox form-control' type='text' name='reqKolom[]' id='reqKolom'  data-options=''  style='text-align:center;'></td>
	<td >
		<input class='easyui-validatebox textbox form-control' type='text' name='reqRowspan[]' id='reqRowspan'   data-options='' style='' value="">
	</td>
	<td >
		<input class='easyui-validatebox textbox form-control' type='text' name='reqColspan[]' id='reqColspan'   data-options='' style='' value="">
	</td>
	<td style="text-align:center"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' onclick="delete_baris('<?=$reqBaris?>')" aria-hidden='true'></i></a></span></td>
	<input type="hidden" name="reqBaris[]" id="reqBaris" value="<?=$reqBaris?>">
	<!-- <input type="hidden" name="reqBaris[]" id="reqBaris" value=""> -->
</tr>