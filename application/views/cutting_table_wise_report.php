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
<body>
<div>
    <table border="1" width="100%">
        <thead>
        <tr style="background-color: rgba(159,255,154,0.41)">
            <th align="center"><span style="font-size: 25px;">LAY QTY</span></th>
            <th align="center"><span style="font-size: 25px;">TODAY CUT</span></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th align="center">
                <span style="font-size: 22px;">
                    <?php
                        $balance_to_cut_qty = 0;
                        foreach ($table_report AS $v){
                            $balance_to_cut_qty += $v['balance_to_cut_qty'];
                        }
                        echo $balance_to_cut_qty;
                    ?>
                </span>
            </th>
            <th align="center">
                <span style="font-size: 22px;">
                    <?php
                    $cut_complete_qty = 0;
                    foreach ($table_report AS $v){
                        $cut_complete_qty += $v['cut_complete_qty'];
                    }
                    echo $cut_complete_qty;
                    ?>
                </span>
            </th>
        </tr>
        </tbody>
    </table>
</div>
<br />
<div id="chartContainer" style="height: 560px; width: 100%;"></div>
</body>
</html>

<script type="text/javascript">
    window.onload = function () {

        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "CUT TABLE REPORT: <?php echo $date;?>",
                fontSize: 30
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

        function addSymbols(e) {
            var suffixes = ["", "K", "M", "B"];
            var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);

            if(order > suffixes.length - 1)
                order = suffixes.length - 1;

            var suffix = suffixes[order];
            return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
        }

        function toggleDataSeries(e) {
            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            } else {
                e.dataSeries.visible = true;
            }
            e.chart.render();
        }

    }
</script>