  <?
  $reqTipe = $this->input->get("reqTipe");
  $this->load->model("base-app/MasterTabel");

  $set= new MasterTabel();


  $arrtabel= [];
  $statement = "";
  $set->selectByParams(array(), -1, -1, $statement);
  while($set->nextRow())
  {
  	$arrdata= array();
  	$arrdata["id"]= $set->getField("MASTER_TABEL_ID");
  	$arrdata["NAMA"]= ucfirst(strtolower(str_replace("_", " ", $set->getField("NAMA"))));
    $arrdata["NAMA_INFO"]= ucfirst(strtolower(str_replace("_", " ", $set->getField("NAMA"))));

  	array_push($arrtabel, $arrdata);
  }
  
  unset($set);
  ?>
  <tr >
  	<?
  	if($reqTipe==1)
  	{ 
  	?>
  		<td>
	  		<select name='reqTipe[]' class="easyui-combobox form-control">
	  			<option value="">Pilih Tabel Master</option>
	  			<?
	  			foreach($arrtabel as $item) 
	  			{
	  				$selectvalid= $item["id"];
	  				$selectnama=$item["NAMA"];
            $selectnamainfo=$item["NAMA_INFO"];

	  				?>
	  				<option value="<?=$selectnama?>"><?=$selectnamainfo?></option>
	  			<?
	  			}
	  			?>
	  		</select>
  		</td>
  		<td style="display: none"><input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusDetil[]' id='reqStatusDetil' value='1'  data-options=''  style='text-align:center;'></td>
  	<?
  	}
  	else
  	{
  	?>
  		<td><input class='easyui-validatebox textbox form-control' type='text' name='reqTipe[]' id='reqTipe' value='Text'  data-options=''  readonly style='text-align:center;'></td>
      <td style="display: none"><input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusDetil[]' id='reqStatusDetil' value='0'  data-options=''  style='text-align:center;'></td>
	<?
	}
	?>
  <td ><input class='easyui-validatebox textbox form-control' type='text' name='reqNamaDetil[]' id='reqNamaDetil'   data-options='' style='' value=""></td>
  	<td style="text-align:center"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td>
  </tr>