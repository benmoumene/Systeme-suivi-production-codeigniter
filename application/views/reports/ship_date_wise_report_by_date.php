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
        <h1>Ship Date Wise Report By Date</h1>
        <h2 class="">Ship Date Wise Report By Date...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Ship Date Wise Report By Date</li>
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
                                <select class="form-control" name="brands[]" id="brands" multiple data-placeholder="Select Brands">
                                    <?php foreach ($brands as $v){
                                        if($v['brand'] != ''){
                                            ?>
                                            <option value="<?php echo "'".$v['brand']."'"?>"><?php echo $v['brand']?></option>
                                            <?php
                                        }
                                    } ?>
                                </select>
                                <span><b>* Select Brands </b></span>
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
                            <!--                            <div class="col-md-2">-->
                            <!--                                <input type="text" name="from_date" id="from_date" placeholder="From Date: mm-dd-yyyy" class="form-control form-control-inline input-medium default-date-picker" required />-->
                            <!--                                <span><b>* Ship Date From</b></span>-->
                            <!--                            </div>-->
                            <!--                            <div class="col-md-2">-->
                            <!--                                <input type="text" name="to_date" id="to_date" placeholder="To Date: mm-dd-yyyy" class="form-control form-control-inline input-medium default-date-picker" required />-->
                            <!--                                <span><b>* Ship Date To</b></span>-->
                            <!--                            </div>-->

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="from_date" name="from_date" required="required" autocomplete="off" />
                                    <span><b>* Select From Date </b></span>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="to_date" name="to_date" required="required" autocomplete="off" />
                                    <span><b>* Select To Date </b></span>
                                </div>
                            </div>


                            <div class="col-md-1">

                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submit_btn" onclick="getShipDateWiseReport();">SEARCH</button>
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
                            <sec class="table-responsive">
                                <section class="panel default blue_title h2">

                                    <div class="panel-body" id="table_content" style="overflow-x:auto;">

                                        <table class="display table table-bordered table-striped" id="" border="1">
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
                                </section>
                            </sec>
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

    function getShipDateWiseReport() {
        var brands = $("#brands").val();
        var po_type = $("#po_type").val();

        var from_dt = $("#from_date").val();
        var to_dt = $("#to_date").val();

//
        var res1 = from_dt.split("-");
        var res2 = to_dt.split("-");

        var from_date = res1[2]+'-'+res1[0]+'-'+res1[1];
        var to_date = res2[2]+'-'+res2[0]+'-'+res2[1];

        var month_year = $("#src_date").val();

        if(month_year != '' && brands != null && po_type != ''){
            $("#loader").css("display", "block");

            $("#table_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getShipDateWiseReportByDate/",
                type: "POST",
                data: {brands: brands, po_type: po_type, from_date: from_date, to_date: to_date},
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

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        location.reload();
    }
</script>