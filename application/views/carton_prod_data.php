<div class="block-web">

    <div class="porlets-content">

        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="">
                <thead>
                <tr>
                    <th class="hidden-phone" colspan="6"></th>
                    <th class="hidden-phone center" colspan="3">Cutting</th>
                    <th class="hidden-phone center" colspan="2">Range</th>
                    <th class="hidden-phone center">Sewing</th>
                    <th class="hidden-phone center" colspan="5">Finishing</th>
                </tr>
                <tr>
                    <th class="hidden-phone center">PO-ITEM</th>
                    <th class="hidden-phone center">Brand</th>
                    <th class="hidden-phone center">STL</th>
                    <th class="hidden-phone center">QL-CLR</th>
                    <th class="hidden-phone center">OQ</th>
                    <th class="hidden-phone center">ExFac</th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut QTY">CQ</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Balance">CBQ</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Pass QTY">CPQ</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Bundle Range">BR</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Care Label Range">CR</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="End-Line Pass QTY">EPQ</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Wash QTY">WQ</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Pack QTY">PQ</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Carton">Carton</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse QTY">WHQ</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Balance QTY">BQ</span></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total_wh_qa = 0;
                foreach($prod_summary as $k => $v) {

                    $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_wh_others'];
                    $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_wh_others'];

                    if (($v['total_cut_input_qty'] - $total_finishing_wh_qa) > 0) {
                        ?>
                        <tr>
                            <td class="hidden-phone center"><span
                                    style="color: #727dff; cursor: pointer;"
                                    onclick="getSizeWiseReport('<?php echo $v['po_no'];?>', '<?php echo $v['purchase_order']; ?>','<?php echo $v['item']; ?>');"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></span>
                            </td>
                            <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_cut_qty']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_cut_qty'] - $v['total_cut_input_qty']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_cut_input_qty']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['bundle_start'] . '-' . $v['bundle_end']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['min_care_label'] . '-' . $v['max_care_label']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['count_end_line_qc_pass']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['count_washing_pass']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['count_packing_pass']; ?></td>
                            <td class="hidden-phone center" style="background-color: darkgreen;">
                                <span style="color: white; font-size: 20px;"><?php echo $v['count_carton_pass']; ?></span>
                            </td>
                            <td class="hidden-phone center"><?php echo $total_wh_qa; ?></td>
                            <td class="hidden-phone center">
                                <a target="_blank" href="<?php echo base_url(); ?>access/remainQtyStatus/<?php echo $v['po_no']; ?>/<?php echo $v['purchase_order']; ?>/<?php echo $v['item']; ?>/4"><?php echo $v['total_cut_input_qty'] - $total_finishing_wh_qa; ?></a>
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