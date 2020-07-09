<div class="block-web">

    <div class="porlets-content">

        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="">
                <thead>
                    <tr>
                        <th class="hidden-phone center">SO</th>
                        <th class="hidden-phone center">Brand</th>
                        <th class="hidden-phone center">PO-ITEM</th>
                        <th class="hidden-phone center">QL-CLR</th>
                        <th class="hidden-phone center">STYLE</th>
                        <th class="hidden-phone center">ExFac</th>
                        <th class="hidden-phone center">QTY</th>
                    </tr>
                </thead>
                <tbody>
                <?php

                    foreach($prod_summary as $k => $v) {

                ?>
                        <tr>
                            <td class="hidden-phone center"><?php echo $v['so_no'];?></td>
                            <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                            <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                            <td class="hidden-phone center">
                                <span class="btn btn-danger" data-target="#myModal2" data-toggle="modal" onclick="getRemainingFinishingAlterPcs('<?php echo $v['so_no']; ?>');">
                                    <?php echo $v['total_finishing_alter_qty']; ?>
                                </span>
                            </td>
                        </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div><!--/table-responsive-->
    </div>

</div><!--/porlets-content-->