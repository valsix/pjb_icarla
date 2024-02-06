<?php
include_once("functions/string.func.php");
include_once("functions/date.func.php");

$this->load->model("base-app/PlanRla");


$pgtitle= $pg;
$pgtitle= churuf(str_replace("_", " ", str_replace("transaksi_", "", $pgtitle)));

$reqIdRla = $this->input->get("reqIdRla");
$reqLihat = $this->input->get("reqLihat");

$statement = " AND A.PLAN_RLA_ID = '".$reqIdRla."' ";
$set= new PlanRla();
$set->selectByParams(array(), -1, -1, $statement);
$set->firstRow();
$vstatus= $set->getField("V_STATUS");
unset($set);



?>
<script type="text/javascript" language="javascript" class="init">	
</script> 

<!-- FIXED AKSI AREA WHEN SCROLLING -->
<link rel="stylesheet" href="css/gaya-stick-when-scroll.css" type="text/css">
<script src="assets/js/stick.js" type="text/javascript"></script>

    <!-- GANTT -->
    <script src="<?=base_url()?>assets/gantt/codebase/dhtmlxgantt.js?v=6.2.3"></script>
    <!-- <script src="//export.dhtmlx.com/gantt/api.js?v=6.2.3"></script> -->

    <script src="<?=base_url()?>assets/gantt/codebase/dhtmlx.js?v=6.2.3"></script>
    <link rel="stylesheet" href="<?=base_url()?>assets/gantt/codebase/dhtmlx.css?v=6.2.3">

    
    <script src="<?=base_url()?>assets/gantt/api.js"></script>
        
    <script src="<?=base_url()?>assets/gantt/codebase/ext/dhtmlxgantt_multiselect.js?v=6.2.3"></script>
    <!-- <script src="{{ asset('assets/gantt/codebase/ext/dhtmlxgantt_auto_scheduling.js?v=6.2.3') }}"></script> -->
    <script src="<?=base_url()?>assets/gantt/codebase/ext/dhtmlxgantt_keyboard_navigation.js?v=6.2.3"></script>

    <link rel="stylesheet" href="<?=base_url()?>assets/gantt/codebase/dhtmlxgantt.css?v=6.2.3">
    <link rel="stylesheet" href="<?=base_url()?>assets/gantt/samples/common/controls_styles.css?v=6.2.3">

    <!-- <script src="../../codebase/dhtmlxgantt.js?v=6.2.3"></script> -->
    <!-- <script src="//export.dhtmlx.com/gantt/api.js?v=6.2.3"></script> -->
    <!-- <link rel="stylesheet" href="../../codebase/dhtmlxgantt.css?v=6.2.3"> -->
    <!-- <link rel="stylesheet" href="../common/controls_styles.css?v=6.2.3"> -->

<script>
// $(document).ready(function() {
//     var s = $("#bluemenu");
	
//     var pos = s.position();
//     $(window).scroll(function() {
//         var windowpos = $(window).scrollTop();
//         if (windowpos >= pos.top) {
//             s.addClass("stick");
// 			$('#example thead').addClass('stick-datatable');
//         } else {
// 			s.removeClass("stick");
// 			$('#example thead').removeClass('stick-datatable');
//         }
//     });
// });
</script>

<style>
	thead.stick-datatable th:nth-child(1){	width:440px !important; *border:1px solid cyan;}
	thead.stick-datatable ~ tbody td:nth-child(1){	width:440px !important; *border:1px solid yellow;}
</style>

<style type="text/css">
    .gantt_folder_open { display: none; }
    .gantt_folder_closed  { display: none; }
    .gantt_file  { display: none; }
</style>

