<table class="display table table-bordered table-striped" id="" border="1">
    <thead>
        <tr>
            <th class="hidden-phone center">GROUP SO</th>
            <th class="hidden-phone center">SO</th>
            <th class="hidden-phone center">Purchase Order</th>
            <th class="hidden-phone center">Item</th>
            <th class="hidden-phone center">Quality</th>
            <th class="hidden-phone center">Color</th>
            <th class="hidden-phone center">Style</th>
            <th class="hidden-phone center">Style Name</th>
            <th class="hidden-phone center">Brand</th>
            <th class="hidden-phone center">Cut No</th>
            <th class="hidden-phone center">Qty</th>
            <th class="hidden-phone center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lay_data as $v){ ?>
            <tr>
                <td class="center"><?php echo $v['po_no'];?></td>
                <td class="center"><?php echo $v['so_no'];?></td>
                <td class="center"><?php echo $v['purchase_order'];?></td>
                <td class="center"><?php echo $v['item'];?></td>
                <td class="center"><?php echo $v['quality'];?></td>
                <td class="center"><?php echo $v['color'];?></td>
                <td class="center"><?php echo $v['style_no'];?></td>
                <td class="center"><?php echo $v['style_name'];?></td>
                <td class="center"><?php echo $v['brand'];?></td>
                <td class="center"><?php echo $v['cut_no'];?></td>
                <td class="center"><?php echo $v['total_cut_qty'];?></td>
                <td class="center">
                    <span class="btn btn-danger" onclick="removeLayScanByPoCut('<?php echo $v['po_no'];?>', '<?php echo $v['cut_no'];?>');"><i class="fa fa-times"></i> Remove</span>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>