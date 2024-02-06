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
                // console.log(data);return false;

                data = data.split("***");
                reqId= data[0];
                infoSimpan= data[1];

                // console.log(reqId);

                if(reqId == 'xxx')
                    $.messager.alert('Info', infoSimpan, 'warning');
                else
                {
                    $.messager.alert('Info', infoSimpan, 'info')
                    setTimeout( function() 
                    {
                        // top.closePopup();
                        location.reload(); 
                    }, 1000);
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
                                <?
                                if(!empty($arrheader))
                                {
                                    foreach ($arrheader as $hkey => $hvalue) 
                                    {
                                        $reqIdHeader= $hvalue["PENGUKURAN_TIPE_HEADER_ID"];   
                                    ?>
                                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTabelHeaderBarisEdit('<?=$reqIdHeader?>')">Tambah Kolom</a>
                                        <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTabelHeader('<?=$reqIdHeader?>')">Tambah Baris Header</a>
                                        <a href="javascript:void(0)" class="btn btn-danger" onclick="delete_data('<?=$reqIdHeader?>','header','')">Delete Header</a>
                                        <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;width: 100%">
                                            <thead>
                                                <tr>
                                                   <th style="vertical-align : middle;text-align:center;width: 35%">Kolom</th>

                                                   <th style="vertical-align : middle;text-align:center;width: 15%">Rowspan</th>
                                                   <th style="vertical-align : middle;text-align:center;width: 15%">Colspan</th>

                                                   <th style="vertical-align : middle;text-align:center;width: 10%">Action</th>
                                               </tr>
                                             </thead>
                                            <tbody id="tableInputHeader<?=$reqIdHeader?>">

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
                                            <tr>
                                                <td style="display: none">
                                                    <input class='easyui-validatebox textbox form-control' type='text' name='reqDetilId[]' id='reqDetilId'  data-options='' style='' value="<?=$reqDetilId?>">
                                                </td>
                                                <td style="display: none">
                                                    <input class='easyui-validatebox textbox form-control' type='text' name='reqHeaderId[]' id='reqHeaderId'   data-options='' style='' value="<?=$reqIdHeader?>">
                                                </td>
                                                <td style="display: none">
                                                    <input class='easyui-validatebox textbox form-control' type='text' name='reqStatusTabel[]' id='reqStatusTabel'   data-options='' style='' value="1">
                                                </td>
                                                <td><input class='easyui-validatebox textbox form-control' type='text' name='reqKolom[]' id='reqKolom'  data-options=''  style='text-align:center;' value="<?=$reqKolom?>" ></td>
                                                <td >
                                                    <input class='easyui-validatebox textbox form-control' type='text' name='reqRowspan[]' id='reqRowspan'   data-options='' style='' value="<?=$reqRowspan?>">
                                                </td>
                                                <td >
                                                    <input class='easyui-validatebox textbox form-control' type='text' name='reqColspan[]' id='reqColspan'   data-options='' style='' value="<?=$reqColspan?>">
                                                </td>
                                                <td style="text-align:center"><span style='background-color: red; padding: 10px; border-radius: 5px;top: 50%;position: relative;'><a class='btn-remove'  ><i class='fa fa-trash fa-lg' style='color: white;' aria-hidden='true' onclick="delete_data('','isi','<?=$reqDetilId?>'')"></i></a></span></td>
                                            </tr>
                                           
                                            <?
                                            }
                                            ?>
                                            <input type="hidden" name="reqTipeHeaderId[]" id="reqIdHeader" value="<?=$reqIdHeader?>">

                                             </tbody>
                                        </table>
                                    <?
                                    }
                                }
                                else
                                {
                                ?>
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTabelHeaderBaris(1)">Tambah Kolom</a>
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="AddTabelHeader()">Tambah Header</a>
                                    <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;width: 100%">
                                        <thead>
                                            <tr>
                                                 <th style="vertical-align : middle;text-align:center;width: 35%">Kolom</th>

                                                 <th style="vertical-align : middle;text-align:center;width: 15%">Rowspan</th>
                                                 <th style="vertical-align : middle;text-align:center;width: 15%">Colspan</th>

                                                 <th style="vertical-align : middle;text-align:center;width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableInputHeader1">
                                            <input type="hidden" name="reqTipeHeaderId[]" id="reqTipeHeaderId" value="1">
                                        </tbody>
                                    </table>
                                <?
                                }
                                ?>
                                  
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="reqId" id="reqId" value="<?=$reqId?>">
                        <div style="text-align:center;padding:5px">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Simpan</a>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">

var check ='<?=$reqIdHeader?>';
const uniqId = (() => {
    
    if(check =="")
    {
        check=2;
    }
    else
    {
       check= Number(check) + 1; 
    }
    // console.log(check);
    let i = check; 
    return () => {
        return i++;
    }
})();


$("#tableInputHeader1").on("click", ".btn-remove", function(){
    $(this).closest('tr').remove();
});

function AddTabelHeader() {
    var idgenerate = uniqId();
    $.get("app/loadUrl/app/template_tipe_pengukuran_input_header?reqIdGenerate="+idgenerate, function(data) { 
         $("#header").append(data);
    });
}

function AddTabelHeaderBaris(id) {
    $.get("app/loadUrl/app/template_tipe_pengukuran_input_header_baris?reqIdHeader="+id, function(data) { 
       $("#tableInputHeader"+id).append(data);
    });
}
function AddTabelHeaderBarisEdit(id) {
    $.get("app/loadUrl/app/template_tipe_pengukuran_input_header_baris?reqIdHeader="+id, function(data) { 
       $("#tableInputHeader"+id).append(data);
    });
}

function AddTabelHeaderBarisDinamis(id) {
    $.get("app/loadUrl/app/template_tipe_pengukuran_input_header_baris?reqIdHeader="+id, function(data) { 
        $("#tableInputHeader"+id).append(data);
    });
}

function delete_baris(id) {
    $("#tableInputHeader"+id).on("click", ".btn-remove", function(){
        $(this).closest('tr').remove();
    });
}

function delete_data(id,reqMode,detilid) {
    $.messager.confirm('Konfirmasi',"Hapus data terpilih?",function(r){
        if (r){
            $.getJSON("json-app/pengukuran_json/delete_tipe_header/?reqHeaderId="+id+"&reqMode="+reqMode+"&reqDetilId="+detilid,
                function(data){
                    $.messager.alert('Info', data.PESAN, 'info');
                    location.reload();

                });
        }
    }); 
}



</script>

</body>
</html>