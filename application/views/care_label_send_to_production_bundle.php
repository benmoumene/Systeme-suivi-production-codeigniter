<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>CUTTING INPUT POINT</h1>
          <h2 class="">CUTTING INPUT POINT...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">CUTTING INPUT POINT</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <form action="<?php echo base_url();?>access/sendingToProductionForBundle" method="post">
          <div class="row">
        <div class="col-md-12">
            <div style="padding-top:10px">
                <h6 style="color:red">
                    <?php
                    $exc = $this->session->userdata('exception');
                    if (isset($exc)) {
                        echo $exc;
                        $this->session->unset_userdata('exception');
                    }
                    ?>
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

          </div><!--/block-web--> 
        </div><!--/col-md-12-->
            <div class="row">
                <div class="col-md-1">
                    <input type="text" class="form-control" name="bundle_tracking_no" autofocus required id="bundle_tracking_no" onkeyup="clickToSubmitBtn();" />
                    <button style="display: none;" id="submit_btn" class="btn btn-success" onclick="sendToProduction()">Send</button>
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
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Mid-Line QTY">MQ</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="End-Line QTY">EQ</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Finishing QTY">FQ</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Packing QTY">PQ</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Balance QTY">BQ</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($prod_summary as $k => $v){ ?>
                                        <tr>
                                            <td class="hidden-phone center">
                                                <span style="color: #727dff; cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>');"><?php echo $v['purchase_order'].'-'.$v['item'];?></span>
                                            </td>
                                            <td class="hidden-phone center"><?php echo $v['brand'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['quality'].'-'.$v['color'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['total_order_qty'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['ex_factory_date'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['total_cut_qty'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['total_cut_qty']-$v['total_cut_input_qty'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['total_cut_input_qty'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['bundle_start'].'-'.$v['bundle_end'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['min_care_label'].'-'.$v['max_care_label'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['count_input_qty_line'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['collar_cuff_bndl_qty'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['count_mid_line_qc_pass'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['count_end_line_qc_pass'];?></td>
                                            <td class="hidden-phone center"></td>
                                            <td class="hidden-phone center"></td>
                                            <td class="hidden-phone center"><a target="_blank" href="<?php echo base_url();?>access/remainQtyStatus/<?php echo $v['purchase_order'];?>/<?php echo $v['item'];?>/4"><?php echo $v['total_cut_qty'] - $v['count_end_line_qc_pass'];?></a></td>
                                        </tr>
                                    <?php } ?>
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
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr>
                                      <td class="hidden-phone center"></td>
                                      <td class="hidden-phone center"></td>
                                      <td class="hidden-phone center"></td>
                                  </tr>
                                  </tbody>
                              </table>
                          </div><!--/table-responsive-->
                      </div>

                  </div><!--/porlets-content-->
              </div>
              <div class="col-md-4">
                  <div class="block-web">

                      <div class="porlets-content">

                          <div class="table-responsive">
                              <table class="display table table-bordered table-striped" id="">
                                  <thead>
                                  <tr>
                                      <th class="hidden-phone center"><a target="_blank" href="<?php echo base_url();?>access/poWiseCuttingReport" class="btn btn-danger">Cutting</a></th>
                                      <th class="hidden-phone center" colspan="2"><a target="_blank" href="<?php echo base_url();?>access/lineWisePoItemReport" class="btn btn-primary">LINE</a></th>
                                  </tr>
                                  <tr>
                                      <th class="hidden-phone center"><a href="" class="btn btn-warning">FN</a></th>
                                      <th class="hidden-phone center" colspan="2"><a href="" class="btn btn-success">Packing</a></th>
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


    $("#bundle_tracking_no").blur(function(){
        $("#bundle_tracking_no").focus();
    });

    function clickToSubmitBtn() {
        var bndle_no = $("#bundle_tracking_no").val();
        var bundle_no = bndle_no.trim();

        var last_variable = bundle_no.slice(-1);

        if(bundle_no != '' && last_variable == '.'){
            document.getElementById("submit_btn").click();
        }

//        if(last_variable == '.'){
////            $.ajax({
////                type: "POST",
////                url: "<?php ////echo base_url();?>////access/sendingToProductionForCareLabel/",
////                data: {care_label_no: care_label_no},
////                dataType: "html",
////                success: function (data) {
////                        console.log(data);
////                        $("#carelabel_tracking_no").val('');
////                        $("#s_msg").text('Successfully Sent!');
////                        $("#er_msg").text('');
////                }
////            });
//        }
//        else{
//            $("#s_msg").text('');
//            $("#er_msg").text('Failed to Send!');
//            $("#carelabel_tracking_no").val('');
//        }
    }

//    function sendToProduction() {
//        var cl_no = $("#carelabel_tracking_no").val();
//
//        if(cl_no != ''){
//            $.ajax({
//                type: "POST",
//                url: "<?php //echo base_url();?>//access/sendingToProductionForCareLabel/",
//                data: {care_label_no: cl_no},
//                dataType: "html",
//                success: function (data) {
//                    $("#carelabel_tracking_no").val('');
//                    $("#s_msg").text('Successfully Sent!');
//                    $("#er_msg").text('');
//                }
//            });
//        }else{
//            $("#s_msg").text('');
//            $("#er_msg").text('Failed to Send!');
//            $("#carelabel_tracking_no").val('');
//        }
//    }


    function getSizeWiseReport(po, item) {
        $("#size_tbl").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeReport/",
            type: "POST",
            data: {purchase_order: po, item: item},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
            }
        });
    }

</script>