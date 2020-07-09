<div class="block-web">

    <div class="porlets-content">

        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="">
                <thead>
                <tr>
                    <th class="hidden-phone" colspan="5"></th>
<!--                    <th class="hidden-phone center" colspan="1">Cutting</th>-->
<!--                    <th class="hidden-phone center" colspan="1">Sewing</th>-->
                    <th class="hidden-phone center" colspan="2">Finishing</th>
                    <th class="hidden-phone center" colspan="5">Warehouse</th>
                    <th class="hidden-phone center" rowspan="2"><span data-toggle="tooltip" title="Balance Qty">Balance</span></th>
                </tr>
                <tr>
                    <th class="hidden-phone center">PO-ITEM</th>
                    <th class="hidden-phone center">Brand</th>
                    <th class="hidden-phone center">STL</th>
                    <th class="hidden-phone center">QL-CLR</th>
<!--                    <th class="hidden-phone center">OQ</th>-->
                    <th class="hidden-phone center">ExFac</th>
<!--                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Pass QTY">Cut Pass</span></th>-->
<!--                    <th class="hidden-phone center"><span data-toggle="tooltip" title="End-Line Pass QTY">End Line</span></th>-->
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Pack QTY">Pack</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Carton QTY">CTN</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse Production Sample">Sample</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse Factory">Factory</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse Buyer">Buyer</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse Trash">Trash</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Warehouse Size-Set">Size-Set</span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($prod_summary as $k => $v) {

                    $total_finishing_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_wh_others'] + $v['count_wh_size_set'];

                    if (($v['count_packing_pass'] - $total_finishing_qa) < 0) {
                        ?>
                        <tr>
                            <td class="hidden-phone center"><span
                                        style="color: #727dff; cursor: pointer;"
                                        onclick="getSizeWiseReport('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order']; ?>','<?php echo $v['item']; ?>','<?php echo $v['quality']; ?>','<?php echo $v['color']; ?>');"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></span>
                            </td>
                            <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
<!--                            <td class="hidden-phone center">--><?php //echo $v['total_order_qty']; ?><!--</td>-->
                            <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
<!--                            <td class="hidden-phone center">--><?php //echo $v['total_cut_input_qty']; ?><!--</td>-->
<!--                            <td class="hidden-phone center">--><?php //echo $v['count_end_line_qc_pass']; ?><!--</td>-->
                            <td class="hidden-phone center"><?php echo $v['count_packing_pass']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['count_carton_pass']; ?></td>
                            <td class="hidden-phone center" style="background-color: darkblue; color: #ffffff; font-size: 19px;"><?php echo $v['count_wh_prod_sample']; ?></td>
                            <td class="hidden-phone center" style="background-color: #55222c; color: #ffffff; font-size: 19px;"><?php echo $v['count_wh_factory']; ?></td>
                            <td class="hidden-phone center" style="background-color: darkgreen; color: #ffffff; font-size: 19px;"><?php echo $v['count_wh_buyer']; ?></td>
                            <td class="hidden-phone center" style="background-color: darkred; color: #ffffff; font-size: 19px;"><?php echo $v['count_wh_trash']; ?></td>
                            <td class="hidden-phone center" style="background-color: rgba(75,255,216,0.8); font-size: 19px;"><?php echo $v['count_wh_size_set']; ?></td>
                            <td class="hidden-phone center">
<!--                                --><?php //echo $v['total_cut_input_qty'] - $total_finishing_qa; ?>
                                <?php echo $v['count_packing_pass'] - $total_finishing_qa; ?>
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