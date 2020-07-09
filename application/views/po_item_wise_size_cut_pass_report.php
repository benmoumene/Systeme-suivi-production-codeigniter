<table class="table">
    <thead>
        <tr>
            <th class="center">PO-ITEM: <?php echo $order_size[0]['purchase_order'].'-'.$order_size[0]['item'];?></th>
            <th class="center">Style: <?php echo $order_size[0]['style_no'].'-'.$order_size[0]['style_name'];?></th>
            <th class="center">QLT-CLR: <?php echo $order_size[0]['quality'].'-'.$order_size[0]['color'];?></th>
            <th class="center">ExFac: <?php echo $order_size[0]['ex_factory_date'];?></th>
        </tr>
        <tr>
            <th class="center">Size</th>
            <th class="center">Order</th>
            <th class="center">Cut</th>
            <th class="center">Cut Pass</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $total_ordered_qty =0;
    $total_cut_pass_qty =0;
    $total_cut_qty =0;

    foreach ($order_size as $v){ ?>
        <tr style="<?php if($v['total_cut_qty'] > $v['total_cut_input_qty']){ ?>background-color: #ff9098; <?php } if($v['total_cut_qty'] == $v['total_cut_input_qty']){ ?>background-color: #aeff82;<?php } ?>">
            <td class="center"><?php echo $v['size'];?></td>
            <td class="center"><?php echo ($v['po_item_size_wise_order_qty'] != '' ? $v['po_item_size_wise_order_qty'] : 0);?></td>
            <td class="center"><?php echo ($v['total_cut_qty'] != '' ? $v['total_cut_qty'] : 0);?></td>
            <td class="center" style="cursor: pointer; font-size: 18px; font-weight: 800;" data-target="#myModal" data-toggle="modal" onclick="getRemainCLs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order'];?>', '<?php echo $v['item'];?>', '<?php echo $v['quality'];?>', '<?php echo $v['color'];?>', '<?php echo $v['size'];?>');"><?php echo ($v['total_cut_input_qty'] != '' ? $v['total_cut_input_qty'] : 0);?></td>
        </tr>
    <?php
        $total_cut_qty += $v['total_cut_qty'];
        $total_cut_pass_qty += $v['total_cut_input_qty'];
        $total_ordered_qty += $v['po_item_size_wise_order_qty'];
    } ?>
    </tbody>
    <tfoot>
    <tr style="background-color: #faffc5; font-weight: 700; font-size: 15px;">
        <td class="center">Total</td>
        <td class="center"><?php echo $total_ordered_qty;?></td>
        <td class="center"><?php echo $total_cut_qty;?></td>
        <td class="center"><?php echo $total_cut_pass_qty;?></td>
    </tr>
    </tfoot>
</table>