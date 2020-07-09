<table class="table">
    <thead>
    <tr>
        <th class="center">PO-ITEM: <?php echo $order_size[0]['purchase_order'].'-'.$order_size[0]['item'];?></th>
        <th class="center">Style: <?php echo $order_size[0]['style_no'].'-'.$order_size[0]['style_name'];?></th>
        <th class="center">QLT-CLR: <?php echo $order_size[0]['quality'].'-'.$order_size[0]['color'];?></th>
        <th class="center">ExFac: <?php echo $order_size[0]['ex_factory_date'];?></th>
        <th class="center"></th>
    </tr>
    <tr>
        <th class="center">Size</th>
        <th class="center">Cut No</th>
        <th class="center">Bundle No</th>
        <th class="center"><?php echo $part_name;?></th>

    </tr>
    </thead>
    <tbody>
    <?php
    $total_cut_pass_qty =0;
    $total_qty =0;
    $total_mid_pass_qty =0;
    $total_end_pass_qty =0;

    foreach ($order_size as $v){ ?>
        <tr style="<?php if($v['total_cut_input_qty'] > $v['count_end_line_qc_pass']){ ?>background-color: #ff9098; <?php } if($v['total_cut_input_qty'] == $v['count_end_line_qc_pass']){ ?>background-color: #aeff82;<?php } ?>">
            <td class="center"><?php echo $v['size'];?></td>
            <td class="center"><?php echo $v['cut_no'];?></td>
            <td class="center"><?php echo $v['bundle'];?></td>
            <td class="center"><?php echo ($v['total_qty'] != '' ? $v['total_qty'] : 0);?></td>

        <?php
        $total_cut_pass_qty += $v['total_cut_input_qty'];
        $total_qty += $v['total_qty'];

    } ?>
    </tbody>
    <tfoot>
    <tr style="background-color: #faffc5; font-weight: 700; font-size: 15px;">
        <td class="center">Total</td>
<!--        <td class="center">--><?php //echo $total_cut_pass_qty;?><!--</td>-->
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"><?php echo $total_qty;?></td>

    </tr>
    </tfoot>
</table>