<div class="col-md-12">
    <div class="judul-halaman"> <a href="app/index/transaksi_management_master_plan">Data Management Master Plan</a> › <a href="app/index/transaksi_management_master_plan_add?reqId=<?=$reqIdRla?>">Kelola Management Master Plan </a> › <?=$pgtitle?></div>
    <div class="konten-area">
        <div class="konten-inner">
            <!-- <div class="form-group"> -->
                <ul class="nav nav-pills mr-auto">
                    <li class="nav-item  ">
                        <a class="nav-link  " href="app/index/transaksi_management_master_plan_add?reqId=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Master Plan RLA</a>
                    </li>
                    <?
                    if(!empty($reqIdRla))
                    {
                        ?> 
                        <li class="nav-item active" >
                            <a class="nav-link active"  href="app/index/transaksi_timeline_rla?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Timelane Rla</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="app/index/transaksi_catatan_rla?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Catatan/Log RLA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="app/index/transaksi_monitoring_pengadaan?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Monitoring Pengadaan & Kontrak</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="app/index/transaksi_pengukuran?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Pengukuran</a>
                        </li>
                        <?
                        if($vstatus==20)
                        {
                            ?>
                            <li class="nav-item ">
                                <a class="nav-link " href="app/index/report_form_uji_plan_rla_dinamis?reqIdRla=<?=$reqIdRla?>&reqLihat=<?=$reqLihat?>"> &nbsp;Report</a>
                            </li>
                            <?
                        }
                        ?>
                       
                        <?
                    }
                    ?>
                </ul>
                <hr style="height:0.8px;border:none;color:#333;background-color:#333;">
                <br>
                <div class="area-menu-tab">
                    <input type="button" id="spanTable" value="Table" onclick="hide_show_chart(false)" />
                    <input type="button" id="spanGantt" value="Gantt" onclick="hide_show_chart(true)" />
                    <input type="button" id="spanReload" value="Reload" onclick="reloadGantt(true)" />
                    <input type="button" id="spanZoomIn" value="Zoom In" onclick="gantt.ext.zoom.zoomIn();" />
                    <input type="button" id="spanZoomOut" value="Zoom Out" onclick="gantt.ext.zoom.zoomOut();" />
                    <input type="button" id="spanExportPDF" value="Export to PDF" onclick="export_data()" />
                    <!-- <input type="button" id="spanScurve" value="S-Curve" onclick="reloadScurve()" /> -->
                </div>
                <div class="">
                    <div id="gantt_here" style='width:100%; height:400px;'></div> 
                    <hr>
                </div>
            <!-- </div> -->
        </div>
    </div>
</div>

<a href="#" id="triggercari" style="display:none" title="triggercari">triggercari</a>
<a href="#" id="btnCari" style="display: none;" title="Cari"></a>

