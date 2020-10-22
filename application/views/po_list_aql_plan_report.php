<div class="col-md-12" id="tableWrap" style="overflow-x:auto;">
<table class="table table-bordered table-striped" id="" border="1">
    <thead>
        <tr>
            <th colspan="9"></th>
            <th class="center">
                <button class="btn btn-success">SAVE</button>
            </th>
        </tr>
        <tr>
            <th class="hidden-phone center">SO</th>
            <th class="hidden-phone center">Brand</th>
            <th class="hidden-phone center">PO</th>
            <th class="hidden-phone center">Item</th>
            <th class="hidden-phone center">Style</th>
            <th class="hidden-phone center">Quality</th>
            <th class="hidden-phone center">Color</th>
            <th class="hidden-phone center">Order</th>
            <th class="hidden-phone center">AQL Plan Date</th>
            <th class="hidden-phone center">Ready for AQL?</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($po_list as $v){ ?>
        <tr>
            <td class="center">
                <?php echo $v['so_no'];?>
                <input type="hidden" autocomplete="off" name="so_no[]" id="so_no" value="<?php echo $v['so_no'];?>"/>
            </td>
            <td class="center"><?php echo $v['brand'];?></td>
            <td class="center"><?php echo $v['purchase_order'];?></td>
            <td class="center"><?php echo $v['item'];?></td>
            <td class="center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
            <td class="center"><?php echo $v['quality'];?></td>
            <td class="center"><?php echo $v['color'];?></td>
            <td class="center"><?php echo $v['total_order_qty'];?></td>
            <td class="center">
                <input type="date" name="aql_plan_date[]" id="aql_plan_date" value="<?php echo ($v['aql_plan_date'] != '' ? $v['aql_plan_date'] : '0000-00-00');?>"/>
            </td>
            <td class="center">
                <center>
                    <input type="checkbox" class="form-control" id="ready_for_aql" name="ready_for_aql[]" value="1" <?php if($v['is_ready_for_aql'] == 1){ ?> checked="checked" <?php } ?> />
                </center>
            </td>
        </tr>
    <?php
        }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9"></td>
            <td class="center">
                <button class="btn btn-success">SAVE</button>
            </td>
        </tr>
    </tfoot>
</table>
</div>