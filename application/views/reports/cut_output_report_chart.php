<?php

$total_cut_qty = $cut_output_report[0]['total_cut_qty'];
$total_pack_qty = $cut_output_report[0]['total_pack_qty'];

$dataPoints = array(
    array("label"=>"CUT", "y"=>$total_cut_qty),
    array("label"=>"PACK", "y"=>$total_pack_qty)
);

?>

<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div id="chart_div" style="width: 1380px; height: 500px;"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Chart Data Load

    window.onload = function() {
        CanvasJS.addColorSet("colorShades",
            [//colorSet Array

                "#ad1d0a",
                "#28a832"
            ]);

        var chart = new CanvasJS.Chart("chart_div", {
            colorSet: "colorShades",
            theme: "theme2",
            animationEnabled: true,
            title: {
//                text: "Target: <?php //echo ($line_target != '' ? $line_target : 0);?>// | Output: <?php //echo ($line_output != '' ? $line_output : 0);?>// | Balance: <?php //echo ($balance != '' && $balance > 0 ? $balance : 0);?>//"
                text: "CUT-PACKED Report of <?php echo $year_month;?>",
                fontSize: 25
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