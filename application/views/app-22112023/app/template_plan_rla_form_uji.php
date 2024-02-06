<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");


$reqTipe= $this->input->get("reqTipe");
$reqId=$this->input->get("reqId");
// print_r($reqId);exit;
$this->load->model('base-app/PlanRLa');

$set= new PlanRla();

$statement = " AND B.PLAN_RLA_ID = '".$reqId."' ";
$set->selectByParamsPlanRlaFormUjiTemplate(array(), -1, -1, $statement);
// echo $set->query;exit;

?>


<body>

    <script type="text/javascript">
    function submitForm(){
        $('#ff').form('submit',{
            url:'json-app/form_uji_template_json/upload',
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
                     setTimeout( function() {top.closePopup(); }, 2000);
                }

                // top.closePopup();
            }
        });
    }
    </script>
   <div class="col-md-12">

      <div class="judul-halaman"> Upload &rsaquo; Tipe Form Uji</div>

      <div class="konten-area">
        <div class="konten-inner">

            <div>

                <form id="ff" class="easyui-form form-horizontal" method="post" novalidate enctype="multipart/form-data">
                 <div class="form-group">  
                    <div class='col-md-12'>
                        <?
                        while ($set->nextRow())
                        {
                            $reqId= $set->getField("PLAN_RLA_ID");
                            $reqListFormUji= $set->getField("FORM_UJI_ID");
                           
                            $reqNamaFormUji= $set->getField("NAMA");

                            ?>
                            <div class='form-group'>
                                <div class='col-md-12'>

                                    <table class="table table-bordered table-striped table-hovered" style="width: 100%">
                                        <thead>
                                            <tr>
                                                 <th colspan="3"  style="text-align: center"><?=$reqNamaFormUji?></th>
                                            </tr>
                                            <tr>
                                              <th style="width: 50%" >Tipe</th>
                                              <th>Link Template</th>
                                              <th>Upload</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?
                                            $tipe= new PlanRla();

                                            $statement = " AND A.FORM_UJI_ID = '".$reqListFormUji."' ";
                                            $tipe->selectByParamsPlanRlaFormUjiTemplateTipe(array(), -1, -1, $statement);
                                            while ($tipe->nextRow())
                                            {

                                                $reqNamaTipe= $tipe->getField("NAMA");
                                                $reqListFormUjiTipe= $tipe->getField("FORM_UJI_TIPE_ID");

                                            ?>

                                            <tr>
                                                <td style="width: 50%"><?=$reqNamaTipe?></td>
                                                <td style="text-align: center"><span style="background-color: green;padding: 8px; border-radius: 5px;"><a onclick="cetak_excel('<?=$reqListFormUjiTipe?>','<?=$reqId?>','<?=$reqListFormUji?>')"><i class="fa fa-download fa-lg" style="color: white;" aria-hidden="true"></i></a></span></td>
                                                <td style="text-align: center"><input type="file" accept=".xls" name="reqLinkFile[]"></td>
                                                <input type="hidden" name="reqId" value="<?=$reqId?>" />
                                                <input type="hidden" name="reqTipe[]" value="<?=$reqListFormUjiTipe?>" />
                                                <input type="hidden" name="reqFormUjiId[]" value="<?=$reqListFormUji?>" />

                                            </tr>
                                            <?
                                            }
                                            ?>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <?
                        }
                        ?>
                    </div>

                    <div style="text-align:center;padding:5px">
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="submitForm()">Upload</a>
                    </div> 
                </div> 
            </form>

        </div>


    </div>
</div>

</div>

<script type="text/javascript">
function cetak_excel(reqTipe,reqId,FormUjiId)
{
    url="";
    
    if (reqTipe=='1' || reqTipe=='2') 
    {
        url= 'ir_pi';
    }
    else if (reqTipe=='4') 
    {
        url= 'sfra';
    }
    else if (reqTipe=='5') 
    {
        url= 'die_res';
    }
    else if (reqTipe=='6') 
    {
        url= 'tan_delta';
    }
    else if (reqTipe=='7') 
    {
        url= 'hcb';
    }
    else if (reqTipe=='8') 
    {
        url= 'ex_curr';
    }
    else if (reqTipe=='9') 
    {
        url= 'rdc';
    }
    else if (reqTipe=='10') 
    {
        url= 'ratio';
    }

    urlExcel = 'json-app/form_uji_template_json/'+url+'?reqId='+reqId+'&reqTipe='+reqTipe+'&reqFormUjiId='+FormUjiId;
    // console.log(urlExcel);
    newWindow = window.open(urlExcel, 'Cetak');
    newWindow.focus();
} 

</script>

</body>
</html>