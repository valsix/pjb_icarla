<?
$reqNama	 = $this->input->post("reqNama");
$reqEquipmentFormUjiId = $this->input->post("reqEquipmentId");
$reqFormUjiEquipmentId = $this->input->post("reqFormUjiId");


?>

<!-- <div class="item"><?=$reqJenis?>:<?=$reqNama?> --> 
<div class="item"><?=$reqNama?> 

	<i class="fa fa-times-circle" onclick="$(this).parent().remove(); $('#itemisi<?=$reqSatkerId?>').empty();"></i>
    <input type="hidden" name="reqEquipmentFormUjiId[]" value="<?=$reqEquipmentFormUjiId?>">
    <input type="hidden" name="reqFormUjiEquipmentId[]" value="<?=$reqFormUjiEquipmentId?>">
   
</div>