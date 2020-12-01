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
            <th colspan="5">10 hours Report: <?php echo $previous_date;?></th>
        </tr>
        </thead>
    </table>
    <br />
    <table width="100%">
        <thead>
        <tr style="background-color: #615000; color: #FFFFFF;">
            <th colspan="4" class="center"><h2>Cutting Ready Package</h2></th>
        </tr>
        <tr style="background-color: #f7ffb0;">
            <th>TARGET</th>
            <th>10Hr OUTPUT</th>
            <!--            <th>Extra OT QTY</th>-->
            <!--            <th>TOTAL</th>-->
        </tr>
        </thead>
        <tbody>
        <tr>
            <th><?php echo $cutting_target[0]['target'];?></th>
            <th><?php echo $cutting_prod[0]['package_ready_qty'];?></th>
            <!--            <th>-->
            <!--                --><?php
            //                $eot_cut_pass = ($cutting_prod[0]['total_cutting_output'] - $cutting_prod[0]['normal_hour_cutting_output']);
            //                echo $eot_cut_pass;
            //                ?>
            <!--            </th>-->
            <!--            <th>--><?php //echo $cutting_prod[0]['total_cutting_output'];?><!--</th>-->
        </tr>
        </tbody>
    </table>

    <?php

    $data_c = array(

        'cut_target' => ($cutting_target[0]['target'] != '' ? $cutting_target[0]['target'] : 0),
//        'normal_output' => ($cutting_prod[0]['normal_hour_cutting_output'] != '' ? $cutting_prod[0]['normal_hour_cutting_output'] : 0),
//        'eot_output' => ($eot_cut_pass != '' ? $eot_cut_pass : 0),
        'cut_output' => ($cutting_prod[0]['cut_complete_qty'] != '' ? $cutting_prod[0]['cut_complete_qty'] : 0),
        'cut_package_ready' => ($cutting_prod[0]['package_ready_qty'] != '' ? $cutting_prod[0]['package_ready_qty'] : 0),
        'date' => $previous_date

    );
    $this->method_call->deleteTblData('tb_daily_cut_summary', $previous_date);

    if($cutting_prod[0]['package_ready_qty'] != 0 && $cutting_prod[0]['package_ready_qty'] != ''){
        $this->method_call->insertTblData('tb_daily_cut_summary', $data_c);
    }

    ?>

    <br />
    <table width="100%">
        <thead>
        <tr style="background-color: #0A6EA0; color: #FFFFFF;">
            <th colspan="9"><h2>Line Report</h2></th>
        </tr>
        <tr style="background-color: #f7ffb0;">
            <th>LINE</th>
            <th>TARGET</th>
            <th>10Hr OUTPUT</th>
            <th>Extra OT QTY</th>
            <th>TOTAL</th>
            <th>EFFICIENCY</th>
            <th>WH</th>
            <th>DHU</th>
            <th>Remarks</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $this->method_call->deleteTblData('tb_daily_line_summary', $previous_date);

        $total_line_target=0;
        $total_line_normal_output=0;
        $total_over_time_qty=0;
        $total_line_output=0;
        $grand_total_output_lines=0;
        $total_sum_efficiency=0;
        $count_lines=0;
        $over_time_qty = 0;

        foreach ($lines as $v){

            $count_lines++;

            $line_target = 0;
            $line_output = 0;
            $line_dhu = 0;

            $line_target_info = $this->method_call->getLineTargetInfos($v['id'], $previous_date);

            $man_power_1 = ($line_target_info[0]['man_power_1'] > 0 ? $line_target_info[0]['man_power_1'] : 0);
            $man_power_2 = ($line_target_info[0]['man_power_2'] > 0 ? $line_target_info[0]['man_power_2'] : 0);
            $man_power_3 = ($line_target_info[0]['man_power_3'] > 0 ? $line_target_info[0]['man_power_3'] : 0);
            $man_power_4 = ($line_target_info[0]['man_power_4'] > 0 ? $line_target_info[0]['man_power_4'] : 0);

            foreach ($hour_ranges as $h){
                $line_pre_info = $this->method_call->getLinePerformanceSummary($v['id'], $previous_date, $h['start_time'], $h['end_time']);

                foreach ($line_pre_info as $lpi){
                    $line_output += $lpi['qty']+$lpi['manual_qty'];
                }

            }

            $line_target = $line_pre_info[0]['target'];

            $produce_minute_1 = ($line_pre_info[0]['produce_minute_1'] > 0 ? $line_pre_info[0]['produce_minute_1'] : 0);
            $produce_minute_2 = ($line_pre_info[0]['produce_minute_2'] > 0 ? $line_pre_info[0]['produce_minute_2'] : 0);
            $produce_minute_3 = ($line_pre_info[0]['produce_minute_3'] > 0 ? $line_pre_info[0]['produce_minute_3'] : 0);
            $produce_minute_4 = ($line_pre_info[0]['produce_minute_4'] > 0 ? $line_pre_info[0]['produce_minute_4'] : 0);

            $work_hour_1 = ($line_pre_info[0]['work_hour_1'] > 0 ? $line_pre_info[0]['work_hour_1'] : 0);
            $work_hour_2 = ($line_pre_info[0]['work_hour_2'] > 0 ? $line_pre_info[0]['work_hour_2'] : 0);
            $work_hour_3 = ($line_pre_info[0]['work_hour_3'] > 0 ? $line_pre_info[0]['work_hour_3'] : 0);
            $work_hour_4 = ($line_pre_info[0]['work_hour_4'] > 0 ? $line_pre_info[0]['work_hour_4'] : 0);

            $work_minute_1 = ($line_pre_info[0]['work_minute_1'] > 0 ? $line_pre_info[0]['work_minute_1'] : 0);
            $work_minute_2 = ($line_pre_info[0]['work_minute_2'] > 0 ? $line_pre_info[0]['work_minute_2'] : 0);
            $work_minute_3 = ($line_pre_info[0]['work_minute_3'] > 0 ? $line_pre_info[0]['work_minute_3'] : 0);
            $work_minute_4 = ($line_pre_info[0]['work_minute_4'] > 0 ? $line_pre_info[0]['work_minute_4'] : 0);
            $avg_of_work_hour=round(((($work_minute_1+$work_minute_2+$work_minute_3+$work_minute_4) / 60) / $man_power_1), 2);

            $line_remarks = $line_pre_info[0]['remarks'];
            $line_efficiency = $line_pre_info[0]['efficiency'];

            $extra_line_qty = $this->method_call->getLinePerformanceSummary($v['id'], $previous_date, $segments[0]['start_time'], $segments[0]['end_time']);
            $over_time_qty = $extra_line_qty[0]['qty'];

            $line_dhu = $this->method_call->getLineDhuSumReport($v['id'], $previous_date);
            $line_dhu = $line_dhu[0]['dhu'];
            $line_manual_qty = $line_dhu[0]['manual_qty'];

//            $average_dhu = round(($line_sum_dhu/$avg_of_work_hour), 2);

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
                <td align="center"><?php echo $line_target;?></td>
                <td align="center"><?php echo $line_output;?></td>
                <td align="center"><?php echo $over_time_qty;?></td>
                <td align="center"><?php echo $total_line_output;?></td>
                <td align="center">
                    <?php

                    echo $line_efficiency;

                    $total_sum_efficiency += $line_efficiency;

                    ?>
                </td>
                <td class="center"><?php echo $avg_of_work_hour;?></td>
                <td class="center"><?php echo $line_dhu;?></td>
                <td class="center"><?php echo $remarks;?></td>
            </tr>
            <?php
            $data_l = array(

                'line_id' => ($v['id'] != '' ? $v['id'] : 0),
                'target' => ($line_target != '' ? $line_target : 0),
                'normal_output' => ($line_output != 0 ? $line_output : 0),
                'eot_output' => ($over_time_qty != '' ? $over_time_qty : 0),
                'manual_qty' => ($line_manual_qty != '' ? $line_manual_qty : 0),
                'output' => ($total_line_output != '' ? $total_line_output : 0),
                'work_hour' => ($avg_of_work_hour != '' ? $avg_of_work_hour : 0),
                'efficiency' => ($line_efficiency != '' ? $line_efficiency : 0),
                'dhu' => ($line_dhu != '' ? $line_dhu : 0),
                'date' => $previous_date,
                'man_power_1' => $man_power_1,
                'produce_minute_1' => $produce_minute_1,
                'work_minute_1' => $work_minute_1,
                'work_hour_1' => $work_hour_1,
                'man_power_2' => $man_power_2,
                'produce_minute_2' => $produce_minute_2,
                'work_minute_2' => $work_minute_2,
                'work_hour_2' => $work_hour_2,
                'man_power_3' => $man_power_3,
                'produce_minute_3' => $produce_minute_3,
                'work_minute_3' => $work_minute_3,
                'work_hour_3' => $work_hour_3,
                'man_power_4' => $man_power_4,
                'produce_minute_4' => $produce_minute_4,
                'work_minute_4' => $work_minute_4,
                'work_hour_4' => $work_hour_4,
                'remarks' => $remarks

            );

            if($line_output != 0 && $line_output != ''){
                $this->method_call->insertTblData('tb_daily_line_summary', $data_l);
            }

        } ?>
        </tbody>
        <tfoot>
        <tr>
            <td align="center"><h3><b>Total</b></h3></td>
            <td align="center"><h3><b><?php echo $total_line_target;?></b></h3></td>
            <td align="center"><h3><b><?php echo $total_line_normal_output;?></b></h3></td>
            <td align="center"><h3><b><?php echo $total_over_time_qty;?></b></h3></td>
            <td align="center"><h3><b><?php echo $grand_total_output_lines;?></b></h3></td>
            <td align="center">
                <h3><b>
                        <?php
                        $total_eff = $total_sum_efficiency / $count_lines;
                        echo $total_line_efficiency = sprintf('%0.2f', $total_eff);
                        ?>
                    </b></h3>
            </td>
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>
        </tr>
        </tfoot>
    </table>
    <br />
    <table width="100%">
        <thead>
        <tr style="background-color: #5d6155; color: #FFFFFF;">
            <th colspan="6" class="center"><h2>Finishing Report</h2></th>
        </tr>
        <tr style="background-color: #f7ffb0;">
            <th align="center">FLOOR</th>
            <th align="center">TARGET</th>
            <th align="center">10Hr OUTPUT</th>
            <th align="center">Extra Output</th>
            <th align="center">Manual Qty</th>
            <th align="center">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $this->method_call->deleteTblData('tb_daily_finish_summary', $previous_date);

        foreach ($finishing_prod as $f){

            ?>
            <tr>
                <td class="center"><?php echo $f['floor_name'];?></td>
                <td class="center"><?php echo $f['target'];?></td>
                <td class="center"><?php echo $f['sum_normal_qty'];?></td>
                <td class="center"><?php echo $f['finishing_extra_hours_output'];?></td>
                <td class="center"><?php echo $f['sum_manual_qty'];?></td>
                <td class="center">
                    <a target="_blank" class="btn btn-warning" href="<?php echo base_url();?>dashboard/getDailyPackingReportDetail/<?php echo $search_date;?>/<?php echo $floor_name;?>/<?php echo $finishing_floor_id;?>">
                        <?php echo $f['total_finishing_output'];?>
                    </a>
                </td>
            </tr>

            <?php
            $data_f = array(

                'floor_id' => ($f['finishing_floor_id'] != '' ? $f['finishing_floor_id'] : 0),
                'target' => ($f['target'] != '' ? $f['target'] : 0),
                'normal_output' => ($f['sum_normal_qty'] != 0 ? $f['sum_normal_qty'] : 0),
                'eot_output' => ($f['finishing_extra_hours_output'] != '' ? $f['finishing_extra_hours_output'] : 0),
                'manual_qty' => ($f['sum_manual_qty'] != '' ? $f['sum_manual_qty'] : 0),
                'output' => ($f['total_finishing_output'] != '' ? $f['total_finishing_output'] : 0),
                'date' => $previous_date

            );

            if($f['total_finishing_output'] != 0 && $f['total_finishing_output'] != ''){
                $this->method_call->insertTblData('tb_daily_finish_summary', $data_f);
            }

        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>