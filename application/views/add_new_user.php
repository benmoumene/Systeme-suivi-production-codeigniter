<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>New User</h1>
        <h2 class="">New User...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">New User</li>
        </ol>
    </div>
</div>

<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/saveNewUser" method="POST">
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
                        <input required="required" class="form-control" type="text" name="user_name" id="user_name" onblur="checkUserAvailability();" />
                        <span style="font-size: 11px;">* Login Code</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input required="required" class="form-control" type="text" name="user_description" id="user_description" />
                        <span style="font-size: 11px;">* User Description</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select required="required" type="text" class="form-control" id="access_points" name="access_points">
                            <option value="">User Type...</option>
                            <option value="1000">Administrator</option>
                            <option value="0">Cutting</option>
                            <option value="1">Cutting Scan</option>
                            <option value="2">Line Input</option>
                            <option value="3">Mid Line QC</option>
                            <option value="4">End Line QC</option>
                            <option value="5">Finishing</option>
                            <option value="6">Washing</option>
                            <option value="7">Packing</option>
                            <option value="8">Collar-Cuff</option>
                            <option value="9">Carton</option>
                            <option value="200">OPR</option>
                            <option value="300">QA</option>
                            <option value="400">SD</option>
                            <option value="500">Production Admin</option>
                            <option value="600">Maintenance Admin</option>
                        </select>
                        <span style="font-size: 11px;">* USER TYPE</span>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control" id="floor_id" name="floor_id">
                            <option value="">Select Floor...</option>
                            <?php foreach ($floors as $f){ ?>
                                <option value="<?php echo $f['id'];?>"><?php echo $f['floor_name'];?></option>
                            <?php } ?>
                        </select>
                        <span style="font-size: 11px;"> Select Floor</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control" id="finishing_floor_id" name="finishing_floor_id">
                            <option value="">Select Finishing Floor...</option>
                            <?php foreach ($floors as $fn){ ?>
                                <option value="<?php echo $fn['id'];?>"><?php echo $fn['floor_name'];?></option>
                            <?php } ?>
                        </select>
                        <span style="font-size: 11px;"> Select Finishing Floor</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <select class="form-control" id="line_id" name="line_id">
                        <option value="">Select Line...</option>
                        <?php foreach ($lines as $l){ ?>
                            <option value="<?php echo $l['id'];?>"><?php echo $l['line_name'];?></option>
                        <?php } ?>
                    </select>
                    <span style="font-size: 11px;">Select Line</span>
                </div>

                <div class="col-md-3">
                    <select  required="required" class="form-control" id="status" name="status">
                        <option value="">Select Status...</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <span style="font-size: 11px;">* Status</span>
                </div>

                <div class="col-md-3">
                    <select class="form-control" multiple id="buyer_condition" name="buyer_condition[]" data-placeholder="Select Brands">
                        <?php foreach ($brands as $b){ ?>
                            <option value="<?php echo $b['brand'];?>"><?php echo $b['brand'];?></option>
                        <?php } ?>
                    </select>
                    <span style="font-size: 11px;">Buyer Condition</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group">


                <div class="col-md-3">
                    <button class="btn btn-success">SAVE</button>
                </div>


            </div>
        </div>

    </form>

</div>

<script type="text/javascript">
    $('select').select2();

    function checkUserAvailability() {

        var user_name=$("#user_name").val();

        if(user_name != ''){

            var user_name_last_char = user_name.charAt(user_name.length-1);

            if(user_name_last_char == '.'){
                $.ajax({
                    url:"<?php echo base_url('access/checkUserAvailability')?>",
                    type:"post",
                    dataType:'html',
                    data:{user_name: user_name},
                    success:function (data) {

                        if(data == 'available'){
                            alert('User Name is already available!');
                            location.reload();
                        }

                    }
                });
            }else{
                alert('Last Character has to be DOT(.) !');
                location.reload();
            }

        }else{
            alert('User name cannot be blank!');
        }

    }

</script>