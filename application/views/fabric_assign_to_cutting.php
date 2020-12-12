<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Fabric Assign to Cutting</h1>
        <h2 class="">Fabric Assign to Cutting...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Fabric Assign to Cutting</li>
        </ol>
    </div>
</div>

<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <form action="<?php echo base_url();?>access/saveFabricAssignToCutting" method="POST">
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

                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" id="fabric_code" name="fabric_code" min="0" required="required" readonly="readonly" autocomplete="off" value="<?php echo $fabric_code[0]['fabric_code'];?>" />
                        <input type="hidden" id="fabric_id" name="fabric_id" min="0" required="required" readonly="readonly" autocomplete="off" value="<?php echo $fabric_code[0]['id'];?>" />
                        <p style="font-size: 11px;">* Fabric Code</p>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" id="cutting_assignment_length" name="cutting_assignment_length" min="0" required="required" autocomplete="off" onblur="checkLengthValidity();" />
                        <p style="font-size: 11px;">* Fabric Length (m)</p>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <input type="text" id="remarks" name="remarks" autocomplete="off" />
                        <p style="font-size: 11px;"> Remarks</p>
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
    
    function checkLengthValidity() {
        var fabric_id = $("#fabric_id").val();

        var cutting_assignment_length = parseFloat($("#cutting_assignment_length").val());

        if(isNaN(cutting_assignment_length) == false){
            cutting_assignment_length = (cutting_assignment_length < 0 ? '' : cutting_assignment_length);
        }else{
            cutting_assignment_length = '';
        }

        if(cutting_assignment_length != ''){

            $.ajax({
                url:"<?php echo base_url('access/checkStoreFabricLengthAvailability')?>",
                type:"post",
                dataType:'json',
                data:{fabric_id: fabric_id},
                success:function (data) {

                    var fabric_store_balance = data[0].total_inhouse_length - data[0].total_cutting_assignment_length;

                    if(cutting_assignment_length > fabric_store_balance){
                        alert('Store Fabric Length Available: '+fabric_store_balance+'(m)');
                        $("#cutting_assignment_length").val('');
                    }

                }
            });

        }else{
            $("#cutting_assignment_length").val(cutting_assignment_length);
        }
    }

</script>