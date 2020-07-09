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
          <h1>Finishing QC</h1>
            <?php if($access_points == 7){?>
                <a href="<?php echo base_url();?>access/care_label_packing" class="btn btn-primary">Packing</a>
            <?php } ?>
            <?php if($access_points == 6){?>
                <a href="<?php echo base_url();?>access/care_label_washing" class="btn btn-primary">Wash Return</a>
            <?php } ?>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Finishing QC</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
<!--        <form action="--><?php //echo base_url();?><!--access/finishingAlterSave" method="post">-->
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

            <h4 style="color: green;"><div id="message"></div></h4>
            <h4 style="color: red;"><div id="exception"></div></h4>


          </div><!--/block-web--> 
        </div><!--/col-md-12-->
        <div class="row">
            <div class="col-md-2">
                <input type="text" class="form-control" name="carelabel_tracking_no" autofocus autocomplete="off" required id="carelabel_tracking_no" />
            </div>
            <div class="col-md-1">
                <span class="btn btn-success" onclick="finishingAlterPassSave();">PASS</span>
            </div>
            <div class="col-md-1">
                <span class="btn btn-danger" onclick="finishingAlterFailSave();">FAIL</span>
            </div>
            <div class="col-md-1">
                <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
            </div>
            <div class="col-md-1">
                <span class="btn btn-primary" onclick="getFinishingAlterReport();">Report</span>
            </div>
        </div>

        <br />

        <div class="row">
              <div class="col-md-12 scroll" id="reload_div"></div>
        </div>
<!--        </form>-->

      </div>
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
        $("#message").empty();

        $(".menutoggle").click();
    });

    $("#carelabel_tracking_no").blur(function(){
        $("#carelabel_tracking_no").focus();
    });

    function finishingAlterPassSave(){
        $("#message").empty();
        $("#exception").empty();

        $("#loader").css('display', 'block');

        var cl_no = $("#carelabel_tracking_no").val();
        var care_label_no = cl_no.trim();

        var last_variable = care_label_no.slice(-1);

        if(care_label_no != '' && last_variable == '.'){

            $("#carelabel_tracking_no").attr('readonly', true);

            $.ajax({
                url: "<?php echo base_url();?>access/finishingAlterSave/",
                type: "POST",
                data: {care_label_no: care_label_no, status: 1},
                dataType: "html",
                success: function (data) {

                    $("#loader").css('display', 'none');
                    $("#carelabel_tracking_no").attr('readonly', false);

                    if(data != '' && data != 'pass pending' && data != 'line pending'){
                        $("#exception").empty();
                        $("#message").text(care_label_no+" "+data);
                    }

                    if(data == 'line pending'){
                        $("#message").empty();
                        $("#exception").text("Line Process not Complete!");
                    }

                    if(data == 'pass pending'){
                        $("#message").empty();
                        $("#exception").text("Alter not Confirmed!");
                    }

                    if(data == ''){
                        $("#message").empty();
                        $("#exception").text("Failed!");
                    }

                    $("#carelabel_tracking_no").val('');
                    $("#carelabel_tracking_no").focus();

                }
            });

        }

    }

    function finishingAlterFailSave(){
        $("#message").empty();
        $("#exception").empty();

        $("#loader").css('display', 'block');

        var cl_no = $("#carelabel_tracking_no").val();
        var care_label_no = cl_no.trim();

        var last_variable = care_label_no.slice(-1);

        if(care_label_no != '' && last_variable == '.'){

            $("#carelabel_tracking_no").attr('readonly', true);

            $.ajax({
                url: "<?php echo base_url();?>access/finishingAlterSave/",
                type: "POST",
                data: {care_label_no: care_label_no, status: 2},
                dataType: "html",
                success: function (data) {

                    $("#loader").css('display', 'none');
                    $("#carelabel_tracking_no").attr('readonly', false);

                    if(data != '' && data != 'pass pending' && data != 'line pending'){
                        $("#exception").empty();
                        $("#message").text(care_label_no+" "+data);
                    }

                    if(data == 'line pending'){
                        $("#message").empty();
                        $("#exception").text("Line Process not Complete!");
                    }

                    if(data == 'pass pending'){
                        $("#message").empty();
                        $("#exception").text("Alter not Confirmed!");
                    }

                    if(data == ''){
                        $("#message").empty();
                        $("#exception").text("Failed!");
                    }

                    $("#carelabel_tracking_no").val('');
                    $("#carelabel_tracking_no").focus();

                }
            });

        }

    }

    function getFinishingAlterReport() {
        $("#loader").css('display', 'block');

        $("#reload_div").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getFinishingAlterReport/",
            type: "POST",
            data: {},
            dataType: "html",
            success: function (data) {

                $("#loader").css('display', 'none');
                $("#reload_div").append(data);

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