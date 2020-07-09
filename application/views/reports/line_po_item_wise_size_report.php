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
            <th class="center">Ordered Qty</th>
            <th class="center">In Line Qty</th>
            <th class="center">End Line Qty</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($order_size as $v){ ?>
        <tr style="<?php if($v['po_item_size_wise_order_qty'] > $v['po_item_size_wise_endline_qty']){ ?>background-color: #ff9098; <?php } if($v['po_item_size_wise_order_qty'] <= $v['po_item_size_wise_endline_qty']){ ?>background-color: #aeff82;<?php } ?>">
            <td class="center"><?php echo $v['size'];?></td>
            <td class="center"><?php echo $v['po_item_size_wise_order_qty'];?></td>
            <td class="center"><?php echo $v['po_item_size_wise_inline_qty'];?></td>
            <td class="center"><?php echo $v['po_item_size_wise_endline_qty'];?></td>
        </tr>
    <?php
        $total_ordered_qty += $v['po_item_size_wise_order_qty'];
        $total_inline_qty += $v['po_item_size_wise_inline_qty'];
        $total_endline_qty += $v['po_item_size_wise_endline_qty'];
    } ?>
    </tbody>
    <tfoot>
    <tr style="background-color: #faffc5; font-weight: 700; font-size: 15px;">
        <td class="center">Total</td>
        <td class="center"><?php echo $total_ordered_qty;?></td>
        <td class="center"><?php echo $total_inline_qty;?></td>
        <td class="center"><?php echo $total_endline_qty;?></td>
    </tr>
    </tfoot>
</table>