<script type="text/javascript">

	// jQuery(document).ready(function() {
	// 	var jsonurl= "json-app/timeline_rla_json/json";
	//     ajaxserverselectsingle.init(infotableid, jsonurl, arrdata);
	// });

    $(document).ready(function() {
        reloadGantt();
    } );

    function reloadGantt()
    {
        // if (jobPlanId=="") 
        // {
        //     $.messager.alert('Warning', "Silahkan pilih Job Plan terlebih dahulu!", 'warning');
        //     return;
        // }
        gantt.clearAll();
        gantt.load("json-app/timeline_rla_json/gantt/?reqIdRla=<?=$reqIdRla?>", "json").then(function(xhr){
            // $.messager.progress('close');
        });
        // gantt.load("{{url('api/'.$pageUrl.'/gantt/?reqId=')}}"+jobPlanId, "json");
    }

    gantt.config.step = 1;
    gantt.config.min_column_width = 30;
    gantt.config.date_scale = "%d";

    gantt.config.subscales = [
        {unit:"month", step:1, date:"%M" }
    ];
    
    gantt.config.open_tree_initially = true;
    gantt.config.keyboard_navigation_cells = true;
    gantt.config.auto_scheduling = true;
    gantt.config.auto_scheduling_strict = true;
    gantt.config.row_height = 23;
    gantt.config.fit_tasks = true;
    gantt.config.show_unscheduled = true;
    gantt.config.placeholder_task = false;
    gantt.config.auto_types = true;
    gantt.config.date_format = "%d-%m-%Y";
    gantt.config.xml_date= "%d-%m-%Y";
    gantt.config.date_grid = "%d-%m-%Y";
    gantt.config.grid_width = 500;
    gantt.config.readonly = true;

    // gantt.plugins({
    //   auto_scheduling: true
    // })

    gantt.config.static_background = true;
    gantt.config.auto_scheduling = true;

    // //nama per field gantt lightbox
    // gantt.locale.labels.section_pekerjaan = "Item Sub Pekerjaan";
    // gantt.locale.labels.section_supplier = "Sub Kontraktor/Supplier";

    function formatEndDate(task)
    {
        var date = gantt.calculateEndDate({start_date:task.start_date, duration:1, task:task});
        return gantt.templates.date_grid(date, task);
    }

    gantt.config.columns = [
        {name: "wbs", label: "#", width:30, align: "left", template: gantt.getWBSCode},
        // {name: "text", label: "Item", width:"*", tree: true},
        {name: "text", label: "Item", width:"*", tree: true},
        {name: "start_date", label: "Tanggal Awal", width:120, align: "center"},
        {name: "end_date", label: "Tanggal Akhir", width:120, align: "center"},
        {name: "durasi", label: "Durasi", width:60, align: "center"},
        {name: "progress", label: "Progress", width:60, align: "center"}
        // ,
        // {name: "closedtype", label: "Closed", width:80, align: "center", editor: editors.closedtype, resize: true},
        // {name: "closedparent", label: "Closed Parent", width:80, align: "center", editor: editors.closedparent, resize: true}
        // , {name: "add", width: 44}
    ]

    gantt.attachEvent("onError", function(errorMessage)
    {
        alert(errorMessage)
        return true;
    });

    var zoomConfig = {
        levels: [
            {
                name:"hour",
                scale_height: 27,
                min_column_width:15,
                scales:[
                    {unit:"day", format:"%d"},
                    {unit:"hour", format:"%H"},
                ]
            },
            {
                name:"day",
                scale_height: 27,
                min_column_width:80,
                scales:[
                    {unit: "day", step: 1, format: "%d %M"}
                ]
            },
            {
                name:"week",
                scale_height: 50,
                min_column_width:50,
                scales:[
                    {unit: "week", step: 1, format: function (date) {
                        var dateToStr = gantt.date.date_to_str("%d %M");
                        var endDate = gantt.date.add(date, -6, "day");
                        var weekNum = gantt.date.date_to_str("%W")(date);
                        return "#" + weekNum + ", " + dateToStr(date) + " - " + dateToStr(endDate);
                    }},
                    {unit: "day", step: 1, format: "%j %D"}
                ]
            },
            {
                name:"month",
                scale_height: 50,
                min_column_width:120,
                scales:[
                    {unit: "month", format: "%F, %Y"},
                    {unit: "week", format: "Week #%W"}
                ]
            },
            {
                name:"quarter",
                height: 50,
                min_column_width:90,
                scales:[
                    {
                        unit: "quarter", step: 1, format: function (date) {
                            var dateToStr = gantt.date.date_to_str("%M");
                            var endDate = gantt.date.add(gantt.date.add(date, 3, "month"), -1, "day");
                            return dateToStr(date) + " - " + dateToStr(endDate);
                        }
                    },
                    {unit: "month", step: 1, format: "%M"},
                ]
            },
            {
                name:"year",
                scale_height: 50,
                min_column_width: 30,
                scales:[
                    {unit: "year", step: 1, format: "%Y"}
                ]
            }
        ],
        useKey: "ctrlKey",
        trigger: "wheel",
        element: function(){
            return gantt.$root.querySelector(".gantt_task");
        }
    };
    gantt.ext.zoom.init(zoomConfig);

    gantt.init("gantt_here");

    // function export_data1(){
    //   var width = 297 / (25.4/144);
    //   var total_width = gantt.$task_bg.scrollWidth + gantt.$grid.scrollWidth;

    //   for (var i = 0; i < total_width; i += width) {
    //    gantt.exportToPDF({
    //      header:`<style>#gantt_here{left:-${i}px;position: absolute;}</style>`,
    //      raw: true,
    //      additional_settings:{
    //        format: 'A3'
    //      }
    //    });
    //   }
    // }

    function export_data()
    {
        gantt.exportToPDF({
            // name:"mygantt.pdf",
            // header:"<h1>My company</h1>",
            // footer:"<h4>Bottom line</h4>",
            // locale:"en",
            // start:"01-04-2013",
            // end:"11-04-2013",
            skin:'broadway',
            // data:{ },
            // server:"https://myapp.com/myexport/gantt",
            raw:true
        });
    }

    function hide_show_chart(gantStatus)
    {
        $("#gantt_here").show();
        // $("#scurve_form").hide();
        if(gantStatus == true)
        {
            $("#spanTable").attr("class", "");
            $("#spanGantt").attr("class", "active");
        }
        else
        {
            $("#spanTable").attr("class", "active");
            $("#spanGantt").attr("class", "");
        }
        
        gantt.config.show_chart = gantStatus;
        
        gantt.render();
        // gantt.refreshData();
    }
</script>