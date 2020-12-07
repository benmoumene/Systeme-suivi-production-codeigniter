<?php

$user_id = $user_info[0]['id'];
$user_name = $user_info[0]['user_name'];
$user_description = $user_info[0]['user_description'];
$access_points = $user_info[0]['access_points'];
$floor_id = $user_info[0]['floor_id'];
$finishing_floor_id = $user_info[0]['finishing_floor_id'];
$line_id = $user_info[0]['line_id'];
$status = $user_info[0]['status'];
$buyer_condition = ltrim(str_replace("'","",$user_info[0]['buyer_condition'])); // Remove apostrophe(') and Spaces From String
$buyer_condition_array = explode(',', $buyer_condition);


//foreach ($brands as $bt){
//    foreach ($buyer_condition_array as $bc){
//        echo '<pre>';
//        print_r($bc.' '.$bt['brand']);
//        echo '</pre>';
//    }
//}


?>

<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Edit User</h1>
        <h2 class="">Edit User Info...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Edit User</li>
        </ol>
    </div>
</div>

<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/updateUserInfo" method="POST">
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
                            <input required="required" class="form-control" type="text" name="user_name" id="user_name" value="<?php echo $user_name;?>" onblur="checkUserAvailability();" />
                            <input required="required" class="form-control" type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>" />
                            <span style="font-size: 11px;">* Login Code</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <input required="required" class="form-control" type="text" name="user_description" id="user_description" value="<?php echo $user_description;?>" />
                            <span style="font-size: 11px;">* User Description</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select required="required" type="text" class="form-control" id="access_points" name="access_points">
                                <option value="">User Type...</option>
                                <option value="1000" <?php echo ($access_points == 1000 ? "selected='selected'" : '');?>>Administrator</option>
                                <option value="0" <?php echo ($access_points == 0 ? "selected='selected'" : '');?>>Cutting</option>
                                <option value="1" <?php echo ($access_points == 1 ? "selected='selected'" : '');?>>Cutting Scan</option>
                                <option value="2" <?php echo ($access_points == 2 ? "selected='selected'" : '');?>>Line Input</option>
                                <option value="3" <?php echo ($access_points == 3 ? "selected='selected'" : '');?>>Mid Line QC</option>
                                <option value="4" <?php echo ($access_points == 4 ? "selected='selected'" : '');?>>End Line QC</option>
                                <option value="5" <?php echo ($access_points == 5 ? "selected='selected'" : '');?>>Finishing</option>
                                <option value="6" <?php echo ($access_points == 6 ? "selected='selected'" : '');?>>Washing</option>
                                <option value="7" <?php echo ($access_points == 7 ? "selected='selected'" : '');?>>Packing</option>
                                <option value="8" <?php echo ($access_points == 8 ? "selected='selected'" : '');?>>Collar-Cuff</option>
                                <option value="9" <?php echo ($access_points == 9 ? "selected='selected'" : '');?>>Carton</option>
                                <option value="200" <?php echo ($access_points == 200 ? "selected='selected'" : '');?>>OPR</option>
                                <option value="300" <?php echo ($access_points == 300 ? "selected='selected'" : '');?>>QA</option>
                                <option value="400" <?php echo ($access_points == 400 ? "selected='selected'" : '');?>>SD</option>
                                <option value="500" <?php echo ($access_points == 500 ? "selected='selected'" : '');?>>Production Admin</option>
                                <option value="600" <?php echo ($access_points == 600 ? "selected='selected'" : '');?>>Maintenance Admin</option>
                            </select>
                            <span style="font-size: 11px;">* USER TYPE</span>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" id="floor_id" name="floor_id">
                                <option value="">Select Floor...</option>
                                <?php foreach ($floors as $f){ ?>
                                    <option value="<?php echo $f['id'];?>" <?php echo ($floor_id == $f['id'] ? "selected='selected'" : '');?>><?php echo $f['floor_name'];?></option>
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
                                    <option value="<?php echo $fn['id'];?>" <?php echo ($finishing_floor_id == $fn['id'] ? "selected='selected'" : '');?>><?php echo $fn['floor_name'];?></option>
                                <?php } ?>
                            </select>
                            <span style="font-size: 11px;"> Select Finishing Floor</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control" id="line_id" name="line_id">
                            <option value="">Select Line...</option>
                            <?php foreach ($lines as $l){ ?>
                                <option value="<?php echo $l['id'];?>" <?php echo ($line_id == $l['id'] ? "selected='selected'" : '');?>><?php echo $l['line_name'];?></option>
                            <?php } ?>
                        </select>
                        <span style="font-size: 11px;">Select Line</span>
                    </div>

                    <div class="col-md-3">
                        <select  required="required" class="form-control" id="status" name="status">
                            <option value="">Select Status...</option>
                            <option value="1" <?php echo ($status == 1 ? "selected='selected'" : '');?>>Active</option>
                            <option value="0" <?php echo ($status == 0 ? "selected='selected'" : '');?>>Inactive</option>
                        </select>
                        <span style="font-size: 11px;">* Status</span>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control" multiple id="buyer_condition" name="buyer_condition[]" data-placeholder="Select Brands">
                            <?php foreach ($brands as $b){ ?>
                                <option value="<?php echo $b['brand'];?>"

                                    <?php
                                        foreach ($buyer_condition_array as $brand) {
                                            echo($brand == $b['brand'] ? "selected='selected'" : '');
                                        }
                                    ?>

                                >
                                    <?php echo $b['brand'];?>
                                </option>
                            <?php } ?>
                        </select>
                        <span style="font-size: 11px;">* Buyer Condition</span>
                    </div>
                </div>
            </div>

        <div class="row">
            <div class="form-group">


                <div class="col-md-3">
                    <button class="btn btn-success">UPDATE</button>
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