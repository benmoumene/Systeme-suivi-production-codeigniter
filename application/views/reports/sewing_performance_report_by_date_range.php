<table class="display table table-bordered table-striped" id="">
    <thead>
    <tr style="background-color: #0A6EA0; color: #FFFFFF;">
        <th colspan="14" class="center"><h2>Line Report</h2></th>
    </tr>
    <tr style="background-color: #f7ffb0;">
        <th class="center">DATE</th>
        <th class="center">LINE</th>
        <th class="center">TARGET</th>
        <th class="center">OUTPUT</th>
        <th class="center">EXTRA QTY</th>
        <th class="center">TOTAL</th>
        <th class="center">SMV</th>
        <th class="center">WORK MIN</th>
        <th class="center">PROD MIN</th>
        <th class="center">EFFI.</th>
        <th class="center">DHU</th>
        <th class="center">WH</th>
        <th class="center">MP</th>
        <th class="center">REMARKS</th>
    </tr>
    </thead>
    <tbody>
    <?php

    $total_line_output=0;

    $total_produce_min=0;
    $total_work_min=0;
    $smv=0;

    foreach ($line_prod as $v){

        $over_time_qty = $v['eot_output'];
        $total_line_target += $v['target'];
        $total_line_normal_output += $v['normal_output'];
        $total_over_time_qty += $v['eot_output'];
        $total_line_output += $v['output'];
        $total_sum_efficiency += $v['efficiency'];
        $total_work_hour += $v['work_hour'];

        $total_produce_min = $v['produce_minute_1']+$v['produce_minute_2']+$v['produce_minute_3']+$v['produce_minute_4'];
        $total_work_min = $v['work_minute_1']+$v['work_minute_2']+$v['work_minute_3']+$v['work_minute_4'];

        $smv = round($total_produce_min / $v['output'], 2);

        ?>
        <tr>
            <td class="center"><?php echo $v['date'];?></td>
            <td class="center"><?php echo $v['line_code'];?></td>
            <td class="center"><?php echo $v['target'];?></td>
            <td class="center"><?php echo $v['normal_output'];?></td>
            <td class="center"><?php echo $over_time_qty;?></td>
            <td class="center"><?php echo $v['output'];?></td>
            <td class="center"><?php echo $smv;?></td>
            <td class="center"><?php echo $total_work_min;?></td>
            <td class="center"><?php echo $total_produce_min;?></td>
            <td class="center"><?php echo $v['efficiency']; ?></td>
            <td class="center"><?php echo $v['dhu']; ?></td>
            <td class="center"><?php echo $v['work_hour']; ?></td>
            <td class="center"><?php echo $v['man_power_1']; ?></td>
            <td class="center"><?php echo $v['remarks']; ?></td>
        </tr>
        <?php
        $count_lines++;
    }

    ?>
    </tbody>
    <tfoot>
        <tr>
            <th class="center" colspan="5"><h5>TOTAL</h5></th>
            <th class="center">
                <h5><?php echo $total_line_output;?></h5>
            </th>
            <th class="center" colspan="8"></th>
        </tr>
    </tfoot>
</table>