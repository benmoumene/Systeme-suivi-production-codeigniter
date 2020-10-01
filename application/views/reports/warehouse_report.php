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
        <h1>Warehouse Report</h1>
        <h2 class="">Warehouse Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Warehouse Report</li>
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
                                <span><b> Select Brands </b></span>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="warehouse_type[]" id="warehouse_type">
                                    <option value="">Select Warehouse Type</option>
                                    <?php foreach ($wh_types as $v_1){
                                    ?>
                                            <option value="<?php echo $v_1['id']?>"><?php echo $v_1['warehouse_type']?></option>
                                    <?php
                                          }
                                    ?>
                                </select>
                                <span><b>* Select Warehouse Type</b></span>
                            </div>
                            <div class="col-md-2">
                                <div class="input-append date dpMonths" data-date="102/2012" data-date-format="yyyy-mm" data-date-viewmode="years" data-date-minviewmode="months">
                                    <input type="text" class="form-control" size="30" id="src_date" name="src_date" value="" readonly="">
                                    <span class="input-group-btn add-on">
                                    <button type="button" class="btn btn-danger"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                                <span><b>Select Month/Year</b></span>
                            </div>
                            <div class="col-md-1">

                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submit_btn" onclick="getWarehousePcsReport();">SEARCH</button>
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
                                                <th class="hidden-phone center">INR No.</th>
                                                <th class="hidden-phone center">Brand</th>
                                                <th class="hidden-phone center">Purchase Order</th>
                                                <th class="hidden-phone center">Item</th>
                                                <th class="hidden-phone center">Style</th>
                                                <th class="hidden-phone center">Quality</th>
                                                <th class="hidden-phone center">Color</th>
                                                <th class="hidden-phone center">Size</th>
                                                <th class="hidden-phone center">Ex-factory</th>
                                                <th class="hidden-phone center">Season</th>
                                                <th class="hidden-phone center">Warehouse</th>
                                                <th class="hidden-phone center">Remarks</th>
                                                <th class="hidden-phone center">Other Reference</th>
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

    function getWarehousePcsReport() {
        var brands = $("#brands").val();
        var warehouse_type = $("#warehouse_type").val();
        var search_date= $("#src_date").val();

            if(warehouse_type != ''){
            $("#loader").css("display", "block");

            $("#table_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getWarehousePcsReport/",
                type: "POST",
                data: {brands: brands, warehouse_type: warehouse_type, search_date: search_date},
                dataType: "html",
                success: function (data) {
                    console.log(data);
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