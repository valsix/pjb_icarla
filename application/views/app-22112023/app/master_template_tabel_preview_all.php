<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");

$reqTipe= $this->input->get("reqTipe");
$reqId=$this->input->get("reqId");

$this->load->model('base-app/TabelTemplate');
$this->load->model("base-app/Pengukuran");

$setAll= new Pengukuran();
$setAll->selectByParamsTipeInput(array("pengukuran_id"=>$reqId), -1,-1);
// echo $setAll->query; exit;
?>
<body>
    <div class="col-md-12">
    <div class="judul-halaman"> Preview &rsaquo; Table</div>
        <div class="konten-area">
<?
while($setAll->nextRow())
{
    $reqStatusTable= $setAll->getField("STATUS_TABLE");
    $reqMasterTableId= $setAll->getField("MASTER_TABEL_ID");
    $value= $setAll->getField("value");
    if($reqStatusTable=='TABLE')
    {

        $set= new TabelTemplate();

        $statement = " AND A.TABEL_TEMPLATE_ID = '".$reqMasterTableId."' ";
        $set->selectByParamsMaxBaris(array(), -1, -1, $statement);
         // echo $set->query;exit; 
        $set->firstRow();
        $maxbaris= $set->getField("MAX");
        unset($set);
        $set= new TabelTemplate();

        $statement = " AND A.TABEL_TEMPLATE_ID = '".$reqMasterTableId."' ";
        $set->selectByParams(array(), -1, -1, $statement);
            // echo $set->query;exit;
        $set->firstRow();
        $reqTotal= $set->getField("TOTAL");
        $reqNama= $set->getField("NAMA");

        $reqNoteAtas= $set->getField("NOTE_ATAS");
        $reqNoteBawah= $set->getField("NOTE_BAWAH");
        unset($set);
        ?>
        <div class="konten-inner">
            <div>
                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">
                    <div class="form-group">  
                        <div class='col-md-12'>
                           <!--  <div class="page-header">
                                <h3><i class="fa fa-file-text fa-lg"></i> <?=$reqNama?> Tabel</h3>       
                            </div> -->
                            <br>
                            <div id="header">
                                <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                                    <thead>
                                    <?
                                    if(!empty($maxbaris))
                                    {
                                      for ($baris=1; $baris < $maxbaris + 1; $baris++) 
                                      {
                                        ?>
                                          <tr>
                                            <?
                                            $set= new TabelTemplate();

                                            $statement = "  AND A.TABEL_TEMPLATE_ID = '".$reqMasterTableId."' AND B.BARIS = '".$baris."'";
                                            $set->selectByParamsDetil(array(), -1, -1, $statement);
                                                        // echo  $set->query;exit;
                                            while($set->nextRow())
                                            {
                                              $reqDetilId= $set->getField("TABEL_DETIL_ID");
                                              $reqBaris= $set->getField("BARIS");
                                              $reqKolom= $set->getField("NAMA_TEMPLATE");
                                              $reqRowspan= $set->getField("ROWSPAN");
                                              $reqColspan= $set->getField("COLSPAN");

                                              ?>
                                              <th rowspan="<?=$reqRowspan?>" colspan="<?=$reqColspan?>" style="vertical-align : middle;text-align:center;"><?=$reqKolom?></th>
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
                                      <tr>
                                      <?
                                      if(!empty($reqTotal))
                                      {
                                        for ($i=1; $i < $reqTotal + 1; $i++) 
                                        {
                                        ?>
                                          <td> &nbsp;</th>
                                        <?
                                        }
                                      }
                                      ?>
                                      </tr>
                                      
                                    </tbody>
                                   
                                </table>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
<?
    }
    else if ($reqStatusTable=='PIC'){?>
         <center><img src="<?=$value?>" style="width: 200px;" /></center><br>
    <?}
    else{?>
        <?=$value?><br>
    <?}
}?>
        </div>
    </div>
</body>