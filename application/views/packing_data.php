<div class="block-web">

    <div class="porlets-content">

        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="">
                <thead>
                <tr>
                    <th class="hidden-phone" colspan="7"></th>
                    <th class="hidden-phone center" colspan="1">Sewing</th>
                    <th class="hidden-phone center" colspan="3">Finishing</th>
                </tr>
                <tr>
                    <th class="hidden-phone center">PO-ITEM</th>
                    <th class="hidden-phone center">Brand</th>
                    <th class="hidden-phone center">STL</th>
                    <th class="hidden-phone center">QL-CLR</th>
                    <th class="hidden-phone center">Order</th>
                    <th class="hidden-phone center">Cut Pass</th>
                    <th class="hidden-phone center">ExFac</th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="End-Line Pass QTY">End Line</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Wash QTY">Wash</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Pack QTY">Pack</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Balance QTY">Balance</span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($prod_summary as $k => $v) {

                    $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'] + $v['count_wh_others'];

                    if (($v['total_cut_input_qty'] - ($v['count_packing_pass']+$v['count_manual_close'])) > 0) {
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
                            <td class="hidden-phone center" <?php if($v['wash_gmt'] == 0){ ?> style="color: #ffffff; font-size: 20px; background-color: darkblue;" <?php } ?>>
                                <?php echo $v['count_end_line_qc_pass']; ?>
                            </td>
                            <td class="hidden-phone center" <?php if($v['wash_gmt'] == 1){ ?> style="color: #ffffff; font-size: 20px; background-color: darkblue;" <?php } ?>>
                                <?php echo $v['count_washing_pass']; ?>
                            </td>
                            <td class="hidden-phone center"
                                <?php
                                if($v['wash_gmt'] == 1){
                                if($v['count_washing_pass'] > $v['count_packing_pass']){ ?>style="background-color: red;" <?php } ?>
                                <?php if($v['count_washing_pass'] <= $v['count_packing_pass']){ ?>style="background-color: darkgreen;" <?php }
                                }

                                if($v['wash_gmt'] == 0){

                                if($v['count_end_line_qc_pass'] > $v['count_packing_pass']){ ?>style="background-color: red;" <?php } ?>
                                <?php if($v['count_end_line_qc_pass'] <= $v['count_packing_pass']){ ?>style="background-color: darkgreen;" <?php }
                                }
                                ?>>
                                <span style="color: white; font-size: 20px;"><?php echo $v['count_packing_pass']; ?></span>
                            </td>
                            <td class="hidden-phone center">
                                <span class="btn btn-danger" data-target="#myModal" data-toggle="modal" onclick="getPolyRemainingPcs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order']; ?>','<?php echo $v['item']; ?>','<?php echo $v['quality']; ?>','<?php echo $v['color']; ?>');">
                                    <?php
                                    if($v['wash_gmt'] == 1){
                                        echo $v['count_washing_pass'] - $v['count_packing_pass'];
                                    }
                                    if($v['wash_gmt'] == 0){
                                        echo $v['count_end_line_qc_pass'] - $v['count_packing_pass'];
                                    }
                                    ?>
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