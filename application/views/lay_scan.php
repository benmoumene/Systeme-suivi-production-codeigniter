<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 20px;
        height: 20px;
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
        <h1>LAY SCAN</h1>
        <h2 class="">LAY SCAN...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">LAY SCAN</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="col-md-12">
            <div style="color: darkgreen; font-size: 25px;" id="s_message"></div>
            <div style="color: red; font-size: 25px;" id="e_message"></div>
        </div><!--/block-web-->
    </div><!--/col-md-12-->
    <div class="row">

        <div class="col-md-2">
            <select class="form-control select" name="table_no" id="table_no" style="font-size: 18px;">
                <option value="" id="blank">Select Table...</option>
                <?php foreach ($tables as $v_table){ ?>
                    <option value = "<?php echo $v_table['id'];?>" ><?php echo $v_table['table_name'];?></option>
                    <?php
                }
                ?>
            </select>
        </div>

        <div class="col-md-1">
            <input type="text" class="form-control" name="cut_tracking_no" autofocus autocomplete="off" required id="cut_tracking_no" onkeyup="clickToSubmitBtn();" />
        </div>
        <div class="col-md-1">
            <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
        </div>
        </div><!--/block-web-->
    </div><!--/col-md-12-->
    <br />
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                <span class="btn btn-success" onclick="getLayScanningReport();">REPORT</span>
            </div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <sec class="table-responsive">
                    <section class="panel default blue_title h2">

                        <div class="panel-body" id="table_content" style="overflow-x:auto;">

                            <table class="display table table-bordered table-striped" id="" border="1">
                                <thead>
                                    <tr>
                                        <th class="hidden-phone center">GROUP SO</th>
                                        <th class="hidden-phone center">SO</th>
                                        <th class="hidden-phone center">Purchase Order</th>
                                        <th class="hidden-phone center">Item</th>
                                        <th class="hidden-phone center">Quality</th>
                                        <th class="hidden-phone center">Color</th>
                                        <th class="hidden-phone center">Style</th>
                                        <th class="hidden-phone center">Style Name</th>
                                        <th class="hidden-phone center">Brand</th>
                                        <th class="hidden-phone center">Cut No</th>
                                        <th class="hidden-phone center">Qty</th>
                                        <th class="hidden-phone center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </section>
                </sec>
            </div>
        </div>
    </div>

</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>

            <div class="modal-body">
                <div class="col-md-3 scroll4">
                    <div class="porlets-content">
                        <div class="table-responsive" id="remain_cl_pcs">

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $('.select').select2();

    $("#cut_tracking_no").blur(function(){
        $("#cut_tracking_no").focus();
    });

    function clickToSubmitBtn(){

        $("#s_message").empty();
        $("#e_message").empty();

        var table_no = $("#table_no").val();
        var cl_no = $("#cut_tracking_no").val();

        var last_variable = cl_no.slice(-1);

        if((last_variable == '.')){
            if(table_no != ''){
                $("#loader").css("display", "block");
                $("#cut_tracking_no").attr('readonly', true);

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>access/inputToLay/",
                    data: {cut_tracking_no: cl_no, table_no: table_no},
                    dataType: "html",
                    success: function (data) {

                        if(data == 'done'){
                            $("#cut_tracking_no").val('');
                            $("#cut_tracking_no").attr('readonly', false);
                            $("#loader").css("display", "none");

                            $("#s_message").text("Successfully Lay Complete: "+ cl_no);
                        }
                        if(data == 'already pass'){
                            $("#cut_tracking_no").val('');
                            $("#cut_tracking_no").attr('readonly', false);
                            $("#loader").css("display", "none");

                            $("#s_message").text("Already Lay Complete: "+ cl_no);
                        }

                    }
                });
            }else{
                alert("Please Select Table!");
                $("#cut_tracking_no").val('');
            }
        }


    }
    
    function getLayScanningReport() {
        $("#table_content").empty();
        $("#loader").css("display", "block");

        $.ajax({
            type: "GET",
            url: "<?php echo base_url();?>access/getLayScanningReport/",
            data: {},
            dataType: "html",
            success: function (data) {
                $("#table_content").append(data);
                $("#loader").css("display", "none");
            }
        });
    }

    function removeLayScanByPoCut(po_no, cut_no) {
        $("#loader").css("display", "block");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>access/removeLayScanByPoCut/",
            data: {po_no: po_no, cut_no: cut_no},
            dataType: "html",
            success: function (data) {
                if(data == 'done'){
                    getLayScanningReport();
                }

                if(data == 'already cut'){
                    alert('SO: '+po_no+', Cut:'+cut_no+' is Already Cutting Complete!');
                    $("#loader").css("display", "none");
                }
            }
        });
    }

</script>