<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 35px;
        height: 35px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<!--\\\\\\\ contentpanel start\\\\\\-->
<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>PO LIST FOR PACKAGE READY</h1>
        <h2 class="">PO LIST FOR PACKAGE READY...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">DASHBOARD</a></li>
            <li class="active">PO LIST FOR PACKAGE READY</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <select required class="form-control" id="po_no" name="po_no" onchange="getReadyPackageByPo(id);">
                            <option value="">SO_PO_Item_Quality_Color_ExFacDate</option>
                            <?php

                            foreach ($purchase_order_nos as $pos){ ?>
                                <option value="<?php echo $pos['so_no'].'_'.$pos['po_no'].'_'.$pos['purchase_order'].'_'.$pos['item'].'_'.$pos['color'].'_'.$pos['ex_factory_date'];?>"><?php echo $pos['so_no'].'_'.$pos['po_no'].'_'.$pos['purchase_order'].'_'.$pos['item'].'_'.$pos['quality'].'_'.$pos['color'].'_'.$pos['ex_factory_date'];?></option>
                                <?php
                            }
                            //                            ?>
                        </select>
                        <span style="font-size: 11px;">* Select SO_PO_Item_Quality_Color_ExFacDate</span>
                    </div>
                </div>
                <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>

            </div>
        </div>
    </div>
    <br />

    <div class="row" id="report_content">
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
            <?php foreach($pending_po_package_list as $k => $v){

                ?>
                <tr>
                    <td class="hidden-phone center">
                        <?php echo $v['purchase_order'].'-'.$v['item'];?>
                    </td>
                    <td class="hidden-phone center"><?php echo $v['so_no'];?></td>
                    <td class="hidden-phone center"><?php echo $v['brand'];?></td>
                    <td class="hidden-phone center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                    <td class="hidden-phone center"><?php echo $v['quality'].'-'.$v['color'];?></td>
                    <td class="hidden-phone center"><?php echo $v['total_order_qty'];?></td>
                    <td class="hidden-phone center"><?php echo $v['ex_factory_date'];?></td>
<!--                    <td class="hidden-phone center">--><?php //echo $v['bundle_start'].'-'.$v['bundle_end'];?><!--</td>-->
                    <!--                            <td class="hidden-phone center">--><?php //echo $v['min_care_label'].'-'.$v['max_care_label'];?><!--</td>-->
                    <td class="hidden-phone center"><?php echo $v['total_cut_qty'];?></td>
                    <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Package');" style="<?php if(($v['count_package_ready_qty'] >= $v['total_cut_qty']) && ($v['count_package_ready_qty'] != '') && ($v['count_cutting_collar_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                        <span style="color: white; font-size: 15px;"><?php echo $v['count_package_ready_qty'];?></span>
                    </td>
                    <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Collar');" style="<?php if(($v['count_cutting_collar_bundle_qty'] >= $v['total_cut_qty']) && ($v['count_cutting_collar_bundle_qty'] != '') && ($v['count_cutting_collar_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                        <span style="color: white; font-size: 15px;"><?php echo $v['count_cutting_collar_bundle_qty'];?></span>
                    </td>
                    <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Cuff');" style="<?php if(($v['count_cutting_cuff_bundle_qty'] >= $v['total_cut_qty']) && ($v['count_cutting_cuff_bundle_qty'] != '') && ($v['count_cutting_cuff_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                        <span style="color: white; font-size: 15px;"><?php echo $v['count_cutting_cuff_bundle_qty'];?></span>
                    </td>
                    <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Back');" style="<?php if(($v['count_cutting_back_bundle_qty'] >= $v['total_cut_qty']) && ($v['count_cutting_back_bundle_qty'] != '') && ($v['count_cutting_back_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                        <span style="color: white; font-size: 15px;"><?php echo $v['count_cutting_back_bundle_qty'];?></span>
                    </td>
                    <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Yoke');" style="<?php if(($v['count_cutting_yoke_bundle_qty'] >= $v['total_cut_qty']) && ($v['count_cutting_yoke_bundle_qty'] != '') && ($v['count_cutting_yoke_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                        <span style="color: white; font-size: 15px;"><?php echo $v['count_cutting_yoke_bundle_qty'];?></span>
                    </td>
                    <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Sleeve');" style="<?php if(($v['count_cutting_sleeve_bundle_qty'] >= $v['total_cut_qty']) && ($v['count_cutting_sleeve_bundle_qty'] != '') && ($v['count_cutting_sleeve_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                        <span style="color: white; font-size: 15px;"><?php echo $v['count_cutting_sleeve_bundle_qty'];?></span>
                    </td>
                    <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Slv Plkt');" style="<?php if(($v['count_cutting_sleeve_plkt_bundle_qty'] >= $v['total_cut_qty']) && ($v['count_cutting_sleeve_plkt_bundle_qty'] != '') && ($v['count_cutting_sleeve_plkt_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                        <span style="color: white; font-size: 15px;"><?php echo $v['count_cutting_sleeve_plkt_bundle_qty'];?></span>
                    </td>
                    <td class="hidden-phone center" data-target="#myModal2" data-toggle="modal" onclick="getRemainingPart('<?php echo $package_info[0]['po_no'];?>', '<?php echo $package_info[0]['so_no'];?>', '<?php echo $package_info[0]['purchase_order']; ?>','<?php echo $package_info[0]['item']; ?>','<?php echo $package_info[0]['quality']; ?>','<?php echo $package_info[0]['color']; ?>' ,'<?php echo $package_info[0]['ex_factory_date']; ?>', 'Pocket');" style="<?php if(($v['count_cutting_pocket_bundle_qty'] >= $v['total_cut_qty']) && ($v['count_cutting_pocket_bundle_qty'] != '') && ($v['count_cutting_pocket_bundle_qty'] != 0)){ ?>background-color: darkgreen;<?php }else{?>background-color: #ff2a27;<?php } ?>">
                        <span style="color: white; font-size: 15px;"><?php echo $v['count_cutting_pocket_bundle_qty'];?></span>
                    </td>

                </tr>
                <?php
                   }
                ?>
                </tbody>
            </table>
        </div><!--/table-responsive-->
    </div>

</div>
<!--\\\\\\\ container  end \\\\\\-->



<script type="text/javascript">
    $('select').select2();

    //    setTimeout(function(){
    //        window.location.reload(1);
    //    }, 5000);

    function getReadyPackageByPo(id) {
        var purchase_order_stuff = $("#"+id).val();
        $("#loader").css("display", "block");
        $("#report_content").empty();

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getReadyPackageByPo/",
            type: "POST",
            data: {purchase_order_stuff: purchase_order_stuff},
            dataType: "html",
            success: function (data) {

                console.log(data);

                $("#report_content").append(data);
                $("#loader").css("display", "none");
            }
        });

    }

    function getWarehousePcs(po_no, purchase_order,item, quality, color, size) {
        $("#wh_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getWarehouseSizePcs/",
            type: "POST",
            data: {po_no: po_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#wh_cl_list").append(data);
            }
        });

    }
</script>