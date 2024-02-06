<?

$reqTipePengukuranId= $this->input->get("reqTipePengukuranId");
$reqId=$this->input->get("reqId");
$reqTabelId=$this->input->get("reqTabelId");

// print_r($reqId);exit;
$this->load->model('base-app/FormUji');
$this->load->model('base-app/TabelTemplate');



$set= new FormUji();

$arrpengukuran= [];

$statement = " AND A.PENGUKURAN_ID = ".$reqTipePengukuranId." AND STATUS_TABLE = 'TABLE' AND A.MASTER_TABEL_ID = '".$reqTabelId."'  ";
$set->selectByParamsPengukuran(array(), -1, -1, $statement);
 // echo $set->query;exit; 

$set->firstRow();

$tabelid= $set->getField("MASTER_TABEL_ID");
$pengukuranid= $set->getField("PENGUKURAN_ID");
$pengukurantipeid= $set->getField("PENGUKURAN_TIPE_INPUT_ID");
$statustabel= $set->getField("STATUS_TABLE");

$tipeinputid=$set->getField("TIPE_INPUT_ID");


unset($set);

$set= new TabelTemplate();


$statement = " AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' ";
$set->selectByParamsMaxBaris(array(), -1, -1, $statement);
 // echo $set->query;exit; 
$set->firstRow();
$maxbaris= $set->getField("MAX");

// var_dump($maxbaris);exit;
unset($set);


$set= new TabelTemplate();

$statement = " AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' ";
$set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
$set->firstRow();
$reqTotal= $set->getField("TOTAL");
$reqNama= $set->getField("NAMA");

$reqNoteAtas= $set->getField("NOTE_ATAS");
$reqNoteBawah= $set->getField("NOTE_BAWAH");
unset($set);


 // echo $set->query;exit; 

unset($set);
?>
<tr>
	<?
	if(!empty($reqTotal))
	{
		for ($i=1; $i < $reqTotal + 1; $i++) 
		{
		?>
			<?
			if ($i==1)
			{
				?> 
				<td><input class='easyui-validatebox textbox form-control' type='text' name='reqNamaKolom[]' id='reqNamaKolom' value='<?=$reqNamaKolom?>' data-options='' style='width:100%'></td>
				<td style="display: none"><input class='easyui-validatebox textbox form-control' type='text' name='reqStatusTabel[]' id='reqStatusTabel' value='TABLE' data-options='' style='width:100%'></td>
				<?
			}
			else
			{
				?>
				<td><input class='easyui-validatebox textbox form-control' type='text' name='' id='' value='' disabled style='width:100%'></td>
				<?
			}
			?>
		<?
		}
	}
	?>
	<td>
		<span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusBaris("<?=$pengukuranid?>","<?=$pengukurantipeid?>","<?=$tabelid?>")' class='btn-remove'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
	</td>
	<input type='hidden' name='reqTabelId[]' id='reqTabelId' value='<?=$tabelid?>' >
	<input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
	<input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
	<input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$reqTipePengukuranId?>' >
	<input type='hidden' name='reqFormDetilId[]' id='reqFormDetilId' value='<?=$reqFormDetilId?>' > 
	<input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
</tr>