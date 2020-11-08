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
          <h1>Machine Maintenance</h1>

            <?php if($access_points == 8){ ?>
                <a class="btn btn-success" href="<?php echo base_url()?>access/bundle_collar_cuff_track">COLLAR-CUFF</a>
            <?php } ?>

          <?php if($access_points == 4){ ?>
          <a class="btn btn-warning" href="<?php echo base_url()?>access/lineFinishingAlter">FINISHING ALTER</a>
          <a class="btn btn-success" href="<?php echo base_url()?>access/care_label_end_line_new">END LINE QC</a>
<!--          <a class="btn btn-primary" href="--><?php //echo base_url()?><!--access/poOutputControl">Output Control</a>-->
          <?php } ?>

          <?php if($access_points == 3){ ?>
              <a class="btn btn-success" href="<?php echo base_url()?>access/care_label_mid_line_new">MID LINE QC</a>
          <?php } ?>

          <?php if($access_points == 2){ ?>
              <a class="btn btn-success" href="<?php echo base_url()?>access/care_label_input_line">LINE INPUT</a>
          <?php } ?>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Machine Maintenance</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
          <div class="row">
              <div class="col-md-12">
                  <div class="panel-body">
                      <div class="porlets-content">
                          <h4><span id="p_er_msg" style="color: red;"></span></h4>
                          <h4><span id="p_s_msg" style="color: green;"></span></h4>
                          <div class="col-md-2">
                              <!--                            <div class="panel-heading" style="color: green;"> Pass<span class="semi-bold"></span> </div>-->

                              <input type="text" placeholder="Machine No" class="form-control" name="machine_no" autofocus required id="machine_no" autocomplete="off" onkeyup="submitClQcInfo();" />
                              <span style="">Machine No.</span>
                              <br />
                              <span style="margin-top: 20px;" id="refresh_report" class="btn btn-primary" onclick="getMachineMaintenanceReport();">Maintenance Report</span>

                          </div>
                          <div class="col-md-2" id="solve_by_div" style="display: none">
                              <!--                            <div class="panel-heading" style="color: green;"> Pass<span class="semi-bold"></span> </div>-->

                              <input type="text" placeholder="Solved By" class="form-control" name="solved_by" autofocus required id="solved_by" autocomplete="off" onkeyup="submitClQcInfo();" />
                              <span style="">Solved By</span>

                          </div>
                          <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                          <div class="col-md-4"></div>

                      </div>

                  </div><!--/block-web-->
              </div><!--/col-md-12-->
          </div>
          <!--                    </form>-->
          <div class="row">
              <div class="col-md-12">
                  <section class="panel default blue_title h2">
                      <!--                <div class="panel-heading" style="color: green;"> Pass<span class="semi-bold"></span> </div>-->
                      <div class="panel-body">

                          <div class="porlets-content">

                              <div class="col-md-12">
                                  <div class="col-md-11 scroll" id="reload_div">
                                      <?php
//                                      $prod_summary = $this->method_call->getProductionSummaryReport();
                                      ?>
                                      <div class="block-web">

                                          <div class="porlets-content">

                                              <div class="table-responsive">
                                                  <table class="display table table-bordered table-striped" id="">
                                                      <thead>
                                                      <tr>
                                                          <th class="hidden-phone center">Machine No</th>
                                                          <th class="hidden-phone center">Machine Name</th>
                                                          <th class="hidden-phone center">Machine Model</th>
                                                          <th class="hidden-phone center">Status</th>
                                                      </tr>
                                                      </thead>
                                                      <tbody></tbody>
                                                  </table>
                                              </div><!--/table-responsive-->
                                          </div>

                                      </div><!--/porlets-content-->
                                  </div><!--/block-web-->
                              </div>
                          </div>

                      </div><!--/block-web-->
                  </section><!--/porlets-content-->
              </div><!--/col-md-12-->
          </div>
            </div>
<!--                    </form>-->

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

//        setInterval(function(){
//            $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReport');
//        }, 60000);
//        $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReport');

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

//    $("#machine_no").blur(function(){
//        $("#machine_no").focus();
//    });

    function submitClQcInfo(){

        var machine_no = $("#machine_no").val();

        var last_variable = machine_no.slice(-1);

        $("#p_er_msg").text('');
        $("#p_s_msg").text('');

        if(last_variable == '.'){

            $("#loader").css("display", "block");
            $("#p_er_msg").text("");

            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>access/checkMachineStatus/",
                data: {machine_no: machine_no},
                dataType: "json",
                success: function (data) {

                    if(data.length > 0){

                        var service_status = data[0].service_status;

                        if(service_status  == 0){
                            $("#p_er_msg").text("Machine is Out of Service!");
                            $("#machine_no").val('');
                            $("#solved_by").val('');
                            $("#loader").css("display", "none");
                        }

                        if(service_status  == 1){
                            $.ajax({
                                url: "<?php echo base_url();?>access/changeMachineStatusLog/",
                                type: "POST",
                                data: {machine_no: machine_no, service_status: 2},
                                dataType: "html",
                                success: function (data) {

                                    if(data == 'done'){
                                        $("#p_s_msg").text("Machine is Under Maintenance!");
                                        $("#machine_no").val('');
                                        $("#solved_by").val('');
                                        $("#loader").css("display", "none");
                                    }

                                }
                            });
                        }

                        if(service_status  == 2){
                            $("#loader").css("display", "none");

                            $("#solve_by_div").css("display", "block");

                            $("#solved_by").focus();

                            var solved_by = $("#solved_by").val();

                            var solved_by_last_variable = solved_by.slice(-1);

                            if(solved_by_last_variable == '.'){
                                $("#loader").css("display", "block");

                                $("#solved_by").val('');

                                $.ajax({
                                    url: "<?php echo base_url();?>access/changeMachineStatusLog/",
                                    type: "POST",
                                    data: {machine_no: machine_no, service_status: 1, solved_by: solved_by},
                                    dataType: "html",
                                    success: function (data) {
                                        $("#p_s_msg").text("Machine is RUNNING!");
                                        $("#loader").css("display", "none");
                                        $("#solve_by_div").css("display", "none");
                                        $("#solved_by").val('');
                                        $("#machine_no").val('');
                                        $("#machine_no").focus();
                                    }
                                });
                            }
                        }

                        if(service_status  == 3){
                            $("#p_er_msg").text("Machine is Idle!");
                            $("#machine_no").val('');
                            $("#solved_by").val('');
                            $("#loader").css("display", "none");
                        }

                    }else{
                        $("#p_er_msg").text("Machine Not Found!");
                        $("#machine_no").val('');
                        $("#solved_by").val('');
                        $("#loader").css("display", "none");
                    }

                }
            });

        }

    }
    
    function getMachineMaintenanceReport() {
        $("#reload_div").empty();
        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>access/getMachineMaintenanceReport/",
            type: "POST",
            data: {},
            dataType: "html",
            success: function (data) {
                $("#reload_div").append(data);

                $("#loader").css("display", "none");
            }
        });
    }

</script>