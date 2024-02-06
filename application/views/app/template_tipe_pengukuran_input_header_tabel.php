<?
$reqIdGenerate=$this->input->get("reqIdGenerate");

// print_r(expression);exit;

?>
<a href="javascript:void(0)" class="btn btn-primary" onclick="AddTabelHeaderKolom('<?=$reqIdGenerate?>')">Tambah Kolom</a>
 <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;width: 100%">
 	<thead>
 		<tr>
 			<th style="vertical-align : middle;text-align:center;width: 35%">Kolom</th>

 			<th style="vertical-align : middle;text-align:center;width: 15%">Rowspan</th>
 			<th style="vertical-align : middle;text-align:center;width: 15%">Colspan</th>

 			<th style="vertical-align : middle;text-align:center;width: 10%">Action</th>
 		</tr>
 	</thead>
 	<tbody id="tableInputHeaderKolom<?=$reqIdGenerate?>">

 	</tbody>
 </table>