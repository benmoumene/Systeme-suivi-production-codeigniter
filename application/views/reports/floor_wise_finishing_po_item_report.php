<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 25px;
        height: 25px;
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
<!--\\\\\\\ contentpanel start\\\\\\-->
    <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
            <h1>Finishing Running PO Report</h1>
            <h2 class="">Finishing Running PO Report...</h2>
        </div>
        <div class="pull-right">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">DASHBOARD</a></li>
                <li class="active">Finishing Running PO Report</li>
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
                        <div class="form-group">
                            <select multiple="multiple" required class="form-control" id="brands" name="brands" data-placeholder="Select Brands">
                                <?php
                                    foreach ($brands as $b){ ?>
                                        <option value="<?php echo "'".$b['brand']."'";?>"><?php echo $b['brand'];?></option>
                                <?php
                                    }
    //                            ?>
                            </select>
                        </div>
                        <span style="font-size: 11px;">* Select Brands</span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="form-group">
                            <select class="form-control" name="po_type" id="po_type">
                                <option value="">PO Type</option>
                                <option value="0">BULK</option>
                                <option value="1">SIZE SET</option>
                                <option value="2">SAMPLE</option>
                            </select>
                        </div>
                        <span><b> Select PO Type </b></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="from_date" name="from_date" required="required" autocomplete="off" />
                        </div>
                        <span><b> Ship Date From </b></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="to_date" name="to_date" required="required" autocomplete="off" />
                        </div>
                        <span><b> Ship Date To </b></span>
                    </div>
                </div>
                <div class="col-md-1">
                    <span class="btn btn-success" id="search_btn" onclick="getFinishingRunningPoReportByBrand('brands');">Search</span>
                </div>

                <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>

                </div>
            </div>
        </div>
        <br />
        <button type="button" onclick="printDiv('print_div')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print</button>
        <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
        <br />
        <div id="print_div">
            <div class="row" id="report_content"></div>
            <div class="row" id="size_tbl"></div>
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
                                <div class="table-responsive" id="remain_cl_list">

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
    <!--\\\\\\\ container  end \\\\\\-->

<script type="text/javascript">
    $('select').select2();

//    setTimeout(function(){
//        window.location.reload(1);
//    }, 5000);

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

    function getFinishingRunningPoReportByBrand(brands) {
        var brands = $("#"+brands).val();
        var po_type = $("#po_type").val();

        var from_dt = $("#from_date").val();
        var to_dt = $("#to_date").val();

        var res1 = from_dt.split("-");
        var res2 = to_dt.split("-");

        var from_date = res1[2]+'-'+res1[0]+'-'+res1[1];
        var to_date = res2[2]+'-'+res2[0]+'-'+res2[1];

        $("#report_content").empty();
        $("#size_tbl").empty();

        if(brands != null){
            $("#loader").css("display", "block");

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getFinishingRunningPoReportByBrand/",
                type: "POST",
                data: {brands: brands, po_type: po_type, from_date: from_date, to_date: to_date},
                dataType: "html",
                success: function (data) {
                    $("#report_content").append(data);
                    $("#loader").css("display", "none");
                }
            });
        }else{
            alert('Please Select Brand!');
        }

    }

    function getPoItemWiseRemainCL(po_no, so_no, purchase_order, item, quality, color) {
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getPoItemWiseFinishingRemainCL/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });

    }

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        location.reload();
    }
</script>