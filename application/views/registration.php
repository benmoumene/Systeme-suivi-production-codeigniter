<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Registration</title>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body class="light_theme  fixed_header left_nav_fixed">
<div class="wrapper">
    <!--\\\\\\\ wrapper Start \\\\\\-->

    <div class="login_page">
        <div class="registration">
            <div class="panel-heading border login_heading">Registration Form</div>
            <form role="form" class="form-horizontal" action="<?php echo base_url();?>register/registerEmployee" method="post">
                <div style="padding-top:10px">
                    <h6 style="color:red">
                        <?php
                        $exc = $this->session->userdata('exception');
                        if (isset($exc)) {
                            echo $exc;
                            $this->session->unset_userdata('exception');
                        }
                        ?>
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

                <div class="form-group">
                    <div class="col-sm-10">
                        <input type="text" placeholder="Employee ID" id="emp_id" name="emp_id" class="form-control" onblur="isEmpAlreadyavailable();" required />
                    </div>
                    <span style="color: red; display: none;" id="emp_msg">Employee ID Already Available!</span>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <select id="access_point" name="access_point" class="form-control" required>
                            <option value="">Select Access Point...</option>
                            <option value="2">Begin-Line Operator</option>
                            <option value="3">Mid-Line QC</option>
                            <option value="4">End-Line QC</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <select id="line" name="line" class="select2 form-control" required>
                            <option value="">Select Line...</option>
                            <?php
                            foreach ($lines as $v){ ?>
                                <option value="<?php echo $v['id']?>"><?php echo $v['line_name'].' - '.$v['floor_name'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-10">
                        <select id="status" name="status" class="form-control" required>
                            <option value="">Select Status...</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class=" col-sm-10">
                        <div class="checkbox checkbox_margin">
                            <a class="lable_margin">
                                <a href="" target="_blank" class="btn btn-primary">Search ID</a>
                            <a href="index.html">
                                <button id="submit_btn" class="btn btn-success pull-right" type="submit" disabled="disabled">SUBMIT</button>
                            </a></div>
                    </div>
                </div>

            </form>
        </div>
    </div>








</div>
<!--\\\\\\\ wrapper end\\\\\\-->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Compose New Task</h4>
            </div>
            <div class="modal-body"> content </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Compose New Task</h4>
            </div>
            <div class="modal-body"> sgxdfgxfg </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/jquery-2.1.0.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/js/common-script.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.slimscroll.min.js"></script>
</body>
</html>

<script>
    function isEmpAlreadyavailable() {
        var emp_id = $("#emp_id").val();


        if(emp_id != ''){
            $.ajax({
                url: "<?php echo base_url();?>register/isEmpAlreadyavailable/",
                type: "POST",
                data: {emp_id: emp_id},
                dataType: "html",
                success: function (data) {
                    if(data == 'proceed'){
                        $("#emp_msg").css('display', 'none');
                        $("#submit_btn").attr('disabled', false);
                    }

                    if(data == 'duplicate'){
                        $("#emp_msg").css('display', 'block');
                        $("#submit_btn").attr('disabled', 'disabled');
                    }
                }
            });
        }
    }
</script>