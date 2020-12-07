<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Defect Codes</h1>
        <h2 class="">Defect Codes...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Defect Codes</li>
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
                    <a href="<?php echo base_url();?>access/addNewDefectCode" class="btn btn-success" title="ADD DEFECT CODE"> <i class="fa fa-plus"></i> DEFECT CODE</a>
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
                                    <th class="center hidden-phone">DEFECT CODE</th>
                                    <th class="center hidden-phone">DEFECT NAME</th>
                                    <th class="center hidden-phone">DESCRIPTION</th>
                                    <th class="center hidden-phone">ACTION</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                            <?php
                            $sl=1;
                            foreach($defect_codes AS $d){ ?>
                                <tr>
                                    <td class="center hidden-phone">
                                        <input class="checkItem" type="checkbox" name="checkItem[]" id="checkItem" value="<?php echo $d['defect_code']; ?>" />
                                    </td>
                                    <td class="center hidden-phone"><?php echo $d['defect_code'];?></td>
                                    <td class="center hidden-phone"><?php echo $d['defect_name'];?></td>
                                    <td class="center hidden-phone"><?php echo $d['defect_description'];?></td>
                                    <td class="center hidden-phone">
                                        <a href="<?php echo base_url()?>access/editDefectCode/<?php echo $d['id'];?>" class="btn btn-warning" title="EDIT"><i class="fa fa-pencil"></i></a>
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
        var defect_codes = [];

        $('input.checkItem:checkbox:checked').each(function () {
            var sThisVal = $(this).val();

            defect_codes.push(sThisVal);
        });

        if(defect_codes.length > 0){

            window.open("<?php echo base_url();?>access/printDefectQRCodes/"+defect_codes, "_blank");
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