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
        <h1>AQL Summary</h1>
        <h2 class="">AQL Summary...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">AQL Summary</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="col-md-12">
            <div class="block-web">
                <div class="header">
                    <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                    <h3 class="content-header"></h3>
                </div>

                <div class="porlets-content">
                    <div id="print_div">
                    <div class="row">
                        <sec class="table-responsive">
                            <section class="panel default blue_title h2">

                                <div class="panel-body" id="table_content" style="overflow-x:auto;">

                                    <table class="display table table-bordered table-striped" id="" border="1">
                                        <thead>
                                            <tr>
                                                <th class="hidden-phone center">SO</th>
                                                <th class="hidden-phone center">PO</th>
                                                <th class="hidden-phone center">Item</th>
                                                <th class="hidden-phone center">Quality</th>
                                                <th class="hidden-phone center">Color</th>
                                                <th class="hidden-phone center">Style</th>
                                                <th class="hidden-phone center">ExFac</th>
                                                <th class="hidden-phone center">Order</th>
                                                <th class="hidden-phone center">Type</th>
                                                <th class="hidden-phone center">AQL Plan</th>
                                                <th class="hidden-phone center">AQL Status</th>
                                                <th class="hidden-phone center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            foreach($aql_summary AS $v){

                                            ?>
                                                <tr>
                                                    <td class="hidden-phone center"><?php echo $v['so_no'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['purchase_order'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['item'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['quality'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['color'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['approved_ex_factory_date'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['total_order_qty'];?></td>
                                                    <td class="hidden-phone center">
                                                        <?php
                                                            if($v['po_type'] == 0){
                                                                echo "Bulk";
                                                            }
                                                            if($v['po_type'] == 1){
                                                                echo "Size Set";
                                                            }
                                                            if($v['po_type'] == 2){
                                                                echo "Sample";
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="hidden-phone center"><?php echo $v['aql_plan_date'];?></td>
                                                    <td class="hidden-phone center">
                                                        <?php
                                                            if($v['aql_status'] == 0){
                                                                echo 'Pending';
                                                            }
                                                            if($v['aql_status'] == 1){
                                                                echo 'Pass';
                                                            }
                                                            if($v['aql_status'] == 2){
                                                                echo 'Fail';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="hidden-phone center">

                                                        <?php if($v['is_aql_offerred'] == 0){ ?>
                                                            <span class="btn btn-warning" onclick="poAqlOffer('<?php echo $v['so_no'];?>');">OFFER</span>
                                                        <?php }

                                                        if($v['is_aql_offerred'] == 1){ ?>
                                                            <span class="btn btn-success" onclick="poAqlPassStatus('<?php echo $v['so_no'];?>');">PASS</span>
                                                            <span class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" onclick="setSoToModalFields('<?php echo $v['so_no'];?>')">FAIL</span>
                                                        <?php } ?>

                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </sec>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm AQL FAIL?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">SO:</label>
                    <input type="text" class="form-control" id="so_no" readonly="readonly">
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Remarks</label>
                    <textarea class="form-control" id="aql_remarks"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" onclick="poAqlFailStatus()">FAIL</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('select').select2();

    function poAqlOffer(so_no) {

        $.ajax({
            url: "<?php echo base_url();?>access/poAqlOffer/",
            type: "POST",
            data: {so_no: so_no},
            dataType: "html",
            success: function (data) {
                if(data == 'done'){
                    location.reload();
                }
            }
        });

    }

    function poAqlPassStatus(so_no) {

        $.ajax({
            url: "<?php echo base_url();?>access/poAqlPassStatus/",
            type: "POST",
            data: {so_no: so_no},
            dataType: "html",
            success: function (data) {
                if(data == 'done'){
                    location.reload();
                }
            }
        });

    }

    function poAqlFailStatus() {

        var so_no = $("#so_no").val();
        var aql_remarks = $("#aql_remarks").val();

        $.ajax({
            url: "<?php echo base_url();?>access/poAqlFailStatus/",
            type: "POST",
            data: {so_no: so_no, aql_remarks: aql_remarks},
            dataType: "html",
            success: function (data) {
                if(data == 'done'){
                    location.reload();
                }
            }
        });

    }

    function setSoToModalFields(so_no) {
        $("#so_no").val(so_no);
        $("#aql_remarks").val('');
    }

</script>