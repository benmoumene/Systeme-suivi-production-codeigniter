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
        <h1>AQL Plan</h1>
        <h2 class="">AQL Plan...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">AQL Plan</li>
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
                                <select class="form-control" name="po_type[]" id="po_type">
                                    <option value="">PO Type...</option>
                                    <option value="0">Bulk</option>
                                    <option value="1">Size Set</option>
                                    <option value="2">Sample</option>
                                </select>
                                <br />
                                <span><b>* Select PO Type </b></span>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submit_btn" onclick="getShipDateWiseReport();">SEARCH</button>
                            </div>
                            <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                        </div>
                    </div>

                    <br />

                    <div class="row">

                        <div id="table_content">
                            <div class="col-md-12" id="tableWrap">

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

    function getShipDateWiseReport() {
        var brands = $("#brands").val();
        var po_type = $("#po_type").val();

        var brands_string = brands.toString();

        var ship_date = $("#ship_date").val();

        if(ship_date != '' && brands != null && po_type != ''){
            $("#loader").css("display", "block");

            $("#table_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>access/getShipDateWiseAqlPlanList/",
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
    
    function saveAqlPlan() {
        var so_no = [];
        $("input[name='so_no[]']").each(function() {
            so_no.push($(this).val());
        });

        var aql_plan_date = [];
        $("input[name='aql_plan_date[]']").each(function() {
            aql_plan_date.push($(this).val());
        });

        var ready_for_aql = [];
        $('.ready_for_aql').each(function (index) {
            ready_for_aql.push(this.value);
        });

        $("#loader").css("display", "block");

        $.ajax({
            url: "<?php echo base_url();?>access/saveAqlPlanNew/",
            type: "POST",
            data: {so_no: so_no, aql_plan_date: aql_plan_date, ready_for_aql: ready_for_aql},
            dataType: "html",
            success: function (data) {

                if(data == 'done'){
                    $("#loader").css("display", "none");
                    $("#submit_btn").click();
                }

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