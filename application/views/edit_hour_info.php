<?php

$hour_id = $hour_info[0]['id'];
$hour = $hour_info[0]['hour'];
$start_time = $hour_info[0]['start_time'];
$end_time = $hour_info[0]['end_time'];

?>

<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Edit Hour</h1>
        <h2 class="">Edit Hour Info...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Edit Hour</li>
        </ol>
    </div>
</div>

<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/updateHourInfo" method="POST">
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
            </div><!--/block-web-->
        </div><!--/col-md-12-->
<!--        <div class="row">-->




            <div class="row">
                <div class="form-group">

                    <div class="col-md-3">
                        <div class="form-group">
                            <input required="required" readonly="readonly" class="form-control" type="text" name="hour" id="hour" value="<?php echo $hour;?>" />
                            <input required="required" class="form-control" type="hidden" name="hour_id" id="hour_id" value="<?php echo $hour_id;?>" />
                            <span style="font-size: 11px;">* Hour</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <input required="required" class="form-control" type="time" name="start_time" id="start_time" step="2" value="<?php echo $start_time;?>" />
                            <span style="font-size: 11px;">* Start Time</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <input required="required" class="form-control" type="time" name="end_time" id="end_time" step="2" value="<?php echo $end_time;?>" />
                            <span style="font-size: 11px;">* End Time</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-success">UPDATE</button>
                    </div>

                </div>
            </div>

    </form>

</div>

<script type="text/javascript">
    $('select').select2();
</script>