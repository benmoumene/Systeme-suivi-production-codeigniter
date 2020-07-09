<div class="block-web">

    <div class="porlets-content">

        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="">
                <thead>
                <tr>
                    <th class="hidden-phone" colspan="7"></th>
                    <th class="hidden-phone center" colspan="2">Finishing</th>
                </tr>
                <tr>
                    <th class="hidden-phone center">PO-ITEM</th>
                    <th class="hidden-phone center">Brand</th>
                    <th class="hidden-phone center">STL</th>
                    <th class="hidden-phone center">QL-CLR</th>
                    <th class="hidden-phone center">Order</th>
                    <th class="hidden-phone center">ExFac</th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Wash">Wash</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Wash QTY">Wash Return</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Balance QTY">Balance</span></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($prod_summary as $k => $v) {
                    if (($v['count_wash_going_qty'] - $v['count_washing_pass']) != 0) {
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
                            <td class="hidden-phone center" style="color: #ffffff; font-size: 20px; background-color: darkblue;"><?php echo $v['count_wash_going_qty']; ?></td>
                            <td class="hidden-phone center" <?php if($v['count_wash_going_qty'] > $v['count_washing_pass']){ ?>style="background-color: red;" <?php } ?> <?php if($v['count_wash_going_qty'] <= $v['count_washing_pass']){ ?>style="background-color: darkgreen;" <?php } ?>>
                                <span style="color: white; font-size: 20px;"><?php echo $v['count_washing_pass']; ?></span>
                            </td>
                            <td class="hidden-phone center">
                                <?php echo $v['count_wash_going_qty'] - $v['count_washing_pass']; ?>
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