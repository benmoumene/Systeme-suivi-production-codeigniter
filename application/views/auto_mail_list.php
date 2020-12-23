<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Auto-Mail List</h1>
        <h2 class="">Auto-Mail List...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Auto-Mail List</li>
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
                <div class="porlets-content">

                    <div class="table-responsive">
                        <table class="display table table-bordered table-striped" id="">
                            <thead>
                                <tr>
                                    <th class="center hidden-phone">ID</th>
                                    <th class="center hidden-phone">EMAIL CONFIG</th>
                                    <th class="center hidden-phone">DESCRIPTION</th>
<!--                                    <th class="center hidden-phone">TO ADDRESS</th>-->
<!--                                    <th class="center hidden-phone">CC ADDRESS</th>-->
                                    <th class="center hidden-phone">DATE CONDITION</th>
                                    <th class="center hidden-phone">STATUS</th>
                                    <th class="center hidden-phone">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($res AS $v){ ?>
                                <tr>
                                    <td class="center hidden-phone"><?php echo $v['id'];?></td>
                                    <td class="center hidden-phone"><?php echo ($v['email_type'] == 0 ? 'Local' : ($v['email_type'] == 1 ? 'Global' : ''));?></td>
                                    <td class="center hidden-phone"><?php echo $v['description'];?></td>
<!--                                    <td class="center hidden-phone">--><?php //echo $v['to_mail_address'];?><!--</td>-->
<!--                                    <td class="center hidden-phone">--><?php //echo $v['cc_mail_address'];?><!--</td>-->
                                    <td class="center hidden-phone"><?php echo $v['date_condition_plus_minus'];?></td>
                                    <td class="center hidden-phone"><?php echo $v['status'] == 1 ? 'Active' : 'Inactive';?></td>
                                    <td class="center hidden-phone">
                                        <a href="<?php echo base_url()?>access/editAutoMailConfig/<?php echo $v['id'];?>" class="btn btn-warning" title="EDIT"><i class="fa fa-pencil"></i></a>
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