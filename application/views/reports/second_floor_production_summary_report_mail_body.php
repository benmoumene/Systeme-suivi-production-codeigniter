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
<!--            <th>Plan Hour Output</th>-->
<!--            <th>Extra Output</th>-->
            <th>Cut Qty</th>
            <th>Package Ready QTY</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th><?php echo $cutting_prod[0]['cut_target'];?></th>
<!--            <th>--><?php //echo $cutting_report[0]['normal_output'];?><!--</th>-->
<!--            <th>--><?php //echo $cutting_report[0]['eot_output'];?><!--</th>-->
            <th><?php echo $cutting_prod[0]['cut_output'];?></th>
            <th><?php echo $cutting_prod[0]['cut_package_ready'];?></th>
        </tr>
        </tbody>
    </table>
    <br />
    <table width="100%">
        <thead>
            <tr style="background-color: #0A6EA0; color: #FFFFFF;">
                <th colspan="7"><h2>Line Report</h2></th>
            </tr>
            <tr style="background-color: #f7ffb0;">
                <th>Line</th>
                <th>Target</th>
                <th>Plan Hour Output</th>
                <th>Extra Output</th>
                <th>Total</th>
                <th>Efficiency</th>
                <th>DHU(%)</th>
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
                <td align="center"><?php echo $v['line_code'];?></td>
                <td align="center"><?php echo $v['target'];?></td>
                <td align="center"><?php echo $v['normal_output'];?></td>
                <td align="center"><?php echo $v['eot_output'];?></td>
                <td align="center"><?php echo $v['output'];?></td>
                <td align="center"><?php echo $v['efficiency'];?></td>
                <td align="center"><?php echo $v['dhu'];?></td>
            </tr>
        <?php } ?>
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
                            $total_eff = $total_sum_efficiency/8;
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
            <th colspan="3" class="center"><h2>Finishing Report</h2></th>
        </tr>
        <tr style="background-color: #f7ffb0;">
            <th align="center">Floor</th>
            <th align="center">Target</th>
<!--            <th align="center">Plan Hour Output</th>-->
<!--            <th align="center">Extra Output</th>-->
            <th align="center">Output</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($finishing_prod as $f){

            $over_time_finish_qty = $f['total_finishing_output'] - $f['finishing_normal_hours_output'];

            ?>
            <tr>
                <td align="center">
                    <?php if($f['floor_id'] == 2){
                        echo '2nd Floor';
                    }
                    ?>
                </td>
                <td align="center"><?php echo $f['target'];?></td>
<!--                <td align="center">--><?php //echo $f['normal_output'];?><!--</td>-->
<!--                <td align="center">--><?php //echo $f['eot_output'];?><!--</td>-->
                <td align="center"><?php echo $f['output'];?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>