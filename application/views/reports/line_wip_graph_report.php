<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="300">
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
    </style>
</head>
<!--<body class="light_theme  fixed_header left_nav_fixed">-->
<body>
<div class="row center">
    <div class="col-md-12">
<!--        <div class="col-md-1"></div>-->
            <div class="col-md-12">
                <table border="1" width="100%">
                    <thead>
                        <tr style="background-color: rgba(159,255,154,0.41)">
                            <th class="text-center"><span style="font-size: 25px;">LAY WIP</span></th>
                            <th class="text-center"><span style="font-size: 25px;">TODAY CUT</span></th>
                            <th class="text-center"><span style="font-size: 25px;">MARKER</span></th>
                            <th class="text-center"><span style="font-size: 25px;">GARMENTS/RATIO</span></th>
                            <th class="text-center" title="Today Ready Package"><span style="font-size: 25px;">TODAY PACKAGE(STOCK)</span></th>
                            <th class="text-center" title="Total Ready Package"><span style="font-size: 25px;">TOTAL PACKAGE(STOCK)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-center"><span style="font-size: 22px;"><?php echo ($lay_qty[0]['total_lay_qty'] != '' ? $lay_qty[0]['total_lay_qty'] : 0);?></span></th>
                            <th class="text-center"><span style="font-size: 22px;"><?php echo ($today_cut[0]['today_cut_qty'] != '' ? $today_cut[0]['today_cut_qty'] : 0);?></span></th>
                            <th class="text-center"><span style="font-size: 22px;"><?php echo ($today_no_of_marker[0]['total_no_of_marker_qty'] != '' ? $today_no_of_marker[0]['total_no_of_marker_qty'] : 0);?></span></th>
                            <th class="text-center"><span style="font-size: 22px;"><?php echo ($today_no_of_garments[0]['total_no_of_garments'] != '' ? $today_no_of_garments[0]['total_no_of_garments'] : 0);?></span></th>
                            <th class="text-center"><span style="font-size: 22px;"><?php echo ($today_cut_ready_package[0]['today_package_ready_qty'] != '' ? $today_cut_ready_package[0]['today_package_ready_qty'] : 0);?></span></th>
                            <th class="text-center"><span style="font-size: 22px;"><?php echo ($cut_ready_package[0]['cut_ready_qty'] != '' ? $cut_ready_package[0]['cut_ready_qty'] : 0);?></span></th>
                        </tr>
                    </tbody>
                </table>
            </div>
<!--        <div class="col-md-1"></div>-->
    </div>
</div>
<br />
<div class="row center">
    <div class="col-md-12">
        <div class="col-md-8">
            <div id="chartContainer" style="height: 400px; width: 100%;"></div>
        </div>
        <div class="col-md-4">
            <div id="chartContainer_1" style="height: 400px; width: 100%;">
                <table>
                    <thead>
                    <tr style="background-color: rgba(179,238,255,0.88)">
                        <th class="text-center" colspan="4"><span style="font-size: 28px;">STYLE TYPE WISE REPORT</span></th>
                    </tr>
                </table>
                <table>
                    <thead>
                        <tr style="background-color: rgba(112,255,86,0.88)">
                            <th class="text-center" colspan="4"><span style="font-size: 22px;">CHECK</span></th>
                        </tr>
                        <tr>
                            <th class="text-center"><span style="font-size: 20px;">LAY WIP</span></th>
                            <th class="text-center"><span style="font-size: 20px;">CUT</span></th>
                            <th class="text-center"><span style="font-size: 20px;">MARKER</span></th>
                            <th class="text-center"><span style="font-size: 20px;">GARMENTS/RATIO</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($lay_qty_check[0]['total_lay_qty'] != '' ? $lay_qty_check[0]['total_lay_qty'] : 0);?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($today_cut_check[0]['today_cut_qty'] != '' ? $today_cut_check[0]['today_cut_qty'] : 0);?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($today_no_of_marker_check[0]['total_no_of_marker_qty'] != '' ? $today_no_of_marker_check[0]['total_no_of_marker_qty'] : 0);?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($today_no_of_garments_check[0]['total_no_of_garments'] != '' ? $today_no_of_garments_check[0]['total_no_of_garments'] : 0);?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr style="background-color: rgba(112,255,86,0.88)">
                            <th class="text-center" colspan="4"><span style="font-size: 22px;">SOLID</span></th>
                        </tr>
                        <tr>
                            <th class="text-center"><span style="font-size: 20px;">LAY WIP</span></th>
                            <th class="text-center"><span style="font-size: 20px;">CUT</span></th>
                            <th class="text-center"><span style="font-size: 20px;">MARKER</span></th>
                            <th class="text-center"><span style="font-size: 20px;">GARMENTS/RATIO</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($lay_qty_solid[0]['total_lay_qty'] != '' ? $lay_qty_solid[0]['total_lay_qty'] : 0);?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($today_cut_solid[0]['today_cut_qty'] != '' ? $today_cut_solid[0]['today_cut_qty'] : 0);?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($today_no_of_marker_solid[0]['total_no_of_marker_qty'] != '' ? $today_no_of_marker_solid[0]['total_no_of_marker_qty'] : 0);?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($today_no_of_garments_solid[0]['total_no_of_garments'] != '' ? $today_no_of_garments_solid[0]['total_no_of_garments'] : 0);?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr style="background-color: rgba(112,255,86,0.88)">
                            <th class="text-center" colspan="4"><span style="font-size: 22px;">PRINT</span></th>
                        </tr>
                        <tr>
                            <th class="text-center"><span style="font-size: 20px;">LAY WIP</span></th>
                            <th class="text-center"><span style="font-size: 20px;">CUT</span></th>
                            <th class="text-center"><span style="font-size: 20px;">MARKER</span></th>
                            <th class="text-center"><span style="font-size: 20px;">GARMENTS/RATIO</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($lay_qty_print[0]['total_lay_qty'] != '' ? $lay_qty_print[0]['total_lay_qty'] : 0);?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($today_cut_print[0]['today_cut_qty'] != '' ? $today_cut_print[0]['today_cut_qty'] : 0);?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($today_no_of_marker_print[0]['total_no_of_marker_qty'] != '' ? $today_no_of_marker_print[0]['total_no_of_marker_qty'] : 0);?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span style="font-size: 18px;">
                                    <?php echo ($today_no_of_garments_print[0]['total_no_of_garments'] != '' ? $today_no_of_garments_print[0]['total_no_of_garments'] : 0);?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br />
