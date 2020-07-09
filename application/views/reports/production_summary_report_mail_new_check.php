<!DOCTYPE html>
<html>
<style>
    table {
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
    }
</style>
<head>
    <title>PTS Summary Report</title>
</head>
<body style="width: 100%">
<div style="align-content: center;">
    <table width="100%">
        <thead>
        <tr style="background-color: #2fcd25; color: #FFFFFF;">
            <th colspan="5"><h1>PTS Summary Report</h1></th>
        </tr>
        <tr style="background-color: #f7ffb0">
            <th colspan="5">Report: <?php echo $previous_date;?></th>
        </tr>
        </thead>
    </table>
    <br />
    <table width="100%">
        <thead>
        <tr style="background-color: #615000; color: #FFFFFF;">
            <th colspan="3" class="center"><h2>Cutting Ready Package</h2></th>
        </tr>
        <tr style="background-color: #f7ffb0;">
            <th>Target</th>
<!--            <th>Plan Hour OUTPUT</th>-->
<!--            <th>Extra OT QTY</th>-->
            <th>Cut Qty</th>
            <th>Package Ready Qty</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th><?php echo $cutting_prod[0]['cut_target'];?></th>
<!--            <th>--><?php //echo $cutting_prod[0]['normal_output'];?><!--</th>-->
<!--            <th>-->
<!--                --><?php
//                $eot_cut_pass = ($cutting_prod[0]['cut_output'] - $cutting_prod[0]['normal_output']);
//                echo $eot_cut_pass;
//                ?>
<!--            </th>-->
            <th><?php echo $cutting_prod[0]['cut_output'];?></th>
            <th><?php echo $cutting_prod[0]['cut_package_ready'];?></th>
        </tr>
        </tbody>
    </table>

    <?php

    $data_c = array(

        'cut_target' => ($cutting_target[0]['target'] != '' ? $cutting_target[0]['target'] : 0),
        'normal_output' => ($cutting_prod[0]['normal_hour_cutting_output'] != '' ? $cutting_prod[0]['normal_hour_cutting_output'] : 0),
        'eot_output' => ($eot_cut_pass != '' ? $eot_cut_pass : 0),
        'cut_output' => ($cutting_prod[0]['total_cutting_output'] != '' ? $cutting_prod[0]['total_cutting_output'] : 0),
        'date' => $previous_date

    );
//    $this->method_call->deleteTblData('tb_daily_cut_summary', $previous_date);

//    if($cutting_prod[0]['total_cutting_output'] != 0 && $cutting_prod[0]['total_cutting_output'] != ''){
//        $this->method_call->insertTblData('tb_daily_cut_summary', $data_c);
//    }

    ?>

    <br />
    <table width="100%">
        <thead>
        <tr style="background-color: #0A6EA0; color: #FFFFFF;">
            <th colspan="9"><h2>Line Report</h2></th>
        </tr>
        <tr style="background-color: #f7ffb0;">
            <th>Line</th>
            <th>Target</th>
            <th>Plan Hour Output</th>
            <th>Extra Output</th>
            <th>Total</th>
            <th>Efficiency</th>
            <th>DHU(%)</th>
            <th>Work Hour</th>
            <th>Remarks</th>
        </tr>
        </thead>
        <tbody>
        <?php

