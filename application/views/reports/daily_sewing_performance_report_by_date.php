<table class="display table table-bordered table-striped" id="">
    <thead>
    <tr style="background-color: #0A6EA0; color: #FFFFFF;">
        <th colspan="10" class="center"><h2>Line Report</h2></th>
    </tr>
    <tr style="background-color: #f7ffb0;">
        <th class="center">LINE</th>
        <th class="center">TARGET</th>
        <th class="center">OUTPUT</th>
        <th class="center">EXTRA QTY</th>
        <th class="center">TOTAL</th>
        <th class="center">EFFI.</th>
        <th class="center">DHU</th>
        <th class="center">WH</th>
        <th class="center">MP</th>
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
    $avg_work_hour=0;
    $count_lines=0;

    foreach ($line_prod as $v){
        $over_time_qty = $v['eot_output'];
        $total_line_target += $v['target'];
        $total_line_normal_output += $v['normal_output'];
        $total_over_time_qty += $v['eot_output'];
        $total_line_output += $v['output'];
        $total_sum_efficiency += $v['efficiency'];
        $total_work_hour += $v['work_hour'];
        ?>
        <tr>
            <td class="center"><?php echo $v['line_code'];?></td>
            <td class="center"><?php echo $v['target'];?></td>
            <td class="center"><?php echo $v['normal_output'];?></td>
            <td class="center"><?php echo $over_time_qty;?></td>
            <td class="center"><a target="_blank" href="<?php echo base_url()?>dashboard/getDailyPerformanceDetail/<?php echo $v['line_name'];?>/<?php echo $v['line_id'];?>/<?php echo $search_date;?>"><?php echo $v['output'];?></a></td>
            <td class="center"><?php echo $v['efficiency']; ?></td>
            <td class="center"><?php echo $v['dhu']; ?></td>
            <td class="center"><?php echo $v['work_hour']; ?></td>
            <td class="center"><?php echo $v['man_power_1']; ?></td>
            <td class="center"><?php echo $v['remarks']; ?></td>
        </tr>
        <?php
        $count_lines++;
    }

    $avg_work_hour = round(($total_work_hour / $count_lines), 2);
    ?>
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
        <td align="center"></td>
        <td align="center"><h5><b><?php echo $avg_work_hour;?></b></h5></td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    </tfoot>
</table>