<table class="display table table-bordered table-striped" id="" border="1">
    <thead>
    <tr>
        <th class="hidden-phone center" colspan="14"><h3>Date: <?php echo $date;?></h3></th>
    </tr>
    <tr>
        <th class="hidden-phone center">Brand</th>
        <th class="hidden-phone center">Purchase Order</th>
        <th class="hidden-phone center">Item</th>
        <th class="hidden-phone center">Style</th>
        <th class="hidden-phone center">Quality</th>
        <th class="hidden-phone center">Color</th>
        <th class="hidden-phone center">Ex-Fac Date</th>
        <th class="hidden-phone center">Order</th>
        <th class="hidden-phone center">Cut</th>
        <th class="hidden-phone center">Line Pass</th>
        <th class="hidden-phone center">Wash Going</th>
        <th class="hidden-phone center">Total Wash Return</th>
        <th class="hidden-phone center"><h4><?php echo $date;?></h4> Wash Return</th>
        <th class="hidden-phone center">Balance</th>
    </tr>
    </thead>

    <tbody>
    <?php

    $wash_return_balance = 0;
    $total_wash_return = 0;
    $total_wash_return_balance = 0;

    foreach ($wash_return_report as $v){
        $wash_return_balance = $v['total_count_wash_going_qty'] - $v['total_count_wash_return_qty'];
        $total_wash_return += $v['count_wash_return_qty'];
        $total_wash_return_balance += $wash_return_balance;
    ?>
    <tr>
        <td class="center"><?php echo $v['brand'];?></td>
        <td class="center"><?php echo $v['purchase_order'];?></td>
        <td class="center"><?php echo $v['item'];?></td>
        <td class="center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
        <td class="center"><?php echo $v['quality'];?></td>
        <td class="center"><?php echo $v['color'];?></td>
        <td class="center"><?php echo $v['ex_factory_date']; ?></td>
        <td class="center"><?php echo $v['total_order_qty'];?></td>
        <td class="center"><?php echo $v['total_cut_qty'];?></td>
        <td class="center"><?php echo $v['total_line_output_qty'];?></td>
        <td class="center"><?php echo $v['total_count_wash_going_qty'];?></td>
        <td class="center"><?php echo $v['total_count_wash_return_qty'];?></td>
        <td class="center">
            <a target="_blank" href="<?php echo base_url();?>dashboard/getWashReturnDetailByDate/<?php echo ($date != '' ? $date : 'NA');?>/<?php echo ($v['po_no'] != '' ? $v['po_no'] : 'NA');?>/<?php echo ($v['purchase_order'] != '' ? $v['purchase_order'] : 'NA');?>/<?php echo ($v['item'] != '' ? $v['item'] : 'NA');?>/<?php echo ($v['quality'] != '' ? $v['quality'] : 'NA');?>/<?php echo ($v['color'] != '' ? $v['color'] : 'NA');?>">
                <?php echo $v['count_wash_return_qty'];?>
            </a>
        </td>
        <td class="center"><?php echo $wash_return_balance;?></td>
    </tr>

    <?php
    }
    ?>

    </tbody>

    <tfoot>
        <tr>
            <td class="" align="right" colspan="12"><h4><b>Total Qty</b></h4></td>
            <td class="center"><h4><b><?php echo $total_wash_return;?></b></h4></td>
            <td class="center"><h4><b><?php echo $total_wash_return_balance;?></b></h4></td>
        </tr>
    </tfoot>

</table>