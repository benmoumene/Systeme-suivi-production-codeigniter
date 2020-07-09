<?php

$line_name = '';
$line_id = $line_info[0]['id'];

if($line_info[0]['line_name'] != ''){
    $line_name = $line_info[0]['line_name'];
}

$line_target = (($line_target != '' && $line_target != 0) ? $line_target : 0);
$line_output = (($line_output != '' && $line_output != 0) ? $line_output : 0);

$achievement_rate = round(($line_output / $line_target) * 100, 2);

$balance = $line_target-$line_output;

$balance = (($balance != '' && $balance != 0) ? $balance : 0);

$dataPoints = array(
    array("label"=>"Balance", "y"=>$balance),
    array("label"=>"Output", "y"=>$line_output)
)

?>

<script type="text/javascript">

// Chart Data Load
$(document).ready(function(){

        CanvasJS.addColorSet("colorShades",
            [//colorSet Array

                "#ad1d0a",
                "#28a832"
            ]);

        var chart = new CanvasJS.Chart("chartContainer", {
            colorSet: "colorShades",
            theme: "theme2",
            animationEnabled: true,
            title: {
//                text: "Target: <?php //echo ($line_target != '' ? $line_target : 0);?>// | Output: <?php //echo ($line_output != '' ? $line_output : 0);?>// | Balance: <?php //echo ($balance != '' && $balance > 0 ? $balance : 0);?>//"
                text: "Target:<?php echo ($line_target != '' ? $line_target : 0);?> | BLNC:<?php echo ($balance != '' && $balance > 0 ? $balance : 0);?> | Rate:<?php echo ($achievement_rate != '' && $achievement_rate > 0 ? $achievement_rate : 0).'%';?>",
                fontSize: 28
            },
            data: [{
                type: "pie",
                indexLabel: "{y}",
//                yValueFormatString: "#,##0.00\"%\"",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#FFFFFF",
                indexLabelFontSize: 38,
                indexLabelFontWeight: "bolder",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

});

</script>