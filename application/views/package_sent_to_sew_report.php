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
                    <th class="hidden-phone center" colspan="1">Range</th>
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
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Bundle Range">BR</span></th>
                    <!--                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Indentity Label Range">INR</span></th>-->
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut QTY">Cut</span></th>
                    <!--                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Pass QTY">CPQ</span></th>-->
                    <!--                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Balance">CBQ</span></th>-->
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Collar">Package Rdy Qty</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cuff">Package Sent To Sew</span></th>


                </tr>
                </thead>
                <tbody>
                <?php foreach($prod_summary as $k => $v){
//                    if (($v['total_cut_qty'] - $v['count_end_line_qc_pass']) > 0) {
//                    if (date('Y-m-d', strtotime($v['ex_factory_date']. ' + 25 days')) > date('Y-m-d')) {

                        ?>
                        <tr>
                            <td class="hidden-phone center">
                                <span style="color: #727dff; cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>','<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');"><?php echo $v['purchase_order'].'-'.$v['item'];?></span>
                            </td>
                            <td class="hidden-phone center"><?php echo $line_code;?></td>
                            <td class="hidden-phone center"><?php echo $v['brand'];?></td>
                            <td class="hidden-phone center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                            <td class="hidden-phone center"><?php echo $v['quality'].'-'.$v['color'];?></td>
                            <td class="hidden-phone center"><?php echo $v['total_order_qty'];?></td>
                            <td class="hidden-phone center"><?php echo $v['ex_factory_date'];?></td>
                            <td class="hidden-phone center"><?php echo $v['bundle_start'].'-'.$v['bundle_end'];?></td>
                            <!--                            <td class="hidden-phone center">--><?php //echo $v['min_care_label'].'-'.$v['max_care_label'];?><!--</td>-->
                            <td class="hidden-phone center"><?php echo $v['total_cut_qty'];?></td>
                            <td class="hidden-phone center"><?php echo $v['pkg_rdy_qty'];?></td>
                            <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPackage('<?php echo $v['po_no'];?>', '<?php echo $v['so_no'];?>', '<?php echo $v['purchase_order']; ?>','<?php echo $v['item']; ?>','<?php echo $v['quality']; ?>','<?php echo $v['color']; ?>' ,'<?php echo $v['ex_factory_date']; ?>');" style="<?php if(($v['pkg_sew_qty'] >= $v['pkg_rdy_qty']) && ($v['pkg_sew_qty'] != '') && ($v['pkg_sew_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                                <span style="color: white; font-size: 15px;"><?php echo $v['pkg_sew_qty'];?></span>
                            </td>


                        </tr>
                        <?php
//                    }
                }
                ?>
                </tbody>
            </table>
        </div><!--/table-responsive-->
    </div>

</div><!--/porlets-content-->

<script type="text/javascript">


    function getRemainingPackage(po_no, so_no, po, item, quality, color, ex_factory_date) {

        $("#remain_cl_list").empty();

//        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>access/getRemainingPackage/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: po, item: item, quality: quality, color: color, ex_factory_date: ex_factory_date},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
                $("#loader").css("display", "none");
            }
        });
    }












    function getSizeWiseReport(po_no, so_no, po, item, quality, color) {
        $("#size_tbl").empty();

        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeEndPassReport/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: po, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
                $("#loader").css("display", "none");
            }
        });
    }

    function getRemainCLs(po_no, so_no, purchase_order, item, quality, color, size) {
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeRemainEndCL/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }

    function getRemainingLinePcs(po_no, so_no, purchase_order, item, quality, color) {
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getRemainingLineOutputPcs/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }
</script>