<?
$reqKelompokEquipmentId = $this->input->get("reqKelompokEquipmentId");
$reqJenis = $this->input->get("reqJenis");
$reqJenisSurat = $this->input->get("reqJenisSurat");
$reqIdField = $this->input->get("reqIdField");


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?=base_url();?>" />

<script src="lib/startbootstrap-sb-admin-2-1.0.7/bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="lib/startbootstrap-sb-admin-2-1.0.7/bower_components/bootstrap/dist/js/bootstrap.js"></script>

<!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ -->
<link href="lib/valsix/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="css/gaya-popup.css" type="text/css">
<!--<link rel="stylesheet" href="css/gaya-bootstrap.css" type="text/css">-->

<!-- BOOTSTRAP -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--<link href="lib/bootstrap/bootstrap.css" rel="stylesheet">-->
<link rel="stylesheet" href="lib/font-awesome/4.5.0/css/font-awesome.css">

<!--<script src="js/jquery-1.11.1.js" type="text/javascript" charset="utf-8"></script> -->

    <style>
    .col-md-12{
        padding-left:0px;
        padding-right:0px;
    }
    </style>

<!-- DRAG DROP -->
<script type="text/javascript" src="js/jquery-1.7.1.js" ></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<!-- EASYUI 1.4.5 -->
<link rel="stylesheet" type="text/css" href="assets/easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="assets/easyui/themes/icon.css">
<script type="text/javascript" src="assets/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="assets/easyui/datagrid-groupview.js"></script>
<script type="text/javascript" src="assets/easyui/globalfunction.js"></script>
<script type="text/javascript" src="assets/easyui/kalender-easyui.js"></script>    

<!-- <link rel="stylesheet" type="text/css" href="assets/easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="assets/easyui/themes/icon.css">
<link rel="stylesheet" type="text/css" href="assets/easyui/demo/demo.css">
<script type="text/javascript" src="assets/easyui/jquery-easyui-1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="assets/easyui/jquery-easyui-1.4.2/jquery.easyui.min.js"></script> -->

<!-- FONT AWESOME -->
<link rel="stylesheet" href="lib/font-awesome-4.7.0/css/font-awesome.css" type="text/css">

<style type="text/css">
    .panel.combo-p{
        width: 300px !important;
    }

    .datagrid-header-inner, .datagrid-htable, .datagrid-btable, .datagrid-ftable {
        width: 100% !important;
    }
</style>

</head>

<style>
.col-md-6{
    float: left;
    width: 50%;
}
</style>
<body class="body-popup">
    
    <div class="container-fluid container-treegrid">
        <div class="row row-treegrid">
            <div class="col-md-12 col-treegrid">
                <div class="area-konten-atas">
                    <div class="judul-halaman"> Kelompok Equipment</div>
                    <div class="area-menu-aksi">    
                         <div id="bluemenu" class="aksi-area">
                            <span class="col-md-8">
                                <a id="btnAdd"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i> Tambah</a>
                            </span>
                        	<label class="col-md-4 text-right">
                            <span>Pencarian </span> 
                            <input type="text" name="reqPencarian" class="easyui-validatebox textbox form-control" id="reqPencarian" style="width:300px"> 
                            </label>
                        </div>
                        
                    </div>
                </div>
                
                <!-- singleSelect: false, -->
                <div id="tableContainer" class="tableContainer tableContainer-treegrid">
                    <table id="tt" class="easyui-treegrid" style="min-width:100px !important; height:300px;">
                        <thead>
                            <tr>
                                <th data-options="field:'NAMA'">Nama</th>
                                <th data-options="field:'LINK_URL_INFO'" align="center" style="width: 100% !important">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                
            </div>
        </div>        
    </div>
    
<script>
/*$("#dnd-example tr").click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var id = $(this).find('td:first').attr('id');
    var title = $(this).find('td:first').attr('title');
}); */

$(function(){
    var tt = $('#tt').treegrid({
        url: 'json-app/kelompok_equipment_json/tree',
        rownumbers: false,
        pagination: false,
        idField: 'id',
        treeField: 'NAMA',
        onBeforeLoad: function(row,param){
        if (!row) { // load top level rows
        param.id = 0; // set id=0, indicate to load new page rows
        }
        }
    });
});
</script>
</body>
</html>