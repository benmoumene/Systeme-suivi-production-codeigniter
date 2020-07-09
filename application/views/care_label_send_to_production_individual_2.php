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
        <form action="<?php echo base_url();?>access/sendingToProductionForCareLabel" method="post">
          <div class="row">
        <div class="col-md-12">
            <div style="padding-top:10px">
                <h4 style="color:red">
                    <?php
                    $exc = $this->session->userdata('exception');
                    if (isset($exc)) {
                        echo $exc;
                        $this->session->unset_userdata('exception');
                    }
                    ?>
                </h4>

                <h4 style="color:green">
                    <?php
                    $msg = $this->session->userdata('message');
                    if (isset($msg)) {
                        echo $msg;
                        $this->session->unset_userdata('message');
                    }
                    ?>
                </h4>
            </div>

          </div><!--/block-web--> 
        </div><!--/col-md-12-->
            <div class="row">
                <div class="col-md-1">
                    <input type="text" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />
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
                                        <th class="hidden-phone center" colspan="2">Range</th>
                                        <th class="hidden-phone center" colspan="3">Cutting</th>
                                    </tr>
                                    <tr>
                                        <th class="hidden-phone center">PO-ITEM</th>
                                        <th class="hidden-phone center">Brand</th>
                                        <th class="hidden-phone center">STL</th>
                                        <th class="hidden-phone center">QL-CLR</th>
                                        <th class="hidden-phone center">OQ</th>
                                        <th class="hidden-phone center">ExFac</th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Bundle Range">BR</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Identity Number Range">INR</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut QTY">Cut</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Pass QTY">Pass</span></th>
                                        <th class="hidden-phone center"><span data-toggle="tooltip" title="Cut Balance">Balance</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($prod_summary as $k => $v) {
                                        if (($v['total_cut_qty'] - $v['total_cut_input_qty']) != 0) {
                                            ?>
                                            <tr>
                                                <td class="hidden-phone center">
                                                    <span style="color: #727dff; cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['purchase_order']; ?>', '<?php echo $v['item']; ?>');"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></span>
                                                </td>
                                                <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['bundle_start'] . '-' . $v['bundle_end']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['min_care_label'] . '-' . $v['max_care_label']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['total_cut_qty']; ?></td>
                                                <td class="hidden-phone center" style="background-color: darkgreen;">
                                                    <span style="color: white;"><?php echo $v['total_cut_input_qty']; ?></span>
                                                </td>
                                                <td class="hidden-phone center" style="background-color: blue;"><span
                                                            style="color: white;"><?php echo $v['total_cut_qty'] - $v['total_cut_input_qty']; ?></span>
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
                                      <th class="center">Size</th>
                                      <th class="center">Order</th>
                                      <th class="center">Cut</th>
                                      <th class="center">Cut Pass</th>
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
              </div>
<!--              <div class="col-md-4">-->
<!--                  <div class="block-web">-->
<!---->
<!--                      <div class="porlets-content">-->
<!---->
<!--                          <div class="table-responsive">-->
<!--                              <table class="display table table-bordered table-striped" id="">-->
<!--                                  <thead>-->
<!--                                  <tr>-->
<!--                                      <th class="hidden-phone center"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/poWiseCuttingReport" class="btn btn-danger">Cutting</a></th>-->
<!--                                      <th class="hidden-phone center" colspan="2"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/lineWisePoItemReport" class="btn btn-primary">LINE</a></th>-->
<!--                                      <th class="hidden-phone center" colspan="3"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/poWisePackingReport" class="btn btn-success">Packing</a></th>-->
<!--                                  </tr>-->
<!--                                  </thead>-->
<!--                                  <tbody>-->
<!---->
<!--                                  </tbody>-->
<!--                              </table>-->
<!--                          </div>-->
<!--                      </div>-->
<!---->
<!--                  </div>-->
<!--              </div>-->

              <div class="col-md-3 scroll4">
                  <div class="porlets-content">
                      <div class="table-responsive" id="remain_cl_list">

                      </div>
                  </div>
              </div>

          </div><!--/col-md-12-->
      </div>

<script type="text/javascript">


    $("#carelabel_tracking_no").blur(function(){
        $("#carelabel_tracking_no").focus();
    });

    function clickToSubmitBtn() {
        var cl_no = $("#carelabel_tracking_no").val();
        var care_label_no = cl_no.trim();

        var last_variable = care_label_no.slice(-1);

        if(care_label_no != '' && last_variable == '.'){
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


    function getSizeWiseReport(so_no, po, item) {
        $("#size_tbl").empty();
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeCutReport/",
            type: "POST",
            data: {po_no: so_no, purchase_order: po, item: item},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
            }
        });
    }

    function getRemainCLs(so_no, purchase_order, item, quality, color, size) {
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeRemainCutSendCL/",
            type: "POST",
            data: {po_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }

</script>