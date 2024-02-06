<?
$reqBaris=$this->input->get("reqBaris");

// print_r(expression);exit;

?>
<a href="javascript:void(0)" class="btn btn-primary" onclick="AddTabelHeaderBarisDinamis('<?=$reqBaris?>')">Tambah Kolom</a>
 <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;width: 100%">
 	<thead>
 		<tr>
 			<th style="vertical-align : middle;text-align:center;width: 35%">Kolom</th>

 			<th style="vertical-align : middle;text-align:center;width: 15%">Rowspan</th>
 			<th style="vertical-align : middle;text-align:center;width: 15%">Colspan</th>

 			<th style="vertical-align : middle;text-align:center;width: 10%">Action</th>
 		</tr>
 	</thead>
 	<tbody id="tableInputHeader<?=$reqBaris?>">
 		<!-- <input type="hidden" name="reqHeaderId[]" id="reqHeaderId" value=""> -->
 		<input type="hidden" name="reqBaris[]" id="reqBaris" value="<?=$reqBaris?>">
 	</tbody>
 </table>