<table class="table">
    <thead>
        <tr>
            <th class="center" colspan="4"><h4><b>Un-Scanned Cuff Bundles</b></h4></th>
        </tr>
        <tr>
            <th class="center" colspan="2">PO-ITEM: <?php echo $remain_collar_bundles[0]['purchase_order'].'-'.$remain_collar_bundles[0]['item'];?></th>
            <th class="center" colspan="2">Style: <?php echo $remain_collar_bundles[0]['style_name'];?></th>
        </tr>
        <tr>
            <th class="center" colspan="2">QLT-CLR: <?php echo $remain_collar_bundles[0]['quality'].'-'.$remain_collar_bundles[0]['color'];?></th>
            <th class="center" colspan="2"></th>
        </tr>
        <tr>
            <th class="center">Size</th>
            <th class="center">Cut No</th>
            <th class="center">Bundle No</th>
            <th class="center">Qty</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($remain_collar_bundles as $v){ ?>
        <tr style="<?php if($v['po_item_size_wise_order_qty'] > $v['po_item_size_wise_packing_qty']){ ?>background-color: #ff9098; <?php } if($v['po_item_size_wise_order_qty'] <= $v['po_item_size_wise_packing_qty']){ ?>background-color: #aeff82;<?php } ?>">
            <td class="center"><?php echo $v['size'];?></td>
            <td class="center"><?php echo $v['cut_no'];?></td>
            <td class="center"><?php echo $v['bundle'];?></td>
            <td class="center"><?php echo $v['cut_qty'];?></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>