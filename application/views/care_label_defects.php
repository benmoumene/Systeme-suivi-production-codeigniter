<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>CL Defects</h1>
          <h2 class="">CL Defects...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">CL Defects</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <form action="#" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="block-web">
                        <div class="header">
                            <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                        </div>

                        <div style="padding-top:10px">
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



                        <div class="col-md-3">
                            <input type="text" class="form-control" name="carelabel_tracking_no" required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />

                            <!--                  <input type="text" class="form-control" name="cut_tracking_no_1" required id="cut_tracking_no_1" />-->
                            <!--                  <span id="er_msg" style="color: red;"></span>-->
                            <!--                  <span id="s_msg" style="color: green;"></span>-->
                        </div>
                        <div class="col-md-3">
                            <button id="submit_btn_save" class="btn btn-success">Save</button>
                        </div>

                        <br />
                        <br />
                        <br />
                        <div class="porlets-content">


                        </div>

                    </div><!--/porlets-content-->
                </div><!--/block-web-->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="porlets-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <section class="panel default blue_title h2">
                                    <div class="panel-heading"> Defects<span class="semi-bold"></span> </div>
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


                                            <tr class="tr_clone">
                                                <td><input onkeyup="getTxt(id);" autofocus class="form-control defect_part" type="text" name="defect_part[]" id="defect_part0" /></td>
                                                <td><input onkeyup="getTxt_1(id);" autofocus class="form-control defect_code" type="text" name="defect_codes[]" id="defect_codes0" /></td>
                                                <td><span class="btn btn-danger" id="remove" onclick="deleteRow(this);">REMOVE</span></td>
                                            </tr>
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
        </form>
<!--          <div class="row">-->
<!--              <div class="col-md-12">-->
<!--                  <div class="block-web">-->
<!--                      <div class="header">-->
<!--                          <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>-->
<!--                      </div>-->
<!--                      <div class="col-md-3">-->
<!--                          <table id="sample_1" border="1">-->
<!--                              <thead>-->
<!--                              <tr>-->
<!--                                  <th>Care Label No.</th>-->
<!--                                  <th>Status</th>-->
<!--                              </tr>-->
<!--                              </thead>-->
<!--                              <tbody>-->
<!--                              <tr>-->
<!--                                  <td></td>-->
<!--                                  <td></td>-->
<!--                              </tr>-->
<!--                              </tbody>-->
<!--                          </table>-->
<!--                      </div>-->
<!--                  </div><!--/porlets-content-->
<!--              </div><!--/block-web-->
<!--          </div><!--/col-md-12-->
      </div>

<script type="text/javascript">

    $(document).ready(function(){

    });

//    $('input').keyup(function(){
//
//        var txt = $(this).val();
//        console.log(txt);
//
//        var first_variable = txt.substring(0, 2);
//        var last_variable = txt.slice(-1);
//
//        if((txt != '') && (first_variable == 'DP') && (last_variable == '.')){
//            $(this).parent().next().find('.defect_code').focus();
//        }
//    });
//
//    $('input').keyup(function(){
//
//        var txt = $(this).val();
//        console.log(txt);
//
//        var first_variable = txt.substring(0, 2);
//        var last_variable = txt.slice(-1);
//
//        if((txt != '') && (first_variable == 'DC') && (last_variable == '.')){
//            addNewRow();
//        }
//    });

    function getTxt(id){
        var txt = $("#"+id).val();
        var to_int = id.slice(11, 13);

        var first_variable = txt.substring(0, 2);
        var last_variable = txt.slice(-1);

        if((txt != '') && (first_variable == 'DP') && (last_variable == '.')){
            $('#defect_codes'+to_int).focus();
        }

        if((txt != '') && (first_variable != 'DP') && (last_variable == '.')){
            $('#carelabel_tracking_no').focus();
            $('#defect_code_tbl tbody').find('tr:last').remove();
            $('#carelabel_tracking_no').val(txt).keyup();
        }
    }

    function getTxt_1(id){
        var txt = $("#"+id).val();
        var first_variable = txt.substring(0, 2);
        var last_variable = txt.slice(-1);

        if((txt != '') && (first_variable == 'DC') && (last_variable == '.')){
            addNewRow();
        }

        if((txt != '') && (first_variable != 'DC') && (last_variable == '.')){
            $('#carelabel_tracking_no').focus();
            $('#defect_code_tbl tbody').find('tr:last').remove();
            $('#carelabel_tracking_no').val(txt).keyup();
        }
    }

    function clickToSubmitBtn() {
        var cl_no = $("#carelabel_tracking_no").val();
        var care_label_no = cl_no.trim();

        var last_variable = care_label_no.slice(-1);

        if(care_label_no != '' && last_variable == '.'){
//            document.getElementById("submit_btn").click();
            console.log("Form Submission");
            location.reload();
        }

//        if(last_variable == '.'){
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
//        }
//        else{
//            $("#s_msg").text('');
//            $("#er_msg").text('Failed to Send!');
//            $("#carelabel_tracking_no").val('');
//        }
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

    function addNewRow() {
        var rowCount = $('#defect_code_tbl tbody tr').length;

        var rowPlus = rowCount + 1;
console.log(rowPlus);
        $("#defect_code_tbl > tbody").append('<tr><td><input onkeyup="getTxt(id);" autofocus class="form-control defect_part" type="text" name="defect_part[]" id="defect_part' + rowPlus + '" /></td><td><input onkeyup="getTxt_1(id);" autofocus class="form-control defect_code" type="text" name="defect_codes[]" id="defect_codes' + rowPlus + '" /></td><td><span class="btn btn-danger" id="remove" onclick="deleteRow(this);">REMOVE</span></td></tr>');
//
        $('#defect_code_tbl .defect_part').last().focus();
    }


//    function autoFocusInput() {
//        $('#defect_code_tbl input').last().focus();
//    }

//    $(".defect_code").keyup(function(){
//        var txt = $('#defect_code_tbl input').last().val();
//        console.log(txt);
//    });


    function deleteRow(row)
    {
        var i = row.parentNode.parentNode.rowIndex;
        document.getElementById('defect_code_tbl').deleteRow(i);

        $('#defect_code_tbl .defect_part').last().focus();
    }
</script>