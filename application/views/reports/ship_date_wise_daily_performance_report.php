<div id="table_content">
    <div class="col-md-12" id="tableWrap">

        <table class="table table-bordered table-striped" id="" border="1">
            <thead>
            <tr>
                <th class="hidden-phone center">SO</th>
                <th class="hidden-phone center">Brand</th>
                <th class="hidden-phone center">Purchase Order</th>
                <th class="hidden-phone center">Item</th>
                <th class="hidden-phone center">Style</th>
                <th class="hidden-phone center">Style Name</th>
                <th class="hidden-phone center">Quality</th>
                <th class="hidden-phone center">Color</th>
                <th class="hidden-phone center">Ex-Factory</th>
                <th class="hidden-phone center">Order</th>
                <th class="hidden-phone center">Line</th>
                <th class="hidden-phone center">Date</th>
                <th class="hidden-phone center">Line Output</th>
                <th class="hidden-phone center">Manual Closed</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total_line_output = 0;
            $total_line_manual_output = 0;

            foreach($daily_output AS $v){

                $total_line_output += $v['line_output_qty'];
                $total_line_manual_output += $v['line_manual_output_qty'];
                ?>
                <tr>
                    <td class="hidden-phone center"><?php echo $v['so_no'];?></td>
                    <td class="hidden-phone center"><?php echo $v['brand'];?></td>
                    <td class="hidden-phone center"><?php echo $v['purchase_order'];?></td>
                    <td class="hidden-phone center"><?php echo $v['item'];?></td>
                    <td class="hidden-phone center"><?php echo $v['style_no'];?></td>
                    <td class="hidden-phone center"><?php echo $v['style_name'];?></td>
                    <td class="hidden-phone center"><?php echo $v['quality'];?></td>
                    <td class="hidden-phone center"><?php echo $v['color'];?></td>
                    <td class="hidden-phone center"><?php echo $v['ex_factory_date'];?></td>
                    <td class="hidden-phone center"><?php echo $v['total_order_qty'];?></td>
                    <td class="hidden-phone center"><?php echo $v['line_code'];?></td>
                    <td class="hidden-phone center"><?php echo $v['line_output_date'];?></td>
                    <td class="hidden-phone center"><?php echo $v['line_output_qty'];?></td>
                    <td class="hidden-phone center"><?php echo $v['line_manual_output_qty'];?></td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr>
                <td class="hidden-phone" colspan="12" align="right">Total</td>
                <td class="hidden-phone center"><?php echo $total_line_output;?></td>
                <td class="hidden-phone center"><?php echo $total_line_manual_output;?></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>