<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>PO Remarks</h1>
        <h2 class="">PO Remarks...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">PO Remarks</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->

    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <select required class="form-control" id="so_no">
                            <option value="" >SO ~ PO ~ Status ~ Type ~ (ExFacDate)</option>
                            <?php
                            $type = '';
                            foreach ($purchase_order_nos as $pos){

                                if($pos['po_type'] == 0){
                                    $type = 'Bulk';
                                }
                                if($pos['po_type'] == 1){
                                    $type = 'Size Set';
                                }
                                if($pos['po_type'] == 2){
                                    $type = 'Sample';
                                }
                            ?>
                                <option value="<?php echo $pos['so_no'];?>"><?php echo $pos['so_no'].'~'.$pos['purchase_order'].'~'.$pos['status'].'~'.$type.'~ ('.$pos['ex_factory_date'].')';?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span style="font-size: 11px;">*Purchase Order</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select required class="form-control" id="value" name="value">
                            <option value="">Select Status</option>
                            <option value="CLOSE">CLOSE</option>
                            <option value="OPEN">OPEN</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">

                            <button type="button" class="btn btn-primary"  onclick="poClosed();">Submit</button>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <br />

    <div class="row" id="report_content">

    </div>
</div>

<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
        $("#message").empty();
    });

    function poClosed() {
        var so_no = $("#so_no").val();
        var value = $("#value").val();
        var audit_status = $("#audit_status").val();


        if (so_no != '') {
            $.ajax({
                url: "<?php echo base_url();?>access/po_closed/",
                type: "POST",
                data: {so_no: so_no, value: value},
                dataType: "html",
                success: function (data) {
//                console.log(data)
                    if (data == 'success') {

                        alert("Successfully PO Closed!");
                        window.location.reload();

                    }
                }
            });
        }else{
            alert("Please Select Required Fields!");
        }


    }
</script>