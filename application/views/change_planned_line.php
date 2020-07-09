<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Change-Planned Line</h1>
        <h2 class="">Change-Planned Line...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Change- Planned Line</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">Change- Planned Line</h3>
            </div>
        </div>


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
                <div class="porlets-content">


                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->
        <div class="porlets-content">
            <form action="<?php echo base_url();?>access/changingPlannedLine" method="post">

                <div id="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div id="set_form">
                                <table class="display table table-bordered table-striped" id="sample_2">
                                    <tbody>
                                    <tr>
                                        <td class="center" colspan="2">
                                            <span id="so_msg" style="color: red;"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center">SO No *</td>
                                        <td class="center">
                                            <select required id="so_no" name="so_no" onchange="soNoSelectionCheck();">
                                                <option value="">Select SO No</option>
                                                <?php foreach ($so_nos as $v_s){ ?>
                                                    <option value="<?php echo $v_s['so_no'];?>"><?php echo $v_s['so_no'];?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center">Cut No *</td>
                                        <td class="center">
                                            <select id="cut_no" name="cut_no" required onchange="cutNoSelectionCheck();">
                                                <option value="">Select Cut No</option>
                                                <?php foreach ($cut_no as $v_c){ ?>
                                                    <option value="<?php echo $v_c['cut_no'];?>"><?php echo $v_c['cut_no'];?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center">Size *</td>
                                        <td class="center">
                                            <select id="size" name="size" required onchange="lineSelectionCheck();">
                                                <option value="">Select Size</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center">Planned Line  *</td>
                                        <td class="center">
                                            <select id="line_no_from" name="line_no_from" required onchange="getTotalScannedQtyBundle();">
                                                <option value="">Select Line</option>
                                                <?php foreach ($lines as $v_l){ ?>
                                                    <option value="<?php echo $v_l['id'];?>"><?php echo $v_l['line_name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center">Total Scanned Qty *</td>
                                        <td class="center">
                                            <input type="text" name="scanned_qty" id="scanned_qty" readonly />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center">Assign To *</td>
                                        <td class="center">
                                            <select id="line_no_to" name="line_no_to" required>
                                                <option value="">Select Line</option>
                                                <?php foreach ($lines as $v_l){ ?>
                                                    <option value="<?php echo $v_l['id'];?>"><?php echo $v_l['line_name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="center"></td>
                                        <td class="center">
                                            <button type="submit" class="btn btn-success" id="submit_btn" name="submit_btn">Save</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div><!--/porlets-content-->

    </div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('#so_no').select2();

    function soNoSelectionCheck() {
        $("#so_msg").empty();
        document.getElementById("cut_no").value = "";
        document.getElementById("line_no_from").value = "";
        $("#scanned_qty").val('');
    }

    function lineSelectionCheck() {
        document.getElementById("line_no_from").value = "";
        document.getElementById("line_no_to").value = "";
        $("#scanned_qty").val('');
    }

    function cutNoSelectionCheck() {
        document.getElementById("line_no_to").value = "";
        document.getElementById("line_no_from").value = "";
        $("#scanned_qty").val('');

        $("#size").empty();

        var so_no = $("#so_no").val();
        var cut_no = $("#cut_no").val();

        if(cut_no != ''){
            $.ajax({
                url: "<?php echo base_url();?>access/getAllSizesByCutNo/",
                type: "POST",
                data: {so_no: so_no, cut_no: cut_no},
                dataType: "html",
                success: function (data) {
                    $("#size").append(data);
                }
            });
        }
    }

    function getTotalScannedQtyBundle(){
        $("#so_msg").empty();

        $("#scanned_qty").val('');

        var so_no = $("#so_no").val();
        var cut_no = $("#cut_no").val();
        var size = $("#size").val();
        var line_no_from = $("#line_no_from").val();


        if(so_no != '' && cut_no != '' && line_no_from != ''){

            $.ajax({
                url: "<?php echo base_url();?>access/getTotalScannedQtyBundle/",
                type: "POST",
                data: {so_no: so_no, cut_no: cut_no, size: size, line_no_from: line_no_from},
                dataType: "json",
                success: function (data) {
                    $("#scanned_qty").val(data[0].line_scan_qty);
                }
            });

        }else {
            $("#so_msg").text("Please Select: SO / CUT NO / ASSIGN FROM");
        }
    }
</script>