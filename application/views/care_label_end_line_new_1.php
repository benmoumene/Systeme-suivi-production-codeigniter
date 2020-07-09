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
<!--        <form action="--><?php //echo base_url();?><!--access/care_label_pass" method="post">-->
        <div class="row">
            <div class="col-md-6">
                <section class="panel default blue_title h2">
                    <div class="panel-heading" style="color: green;"> Pass<span class="semi-bold"></span> </div>
                    <div class="panel-body">

              <div style="">
                  <h6 style="color:red">
                      <?php
                      $exc = $this->session->userdata('exception');
                      if (isset($exc)) {
                          echo $exc;
                          $this->session->unset_userdata('exception');
                      } ?>
                  </h6>

                  <h6 style="color:green">
                      <?php
                      $msg = $this->session->userdata('message');
                      if (isset($msg)) {
                          echo $msg;
                          $this->session->unset_userdata('message');
                      }
                      ?>
                  </h6>
              </div>

               <div class="porlets-content">
                   <div class="col-md-6">
                       <input type="text" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" onkeyup="submitClQcInfo();" />
                   </div>

                   <span id="p_er_msg" style="color: red;"></span>
                   <span id="p_s_msg" style="color: green;"></span>

                   <div class="col-md-6">
                       <button style="display: none;" id="submit_btn_save_pass" class="btn btn-success">Save</button>
                   </div>
               </div>

          </div><!--/block-web-->
                </section><!--/porlets-content-->
        </div><!--/col-md-12-->
<!--            <div class="row">-->
<!--                <div class="col-md-6">-->
<!--                    <section class="panel default blue_title h2">-->
<!--                        <div class="panel-body">-->
<!--                            <button style="display: none;" type="submit" name="accept_btn" id="accept_btn" class="btn btn-success btn-lg">Pass</button>-->
<!--                            &nbsp;-->
<!--                            <a href="--><?php //echo base_url();?><!--access/clDefects" target="_blank" name="defect_btn" id="" class="btn btn-warning btn-lg">Defects</a>-->
<!---->
<!--                            <span name="defect_btn" id="defect_btn" class="btn btn-warning btn-lg" onclick="defectFormFocus();">Defects-N</span>-->
<!--                            &nbsp;-->
<!--                            <a href="--><?php //echo base_url();?><!--access/clRejection" target="_blank" name="reject_btn" id="reject_btn" class="btn btn-danger btn-lg">Reject</a>-->
<!---->
<!--                        </div>-->
<!--                    </section>-->
<!--                <!--/col-md-6-->
<!--                </div>-->
<!--            </div>-->
            </div>

            <div class="row">
                <div class="col-md-6">
                    <section class="panel default blue_title h2">
                        <div class="panel-heading"> Defects<span class="semi-bold"></span> </div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="carelabel_tracking_no_defect" required id="carelabel_tracking_no_defect" onkeyup="submitClQcDefectInfo();" />

                                <span id="er_msg" style="color: red;"></span>
                                <span id="s_msg" style="color: green;"></span>
                            </div>
                            <div class="col-md-6">
                                <button style="display: none;" id="submit_btn_save_defect" class="btn btn-success">Save</button>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="porlets-content">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <section class="panel default blue_title h2">
                                                    <div class="panel-body">

                                                        <table class="table table-bordered" id="defect_code_tbl">
                                                            <thead>
                                                            <tr>
                                                                <th class="center">Defect Part</th>
                                                                <th class="center">Defect Code</th>
                                                                <th class="center">Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
<!--                                                                <tr>-->
<!--                                                                    <td><input onkeyup="getTxt(id);" autofocus class="form-control defect_part" type="text" name="defect_part[]" id="defect_part0" /></td>-->
<!--                                                                    <td><input onkeyup="getTxt_1(id);" autofocus class="form-control defect_code" type="text" name="defect_codes[]" id="defect_codes0" /></td>-->
<!--                                                                    <td><span class="btn btn-danger" id="remove" onclick="deleteRow(this);">REMOVE</span></td>-->
<!--                                                                </tr>-->
                                                            </tbody>
                                                            <tfoot>
                                                            <td colspan="2"></td>
                                                            <td><span class="btn btn-success" id="add_btn" onclick="addNewRow();">ADD</span></td>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                    <div></div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>

                                </div><!--/block-web-->
                            </div><!--/col-md-12-->
                        </div>
                    </section>
                <!--/col-md-6-->
                </div>

            </div>
<!--                    </form>-->

