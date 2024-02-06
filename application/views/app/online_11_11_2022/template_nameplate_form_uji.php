  <?
  $reqNameplateId= $this->input->get("reqNameplateId");

  $this->load->model("base-app/Nameplate");

  $set= new Nameplate();

  $arrnameplatedetil= [];
  $statement = " ";
  $sOrder="";

  $statement = " AND A.NAMEPLATE_ID =".$reqNameplateId;
  $set->selectByParamsDetil(array(), -1, -1, $statement);
  while($set->nextRow())
  {
    $arrdata= array();
    $arrdata["id"]= $set->getField("NAMEPLATE_DETIL_ID");
    $arrdata["NAMA"]= $set->getField("NAMA");
    $arrdata["NAMA_TABEL"]= $set->getField("NAMA_TABEL");
    $arrdata["STATUS"]= $set->getField("STATUS");

    array_push($arrnameplatedetil, $arrdata);
  }

  unset($set);
  ?>

  <?
  foreach($arrnameplatedetil as $item) 
  {
    $selectvalid= $item["id"];
    $selectnama=$item["NAMA"];
    $selectstatus=$item["STATUS"];
    $selectTabel=$item["NAMA_TABEL"];

    $arrMaster= [];
    $statement = " ";
    $sOrder="";

    if(!empty($selectTabel) && $selectstatus==1)
    {
      $set= new Nameplate();
      $set->selectByParamsCheckTabel(array(), -1, -1, $statement,$sOrder,$selectTabel);
      while($set->nextRow())
      {
        $arrdata= array();
        $arrdata["id"]= $set->getField("".$selectTabel."_ID");
        $arrdata["NAMA"]= $set->getField("NAMA");

        array_push($arrMaster, $arrdata);
      }
    }

    ?>
    <div class="form-group"> 
      <label class="control-label col-md-2"><?=$selectnama?></label>
      <div class="col-md-8">
        <div class="form-group">
          <div class="col-md-11">
            <?
            if($selectstatus==1)
            { 
              if(!empty($arrMaster))
              {
              ?>
                  <select name='reqMaster[]' class="easyui-combobox form-control">
                    <option value="">Pilih Data </option>
                    <?
                    foreach($arrMaster as $master) 
                    {
                      $id= $master["id"];
                      $masternama=$master["NAMA"];
                      ?>

                      <option value="<?=$id?>"><?=$masternama?></option>
                      <?
                    }
                    ?>
                  </select>
                   <input autocomplete="off" class="easyui-validatebox textbox form-control" type="hidden" name="reqKolomNameplate[]"  id="reqKolomNameplate" value=""  style="width:100%"/>

              <?
              }
            }
            else
            {
              ?>
               <input autocomplete="off" class="easyui-validatebox textbox form-control" type="hidden" name="reqMaster[]"  id="reqMaster"  style="width:100%"/>
                <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqKolomNameplate[]"  id="reqKolomNameplate"  style="width:100%"/>
              <?
            }
            ?>
            <input autocomplete="off" type="hidden" name="reqStatusCheck[]"  value="<?=$selectstatus?>"/>
            <input autocomplete="off" type="hidden" name="reqNameplateDetilId[]"  value="<?=$selectvalid?>" />
            <input autocomplete="off" type="hidden" name="reqNameplateId"  value="<?=$reqNameplateId?>" />
            <input autocomplete="off" type="hidden" name="reqNamaTabel[]"  value="<?=$selectTabel?>" />
            <input autocomplete="off" type="hidden" name="reqNameplate[]"  value="<?=$selectnama?>" />
          </div>
        </div>
      </div>
    </div>
    <?
  }
  ?>

 