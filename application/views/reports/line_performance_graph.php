<?php

if($line_target != 0 && $line_output != 0 && $line_target != '' && $line_output != ''){
    $balance = $line_target-$line_output;

    $dataPoints = array(
        array("label"=>"Balance", "y"=>$balance),
        array("label"=>"Output", "y"=>$line_output)
    );
}

?>


<!DOCTYPE HTML>
<html>
<head></head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>

</body>
</html>

<!--Canvas Chart Asset Start-->
<script src="<?php echo base_url(); ?>assets/js/canvas_chart/canvasjs.min.js"></script>
<!--Canvas Chart Asset End-->

<script type="text/javascript">
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