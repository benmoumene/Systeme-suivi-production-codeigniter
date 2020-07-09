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
          <h1>Wash Send</h1>
          <h2 class="">Wash Send...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Wash Send</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->

        <div class="row">
        <div class="col-md-12">
            <div style="color: darkgreen; font-size: 25px;" id="s_message"></div>
            <div style="color: red; font-size: 25px;" id="e_message"></div>

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
                    <input type="text" class="form-control" name="carelabel_tracking_no" autofocus autocomplete="off" required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />
<!--                    <button style="display: none;" id="submit_btn" class="btn btn-success">Send</button>-->

                    <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                    <br />
                    <br />
                    <span style="margin-top: 30px;" id="refresh_report" class="btn btn-primary" onclick="getGoingWashReport();">Report</span>
                    <br />
                    <br />
                    <?php if($access_points == 2){ ?>
                    <a href="<?php echo base_url();?>access/care_label_input_line" id="" class="btn btn-success">INPUT</a>
                    <?php } ?>
                    <br />
                    <br />
                    <?php if($access_points != 2){ ?>
                    <a href="<?php echo base_url();?>access/care_label_washing" id="" class="btn btn-primary ">Wash Return</a>
                    <?php } ?>
                </div>
                <div class="col-md-11 scroll" id="reload_div">

                </div><!--/block-web-->
            </div><!--/col-md-12-->

          <div class="row">
              <div class="col-md-8 scroll2">
                  <div class="block-web">

                      <div class="porlets-content">

                          <div class="table-responsive" id="size_tbl">
                              <table class="display table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                      <th class="hidden-phone center">Size</th>
                                      <th class="hidden-phone center">Cut</th>
                                      <th class="hidden-phone center">End</th>
                                      <th class="hidden-phone center">Wash</th>
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

    $(document).ready(function(){
//        $("#reload_div").load('<?php //echo base_url();?>//access/wash_going_data');

//        setInterval(function(){
//            $("#reload_div").load('<?php //echo base_url();?>//access/wash_going_data');
//        }, 30000);
//        $("#message").empty();

        setInterval(function(){

            $.ajax({
                url: "<?php echo base_url();?>access/checkSession/", //Change this URL as per your settings
                type: "POST",
                data: {},
                dataType: "html",
                success: function(newVal) {

                    var session_out_time = '<?php echo $session_out?>';

                    var inactive_time = newVal * 1;

                    console.log(inactive_time);

                    if (inactive_time > session_out_time){
                        window.location.assign('<?php echo base_url();?>access/logout');
                    }

                }
            });


        }, 10000);

    });

    $("#carelabel_tracking_no").blur(function(){
        $("#carelabel_tracking_no").focus();
    });

    function getGoingWashReport() {
        $("#loader").css("display", "block");
//        $("#reload_div").load('<?php //echo base_url();?>//access/wash_going_data');

        $("#reload_div").empty();
        $("#size_tbl").empty();

//        setInterval(function(){
//            $("#loader").css("display", "none");
//        }, 15000);

        $.ajax({
            url: "<?php echo base_url();?>access/wash_going_data/",
            type: "POST",
            data: {},
            dataType: "html",
            success: function (data) {
                $("#reload_div").append(data);
                $("#loader").css("display", "none");
            }
        });

    }

    function clickToSubmitBtn() {
        $("#s_message").empty();
        $("#e_message").empty();

        var cl_no = $("#carelabel_tracking_no").val();

        var code_length = cl_no.length;

        var last_variable = cl_no.slice(-1);

        $("#loader").css("display", "block");

        if(code_length == 10){
            if(code_length==10 && cl_no != '' && last_variable == '.'){
                $("#carelabel_tracking_no").attr('readonly', true);

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>access/goingForWash/",
                    data: {care_label_no: cl_no},
                    dataType: "html",
                    success: function (data) {
                        if(data == 'successful'){
                            $("#s_message").text(cl_no+" Successful!");
                        }
                        if(data == 'already'){
                            $("#s_message").text(cl_no+" Scanned Already!");
                        }
                        if(data == 'non-wash'){
                            $("#e_message").text(cl_no+" is not Wash Garment!");
                        }
                        if(data == 'previous process wip'){
                            $("#e_message").text(cl_no+" Previous Process Not Finished!");
                        }
                        if(data == 'Not Found'){
                            $("#e_message").text(cl_no+" Not Found!");
                        }
                        if(data == 'closed'){
                            $("#e_message").text(cl_no+" is Closed!");
                        }
                        $("#carelabel_tracking_no").val('').focus;
                        $("#loader").css("display", "none");
                        $("#carelabel_tracking_no").attr('readonly', false);
                    }
                });
            }
            else{
                $("#s_message").text('');
                $("#e_message").text('Failed!');
                $("#carelabel_tracking_no").val('');
            }
        }
        if(code_length > 10){
            $("#s_message").text('');
            $("#e_message").text('Label Length Error!');
            $("#carelabel_tracking_no").val('');
        }

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

    function getSizeWiseReport(po_no, so_no, po, item, quality, color) {
        $("#size_tbl").empty();
        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeWashGoingReport/",
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
            url: "<?php echo base_url();?>access/getPoItemWiseSizeRemainWashGoingCL/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }
</script>