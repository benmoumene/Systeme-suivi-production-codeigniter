<table class="table">
    <thead>
        <tr>
            <th class="center" colspan="3">PO-ITEM: <?php echo $order_size[0]['purchase_order'].'-'.$order_size[0]['item'];?></th>
            <th class="center" colspan="3">Style: <?php echo $order_size[0]['style_no'].'-'.$order_size[0]['style_name'];?></th>
            <th class="center" colspan="3">QLT-CLR: <?php echo $order_size[0]['quality'].'-'.$order_size[0]['color'];?></th>
            <th class="center" colspan="2">ExFac: <?php echo $order_size[0]['ex_factory_date'];?></th>
        </tr>
        <tr>
            <th class="center">Size</th>
            <th class="center">Order</th>
            <th class="center">Cut</th>
            <th class="center">Cut Pass</th>
            <th class="center">IN</th>
            <th class="center">Mid</th>
            <th class="center">End</th>
            <th class="center">Washing</th>
            <th class="center">Washed</th>
            <th class="center">Pack</th>
            <th class="center">Carton</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $total_ordered_qty = 0;
    $total_cut_qty = 0;
    $total_cut_pass_qty = 0;
    $total_input_qty = 0;
    $total_endline_qty = 0;
    $total_wash_going = 0;
    $total_wash_qty = 0;
    $total_packing_qty = 0;
    $total_count_carton_pass = 0;

    foreach ($order_size as $v){ ?>
        <tr style="<?php if($v['po_item_size_wise_order_qty'] > $v['count_carton_pass']){ ?>background-color: #ff9098; <?php } if($v['po_item_size_wise_order_qty'] <= $v['count_carton_pass']){ ?>background-color: #aeff82;<?php } ?>">
            <td class="center"><?php echo $v['size'];?></td>
            <td class="center"><?php echo $v['po_item_size_wise_order_qty'];?></td>
            <td class="center"><?php echo $v['total_cut_qty'];?></td>
            <td data-target="#myModal2" data-toggle="modal" class="center" style="cursor: pointer;" onclick="getRemainCLs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order'];?>', '<?php echo $v['item'];?>', '<?php echo $v['quality'];?>', '<?php echo $v['color'];?>', '<?php echo $v['size'];?>', 1);"><?php echo ($v['total_cut_input_qty'] != '' ? $v['total_cut_input_qty'] : 0);?></td>
            <td data-target="#myModal2" data-toggle="modal" class="center" style="cursor: pointer;" onclick="getRemainCLs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order'];?>', '<?php echo $v['item'];?>', '<?php echo $v['quality'];?>', '<?php echo $v['color'];?>', '<?php echo $v['size'];?>', 2);"><?php echo ($v['count_input_qty_line'] != '' ? $v['count_input_qty_line'] : 0);?></td>
            <td data-target="#myModal2" data-toggle="modal" class="center" style="cursor: pointer;" onclick="getRemainCLs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order'];?>', '<?php echo $v['item'];?>', '<?php echo $v['quality'];?>', '<?php echo $v['color'];?>', '<?php echo $v['size'];?>', 3);"><?php echo ($v['count_mid_line_qc_pass'] != '' ? $v['count_mid_line_qc_pass'] : 0);?></td>
            <td data-target="#myModal2" data-toggle="modal" class="center" style="cursor: pointer;" onclick="getRemainCLs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order'];?>', '<?php echo $v['item'];?>', '<?php echo $v['quality'];?>', '<?php echo $v['color'];?>', '<?php echo $v['size'];?>', 4);"><?php echo ($v['count_end_line_qc_pass'] != '' ? $v['count_end_line_qc_pass'] : 0);?></td>
            <td data-target="#myModal2" data-toggle="modal" class="center" style="cursor: pointer;" onclick="getRemainCLs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order'];?>', '<?php echo $v['item'];?>', '<?php echo $v['quality'];?>', '<?php echo $v['color'];?>', '<?php echo $v['size'];?>', 10);"><?php echo ($v['count_wash_going'] != '' ? $v['count_wash_going'] : 0);?></td>
            <td data-target="#myModal2" data-toggle="modal" class="center" style="cursor: pointer;" onclick="getRemainCLs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order'];?>', '<?php echo $v['item'];?>', '<?php echo $v['quality'];?>', '<?php echo $v['color'];?>', '<?php echo $v['size'];?>', 5);"><?php echo ($v['count_washing_pass'] != '' ? $v['count_washing_pass'] : 0);?></td>
            <td data-target="#myModal2" data-toggle="modal" class="center" style="cursor: pointer;" onclick="getRemainCLs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order'];?>', '<?php echo $v['item'];?>', '<?php echo $v['quality'];?>', '<?php echo $v['color'];?>', '<?php echo $v['size'];?>', 7);"><?php echo ($v['po_item_size_wise_packing_qty'] != '' ? $v['po_item_size_wise_packing_qty'] : 0);?></td>
            <td data-target="#myModal2" data-toggle="modal" class="center" style="cursor: pointer;" onclick="getRemainCLs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order'];?>', '<?php echo $v['item'];?>', '<?php echo $v['quality'];?>', '<?php echo $v['color'];?>', '<?php echo $v['size'];?>', 9);"><?php echo ($v['count_carton_pass'] != '' ? $v['count_carton_pass'] : 0);?></td>
        </tr>
    <?php
        $total_ordered_qty += $v['po_item_size_wise_order_qty'];
        $total_cut_qty += $v['total_cut_qty'];
        $total_cut_pass_qty += $v['total_cut_input_qty'];
        $total_input_qty += $v['count_input_qty_line'];
        $total_midline_qty += $v['count_mid_line_qc_pass'];
        $total_endline_qty += $v['count_end_line_qc_pass'];
        $total_wash_going += $v['count_wash_going'];
        $total_wash_qty += $v['count_washing_pass'];
        $total_packing_qty += $v['po_item_size_wise_packing_qty'];
        $total_count_carton_pass += $v['count_carton_pass'];
    } ?>
    </tbody>
    <tfoot>
    <tr style="background-color: #faffc5; font-weight: 700; font-size: 22px;">
        <td class="center">Total</td>
        <td class="center"><?php echo $total_ordered_qty;?></td>
        <td class="center"><?php echo $total_cut_qty;?></td>
        <td class="center"><?php echo $total_cut_pass_qty;?></td>
        <td class="center"><?php echo $total_input_qty;?></td>
        <td class="center"><?php echo $total_midline_qty;?></td>
        <td class="center"><?php echo $total_endline_qty;?></td>
        <td class="center"><?php echo $total_wash_going;?></td>
        <td class="center"><?php echo $total_wash_qty;?></td>
        <td class="center"><?php echo $total_packing_qty;?></td>
        <td class="center"><?php echo $total_count_carton_pass;?></td>
    </tr>
    </tfoot>
</table>