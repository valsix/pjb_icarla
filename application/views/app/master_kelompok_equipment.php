<?
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/Crud");
$appuserkodehak= $this->appuserkodehak;

$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("master_", "", $pgtitle)));

$set= new Crud();
$statement=" AND KODE_MODUL ='0213'";
$kode= $appuserkodehak;
$set->selectByParamsMenus(array(), -1, -1, $statement, $kode);
// echo $set->query;exit;
$set->firstRow();
$reqMenu= $set->getField("MENU");
$reqCreate= $set->getField("MODUL_C");
$reqRead= $set->getField("MODUL_R");
$reqUpdate= $set->getField("MODUL_U");
$reqDelete= $set->getField("MODUL_D");
?>
<style type="text/css">
    .col-md-12{
        padding-left:0px;
        padding-right:0px;
    }

    .panel.combo-p{
        width: 300px !important;
    }

    .datagrid-header-inner, .datagrid-htable, .datagrid-btable, .datagrid-ftable {
        width: 100% !important;
    }

    .col-md-6{
        float: left;
        width: 50%;
    }
</style>

<div class="col-md-12">
    <div class="judul-halaman"> Data <?=$pgtitle?></div>
    <div class="konten-area">
        <div id="bluemenu" class="aksi-area">
            <span><a id="btnAdd" class="btntambah"><i class="fa fa-plus-circle fa-lg" aria-hidden="true"></i> Tambah</a></span>
        </div>

        <div class="area-filter">
        </div>

        <div id="tableContainer" width="100%">
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
    
    <script>
        function hapusdata(id, statusaktif)
        {
            $.messager.defaults.ok = 'Ya';
            $.messager.defaults.cancel = 'Tidak';
            reqmode= "mode_1";
            infoMode= "Apakah anda yakin mengaktifkan data terpilih"
            if(statusaktif == "")
            {
                reqmode= "mode_0";
                infoMode= "Apakah anda yakin menonaktifkan data terpilih"
            }
                
            $.messager.confirm('Konfirmasi', infoMode+" ?",function(r){
                if (r){
                    var s_url= "json-app/kelompok_equipment_json/deletestatus/?reqMode="+reqmode+"&reqId="+id;
                    $.ajax({'url': s_url,'success': function(msg){
                        // console.log(msg);return false;
                        if(msg == ''){}
                        else
                        {
                            reloadselectedtree();
                        }
                    }});
                }
            }); 
        }

        function adddata(id, mode)
        {
            varurl= "app/index/master_kelompok_equipment_add?reqId="+id+"&reqMode="+mode;
            document.location.href = varurl;
        }

        function buttonaksi()
        {
            <?
            if($reqCreate == 1){}
            else
            {
            ?>
                $(".btntambah").hide();
            <?
            }

            if($reqDelete == 1){}
            else
            {
            ?>
                $(".btnhapus").hide();
            <?
            }
            ?>
        }

        $(document).ready(function() {
            buttonaksi();

            $("#btnAdd").on("click", function () {
                btnid= $(this).attr('id');

                mode= "";
                if(btnid=="btnAdd")
                {
                    valinfoid="0";
                    mode= "insert";
                }
                else
                {
                    // if(valinfoid == "" )
                    // {
                    //     $.messager.alert('Info', "Pilih salah satu data terlebih dahulu.", 'warning');
                    //     return false;
                    // }
                }
                adddata(valinfoid, mode);
            });
        });

        function reloadselectedtree(){
            var tt = $('#tt').treegrid({
                url: 'json-app/kelompok_equipment_json/tree',
                onLoadSuccess:function(){
                    /*var node= $('#tt').treegrid('getSelected');
                    console.log(node);return false;
                    var itemSubsting= "";
                    valNode= node.ID;
                    panjangNode= parseInt(node.ID.length) / 3;
                    //alert(panjangNode+'-'+node.ID);
                    for(var i=0;i<panjangNode;i++)
                    {
                        
                        itemSubsting= parseInt(i) + 1;
                        itemSubsting= 3 * parseInt(itemSubsting);
                        itemNode= valNode.substring(0, itemSubsting);
                        $('#tt').treegrid('expand', itemNode);
                    }*/
                }
            });
            //tt.treegrid('enableFilter');
        }

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
                , onLoadSuccess: function(row,data){
                    // console.log(data);
                    buttonaksi();
                }
            });
        });
    </script>