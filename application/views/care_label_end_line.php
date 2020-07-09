<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>End Line QC</h1>
          <h2 class="">End Line QC...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">End Line QC</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
<!--        <form action="--><?php //echo base_url();?><!--access/care_label_mid_line_qc" method="post">-->
        <div class="row">
        <div class="col-md-12">
          <div class="block-web">
            <div class="header">
              <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
            </div>

<!--              <div style="padding-top:10px">-->
<!--                  <h6 style="color:red">-->
<!--                      --><?php
//                      $exc = $this->session->userdata('exception');
//                      if (isset($exc)) {
//                          echo $exc;
//                          $this->session->unset_userdata('exception');
//                      } ?>
<!--                  </h6>-->
<!---->
<!--                  <h6 style="color:green">-->
<!--                      --><?php
//                      $msg = $this->session->userdata('message');
//                      if (isset($msg)) {
//                          echo $msg;
//                          $this->session->unset_userdata('message');
//                      }
//                      ?>
<!--                  </h6>-->
<!--              </div>-->
              <div id="message"></div>

              <div class="col-md-3">
                  <input type="text" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" onblur="focusOnThisInput();" />

<!--                  <input type="text" class="form-control" name="cut_tracking_no_1" required id="cut_tracking_no_1" />-->
<!--                  <span id="er_msg" style="color: red;"></span>-->
<!--                  <span id="s_msg" style="color: green;"></span>-->
              </div>

              <br />
               <div class="porlets-content">

               </div>

           </div><!--/porlets-content-->  
          </div><!--/block-web--> 
        </div><!--/col-md-12-->
            <div class="row">
                <div class="col-md-12">
                    <section class="panel default blue_title h2">
                        <div class="panel-body">
                            <button type="submit" name="accept_btn" id="accept_btn" class="btn btn-success btn-lg" onclick="careLabelMidLineQc(id);">Pass</button>
                            &nbsp;
                            <button type="submit" name="defect_btn" id="defect_btn" class="btn btn-warning btn-lg" onclick="careLabelMidLineQc(id);">Defects</button>
                            &nbsp;
                            <button  type="submit" name="reject_btn" id="reject_btn" class="btn btn-danger btn-lg" onclick="careLabelMidLineQc(id);">Reject</button>
                    </section>
                </div>
                <!--/col-md-6-->
            </div>
<!--        </form>-->
      </div>

<script type="text/javascript">

    $(document).ready(function(){
        $("#message").empty();
    });

    function focusOnThisInput() {
        $("#carelabel_tracking_no").focus();
    }

    function careLabelMidLineQc(id) {
        var cl_no = $("#carelabel_tracking_no").val();
        var care_label_no = cl_no.trim();
        var status = 0;

        var last_variable = care_label_no.slice(-1);

        if(care_label_no != '' && last_variable == '.'){
            if(id == 'accept_btn'){
                status = 1;

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>access/care_label_end_line_qc/",
                    data: {care_label_no: care_label_no, access_points_status: status},
                    dataType: "html",
                    success: function (data) {
                        $("#message").empty();
                        $("#message").append(data);
                        $("#carelabel_tracking_no").val('');
                        $("#carelabel_tracking_no").focus();
                    }
                });
            }
            if(id == 'defect_btn'){
                status = 2;

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>access/care_label_end_line_qc_defect/",
                    data: {care_label_no: care_label_no, access_points_status: status},
                    dataType: "html",
                    success: function (data) {
                        $("#message").empty();
                        $("#message").append(data);
                        $("#carelabel_tracking_no").val('');
                        $("#carelabel_tracking_no").focus();
                    }
                });
            }
            if(id == 'reject_btn'){
                status = 3;

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>access/care_label_end_line_qc_reject/",
                    data: {care_label_no: care_label_no, access_points_status: status},
                    dataType: "html",
                    success: function (data) {
                        $("#message").empty();
                        $("#message").append(data);
                        $("#carelabel_tracking_no").val('');
                        $("#carelabel_tracking_no").focus();
                    }
                });
            }
        }

        if(last_variable == '.'){

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
        }
//        else{
//            $("#s_msg").text('');
//            $("#er_msg").text('Failed to Send!');
//            $("#carelabel_tracking_no").val('');
//        }
    }

</script>