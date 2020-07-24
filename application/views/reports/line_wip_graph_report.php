<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
<!--    <meta http-equiv="refresh" content="300">-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $title ?></title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!--Canvas Chart Asset Start-->
    <script src="<?php echo base_url(); ?>assets/js/canvas_chart/jquery-1.11.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/canvas_chart/canvasjs.min.js"></script>
    <!--Canvas Chart Asset End-->

    <style>
        table, td, th {
            border: 1px solid #ddd;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 2px;
        }

        /* Loader Style Start */

        .loader {
            border: 20px solid #f3f3f3;
            border-radius: 50%;
            border-top: 20px solid #3498db;
            width: 35px;
            height: 35px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Loader Style End */
    </style>
</head>
<!--<body class="light_theme  fixed_header left_nav_fixed">-->
<body>
<div class="row center">
    <div class="col-md-12">
<!--        <div class="col-md-1"></div>-->
            <div id="loader" style="display: none;"><div class="loader"></div></div>
            <div class="col-md-12" id="chartContainer"></div>
<!--        <div class="col-md-1"></div>-->
    </div>
</div>
<br />
<div class="row center">
    <div class="col-md-12">
        <div class="col-md-8">
            <div id="loader_1" style="display: none;"><div class="loader"></div></div>
            <div id="chartContainer_1" style="height: 400px; width: 100%;"></div>
        </div>
        <div class="col-md-4">
            <div id="loader_2" style="display: none;"><div class="loader"></div></div>
            <div id="chartContainer_2" style="height: 400px; width: 100%;"></div>
        </div>
    </div>
</div>
<br />
<!--<div id="chartContainer_1" style="height: 200px; width: 100%;"></div>-->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
</body>

</html>

<script type="text/javascript">

    $(document).ready(function(){
//        setInterval(function() {
//            window.location.reload();
//        }, 300000);

        $("#loader").css("display", "block");
        $("#loader_1").css("display", "block");
        $("#loader_2").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>dashboard/layCutPackageReadySummaryReport/",
            type: "POST",
            data: {},
            dataType: "html",
            success: function (data) {
                $("#chartContainer").empty();
                $("#chartContainer").append(data);
                $("#loader").css("display", "none");
            }
        });

        $("#chartContainer_1").load('<?php echo base_url();?>dashboard/tableWiseLayCutReport/');

        setInterval(function(){
            var isEmptywip = $("#chartContainer_1").html() === "";

            if(isEmptywip == false){
                $("#loader_1").css("display", "none");
            }
        }, 1000);

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getStyleTypeWiseCuttingReport/",
            type: "POST",
            data: {},
            dataType: "html",
            success: function (data) {
                $("#chartContainer_2").empty();
                $("#chartContainer_2").append(data);
                $("#loader_2").css("display", "none");
            }
        });

        setInterval(function(){
            $("#chartContainer").load('<?php echo base_url();?>dashboard/layCutPackageReadySummaryReport');
            $("#loader").css("display", "none");
            $("#chartContainer_1").load('<?php echo base_url();?>dashboard/tableWiseLayCutReport');
            $("#loader_1").css("display", "none");
            $("#chartContainer_2").load('<?php echo base_url();?>dashboard/getStyleTypeWiseCuttingReport');
            $("#loader_2").css("display", "none");

        }, 300000);

    });

//    window.onload = function () {
//
//        var chart = new CanvasJS.Chart("chartContainer_1",
//            {
//                animationEnabled: true,
//                title: {
//                    text: "CUT TABLE REPORT: <?php //echo $date;?>//"
//                },
//                dataPointWidth: 30,
//                axisX: {
//                    valueFormatString: "",
//                    labelFontSize: 25
//                },
//                axisY: {
//                    prefix: "",
//                },
////            toolTip: {
////                shared: true
////            },
//                legend: {
//                    cursor: "pointer"
//                },
//                data: [
//                    {
//                        type: "column",
//                        name: "LAY WIP",
//                        showInLegend: true,
//                        color: "#d8cf27",
//                        indexLabelFontSize: 25,
//                        indexLabelOrientation: "vertical",
//                        xValueFormatString: "LAY WIP",
//                        yValueFormatString: "#,##0",
//                        dataPoints: [
//
//                            <?php //foreach ($table_report as $k_1 => $v_1){
//
//                            $balance_to_cut_qty = ($v_1['balance_to_cut_qty'] != '' ? $v_1['balance_to_cut_qty'] : 0);
//
//                            ?>
//                            { label: "<?php //echo $v_1['table_name'];?>//", y: <?php //echo $balance_to_cut_qty;?>//, indexLabel: "<?php //echo $balance_to_cut_qty;?>//" },
//                            <?php //} ?>
//
//                        ]
//                    },
//                    {
//                        type: "column",
//                        name: "CUT",
//                        showInLegend: true,
//                        color: "#62a4d8",
//                        indexLabelFontSize: 25,
//                        indexLabelOrientation: "vertical",
//                        xValueFormatString: "CUT",
//                        yValueFormatString: "##0",
//                        dataPoints: [
//
//                            <?php //foreach ($table_report as $k_1 => $v_1){
//
//                            $cut_complete_qty = ($v_1['cut_complete_qty'] != '' ? $v_1['cut_complete_qty'] : 0);
//
//                            ?>
//                            { label: "<?php //echo $v_1['table_name'];?>//", y: <?php //echo $cut_complete_qty;?>//, indexLabel: "<?php //echo $v_1['cut_complete_qty'];?>//" },
//                            <?php //} ?>
//
//                        ]
//                    }
//
//                ]
//            });
//
//        chart.render();
//
//    }
</script>