<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>New Floor</h1>
        <h2 class="">New Floor...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">New Floor</li>
        </ol>
    </div>
</div>

<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/saveNewFloor" method="POST">
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
                            <input required="required" class="form-control" type="text" name="floor_name" id="floor_name" />
                            <span style="font-size: 11px;">* Floor Name</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <input required="required" class="form-control" type="text" name="floor_code" id="floor_code" />
                            <span style="font-size: 11px;">* Floor Code</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <input required="required" class="form-control" type="text" name="floor_description" id="floor_description" />
                            <span style="font-size: 11px;">* Floor Description</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select required="required" class="form-control" id="is_finishing_floor" name="is_finishing_floor">
                                <option value="">Finishing Floor?</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            <span style="font-size: 11px;">* Finishing Floor?</span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="form-group">

                    <div class="col-md-3">
                        <div class="form-group">
                            <select  required="required" class="form-control" id="status" name="status">
                                <option value="">Select Status...</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span style="font-size: 11px;">* Status</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-success">SAVE</button>
                    </div>

                </div>
            </div>

    </form>

</div>

<script type="text/javascript">
    $('select').select2();
</script>