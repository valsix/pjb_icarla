<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");


$reqTipePengukuranId= $this->input->get("reqTipePengukuranId");
$reqId=$this->input->get("reqId");
$reqLihat=$this->input->get("reqLihat");
$reqRead=$this->input->get("reqRead");


// print_r($reqId);exit;
$this->load->model('base-app/FormUji');
$this->load->model('base-app/TabelTemplate');
$this->load->model('base-app/PlanRlaFormUjiDinamis');


$set= new FormUji();

$arrpengukuran= [];

$statement = " AND A.PENGUKURAN_ID IN (".$reqTipePengukuranId.") ";
$set->selectByParamsPengukuran(array(), -1, -1, $statement);
 // echo $set->query;exit; 

while($set->nextRow())
{
  $arrdata= array();
  $arrdata["TABEL_TEMPLATE_ID"]= $set->getField("TABEL_TEMPLATE_ID");
  $arrdata["PENGUKURAN_TIPE_INPUT_ID"]= $set->getField("PENGUKURAN_TIPE_INPUT_ID");
  $arrdata["TABEL_NAMA"]= $set->getField("TABEL_NAMA");
  $arrdata["STATUS_TABLE"]= $set->getField("STATUS_TABLE");
  $arrdata["MASTER_TABEL_ID"]= $set->getField("MASTER_TABEL_ID");
  $arrdata["PENGUKURAN_ID"]= $set->getField("PENGUKURAN_ID");
  $arrdata["TIPE_INPUT_ID"]= $set->getField("TIPE_INPUT_ID");
  $arrdata["VALUE"]= $set->getField("VALUE");
  array_push($arrpengukuran, $arrdata);
}
 // echo $set->query;exit; 

// print_r($arrpengukuran);exit;
// var_dump($maxbaris);exit;
unset($set);


if($reqLihat ==1 )
{
    $disabled="disabled";  
}


?>

<head>

</head>

