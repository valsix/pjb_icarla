  <?
  $reqTipe = $this->input->get("reqTipe");
  $this->load->model("base-app/Nameplate");

  $reqTabel = $this->input->get("reqTabel");
  $reqIdGenerate = $this->input->get("reqIdGenerate");




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

  	
  <select class="form-control jscaribasicmultiple" name='reqIsiDetil[]' id="reqIsiDetil-<?=$reqIdGenerate?>" style="width:100%;" >
    <?
    foreach($arrMaster as $itemisi) 
    {
      $selectvalid= $itemisi["id"];
      $selectnama=$itemisi["NAMA"];
      $selectinfo=$itemisi["NAMA_INFO"];
      $selected="";
      if(strtoupper($selectvalid) == $reqIsiDetil)
      {
        $selected="selected";
      }

      ?>
      <option value="<?=$selectvalid?>" <?=$selected?>><?=$selectnama?></option>
      <?
    }
    ?>  
  </select>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.jscaribasicmultiple').select2();
    });
  </script>


 