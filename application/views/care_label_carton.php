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
          <h1>Carton</h1>
          <h2 class="">Carton...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Carton</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
<!--        <form action="--><?php //echo base_url();?><!--access/cartonSave" method="post">-->
        <div class="row">
        <div class="col-md-12">
              <div style="color: darkgreen; font-size: 30px; font-weight: 900;" id="s_message"></div>
              <div style="color: red; font-size: 30px; font-weight: 900;" id="e_message"></div>


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
                    <span style="margin-top: 30px;" id="refresh_report" class="btn btn-success" onclick="getCartonReport();">Report</span>
                    <br />
                    <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                </div>
                <div class="col-md-11 scroll" id="reload_div">

                </div><!--/block-web-->
            </div><!--/col-md-12-->
<!--        </form>-->
          <div class="row">
              <div class="col-md-8 scroll2">
                  <div class="block-web">

                      <div class="porlets-content">

                          <div class="table-responsive" id="size_tbl">
                              <table class="display table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                      <th class="center">Size</th>
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
                                  </tr>
                                  </tbody>
                              </table>
                          </div><!--/table-responsive-->
                      </div>

                  </div><!--/porlets-content-->
              </div><!--/block-web-->
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

    $(document).ready(function(){
//        $("#reload_div").load('<?php //echo base_url();?>//access/care_label_carton_data_load');

//        setInterval(function(){
//            $("#reload_div").load('<?php //echo base_url();?>//access/care_label_carton_data_load');
//        }, 60000);

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

    function getCartonReport() {
        $("#loader").css("display", "block");
//        $("#reload_div").load('<?php //echo base_url();?>//access/care_label_carton_data_load');

        $("#reload_div").empty();

//        setInterval(function(){
//            $("#loader").css("display", "none");
//        }, 15000);

        $.ajax({
            url: "<?php echo base_url();?>access/care_label_carton_data_load/",
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
                    url: "<?php echo base_url();?>access/cartonSave/",
                    data: {care_label_no: cl_no},
                    dataType: "html",
                    success: function (data) {
                        if(data == 'Successfully in Carton!'){
                            $("#s_message").text(cl_no+" Successfully in Carton!");
                        }
                        if(data == 'Already in Carton!'){
                            $("#s_message").text(cl_no+" Already in Carton!");
                        }
                        if(data == 'In Trash!'){
                            $("#e_message").text(cl_no+" In Trash!");
                        }
                        if(data == 'Packing Not Completed!'){
                            $("#e_message").text(cl_no+" Packing Not Completed!");
                        }
                        if(data == 'Not Found!'){
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
                $("#e_message").text('Failed to Send!');
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
            url: "<?php echo base_url();?>access/getPoItemWiseSizeCartonReport/",
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
            url: "<?php echo base_url();?>access/getPoItemWiseSizeRemainCartonCL/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }

    function getCartonRemainingPcs(po_no, so_no, purchase_order, item, quality, color, size) {
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getCartonRemainingPcs/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }
</script>