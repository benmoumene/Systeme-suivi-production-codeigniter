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
        <h1>Mid Line QC</h1>
        <h2 class="">Mid Line QC...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Mid Line QC</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <!--        <form action="--><?php //echo base_url();?><!--access/care_label_pass" method="post">-->
    <div class="row">
        <div class="col-md-12">
                <div class="panel-body">
                    <div class="porlets-content">
                        <h4><span id="p_er_msg" style="color: red; font-size: 30px; font-weight: 900;"></span></h4>
                        <h4><span id="p_s_msg" style="color: green; font-size: 30px; font-weight: 900;"></span></h4>
                        <div class="col-md-1">
<!--                            <div class="panel-heading" style="color: green;"> Pass<span class="semi-bold"></span> </div>-->

                            <input type="text" placeholder="Pass" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" autocomplete="off" onkeyup="submitClQcInfo();" />
                            <span style="">Pass</span>
                            <button style="display: none;" id="submit_btn_save_pass" class="btn btn-success">Save</button>
                            <span style="margin-top: 30px;" id="refresh_report" class="btn btn-primary" onclick="getLineMidOutputReport();">Report</span>
                            <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                        </div>
                        <div class="col-md-4">

<!--                                <div class="panel-heading" style="color: red;"> Defects<span class="semi-bold"></span> </div>-->
<!--                                <div class="panel-body">-->
                            <h4><span id="er_msg" style="color: red; font-size: 30px; font-weight: 900;"></span></h4>
                            <h4><span id="s_msg" style="color: green; font-size: 30px; font-weight: 900;"></span></h4>
                                    <div class="col-md-6">
                                        <input type="text" placeholder="Defect" class="form-control" name="carelabel_tracking_no_defect" required id="carelabel_tracking_no_defect" onkeyup="submitClQcDefectInfo();" />
                                        <span style=""> Defect</span>

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
<!--                                </div>-->
                            <!--/col-md-6-->
                        </div>
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-8 scroll3">
                                    <div class="block-web">

                                        <div class="porlets-content">

                                            <div class="table-responsive" id="size_tbl">
                                                <table class="display table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th class="center">Size</th>
                                                        <th class="center">Cut</th>
                                                        <th class="center">Line Input</th>
                                                        <th class="center">Mid Pass</th>
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

