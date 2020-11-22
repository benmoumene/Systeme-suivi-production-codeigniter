<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 35px;
        height: 35px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Package Adjustment</h1>
        <h2 class="">Package Adjustment...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Package Adjustment</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->

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
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <select required type="text" class="form-control" id="po_no" name="po_no">

                        <option value="">Select GROUP PO...</option>
                        <?php foreach ($sap_no as $v){ ?>
                            <option value="<?php echo $v['po_no'];?>"><?php echo $v['po_no'];?></option>
                        <?php } ?>
                    </select>
                    <span style="font-size: 11px;">* PO No.</span>
                </div>
            </div>
            <div class="col-md-3">
                <span class="btn btn-success" onclick="cuttingPackageReadyManualAdjustment();">PROCESS</span>
            </div>
            <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
        </div>


</div>

<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
        $("#message").empty();
    });

    function cuttingPackageReadyManualAdjustment() {

        var po_no = $("#po_no").val();

        if(po_no != ''){
            $("#loader").css("display", "block");

            $.ajax({
                url: "<?php echo base_url();?>access/cuttingPackageReadyManualAdjustmentProcess/",
                type: "POST",
                data: {po_no: po_no},
                dataType: "html",
                success: function (data) {
                    if(data == 'done'){
                        $("#loader").css("display", "none");
                        location.reload();
                    }
                }
            });

        }else{
            alert("Please Select PO!");
        }

    }

</script>