//        $this->method_call->deleteTblData('tb_daily_line_summary', $previous_date);

        $total_line_target=0;
        $total_line_normal_output=0;
        $total_over_time_qty=0;
        $total_line_output=0;
        $grand_total_output_lines=0;
        $total_sum_efficiency=0;
        $total_wh=0;
        $total_avg_wh=0;
        $total_base_mp=0;
        $count_lines=0;
        $over_time_qty = 0;

        foreach ($line_report as $v){

            $count_lines++;

            $line_target = 0;
            $line_output = 0;

//            foreach ($v['line_id'] as $h){
////                $line_pre_info = $this->method_call->getLinePerformanceSummary($v['id'], $previous_date, $h['start_time'], $h['end_time']);
//
//                foreach ($line_report as $lpi){
//                    $line_output += $lpi['qty'];
//                }
//
//                $line_target = $line_pre_info[0]['target'];
//
//            }

            $line_target = $v['target'];
            $line_output = $v['normal_output'];
            $line_remarks = $v['remarks'];
            $line_efficiency = $v['efficiency'];

//            $extra_line_qty = $this->method_call->getLinePerformanceSummary($v['id'], $previous_date, $segments[0]['start_time'], $segments[0]['end_time']);

            $over_time_qty = $v['eot_output'];
            $dhu = $v['dhu'];
            $work_hour = $v['work_hour'];
            $base_mp = $v['man_power_1'];

            $total_base_mp += $base_mp;
            $total_wh += ($work_hour * $base_mp);

//            echo '<pre>';
//            print_r($extra_line_qty);
//            echo '</pre>';

//            $over_time_qty = $v['total_line_output'] - $v['line_normal_hours_output'];



//            $total_line_normal_output += $v['line_normal_hours_output'];
//            $total_over_time_qty += $over_time_qty;
            $total_line_output += $v['total_line_output'];

            if($line_remarks != ''){
                $remarks = $line_remarks;
            }else{
                $remarks = '';
            }

            $total_line_target += $line_target;
            $total_line_normal_output += $line_output;
            $total_over_time_qty += $over_time_qty;

            $total_line_output = ($line_output + $over_time_qty);

            $grand_total_output_lines += $total_line_output;
            ?>
            <tr>
                <td align="center"><?php echo $v['line_code'];?></td>
                <td align="center"><?php echo $v['target'];?></td>
                <td align="center"><?php echo $v['normal_output'];?></td>
                <td align="center"><?php echo $v['eot_output'];?></td>
                <td align="center"><?php echo $v['output'];?></td>
<!--                <td align="center">--><?php //echo $v['efficiency'];?><!--</td>-->
                <td align="center">
                    <?php

                    echo $line_efficiency;

                    $total_sum_efficiency += $line_efficiency;

                    ?>
                </td>
                <td align="center"><?php echo $dhu;?></td>
                <td align="center"><?php echo $work_hour;?></td>
                <td align="center"><?php echo $remarks;?></td>
            </tr>
            <?php
            $data_l = array(

                'line_id' => ($v['id'] != '' ? $v['id'] : 0),
                'target' => ($line_target != '' ? $line_target : 0),
                'normal_output' => ($line_output != 0 ? $line_output : 0),
                'eot_output' => ($over_time_qty != '' ? $over_time_qty : 0),
                'output' => ($total_line_output != '' ? $total_line_output : 0),
                'efficiency' => ($line_efficiency != '' ? $line_efficiency : 0),
                'date' => $previous_date,
                'remarks' => $remarks

            );

            if($line_output != 0 && $line_output != ''){
//                $this->method_call->insertTblData('tb_daily_line_summary', $data_l);
            }

        }

        $total_avg_wh = round(($total_wh / $total_base_mp), 2);
        ?>
        </tbody>
        <tfoot>
        <tr>
            <td align="center"><h3><b>Total</b></h3></td>
            <td align="center"><h3><b><?php echo $total_line_target;?></b></h3></td>
            <td align="center"><h3><b><?php echo $total_line_normal_output;?></b></h3></td>
            <td align="center"><h3><b><?php echo $total_over_time_qty;?></b></h3></td>
            <td align="center"><h3><b><?php echo $grand_total_output_lines;?></b></h3></td>
            <td align="center"><h3><b><?php echo $total_line_efficiency;?></b></h3></td>
            <td align="center"></td>
            <td align="center"><h3><b><?php echo $total_avg_wh;?></b></h3></td>
            <td align="center"></td>
        </tr>
        </tfoot>
    </table>
    <br />
    <table width="100%">
        <thead>
        <tr style="background-color: #5d6155; color: #FFFFFF;">
            <th colspan="5" class="center"><h2>Finishing Report</h2></th>
        </tr>
        <tr style="background-color: #f7ffb0;">
            <th align="center">Floor</th>
            <th align="center">Target</th>
            <th align="center">Plan Hour Output</th>
            <th align="center">Extra Output</th>
            <th align="center">Total</th>
        </tr>
        </thead>
        <tbody>
        <?php
//        $this->method_call->deleteTblData('tb_daily_finish_summary', $previous_date);

        foreach ($finishing_report as $f){

            $over_time_finish_qty = $f['output'] - $f['normal_output'];

            ?>
            <tr>
                <td align="center"><?php echo $f['floor_id'];?></td>
                <td align="center"><?php echo $f['target'];?></td>
                <td align="center"><?php echo $f['normal_output'];?></td>
                <td align="center"><?php echo $f['eot_output'];?></td>
                <td align="center"><?php echo $f['output'];?></td>
            </tr>
            <?php
            $data_f = array(

                'floor_id' => ($f['finishing_floor_id'] != '' ? $f['finishing_floor_id'] : 0),
                'target' => ($f['target'] != '' ? $f['target'] : 0),
                'normal_output' => ($f['finishing_normal_hours_output'] != 0 ? $f['finishing_normal_hours_output'] : 0),
                'eot_output' => ($over_time_finish_qty != '' ? $over_time_finish_qty : 0),
                'output' => ($f['total_finishing_output'] != '' ? $f['total_finishing_output'] : 0),
                'date' => $previous_date

            );

            if($f['total_finishing_output'] != 0 && $f['total_finishing_output'] != ''){
//                $this->method_call->insertTblData('tb_daily_finish_summary', $data_f);
            }

        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>