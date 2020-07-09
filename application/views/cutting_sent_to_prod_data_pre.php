<div class="block-web">

    <div class="porlets-content">

        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="">
                <thead>
                <tr>
                    <th class="hidden-phone" colspan="6"></th>
                    <th class="hidden-phone center" colspan="2">Range</th>
                    <th class="hidden-phone center" colspan="3">Cutting</th>
                </tr>
                <tr>
                    <th class="hidden-phone center">PO-ITEM</th>
                    <th class="hidden-phone center">Brand</th>
                    <th class="hidden-phone center">STL</th>
                    <th class="hidden-phone center">QL-CLR</th>
                    <th class="hidden-phone center">OQ</th>
                    <th class="hidden-phone center">ExFac</th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Bundle Range">BR</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Identity Number Range">INR</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut QTY">Cut</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Pass QTY">Pass</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Balance">Balance</span></th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach($prod_summary as $k => $v) {
                    if (($v['total_cut_qty'] - $v['total_cut_input_qty']) > 0) {
                        ?>
                        <tr>
                            <td class="hidden-phone center">
                                <span style="color: #727dff; cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['purchase_order']; ?>', '<?php echo $v['item']; ?>');"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></span>
                            </td>
                            <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['bundle_start'] . '-' . $v['bundle_end']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['min_care_label'] . '-' . $v['max_care_label']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_cut_qty']; ?></td>
                            <td class="hidden-phone center" style="background-color: darkgreen;">
                                <span style="color: white;"><?php echo $v['total_cut_input_qty']; ?></span>
                            </td>
                            <td class="hidden-phone center" style="background-color: blue;"><span
                                        style="color: white;"><?php echo $v['total_cut_qty'] - $v['total_cut_input_qty']; ?></span>
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