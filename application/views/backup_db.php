<style>
    .loader {
        border: 30px solid #f3f3f3;
        border-radius: 50%;
        border-top: 30px solid #3498db;
        width: 30px;
        height: 30px;
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
  <h1>Backup Database</h1>
  <h2 class="">Backup Database...</h2>
</div>
<div class="pull-right">
  <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>">Home</a></li>
      <li class="active">Backup Database</li>
  </ol>
</div>
</div>
<div class="container clear_both padding_fix">
<!--\\\\\\\ container  start \\\\\\-->

<div class="row">
    <div class="col-md-12">

    </div><!--/block-web-->
</div><!--/col-md-12-->

    <div class="row">
        <div class="col-md-2">
            <select class="form-control" name="des_db" id="des_db">
                <option value="">Select Destination DB...</option>
                <?php foreach ($databases as $db){ ?>

                     <option value="<?php echo $db['TABLE_SCHEMA'];?>"><?php echo $db['TABLE_SCHEMA'];?></option>

                <?php
                } ?>
            </select>
            <span><b>* Destination Database</b></span>
        </div>
        <div class="col-md-2">
            <div class="input-append date dpMonths" data-date="102/2012" data-date-format="yyyy-mm" data-date-viewmode="years" data-date-minviewmode="months">
                <input type="text" class="form-control" size="30" id="src_date" name="src_date" value="" readonly="">
                <span class="input-group-btn add-on">
                    <button type="button" class="btn btn-danger"><i class="fa fa-calendar"></i></button>
                </span>
            </div>
            <span><b>* Select Month/Year</b></span>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-3">
            <span class="btn btn-primary" onclick="backUpCareLabelTable();">Care Label Table</span>
            <br />
            <span id="success_msg_1" style="color: #308309; font-size: 20px;"></span>
        </div>
        <div class="col-md-3">
            <span class="btn btn-success" onclick="backUpCutSummaryTable();">Cut Summary Table</span>
            <br />
            <span id="success_msg_2" style="color: #308309; font-size: 20px;"></span>
        </div>
        <div class="col-md-3">
            <span class="btn btn-warning" onclick="backUpPoDetailTable();">PO Detail Table</span>
            <br />
            <span id="success_msg_3" style="color: #308309; font-size: 20px;"></span>
        </div>
        <div class="col-md-3" id="loader" style="display: none;">
            <div class="loader"></div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
        $("#message").empty();
    });

    function backUpCareLabelTable() {

        var des_db = $("#des_db").val();
        var src_date = $("#src_date").val();

        if(des_db != '' && src_date != ''){

        $("#loader").css("display", "block");
        $("#success_msg_1").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/backUpCareLabelTable/",
            type: "POST",
            data: {src_date: src_date, des_db: des_db},
            dataType: "html",
            success: function (data) {
                if (data == 'Care Label Backup Done'){
                    $("#success_msg_1").text(data);
                    $("#loader").css("display", "none");
                }
            }
        });

        }else {
            alert('Please Select Required Fields!');
        }
    }

    function backUpCutSummaryTable() {

        var des_db = $("#des_db").val();
        var src_date = $("#src_date").val();

        if(des_db != '' && src_date != ''){

        $("#loader").css("display", "block");
        $("#success_msg_2").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/backUpCutSummaryTable/",
            type: "POST",
            data: {src_date: src_date, des_db: des_db},
            dataType: "html",
            success: function (data) {
                if (data == 'Cut Summary Backup Done'){
                    $("#success_msg_2").text(data);
                    $("#loader").css("display", "none");
                }
            }
        });

        }else {
            alert('Please Select Required Fields!');
        }

    }

    function backUpPoDetailTable() {

        var des_db = $("#des_db").val();
        var src_date = $("#src_date").val();

        if(des_db != '' && src_date != ''){

        $("#loader").css("display", "block");
        $("#success_msg_3").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/backUpPoDetailTable/",
            type: "POST",
            data: {src_date: src_date, des_db: des_db},
            dataType: "html",
            success: function (data) {
                if (data == 'PO Detail Backup Done'){
                    $("#success_msg_3").text(data);
                    $("#loader").css("display", "none");
                }
            }
        });

        }else {
            alert('Please Select Required Fields!');
        }
    }
</script>