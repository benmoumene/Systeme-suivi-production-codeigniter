<?php

$floor_name = '';
if($finishing_report[0]['floor_name'] != ''){
    $floor_name = $finishing_report[0]['floor_name'];
}

$finishing_target = (($finishing_target != '') ? $finishing_target : 0);
$finishing_output_qty = (($finishing_output_qty != '') ? $finishing_output_qty : 0);

$balance = $finishing_target-$finishing_output_qty;

$balance = (($balance != '' && $balance != 0) ? $balance : 0);

$dataPoints = array(
    array("label"=>"Balance", "y"=>$balance),
    array("label"=>"Output", "y"=>$finishing_output_qty)
);

?>

<script type="text/javascript">

    // Chart Data Load
    $(document).ready(function(){

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

    });

</script>