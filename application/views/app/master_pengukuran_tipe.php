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
    if(!empty($arrdata["PENGUKURAN_TIPE_HEADER_ID"]))
    {
         array_push($arrheader, $arrdata);
    }
   
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
                                    <h3><i class="fa fa-file-text fa-lg"></i> Tabel</h3>       
                                </div>
                                <br>
                                <div id="header">
                                    <label class="control-label col-md-2">Template tabel</label>
                               <select class="form-control jscaribasicmultiple " id="reqTipePengukuran" <?=$disabled?> name="reqTipePengukuran[]" style="width:50%;">

                                    <option value="1">
                                        Tes Template 1
                                    </option>
                                    <option value="1">
                                        Tes Template 2
                                    </option>
                                </select>
                                  
                                </div>
                            </div>
                        </div>
                        <?
                        if(!empty($arrheader))
                        {
                        ?>
                        <div class="form-group">  
                            <div class='col-md-12'>
                                <div class="page-header">
                                    <h3><i class="fa fa-file-text fa-lg"></i> Isi Tabel</h3>       
                                </div>
                                <br>
                                <div id="isi">
                                    <a href="javascript:void(0)" class="btn btn-primary" onclick="AddIsi()">Tambah </a>
                                    <table class="table table-bordered table-striped table-hovered" style="margin-top: 10px;width: 100%">
                                        <thead>
                                            <tr>
                                               <th style="vertical-align : middle;text-align:center;width: 35%">Kolom </th>

                                               <th style="vertical-align : middle;text-align:center;width: 15%">Rowspan</th>
                                               <th style="vertical-align : middle;text-align:center;width: 15%">Colspan</th>
                                               <th style="vertical-align : middle;text-align:center;width: 10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableInputIsi">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?
                        }
                        ?>

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


$("#tableInputHeader1,#tableInputIsi").on("click", ".btn-remove", function(){
    $(this).closest('tr').remove();
});

function AddTabelHeader() {
    var idgenerate = uniqId();
    $.get("app/loadUrl/app/template_tipe_pengukuran_input_header?reqIdGenerate="+idgenerate, function(data) { 
         $("#header").append(data);
    });
}

function AddTabelHeaderBaris(id) {
    // console.log(id);
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

function AddIsi(id) {
    $.get("app/loadUrl/app/template_tipe_pengukuran_input_header_baris", function(data) { 
       $("#tableInputIsi").append(data);
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