<script type="text/javascript">

    function getTxt(id){
        var txt = $("#"+id).val();
        var to_int = id.slice(11, 13);

        var first_variable = txt.substring(0, 2);
        var last_variable = txt.slice(-1);

        if((first_variable == 'Dp') && (last_variable == '.')){
            $('#defect_part'+to_int).val('');
        }

        if((txt != '') && (first_variable == 'DP') && (last_variable == '.')){
            $('#defect_codes'+to_int).focus();
        }

        if((txt != '') && (first_variable == 'DC') && (last_variable == '.')){
            $('#defect_part'+to_int).val('');
            $('#defect_part'+to_int).focus();
        }

        if((txt != '') && (first_variable != 'DP') && (first_variable != 'Dp') && (first_variable != 'DC') && (first_variable != 'Dc') && (last_variable == '.')){
//            $('#carelabel_tracking_no_defect').focus();
            $('#defect_code_tbl tbody').find('tr:last').remove();
            $('#carelabel_tracking_no_defect').val(txt).keyup();
        }
    }

    function getTxt_1(id){
        var txt = $("#"+id).val();
        var first_variable = txt.substring(0, 2);
        var last_variable = txt.slice(-1);
        var to_int = id.slice(12, 14);

//        var txt_1 = $("#defect_part"+to_int).val();

        if((first_variable == 'Dc') && (last_variable == '.')){
            $('#defect_codes'+to_int).val('');
        }

        if((txt != '') && (first_variable == 'DC') && (last_variable == '.')){
            addNewRow();
        }

        if((txt != '') && (first_variable == 'DP') && (last_variable == '.')){
            $("#"+id).val('');
        }

        if((txt != '') && (first_variable != 'DC') && (first_variable != 'Dc') && (first_variable != 'DP') && (first_variable != 'Dp') && (last_variable == '.')){
//            $('#carelabel_tracking_no_defect').focus();
            $('#defect_code_tbl tbody').find('tr:last').remove();
            $('#carelabel_tracking_no_defect').val(txt).keyup();
        }
    }


    function addNewRow() {
        var rowCount = $('#defect_code_tbl tbody tr').length;

        var res = $("#defect_code_tbl tbody tr:last input:first").attr('id');
//        console.log($("#defect_code_tbl tbody tr:last input:first").attr('id'));

        console.log(res);
        console.log(rowCount);

        if(rowCount == 0){
            console.log(res);
            var rowPlus = rowCount + 1;

            $("#defect_code_tbl > tbody").append('<tr><td><input onkeyup="getTxt(id);" class="form-control defect_part" type="text" name="defect_part[]" id="defect_part' + rowPlus + '" /></td><td><input onkeyup="getTxt_1(id);" class="form-control defect_code" type="text" name="defect_codes[]" id="defect_codes' + rowPlus + '" /></td><td><span class="btn btn-danger" id="remove" onclick="deleteRow(this);">REMOVE</span></td></tr>');

            $('#defect_code_tbl .defect_part').last().focus();
        }
        if(rowCount > 0){
            console.log(res);
            var to_int = res.slice(11, 13);

            var rowPlus = parseInt(to_int) + 1;

            $("#defect_code_tbl > tbody").append('<tr><td><input onkeyup="getTxt(id);" class="form-control defect_part" type="text" name="defect_part[]" id="defect_part' + rowPlus + '" /></td><td><input onkeyup="getTxt_1(id);" class="form-control defect_code" type="text" name="defect_codes[]" id="defect_codes' + rowPlus + '" /></td><td><span class="btn btn-danger" id="remove" onclick="deleteRow(this);">REMOVE</span></td></tr>');

            $('#defect_code_tbl .defect_part').last().focus();
        }
    }


