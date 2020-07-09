<table class="table">
    <thead>
        <tr>
            <th class="center" colspan="2">PO-ITEM: <?php echo $remain_pcs[0]['purchase_order'].'-'.$remain_pcs[0]['item'];?></th>
            <th class="center">Style: <?php echo $remain_pcs[0]['style_no'].'-'.$remain_pcs[0]['style_name'];?></th>
            <th class="center">QLT-CLR: <?php echo $remain_pcs[0]['quality'].'-'.$remain_pcs[0]['color'];?></th>
            <th class="center">ExFac: <?php echo $remain_pcs[0]['ex_factory_date'];?></th>
        </tr>
        <tr>
            <th class="center" colspan="2">Size</th>
            <th class="center" colspan="2">INR No.</th>
            <th class="center">Remarks</th>
        </tr>
    </thead>
    <tbody>
    <?php

        foreach ($remain_pcs as $v){
            $po_type = $v['po_type'];

            if($po_type == 1){
                $remarks = 'Size Set';
            }

            if($po_type == 2){
                $remarks = 'Sample';
            }

            if($po_type == 0){
                $remarks = '';
            }
            ?>
        <tr>
            <td class="center" colspan="2"><?php echo $v['size'];?></td>
            <td class="center" colspan="2"><?php echo $v['pc_tracking_no'];?></td>
            <td class="center" colspan="2"><?php echo $remarks;?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>