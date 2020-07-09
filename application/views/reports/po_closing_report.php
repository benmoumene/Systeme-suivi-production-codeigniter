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
        <h1>PO Closing Report</h1>
        <h2 class="">PO Closing Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">PO Closing Report</li>
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
                                <input type="hidden" name="ship_frm_dt" id="ship_frm_dt" placeholder="Date: mm-dd-yyyy" class="form-control form-control-inline input-medium default-date-picker" required />
                                <span style="display: none;"><b>Ship Date </b></span>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="from_date" id="from_date" placeholder="From Date: mm-dd-yyyy" class="form-control form-control-inline input-medium default-date-picker" required />
                                <span><b>* Closed From Date</b></span>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="to_date" id="to_date" placeholder="To Date: mm-dd-yyyy" class="form-control form-control-inline input-medium default-date-picker" required />
                                <span><b>* Closed To Date</b></span>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submit_btn" onclick="getPoClosingReport();">Search</button>
                            </div>
                            <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                        </div>
                    </div>

                    <br />
                    <button type="button" onclick="printDiv('print_div')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print</button>
                    <br />

                    <div id="print_div">
                    <div class="row">
                        <sec class="table-responsive">
                            <section class="panel default blue_title h2">

                                <div class="panel-body" id="table_content" style="overflow-x:auto;">

                                    <table class="display table table-bordered table-striped" id="">
                                        <thead>
                                        <tr>
<!--                                            <th class="hidden-phone center">SO</th>-->
                                            <th class="hidden-phone center">Purchase Order</th>
                                            <th class="hidden-phone center">Item</th>
                                            <th class="hidden-phone center">Quality</th>
                                            <th class="hidden-phone center">Color</th>
                                            <th class="hidden-phone center">Ex-Fac Date</th>
                                            <th class="hidden-phone center">Order</th>
                                            <th class="hidden-phone center">Cut</th>
                                            <th class="hidden-phone center">Sewed</th>
                                            <th class="hidden-phone center">Packed</th>
                                            <th class="hidden-phone center">Carton</th>
                                            <th class="hidden-phone center">Warehouse</th>
                                            <th class="hidden-phone center">Balance</th>
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

<script type="text/javascript">
    $('select').select2();

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

    function getPoClosingReport() {
        var from_dt = $("#from_date").val();
        var to_dt = $("#to_date").val();

        var res1 = from_dt.split("-");
        var res2 = to_dt.split("-");

//        var ship_frm_dt = $("#ship_frm_dt").val();

//        var res3 = ship_frm_dt.split("-");

        var from_date = res1[2]+'-'+res1[0]+'-'+res1[1];
        var to_date = res2[2]+'-'+res2[0]+'-'+res2[1];

//        var ship_from_date = res3[2]+'-'+res3[0]+'-'+res3[1];

        if(from_date != '' && to_date != ''){
            $("#loader").css("display", "block");

            $("#table_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPoClosingReport/",
                type: "POST",
                data: {po_from_date: from_date, po_to_date: to_date},
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
</script>