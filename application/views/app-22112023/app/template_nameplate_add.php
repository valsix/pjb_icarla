  <?
  $reqTipe = $this->input->get("reqTipe");
  $this->load->model("base-app/MasterTabel");
  $reqIdGenerate = $this->input->get("reqIdGenerate");
  $this->load->model("base-app/Nameplate");



  $set= new MasterTabel();


  $arrtabel= [];
  $statement = "";
  $set->selectByParams(array(), -1, -1, $statement);
  while($set->nextRow())
  {
  	$arrdata= array();
  	$arrdata["id"]= $set->getField("MASTER_TABEL_ID");
  	// $arrdata["NAMA"]= ucfirst(strtolower(str_replace("_", " ", $set->getField("NAMA"))));
    $arrdata["NAMA"]= ucfirst(strtolower($set->getField("NAMA")));
    $arrdata["NAMA_INFO"]= ucfirst(strtolower(str_replace("_", " ", $set->getField("NAMA"))));

  	array_push($arrtabel, $arrdata);
  }
  
  unset($set);

  $arrMaster= [];
  $statement = "";
  $set= new Nameplate();
  $set->selectByParamsCheckTabel(array(), -1, -1, $statement,$sOrder,$reqTabel);
  // echo $set->query;
  while($set->nextRow())
  {
    $arrdata= array();
    $arrdata["id"]= $set->getField("".$reqTabel."_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");

    array_push($arrMaster, $arrdata);
  }
  
  unset($set);
  ?>
  <tr >

  <?
  if($reqTipe==1)
  { 
  ?>
  		<td>
	  		<select name='reqTipe[]' id="reqTipe-<?=$reqIdGenerate?>" class="form-control jscaribasicmultiple">
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
  <td ><input class='easyui-validatebox textbox form-control' type='text' name='reqNamaDetil[]' id='reqNamaDetil' required   data-options='' style='' value=""></td>

  <?
  if($reqTipe==1)
  { 
    ?>
    <td>
      <div id="isitabel-<?=$reqIdGenerate?>">
        
      </div>
    </td>

    <?
  }
  else
  {
    ?>
    <td ><input class='easyui-validatebox textbox form-control' type='text' name='reqIsiDetil[]' id='reqIsiText'   data-options='' style='' value=""></td>
    <?
  }
  ?>


  <td style="text-align:center"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove' ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span></td>
  </tr>

  <script type="text/javascript">
     $("#reqTipe-<?=$reqIdGenerate?>").on("change", function () 
        { 

            var val=$(this).val();
            var reqTabel = val;
            // console.log(reqTabel);
            var url = "app/loadUrl/app/template_nameplate_add_master?reqTabel="+reqTabel+"&reqIdGenerate=<?=$reqIdGenerate?>";
            $.get(url, function(data) {
                $("#isitabel-<?=$reqIdGenerate?>").empty();   
                $("#isitabel-<?=$reqIdGenerate?>").append(data);
            });

        });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.jscaribasicmultiple').select2();
    });
  </script>