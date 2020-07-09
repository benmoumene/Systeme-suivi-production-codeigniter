<table class="table">
    <thead>
        <tr>
            <th class="center">PO: <?php echo $order_size[0]['purchase_order'];?></th>
            <th class="center">ITEM: <?php echo $order_size[0]['item'];?></th>
            <th class="center" colspan="2">Style: <?php echo $order_size[0]['style_no'];?></th>
        </tr>
        <tr>
            <th class="center">QLT: <?php echo $order_size[0]['quality'];?></th>
            <th class="center">CLR: <?php echo $order_size[0]['color'];?></th>
            <th class="center" colspan="2">Style Name: <?php echo $order_size[0]['style_name'];?></th>
        </tr>
        <tr>
            <th class="center">Size</th>
            <th class="center">Identity Number</th>
            <th class="center">Warehouse Type</th>
            <th class="center">Remarks</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($order_size as $v){ ?>
        <tr style="">
            <td class="center"><?php echo $v['size'];?></td>
            <td class="center"><?php echo $v['pc_tracking_no'];?></td>
            <td class="center">
                <?php if($v['warehouse_qa_type'] == 1){ echo 'Buyer'; } ?>
                <?php if($v['warehouse_qa_type'] == 2){ echo 'Factory'; } ?>
                <?php if($v['warehouse_qa_type'] == 3){ echo 'Trash'; } ?>
                <?php if($v['warehouse_qa_type'] == 4){ echo 'Sample'; } ?>
                <?php if($v['warehouse_qa_type'] == 5){ echo 'Others'; } ?>
                <?php if($v['warehouse_qa_type'] == 6){ echo 'Lost'; } ?>
                <?php if($v['warehouse_qa_type'] == 7){ echo 'Size Set'; } ?>
            </td>
            <td class="center"><?php echo $v['other_purpose_remarks'];?></td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>