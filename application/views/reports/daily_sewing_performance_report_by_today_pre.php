<table class="display table table-bordered table-striped" id="">
    <thead>
    <tr style="background-color: #0A6EA0; color: #FFFFFF;">
        <th colspan="7" class="center"><h2>Line Report</h2></th>
    </tr>
    <tr style="background-color: #f7ffb0;">
        <th class="center">LINE</th>
        <th class="center">TARGET</th>
        <th class="center">OUTPUT</th>
        <th class="center">EOT QTY</th>
        <th class="center">TOTAL</th>
        <th class="center">EFFICIENCY</th>
        <th class="center">REMARKS</th>
    </tr>
    </thead>
    <tbody>
    <?php

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
        ?>
        <tr>
            <td class="center"><a class="btn btn-primary" target="_blank" href="<?php echo base_url()?>dashboard/getDailyPerformanceDetail/<?php echo $v['line_name'];?>/<?php echo $v['line_id'];?>/<?php echo $search_date;?>"><?php echo $v['line_code'];?></a></td>
            <td class="center"><?php echo $v['target'];?></td>
            <td class="center"><?php echo $v['line_normal_hours_output'];?></td>
            <td class="center"><?php echo $over_time_qty;?></td>
            <td class="center"><?php echo $v['total_line_output'];?></td>
            <td class="center">
                <?php

                $work_time = $this->method_call->getWorkTime($v['line_id'], $search_date);
                $man_power = $this->method_call->getManPower($v['line_id'], $search_date);
                $get_smv_list = $this->method_call->getSmvList($v['line_id'], $search_date);

                $minutes = ($work_time / 60);
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
            <td class="center"><?php echo $v['remarks']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td align="center"><h5><b>Total</b></h5></td>
        <td align="center"><h5><b><?php echo $total_line_target;?></b></h5></td>
        <td align="center"><h5><b><?php echo $total_line_normal_output;?></b></h5></td>
        <td align="center"><h5><b><?php echo $total_over_time_qty;?></b></h5></td>
        <td align="center"><h5><b><?php echo $total_line_output;?></b></h5></td>
        <td align="center">
            <h5>
                <b>
                    <?php
                    $total_eff = $total_sum_efficiency / $count_lines;
                    echo $total_line_efficiency = sprintf('%0.2f', $total_eff);
                    ?>
                </b>
            </h5>
        </td>
        <td class="center"></td>
    </tr>
    </tfoot>
</table>