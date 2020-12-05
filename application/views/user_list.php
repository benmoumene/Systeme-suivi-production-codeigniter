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

    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="col-md-12">
            <div class="block-web">

                <div class="col-md-1">
                    <span class="btn btn-primary" title="PRINT QR CODE" onclick="printQRCodes()"> <i class="fa fa-print"></i> PRINT</span>
                </div>
                <div class="col-md-1">
                    <span class="btn btn-success" title="ADD USER"> <i class="fa fa-plus"></i> USER</span>
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
                            <tbody>
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
</script>