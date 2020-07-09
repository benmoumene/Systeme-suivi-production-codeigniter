<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 35px;
        height: 35px;
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
        <h1>Line Target</h1>
        <h2 class="">Line Target Assign...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Line Target Assign</li>
        </ol>
    </div>
</div>
<form action="<?php echo base_url();?>access/assignLineTarget" method="post">
<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
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
            </div>
        </div>

        <div id="row">
<!--            <div class="col-md-2">-->
<!--                <div class="form-group">-->
<!---->
<!--                </div>-->
<!--            </div>-->

            <?php

            $cur_segment = $segment[0]['id'];

            ?>

            <div class="col-md-2">
                <div class="form-group">
                    <select name="segments" id="segments" required="required" onchange="lastSegmentLastHourFieldOpenClose()">

                        <option value="">Select Segment</option>

                        <?php foreach($segments as $v_segments){

                            if($v_segments['id'] >= $cur_segment){
                            ?>
                            <option value="<?php echo $v_segments['id']; ?>" <?php if($cur_segment == $v_segments['id']){ ?> selected="selected" <?php } ?>><?php echo $v_segments['name']; ?></option>
<!--                            <input type="hidden" name="segment_id" value="--><?php //echo $v_segments['id']; ?><!--">-->
                        <?php
                            }
                        }
                        ?>

                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="target_date" name="target_date" placeholder="Select Date" required="required" autocomplete="off" />
                </div>
            </div>

            <div class="col-md-2">
                <span class="btn btn-primary" onclick="getLineTarget();">Search</span>
            </div>

            <div class="col-md-1">
                <div class="loader" id="loader" style="display: none;"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                <div class="porlets-content">


                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->
        <div class="porlets-content">

                    <div id="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div id="set_form">
                                    <table class="display table table-bordered table-striped" id="sample_2">
                                        <thead>
                                            <tr>
                                                <th class="center">Line</th>
                                                <th class="center">Target Hour</th>
                                                <th class="center">Target</th>
                                                <th class="center">Man-Power</th>
                                                <th class="center">Remarks</th>
                                                <th class="center">Last Hour</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($lines as $k_1 => $v_l){ ?>
                                            <tr>
                                                <td class="center">
                                                    <?php echo $v_l['line_name'];?>
                                                    <input type="hidden" id="line_id<?php echo $k_1;?>" readonly name="line_id[]" value="<?php echo $v_l['id'];?>" required>
                                                </td>
                                                <td class="center">
                                                    <input type="text" placeholder="Target Hour" id="target_hr<?php echo $k_1;?>" name="target_hr[]">
                                                </td>
                                                <td class="center">
                                                    <input type="text" placeholder="Target" id="target<?php echo $k_1;?>" name="target[]">
                                                </td>
                                                <td class="center">
                                                    <input type="text" placeholder="Man-Power" id="mp<?php echo $k_1;?>" name="mp[]" onblur="lastSegmentTimeCheck(<?php echo $k_1;?>);">
                                                </td>
                                                <td class="center">
                                                    <input type="text" placeholder="Remarks" id="remarks<?php echo $k_1;?>" name="remarks[]">
                                                </td>
                                                <td class="center">
                                                    <input type="time" class="last_segment_time" placeholder="Last Segment Time" id="last_segment_time<?php echo $k_1;?>" name="last_segment_time[]" min="<?php echo $segments[3]['start_time'];?>" max="<?php echo $segments[3]['end_time'];?>" required="required" <?php if($cur_segment != 4){ ?> readonly="readonly" disabled="disabled" <?php } ?>>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

            </div><!--/porlets-content-->

    </div><!--/col-md-12-->
</div>
<div id="row">
    <div class="col-md-5">

    </div>
    <div class="col-md-7">
        <div class="form-group">
            <button class="btn btn-success">Save</button>
        </div>
    </div>
</div>
<!--/row-->
</form>

<script type="text/javascript">
    $('select').select2();

    function lastSegmentLastHourFieldOpenClose() {
        var segments = $("#segments").val();

        if(segments == 4){
            $(".last_segment_time").attr('required', true);
            $(".last_segment_time").attr('disabled', false);
            $(".last_segment_time").attr('readonly', false);
        }else{
            $(".last_segment_time").attr('required', false);
            $(".last_segment_time").attr('disabled', true);
            $(".last_segment_time").attr('readonly', true);
        }
    }

    function lastSegmentTimeCheck(row) {
        var segments = $("#segments").val();

        var mp = $("#mp"+row).val();
        mp = (mp != '' ? mp : 0);

        if(segments == 4){
            if(mp > 0){
                $("#last_segment_time"+row).attr('required', true);
                $("#last_segment_time"+row).attr('disabled', false);
                $("#last_segment_time"+row).attr('readonly', false);
            }else{
                $("#last_segment_time"+row).attr('required', false);
                $("#last_segment_time"+row).attr('disabled', true);
                $("#last_segment_time"+row).attr('readonly', true);
            }
        }


    }

    function getLineTarget() {
        var segment = $("#segments").val();

        var date = $("#target_date").val();
        var dt_parts = date.split("-");

        var mon = dt_parts[0];
        var dt = dt_parts[1];
        var yr = dt_parts[2];

        var target_date = yr+'-'+mon+'-'+dt;


        var cur_date = '<?php echo date("Y-m-d");?>';

        var count_tr = $('#sample_2 tbody tr').length;

        if(date != ''){
            if(cur_date <= target_date){
                $("#loader").css("display", "block");

                for(var i=0; i < count_tr; i++){
                    var line_id = $("#line_id"+i).val();

                    $("#target_hr"+i).val('');
                    $("#target"+i).val('');
                    $("#mp"+i).val('');
                    $("#remarks"+i).val('');

                    $.ajax({
                        async: false,
                        url: "<?php echo base_url();?>access/getLineTargetInfo",
                        type: "POST",
                        data: {target_date: target_date, line_id: line_id, segment: segment},
                        dataType: "json",
                        success: function (data) {

                            if(data.length > 0){
                                var target = data[0].target;
                                var target_hour = data[0].target_hour;

                                if(segment == 1){
                                    var mp = data[0].man_power_1;
                                }
                                if(segment == 2){
                                    var mp = data[0].man_power_2;
                                }
                                if(segment == 3){
                                    var mp = data[0].man_power_3;
                                }
                                if(segment == 4){
                                    var mp = data[0].man_power_4;
                                    mp = (mp != '' ? mp : 0);

                                    if(mp > 0){
                                        $("#last_segment_time"+i).attr('required', true);
                                    }else{
                                        $("#last_segment_time"+i).attr('required', false);
                                    }
                                }

                                var remarks = data[0].remarks;
                                var last_segment_time = (data[0].last_segment_time != '00:00:00' ? data[0].last_segment_time : '');

                                $("#target_hr"+i).val(target_hour);
                                $("#target"+i).val(target);
                                $("#mp"+i).val(mp);
                                $("#last_segment_time"+i).val(last_segment_time);
                                $("#remarks"+i).val(remarks);

                                $("#mp"+i).blur();

                                $("#loader").css("display", "none");
                            }
                        }
                    });
                }
            }else{
                alert("Please Select Up-Coming Dates!");
            }
        }else{
            alert('Please Select Date!');
        }
    }
</script>