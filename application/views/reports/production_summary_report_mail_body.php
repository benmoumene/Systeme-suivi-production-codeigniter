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
                <th>Extra OT QTY</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th><?php echo $cutting_target[0]['target'];?></th>
                <th><?php echo $cutting_prod[0]['normal_hour_cutting_output'];?></th>
                <th>
                    <?php
                    $eot_cut_pass = ($cutting_prod[0]['total_cutting_output'] - $cutting_prod[0]['normal_hour_cutting_output']);
                    echo $eot_cut_pass;
                    ?>
                </th>
                <th><?php echo $cutting_prod[0]['total_cutting_output'];?></th>
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
    $this->method_call->deleteTblData('tb_daily_cut_summary', $previous_date);

    if($cutting_prod[0]['total_cutting_output'] != 0 && $cutting_prod[0]['total_cutting_output'] != ''){
        $this->method_call->insertTblData('tb_daily_cut_summary', $data_c);
    }

    ?>

    <br />
    <table width="100%">
        <thead>
            <tr style="background-color: #0A6EA0; color: #FFFFFF;">
                <th colspan="7"><h2>Line Report</h2></th>
            </tr>
            <tr style="background-color: #f7ffb0;">
                <th>LINE</th>
                <th>TARGET</th>
                <th>10Hr OUTPUT</th>
                <th>Extra OT QTY</th>
                <th>TOTAL</th>
                <th>EFFICIENCY</th>
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
        $total_sum_efficiency=0;
        $count_lines=0;

        foreach ($line_prod as $v){
            $over_time_qty = $v['total_line_output'] - $v['line_normal_hours_output'];

            $total_line_target += $v['target'];
            $total_line_normal_output += $v['line_normal_hours_output'];
            $total_over_time_qty += $over_time_qty;
            $total_line_output += $v['total_line_output'];

            if($v['remarks'] != ''){
                $remarks = $v['remarks'];
            }else{
                $remarks = '';
            }

            ?>
            <tr>
                <td align="center"><?php echo $v['line_code'];?></td>
                <td align="center"><?php echo $v['target'];?></td>
                <td align="center"><?php echo $v['line_normal_hours_output'];?></td>
                <td align="center"><?php echo $over_time_qty;?></td>
                <td align="center"><?php echo $v['total_line_output'];?></td>
                <td align="center">
                    <?php

                    $work_time = $this->method_call->getWorkTime($v['line_id'], $previous_date);
                    $man_power = $this->method_call->getManPower($v['line_id'], $previous_date);
                    $get_smv_list = $this->method_call->getSmvList($v['line_id'], $previous_date);

                    $sec_to_minutes = ($work_time / 60);

                    if ($cur_time > "14:00:00"){
                        $minutes = ($sec_to_minutes - 60);
                    }else{
                        $minutes = $sec_to_minutes;
                    }

                    $work_minute = $minutes * $man_power;

                    //                echo '<pre>';
                    //                print_r($minutes.' '.$man_power);
                    //                echo '</pre>';
                    //
                    //                echo '<pre>';
                    //                print_r('Work Min: '.$work_minute);
                    //                echo '</pre>';

                    $produce_minute = 0;
                    $average_produce_min = 0;
                    foreach ($get_smv_list as $s){
                        $smv = $s['smv'];
                        $s_total_line_output = $s['total_line_output'];

                        $produce_minute += ($s_total_line_output * $smv);

//                                            echo '<pre>';
//                                            print_r($smv.' '.$s_total_line_output);
//                                            echo '</pre>';
                    }

//                                    echo '<pre>';
//                                    print_r('Prod Min: '.$produce_minute);
//                                    echo '</pre>';

                    $eff = ($produce_minute/$work_minute) * 100;

                    echo $line_efficiency = sprintf('%0.2f', $eff);

                    $total_sum_efficiency += $line_efficiency;

                    if($v['total_line_output'] > 0){
                        $count_lines++;
                    }

                    ?>
                </td>
                <td class="center"><?php echo $v['remarks'];?></td>
            </tr>
        <?php
            $data_l = array(

                'line_id' => ($v['line_id'] != '' ? $v['line_id'] : 0),
                'target' => ($v['target'] != '' ? $v['target'] : 0),
                'normal_output' => ($v['line_normal_hours_output'] != 0 ? $v['line_normal_hours_output'] : 0),
                'eot_output' => ($over_time_qty != '' ? $over_time_qty : 0),
                'output' => ($v['total_line_output'] != '' ? $v['total_line_output'] : 0),
                'efficiency' => ($line_efficiency != '' ? $line_efficiency : 0),
                'date' => $previous_date,
                'remarks' => $remarks

            );

            if($v['total_line_output'] != 0 && $v['total_line_output'] != ''){
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
                <td align="center"><h3><b><?php echo $total_line_output;?></b></h3></td>
                <td align="center">
                    <h3><b>
                            <?php
                            $total_eff = $total_sum_efficiency / $count_lines;
                            echo $total_line_efficiency = sprintf('%0.2f', $total_eff);
                            ?>
                    </b></h3>
                </td>
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
            <th align="center">FLOOR</th>
            <th align="center">TARGET</th>
            <th align="center">10Hr OUTPUT</th>
            <th align="center">Extra OT QTY</th>
            <th align="center">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $this->method_call->deleteTblData('tb_daily_finish_summary', $previous_date);

        foreach ($finishing_prod as $f){

            $over_time_finish_qty = $f['total_finishing_output'] - $f['finishing_normal_hours_output'];

            ?>
            <tr>
                <td align="center"><?php echo $f['floor_name'];?></td>
                <td align="center"><?php echo $f['target'];?></td>
                <td align="center"><?php echo $f['finishing_normal_hours_output'];?></td>
                <td align="center"><?php echo $over_time_finish_qty;?></td>
                <td align="center"><?php echo $f['total_finishing_output'];?></td>
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
                $this->method_call->insertTblData('tb_daily_finish_summary', $data_f);
            }

        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>