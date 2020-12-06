<?php

$segment_id = $segment_info[0]['id'];
$start_time = $segment_info[0]['start_time'];
$end_time = $segment_info[0]['end_time'];
$name = $segment_info[0]['name'];
$description = $segment_info[0]['description'];
$status = $segment_info[0]['status'];

?>

<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Edit Segment</h1>
        <h2 class="">Edit Segment Info...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Edit Segment</li>
        </ol>
    </div>
</div>

<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/updateSegmentInfo" method="POST">
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
                            <input required="required" class="form-control" type="time" name="start_time" id="start_time" step="2" value="<?php echo $start_time;?>" />
                            <input required="required" class="form-control" type="hidden" name="segment_id" id="segment_id" value="<?php echo $segment_id;?>" />
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
                        <div class="form-group">
                            <input required="required" class="form-control" type="text" name="name" id="name" value="<?php echo $name;?>" />
                            <span style="font-size: 11px;">* Name</span>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <input required="required" class="form-control" type="text" name="description" id="description" value="<?php echo $description;?>" />
                            <span style="font-size: 11px;">* Description</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-3">
                        <select  required="required" class="form-control" id="status" name="status">
                            <option value="">Select Status...</option>
                            <option value="1" <?php echo ($status == 1 ? "selected='selected'" : '');?>>Active</option>
                            <option value="0" <?php echo ($status == 0 ? "selected='selected'" : '');?>>Inactive</option>
                        </select>
                        <span style="font-size: 11px;">* Status</span>
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