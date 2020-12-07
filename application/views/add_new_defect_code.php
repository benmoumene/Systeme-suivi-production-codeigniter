<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>New Defect Code</h1>
        <h2 class="">New Defect Code...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">New Defect Code</li>
        </ol>
    </div>
</div>

<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/saveNewDefectCode" method="POST">
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
                        <input required="required" class="form-control" type="text" name="defect_code" id="defect_code" onblur="checkDefectCodeAvailability();" />
                        <span style="font-size: 11px;">* Defect Code</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input required="required" class="form-control" type="text" name="defect_code_name" id="defect_code_name" />
                        <span style="font-size: 11px;">* Defect Name</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <input required="required" class="form-control" type="text" name="defect_code_description" id="defect_code_description" />
                        <span style="font-size: 11px;">* Defect Description</span>
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

    function checkDefectCodeAvailability() {

        var defect_code=$("#defect_code").val();

        if(defect_code != ''){

            var defect_code_length = defect_code.length;
            var defect_code_last_char = defect_code.charAt(defect_code.length-1);

            if(defect_code_length == 7 && defect_code_last_char == '.'){
                $.ajax({
                    url:"<?php echo base_url('access/checkDefectCodeAvailability')?>",
                    type:"post",
                    dataType:'html',
                    data:{defect_code: defect_code},
                    success:function (data) {

                        if(data == 'available'){
                            alert('DEFECT CODE is already available!');
                            location.reload();
                        }

                    }
                });
            }else{
                alert('DEFECT CODE has to be 7 Digits and Last Character has to be DOT(.) !');
                location.reload();
            }

        }else{
            alert('DEFECT CODE cannot be blank!');
            location.reload();
        }

    }

</script>