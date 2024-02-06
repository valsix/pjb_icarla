<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");


$reqTipe= $this->input->get("reqTipe");
$reqId=$this->input->get("reqId");
// print_r($reqId);exit;
$this->load->model('base-app/PengukuranTipe');

$set= new PengukuranTipe();

$arrheader=[];
$statement = " AND A.PENGUKURAN_ID = '".$reqId."' ";
$set->selectByParamsHeader(array(), -1, -1, $statement);
// echo  $set->query;exit;
while($set->nextRow())
{
    $arrdata= array();
    $arrdata["PENGUKURAN_TIPE_HEADER_ID"]= $set->getField("PENGUKURAN_TIPE_HEADER_ID");
    $arrdata["PENGUKURAN_ID"]= $set->getField("PENGUKURAN_ID");
    array_push($arrheader, $arrdata);
}
unset($set);



// print_r($arrheader);exit;
// echo $set->query;exit;

?>

<body>
    <script type="text/javascript">
    function submitForm(){
        $('#ff').form('submit',{
            url:'json-app/Pengukuran_json/addtipe',
            onSubmit:function(){

                if($(this).form('validate'))
                {
                    var win = $.messager.progress({
                        title:'<?=$this->configtitle["progres"]?>',
                        msg:'proses data...'
                    });
                }

                return $(this).form('enableValidation').form('validate');
            },
            success:function(data){
                $.messager.progress('close');
                console.log(data);return false;

                data = data.split("***");
                reqId= data[0];
                infoSimpan= data[1];

                // console.log(reqId);

                if(reqId == 'xxx')
                    $.messager.alert('Info', infoSimpan, 'warning');
                else
                {
                    $.messager.alert('Info', infoSimpan, 'info')
                     setTimeout( function() {top.closePopup(); }, 2000);
                }

                // top.closePopup();
            }
        });
    }
    </script>
    <div class="col-md-12">
      <div class="judul-halaman"> Input &rsaquo; Tipe Pengukuran </div>
        <div class="konten-area">
            <div class="konten-inner">
                <div>
                    <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">
                        <div class="form-group">  
                            <div class='col-md-12'>
                                <div class="page-header">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Header Tabel</h3>       
                                </div>
                                <br>
                                <div id="header">
                                    <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;">
                                        <thead>
                                            <?
                                            foreach ($arrheader as $key => $value) 
                                            {
                                               $reqIdHeader= $value["PENGUKURAN_TIPE_HEADER_ID"];
                                               $reqRowspan= $value["R"];
                                            ?>
                                                <tr>
                                                  <?
                                                  $set= new PengukuranTipe();

                                                  $statement = " AND A.PENGUKURAN_ID = '".$reqId."'  AND A.PENGUKURAN_TIPE_HEADER_ID = '".$reqIdHeader."'";
                                                  $set->selectByParamsHeaderIsi(array(), -1, -1, $statement);
                                                // echo  $set->query;exit;
                                                  while($set->nextRow())
                                                  {
                                                     $reqDetilId= $set->getField("PENGUKURAN_TIPE_ID");

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
                                            ?>
                                        </thead>
                                       
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