<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 20px;
        height: 20px;
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
<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Piece By Piece Scan</h1>
            <a href="<?php echo base_url();?>access/collar_cuff_send_to_production" id="bundle_scan_tab" class="btn btn-primary">Bundle Scan</a>
            <a href="<?php echo base_url();?>access/package_send_to_sew" class="btn btn-warning">INPUT To SEW</a>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Piece By Piece Scan</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
<!--        <form action="--><?php //echo base_url();?><!--access/sendingToProductionForCareLabel" method="post">-->
          <div class="row">
        <div class="col-md-12">
            <div style="padding-top:10px">
                <h6 style="color:red" id="err_msg"></h6>

                <h6 style="color:green" id="suc_msg"></h6>
            </div>

          </div><!--/block-web--> 
        </div><!--/col-md-12-->
            <div class="row">
                <div class="col-md-2">
                    <select class="form-control" name="line_no" id="line_no" style="font-size: 18px;">
                        <option value="" id="blank">Line...</option>
                        <?php foreach ($lines as $lns){ ?>
                            <option value="<?php echo $lns['id'];?>"><?php echo $lns['line_name'];?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                    <!--                    <button style="display: none;" id="submit_btn" class="btn btn-success" onclick="sendToProduction()">Send</button>-->
                </div>
                <div class="col-md-1">
                    <input type="text" class="form-control" name="carelabel_tracking_no" autofocus id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />

                    <br />
                    <br />
                    <span style="margin-top: 30px;" id="refresh_report" class="btn btn-success" onclick="getCuttingReportIndividual();">Report</span>

                </div>
                <div class="col-md-3">
                    <div class="block-web scroll3">
                        <div class="porlets-content">

                            <div class="table-responsive">
                                <table class="display table table-bordered table-striped" id="bundle_tbl">
                                    <thead>
                                    <tr>
                                        <th class="hidden-phone center">Identity Number</th>
                                    </tr>
                                    </thead>
                                    <tbody id="bundle_tbl_bdy">

                                    </tbody>
                                </table>
                            </div><!--/table-responsive-->
                        </div>
                    </div>

                </div><!--/block-web-->
                <div class="col-md-2">
                </div>

                <div class="col-md-1">
                    <button id="submit_btn" class="btn btn-lg btn-success" onclick="sendingToProduction();">Save</button>
                </div>
                <div class="col-md-3">
                    <div class="block-web scroll5">
                            <div class="porlets-content">

                                <div class="table-responsive" id="">
                                    <table class="display table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="center" style="color: red;">Failed INR List</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $res = $this->session->userdata('cl_list_array');
                                        if (isset($res)) {
                                        ?>
                                        <?php
                                            foreach ($res as $v){ ?>
                                                <tr>
                                                    <td class="hidden-phone center"><?php echo $v;?></td>
                                                </tr>
                                        <?php    }
                                        ?>
                                        <?php    $this->session->unset_userdata('cl_list_array');
                                        }
                                        ?>

                                        </tbody>
                                    </table>
                                </div><!--/table-responsive-->
                            </div>
                    </div>
                </div>
            </div><!--/col-md-12-->
<!--        </form>-->

          <div class="row">
              <div class="col-md-12">
                  <div class="block-web scroll6" id="reload_div">



                  </div><!--/porlets-content-->
              </div><!--/block-web-->
<!--              <div class="col-md-5 scroll4" style="margin-left: 40px;">-->
<!--                  <div class="block-web">-->
<!---->
<!--                      <div class="porlets-content">-->
<!---->
<!--                          <div class="table-responsive" id="size_tbl">-->
<!--                              <table class="display table table-bordered table-striped">-->
<!--                                  <thead>-->
<!--                                  <tr>-->
<!--                                      <th class="center">Size</th>-->
<!--                                      <th class="center">Order</th>-->
<!--                                      <th class="center">Cut</th>-->
<!--                                      <th class="center">Cut Pass</th>-->
<!--                                  </tr>-->
<!--                                  </thead>-->
<!--                                  <tbody>-->
<!--                                  <tr>-->
<!--                                      <td class="hidden-phone center"></td>-->
<!--                                      <td class="hidden-phone center"></td>-->
<!--                                      <td class="hidden-phone center"></td>-->
<!--                                      <td class="hidden-phone center"></td>-->
<!--                                  </tr>-->
<!--                                  </tbody>-->
<!--                              </table>-->
<!--                          </div>-->
<!--                      </div>-->
<!---->
<!--                  </div>-->
<!--              </div>-->
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
                      <div class="table-responsive" id="">

                      </div>
                  </div>
              </div>

          </div><!--/col-md-12-->
      </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
//    $('select').select2();

    $(document).ready(function(){
    //        $("#reload_div").load('<?php //echo base_url();?>//access/line_input_prod_data');

        setInterval(function(){

            $.ajax({
                url: "<?php echo base_url();?>access/checkSession/", //Change this URL as per your settings
                type: "POST",
                data: {},
                dataType: "html",
                success: function(newVal) {
                    if (newVal == ''){
                        location.reload(true);
                    }
                }
            });


        }, 60000);

        $("#message").empty();
    });

    $("#carelabel_tracking_no").blur(function(){
        $("#carelabel_tracking_no").focus();
    });

    function clickToSubmitBtn() {
        var cl_no = $("#carelabel_tracking_no").val();
        var care_label_no = cl_no.trim();

        var last_variable = care_label_no.slice(-1);

        var cl_array = [];

        if(care_label_no != '' && last_variable == '.'){
//            document.getElementById("submit_btn").click();

            $("input[name='cl_codes[]']").each(function() {
                cl_array.push($(this).val());
            });
            var index_find = cl_array.indexOf(cl_no);

            $("#suc_msg").empty();
            $("#err_msg").empty();

            if(index_find < 0){
                $("#bundle_tbl_bdy").append('<tr><td><input type="text" name="cl_codes[]" id="cl_codes" class="form-control" value="'+cl_no+'" /></td></tr>');
                $("#carelabel_tracking_no").val('');
                $("#suc_msg").append(care_label_no+" Successfully Added!");
            }
            if(index_find >= 0){
                $("#err_msg").append(care_label_no+" Already Added!");
                $("#carelabel_tracking_no").val('');
            }

        }

    }

    function sendingToProduction() {
        var cl_array = [];

        $("input[name='cl_codes[]']").each(function() {
            cl_array.push($(this).val());
        });

        var line_id = $("#line_no").val();

        if(line_id != ''){
            $("#loader").css("display", "block");

            $.ajax({
                url: "<?php echo base_url();?>access/sendingCutToProduction/",
                type: "POST",
                data: {cl_array: cl_array, line_id: line_id},
                dataType: "html",
                success: function (data) {
                    if(data == 'DONE'){
                        location.reload();
                    }
                }
            });
        }else{
            alert("Please Select Line!");
        }
    }

    function getSizeWiseReport(po_no, so_no, po, item) {
        $("#loader").css("display", "block");

        $("#size_tbl").empty();
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeCutReport/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: po, item: item},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
                $("#loader").css("display", "none");
            }
        });
    }

    function getRemainCLs(po_no, so_no, purchase_order, item, quality, color, size) {
//        $("#loader").css("display", "block");

        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeRemainCutSendCL/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
//                $("#loader").css("display", "none");
            }
        });
    }

    function getCuttingReportIndividual() {
        var line_no = $("#line_no").val();

        if(line_no != ''){
            $("#loader").css("display", "block");
//            $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReport');

            $("#reload_div").empty();
            $("#remain_cl_list").empty();
            $("#size_tbl").empty();

//            setInterval(function(){
//                $("#loader").css("display", "none");
//            }, 15000);

            $.ajax({
                url: "<?php echo base_url();?>access/getProductionSummaryReport/",
                type: "POST",
                data: {line_no: line_no},
                dataType: "html",
                success: function (data) {
//                console.log(data);
                    $("#reload_div").append(data);
                    $("#loader").css("display", "none");
                    document.getElementById("blank").selected = "true";
                }
            });
        }else{
            alert("Please Select Line");
        }

    }

    function getCutBalancePcs(po_no, so_no, purchase_order, item, quality, color) {

        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getCutBalancePcs/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });

    }
</script>