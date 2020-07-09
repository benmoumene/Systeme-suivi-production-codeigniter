<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title ?></title>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <script src="<?php echo base_url(); ?>assets/js/jquery-latest.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/jquery-1.9.0.js"></script>
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/css/colorpicker.css" />
    <link href="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/advanced-datatable/css/demo_page.css" rel="stylesheet" />

    <!--Select2 Start-->
    <script src="<?php echo base_url(); ?>assets/select2/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/select2/select2.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/select2/select2.min.css" rel="stylesheet"/>

    <!--Canvas Chart Asset Start-->
    <script src="<?php echo base_url(); ?>assets/js/canvas_chart/canvasjs.min.js"></script>
    <!--Canvas Chart Asset End-->

    <style type="text/css">

        .has-error .select2-selection {
            /*border: 1px solid #a94442;
            border-radius: 4px;*/
            border-color:rgb(185, 74, 72) !important;
        }

        div.scroll {
            /*background-color: #00FFFF;*/
            width: 1900px;
            height: 500px;
            overflow: scroll;
        }

        div.scroll2 {
            /*background-color: #00FFFF;*/
            width: 1200px;
            height: 500px;
            overflow: scroll;
        }

        div.scroll3 {
            /*background-color: #00FFFF;*/
            width: 700px;
            height: 500px;
            overflow: scroll;
        }

        /*table thead fixed*/
        .table-fixed thead {
            width: 100%;
        }
        .table-fixed tbody {
            height: 230px;
            overflow-y: auto;
            width: 100%;
        }
        .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
            display: block;
        }
        .table-fixed tbody td, .table-fixed thead > tr> th {
            float: left;
            border-bottom-width: 0;
        }
        /*table thead fixed*/

        .well1 {
            background: none;
            height: 400px;
        }

        .well {
            background: none;
            height: 600px;
        }

        .table-scroll tbody {
            position: absolute;
            overflow-y: scroll;
            height: 450px;
        }

        .table-scroll tr {
            width: 100%;
            table-layout: fixed;
            display: inline-table;
        }

        .table-scroll thead > tr > th {
            /*border: none;*/
        }
    </style>
    <!--Select2 End-->
</head>
<!--<body class="light_theme  fixed_header left_nav_fixed">-->
<?php

$finishing_target = (($finishing_target != '' && $finishing_target != 0) ? $finishing_target : 0);
$finishing_output_qty = (($finishing_output_qty != '' && $finishing_output_qty != 0) ? $finishing_output_qty : 0);

$balance = $finishing_target-$finishing_output_qty;

$balance = (($balance != '' && $balance != 0) ? $balance : 0);

$dataPoints = array(
    array("label"=>"Balance", "y"=>$balance),
    array("label"=>"Output", "y"=>$finishing_output_qty)
)

?>
<body class="light_theme green_thm left_nav_hide">
<div class="wrapper">

    <div class="inner">
        <!--\\\\\\\left_nav end \\\\\\-->
        <div class="contentpanel">

            <div class="pull-left breadcrumb_admin clear_both">
                <div class="pull-left page_title theme_color">
                    <!--          <h1>Dashboard</h1>-->
                    <!--          <h2 class="">Dashboard...</h2>-->
                    Finishing Performance
                </div>
                <div class="pull-right">
                    <ol class="breadcrumb">
                        <li><a href="javascript:void(0);" onclick="window.location.reload(1);"> <i class="fa fa-repeat"></i> </a></li>
                        <li><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </div>
            </div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="header">
        <!--        <div class="actions"> <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button> </div>-->
    </div>
    <form action="<?php echo base_url();?>dashboard/finishingPerformanceDashboard" method="post">
        <div class="row">
            <div class="col-md-12">
                <select name="floor" id="floor" onchange="">
                    <option value="">Select Floor</option>
                    <?php foreach ($floors as $flr){ ?>
                        <option value="<?php echo $flr['id'];?>"><?php echo $flr['floor_name'];?></option>
                    <?php } ?>
                </select>

                <button type="submit">Search</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">
            <h1>
                <b>
                    <?php
                        if($floor_name != ''){
                            echo $floor_name.' - '."FINISHING";
                        }
                    ?>
                </b>
            </h1>
        </div>
        <div class="col-md-4">

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="col-md-12">

                <section class="panel default">
                    <div class="panel-body">

                        <div id="chartContainer" style="height: 500px; width: 100%;"></div>

                    </div>
                </section>
            </div>


        </div>
    </div>

</div>

        </div>
    </div>

</div>
</body>

<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
//        setInterval(function(){
//            $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReportByUID');
//        }, 10000);

//        setInterval(function() {
//            window.location.reload();
//        }, 30000);
    });

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

    function getSizeWiseReport(sap_no, po, item, quality, color) {
        $("#size_tbl").empty();

//        alert(sap_no+'-'+po+'-'+item+'-'+quality+'-'+color);

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeReport/",
            type: "POST",
            data: {po_no: sap_no, purchase_order: po, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
            }
        });
    }

    // Chart Data Load

    window.onload = function() {
        CanvasJS.addColorSet("colorShades",
            [//colorSet Array

                "#ad1d0a",
                "#3CB371"
            ]);

        var chart = new CanvasJS.Chart("chartContainer", {
            colorSet: "colorShades",
            theme: "theme2",
            animationEnabled: true,
            title: {
//                text: "Target: <?php //echo ($line_target != '' ? $line_target : 0);?>// | Output: <?php //echo ($line_output != '' ? $line_output : 0);?>// | Balance: <?php //echo ($balance != '' && $balance > 0 ? $balance : 0);?>//"
                text: "Target:<?php echo ($finishing_target != '' ? $finishing_target : 0);?> | Balance:<?php echo ($balance != '' && $balance > 0 ? $balance : 0);?>"
            },
            data: [{
                type: "pie",
                indexLabel: "{y}",
//                yValueFormatString: "#,##0.00\"%\"",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#FFFFFF",
                indexLabelFontSize: 35,
                indexLabelFontWeight: "bolder",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }

</script>