<!--                                <div class="col-md-4">-->
<!--                                    <div class="">-->
<!---->
<!--                                        <div class="porlets-content">-->
<!---->
<!--                                            <div class="table-responsive">-->
<!--                                                <table class="display table table-bordered table-striped" id="">-->
<!--                                                    <thead>-->
<!--                                                    <tr>-->
<!--                                                        <th class="hidden-phone center"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/poWiseCuttingReport" class="btn btn-danger">Cutting</a></th>-->
<!--                                                        <th class="hidden-phone center" colspan="2"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/lineWisePoItemReport" class="btn btn-primary">LINE</a></th>-->
<!--                                                        <th class="hidden-phone center" colspan="3"><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/poWisePackingReport" class="btn btn-success">Packing</a></th>-->
<!--                                                    </tr>-->
<!--                                                    </thead>-->
<!--                                                    <tbody>-->
<!---->
<!--                                                    </tbody>-->
<!--                                                </table>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!---->
<!--                                    </div>-->
<!--                                </div>-->

                            </div><!--/col-md-12-->
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
//                                $prod_summary = $this->method_call->getProductionSummaryReport();
                                ?>
                                <div class="block-web">

                                    <div class="porlets-content">

                                        <div class="table-responsive">
                                            <table class="display table table-bordered table-striped" id="">
                                                <thead>
                                                <tr>
                                                    <th class="hidden-phone" colspan="6"></th>
                                                    <th class="hidden-phone center" colspan="3">Sewing</th>
                                                </tr>
                                                <tr>
                                                    <th class="hidden-phone center">PO-ITEM</th>
                                                    <th class="hidden-phone center">Brand</th>
                                                    <th class="hidden-phone center">STL</th>
                                                    <th class="hidden-phone center">QL-CLR</th>
                                                    <th class="hidden-phone center">Order</th>
                                                    <th class="hidden-phone center">ExFac</th>
                                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Line Input">Input</span></th>
                                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Mid-Line Pass QTY">Mid QC</span></th>
                                                    <th class="hidden-phone center"><span data-toggle="tooltip" title="Balance QTY">Balance</span></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($prod_summary as $k => $v){
                                                    if (($v['count_input_qty_line'] - $v['count_end_line_qc_pass']) != 0) {
                                                        ?>
                                                        <tr>
                                                            <td class="hidden-phone center"><span
                                                                        style="color: #727dff; cursor: pointer;"
                                                                        onclick="getSizeWiseReport('<?php echo $v['po_no'];?>', '<?php echo $v['purchase_order']; ?>','<?php echo $v['item']; ?>');"><?php echo $v['purchase_order'] . '-' . $v['item']; ?></span>
                                                            </td>
                                                            <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                                                            <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                                                            <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                                                            <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                                                            <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                                                            <td class="hidden-phone center" style="color: #ffffff; font-size: 20px; background-color: darkblue;"><?php echo $v['count_input_qty_line']; ?></td>
                                                            <td class="hidden-phone center" <?php if($v['count_mid_line_qc_pass'] > $v['count_end_line_qc_pass']){ ?>style="background-color: red;" <?php } ?> <?php if($v['count_mid_line_qc_pass'] == $v['count_end_line_qc_pass']){ ?>style="background-color: darkgreen;" <?php } ?>>
                                                                <span style="color: white; font-size: 20px;"><?php echo $v['count_mid_line_qc_pass']; ?></span>
                                                            </td>
                                                            <td class="hidden-phone center">
                                                                <?php echo $v['count_input_qty_line'] - $v['count_mid_line_qc_pass']; ?>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                </tbody>
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
//            setInterval(function(){
//                $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReport');
//            }, 60000);
//            $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReport');

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

        function getLineMidOutputReport() {
            $("#loader").css("display", "block");
//            $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReport');

            $("#reload_div").empty();

//            setInterval(function(){
//                $("#loader").css("display", "none");
//            }, 15000);

            $.ajax({
                url: "<?php echo base_url();?>access/getProductionSummaryReport/",
                type: "POST",
                data: {},
                dataType: "html",
                success: function (data) {
                    $("#reload_div").append(data);
                    $("#loader").css("display", "none");
                }
            });

        }

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
//                $('#carelabel_tracking_no_defect').focus();
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

            if((code_length == 7) && (first_variable == 'DP') && (first_variable != 'Dp') && (last_variable == '.')){
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
                console.log(code_length + "IN 7");
            }

            if((code_length == 10) && (rowCount == 0) && (carelabel_tracking_no != '') && (first_variable != 'DP') && (first_variable != 'Dp') && (first_variable != 'DC') && (first_variable != 'Dc') && (last_variable == '.')){
//                $("#p_er_msg").empty();
//                $("#er_msg").empty();
//                $("#s_msg").empty();
//                $("#p_s_msg").empty();
//                $("#p_s_msg").text('Successfully Passed!');
//
//                $("#carelabel_tracking_no").val('');
//                $("#carelabel_tracking_no").focus();
                $("#carelabel_tracking_no").attr('readonly', true);
                $("#loader").css("display", "block");

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>access/careLabelMidPassSave/",
                    data: {cl_track_no_defect: carelabel_tracking_no, access_points_status: 1},
                    dataType: "html",
                    success: function (data) {

                        if(data != ''){
                            $("#p_er_msg").empty();
                            $("#er_msg").empty();
                            $("#s_msg").empty();
                            $("#p_s_msg").empty();

                            if((data == 'Line mismatch found!') || (data == 'Previous process in WIP!') || (data == 'Already Defect Found!')){
                                $("#p_er_msg").text(carelabel_tracking_no+' '+data);
//                                location.reload();
                            }

                            if((data == 'Already Passed!') || (data == 'Successfully Passed!')){
                                $("#p_s_msg").text(carelabel_tracking_no+' '+data);
//                                location.reload();
                            }

                            if((data == 'Not Found')){
                                $("#er_msg").text(carelabel_tracking_no+' '+data);
                            }

                            if((data == 'closed')){
                                $("#er_msg").text(carelabel_tracking_no+' is Closed!');
                            }

                            $('#defect_code_tbl tbody tr').remove();

                            $("#carelabel_tracking_no_defect").val('');
                            $("#carelabel_tracking_no").val('');
                            $("#carelabel_tracking_no").focus();
                        }
                        $("#loader").css("display", "none");
                        $("#carelabel_tracking_no").attr('readonly', false);
                    }
                });
            }
