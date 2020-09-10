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
          <h1>QA Warehouse</h1>
          <h2 class="">QA Warehouse...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">QA Warehouse</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
<!--        <form action="--><?php //echo base_url();?><!--access/saveAsWarehouseNew" method="post">-->

        <div class="row">
            <div class="col-md-12">
                <div style="padding-top:10px">
                    <h6 style="color:red" id="err_msg"></h6>

                    <h6 style="color:green" id="suc_msg"></h6>
                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->

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
                <div class="col-md-2">
<!--                    <input type="text" class="form-control" placeholder="Warehouse Type Code" name="warehouse_code" autofocus required id="warehouse_code" onkeyup="blurToCarelabelnoField();" />-->
                    <select class="form-control" name="warehouse_type" id="warehouse_type" onchange="appendRemarksOption();">
                        <option value="">Select Warehouse Type</option>
                        <?php foreach ($wh_types as $v_1){
                            if($v_1['id'] != 5){
                            ?>
                            <option value="<?php echo $v_1['id']?>"><?php echo $v_1['warehouse_type']?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    <span><b>* Select Warehouse Type</b></span>
                    <br />

                </div>
                <div class="col-md-2">
                    <!--                    <input type="text" class="form-control" placeholder="Warehouse Type Code" name="warehouse_code" autofocus required id="warehouse_code" onkeyup="blurToCarelabelnoField();" />-->
                    <select class="form-control" name="season" id="season">
                        <option value="">Select Season</option>
                        <?php foreach ($seasons as $v_2){ ?>
                            <option value="<?php echo $v_2['id']?>"><?php echo $v_2['season']?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span><b>* Select Season</b></span>
                    <br />
                    <br />
                    <div id="remarks_div" style="display: none">
                        <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks" autocomplete="off" onblur="checkRemarksValidation();" />
                        <span><b>Remarks</b></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Indentity Label Code" name="carelabel_tracking_no" autofocus autocomplete="off" id="carelabel_tracking_no"  onkeyup="clickToSubmitBtn();" />
                    <br />
                    <button id="submit_btn" class="btn btn-success" onclick="sendingToProduction();">Save</button>
                    <br />
                    <span style="margin-top: 30px;" id="refresh_report" class="btn btn-primary" onclick="getQaWarehouseReport();">Report</span>
                    <br />
                    <br />
                    <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                </div>
                <div class="col-md-3">
                    <div class="block-web scroll7">
                        <div class="porlets-content">

                            <div class="table-responsive">
                                <table class="display table table-bordered table-striped" id="bundle_tbl">
                                    <thead>
                                    <tr>
                                        <th class="hidden-phone center">Identity Number</th>
                                        <th class="hidden-phone center">Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody id="bundle_tbl_bdy">

                                    </tbody>
                                </table>
                            </div><!--/table-responsive-->
                        </div>
                    </div>

                </div><!--/block-web-->
                <div class="col-md-3">
                    <div class="block-web scroll7">
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
            </div>
            <div class="row">
                <div class="col-md-12 scroll" id="reload_div">

                </div><!--/block-web-->
            </div><!--/col-md-12-->
<!--        </form>-->

      </div>

<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
        $("#message").empty();

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
    });

//    $("#carelabel_tracking_no").blur(function(){
//        $("#carelabel_tracking_no").focus();
//    });

    function appendRemarksOption() {
        var warehouse_type = $("#warehouse_type").val();

        if (warehouse_type == 3){
//            $("#remarks_div").css('display', 'block');
            $("#carelabel_tracking_no").css('display', 'block');
        }else{
//            $("#remarks_div").css('display', 'none');
            $("#carelabel_tracking_no").css('display', 'block');
        }

        $("#carelabel_tracking_no").focus();
    }

    function checkRemarksValidation() {
        var remarks = $("#remarks").val();

//        if (remarks != ''){
//            $("#carelabel_tracking_no").css('display', 'block');
//            $("#carelabel_tracking_no").focus();
//        }else{
//            alert("Please Enter Valid Reason!");
//            $("#carelabel_tracking_no").css('display', 'none');
//        }
    }
    
    function getQaWarehouseReport() {
        $("#loader").css("display", "block");
//        $("#reload_div").load('<?php //echo base_url();?>//access/packing_data');

        $("#reload_div").empty();

//        setInterval(function(){
//            $("#loader").css("display", "none");
//        }, 15000);

        $.ajax({
            url: "<?php echo base_url();?>access/qa_warehouse_data/",
            type: "POST",
            data: {},
            dataType: "html",
            success: function (data) {
                $("#reload_div").append(data);
                $("#loader").css("display", "none");
            }
        });
    }

    function blurToCarelabelnoField(){
        var wh_code = $("#warehouse_code").val();
        var warehouse_code = wh_code.trim();

        var code_length = warehouse_code.length;

        if(code_length == 8){
            var fst_variable = warehouse_code.charAt(0);
            var last_variable = warehouse_code.slice(-1);
        }

        if(warehouse_code != '' && fst_variable == 'w' && last_variable == '.') {
            $("#carelabel_tracking_no").attr('readonly', false);
            $("#carelabel_tracking_no").focus();
        }
    };

    function clickToSubmitBtn() {
        var warehouse_type = $("#warehouse_type").val();
        var remarks = $("#remarks").val();

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
                $("#bundle_tbl_bdy").append('<tr><td><input type="text" name="cl_codes[]" id="cl_codes" class="form-control" value="'+cl_no+'" /></td><td><input type="text" name="remarks[]" id="remarks" class="form-control" value="'+remarks+'" /></td></tr>');
                $("#carelabel_tracking_no").val('');
                $("#suc_msg").append(care_label_no+" Successfully Added!");
            }
            if(index_find >= 0){
                $("#err_msg").append(care_label_no+" Already Added!");
                $("#carelabel_tracking_no").val('');
            }

//            if(warehouse_type == 3){
//                $("#carelabel_tracking_no").css('display', 'none');
//                $("#remarks").val('');
//            }

        }

    }

    function sendingToProduction() {
        var cl_array = [];
        var remarks_array = [];

        $("input[name='cl_codes[]']").each(function() {
            cl_array.push($(this).val());
        });

        $("input[name='remarks[]']").each(function() {
            remarks_array.push($(this).val());
        });

        var warehouse_type = $("#warehouse_type").val();
        var season = $("#season").val();

        if(warehouse_type != '' && season != ''){

                $("#loader").css("display", "block");

                    $.ajax({
                        url: "<?php echo base_url();?>access/saveAsWarehouseNew/",
                        type: "POST",
                        data: {cl_array: cl_array, warehouse_type: warehouse_type, season: season, remarks_array: remarks_array},
                        dataType: "html",
                        success: function (data) {
//                            console.log(data);

                            if(data == 'DONE'){
                                location.reload();
                            }
                        }
                    });



        }else{
            alert("Please Select Warehouse Type / Season!");
        }
    }

//    function clickToSubmitBtn() {
//        var cl_no = $("#carelabel_tracking_no").val();
//        var care_label_no = cl_no.trim();
//
//        var last_variable = care_label_no.slice(-1);
//
//        var wh_code = $("#carelabel_tracking_no").val();
//        var warehouse_code = wh_code.trim();
//        var code_length = warehouse_code.length;
//
//        if(code_length == 8){
//            var fst_variable = warehouse_code.charAt(0);
//        }
//
//        if(care_label_no != '' && fst_variable != 'w' && last_variable == '.'){
//            document.getElementById("submit_btn").click();
//
//
//
//        }
//
//        if(care_label_no != '' && fst_variable == 'w' && last_variable == '.'){
//            $("#carelabel_tracking_no").val('');
//        }
//    }

    function getSizeWiseReport(po_no, so_no, po, item, quality, color) {
        $("#size_tbl").empty();
        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemWiseSizeWhReport/",
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
            url: "<?php echo base_url();?>access/getPoItemWiseSizeRemainWhCL/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }
</script>