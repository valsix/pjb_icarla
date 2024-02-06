<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=\"tes.xls\"");


$reqTipe= $this->input->get("reqTipe");
$reqTabelId=$this->input->get("reqId");
$reqTabelId= $this->input->get("reqTabelId");
// print_r($reqTabelId);exit;
$this->load->model('base-app/TabelTemplate');


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


?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
    xmlns="http://www.w3.org/TR/REC-html40">
<body>
  <table border="1"  style="margin-top: 10px;border-collapse: collapse;">
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

            $statement = "  AND A.TABEL_TEMPLATE_ID = '".$reqTabelId."' AND B.BARIS = '".$baris."'";
            $set->selectByParamsDetil(array(), -1, -1, $statement);
                                                            // echo  $set->query;exit;
            while($set->nextRow())
            {
              $reqDetilId= $set->getField("TABEL_DETIL_ID");
              $reqBaris= $set->getField("BARIS");
              $reqKolom= $set->getField("NAMA");
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
  </body>
  </html>
