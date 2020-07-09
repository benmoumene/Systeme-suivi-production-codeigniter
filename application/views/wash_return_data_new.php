<div class="block-web">

    <div class="porlets-content">

        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>

                    <div class="modal-body">
                        <div class="col-md-3 scroll4">
                            <div class="porlets-content">
                                <div class="table-responsive" id="remain_cl_list">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                        <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
                    </div>

                </div>
            </div>
        </div>



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
                    if (($v['count_wash_going_qty'] - ($v['count_washing_pass']+$v['count_manual_close_qty'])) > 0) {
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
                            <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                            <td class="hidden-phone center" style="color: #ffffff; font-size: 20px; background-color: darkblue;"><?php echo $v['count_wash_going_qty']; ?></td>
                            <td class="hidden-phone center" <?php if($v['count_wash_going_qty'] > $v['count_washing_pass']){ ?>style="background-color: red;" <?php } ?> <?php if($v['count_wash_going_qty'] <= $v['count_washing_pass']){ ?>style="background-color: darkgreen;" <?php } ?>>
                                <span style="color: white; font-size: 20px;"><?php echo $v['count_washing_pass']; ?></span>
                            </td>
<!--                            <td class="hidden-phone center">-->
<!--                                --><?php //echo $v['count_wash_going_qty'] - $v['count_washing_pass']; ?>
<!--                            </td>-->

                            <td class="hidden-phone center">
                                <span class="btn btn-danger" data-target="#myModal2" data-toggle="modal" onclick="getRemainCLs('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order']; ?>','<?php echo $v['item']; ?>','<?php echo $v['quality']; ?>','<?php echo $v['color']; ?>')">
                                    <?php echo $v['count_wash_going_qty'] - $v['count_washing_pass']; ?>
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

<script type="text/javascript">



    function getRemainCLs(po_no, so_no, purchase_order, item, quality, color, size) {
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeRemainWashReturnCL/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }
</script>