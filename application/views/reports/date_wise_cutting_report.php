<?php
$cur_date = date('Y-m-d');
$date_range = date('Y-m-d',(strtotime ( '-10 day' , strtotime ( $cur_date) ) ));
?>
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
        <h1>Date Wise Cutting Report</h1>
        <h2 class="">Date Wise Cutting Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Date Wise Cutting Report</li>
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
                                <input type="text" name="from_date" id="from_date" placeholder="From Date: mm-dd-yyyy" class="form-control form-control-inline input-medium default-date-picker" required />
                                <input type="hidden" class="form-control" id="date_range" readonly name="date_range" value="<?php echo $date_range; ?>" />
                                <span><b>* Select Date </b></span>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submit_btn" onclick="getDateWiseCuttingReport();">Search</button>
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

                                <div class="panel-body" id="table_content">

                                    <table class="display table table-bordered table-striped" id="" border="1">
                                        <thead>
                                        <tr>
                                            <th class="hidden-phone center" colspan="9"></th>
                                            <th class="hidden-phone center" colspan="6">Total Status</th>
                                            <th class="hidden-phone center" colspan="3"><h4>Date</h4></th>
                                        </tr>
                                        <tr>
                                            <th class="hidden-phone center">Brand</th>
                                            <th class="hidden-phone center">Purchase Order</th>
                                            <th class="hidden-phone center">Item</th>
                                            <th class="hidden-phone center">Style</th>
                                            <th class="hidden-phone center">Quality</th>
                                            <th class="hidden-phone center">Color</th>
                                            <th class="hidden-phone center">Ex-Fac Date</th>
                                            <th class="hidden-phone center">Order</th>
                                            <th class="hidden-phone center">Cut</th>
                                            <th class="hidden-phone center">Body Pass</th>
                                            <th class="hidden-phone center">Balance</th>
                                            <th class="hidden-phone center">Collar</th>
                                            <th class="hidden-phone center">Collar Balance</th>
                                            <th class="hidden-phone center">Cuff</th>
                                            <th class="hidden-phone center">Cuff Balance</th>
                                            <th class="hidden-phone center">Body</th>
                                            <th class="hidden-phone center">COLLAR</th>
                                            <th class="hidden-phone center">CUFF</th>
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

    function getDateWiseCuttingReport() {

        var from_dt = $("#from_date").val();

        var res1 = from_dt.split("-");

        var from_date = res1[2]+'-'+res1[0]+'-'+res1[1];
        var date_range = $("#date_range").val();

        if(from_date != ''){
            if(from_date > date_range){
                $("#loader").css("display", "block");

                $("#table_content").empty();

                $.ajax({
                    url: "<?php echo base_url();?>dashboard/getDateWiseCuttingReport/",
                    type: "POST",
                    data: {po_from_date: from_date},
                    dataType: "html",
                    success: function (data) {
                        console.log(data);

                        $("#table_content").append(data);
                        $("#loader").css("display", "none");
                    }
                });
            }else{
                alert("Please Select Date More Than: "+ date_range);
            }
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