<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Segments</h1>
        <h2 class="">Segments...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Segments</li>
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
                                    <th class="center hidden-phone">#</th>
                                    <th class="center hidden-phone">START TIME</th>
                                    <th class="center hidden-phone">END TIME</th>
                                    <th class="center hidden-phone">NAME</th>
                                    <th class="center hidden-phone">DESCRIPTION</th>
                                    <th class="center hidden-phone">STATUS</th>
                                    <th class="center hidden-phone">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sl=1;
                            foreach($segments AS $s){ ?>
                                <tr>
                                    <td class="center hidden-phone">
                                        <?php echo $sl; $sl++;?>
                                    </td>
                                    <td class="center hidden-phone"><?php echo $s['start_time'];?></td>
                                    <td class="center hidden-phone"><?php echo $s['end_time'];?></td>
                                    <td class="center hidden-phone"><?php echo $s['name'];?></td>
                                    <td class="center hidden-phone"><?php echo $s['description'];?></td>
                                    <td class="center hidden-phone"><?php echo ($s['status'] == 1 ? 'Active' : 'Inactive') ;?></td>
                                    <td class="center hidden-phone">
                                        <a href="<?php echo base_url()?>access/editSegmentInfo/<?php echo $s['id'];?>" class="btn btn-warning" title="EDIT"><i class="fa fa-pencil"></i></a>
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