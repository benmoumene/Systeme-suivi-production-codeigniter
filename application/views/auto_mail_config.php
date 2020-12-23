<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1><?php echo $title;?></h1>
        <h2 class=""><?php echo $title;?>...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active"><?php echo $title;?></li>
        </ol>
    </div>
</div>

<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/saveAutoMailConfig" method="POST">
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
                        <select  required="required" class="form-control" id="email_config_id" name="email_config_id">
                            <option value="">Email Config Type</option>
                            <option value="0" <?php echo ($res[0]['email_type'] == 0 ? "selected='selected'" : '');?>>Local</option>
                            <option value="1" <?php echo ($res[0]['email_type'] == 1 ? "selected='selected'" : '');?>>Global</option>
                        </select>
                        <input type="hidden" id="auto_mail_id" name="auto_mail_id" value="<?php echo $res[0]['id'];?>" readonly="readonly" />
                        <span style="font-size: 11px;">* Email Config Type</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input required="required" class="form-control" type="text" name="description" id="description" value="<?php echo $res[0]['description'];?>" />
                        <span style="font-size: 11px;">* Description</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input class="form-control" type="text" name="date_condition_plus_minus" id="date_condition_plus_minus" value="<?php echo $res[0]['date_condition_plus_minus'];?>" />
                        <span style="font-size: 11px;"> Date Condition</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select  required="required" class="form-control" id="status" name="status">
                            <option value="">Select Status...</option>
                            <option value="1" <?php echo ($res[0]['status'] == 1 ? "selected='selected'" : '');?>>Active</option>
                            <option value="0" <?php echo ($res[0]['status'] == 0 ? "selected='selected'" : '');?>>Inactive</option>
                        </select>
                        <span style="font-size: 11px;">* Status</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="form-group">

                <div class="col-md-3">
                    <div class="form-group">
                        <textarea required="required" class="form-control" name="to_mail_address" id="to_mail_address" rows="10"><?php echo $res[0]['to_mail_address'];?></textarea>
                        <span style="font-size: 11px;">* To Mail Address</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <textarea class="form-control" name="cc_mail_address" id="cc_mail_address" rows="10"><?php echo $res[0]['cc_mail_address'];?></textarea>
                        <span style="font-size: 11px;"> CC Mail Address</span>
                    </div>
                </div>

                <div class="col-md-1">
                    <button class="btn btn-success">SAVE</button>
                </div>

                <div class="col-md-1">
                    <a href="<?php echo base_url();?>access/forceAutoMailSending/<?php echo $res[0]['id'];?>" class="btn btn-warning" target="_blank">SEND MAIL</a>
                </div>

            </div>
        </div>

    </form>

</div>

<script type="text/javascript">
    $('select').select2();
</script>