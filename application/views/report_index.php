<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
<!--          <h1>Dashboard</h1>-->
<!--          <h2 class="">Dashboard...</h2>-->
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="javascript:void(0);" onclick="window.location.reload(1);"> <i class="fa fa-repeat"></i> </a></li>
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
                            <th class="" colspan="6" style="width: 43.4%"></th>
                            <th class="" colspan="3" style="text-align: center;">Cutting</th>
                            <th class="" colspan="2" style="text-align: center;">Range</th>
                            <th class="" colspan="4" style="text-align: center;">Sewing</th>
                            <th class="" colspan="3" style="text-align: center;">Finishing</th>
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
                            <th class=""><span data-toggle="tooltip" title="Collar Cuff">CC</span></th>
                            <th class=""><span data-toggle="tooltip" title="Mid-Line Pass QTY">MPQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="End-Line Pass QTY">EPQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Wash QTY">WQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Packing QTY">PQ</span></th>
                            <th class=""><span data-toggle="tooltip" title="Packing Balance QTY">PBQ</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($prod_summary as $k => $v){
                            if(($v['count_input_qty_line'] - $v['count_end_line_qc_pass']) != 0){
                                ?>

                                <tr>
                                    <td class="" style="width: 10%"><span style="color: #727dff; cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');"><?php echo $v['purchase_order'].'-'.$v['item'];?></span></td>
                                    <td class=""><?php echo $v['brand'];?></td>
                                    <td class="" style="width: 9.9%"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                                    <td class="" style="width: 10%"><?php echo $v['quality'].'-'.$v['color'];?></td>
                                    <td class=""><?php echo $v['total_order_qty'];?></td>
                                    <td class=""><?php echo $v['ex_factory_date'];?></td>
                                    <td class=""><?php echo $v['total_cut_qty'];?></td>
                                    <td class=""><?php echo $v['total_cut_qty']-$v['total_cut_input_qty'];?></td>
                                    <td class=""><?php echo $v['total_cut_input_qty'];?></td>
                                    <td class=""><span style="color: #ffffff;">'</span><?php echo $v['bundle_start'].'-'.$v['bundle_end'];?></td>
                                    <td class=""><?php echo $v['min_care_label'].'-'.$v['max_care_label'];?></td>
                                    <td class=""><?php echo $v['count_input_qty_line'];?></td>
                                    <td class=""><?php echo $v['collar_cuff_bndl_qty'];?></td>
                                    <td class=""><?php echo $v['count_mid_line_qc_pass'];?></td>
                                    <td class=""><?php echo $v['count_end_line_qc_pass'];?></td>
                                    <td class="" <?php if($v['wash_gmt'] == 1){ ?> style="background-color: #faff88;" <?php } ?> >
                                        <?php echo $v['count_washing_pass'];?>
                                    </td>
                                    <td class=""><?php echo $v['count_packing_pass'];?></td>
                                    <td class=""><a target="_blank" href="<?php echo base_url();?>dashboard/remainQtyStatus/<?php echo $v['po_no'];?>/<?php echo $v['purchase_order'];?>/<?php echo $v['item'];?>/4"><?php echo $v['total_cut_qty'] - $v['count_packing_pass'];?></a></td>
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
                                    <th class="hidden-phone center">Size</th>
                                    <th class="hidden-phone center">Ordered Qty</th>
                                    <th class="hidden-phone center">End Line Qty</th>
                                    <th class="center">Packing Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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

<script type="text/javascript">
    $(document).ready(function(){
        setInterval(function(){
            $("#reload_div").load('<?php echo base_url();?>access/getProductionSummaryReportByUID');
        }, 10000);

        setInterval(function() {
            window.location.reload();
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

</script>