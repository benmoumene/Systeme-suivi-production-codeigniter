<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>SMS File Upload</h1>
          <h2 class="">SMS File Upload...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">SMS File Upload</li>
          </ol>
        </div>
      </div>

    <form action="<?php echo base_url();?>access/smsFileUpload" method="post" enctype="multipart/form-data">
        <div class="container clear_both padding_fix">
            <!--\\\\\\\ container  start \\\\\\-->
            <div class="row">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="col-md-2">
                            <div class="form-group">
                                <h4 align="right">Select SMS File:</h4>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input class="form-control" type="file" name="file" id="file" />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Upload</button>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <a href="<?php echo base_url();?>uploads/sms_hb_format/sms_file_format.csv" class="btn btn-warning">SMS File Format</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
        $("#message").empty();
    });

//    function getPoItemDetail() {
//        $("#report_content").empty();
//
//        var po_no_all = $("#po_no").val();
//
//        var res = po_no_all.split("_");
//
//        var sap_po = res[0];
//        var purchase_order = res[1];
//        var item = res[2];
//        var quality = res[3];
//        var color = res[4];
//
//        $.ajax({
//            url: "<?php //echo base_url();?>//access/getPoItemDetail/",
//            type: "POST",
//            data: {sap_no: sap_po, purchase_order: purchase_order, item: item, quality: quality, color: color},
//            dataType: "html",
//            success: function (data) {
//                $("#report_content").append(data);
//            }
//        });
//    }
</script>