<div class="porlets-content">

    <div class="table-responsive">
        <table class="display table table-bordered table-striped" id="">
            <thead>
            <tr>
                <th class="hidden-phone" colspan="7"></th>
<!--                <th class="hidden-phone center" colspan="1">Range</th>-->
                <th class="hidden-phone center" colspan="3">Cutting</th>

                <th class="hidden-phone center" colspan="2">Sewing</th>
            </tr>
            <tr>
                <th class="hidden-phone center">PO-ITEM</th>
                <th class="hidden-phone center">Brand</th>
                <th class="hidden-phone center">STL</th>
                <th class="hidden-phone center">QL-CLR</th>
                <th class="hidden-phone center"><span data-toggle="tooltip" title="Order QTY">OQ</span></th>
                <th class="hidden-phone center">ExFac</th>
                <th class="hidden-phone center"><span data-toggle="tooltip" title="Bundle Range">Bundles</span></th>
<!--                <th class="hidden-phone center"><span data-toggle="tooltip" title="Identity Number Range">INR</span></th>-->
                <th class="hidden-phone center"><span data-toggle="tooltip" title="Label Pass QTY">Label Pass</span></th>
                <th class="hidden-phone center"><span data-toggle="tooltip" title="Collar">Collar</span></th>
                <th class="hidden-phone center"><span data-toggle="tooltip" title="Cuff">Cuff</span></th>
                <th class="hidden-phone center"><span data-toggle="tooltip" title="Collar">Collar</span></th>
                <th class="hidden-phone center"><span data-toggle="tooltip" title="Cuff">Cuff</span></th>
            </tr>
            </thead>
            <tbody>
            <?php
//            $other_line_collar = 0;
//            $other_line_cuff = 0;

            foreach($prod_summary as $k => $v){

//                $other_line_cr = $this->method_call->otherLineCollarBundleScanned($v['po_no'], $v['so_no'], $v['purchase_order'], $v['item'], $v['quality'], $v['color']);
//                $other_line_collar = $other_line_cr[0]['count_collar_bundle_qty'];
//                $total_collar_bundle = $other_line_collar + $v['count_collar_bundle_qty'];

//                $other_line_cff = $this->method_call->otherLineCuffBundleScanned($v['po_no'], $v['so_no'], $v['purchase_order'], $v['item'], $v['quality'], $v['color']);
//                $other_line_cuff = $other_line_cff[0]['count_cuff_bundle_qty'];
//                $total_cuff_bundle = $other_line_cuff + $v['count_cuff_bundle_qty'];

//             if (($v['total_cut_input_qty'] > $v['collar_bndl_qty']) && ($v['total_cut_input_qty'] > $v['cuff_bndl_qty'])) {
                if (($v['total_cut_input_qty'] - $v['count_end_line_qc_pass']) != 0) {

                    ?>
                    <tr>
                        <td class="hidden-phone center">
                            <span style="color: #727dff; cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></span>
                        </td>
                        <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['bundle_start'] . '-' . $v['bundle_end']; ?></td>
<!--                        <td class="hidden-phone center">--><?php //echo $v['min_care_label'] . '-' . $v['max_care_label']; ?><!--</td>-->
                        <td class="hidden-phone center"><?php echo $v['total_cut_input_qty']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['count_cutting_collar_bundle_qty']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['count_cutting_cuff_bundle_qty']; ?></td>
                        <td class="hidden-phone center" style="<?php if(($v['count_collar_bundle_qty'] >= $v['count_cutting_collar_bundle_qty']) && ($v['count_collar_bundle_qty'] != '') && ($v['count_collar_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                            <span data-target="#myModal" data-toggle="modal" onclick="getCollarRemainingBundle('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');" style="color: white; font-size: 20px;"><?php echo $v['count_collar_bundle_qty']; ?></span>
                        </td>
                        <td class="hidden-phone center" style="<?php if(($v['count_cuff_bundle_qty'] >= $v['count_cutting_cuff_bundle_qty']) && ($v['count_cuff_bundle_qty'] != '') && ($v['count_cuff_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                            <span data-target="#myModal" data-toggle="modal" onclick="getCuffRemainingBundle('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');" style="color: white; font-size: 20px;"><?php echo $v['count_cuff_bundle_qty']; ?></span>
                        </td>
                    </tr>
                    <?php
                }
            } ?>
            </tbody>
        </table>
    </div><!--/table-responsive-->
</div>