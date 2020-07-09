<div class="block-web">

    <div class="porlets-content">

        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="">
                <thead>
                <tr>
                    <th class="hidden-phone" colspan="7"></th>
<!--                    <th class="hidden-phone center" colspan="1">Sewing</th>-->
                    <th class="hidden-phone center" colspan="4">Finishing</th>
                </tr>
                <tr>
                    <th class="hidden-phone center">PO-ITEM</th>
                    <th class="hidden-phone center">Brand</th>
                    <th class="hidden-phone center">STL</th>
                    <th class="hidden-phone center">QL-CLR</th>
                    <th class="hidden-phone center">Order</th>
                    <th class="hidden-phone center">Cut Pass</th>
                    <th class="hidden-phone center">ExFac</th>
<!--                    <th class="hidden-phone center"><span data-toggle="tooltip" title="End-Line Pass QTY">End Line</span></th>-->
<!--                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Wash QTY">Wash</span></th>-->
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Pack QTY">Pack</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Carton">Carton</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse QTY">WHQ</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Balance QTY">Balance</span></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total_wh_qa = 0;
                foreach($prod_summary as $k => $v) {

                    $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_manual_close'] + ($v['total_wh_qa'] != NULL ? $v['total_wh_qa'] : 0);
                    $total_wh_qa = ($v['total_wh_qa'] != NULL ? $v['total_wh_qa'] : 0);

                    if (($v['total_cut_input_qty'] - $total_finishing_wh_qa) > 0) {
                        ?>
                        <tr>
                            <td class="hidden-phone center"><span
                                        style="color: #727dff; cursor: pointer;"
                                        onclick="getSizeWiseReport('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order']; ?>','<?php echo $v['item']; ?>','<?php echo $v['quality']; ?>','<?php echo $v['color']; ?>');"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></span>
                            </td>
                            <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['total_cut_input_qty']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
<!--                            <td class="hidden-phone center">--><?php //echo $v['count_end_line_qc_pass']; ?><!--</td>-->
<!--                            <td class="hidden-phone center">--><?php //echo $v['count_washing_pass']; ?><!--</td>-->
                            <td class="hidden-phone center"><?php echo $v['count_packing_pass']; ?></td>
                            <td class="hidden-phone center" style="background-color: darkgreen;">
                                <span style="color: white; font-size: 20px;"><?php echo $v['count_carton_pass']; ?></span>
                            </td>
                            <td class="hidden-phone center"><?php echo $total_wh_qa; ?></td>
                            <td class="hidden-phone center">
                                <span class="btn btn-danger" data-target="#myModal" data-toggle="modal" onclick="getCartonRemainingPcs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order']; ?>','<?php echo $v['item']; ?>','<?php echo $v['quality']; ?>','<?php echo $v['color']; ?>');"><?php echo $v['total_cut_input_qty'] - $total_finishing_wh_qa; ?></span>
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