//    //    function autoFocusInput() {
//    //        $('#defect_code_tbl input').last().focus();
//    //    }
//
//    //    $(".defect_code").keyup(function(){
//    //        var txt = $('#defect_code_tbl input').last().val();
//    //        console.log(txt);
//    //    });
//
//
    function deleteRow(row)
    {
        console.log(row);
        var i = row.parentNode.parentNode.rowIndex;
        document.getElementById('defect_code_tbl').deleteRow(i);

        $('#defect_code_tbl .defect_part').last().focus();
    }

    function submitClQcInfo(){
        var carelabel_tracking_no = $("#carelabel_tracking_no").val();

        var code_length = carelabel_tracking_no.length;

        var first_variable = carelabel_tracking_no.substring(0, 2);
        var last_variable = carelabel_tracking_no.slice(-1);

        var rowCount = $('#defect_code_tbl tbody tr').length;

        if((code_length < 8) && (first_variable == 'DP') && (first_variable != 'Dp') && (last_variable == '.')){
            $('#defect_code_tbl tbody tr').remove();
            addNewRow();

            var defect_part_code = carelabel_tracking_no;

            $('#defect_part1').focus();
            $('#defect_part1').val(defect_part_code).keyup();
            $('#carelabel_tracking_no').val('');

//            var rowCount = $('#defect_code_tbl tbody tr').length;
//
//            if((code_length < 9) && (rowCount > 0) && (carelabel_tracking_no != '') && (first_variable == 'DP') && (last_variable == '.')){
//                console.log("Submit Defect");
//            }
        }

        if((code_length == 8) && (rowCount == 0) && (carelabel_tracking_no != '') && (first_variable != 'DP') && (first_variable != 'Dp') && (first_variable != 'DC') && (first_variable != 'Dc') && (last_variable == '.')){
//            $("#p_er_msg").empty();
//            $("#er_msg").empty();
//            $("#s_msg").empty();
//            $("#p_s_msg").empty();
//            $("#p_s_msg").text('Successfully Passed!');
//
//            $("#carelabel_tracking_no").val('');
//            $("#carelabel_tracking_no").focus();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>access/careLabelEndPassSave/",
                data: {cl_track_no_defect: carelabel_tracking_no, access_points_status: 4},
                dataType: "html",
                success: function (data) {
                    if(data != ''){
                        $("#p_er_msg").empty();
                        $("#er_msg").empty();
                        $("#s_msg").empty();
                        $("#p_s_msg").empty();

                        if((data == 'Line mismatch found!') || (data == 'Previous process in WIP!') || (data == 'Already Defect Found!')){
                            $("#p_er_msg").text(data);
                        }

                        if((data == 'This Process already passed!') || (data == 'Successfully Passed!')){
                            $("#p_s_msg").text(data);
                        }

                        $('#defect_code_tbl tbody tr').remove();

                        $("#carelabel_tracking_no_defect").val('');
                        $("#carelabel_tracking_no").val('');
                        $("#carelabel_tracking_no").focus();
                    }
                }
            });
        }
        console.log(code_length);
        console.log(first_variable);
        console.log(last_variable);
        if((code_length == 7) && ((first_variable == 'DC') || (first_variable == 'Dc')) && (last_variable == '.')){
            console.log("IN");
            $("#carelabel_tracking_no").val('');
            $("#carelabel_tracking_no").focus();
        }
    }

    function submitClQcDefectInfo(){
        var carelabel_tracking_no_defect = $("#carelabel_tracking_no_defect").val();

        var code_length = carelabel_tracking_no_defect.length;


        var first_variable = carelabel_tracking_no_defect.substring(0, 2);
        var last_variable = carelabel_tracking_no_defect.slice(-1);

        var rowCount = $('#defect_code_tbl tbody tr').length;

        if((code_length < 8) && (first_variable == 'DP') && (first_variable != 'Dp') && (last_variable == '.')){
            $('#defect_code_tbl tbody tr').remove();
            addNewRow();

            var defect_part_code = carelabel_tracking_no_defect;

            $('#defect_part1').focus();
            $('#defect_part1').val(defect_part_code).keyup();
            $('#carelabel_tracking_no_defect').val('');
        }

        if((code_length < 8) && (first_variable == 'DC') && (first_variable != 'Dc') && (last_variable == '.')){
            $('#carelabel_tracking_no_defect').val('');
            $('#carelabel_tracking_no_defect').focus();
        }

        if((code_length == 8) && (rowCount > 0) && (carelabel_tracking_no_defect != '') && (last_variable == '.')){
            console.log("Submit Defect");
//            location.reload();

            var cl_track_no_defect = $("#carelabel_tracking_no_defect").val();
            var defect_part_array = $("input[name='defect_part[]']").map(function(){return $(this).val();}).get();
            var defect_codes_array = $("input[name='defect_codes[]']").map(function(){return $(this).val();}).get();

            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>access/careLabelEndDefectSave/",
                data: {defect_part_array: defect_part_array, defect_codes_array: defect_codes_array, cl_track_no_defect: cl_track_no_defect, access_points_status: 2},
                dataType: "html",
                success: function (data) {
                    if(data != ''){
                        $("#p_er_msg").empty();
                        $("#er_msg").empty();
                        $("#s_msg").empty();
                        $("#p_s_msg").empty();

                        if((data == 'Line mismatch found!') || (data == 'Previous process in WIP!') || (data == 'Already Defect Found!')){
                            $("#er_msg").text(data);
                        }

                        if((data == 'This Process already passed!') || (data == 'Already Passed!') || (data == 'Successful!') || (data == 'Defects Updated!')){
                            $("#s_msg").text(data);
                        }

                        $('#defect_code_tbl tbody tr').remove();

                        $("#carelabel_tracking_no_defect").val('');
                        $("#carelabel_tracking_no").val('');
                        $("#carelabel_tracking_no").focus();
                    }
                }
            });
        }
        if((code_length == 8) && (rowCount == 0) && (carelabel_tracking_no_defect != '') && (last_variable == '.')){
            $("#p_er_msg").empty();
            $("#er_msg").empty();
            $("#s_msg").empty();
            $("#p_s_msg").empty();

            $("#er_msg").text("No Defect Selected!");
            $("#carelabel_tracking_no_defect").val('');
            $("#carelabel_tracking_no").focus();
        }
    }
</script>