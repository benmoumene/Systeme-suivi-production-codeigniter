<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="refresh" content="180">
    <title><?php echo $title ?></title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />
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
<div>
    <table border="1" width="100%">
        <thead>
            <tr style="background-color: rgba(159,255,154,0.41)">
                <th align="center"><span style="font-size: 25px;">LAY QTY</span></th>
                <th align="center"><span style="font-size: 25px;">TODAY CUT</span></th>
                <th align="center"><span style="font-size: 25px;">MARKER</span></th>
                <th align="center"><span style="font-size: 25px;">GARMENTS</span></th>
                <th align="center"><span style="font-size: 25px;">TODAY READY PACKAGE</span></th>
                <th align="center"><span style="font-size: 25px;">TOTAL READY PACKAGE</span></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th align="center"><span style="font-size: 22px;"><?php echo ($lay_qty[0]['total_lay_qty'] != '' ? $lay_qty[0]['total_lay_qty'] : 0);?></span></th>
                <th align="center"><span style="font-size: 22px;"><?php echo ($today_cut[0]['today_cut_qty'] != '' ? $today_cut[0]['today_cut_qty'] : 0);?></span></th>
                <th align="center"><span style="font-size: 22px;"><?php echo ($today_no_of_marker[0]['total_no_of_marker_qty'] != '' ? $today_no_of_marker[0]['total_no_of_marker_qty'] : 0);?></span></th>
                <th align="center"><span style="font-size: 22px;">
                        <?php echo ($today_no_of_garments[0]['total_no_of_garments'] != '' ? $today_no_of_garments[0]['total_no_of_garments'] : 0);?></span></th>
                <th align="center"><span style="font-size: 22px;"><?php echo ($today_cut_ready_package[0]['today_package_ready_qty'] != '' ? $today_cut_ready_package[0]['today_package_ready_qty'] : 0);?></span></th>
                <th align="center"><span style="font-size: 22px;"><?php echo ($cut_ready_package[0]['cut_ready_qty'] != '' ? $cut_ready_package[0]['cut_ready_qty'] : 0);?></span></th>
            </tr>
        </tbody>
    </table>
</div>
<br />
<div id="chartContainer" style="height: 400px; width: 100%;"></div>
<br />
<!--<div id="chartContainer_1" style="height: 200px; width: 100%;"></div>-->
</body>

</html>

<script type="text/javascript">
    $(document).ready(function(){
        setInterval(function() {
            window.location.reload();
        }, 120000);
    });

    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer",
            {
                animationEnabled: true,
                title: {
                    text: "CUT TABLE REPORT: <?php echo $date;?>"
                },
                dataPointWidth: 50,
                axisX: {
                    valueFormatString: ""
                },
                axisY: {
                    prefix: ""
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
                        name: "LAY",
                        showInLegend: true,
                        color: "#d8cf27",
                        indexLabelFontSize: 16,
                        indexLabelOrientation: "vertical",
                        xValueFormatString: "LAY",
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
                        indexLabelFontSize: 16,
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