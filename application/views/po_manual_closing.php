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
<div class="pull-left breadcrumb_admin clear_both" xmlns="http://www.w3.org/1999/html">
    <div class="pull-left page_title theme_color">
        <h1>PO Manual Closing</h1>
        <h2 class="">PO Manual Closing...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">PO Manual Closing</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">Manual Closing</h3>
            </div>


            <br class="porlets-content">
<!--                <form action="--><?php //echo base_url();?><!--access/search_cutting_result" method="post">-->



                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select required type="text" class="form-control select" multiple id="so_no" name="so_no" data-placeholder="Select SO">
                                        <option value="">Select SO No...</option>
                                        <?php foreach ($sap_no as $v){ ?>
                                            <option value="<?php echo $v['so_no'];?>"><?php echo $v['so_no'];?></option>
                                        <?php } ?>
                                    </select>
                                    <span style="font-size: 11px;">* SO No.</span>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="porlets-content">

                                            <button type="submit" id="save_btn" class="btn btn-danger"onclick="getPOManualClose()">CLOSE</button>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <div class="porlets-content">

                                        <button type="submit" id="save_btn" class="btn btn-success"onclick="getPOManualReopen()">RE-OPEN</button>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="porlets-content">
                                        <div id="loader" style="display: none;"><div class="loader"></div></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('.select').select2();

    function getPOManualClose(){
        var so_no = $("#so_no").val();

        console.log(so_no);

        if(so_no != ''){
            $("#loader").css("display", "block");

            $.ajax({
                url: "<?php echo base_url();?>access/poManualClose/",
                type: "POST",
                data: {so_no: so_no},
                dataType: "html",
                success: function (data) {
                    if(data == 'done'){
                        $("#loader").css("display", "none");
                        alert("Manual Closing Successful!");
                        location.reload();
                    }
                }
            });
        }

    }

    function getPOManualReopen(){
        var so_no = $("#so_no").val();

        console.log(so_no);

        if(so_no != ''){
            $("#loader").css("display", "block");

            $.ajax({
                url: "<?php echo base_url();?>access/poManualReopen/",
                type: "POST",
                data: {so_no: so_no},
                dataType: "html",
                success: function (data) {
                    if(data == 'done'){
                        $("#loader").css("display", "none");
                        alert("PO Re-Open Successful!");
                        location.reload();
                    }
                }
            });
        }

    }


</script>