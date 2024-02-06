<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");


$reqTipe= $this->input->get("reqTipe");
$reqId=$this->input->get("reqId");
// print_r($reqId);exit;
$this->load->model('base-app/TabelTemplate');


$set= new TabelTemplate();


$statement = " AND A.TABEL_TEMPLATE_ID = '".$reqId."' ";
$set->selectByParamsMaxBaris(array(), -1, -1, $statement);
 // echo $set->query;exit; 
$set->firstRow();
$maxbaris= $set->getField("MAX");

// var_dump($maxbaris);exit;
unset($set);


$set= new TabelTemplate();

$statement = " AND A.TABEL_TEMPLATE_ID = '".$reqId."' ";
$set->selectByParams(array(), -1, -1, $statement);
    // echo $set->query;exit;
$set->firstRow();
$reqTotal= $set->getField("TOTAL");
$reqNama= $set->getField("NAMA");

$reqNoteAtas= $set->getField("NOTE_ATAS");
$reqNoteBawah= $set->getField("NOTE_BAWAH");
unset($set);


?>

<body>
    <div class="col-md-12">
      <div class="judul-halaman"> Preview &rsaquo; Table</div>
        <div class="konten-area">
            <div class="konten-inner">
                <div>
                    <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">
                        <div class="form-group">  
                            <div class='col-md-12'>
                                <div class="page-header">
                                    <h3><i class="fa fa-file-text fa-lg"></i> <?=$reqNama?> Tabel</h3>       
                                </div>
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

                                                $statement = "  AND A.TABEL_TEMPLATE_ID = '".$reqId."' AND B.BARIS = '".$baris."'";
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
        </div>
    </div>

</body>
</html>