<!--<div id="chartContainer_1" style="height: 200px; width: 100%;"></div>-->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
</body>

</html>

<script type="text/javascript">
    $(document).ready(function(){
        setInterval(function() {
            window.location.reload();
        }, 300000);
    });

    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer",
            {
                animationEnabled: true,
                title: {
                    text: "CUT TABLE REPORT: <?php echo $date;?>"
                },
                dataPointWidth: 30,
                axisX: {
                    valueFormatString: "",
                    labelFontSize: 25
                },
                axisY: {
                    prefix: "",
                },
//            toolTip: {
//                shared: true
//            },
                legend: {
                    cursor: "pointer"
                },
                data: [
                    {
                        type: "column",
                        name: "LAY WIP",
                        showInLegend: true,
                        color: "#d8cf27",
                        indexLabelFontSize: 25,
                        indexLabelOrientation: "vertical",
                        xValueFormatString: "LAY WIP",
                        yValueFormatString: "#,##0",
                        dataPoints: [

                            <?php foreach ($table_report as $k_1 => $v_1){

                            $balance_to_cut_qty = ($v_1['balance_to_cut_qty'] != '' ? $v_1['balance_to_cut_qty'] : 0);

                            ?>
                            { label: "<?php echo $v_1['table_name'];?>", y: <?php echo $balance_to_cut_qty;?>, indexLabel: "<?php echo $balance_to_cut_qty;?>" },
                            <?php } ?>

                        ]
                    },
                    {
                        type: "column",
                        name: "CUT",
                        showInLegend: true,
                        color: "#62a4d8",
                        indexLabelFontSize: 25,
                        indexLabelOrientation: "vertical",
                        xValueFormatString: "CUT",
                        yValueFormatString: "##0",
                        dataPoints: [

                            <?php foreach ($table_report as $k_1 => $v_1){

                            $cut_complete_qty = ($v_1['cut_complete_qty'] != '' ? $v_1['cut_complete_qty'] : 0);

                            ?>
                            { label: "<?php echo $v_1['table_name'];?>", y: <?php echo $cut_complete_qty;?>, indexLabel: "<?php echo $v_1['cut_complete_qty'];?>" },
                            <?php } ?>

                        ]
                    }

                ]
            });

        chart.render();

//        Line WIP Report Start
//        var chart_1 = new CanvasJS.Chart("chartContainer_1",
//            {
//                animationEnabled: true,
//                title:{
//                    text: "LINE WIP REPORT"
//                },
//                axisY:{
//                    title: "QTY",
//                    tickLength: 0,
//                    lineThickness:0,
//                    margin:0,
//                    valueFormatString:" " //comment this to show numeric values
//                },
//                axisX:{
//                    title: "Line",
//                    interval:1,
//                    labelMaxWidth: 100,
//                    labelAngle: 0,
//                    labelFontSize: 16,
//                    labelFontWeight: "bold"
//                },
//
//                toolTip: {
//                    shared: true
//                },
//
//                legend: {
//                    cursor:"pointer"
//                },
//
//                dataPointWidth: 20,
//
//                data: [
//
//                    {
//                        type: "column",
//                        showInLegend: true,
////                        color: "#ff1000",
//                        color: "#ffbf00",
//                        name: "Line WIP",
//                        indexLabel: "{y}",
//                        dataPoints: [
//                            <?php
//
//                            foreach ($cut_wip_report as $v_w)
//                            {
//                                $line_id = $v_w['line_id'];
//                                $line_name = $v_w['line_code'];
//
//
//                                $count_qty_line = ($v_w['wip'] != '' ? $v_w['wip'] : 0);
//
//
////                                $line_input_date = $v['line_input_date'];
//
//                                echo "{label: '$line_name', y: $count_qty_line },";
//                            }
//                            ?>
//                        ]
//                    },
//                    {
//                        type: "column",
//                        showInLegend: true,
////                        color: "#ff1000",
//                        color: "#4dbcfa",
//                        name: "Line Super Market",
//                        indexLabel: "{y}",
//                        dataPoints: [
//                            <?php
//                            foreach ($cut_wip_report as $v)
//                            {
//                                $line_id = $v['line_id'];
//                                $line_name = $v['line_code'];
//
//                                $count_super_market = ($v['cut_sew_ready_qty'] != '' ? $v['cut_sew_ready_qty'] : 0);
//
////                                $line_input_date = $v['line_input_date'];
//
//                                echo "{label: '$line_name', y: $count_super_market, },";
//                            }
//                            ?>
//                        ]
//                    }
//
//                ]
//
//            });
//
//        chart_1.render();

//        Line WIP Report End
    }
</script>