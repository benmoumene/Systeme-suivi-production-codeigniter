<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Print Sticker</h1>
        <h2 class="">Print Sticker...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Print Sticker</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/rediSamePage" method="post">
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



                <!--              <div class="col-md-3">-->
                <!--                  <input type="text" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />-->
                <!---->
                <!--<!--                  <input type="text" class="form-control" name="cut_tracking_no_1" required id="cut_tracking_no_1" />-->
                <!--<!--                  <span id="er_msg" style="color: red;"></span>-->
                <!--<!--                  <span id="s_msg" style="color: green;"></span>-->
                <!--              </div>-->
                <!--              <div class="col-md-3">-->
                <!--                  <button style="display: none;" id="submit_btn" class="btn btn-success">Send</button>-->
                <!--              </div>-->

            </div><!--/block-web-->
        </div><!--/col-md-12-->
        <div class="row">
            <div class="col-md-1">
                <input type="text" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />
                <button style="display: none;" id="submit_btn" class="btn btn-success">Send</button>
            </div>
            <div class="col-md-11 scroll">
                <div class="block-web">

                    <div class="porlets-content">

                        <div class="table-responsive">
                            <table class="display table table-bordered table-striped" id="">
                                <thead>
                                <tr>
                                    <th class="hidden-phone" colspan="6"></th>
                                    <th class="hidden-phone center" colspan="3">Cutting</th>
                                    <th class="hidden-phone center" colspan="2">Range</th>
                                    <th class="hidden-phone center" colspan="4">Sewing</th>
                                    <th class="hidden-phone center" colspan="3">Finishing</th>
                                </tr>
                                <tr>
                                    <th class="hidden-phone center">PO-ITEM</th>
                                    <th class="hidden-phone center">Brand</th>
                                    <th class="hidden-phone center">STL</th>
                                    <th class="hidden-phone center">QL-CLR</th>
                                    <th class="hidden-phone center">OQ</th>
                                    <th class="hidden-phone center">ExFac</th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut QTY">CQ</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Balance">CBQ</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Pass QTY">CPQ</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Bundle Range">BR</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Care Label Range">CR</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Line Input">IN</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Collar Cuff">CC</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Mid-Line Pass QTY">MPQ</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="End-Line Pass QTY">EPQ</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Wash QTY">WQ</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Pack QTY">PQ</span></th>
                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Balance QTY">BQ</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($prod_summary as $k => $v) {
                                    if (($v['total_cut_qty'] - $v['count_packing_pass']) != 0) {
                                        ?>
                                        <tr>
                                            <td class="hidden-phone center"><span
                                                        style="color: #727dff; cursor: pointer;"
                                                        onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></span>
                                            </td>
                                            <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['total_cut_qty']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['total_cut_qty'] - $v['total_cut_input_qty']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['total_cut_input_qty']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['bundle_start'] . '-' . $v['bundle_end']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['min_care_label'] . '-' . $v['max_care_label']; ?></td>
                                            <td class="hidden-phone center" style="background-color: darkgreen;">
                                                <span style="color: white; font-size: 20px;"><?php echo $v['count_input_qty_line']; ?></span>
                                            </td>
                                            <td class="hidden-phone center"><?php echo $v['collar_cuff_bndl_qty']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['count_mid_line_qc_pass']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['count_end_line_qc_pass']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['count_washing_pass']; ?></td>
                                            <td class="hidden-phone center"><?php echo $v['count_packing_pass']; ?></td>
                                            <td class="hidden-phone center">
                                                <a target="_blank" href="<?php echo base_url(); ?>access/remainQtyStatus/<?php echo $v['po_no'];?>/<?php echo $v['purchase_order']; ?>/<?php echo $v['item']; ?>/4"><?php echo $v['total_cut_qty'] - $v['count_packing_pass']; ?></a>
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
            </div><!--/block-web-->
        </div><!--/col-md-12-->
    </form>
    <div class="row">
        <div class="col-md-8 scroll2">
            <div class="block-web">

                <div class="porlets-content">

                    <div class="table-responsive" id="size_tbl">
                        <table class="display table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="hidden-phone center">Size</th>
                                <th class="hidden-phone center">Ordered Qty</th>
                                <th class="hidden-phone center">End Line Qty</th>
                                <th class="hidden-phone center">Packing Qty</th>
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
        <div class="col-md-4">
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
        $("#message").empty();
    });

    $("#carelabel_tracking_no").blur(function(){
        $("#carelabel_tracking_no").focus();
    });

    function clickToSubmitBtn() {
        var cl_no = $("#carelabel_tracking_no").val();
        var care_label_no = cl_no.trim();

        var last_variable = care_label_no.slice(-1);

        if (care_label_no != '' && last_variable == '.'){
            document.getElementById("submit_btn").click();
        }
    }

</script>