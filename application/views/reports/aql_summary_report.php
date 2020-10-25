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
        <h1>AQL Report</h1>
        <h2 class="">AQL Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">AQL Report</li>
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
                                <br />
                                <span><b>* Select Brands </b></span>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="from_date" name="from_date" readonly="readonly" placeholder="mm-dd-YYY">
                                <span><b>* Ship Date From </b></span>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control form-control-inline input-medium default-date-picker" id="to_date" name="to_date" readonly="readonly" placeholder="mm-dd-YYY">
                                <span><b>* Ship Date To </b></span>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="po_type[]" id="po_type">
                                    <option value="">PO Type...</option>
                                    <option value="0">Bulk</option>
                                    <option value="1">Size Set</option>
                                    <option value="2">Sample</option>
                                </select>
                                <span><b>* PO Type </b></span>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submit_btn" onclick="getAQLSummaryReport();">SEARCH</button>
                            </div>
                            <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                        </div>
                    </div>

                    <br />

                    <div id="print_div">
                        <div class="row">

                            <div id="table_content">
                                <div class="col-md-12" id="tableWrap">


                                    <table class="table table-bordered table-striped" id="" border="1">
                                        <thead>
                                        <tr style="font-size: 20px;">
                                            <th class="hidden-phone center" rowspan="2">Brand</th>
                                            <th class="hidden-phone center" rowspan="2">ETD</th>
                                            <th class="hidden-phone center" colspan="5" style="background-color: rgba(105,216,138,0.88);">Today AQL Status</th>
                                            <th class="hidden-phone center" colspan="7" style="background-color: rgba(180,216,28,0.88);">PO CLOSING STATUS</th>
                                        </tr>
                                        <tr style="font-size: 16px;">
                                            <th class="hidden-phone center">Plan</th>
                                            <th class="hidden-phone center">Offer</th>
                                            <th class="hidden-phone center">Pass</th>
                                            <th class="hidden-phone center">Fail</th>
                                            <th class="hidden-phone center">Blnc</th>
                                            <th class="hidden-phone center">PO</th>
                                            <th class="hidden-phone center">Ready for AQL</th>
                                            <th class="hidden-phone center">Offered AQL</th>
                                            <th class="hidden-phone center">Pass</th>
                                            <th class="hidden-phone center">Fail</th>
                                            <th class="hidden-phone center">Offer Blnc</th>
                                            <th class="hidden-phone center">Closing Blnc</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">

                            <div id="table_content_2">
                                <div class="col-md-12" id="tableWrap">


                                    <table class="table table-bordered table-striped" id="" border="1">
                                        <thead>
                                            <tr style="font-size: 20px;">
                                                <th class="hidden-phone center" colspan="12" style="background-color: rgba(216,114,94,0.88);">FAIL LIST</th>
                                            </tr>
                                            <tr style="font-size: 16px;">
                                                <th class="hidden-phone center">#</th>
                                                <th class="hidden-phone center">SO</th>
                                                <th class="hidden-phone center">PO</th>
                                                <th class="hidden-phone center">ITEM</th>
                                                <th class="hidden-phone center">QUALITY</th>
                                                <th class="hidden-phone center">COLOR</th>
                                                <th class="hidden-phone center">STYLE</th>
                                                <th class="hidden-phone center">STYLE NAME</th>
                                                <th class="hidden-phone center">BRAND</th>
                                                <th class="hidden-phone center">ExFac</th>
                                                <th class="hidden-phone center">ORDER QTY</th>
                                                <th class="hidden-phone center">AQL DATE</th>
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

    function getAQLSummaryReport() {
        var brands = $("#brands").val();

        if(brands != null){
            var brands_string = brands.toString();
        }

        var po_type = $("#po_type").val();

        var from_dt = $("#from_date").val();
        var to_dt = $("#to_date").val();

        var res1 = from_dt.split("-");
        var res2 = to_dt.split("-");

        var from_date = res1[2]+'-'+res1[0]+'-'+res1[1];
        var to_date = res2[2]+'-'+res2[0]+'-'+res2[1];

        if(brands_string != '' && from_date != '' && to_date != '' && po_type != ''){
            $("#loader").css("display", "block");

            $("#table_content").empty();
            $("#table_content_2").empty();

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getAQLSummaryReport/",
                type: "POST",
                data: {brands: brands_string, from_date: from_date, to_date: to_date, po_type: po_type},
                dataType: "html",
                success: function (data) {
                    $("#table_content").append(data);
                    $("#loader").css("display", "none");
                }
            });

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getAQLFailSummaryReport/",
                type: "POST",
                data: {brands: brands_string, from_date: from_date, to_date: to_date, po_type: po_type},
                dataType: "html",
                success: function (data) {
                    $("#table_content_2").append(data);
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