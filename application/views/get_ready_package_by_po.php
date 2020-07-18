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
<!--                    <th class="hidden-phone center" colspan="1">Range</th>-->
                    <th class="hidden-phone center" colspan="9">Cutting</th>

                </tr>
                <tr>
                    <th class="hidden-phone center">PO-ITEM</th>
                    <th class="hidden-phone center">So No</th>
                    <th class="hidden-phone center">Brand</th>
                    <th class="hidden-phone center">STL</th>
                    <th class="hidden-phone center">QL-CLR</th>
                    <th class="hidden-phone center">Order</th>
                    <th class="hidden-phone center">ExFac</th>
<!--                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Bundle Range">BR</span></th>-->
                    <!--                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Indentity Label Range">INR</span></th>-->
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut QTY">Cut</span></th>
                    <!--                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Pass QTY">CPQ</span></th>-->
                    <!--                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Balance">CBQ</span></th>-->
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Collar">Package</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Collar">Collar</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cuff">Cuff</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cuff">Back</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cuff">Yoke</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cuff">Sleeve</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cuff">Slv-Plkt</span></th>
                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cuff">Pocket</span></th>
                </tr>
                </thead>
                <tbody>
<!--                --><?php //foreach($prod_summary as $k => $v){
//                    if (($v['total_cut_qty'] - $v['count_end_line_qc_pass']) > 0) {
//                    if (date('Y-m-d', strtotime($v['ex_factory_date']. ' + 15 days')) > date('Y-m-d')) {

                        ?>
                        <tr>
                            <td class="hidden-phone center">
                                <?php echo $package_info[0]['purchase_order'].'-'.$package_info[0]['item'];?>
                            </td>
                            <td class="hidden-phone center"><?php echo $package_info[0]['so_no'];?></td>
                            <td class="hidden-phone center"><?php echo $package_info[0]['brand'];?></td>
                            <td class="hidden-phone center"><?php echo $package_info[0]['style_no'].'-'.$package_info[0]['style_name'];?></td>
                            <td class="hidden-phone center"><?php echo $package_info[0]['quality'].'-'.$package_info[0]['color'];?></td>
                            <td class="hidden-phone center"><?php echo $package_info[0]['total_order_qty'];?></td>
                            <td class="hidden-phone center"><?php echo $package_info[0]['ex_factory_date'];?></td>
<!--                            <td class="hidden-phone center">--><?php //echo $package_info[0]['bundle_start'].'-'.$package_info[0]['bundle_end'];?><!--</td>-->
                            <!--                            <td class="hidden-phone center">--><?php //echo $v['min_care_label'].'-'.$v['max_care_label'];?><!--</td>-->
                            <td class="hidden-phone center"><?php echo $package_info[0]['total_cut_qty'];?></td>
                            <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Package');" style="<?php if(($package_info[0]['count_package_ready_qty'] >= $package_info[0]['total_cut_qty']) && ($package_info[0]['count_package_ready_qty'] != '') && ($package_info[0]['count_cutting_collar_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                                <span style="color: white; font-size: 15px;"><?php echo $package_info[0]['count_package_ready_qty'];?></span>
                            </td>
                            <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Collar');" style="<?php if(($package_info[0]['count_cutting_collar_bundle_qty'] >= $package_info[0]['total_cut_qty']) && ($package_info[0]['count_cutting_collar_bundle_qty'] != '') && ($package_info[0]['count_cutting_collar_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                                <span style="color: white; font-size: 15px;"><?php echo $package_info[0]['count_cutting_collar_bundle_qty'];?></span>
                            </td>
                            <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Cuff');" style="<?php if(($package_info[0]['count_cutting_cuff_bundle_qty'] >= $package_info[0]['total_cut_qty']) && ($package_info[0]['count_cutting_cuff_bundle_qty'] != '') && ($package_info[0]['count_cutting_cuff_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                                <span style="color: white; font-size: 15px;"><?php echo $package_info[0]['count_cutting_cuff_bundle_qty'];?></span>
                            </td>
                            <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Back');" style="<?php if(($package_info[0]['count_cutting_back_bundle_qty'] >= $package_info[0]['total_cut_qty']) && ($package_info[0]['count_cutting_back_bundle_qty'] != '') && ($package_info[0]['count_cutting_back_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                                <span style="color: white; font-size: 15px;"><?php echo $package_info[0]['count_cutting_back_bundle_qty'];?></span>
                            </td>
                            <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Yoke');" style="<?php if(($package_info[0]['count_cutting_yoke_bundle_qty'] >= $package_info[0]['total_cut_qty']) && ($package_info[0]['count_cutting_yoke_bundle_qty'] != '') && ($package_info[0]['count_cutting_yoke_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                                <span style="color: white; font-size: 15px;"><?php echo $package_info[0]['count_cutting_yoke_bundle_qty'];?></span>
                            </td>
                            <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Sleeve');" style="<?php if(($package_info[0]['count_cutting_sleeve_bundle_qty'] >= $package_info[0]['total_cut_qty']) && ($package_info[0]['count_cutting_sleeve_bundle_qty'] != '') && ($package_info[0]['count_cutting_sleeve_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                                <span style="color: white; font-size: 15px;"><?php echo $package_info[0]['count_cutting_sleeve_bundle_qty'];?></span>
                            </td>
                            <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Slv Plkt');" style="<?php if(($package_info[0]['count_cutting_sleeve_plkt_bundle_qty'] >= $package_info[0]['total_cut_qty']) && ($package_info[0]['count_cutting_sleeve_plkt_bundle_qty'] != '') && ($package_info[0]['count_cutting_sleeve_plkt_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                                <span style="color: white; font-size: 15px;"><?php echo $package_info[0]['count_cutting_sleeve_plkt_bundle_qty'];?></span>
                            </td>
                            <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Pocket');" style="<?php if(($package_info[0]['count_cutting_pocket_bundle_qty'] >= $package_info[0]['total_cut_qty']) && ($package_info[0]['count_cutting_pocket_bundle_qty'] != '') && ($package_info[0]['count_cutting_pocket_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                                <span style="color: white; font-size: 15px;"><?php echo $package_info[0]['count_cutting_pocket_bundle_qty'];?></span>
                            </td>

                        </tr>
                        <?php
//                    }
//                }
                ?>
                </tbody>
            </table>
        </div><!--/table-responsive-->
    </div>

</div><!--/porlets-content-->

<script type="text/javascript">


    function getRemainingPart(po_no, so_no, po, item, quality, color, ex_factory_date, part) {

        $("#remain_cl_list").empty();

//        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getRemainingPart/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: po, item: item, quality: quality, color: color, ex_factory_date: ex_factory_date, part: part},
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