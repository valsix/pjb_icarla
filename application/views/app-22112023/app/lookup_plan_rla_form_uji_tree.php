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
<!--<link rel="stylesheet" type="text/css" href="/css/normalize.css">-->
<script type="text/javascript" src="js/jquery-ui.js"></script>

<!-- EASYUI 1.4.5 -->
<link rel="stylesheet" type="text/css" href="assets/easyui/themes/default/easyui.css">
<link rel="stylesheet" type="text/css" href="assets/easyui/themes/icon.css">
<script type="text/javascript" src="assets/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="assets/easyui/datagrid-groupview.js"></script>
<script type="text/javascript" src="assets/easyui/globalfunction.js"></script>
<script type="text/javascript" src="assets/easyui/kalender-easyui.js"></script>    

<!-- FONT AWESOME -->
<link rel="stylesheet" href="lib/font-awesome-4.7.0/css/font-awesome.css" type="text/css">

<style type="text/css">
    .panel.combo-p{
        width: 300px !important;
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
            
            <div class="col-md-3 col-treegrid">
                <div class="konten">
                    <div id="infodetilparaf">
                        <label>Form Uji Terpilih: </label>
                        <button class="btn btn-primary btn-sm" type="button" onClick="setsatuankerjapilih()"><i class="fa fa-user-circle"></i> Ok</button>
                        <br><span>Pilih salah satu data!</span>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-treegrid">
                <div class="area-konten-atas">
                    <div class="judul-halaman"> <?=ucwords(strtolower($reqJenis))?> Form Uji</div>
                    <div class="area-menu-aksi">    
                        <!--Pencarian : <input type="text" name="reqPencarian" id="reqPencarian">-->

                         <div id="bluemenu" class="aksi-area">
                        	<label class="col-md-5">
                            <span>Kelompok Equipment </span>
                            <input type="text" name="reqKelompokEquipmentId" class="easyui-combobox" id="reqKelompokEquipmentId" 
                            data-options="
                            width:'300'
                            , editable:false
                            , valueField:'id'
                            , textField:'text'
                            , url:'json-app/combo_json/combokelompokeq?reqKelompokEquipmentId=<?=$reqKelompokEquipmentId?>'
                            " 
                            value=""  />
                            </label>
                            <label class="col-md-7 text-right">
                            <span>Pencarian </span> 
                            <input type="text" name="reqPencarian" class="easyui-validatebox textbox form-control" id="reqPencarian" style="width:300px"> 
                            </label>
                        </div>
                        
                    </div>
                    
                </div>
                
                <!-- singleSelect: false, -->
                <div id="tableContainer" class="tableContainer tableContainer-treegrid">
                    <table id="treeSatker" class="easyui-treegrid" style="min-width:100px !important;height:300px"
                            data-options="
                                url: 'json-app/plan_rla_json/tree_formuji/?reqKelompokEquipmentId=<?=$reqKelompokEquipmentId?>',
                                pagination: true, 
                                method: 'get',
                                idField: 'id',
                                treeField: 'text',
                                fitColumns: true,
                                onBeforeLoad: function(row,param){
                                    if (!row) {    // load top level rows
                                        param.id = 0;    // set id=0, indicate to load new page rows
                                    }
                                }
                            ">
                        <thead>
                            <tr>
                                <th data-options="field:'KELOMPOK_EQUIPMENT_ID',width:100" formatter="formatcheckbox">Kelompok Equipment</th>
                                <!-- <th data-options="field:'NAMA',width:300">Form Uji</th> -->
                            </tr>
                        </thead>
                    </table>
                </div>
                
            </div>
        </div>        
    </div>
    
<script>
var infoid= [];
var infonama= [];
var tempdataintegrasi= "";
function setsatuankerjapilih()
{
	// console.log(infoid);
    if(infoid.length == 0)
    {
        $.messager.alert('Info', "Pilih data terlebih dahulu.", 'info');
        return;
    }
    else
    {
        vkelompokequipmentid= [];
        vformujiid= [];
        infoid.forEach(function (item, index) {
            // console.log(item, index);
            arritem= item.split('_');
            // console.log(arritem[0]);
            // console.log(arritem[1]);
            // console.log(arritem);
            vkelompokequipmentid.push(String(arritem[0]));
            vformujiid.push(String(arritem[1]));
        });

        // console.log(vkelompokequipmentid);
        // console.log(infonama);

        // console.log(infoid);
        var divIdField = "divlistform";
        top.addmultisatuanKerja(vkelompokequipmentid,vformujiid, infonama, divIdField);
        top.closePopup();
    }
}

// function show(checkid,ujiid)
function show(checkid)
{

    // var s = '#check_'+checkid+'_'+ujiid+'';
    var s = '#check_'+checkid;
    var nodes = $("#treeSatker").treegrid("find",checkid);
    // console.log(s);
    // console.log(nodes);
    // console.log(checkid);

    idselected= nodes.id;
    namakelompok= nodes.NAMA_FORM;
    nama= nodes.NAMA_KELOMPOK;
    var tujuan= namakelompok +' - '+ nama;

        infochecked= $(s)[0].checked;
        // console.log(infochecked);
        // $(('#check_'+idselected+'_'+ujiid))[0].checked = infochecked;
        $(('#check_'+idselected))[0].checked = infochecked;

        if(infochecked == false)
        {
            var elementRow= infoid.indexOf(checkid);
            if(parseInt(elementRow) >= 0)
            {
                infoid.splice(elementRow, 1);
                infonama.splice(elementRow, 1);
            }
        }
        else
        {
            infoid.push(String(checkid));
            infonama.push(String(tujuan));
        }
        // setinfo(ujiid);

        setinfo();
        // console.log(tujuan);
    

}

// function setinfo(ujiid)
function setinfo()
{
    idata=0;
    infodetilparaf= '<label>Form Uji Terpilih:</label><button class="btn btn-primary btn-sm" type="button" onClick="setsatuankerjapilih()"><i class="fa fa-user-circle"></i> Ok</button>';
    infodetilparaf+= "<ol id='SortMe'>";
    /*infoid.forEach(function (item, index) {
       
        var nodes = $("#treeSatker").treegrid("find",item);
         // console.log( nodes);
        
        if(typeof nodes==='undefined' || nodes===null || nodes == "")
        {
            // jabatan= infonama[index];
            // infodetilparaf+= "<li class='ListItem'>"+jabatan+"</li>";
        }
        else
        {
            // $('#check_'+item+'_'+ujiid+':checked').each(function() {
            //  // console.log(this.value+'_'+item+'_'+ujiid);
            // });

             nodes.children.forEach(function (e, index) {
                // if(e.KELOMPOK_EQUIPMENT_ID == item && e.FORM_UJI_ID== ujiid )
                // {

                   var checkedform= $('#check_'+item+'_'+ujiid).prop("checked");
                   // console.log(checkedform+'_'+item+'_'+ujiid);

                   if(checkedform === true)
                   {
                       namakelompok= e.NAMA_FORM;
                       nama=e.NAMA_KELOMPOK;
                       var tujuan= namakelompok +' - '+ nama;
                       infodetilparaf+= "<li class='ListItem'>"+tujuan+"</li>";
                       // console.log(tujuan);
                   }

                
                 // infodetilparaf+= "<li class='ListItem'>"+tujuan+"</li>";
                // }
             
            });
               
        	
        }
        idata= parseInt(idata) + 1;
    });*/

    infoid.forEach(function (item, index) {
        // console.log(item, index);
        var nodes = $("#treeSatker").treegrid("find",item);
        if(typeof nodes==='undefined' || nodes===null || nodes == "")
        {
            // jabatan= infonama[index];
            // infodetilparaf+= "<li class='ListItem'>"+jabatan+"</li>";
        }
        else
        {
            namakelompok= nodes.NAMA_FORM;
            nama=nodes.NAMA_KELOMPOK;
            var tujuan= namakelompok +' - '+ nama;
            infodetilparaf+= "<li class='ListItem'>"+tujuan+"</li>";
        }
        idata= parseInt(idata) + 1;
    });

    infodetilparaf+= "</ol><div class='text-danger'><i class='fa fa-info-circle' aria-hidden='true'></i> Ubah urutan form uji dengan cara <strong><i>drag and drop</i></strong></div>";

    if(idata == 0)
    {
        infodetilparaf= '<label>Form Uji Terpilih: Pilih salah satu data</label><button class="btn btn-primary btn-sm" type="button" onClick="setsatuankerjapilih()"><i class="fa fa-user-circle"></i> Ok</button>';
    }

    $("#infodetilparaf").empty();
    $("#infodetilparaf").html(infodetilparaf);
    
    // SORT/CHANGE POSITION OF LIST ITEM
    var Items = $("#SortMe li");
    $('#SortMe').sortable({
        disabled: false,
        axis: 'y',
        forceHelperSize: true,
        start: function(evt, ui){
            $(ui.item).data('old-ndex' , ui.item.index());
        },
        update: function (event, ui) {
            var oldindex= $(ui.item).data('old-ndex');
            var newindex= ui.item.index();
            panjang= infoid.length;
            // console.log('old index -'+oldindex+' new index -'+newindex+' panjang -'+panjang);

            var tempinfoid= [];
            var tempinfonama= [];

            idtuker= infoid[oldindex];
            namatuker= infonama[oldindex];

            if(oldindex + 1 == panjang || oldindex > newindex)
            {
                infoid.splice(newindex, 0, idtuker);
                infonama.splice(newindex, 0, namatuker);

                delete infoid[oldindex+1];
                delete infonama[oldindex+1];
            }
            else
            {
                infoid.splice(newindex+1, 0, idtuker);
                infonama.splice(newindex+1, 0, namatuker);

                delete infoid[oldindex];
                delete infonama[oldindex];
            }

            infoid= clean(infoid);
            infonama= clean(infonama);

            // console.log(infonama);
        }
    }).disableSelection();
}

function clean(item) {
    var tempArr = [];
    for (var i = 0; i < item.length; i++) {
        if (item[i] !== undefined && item[i] != "") {
            tempArr.push(item[i]);
        }
    }
    return tempArr;
}

function getselected(mode)
{
    tempdataintegrasi= "";
    idata=0;
    infoid.forEach(function (item, index) {
        if(tempdataintegrasi == "")
            tempdataintegrasi= item;
        else
            tempdataintegrasi += ','+item;

        tujuan= $(('#check_'+item))[0];
        if(typeof tujuan==='undefined' || tujuan===null || tujuan == ""){}
        else
        {
            if(mode == "selected")
            {
                $(('#check_'+item))[0].checked = true;
            }
        }

        idata= parseInt(idata) + 1;
    });
}

function formatcheckbox(val,row)
{
    // console.log(row);
    if(row.parentId==0)
    {
         return "<label style='font-size:11pt'>" + row.NAMA+ "</label>";
    }
    else
    {
       
    kelompokjabatan= row.id;
    return "<input type='checkbox' onclick=show('"+row.KELOMPOK_EQUIPMENT_ID+"_"+row.FORM_UJI_ID+"') id='check_"+row.KELOMPOK_EQUIPMENT_ID+"_"+row.FORM_UJI_ID+"' "+(row.checked?'checked':'')+"/> " + row.NAMA_FORM;
    }

	
}

$(document).ready( function () {     
    $("#reqPencarian").focus();
    $('#reqKelompokEquipmentId').combobox({
        onSelect: function(param){
            var urlApp = 'json-app/plan_rla_json/tree_formuji/?reqKelompokEquipmentId='+param.id+'&reqPencarian='+$("#reqPencarian").val();
            $('#treeSatker').treegrid(
            {
                url: urlApp
                , pageSize: 1
            });
        }
    });
        
    $('input[name=reqPencarian]').keyup(function(e) {
        var value = this.value;
        $("html, body").animate({ scrollTop: 0 });

        if(e.keyCode == 13) {
            var urlApp = 'json-app/plan_rla_json/tree_formuji/?reqKelompokEquipmentId='+$('#reqKelompokEquipmentId').combobox("getValue")+'&reqPencarian='+value;
            $('#treeSatker').treegrid(
            {
                url: urlApp,
                onLoadSuccess: function(row,param){
                    getselected("selected");
                    // console.log("s");
                }
            }); 
        }
    });
        

});

$("#dnd-example tr").click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    var id = $(this).find('td:first').attr('id');
    var title = $(this).find('td:first').attr('title');
}); 
</script>
    
<script>
    // Mendapatkan tinggi .area-konten-atas
    var divTinggi = $(".area-konten-atas").height();
    //alert(divTinggi);
    
    // Menentukan tinggi tableContainer
    $('#tableContainer').css({ 'height': 'calc(100% - ' + divTinggi+ 'px)' });
</script>

</body>
</html>