//            console.log(code_length);
//            console.log(first_variable);
//            console.log(last_variable);
            if((code_length == 7) && ((first_variable == 'DC') || (first_variable == 'Dc')) && (last_variable == '.')){
                console.log("7 IN");
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

            if((code_length == 7) && (first_variable == 'DP') && (first_variable != 'Dp') && (last_variable == '.')){
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

            if((code_length == 10) && (rowCount > 0) && (carelabel_tracking_no_defect != '') && (last_variable == '.')){
                console.log("Submit Defect");

                $("#carelabel_tracking_no").attr('readonly', true);
                $("#loader").css("display", "block");

//            location.reload();

                var cl_track_no_defect = $("#carelabel_tracking_no_defect").val();
                var defect_part_array = $("input[name='defect_part[]']").map(function(){return $(this).val();}).get();
                var defect_codes_array = $("input[name='defect_codes[]']").map(function(){return $(this).val();}).get();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>access/careLabelMidDefectSave/",
                    data: {defect_part_array: defect_part_array, defect_codes_array: defect_codes_array, cl_track_no_defect: cl_track_no_defect, access_points_status: 2},
                    dataType: "html",
                    success: function (data) {
                        if(data != ''){
                            $("#p_er_msg").empty();
                            $("#er_msg").empty();
                            $("#s_msg").empty();
                            $("#p_s_msg").empty();

                            if((data == 'Line mismatch found!') || (data == 'Previous process in WIP!') || (data == 'Already Defect Found!')){
                                $("#er_msg").text(cl_track_no_defect+' '+data);
                            }

                            if((data == 'This Process already passed!') || (data == 'Already Passed!') || (data == 'Defect Tracked!')){
                                $("#s_msg").text(cl_track_no_defect+' '+data);
                            }

                            if(data == 'closed'){
                                $("#er_msg").text(cl_track_no_defect+' is Closed!');
                            }

                            $('#defect_code_tbl tbody tr').remove();

                            $("#carelabel_tracking_no_defect").val('');
                            $("#carelabel_tracking_no").val('');
                            $("#carelabel_tracking_no").focus();
                        }
                        $("#loader").css("display", "none");
                        $("#carelabel_tracking_no").attr('readonly', false);
                    }
                });
            }
            if((code_length == 10) && (rowCount == 0) && (carelabel_tracking_no_defect != '') && (last_variable == '.')){
                $("#p_er_msg").empty();
                $("#er_msg").empty();
                $("#s_msg").empty();
                $("#p_s_msg").empty();

                $("#er_msg").text("No Defect Selected!");
                $("#carelabel_tracking_no_defect").val('');
                $("#carelabel_tracking_no").focus();
            }
        }

        function getSizeWiseReport(po_no, so_no, po, item, quality, color) {
            $("#size_tbl").empty();
            $("#loader").css("display", "block");

            $.ajax({
                url: "<?php echo base_url();?>access/getPoItemWiseSizeMidPassReport/",
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
                url: "<?php echo base_url();?>access/getPoItemWiseSizeRemainMidCL/",
                type: "POST",
                data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color, size: size},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }

        function getRemainingLinePcs(po_no, so_no, purchase_order, item, quality, color) {
            $("#remain_cl_list").empty();

            $.ajax({
                url: "<?php echo base_url();?>access/getRemainingLineMidQcPcs/",
                type: "POST",
                data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color},
                dataType: "html",
                success: function (data) {
                    $("#remain_cl_list").append(data);
                }
            });
        }
    </script>