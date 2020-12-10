<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>New Fabric Code</h1>
        <h2 class="">New Fabric Code...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">New Fabric Code</li>
        </ol>
    </div>
</div>

<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/saveNewFabricCode" method="POST">
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
                        <input required="required" class="form-control" type="text" name="fabric_code" id="fabric_code" onblur="checkFabricCodeAvailability();" />
                        <span style="font-size: 11px;">* Fabric Code</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <button class="btn btn-success">SAVE</button>
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>

<script type="text/javascript">
    $('select').select2();

    function checkFabricCodeAvailability() {

        var fabric_code=$("#fabric_code").val();

        if(fabric_code != ''){

            $.ajax({
                url:"<?php echo base_url('access/checkFabricCodeAvailability')?>",
                type:"post",
                dataType:'html',
                data:{fabric_code: fabric_code},
                success:function (data) {

                    if(data == 'available'){
                        alert('FABRIC CODE is already available!');
                        location.reload();
                    }

                }
            });

        }else{
            alert('DEFECT CODE cannot be blank!');
            location.reload();
        }

    }

</script>