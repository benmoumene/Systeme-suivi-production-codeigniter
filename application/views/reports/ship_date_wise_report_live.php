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

    /*Table Head tr Fix Start*/

    .tableFixHead { overflow-y: auto; height: 600px; }
    .tableFixHead thead th { position: sticky; top: 0; }

    table  { border-collapse: collapse; width: 100%; }
    th, td { padding: 8px 16px; }
    th     { background:#ffffff; }

    /*Table Head tr Fix End*/
</style>
<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Ship Date Wise Report</h1>
        <h2 class="">Ship Date Wise Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Ship Date Wise Report</li>
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
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-2">
                                <select class="form-control" name="brands[]" id="brands" multiple data-placeholder="Select Brands" onchange="getShipDateLists();">
                                    <?php foreach ($brands as $v){
                                        if($v['brand'] != ''){
                                            ?>
                                            <option value="<?php echo "'".$v['brand']."'"?>"><?php echo $v['brand']?></option>
                                            <?php
                                        }
                                    } ?>
                                </select>
                                <br />
                                <span><b>* Select Brands </b></span>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="ship_date[]" id="ship_date">
                                    <option value="">Select Ship Date</option>
                                    <?php foreach ($ship_dates as $s){
                                        if($v['brand'] != ''){
                                            ?>
                                            <option value="<?php echo "'".$s['ex_factory_date']."'"?>"><?php echo $s['ex_factory_date']?></option>
                                            <?php
                                        }
                                    } ?>
                                </select>
                                <br />
                                <span><b>* Ship Date </b></span>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="po_type" id="po_type">
                                    <option value="">PO Type</option>
                                    <option value="0">BULK</option>
                                    <option value="1">SIZE SET</option>
                                    <option value="2">SAMPLE</option>
                                </select>
                                <span><b>* Select PO Type </b></span>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submit_btn" onclick="getShipDateWiseReportLive();">SEARCH</button>
                            </div>
                            <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                        </div>
                    </div>

                    <br />
                    <button type="button" onclick="printDiv('print_div')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print</button>
                    <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
                    <br />

                    <div id="print_div">
                        <div class="row">

                            <div id="table_content">
                                <div class="col-md-12 tableFixHead">


                                    <table class="table table-bordered table-striped" id="" border="1">
                                        <thead>
                                        <tr>
                                            <th class="hidden-phone center">SO</th>
                                            <th class="hidden-phone center">Brand</th>
                                            <th class="hidden-phone center">Purchase Order</th>
                                            <th class="hidden-phone center">Item</th>
                                            <th class="hidden-phone center">Style</th>
                                            <th class="hidden-phone center">Quality</th>
                                            <th class="hidden-phone center">Color</th>
                                            <th class="hidden-phone center">Order</th>
                                            <th class="hidden-phone center">Cut</th>
                                            <th class="hidden-phone center">Cut Pass</th>
                                            <th class="hidden-phone center">Sewed</th>
                                            <th class="hidden-phone center">Sew Balance</th>
                                            <th class="hidden-phone center">Wash Send</th>
                                            <th class="hidden-phone center">Wash Rcv</th>
                                            <th class="hidden-phone center">Wash BLNC</th>
                                            <th class="hidden-phone center">Packed</th>
                                            <th class="hidden-phone center">Carton</th>
                                            <th class="hidden-phone center">Warehouse</th>
                                            <th class="hidden-phone center">Other</th>
                                            <th class="hidden-phone center">Balance</th>
                                            <!--        <th class="hidden-phone center">Ex-Fac Date</th>-->
                                            <th class="hidden-phone center">Closing Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1"></h4>
            </div>

            <div class="modal-body">
                <div class="col-md-3 scroll4">
                    <div class="porlets-content">
                        <div class="table-responsive" id="wh_cl_list">

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
    $('select').select2();

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#table_content').html())
            location.href=url
            return false
        })
    })

    window.addEventListener('keydown', function(event) {
        if (event.keyCode === 80 && (event.ctrlKey || event.metaKey) && !event.altKey && (!event.shiftKey || window.chrome || window.opera)) {
            event.preventDefault();
            if (event.stopImmediatePropagation) {
                event.stopImmediatePropagation();
            } else {
                event.stopPropagation();
            }
            return;
        }
    }, true);

    function getShipDateLists() {
        var brands = $("#brands").val();

        $("#ship_date").empty();

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getShipDateLists/",
            type: "POST",
            data: {brands: brands},
            dataType: "html",
            success: function (data) {

                $("#ship_date").append(data);

            }
        });
    }

    function getShipDateWiseReportLive() {
        var brands = $("#brands").val();
        var po_type = $("#po_type").val();

        var brands_string = brands.toString();

        var ship_date = $("#ship_date").val();

        if(ship_date != '' && brands != null && po_type != ''){
            $("#loader").css("display", "block");

            $("#table_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getShipDateWiseReportLive/",
                type: "POST",
                data: {brands: brands_string, ship_date: ship_date, po_type: po_type},
                dataType: "html",
                success: function (data) {
                    $("#table_content").empty();
                    $("#table_content").append(data);
                    $("#loader").css("display", "none");
                }
            });
        }else{
            alert("Please Select Required Fields!");
        }
    }

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        location.reload();
    }

    function getWarehousePcs(po_no, so_no, purchase_order,item, quality, color) {
        $("#wh_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getWarehouseSizePcs/",
            type: "POST",
            data: {po_no: po_no, so_no: so_no, purchase_order: purchase_order, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#wh_cl_list").append(data);
            }
        });


    }
</script>