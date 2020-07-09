<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Dashboard</h1>
          <h2 class="">Dashboard...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Dashboard</li>
          </ol>
        </div>
      </div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="header">
        <div class="actions"> <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button> </div>
    </div>
        <div class="row">
            <div class="col-md-12">

                <div style="padding-top:10px">
                    <h6 style="color:red">
                        <?php
                        $exc = $this->session->userdata('exception');
                        if (isset($exc)) {
                            echo $exc;
                            $this->session->unset_userdata('exception');
                        } ?>
                    </h6>

                    <h6 style="color:green">
                        <?php
                        $msg = $this->session->userdata('message');
                        if (isset($msg)) {
                            echo $msg;
                            $this->session->unset_userdata('message');
                        }
                        ?>
                    </h6>
                </div>
                <div class="porlets-content">


                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->

        <div class="row" style="font-size: 25px;">


            <div  id="reload_div">
                <div class="col-md-12 well" id="tableWrap">
                    <table class="table table-scroll table-striped" border="1">
                        <thead>
                        <tr>
                            <th class="" colspan="6" style="width: 41.4%"></th>
                            <th class="" colspan="3" style="text-align: center;">Cutting</th>
                            <th class="" colspan="2" style="text-align: center;">Range</th>
                            <th class="" colspan="5" style="text-align: center;">Sewing</th>
                            <th class="" colspan="5" style="text-align: center;">Finishing</th>
                        </tr>
                        <tr>
                            <th class="" style="width: 10%"><span data-toggle="tooltip" title="PO-ITEM">PO-ITEM</span></th>
                            <th class=""><span data-toggle="tooltip" title="Brand">Brand</span></th>
                            <th class="" style="width: 9.9%"><span data-toggle="tooltip" title="Style">STL</span></th>
                            <th class="" style="width: 10%"><span data-toggle="tooltip" title="Quality-Color">QL-CLR</span></th>
                            <th class=""><span data-toggle="tooltip" title="Order Qty">OQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Ex-Factory Date">ExFac</span></th>
                            <th class=""><span data-toggle="tooltip" title="Cut QTY">CQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Cut Balance">CBQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Cut Pass QTY">CPQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Bundle Range">BR</span></th>
                            <th class=""><span data-toggle="tooltip" title="Identity Number Range">INR</span></th>
                            <th class=""><span data-toggle="tooltip" title="Line Input">IN</span></th>
                            <th class=""><span data-toggle="tooltip" title="Collar">Collar</span></th>
                            <th class=""><span data-toggle="tooltip" title="Cuff">Cuff</span></th>
                            <th class=""><span data-toggle="tooltip" title="Mid-Line Pass QTY">MPQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="End-Line Pass QTY">EPQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Wash QTY">WQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Packing QTY">PQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Carton QTY">CTN</span></th>
                            <th class=""><span data-toggle="tooltip" title="Warehouse QTY">WHQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Balance QTY">BQ</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $cur_date = date('Y-m-d');

                        foreach($prod_summary as $k => $v){

                            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];
                            $total_wh_qa = $v['count_wh_prod_sample'] + $v['count_wh_factory'] + $v['count_wh_buyer'] + $v['count_wh_trash'];


                            if(($v['total_cut_qty'] - $total_finishing_wh_qa) != 0){
                                $ship_date = $v['ex_factory_date'];
                        ?>

                                <tr>
                                    <td class="" style="width: 10%">
                                        <span style="color: #727dff; cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');">
                                            <?php
                                            if($v['item'] != ''){
                                                echo $v['purchase_order'] . '_' . $v['item'];
                                            }else{
                                                echo $v['purchase_order'];
                                            }
                                            ?>
                                        </span>
                                    </td>
                                    <td class=""><?php echo $v['brand'];?></td>
                                    <td class="" style="width: 9.9%"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                                    <td class="" style="width: 10%"><?php echo $v['quality'].'_'.$v['color'];?></td>
                                    <td class=""><?php echo $v['total_order_qty'];?></td>
                                    <td class="" <?php if($cur_date > $ship_date){ ?> style="background-color: #ff481f; color: #fff;" <?php } ?> >
                                        <?php echo $v['ex_factory_date'];?>
                                    </td>
                                    <td class=""><?php echo $v['total_cut_qty'];?></td>
                                    <td class=""><?php echo $v['total_cut_qty']-$v['total_cut_input_qty'];?></td>
                                    <td class=""><?php echo $v['total_cut_input_qty'];?></td>
                                    <td class=""><span style="color: #ffffff;">'</span><?php echo $v['bundle_start'].'-'.$v['bundle_end'];?></td>
                                    <td class=""><?php echo $v['min_care_label'].'-'.$v['max_care_label'];?></td>
                                    <td class="" title="<?php echo $v['min_line_input_date_time'];?>">
                                        <?php echo $v['count_input_qty_line'];?>
                                    </td>
                                    <td class=""><?php echo $v['collar_bndl_qty'];?></td>
                                    <td class=""><?php echo $v['cuff_bndl_qty'];?></td>
                                    <td class=""><?php echo $v['count_mid_line_qc_pass'];?></td>
                                    <td class=""><?php echo $v['count_end_line_qc_pass'];?></td>
                                    <td class="" <?php if($v['wash_gmt'] == 1){ ?> style="background-color: #faff88;" <?php } ?> >
                                        <?php echo $v['count_washing_pass'];?>
                                    </td>
                                    <td class=""><?php echo $v['count_packing_pass'];?></td>
                                    <td class=""><?php echo $v['count_carton_pass'];?></td>
                                    <td class=""><?php echo $total_wh_qa;?></td>
                                    <td class=""><a target="_blank" href="<?php echo base_url();?>dashboard/remainQtyStatus/<?php echo $v['po_no'];?>/<?php echo $v['purchase_order'];?>/<?php echo $v['item'];?>/4"><?php echo $v['total_cut_qty'] - $total_finishing_wh_qa;?></a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div><!--/col-md-12-->
    <div class="row" style="font-size: 20px;">
        <div class="col-md-6 scroll2">
            <div class="block-web">

                <div class="porlets-content">
                    <div class="table-responsive" id="size_tbl">
                        <table class="display table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="center">Size</th>
                                    <th class="center">Order</th>
                                    <th class="center">Cut</th>
                                    <th class="center">End</th>
                                    <th class="center">Wash</th>
                                    <th class="center">Pack</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="hidden-phone center"></td>
                                    <td class="hidden-phone center"></td>
                                    <td class="hidden-phone center"></td>
                                    <td class="hidden-phone center"></td>
                                    <td class="hidden-phone center"></td>
                                    <td class="hidden-phone center"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!--/table-responsive-->
                </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
        <div class="col-md-3">
            <div class="block-web">

                <div class="porlets-content">

                    <div class="table-responsive">
                        <table class="display table table-bordered table-striped" id="">
                            <thead>
                            <tr>
                                <th class="hidden-phone center"><a target="_blank" href="<?php echo base_url();?>dashboard/poWiseCuttingReport" class="btn btn-danger">Cutting</a></th>
                                <th class="hidden-phone center" colspan="2"><a target="_blank" href="<?php echo base_url();?>dashboard/lineWisePoItemReport" class="btn btn-primary">LINE</a></th>
                                <th class="hidden-phone center" colspan="3"><a target="_blank" href="<?php echo base_url();?>dashboard/poWisePackingReport" class="btn btn-success">Packing</a></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div><!--/table-responsive-->
                </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div>

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


<script type="text/javascript">
    $(document).ready(function(){
        setInterval(function(){
            $("#reload_div").load('<?php echo base_url();?>dashboard/getProductionSummaryReportDashboard');
        }, 300000);
    });

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

    function getSizeWiseReport(sap_no, po, item, quality, color) {
        $("#size_tbl").empty();

//        alert(sap_no+'-'+po+'-'+item+'-'+quality+'-'+color);

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeReport/",
            type: "POST",
            data: {po_no: sap_no, purchase_order: po, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
            }
        });
    }

    function getRemainCLs(so_no, purchase_order, item, quality, color, size, access_point) {
        $("#remain_cl_list").empty();


        if(access_point == 1){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainCutSendCL/",
                type: "POST",
                data: {po_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 2){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainInputCL/",
                type: "POST",
                data: {po_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 3){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainMidCL/",
                type: "POST",
                data: {po_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 4){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainEndCL/",
                type: "POST",
                data: {po_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 5){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainWashCL/",
                type: "POST",
                data: {po_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        if(access_point == 7){
            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeRemainPackCL/",
                type: "POST",
                data: {po_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }
    }

</script>