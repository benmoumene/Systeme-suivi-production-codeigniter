<div class="block-web">

    <div class="porlets-content">

        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="">
                <thead>
                <tr>
                    <th class="hidden-phone" colspan="6"></th>
                    <th class="hidden-phone center" colspan="3">Cutting</th>
                    <th class="hidden-phone center" colspan="3">Sewing</th>
                </tr>
                <tr>
                    <th class="hidden-phone center">PO-ITEM</th>
                    <th class="hidden-phone center">Brand</th>
                    <th class="hidden-phone center">STL</th>
                    <th class="hidden-phone center">QL-CLR</th>
                    <th class="hidden-phone center">Order</th>
                    <th class="hidden-phone center">ExFac</th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut QTY">CUT</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Balance">CUT BALANCE</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Pass QTY">CUT PASS</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Line Input">Input</span></th>
<!--                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Other Line Input">Other Line</span></th>-->
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Balance QTY">Balance</span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($prod_summary as $k => $v) {
                    if (($v['count_input_qty_line'] - $v['count_end_line_qc_pass']) > 0) {
                        ?>
                        <tr>
                            <td class="hidden-phone center"><span
                                        style="color: #727dff; cursor: pointer;"
                                        onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></span>
                            </td>
                            <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_cut_qty']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_cut_qty'] - $v['total_cut_input_qty']; ?></td>
                            <td class="hidden-phone center" style="background-color: #131b50;">
                                <span style="color: white; font-size: 20px;"><?php echo $v['total_cut_input_qty']; ?></span>
                            </td>
                            <td class="hidden-phone center" <?php if($v['total_cut_input_qty'] > ($v['count_input_qty_line'] + $v['count_other_input_qty_line'])){ ?>style="background-color: red;" <?php } ?> <?php if($v['total_cut_input_qty'] == ($v['count_input_qty_line'] + $v['count_other_input_qty_line'])){ ?>style="background-color: darkgreen;" <?php } ?>>
                                <span style="color: white; font-size: 20px;"><?php echo $v['count_input_qty_line']; ?></span>
                            </td>
<!--                            <td class="hidden-phone center">-->
<!--                                --><?php //echo $v['count_other_input_qty_line']; ?>
<!--                            </td>-->
                            <td class="hidden-phone center">
                                <span class="btn btn-danger" data-target="#myModal2" data-toggle="modal" onclick="getRemainingLinePcs('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>')">
                                    <?php echo $v['total_cut_input_qty'] - ($v['count_input_qty_line'] + $v['count_other_input_qty_line']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div><!--/table-responsive-->
    </div>

</div><!--/porlets-content-->