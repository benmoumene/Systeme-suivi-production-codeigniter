<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="180">
    <script src="<?php echo base_url();?>assets/js/highchart/highcharts.js"></script>
    <script src="<?php echo base_url();?>assets/js/highchart/exporting.js"></script>
    <script src="<?php echo base_url();?>assets/js/highchart/export-data.js"></script>
</head>
<body>

<div id="container" style="min-width: 310px; height: 550px; margin: 0 auto;"></div>

</body>
</html>

<script type="text/javascript">
    Highcharts.chart('container', {

        chart: {
            type: 'column',
            backgroundColor: '#e6ffff',
            style: {
                fontSize: '20px'
            }
        },

        title: {
            text: 'LINE REPORT',
            style: {
                fontSize: '40px'
            }
        },

        xAxis: {
            categories: [
                <?php

                foreach ($line_report as $v) {
                    $table = $v['cut_table'];
                    $count_total_pc = $v['count_total_pc'];

                    $line_id = $v['line_id'];
                    $line_name = $v['line_name'];
                    $floor_name = $v['floor_name'];

                    echo "'$line_name', ";

                }
                ?>
//                'Line-1', 'Line-2', 'Line-3', 'Line-4', 'Line-5'

            ],
            labels: {
                style: {
                    fontSize: '18px'
                }
            }
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Quantity'
            }
        },

        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>'
//                    + 'Total: ' + this.point.stackTotal;
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: "15px",
                        fontStyle: 'normal',
                        textOutline: 0,
                        color: "#000000"
                    },
                    rotation: 270,
                    align: 'left'
                }
            }
        },

        series: [{
            name: 'Balance',
            color: "#f3b30e",
            data: [

                <?php

                foreach ($line_report as $v)
                {
                    $table=$v['cut_table'];
                    $count_total_pc=$v['count_total_pc'];

                    $line_id = $v['line_id'];
                    $line_name = $v['line_name'];
                    $floor_name = $v['floor_name'];

                    if($v['target'] != ''){
                        $count_target = $v['target'];
                    }else{
                        $count_target = 0;
                    }

                    if($v['count_wip_qty_line'] != ''){
                        $count_qty_line = $v['count_wip_qty_line'];
                    }else{
                        $count_qty_line = 0;
                    }

                    if($v['count_mid_pass_qty'] != ''){
                        $count_mid_pass_qty = $v['count_mid_pass_qty'];
                    }else{
                        $count_mid_pass_qty = 0;
                    }

                    if($v['count_end_line_qc_pass'] != ''){
                        $count_end_line_qc_pass = $v['count_end_line_qc_pass'];
                    }else{
                        $count_end_line_qc_pass = 0;
                    }

                    $line_input_date = $v['line_input_date'];
                    $t_balance = $count_target - $count_end_line_qc_pass;

                    if($t_balance != ''){
                        $target_balance = $t_balance;
                    }else{
                        $target_balance = 0;
                    }

                    echo "$target_balance, ";
                }
                ?>

//                500, 100, 300, 300, 450

            ],
            stack: 'male'
        }
        , {
            name: 'Output',
            color: '#31AF08',
            data: [

                <?php

                foreach ($line_report as $v)
                {
                    $table=$v['cut_table'];
                    $count_total_pc=$v['count_total_pc'];

                    $line_id = $v['line_id'];
                    $line_name = $v['line_name'];
                    $floor_name = $v['floor_name'];

                    if($v['count_input_qty_line'] != ''){
                        $count_input_qty_line = $v['count_input_qty_line'];
                    }else{
                        $count_input_qty_line = 0;
                    }

                    if($v['count_wip_qty_line'] != ''){
                        $count_qty_line = $v['count_wip_qty_line'];
                    }else{
                        $count_qty_line = 0;
                    }

                    if($v['count_mid_pass_qty'] != ''){
                        $count_mid_pass_qty = $v['count_mid_pass_qty'];
                    }else{
                        $count_mid_pass_qty = 0;
                    }

                    if($v['count_end_line_qc_pass'] != ''){
                        $count_end_line_qc_pass = $v['count_end_line_qc_pass'];
                    }else{
                        $count_end_line_qc_pass = 0;
                    }

                    $line_input_date = $v['line_input_date'];

                    echo "$count_end_line_qc_pass , ";
                }
                ?>

//                500, 450, 300, 350, 250
            ],
            stack: 'male'
        }
        ,{
            name: 'WIP',
            color: '#FE4640',
            data: [

                <?php

                foreach ($line_report as $v)
                {
                    $table=$v['cut_table'];
                    $count_total_pc=$v['count_total_pc'];

                    $line_id = $v['line_id'];
                    $line_name = $v['line_name'];
                    $floor_name = $v['floor_name'];

                    if($v['count_input_qty_line'] != ''){
                        $count_input_qty_line = $v['count_input_qty_line'];
                    }else{
                        $count_input_qty_line = 0;
                    }

                    if($v['count_wip_qty_line'] != ''){
                        $count_qty_line = $v['count_wip_qty_line'];
                    }else{
                        $count_qty_line = 0;
                    }

                    if($v['count_mid_pass_qty'] != ''){
                        $count_mid_pass_qty = $v['count_mid_pass_qty'];
                    }else{
                        $count_mid_pass_qty = 0;
                    }

                    if($v['count_end_line_qc_pass'] != ''){
                        $count_end_line_qc_pass = $v['count_end_line_qc_pass'];
                    }else{
                        $count_end_line_qc_pass = 0;
                    }

                    $line_input_date = $v['line_input_date'];

                    echo "$count_qty_line, ";
                }
                ?>

//                1500, 1200, 800, 700, 900
            ],
            stack: 'female'
        }
            ,{
                name: 'Today Input',
                color: '#0099ff',
                data: [

                    <?php

                    foreach ($line_report as $v)
                    {
                        $table=$v['cut_table'];
                        $count_total_pc=$v['count_total_pc'];

                        $line_id = $v['line_id'];
                        $line_name = $v['line_name'];
                        $floor_name = $v['floor_name'];

                        if($v['count_input_qty_line'] != ''){
                            $count_input_qty_line = $v['count_input_qty_line'];
                        }else{
                            $count_input_qty_line = 0;
                        }

                        if($v['count_wip_qty_line'] != ''){
                            $count_qty_line = $v['count_wip_qty_line'];
                        }else{
                            $count_qty_line = 0;
                        }

                        if($v['count_mid_pass_qty'] != ''){
                            $count_mid_pass_qty = $v['count_mid_pass_qty'];
                        }else{
                            $count_mid_pass_qty = 0;
                        }

                        if($v['count_end_line_qc_pass'] != ''){
                            $count_end_line_qc_pass = $v['count_end_line_qc_pass'];
                        }else{
                            $count_end_line_qc_pass = 0;
                        }

                        $line_input_date = $v['line_input_date'];

                        echo "$count_input_qty_line, ";
                    }
                    ?>

//                1500, 1200, 800, 700, 900
                ],
                stack: 'female'
            }
       ]
    });

</script>