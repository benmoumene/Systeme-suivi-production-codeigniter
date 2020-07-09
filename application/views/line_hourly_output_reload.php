<?php

$line_name = '';
$line_id = $line_info[0]['id'];

if($line_info[0]['line_name'] != ''){
    $line_name = $line_info[0]['line_name'];
}

$line_target = (($line_target != '' && $line_target != 0) ? $line_target : 0);
$line_output = (($line_output != '' && $line_output != 0) ? $line_output : 0);

$balance = $line_target-$line_output;

$balance = (($balance != '' && $balance != 0) ? $balance : 0);

$dataPoints = array(
    array("label"=>"Balance", "y"=>$balance),
    array("label"=>"Output", "y"=>$line_output)
);

foreach ($line_report as $k_3 => $v_3){
    $per_hour_target = round(($line_target != '' ? $line_target : 0)/$line_target_hour);

    $time_diff = number_format((strtotime($v_3['end_time']) - strtotime($v_3['start_time'])) / 3600, 2);

    $extra_time = $time_diff - floor($time_diff);

    $per_hour_actual_target = round($per_hour_target + ($per_hour_target * $extra_time));

    $this->method_call->updatePerHourTarget($line_id, $v_3['start_time'], $v_3['end_time'], $per_hour_actual_target);
}

?>

<script type="text/javascript">

    $(document).ready(function(){

        // Chart Data Load

            <!--HOURLY CHART START-->

            var chart_h = new CanvasJS.Chart("chartContainer_1",
                {
                    title:{
                        text: "Hourly",
                        fontSize: 28
                    },

                    axisX:{
                        labelFontSize: 18,
                        labelFontWeight: "bold"
                    },

                    toolTip: {
                        shared: true
                    },

                    data: [
                        {
                            type: "bar",
                            legendText: "TARGET",
                            showInLegend: true,
                            name: "TARGET",
                            indexLabel: "{y}",
                            indexLabelFontSize: 18,
                            color: "#f9ae00",
                            dataPoints: [
                                <?php foreach ($line_report as $k_1 => $v_1){ ?>
                                { label: "<?php echo date('H:i', strtotime($v_1['start_time'])).'-'.date('H:i', strtotime($v_1['end_time']));?>", y: <?php echo $v_1['target_hr'];?> },
                                <?php } ?>
                            ]
                        }
                        ,

                        {
                            type: "bar",
                            legendText: "OUTPUT",
                            showInLegend: true,
                            name: "OUTPUT",
                            indexLabel: "{y}",
                            indexLabelFontSize: 18,
                            dataPoints: [
                                <?php foreach ($line_report as $k_2 => $v_2){
//                                $output = $this->method_call->todayLineOutputHourly($line_id, $v_2['start_time'], $v_2['end_time']);

                                $hourly_qty = ($v_2['qty'] != '' ? $v_2['qty'] : 0);

                                $line_hour_target = (round(($line_target != '' ? $line_target : 0)/$line_target_hour));

                                $color_code = (($v_2['target_hr'] <= $hourly_qty) ? "#28a832" : "#ad1d0a");
                                ?>

                                { label: "<?php echo date('H:i', strtotime($v_2['start_time'])).'-'.date('H:i', strtotime($v_2['end_time']));?>", y: <?php echo $hourly_qty;?>, color: '<?php echo $color_code;?>' },
                                <?php } ?>
                            ]
                        }

                    ]

                });

            chart_h.render();

    });

</script>