<body>

      <?
      $z=0;
       $idcheck=[];
      foreach ($arrpengukuran as $key => $value) 
      {
        $tabelnama= $value["TABEL_NAMA"];
        $statustabel= $value["STATUS_TABLE"];
        $tabelid= $value["MASTER_TABEL_ID"];
        $pengukuranid= $value["PENGUKURAN_ID"];
        $pengukurantipeid= $value["PENGUKURAN_TIPE_INPUT_ID"];
        $tipeinputid= $value["TIPE_INPUT_ID"];
        $valuenama= $value["VALUE"];

        $set= new TabelTemplate();

        $statement = " AND A.TABEL_TEMPLATE_ID = '".$tabelid."' ";
        $set->selectByParamsMaxBaris(array(), -1, -1, $statement);
          // echo $set->query;
        $set->firstRow();
        $maxbaris= $set->getField("MAX");

        $total= new TabelTemplate();

        $statement = " AND A.TABEL_TEMPLATE_ID = '".$tabelid."' ";
        $total->selectByParams(array(), -1, -1, $statement);
        $total->firstRow();
        $reqTotal= $total->getField("TOTAL");

        $checkvalidasi= new PlanRlaFormUjiDinamis();

        $statement = " AND A.TABEL_TEMPLATE_ID = '".$tabelid."'  AND A.FORM_UJI_ID = '".$reqId."' ";
        $checkvalidasi->selectByParamsDetil(array(), -1, -1, $statement);
        $checkvalidasi->firstRow();
        $reqIdFormDinamis= $checkvalidasi->getField("PLAN_RLA_FORM_UJI_DINAMIS_ID");
        // var_dump($reqIdFormDinamis);

        $pengukuran= new FormUji();

        $statement = " AND A.PENGUKURAN_ID = '".$pengukuranid."' ";
        $pengukuran->selectByParamsPengukuranMaster(array(), -1, -1, $statement);
          // echo $set->query;
        $pengukuran->firstRow();
        $pengukurannama= $pengukuran->getField("NAMA");

        $idcheck[]= $pengukuranid;

        // var_dump($pengukurannama) ;

        ?>
          <div class="container" id="divpengukuran<?=$pengukuranid?>">
           <div class="page-header headernew class_header_<?=$pengukuranid?>" id="<?=$pengukuranid?>" style="background: #adb000">
            <h3><i class="fa fa-id-badge fa-lg"></i> <?=$pengukurannama?></h3>
           </div>

            <?
            if($statustabel== 'TABLE')
            {

              ?>
              <div class="page-header">
                <h3><i class="fa fa-file-text fa-lg"></i> <?=$tabelnama?> Tabel</h3>       
              </div>
              <br>
              <?
              if(empty($reqLihat))
              {
                ?>
                <a href="javascript:void(0)" class="btn btn-primary" onclick="AddBaris('<?=$pengukuranid?>','<?=$pengukurantipeid?>','<?=$tabelid?>')">Tambah</a>
                <a href="javascript:void(0)" class="btn btn-success" onclick="import_tipe('<?=$pengukuranid?>','<?=$tabelid?>','<?=$pengukurantipeid?>','<?=$tipeinputid?>')">Import</a>
                <?
              }
              ?>

              <div id="header">
                <table id="tabelpengukuran<?=$pengukuranid?>-<?=$pengukurantipeid?>-<?=$tabelid?>" class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                    <thead>
                     <?
                     if(!empty($maxbaris))
                     {
                      for ($baris=1; $baris < $maxbaris + 1; $baris++) 
                      {
                        ?>
                         <tr> 
                          <?
                          $statement = " AND A.PENGUKURAN_ID = ".$pengukuranid." AND A.MASTER_TABEL_ID = '".$tabelid."' AND C.BARIS = '".$baris."' AND A.PENGUKURAN_TIPE_INPUT_ID=".$pengukurantipeid;

                          $settabel= new FormUji();
                          $settabel->selectByParamsPengukuranTabel(array(), -1, -1, $statement);
                           // echo $settabel->query;
       
                          while($settabel->nextRow())
                          {
                            $reqKolom= $settabel->getField("NAMA_KOLOM");
                            $reqBaris= $settabel->getField("BARIS");
                            $reqRowspan= $settabel->getField("ROWSPAN");
                            $reqColspan= $settabel->getField("COLSPAN");

                          ?>
                            <th rowspan="<?=$reqRowspan?>" colspan="<?=$reqColspan?>" style="vertical-align : middle;text-align:center;"><?=$reqKolom?></th>
                          <?
                          }
                          ?>
                          <?
                          if ($baris==1)
                          {
                            ?> 
                            <th rowspan="<?=$maxbaris?>" style="vertical-align : middle;text-align:center;">Action</th>
                            <?
                          }
                          ?>
                         </tr>
                        <?
                      }
                    }
                    ?>

                    </thead>
                    <tbody>
                      <?

                      $reqFormDetilId="";
                      $setisi= new FormUji();
                      $statement = " AND A.PENGUKURAN_ID =".$pengukuranid." AND STATUS_TABLE = 'TABLE' AND A.FORM_UJI_ID = ".$reqId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." ";
                      $setisi->selectByParamsDetilDinamis(array(), -1, -1, $statement);
                      // echo $setisi->query; 
                      while($setisi->nextRow())
                      {

                        $reqFormDetilId= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");
                        $reqNamaKolom= $setisi->getField("NAMA");
                      ?>
                        <?
                        if(!empty($reqFormDetilId))
                        {
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
                                  <td><input class='easyui-validatebox textbox form-control' type='text' name='reqNamaKolom[]' id='reqNamaKolom'  <?=$disabled?> value='<?=$reqNamaKolom?>' data-options='' style='width:100%'></td>
                                  <td style="display: none"><input class='easyui-validatebox textbox form-control' type='text' name='reqStatusTabel[]' id='reqStatusTabel' value='TABLE' data-options='' style='width:100%'></td>
                                  <input type='hidden' name='reqFormDetilId[]' class="iddetil" id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                                  <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='<?=$tabelid?>' >
                                  <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                                  <input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
                                  <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                                  <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                                  <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >

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
                            <?
                            if(!empty($reqIdFormDinamis))
                            {
                            ?>
                            <!-- <td style="text-align: center">Dipakai RLA</td> -->
                            <?
                            }
                            else
                            {
                            ?>
                            <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusDetil("<?=$reqFormDetilId?>","TABLE","<?=$pengukuranid?>")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                            </td>
                            <?
                            }
                            ?>
                           
                          </tr>

                        <?
                        }
                        ?>
                      <?
                      }
                      ?>

                      <?
                      if(empty($reqFormDetilId))
                      {
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
                                <td><input class='easyui-validatebox textbox form-control' type='text' name='reqNamaKolom[]' id='reqNamaKolom' value='' data-options='' style='width:100%'></td>
                                <td style="display: none"><input class='easyui-validatebox textbox form-control' type='text' name='reqStatusTabel[]' id='reqStatusTabel' value='TABLE' data-options='' style='width:100%'></td>
                                <input type='hidden' name='reqFormDetilId[]' id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                                <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='<?=$tabelid?>' >
                                <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                                <input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
                                <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                                <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                                <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >

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
                         <!--  <td><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a onclick='HapusTable("<?=$selectvalid?>","rdcdetil","<?=$selecttipe?>")'><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true'></i></a></span>
                          </td> -->
                        </tr>
                        <?
                      }
                      ?>
                      
                     
                     
                    </tbody>
                 </table> 
              </div>
            <?
            }
            else if ($statustabel== 'TEXT')
            {
            ?>
              <br>
              <div class="page-header">
                <h3><i class="fa fa-file-text fa-lg"></i> KETERANGAN </h3>       
              </div>
              <div class="form-group">  
                <label class="control-label col-md-2"><?=$valuenama?></label>
                <div class='col-md-8'>
                  <div class='form-group'>
                    <div class='col-md-11'>

                    <?
                      $reqFormDetilId="";
                      $setisi= new FormUji();
                      $statement = " AND A.PENGUKURAN_ID =".$pengukuranid." AND STATUS_TABLE = 'TEXT' AND A.FORM_UJI_ID = ".$reqId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." ";
                      $setisi->selectByParamsDetilDinamis(array(), -1, -1, $statement);
                      // echo $setisi->query; 
                      while($setisi->nextRow())
                      {

                        $reqFormDetilId= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");
                        $reqNamaKolom= $setisi->getField("NAMA");
                      ?>
                       <textarea id="check-<?=$reqFormDetilId?>" <?=$disabled?>  name="reqNamaKolom[]" style="width:100%"><?=$reqNamaKolom?></textarea>
                       <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='TEXT' data-options='' style='width:100%'>
                       <input type='hidden' name='reqFormDetilId[]' class="iddetil"  id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                       <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                       <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                       <input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
                       <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                       <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                       <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
                      
                    <?
                     }
                     ?>
                    <?
                     if(empty($reqFormDetilId))
                     {
                      ?>
                       <textarea  name="reqNamaKolom[]"  id="check-<?=$pengukuranid?>-<?=$z?>"  style="width:100%"></textarea>
                       <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='TEXT' data-options='' style='width:100%'>
                       <input type='hidden' name='reqFormDetilId[]' id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                       <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                       <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                       <input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
                       <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                       <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                       <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
                    <?
                    }
                    ?>
                   </div>
                 </div>
               </div>
              </div>
            <?
            }
            else if ($statustabel== 'PIC')
            {
            ?>
              <div class="page-header">
                <h3><i class="fa fa-file-text fa-lg"></i> GAMBAR</h3>       
              </div>
               <div class="form-group">  
                <label class="control-label col-md-2"><?=$valuenama?></label>
                <div class='col-md-8'>
                  <div class='form-group'>
                    <div class='col-md-11'>
                    <?
                      $reqFormDetilId="";
                      $setisi= new FormUji();
                      $statement = " AND A.PENGUKURAN_ID =".$pengukuranid." AND STATUS_TABLE = 'PIC' AND A.FORM_UJI_ID = ".$reqId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." ";
                      $setisi->selectByParamsDetilDinamis(array(), -1, -1, $statement);
                      // echo $setisi->query; 
                      while($setisi->nextRow())
                      {

                        $reqFormDetilId= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");
                        $reqNamaKolom= $setisi->getField("NAMA");
                        $reqLinkFile= $setisi->getField("LINK_FILE");
                      ?>

                      <input type="file" name="reqLinkFile[]" <?=$disabled?> id="reqLinkFile" accept=".jpg,.jpeg,.png,image/png">
                      <?
                      if(!empty($reqLinkFile))
                      {
                      ?>
                        <a href="<?=$reqLinkFile?>" target="_blank"> <img src="<?=$reqLinkFile?>" width="300px" height = "300px" ></a>
                         
                      <?
                      }
                      ?>
                      <input class='easyui-validatebox textbox form-control' type='hidden' name='reqNamaKolom[]' id='reqNamaKolom' value='<?=$reqNamaKolom?>' data-options='' style='width:100%'>


                      <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='PIC' data-options='' style='width:100%'>
                      <input type='hidden' name='reqFormDetilId[]'  class="iddetil" id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                      <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                      <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                      <input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
                      <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                      <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong" value="1">
                      <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
                      
                    <?
                     }
                     ?>
                    <?
                    // var_dump($reqFormDetilId);
                    if(empty($reqFormDetilId))
                    {
                      ?>
                       <input type="file" name="reqLinkFile[]" id="reqLinkFile" accept=".jpg,.jpeg,.png,image/png">
                       <input class='easyui-validatebox textbox form-control' type='hidden' name='reqNamaKolom[]' id='reqNamaKolom' value='<?=$valuenama?>' data-options='' style='width:100%'>

                       <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='PIC' data-options='' style='width:100%'>
                       <input type='hidden' name='reqFormDetilId[]' id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                       <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                       <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                       <input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
                       <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                       <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong"  value="1">
                       <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
                    <?
                    }
                    ?>
                   </div>
                 </div>
               </div>
              </div>
            <?
            }
            else if ($statustabel== 'ANALOG')
            {
            ?>
              <br>
              <div class="page-header">
                <h3><i class="fa fa-file-text fa-lg"></i> ANALOG </h3>       
              </div>
              <div class="form-group">  
                <label class="control-label col-md-2"><?=$valuenama?></label>
                <div class='col-md-8'>
                  <div class='form-group'>
                    <div class='col-md-11'>

                      <?
                      $reqFormDetilId="";
                      $setisi= new FormUji();
                      $statement = " AND A.PENGUKURAN_ID =".$pengukuranid." AND STATUS_TABLE = 'ANALOG' AND A.FORM_UJI_ID = ".$reqId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." ";
                      $setisi->selectByParamsDetilDinamis(array(), -1, -1, $statement);
                        // echo $setisi->query; 
                      while($setisi->nextRow())
                      {

                        $reqFormDetilId= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");
                        $reqNamaKolom= $setisi->getField("NAMA");
                        ?>
                        <input class='easyui-validatebox textbox form-control' <?=$disabled?> type='text' name='reqNamaKolom[]' id='reqNamaKolom' value='<?=$reqNamaKolom?>' data-options='' style='width:100%' maxlength="25">
                        <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='ANALOG' data-options='' style='width:100%'>
                        <input type='hidden' name='reqFormDetilId[]'  class="iddetil" id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                        <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                        <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                        <input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
                        <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                        <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                        <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
                        
                        <?
                      }
                      ?>
                      <?
                      if(empty($reqFormDetilId))
                      {
                        ?>
                        <input class='easyui-validatebox textbox form-control' type='text' name='reqNamaKolom[]' id='reqNamaKolom' value='' data-options='' style='width:100%' maxlength="25">
                        <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='ANALOG' data-options='' style='width:100%'>
                        <input type='hidden' name='reqFormDetilId[]' id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                        <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                        <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                        <input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
                        <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                        <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                        <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
                        <?
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            <?
            }
            else if ($statustabel== 'BINARY')
            {
            ?>
              <br>
              <div class="page-header">
                <h3><i class="fa fa-file-text fa-lg"></i> BINARY </h3>       
              </div>
              <div class="form-group">  
                <label class="control-label col-md-2"><?=$valuenama?></label>
                <div class='col-md-8'>
                  <div class='form-group'>
                    <div class='col-md-11'>

                      <?
                      $reqFormDetilId="";
                      $setisi= new FormUji();
                      $statement = " AND A.PENGUKURAN_ID =".$pengukuranid." AND STATUS_TABLE = 'BINARY' AND A.FORM_UJI_ID = ".$reqId." AND A.PENGUKURAN_TIPE_INPUT_ID=  ".$pengukurantipeid." ";
                      $setisi->selectByParamsDetilDinamis(array(), -1, -1, $statement);
                          // echo $setisi->query; 
                      while($setisi->nextRow())
                      {

                        $reqFormDetilId= $setisi->getField("FORM_UJI_DETIL_DINAMIS_ID");
                        $reqNamaKolom= $setisi->getField("NAMA");
                        ?>
                        <input class='easyui-validatebox textbox form-control' <?=$disabled?> type='text' name='reqNamaKolom[]' id='reqNamaKolom' value='<?=$reqNamaKolom?>' data-options='' style='width:100%' maxlength="25">
                        <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='BINARY' data-options='' style='width:100%'>
                        <input type='hidden' name='reqFormDetilId[]'  class="iddetil" id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                        <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                        <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                        <input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
                        <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                        <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                        <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >

                        <?
                      }
                      ?>
                      <?
                      if(empty($reqFormDetilId))
                      {
                        ?>
                        <input class='easyui-validatebox textbox form-control' type='text' name='reqNamaKolom[]' id='reqNamaKolom' value='' data-options='' style='width:100%' maxlength="25">
                        <input class='easyui-validatebox textbox form-control' type='hidden' name='reqStatusTabel[]' id='reqStatusTabel' value='BINARY' data-options='' style='width:100%'>
                        <input type='hidden' name='reqFormDetilId[]' id='reqFormDetilId' value='<?=$reqFormDetilId?>' >
                        <input type='hidden' name='reqTabelId[]' id='reqTabelId' value='' >
                        <input type='hidden' name='reqPengukuranId[]' id='reqPengukuranId' value='<?=$pengukuranid?>' >
                        <input type='hidden' name='reqPengukuranTipeId[]' id='reqPengukuranTipeId' value='<?=$pengukurantipeid?>' >
                        <input type='hidden' name='reqTipePengukuranId[]' id='reqTipePengukuranId' value='<?=$pengukuranid?>' >
                        <input type="hidden" name="reqLinkFileKosong[]" id="reqLinkFileKosong">
                        <input type='hidden' name='reqTipeInputId[]' id='reqTipeInputId' value='<?=$tipeinputid?>' >
                        <?
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            <?
            }
            ?>
           

          </div>

        <?
        $z++;
        }
        ?>

<script type="text/javascript">

  var arridcheck = <?php echo json_encode($idcheck); ?>;

  arridcheck.forEach(function(item) {
    // console.log(item);
    $('.class_header_'+item ).not(':first').hide();

  });

// tinymce.init({
//     selector: 'textarea#editor',
//     skin: 'bootstrap',
//     plugins: 'lists, link, image, media',
//     toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
//     menubar: false,
//     });
// tinymce.init({
//         selector: '#editor'
//       });
// tinymceinit();

</script>
</body>
</html>