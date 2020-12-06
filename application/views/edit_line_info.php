<?php

$line_id = $line_info[0]['id'];
$line_name = $line_info[0]['line_name'];
$line_code = $line_info[0]['line_code'];
$line_description = $line_info[0]['line_description'];
$floor = $line_info[0]['floor'];
$finishing_floor_id = $line_info[0]['finishing_floor_id'];
$status = $line_info[0]['status'];

?>

<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Edit Line</h1>
        <h2 class="">Edit Line Info...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Edit Line</li>
        </ol>
    </div>
</div>

<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/updateLineInfo" method="POST">
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
                            <input required="required" class="form-control" type="text" name="line_name" id="line_name" value="<?php echo $line_name;?>" />
                            <input required="required" class="form-control" type="hidden" name="line_id" id="line_id" value="<?php echo $line_id;?>" />
                            <span style="font-size: 11px;">* Line Name</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <input required="required" class="form-control" type="text" name="line_code" id="line_code" step="2" value="<?php echo $line_code;?>" />
                            <span style="font-size: 11px;">* Line Code</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <input required="required" class="form-control" type="text" name="line_description" id="line_description" step="2" value="<?php echo $line_description;?>" />
                            <span style="font-size: 11px;">* Line Description</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select  required="required" class="form-control" id="floor_id" name="floor_id">
                                <option value="">Select Floor</option>
                                <?php foreach ($floors as $f){ ?>
                                    <option value="<?php echo $f['id']?>" <?php echo ($f['id'] == $floor ? "selected='selected'" : '')?>>
                                        <?php echo $f['floor_name']?>
                                    </option>
                                <?php } ?>
                            </select>
                            <span style="font-size: 11px;">* Select Floor</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="form-group">

                    <div class="col-md-3">
                        <div class="form-group">
                            <select  required="required" class="form-control" id="finishing_floor_id" name="finishing_floor_id">
                                <option value="">Select Finishing Floor</option>
                                <?php foreach ($floors as $f){ ?>
                                    <option value="<?php echo $f['id']?>" <?php echo ($f['id'] == $finishing_floor_id ? "selected='selected'" : '')?>>
                                        <?php echo $f['floor_name']?>
                                    </option>
                                <?php } ?>
                            </select>
                            <span style="font-size: 11px;">* Finishing Floor</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select  required="required" class="form-control" id="status" name="status">
                                <option value="">Select Status...</option>
                                <option value="1" <?php echo ($status == 1 ? "selected='selected'" : '');?>>Active</option>
                                <option value="0" <?php echo ($status == 0 ? "selected='selected'" : '');?>>Inactive</option>
                            </select>
                            <span style="font-size: 11px;">* Status</span>
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