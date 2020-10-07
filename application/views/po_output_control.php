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
          <h1>PO Output Control</h1>
          <a class="btn btn-success" href="<?php echo base_url()?>access/care_label_end_line_new">End Line QC</a>
            <a class="btn btn-warning" href="<?php echo base_url()?>access/lineFinishingAlter">Finishing Alter</a>
            <a class="btn btn-danger" href="<?php echo base_url()?>access/machineMaintenance">Machine Maintenance</a>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">PO Output Control</li>
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
                              <input type="text" placeholder="Responsible Person" class="form-control" name="responsible_person" autofocus required id="responsible_person" autocomplete="off" onkeyup="checkResponsiblePersonValidity();" />
                              <span style="">Responsible Person</span>
                          </div>
                          <div class="col-md-2" id="scano_po_div" style="display: none">
                              <input type="text" placeholder="Scan PO" class="form-control" name="scan_po" autofocus required id="scan_po" autocomplete="off" onkeyup="submitPoOutputControl();" />
                              <span style="">Scan PO</span>
                          </div>
                          <div class="col-md-2">
                              <button style="display: none;" id="submit_btn_save_pass" class="btn btn-success">Save</button>
                              <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                          </div>

                      </div>

                  </div><!--/block-web-->
              </div><!--/col-md-12-->
          </div>
          <!--                    </form>-->

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

//    $("#responsible_person").blur(function(){
//        $("#responsible_person").focus();
//    });

    function checkResponsiblePersonValidity() {
        var responsible_person = $("#responsible_person").val();

        var last_variable = responsible_person.slice(-1);

        if(last_variable == '.'){
            $.ajax({
                url: "<?php echo base_url();?>access/checkResponsiblePersonValidity/",
                type: "POST",
                data: {responsible_person: responsible_person},
                dataType: "html",
                success: function (data) {
                    if(data == 'found'){
                        $("#scano_po_div").css('display', 'block');
                        $("#responsible_person").attr('readonly', true);
                        $("#scan_po").focus();
                        $("#p_er_msg").text('');
                        $("#p_s_msg").text('');
                    }
                    if(data == 'not found'){
                        $("#p_er_msg").text('Invalid Responsible Person Code!');
                        $("#p_s_msg").text('');
                        $("#responsible_person").val('');
                        $("#scan_po").val('');

                        $("#scano_po_div").css('display', 'none');
                        $("#responsible_person").attr('readonly', false);
                        $("#responsible_person").focus();

                    }
                }
            });
        }
    }
    
    function submitPoOutputControl() {
        var responsible_person = $("#responsible_person").val();
        var scan_po = $("#scan_po").val();

        var last_variable = scan_po.slice(-1);

        $("#p_er_msg").text('');
        $("#p_s_msg").text('');

        if(last_variable == '.'){
            $("#loader").css('display', 'block');

            $.ajax({
                url: "<?php echo base_url();?>access/allowPoLineOutput/",
                type: "POST",
                data: {pc_no: scan_po, responsible_person: responsible_person},
                dataType: "html",
                success: function (data) {

                    if(data == 'done'){
                        $("#p_s_msg").text('Successful!');
                        $("#responsible_person").attr('readonly', false);
                        $("#responsible_person").val('');
                        $("#responsible_person").focus();
                        $("#scan_po").val('');
                        $("#scano_po_div").css('display', 'none');
                    }

                    if(data == 'line mismatch'){
                        $("#p_er_msg").text('Line Mismatch!');
                        $("#scan_po").val('');
                    }

                    if(data == 'invalid'){
                        $("#p_er_msg").text('Invalid Code!');
                        $("#scan_po").val('');
                    }

                    $("#loader").css('display', 'none');
                }
            });
        }
    }

</script>