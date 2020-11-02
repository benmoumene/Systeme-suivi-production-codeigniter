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
        <h1>CUT SCAN</h1>
        <h2 class="">CUT SCAN...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">CUT SCAN</li>
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
        <div class="col-md-12">
            <div class="col-md-2">
                <input type="text" class="form-control" name="carelabel_tracking_no" autofocus autocomplete="off" required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />


            </div>
            <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
        </div>

    </div>
    <br />
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2">
                <span class="btn btn-success" onclick="getCutScanningReport();">REPORT</span>
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

    $("#carelabel_tracking_no").blur(function(){
        $("#carelabel_tracking_no").focus();
    });

    function clickToSubmitBtn() {

        $("#s_message").empty();
        $("#e_message").empty();

        var cl_no = $("#carelabel_tracking_no").val();



        var last_variable = cl_no.slice(-1);

        if(last_variable == '.'){
            $("#carelabel_tracking_no").attr('readonly', true);

            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>access/inputToCut/",
                data: {care_label_no: cl_no},
                dataType: "html",
                success: function (data) {

                    if(data == 'Done'){
                        $("#carelabel_tracking_no").val('');
                        $("#carelabel_tracking_no").attr('readonly', false);

                        $("#s_message").text("Successfully Cutting Complete: "+ cl_no);
                    }

                    if(data == 'Pending'){
                        $("#carelabel_tracking_no").val('');
                        $("#carelabel_tracking_no").attr('readonly', false);

//                        $("#e_message").text("Successfully Lay Complete: "+ cl_no);
                        $("#e_message").text("Previous Process Pending: "+ cl_no);
                    }
                    if(data == 'Already Pass'){
                        $("#carelabel_tracking_no").val('');
                        $("#carelabel_tracking_no").attr('readonly', false);

//                        $("#e_message").text("Successfully Lay Complete: "+ cl_no);
                        $("#s_message").text("Already Cutting Complete: "+ cl_no);
                    }

                }
            });

        }

    }


    function getCutScanningReport() {
        $("#table_content").empty();
        $("#loader").css("display", "block");

        $.ajax({
            type: "GET",
            url: "<?php echo base_url();?>access/getCutScanningReport/",
            data: {},
            dataType: "html",
            success: function (data) {
                $("#table_content").append(data);
                $("#loader").css("display", "none");
            }
        });
    }

    function removeCutScanByPoCut(po_no, cut_no) {
        $("#loader").css("display", "block");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>access/removeCutScanByPoCut/",
            data: {po_no: po_no, cut_no: cut_no},
            dataType: "html",
            success: function (data) {
                if(data == 'done'){
                    getCutScanningReport();
                }
            }
        });
    }


</script>