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

if($line_target != 0 && $line_output != 0){
    $balance = $line_target-$line_output;

    $dataPoints = array(
        array("label"=>"Balance", "y"=>$balance),
        array("label"=>"Output", "y"=>$line_output)
    );
}

?>

<body class="light_theme green_thm left_nav_hide">
<div class="wrapper">

    <div class="inner">
        <!--\\\\\\\left_nav end \\\\\\-->
        <div class="contentpanel">

            <div class="container clear_both padding_fix">
                <!--\\\\\\\ container  start \\\\\\-->
                <div class="header">
                    <!--        <div class="actions"> <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button> </div>-->
                </div>
                <form action="<?php echo base_url();?>dashboard/linePerformanceDashboard" method="post">
                <div class="row">
                    <div class="col-md-12">

                        <select name="line_no" id="line_no" onchange="">
                                <option value="">Select Line</option>
                            <?php foreach ($lines as $ln){ ?>
                                <option value="<?php echo $ln['id'];?>"><?php echo $ln['line_name'];?></option>
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

                        <?php if($line_info[0]['line_name'] != ''){ ?>
                            <span class="center"><h3><b><?php echo $line_info[0]['line_name']; ?></b></h3></span>
                        <?php } ?>

                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <div class="porlets-content">
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!--\\\\\\\ inner end\\\\\\-->
    </div>
</div>
<!--\\\\\\\ wrapper end\\\\\\-->

</body>
</html>

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


//    function getLinePerformanceInfo() {
//        var line = $("#line_no").val();
//
//        $("#chart").empty();
//
//        $.ajax({
//            url: "<?php //echo base_url();?>//dashboard/getLinePerformanceInfo/",
//            type: "POST",
//            data: {line: line},
//            dataType: "json",
//            success: function (data) {
////                $("#chart").append(data);
//                console.log(data);
//            }
//        });
//    }


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
                text: "Target: <?php echo ($line_target != '' ? $line_target : 0);?> | Output: <?php echo ($line_output != '' ? $line_output : 0);?> | Balance: <?php echo ($balance != '' && $balance > 0 ? $balance : 0);?>"
            },
            data: [{
                type: "pie",
                indexLabel: "{y}",
//                yValueFormatString: "#,##0.00\"%\"",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#FFFFFF",
                indexLabelFontSize: 18,
                indexLabelFontWeight: "bolder",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }

</script>
<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.0.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common-script.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jPushMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/js/side-chats.js"></script>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/form-components.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/dynamic_table_init.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/edit-table/edit-table.js"></script>