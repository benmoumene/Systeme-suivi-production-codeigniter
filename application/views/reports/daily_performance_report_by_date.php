<table class="display table table-bordered table-striped" id="">
    <thead>
        <tr style="background-color: #615000; color: #FFFFFF;">
            <th colspan="4" class="center"><h2>Cutting Report</h2></th>
        </tr>
        <tr style="background-color: #f7ffb0;">
            <th class="center">TARGET</th>
            <th class="center">OUTPUT</th>
            <th class="center">EOT QTY</th>
            <th class="center">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        <tr style="background-color: #f7ffb0;">
            <th class="center"><?php echo $cutting_prod[0]['cut_target'];?></th>
            <th class="center"><?php echo $cutting_prod[0]['normal_output'];?></th>
            <th class="center"><?php echo $cutting_prod[0]['eot_output'];?></th>
            <th class="center"><a target="_blank" class="btn btn-warning" href="<?php echo base_url();?>dashboard/getDailyCuttingReportDetail/<?php echo $search_date;?>"><?php echo $cutting_prod[0]['cut_output'];?></a></th>
        </tr>
    </tbody>
</table>

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
        $over_time_qty = $v['eot_output'];

        $total_line_target += $v['target'];
        $total_line_normal_output += $v['normal_output'];
        $total_over_time_qty += $v['eot_output'];
        $total_line_output += $v['output'];
        $total_sum_efficiency += $v['efficiency'];
        ?>
        <tr>
            <td class="center"><a class="btn btn-primary" target="_blank" href="<?php echo base_url()?>dashboard/getDailyPerformanceDetail/<?php echo $v['line_name'];?>/<?php echo $v['line_id'];?>/<?php echo $search_date;?>"><?php echo $v['line_code'];?></a></td>
            <td class="center"><?php echo $v['target'];?></td>
            <td class="center"><?php echo $v['normal_output'];?></td>
            <td class="center"><?php echo $over_time_qty;?></td>
            <td class="center"><?php echo $v['output'];?></td>
            <td class="center"><?php echo $v['efficiency']; ?></td>
            <td class="center"><?php echo $v['remarks']; ?></td>
        </tr>
    <?php
        $count_lines++;
    }
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
    </tr>
    </tfoot>
</table>

<table class="display table table-bordered table-striped" id="">
    <thead>
    <tr style="background-color: #5d6155; color: #FFFFFF;">
        <th colspan="5" class="center"><h2>Finishing Report</h2></th>
    </tr>
    <tr style="background-color: #f7ffb0;">
        <th class="center">FLOOR</th>
        <th class="center">TARGET</th>
        <th class="center">OUTPUT</th>
        <th class="center">EOT QTY</th>
        <th class="center">TOTAL</th>
    </tr>
    </thead>
    <tbody>
        <?php

        foreach ($finishing_prod as $f){

        $over_time_finish_qty = $f['eot_output'];

        ?>
    <tr>
        <td class="center"><?php echo $f['floor_name'];?></td>
        <td class="center"><?php echo $f['target'];?></td>
        <td class="center"><?php echo $f['normal_output'];?></td>
        <td class="center"><?php echo $over_time_finish_qty;?></td>
        <td class="center"><?php echo $f['output'];?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>