<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="refresh" content="180">
    <title><?php echo $title ?></title>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />
    <!--Canvas Chart Asset Start-->
    <script src="<?php echo base_url(); ?>assets/js/canvas_chart/jquery-1.11.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/canvas_chart/canvasjs.min.js"></script>
    <!--Canvas Chart Asset End-->
</head>
<body>
<div id="chartContainer" style="height: 560px; width: 100%;"></div>
<br />
<hr>
<br />
<div id="chartContainer_1" style="height: 560px; width: 100%;"></div>
</body>
</html>

<script type="text/javascript">
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "EcoFab Line Report: <?php echo date('Y-m-d');?>"
            },
            axisX: {
                valueFormatString: ""
            },
            axisY: {
                prefix: "",
                labelFormatter: addSymbols
            },
//            toolTip: {
//                shared: true
//            },
            legend: {
                cursor: "pointer",
                itemclick: toggleDataSeries
            },
            data: [
                {
                    type: "column",
                    click: onClick,
                    name: "Target",
                    showInLegend: true,
                    color: "#d8cf27",
                    indexLabelFontSize: 16,
                    indexLabelOrientation: "vertical",
                    xValueFormatString: "Target",
                    yValueFormatString: "#,##0",
                    dataPoints: [
//                            { x: 01, y: 1000 },
//                            { x: 02, y: 700 },
//                            { x: 03, y: 750 },
//                            { x: 04, y: 600 },
//                            { x: 05, y: 650 },
//                            { x: 06, y: 550 },
//                            { x: 07, y: 500 },
//                            { x: 08, y: 700 },
//                            { x: 09, y: 600 },
//                            { x: 10, y:  550 },
//                            { x: 11, y: 600 },
//                            { x: 12, y: 650 },
//                            { x: 13, y: 650 },
//                            { x: 14, y: 650 },
//                            { x: 15, y: 650 },
//                            { x: 16, y: 650 },
//                            { x: 17, y: 650 },
//                            { x: 18, y: 650 }

                        <?php foreach ($line_report as $k_1 => $v_1){ ?>
                        { label: "<?php echo $v_1['line_code'];?>", y: <?php echo $v_1['target'];?>, indexLabel: "<?php echo $v_1['target'];?>" },
                        <?php } ?>
                    ]
                },
                {
                    type: "column",
                    click: onClick,
                    name: "Actual",
                    showInLegend: true,
                    color: "GREEN",
                    indexLabelFontSize: 16,
                    indexLabelOrientation: "vertical",
                    xValueFormatString: "Actual",
                    yValueFormatString: "##0",
                    dataPoints: [
//                            { x: 01, y: 500 },
//                            { x: 02, y: 400 },
//                            { x: 03, y: 600 },
//                            { x: 04, y: 300 },
//                            { x: 05, y: 100 },
//                            { x: 06, y: 650 },
//                            { x: 07, y: 450 },
//                            { x: 08, y: 400 },
//                            { x: 09, y: 550 },
//                            { x: 10, y:  500 },
//                            { x: 11, y: 546 },
//                            { x: 12, y: 233 },
//                            { x: 13, y: 233 },
//                            { x: 14, y: 233 },
//                            { x: 15, y: 233 },
//                            { x: 16, y: 233 },
//                            { x: 17, y: 233 },
//                            { x: 18, y: 233 }

                        <?php foreach ($line_report as $k_1 => $v_1){ ?>
                        { label: "<?php echo $v_1['line_code'];?>", y: <?php echo $v_1['total_output_qty'];?>, indexLabel: "<?php echo $v_1['total_output_qty'];?>" },
                        <?php } ?>

                    ]
                },
                {
                    type: "line",
                    click: onClick,
                    name: "Efficiency",
                    indexLabelFontColor: "blue",
                    color: "BLUE",
                    indexLabelFontWeight: "bold",
                    indexLabelFontSize: 15,
                    showInLegend: true,
                    indexLabelOrientation: "horizontal",
                    xValueFormatString: "Efficiency",
                    yValueFormatString: "00.00#",
                    dataPoints: [
//                            { x: 01, y: 455, indexLabel: "45.50" },
//                            { x: 02, y: 400, indexLabel: "40" },
//                            { x: 03, y: 414.2, indexLabel: "41.42" },
//                            { x: 04, y: 355.6, indexLabel: "35.56" },
//                            { x: 05, y: 342, indexLabel: "34.20" },
//                            { x: 06, y: 278, indexLabel: "27.80" },
//                            { x: 07, y: 325, indexLabel: "32.50" },
//                            { x: 08, y: 422, indexLabel: "42.20" },
//                            { x: 09, y: 435, indexLabel: "43.50" },
//                            { x: 10, y: 506.1, indexLabel: "50.61" },
//                            { x: 11, y: 304, indexLabel: "30.40" },
//                            { x: 12, y: 387, indexLabel: "38.70" },
//                            { x: 13, y: 387, indexLabel: "38.70" },
//                            { x: 14, y: 387, indexLabel: "38.70" },
//                            { x: 15, y: 387, indexLabel: "38.70" },
//                            { x: 16, y: 387, indexLabel: "38.70" },
//                            { x: 17, y: 387, indexLabel: "38.70" },
//                            { x: 18, y: 387, indexLabel: "38.70" }

                        <?php foreach ($line_report as $k_1 => $v_1){

                        ?>
                        { label: "<?php echo $v_1['line_code'];?>", y: <?php echo ($v_1['efficiency'] * 10);?>, indexLabel: "<?php echo $v_1['efficiency'];?>" },
                        <?php } ?>
                    ]
                },
                {
                    type: "line",
                    click: onClick,
                    name: "DHU",
                    lineDashType: "dash",
                    color: "RED",
                    indexLabelFontColor: "red",
                    indexLabelFontWeight: "bold",
                    indexLabelFontSize: 15,
                    showInLegend: true,
                    indexLabelOrientation: "horizontal",
                    xValueFormatString: "DHU",
                    yValueFormatString: "00.00#",
                    dataPoints: [
                        <?php foreach ($line_report as $k_1 => $v_1){
                        $dhu_sum = ($v_1['sum_dhu'] != '' ? $v_1['sum_dhu'] : 0);
                        $work_hour_1 = ($v_1['work_hour_1'] != '' ? $v_1['work_hour_1'] : 0);
                        $work_hour_2 = ($v_1['work_hour_2'] != '' ? $v_1['work_hour_2'] : 0);
                        $work_hour_3 = ($v_1['work_hour_3'] != '' ? $v_1['work_hour_3'] : 0);
                        $work_hour_4 = ($v_1['work_hour_4'] != '' ? $v_1['work_hour_4'] : 0);

                        $total_wh = $work_hour_1+$work_hour_2+$work_hour_3+$work_hour_4;

                        $hour = $res_hour[0]['hour'];

                        $average_dhu = round($dhu_sum/$hour, 2);
                        ?>
                        { label: "<?php echo $v_1['line_code'];?>", y: <?php echo $average_dhu * 10 ;?>, indexLabel: "<?php echo $average_dhu;?>" },
                        <?php } ?>
                    ]
                }
                ]
        });
        chart.render();

        function onClick(e) {
            var line_code = e.dataPoint.label;

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getHourlyReportByLineCode/",
                type: "POST",
                data: {line_code: line_code},
                dataType: "json",
                success: function (data) {

                    var dataPoints_1 = [];
                    var dataPoints_2 = [];
                    var dataPoints_3 = [];

                    var count_data = data.length;

                    if(count_data > 0){

                        for (var i = 0; i < data.length; i++) {
                            dataPoints_1.push({
                                label: data[i].start_time+' - '+data[i].end_time,
                                y: data[i].per_hour_target * 1,
                                indexLabel: data[i].per_hour_target,
                            });
                        }

                        for (var j = 0; j < data.length; j++) {

                            var achieve_percentage = Math.round(((data[j].qty * 1) / (data[j].per_hour_target * 1)) * 100);

                            if(achieve_percentage >= 90){
                                var color = "GREEN";
                            }else{
                                var color = "RED";
                            }

                            dataPoints_2.push({
                                label: data[j].start_time+' - '+data[j].end_time,
                                y: data[j].qty * 1,
                                indexLabel: data[j].qty,
                                color: color,
                            });
                        }

                        for (var k = 0; k < data.length; k++) {

                            dataPoints_3.push({
                                label: data[k].start_time+' - '+data[k].end_time,
                                y: data[k].dhu * 1,
                                indexLabel: data[k].dhu,
                            });
                        }

                        var chart_1 = new CanvasJS.Chart("chartContainer_1", {
                            animationEnabled: true,
                            theme: "light2",
                            title: {
                                text: "Hourly Report of Line: "+line_code,
                                fontSize: 40,
                            },
                            axisX: {
                                valueFormatString: ""
                            },
                            axisY: {
                                prefix: "",
                                labelFormatter: addSymbols
                            },
                            toolTip: {
                                shared: true
                            },
                            legend: {
                                cursor: "pointer",
                                itemclick: toggleDataSeries
                            },
                            data: [
                                {
                                    type: "column",
                                    name: "Target",
                                    showInLegend: true,
                                    color: "#62a4d8",
                                    indexLabelFontSize: 16,
                                    indexLabelOrientation: "vertical",
                                    xValueFormatString: "Target",
                                    yValueFormatString: "#,##0",
                                    dataPoints: dataPoints_1

                                },
                                {
                                    type: "column",
                                    name: "Actual",
                                    showInLegend: true,
                                    color: "GREEN",
                                    indexLabelFontSize: 16,
                                    indexLabelOrientation: "vertical",
                                    xValueFormatString: "Actual",
                                    yValueFormatString: "##0",
                                    dataPoints: dataPoints_2

                                },
                                {
                                    type: "line",
                                    click: onClick,
                                    name: "DHU",
                                    lineDashType: "dash",
                                    color: "#64020a",
                                    indexLabelFontColor: "#64020a",
                                    indexLabelFontWeight: "bold",
                                    indexLabelFontSize: 15,
                                    showInLegend: true,
                                    indexLabelOrientation: "horizontal",
                                    xValueFormatString: "DHU",
                                    yValueFormatString: "00.00#",
                                    dataPoints: dataPoints_3
                                }]
                        });
                        chart_1.render();


                        function addSymbols(e) {
                            var suffixes = ["", "K", "M", "B"];
                            var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);

                            if(order > suffixes.length - 1)
                                order = suffixes.length - 1;

                            var suffix = suffixes[order];
                            return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
                        }

                        function toggleDataSeries(e) {
                            alert(e);
                            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } else {
                                e.dataSeries.visible = true;
                            }
                            e.chart.render();
                        }

                    }else{
                        $("#chartContainer_1").append("No Data Found!");
                    }

                }
            });
        }

        function addSymbols(e) {
            var suffixes = ["", "K", "M", "B"];
            var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);

            if(order > suffixes.length - 1)
                order = suffixes.length - 1;

            var suffix = suffixes[order];
            return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
        }

        function toggleDataSeries(e) {
            alert(e);
            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            e.chart.render();
        }

    }
</script>