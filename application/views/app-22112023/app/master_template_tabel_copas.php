<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");

$this->load->model('base-app/TabelTemplate');

$reqId= $this->input->get("reqId");

$set= new TabelTemplate();
$statement = " AND A.TABEL_TEMPLATE_ID = '".$reqId."' ";
$set->selectByParamsMaxBaris(array(), -1, -1, $statement);
// echo $set->query;exit;
$set->firstRow();
$maxbaris= $set->getField("MAX");
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
    <div class="judul-halaman"> Copy &rsaquo; Table</div>
    <div class="konten-area">
      <div class="konten-inner">
        <div>
          <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">
            <div class="form-group">  
              <label class="control-label col-md-2">Nama</label>
              <div class='col-md-8'>
                <div class='form-group'>
                  <div class='col-md-11'>
                   <input autocomplete="off" class="easyui-validatebox textbox form-control" type="text" name="reqNama"  id="reqNama" value="" data-options="required:true" style="width:100%" <?=$disabled?> />
                 </div>
               </div>
             </div>
            </div>

            <div class="form-group">  
              <div class='col-md-12'>
                <div class="page-header">
                  <h3><i class="fa fa-file-text fa-lg"></i> Copas <?=$reqNama?> Tabel</h3>       
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
                            $statement= " AND A.TABEL_TEMPLATE_ID = '".$reqId."' AND B.BARIS = '".$baris."'";
                            $set->selectByParamsDetil(array(), -1, -1, $statement);
                            // echo $set->query;
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
                            <td> &nbsp;</td>
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

            <input type="hidden" name="reqId" value="<?=$reqId?>" />


            <div style="text-align:center;padding:5px">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Simpan</a>
            </div>
           
          </form>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function submitForm(){
      $('#ff').form('submit',{
        url:'json-app/template_tabel_json/copy',
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
            // console.log(data);return false;

            data = data.split("***");
            reqId= data[0];
            infoSimpan= data[1];

            if(reqId == 'xxx')
              $.messager.alert('Info', infoSimpan, 'warning');
            else
              $.messager.alert('Info', infoSimpan, 'info')
               setTimeout( function() {top.closePopup(); }, 2000);
          }
        });
    }
  </script>
</body>
</html>