<div class="col-md-12" id="tableWrap" style="overflow-x:auto;">
<table class="table table-bordered table-striped" id="" border="1">
    <thead>
    <tr style="font-size: 16px;">
        <th class="hidden-phone center">Group PO</th>
        <th class="hidden-phone center">SO</th>
        <th class="hidden-phone center">Brand</th>
        <th class="hidden-phone center">Purchase Order</th>
        <th class="hidden-phone center">Item</th>
        <th class="hidden-phone center">Quality</th>
        <th class="hidden-phone center">Color</th>
        <th class="hidden-phone center">Style</th>
        <th class="hidden-phone center">Style Name</th>
        <th class="hidden-phone center">Size</th>
        <th class="hidden-phone center">Order</th>
        <th class="hidden-phone center">ExFac Date</th>
        <th class="hidden-phone center">Type</th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($po_info_report as $v){

        $po_type='';
        if($v['po_type'] == 0){
            $po_type='BULK';
        }
        if($v['po_type'] == 1){
            $po_type='SIZE SET';
        }
        if($v['po_type'] == 2){
            $po_type='SAMPLE';
        }

        ?>
        <tr>
            <td class="center"><?php echo $v['po_no'];?></td>
            <td class="center"><?php echo $v['so_no'];?></td>
            <td class="center"><?php echo $v['brand'];?></td>
            <td class="center"><?php echo $v['purchase_order'];?></td>
            <td class="center"><?php echo $v['item'];?></td>
            <td class="center"><?php echo $v['quality'];?></td>
            <td class="center"><?php echo $v['color'];?></td>
            <td class="center"><?php echo $v['style_no'];?></td>
            <td class="center"><?php echo $v['style_name'];?></td>
            <td class="center"><?php echo $v['size'];?></td>
            <td class="center"><?php echo $v['quantity'];?></td>
            <td class="center"><?php echo $v['ex_factory_date'];?></td>
            <td class="center"><?php echo $po_type;?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
</div>