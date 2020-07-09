<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Collar Cuff Scan</h1>
          <h2 class="">Collar Cuff Scan...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Collar Cuff Scan</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <form action="<?php echo base_url();?>access/bundleCollarCuffTracking" method="post">
        <div class="row">
        <div class="col-md-12">

              <div style="padding-top:10px">
                  <h4 style="color:red">
                      <?php
                      $exc = $this->session->userdata('exception');
                      if (isset($exc)) {
                          echo $exc;
                          $this->session->unset_userdata('exception');
                      } ?>
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
               <div class="porlets-content">


               </div>

          </div><!--/block-web--> 
        </div><!--/col-md-12-->
            <div class="row">
                <div class="col-md-1">
                    <input type="text" class="form-control" name="bundle_tracking_no" autofocus required id="bundle_tracking_no" onkeyup="clickToSubmitBtn();" />
                    <button style="display: none;" id="submit_btn" class="btn btn-success">Send</button>
                </div>
                <div class="col-md-11 scroll" id="reload_div">
<!--                    <div class="block-web">-->

<!--                    </div><!--/porlets-content-->
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
                                      <th class="hidden-phone center">Collar</th>
                                      <th class="hidden-phone center">Cuff</th>
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
<!--              <div class="col-md-4">-->
<!--                  <div class="">-->
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
                      <div class="table-responsive" id="remain_bundle_list">

                      </div>
                  </div>
              </div>
          </div>
      </div>

<script type="text/javascript">

    $(document).ready(function(){
        $("#reload_div").load('<?php echo base_url();?>access/bundle_collar_cuff_data');

        $("#message").empty();
    });

    $("#bundle_tracking_no").blur(function(){
        $("#bundle_tracking_no").focus();
    });

    function clickToSubmitBtn() {
        var cl_no = $("#bundle_tracking_no").val();
        var care_label_no = cl_no.trim();

        var last_variable = care_label_no.slice(-1);
        var last_variable_1 = care_label_no.substr(care_label_no.length - 4);

        if((last_variable == '.') && ((last_variable_1 == 'clr.') || (last_variable_1 == 'cff.'))){
            document.getElementById("submit_btn").click();
        }

//        if(care_label_no != '' && last_variable == '.'){
//            document.getElementById("submit_btn").click();
//        }

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


    function getSizeWiseReport(sap_no, po, item, quality, color) {
        $("#size_tbl").empty();
        $("#remain_bundle_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeCCReport/",
            type: "POST",
            data: {po_no: sap_no, purchase_order: po, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
            }
        });
    }

    function getRemainingCollarBundlesBySize(po_no, purchase_order, item, quality, color, size) {
//        alert("Collar "+po_no+' '+purchase_order+' '+item+' '+quality+' '+color+' '+size);

        $("#remain_bundle_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getRemainingCollarBundlesBySize/",
            type: "POST",
            data: {po_no: po_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_bundle_list").append(data);
            }
        });
    }

    function getRemainingCuffBundlesBySize(po_no, purchase_order, item, quality, color, size) {
//        alert("Cuff "+po_no+' '+purchase_order+' '+item+' '+quality+' '+color+' '+size);

        $("#remain_bundle_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getRemainingCuffBundlesBySize/",
            type: "POST",
            data: {po_no: po_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_bundle_list").append(data);
            }
        });
    }
</script>