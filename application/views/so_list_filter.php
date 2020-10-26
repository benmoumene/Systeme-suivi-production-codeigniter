<div id="table_content">
    <div class="col-md-12 tableFixHead">
        <table class="table table-bordered table-striped" id="" border="1">
            <thead>
                <tr>
                    <th class="hidden-phone center">Group SO</th>
                    <th class="hidden-phone center">SO</th>
                    <th class="hidden-phone center">Purchase Order</th>
                    <th class="hidden-phone center">Item</th>
                    <th class="hidden-phone center">Quality</th>
                    <th class="hidden-phone center">Color</th>
                    <th class="hidden-phone center">Style</th>
                    <th class="hidden-phone center">Style Name</th>
                    <th class="hidden-phone center">Brand</th>
                    <th class="hidden-phone center">Order</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($so_list as $s){ ?>
                    <tr>
                        <td class="hidden-phone center"><?php echo $s['po_no'];?></td>
                        <td class="hidden-phone center"><?php echo $s['so_no'];?></td>
                        <td class="hidden-phone center"><?php echo $s['purchase_order'];?></td>
                        <td class="hidden-phone center"><?php echo $s['item'];?></td>
                        <td class="hidden-phone center"><?php echo $s['quality'];?></td>
                        <td class="hidden-phone center"><?php echo $s['color'];?></td>
                        <td class="hidden-phone center"><?php echo $s['style_no'];?></td>
                        <td class="hidden-phone center"><?php echo $s['style_name'];?></td>
                        <td class="hidden-phone center"><?php echo $s['brand'];?></td>
                        <td class="hidden-phone center"><?php echo $s['total_order_qty'];?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td class="hidden-phone center">
                        <span class="btn btn-success" onclick="reformGroupSo();">REFORM</span>
                    </td>
                    <td colspan="10"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>