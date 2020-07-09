<div class="block-web">

    <div class="porlets-content">

        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="">
                <thead>
                <tr>
                    <th class="hidden-phone" colspan="7"></th>
<!--                    <th class="hidden-phone center" colspan="2">Range</th>-->
                    <th class="hidden-phone center" colspan="3">Cutting</th>
                </tr>
                <tr>
                    <th class="hidden-phone center">PO-ITEM</th>
                    <th class="hidden-phone center">Plan Line</th>
                    <th class="hidden-phone center">Brand</th>
                    <th class="hidden-phone center">STL</th>
                    <th class="hidden-phone center">QL-CLR</th>
                    <th class="hidden-phone center">Order</th>
                    <th class="hidden-phone center">ExFac</th>
<!--                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Bundle Range">Bundles</span></th>-->
<!--                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Identity Number Range">INR</span></th>-->
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut QTY">Cut</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Pass QTY">Pass</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Balance">Balance</span></th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach($prod_summary as $k => $v) {

//                    $cut_balance_qty = ($v['cut_balance_qty'] != '' ? $v['cut_balance_qty'] : 0);

                    if (($v['total_cut_qty'] - ($v['total_cut_input_qty'] + $v['count_manual_close_qty'])) > 0) {
//                    if ($cut_balance_qty > 0) {
                        ?>
                        <tr>
                            <td class="hidden-phone center">
                                <?php echo $v['purchase_order'] . '-' . $v['item']; ?>
                            </td>
                            <td class="hidden-phone center"><?php echo $line_name; ?></td>
                            <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
<!--                            <td class="hidden-phone center">--><?php //echo $v['bundle_start'] . '-' . $v['bundle_end']; ?><!--</td>-->
<!--                            <td class="hidden-phone center">--><?php //echo $v['min_care_label'] . '-' . $v['max_care_label']; ?><!--</td>-->
                            <td class="hidden-phone center"><?php echo $v['total_cut_qty']; ?></td>
                            <td class="hidden-phone center" style="background-color: darkgreen;">
                                <span style="color: white;"><?php echo $v['total_cut_input_qty']; ?></span>
                            </td>
                            <td class="hidden-phone center">
                                <span class="btn btn-primary" data-target="#myModal" data-toggle="modal" onclick="getCutBalancePcs('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order']; ?>', '<?php echo $v['item']; ?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');">
                                    <?php
//                                        echo $v['total_cut_qty'] - $v['total_cut_input_qty'];
//                                        echo $cut_balance_qty;
                                    ?>

                                    BLNC PCs
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