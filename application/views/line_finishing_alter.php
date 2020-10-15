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
          <h1>Line-Finishing Alter</h1>
          <a class="btn btn-success" href="<?php echo base_url()?>access/care_label_end_line_new">End Line QC</a>
<!--          <a class="btn btn-primary" href="--><?php //echo base_url()?><!--access/poOutputControl">Output Control</a>-->
          <a class="btn btn-danger" href="<?php echo base_url()?>access/machineMaintenance">Machine Maintenance</a>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Line-Finishing Alter</li>
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
                          <div class="col-md-1">
                              <!--                            <div class="panel-heading" style="color: green;"> Pass<span class="semi-bold"></span> </div>-->

                              <input type="text" placeholder="Pass" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" autocomplete="off" onkeyup="submitClQcInfo();" />
                              <span style="">Pass</span>
                              <button style="display: none;" id="submit_btn_save_pass" class="btn btn-success">Save</button>
                              <br />
                              <span style="margin-top: 20px;" id="refresh_report" class="btn btn-primary" onclick="getFinishingAlterLineReport();">Alter Report</span>
                              <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                          </div>
                          <div class="col-md-4">

                              <!--                                <div class="panel-heading" style="color: red;"> Defects<span class="semi-bold"></span> </div>-->
                              <!--                                <div class="panel-body">-->
                              <h4><span id="er_msg" style="color: red;"></span></h4>
                              <h4><span id="s_msg" style="color: green;"></span></h4>
                              <div class="col-md-6">
<!--                                  <input type="text" placeholder="Defect" class="form-control" name="carelabel_tracking_no_defect" required id="carelabel_tracking_no_defect" onkeyup="submitClQcDefectInfo();" />-->
<!--                                  <span style=""> Defect</span>-->

                              </div>
                              <div class="col-md-6">
                                  <button style="display: none;" id="submit_btn_save_defect" class="btn btn-success">Save</button>
                              </div>


                              <!--                                </div>-->
                              <!--/col-md-6-->
                          </div>

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
                                                          <th class="hidden-phone center">PO-ITEM</th>
                                                          <th class="hidden-phone center">Brand</th>
                                                          <th class="hidden-phone center">STL</th>
                                                          <th class="hidden-phone center">QL-CLR</th>
                                                          <th class="hidden-phone center">Order</th>
                                                          <th class="hidden-phone center">ExFac</th>
                                                          <th class="hidden-phone center">Qty</th>
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

    $("#carelabel_tracking_no").blur(function(){
        $("#carelabel_tracking_no").focus();
    });

    function submitClQcInfo(){

        var carelabel_tracking_no = $("#carelabel_tracking_no").val();

        var code_length = carelabel_tracking_no.length;

        var rowCount = $('#defect_code_tbl tbody tr').length;

        if((code_length == 10) && (carelabel_tracking_no != '')){

            $("#carelabel_tracking_no").attr('readonly', true);
            $("#loader").css("display", "block");

            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>access/lineFinishingAlterDone/",
                data: {carelabel_tracking_no: carelabel_tracking_no},
                dataType: "html",
                success: function (data) {

                    if(data != ''){
                        $("#p_er_msg").empty();
                        $("#er_msg").empty();
                        $("#s_msg").empty();
                        $("#p_s_msg").empty();

                        if(data == 'Successfully Updated'){
                            $("#s_msg").text(carelabel_tracking_no+' '+data);
                        }

                        if((data == 'Line Mismatch' || data == 'No Alter Request Found')){
                            $("#er_msg").text(carelabel_tracking_no+' '+data);
                        }

                        $("#carelabel_tracking_no_defect").val('');
                        $("#carelabel_tracking_no").val('');
                        $("#carelabel_tracking_no").focus();

                    }

                    $("#loader").css("display", "none");
                    $("#carelabel_tracking_no").attr('readonly', false);
                }
            });

        }

    }

    function getFinishingAlterLineReport() {
        $("#loader").css("display", "block");
//        $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReport');

        $("#reload_div").empty();

//        setInterval(function(){
//            $("#loader").css("display", "none");
//        }, 15000);

        $.ajax({
            url: "<?php echo base_url();?>access/getFinishingAlterLineReport/",
            type: "POST",
            data: {},
            dataType: "html",
            success: function (data) {
                $("#reload_div").append(data);
                $("#loader").css("display", "none");
            }
        });

    }

    function getRemainingFinishingAlterPcs(so_no){
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getRemainingFinishingAlterPcs/",
            type: "POST",
            data: {so_no: so_no},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }

    function getRemainingFinishingAlterPcs(so_no){
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getRemainingFinishingAlterPcs/",
            type: "POST",
            data: {so_no: so_no},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }
</script>