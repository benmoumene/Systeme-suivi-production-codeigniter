<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>User List</h1>
        <h2 class="">User List...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">User List</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
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
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" class="form-control" name="login_code" id="login_code" placeholder="Login Code" />
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" id="user_type" name="user_type">
                        <option value="">Select User Type</option>
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
                        <option value="700">Store</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" id="floor_id" name="floor_id">
                        <option value="">Select Floor</option>

                        <?php foreach ($floors AS $f){ ?>
                            <option value="<?php echo $f['id'];?>"><?php echo $f['floor_name'];?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" id="finishing_floor_id" name="finishing_floor_id">
                        <option value="">Select Finishing Floor</option>

                        <?php foreach ($finishing_floors AS $ff){ ?>
                            <option value="<?php echo $ff['id'];?>"><?php echo $ff['floor_name'];?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <select class="form-control" id="line_id" name="line_id">
                        <option value="">Select Line</option>

                        <?php foreach ($lines AS $l){ ?>
                            <option value="<?php echo $l['id'];?>"><?php echo $l['line_name'];?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <span class="btn btn-primary" onclick="getFilteredUserList();">SEARCH</span>
                </div>
            </div>
        </div>
    </div>

    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="col-md-12">
            <div class="block-web">

                <div class="col-md-1">
                    <span class="btn btn-primary" title="PRINT QR CODE" onclick="printQRCodes()"> <i class="fa fa-print"></i> PRINT</span>
                </div>
                <div class="col-md-1">
                    <a href="<?php echo base_url();?>access/addNewUser" class="btn btn-success" title="ADD USER"> <i class="fa fa-plus"></i> USER</a>
                </div>
                <br />
                <br />
                <br />
                <div class="porlets-content">

                    <div class="table-responsive">
                        <table class="display table table-bordered table-striped" id="">
                            <thead>
                                <tr>
                                    <th class="center hidden-phone">
                                        <input type="checkbox" class="select_all" id="checkAll" name="select_all" />
                                    </th>
                                    <th class="center hidden-phone">LOGIN CODE</th>
                                    <th class="center hidden-phone">DESCRIPTION</th>
                                    <th class="center hidden-phone">USER TYPE</th>
                                    <th class="center hidden-phone">FLOOR</th>
                                    <th class="center hidden-phone">FINISHING FLOOR</th>
                                    <th class="center hidden-phone">LINE</th>
                                    <th class="center hidden-phone">STATUS</th>
                                    <th class="center hidden-phone">BRANDS</th>
                                    <th class="center hidden-phone">ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                            <?php
                            $sl=1;
                            foreach($user_list AS $u){ ?>
                                <tr>
                                    <td class="center hidden-phone">
                                        <input class="checkItem" type="checkbox" name="checkItem[]" id="checkItem" value="<?php echo $u['user_name']; ?>" />
                                    </td>
                                    <td class="center hidden-phone"><?php echo $u['user_name'];?></td>
                                    <td class="center hidden-phone"><?php echo $u['user_description'];?></td>
                                    <td class="center hidden-phone">
                                        <?php
                                            if($u['access_points'] == 1000){
                                                echo 'ADMINISTRATOR';
                                            }
                                            if($u['access_points'] == 0){
                                                echo 'CUTTING';
                                            }
                                            if($u['access_points'] == 1){
                                                echo 'CUTTING SCAN';
                                            }
                                            if($u['access_points'] == 2){
                                                echo 'LINE INPUT';
                                            }
                                            if($u['access_points'] == 3){
                                                echo 'MID LINE QC';
                                            }
                                            if($u['access_points'] == 4){
                                                echo 'END LINE QC';
                                            }
                                            if($u['access_points'] == 5){
                                                echo 'FINISHING';
                                            }
                                            if($u['access_points'] == 6){
                                                echo 'WASHING';
                                            }
                                            if($u['access_points'] == 7){
                                                echo 'PACKING';
                                            }
                                            if($u['access_points'] == 8){
                                                echo 'COLLAR-CUFF';
                                            }
                                            if($u['access_points'] == 9){
                                                echo 'CARTON';
                                            }
                                            if($u['access_points'] == 200){
                                                echo 'OPR';
                                            }
                                            if($u['access_points'] == 300){
                                                echo 'QA';
                                            }
                                            if($u['access_points'] == 400){
                                                echo 'SD';
                                            }
                                            if($u['access_points'] == 500){
                                                echo 'PRODUCTION ADMIN';
                                            }
                                            if($u['access_points'] == 600){
                                                echo 'MAINTENANCE ADMIN';
                                            }
                                            if($u['access_points'] == 700){
                                                echo 'STORE';
                                            }
                                        ?>
                                    </td>
                                    <td class="center hidden-phone"><?php echo $u['floor_code'];?></td>
                                    <td class="center hidden-phone"><?php echo $u['finishing_floor_code'];?></td>
                                    <td class="center hidden-phone"><?php echo $u['line_code'];?></td>
                                    <td class="center hidden-phone"><?php echo ($u['status'] == 1 ? 'ACTIVE' : 'INACTIVE');?></td>
                                    <td class="center hidden-phone"><?php echo $u['buyer_condition'];?></td>
                                    <td class="center hidden-phone">
                                        <a href="<?php echo base_url()?>access/editUserInfo/<?php echo $u['id'];?>" class="btn btn-warning" title="EDIT"><i class="fa fa-pencil"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div><!--/table-responsive-->
                </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div>

<script type="text/javascript">
    $('select').select2();

    $(document).on('click','#checkAll',function () {
        $('.checkItem').not(this).prop('checked', this.checked);
    });

    function printQRCodes() {
        var user_codes = [];

        $('input.checkItem:checkbox:checked').each(function () {
            var sThisVal = $(this).val();

            user_codes.push(sThisVal);
        });

        if(user_codes.length > 0){

            window.open("<?php echo base_url();?>access/printQRCodes/"+user_codes, "_blank");
//            window.open("<?php //echo site_url('access/printQRCodes');?>///"+user_codes, "_blank");

        }else{
            alert('Nothing selected to print!');
        }
    }
    
    function getFilteredUserList() {
        var login_code = $("#login_code").val();
        var user_type = $("#user_type").val();
        var floor_id = $("#floor_id").val();
        var finishing_floor_id = $("#finishing_floor_id").val();
        var line_id = $("#line_id").val();

        $("#tbody_id").empty();

        $.ajax({
            url:"<?php echo base_url('access/getFilteredUserList')?>",
            type:"post",
            dataType:'html',
            data:{login_code: login_code, user_type: user_type, floor_id: floor_id, finishing_floor_id: finishing_floor_id, line_id: line_id},
            success:function (data) {

                $("#tbody_id").append(data);

            }
        });
    }
</script>