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
        <h1>AQL Summary</h1>
        <h2 class="">AQL Summary...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">AQL Summary</li>
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
                    <div id="print_div">
                    <div class="row">
                        <sec class="table-responsive">
                            <section class="panel default blue_title h2">

                                <div class="panel-body" id="table_content" style="overflow-x:auto;">

                                    <table class="display table table-bordered table-striped" id="" border="1">
                                        <thead>
                                            <tr>
                                                <th class="hidden-phone center">Brand</th>
                                                <th class="hidden-phone center">Today AQL</th>
                                                <th class="hidden-phone center">Previous Due AQL</th>
                                                <th class="hidden-phone center">Pass</th>
                                                <th class="hidden-phone center">Fail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            foreach($aql_summary AS $v){
                                                if($v['today_plan_aql_count'] != '' || $v['previous_due_aql_count'] || $v['today_plan_aql_pass_count'] || $v['previous_due_aql_pass_count']){
                                            ?>
                                                <tr>
                                                    <td class="hidden-phone center"><?php echo $v['brand'];?></td>
                                                    <td class="hidden-phone center">
                                                        <a class="btn btn-primary" href="<?php echo base_url()?>access/aqlListDetail/<?php echo $v['brand'];?>">
                                                            <?php echo ($v['today_plan_aql_count'] != '' ? $v['today_plan_aql_count'] : 0);?>
                                                        </a>
                                                    </td>
                                                    <td class="hidden-phone center">
                                                        <a class="btn btn-primary" href="<?php echo base_url()?>access/getDueAqlTargetList/<?php echo $v['brand'];?>">
                                                            <?php echo ($v['previous_due_aql_count'] != '' ? $v['previous_due_aql_count'] : 0);?>
                                                        </a>
                                                    </td>
                                                    <td class="hidden-phone center"><?php echo $v['today_plan_aql_pass_count']+$v['previous_due_aql_pass_count'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['today_plan_aql_fail_count']+$v['previous_due_aql_fail_count'];?></td>
                                                </tr>
                                            <?php
                                                }
                                            } ?>
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

//        var from_dt = $("#from_date").val();
//        var to_dt = $("#to_date").val();
//
//        var res1 = from_dt.split("-");
//        var res2 = to_dt.split("-");
//
//        var from_date = res1[2]+'-'+res1[0]+'-'+res1[1];
//        var to_date = res2[2]+'-'+res2[0]+'-'+res2[1];

        var month_year = $("#src_date").val();

        if(month_year != '' && brands != null && po_type != ''){
            $("#loader").css("display", "block");

            $("#table_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getShipDateWiseReportMonth/",
                type: "POST",
                data: {brands: brands, month_year: month_year, po_type: po_type},
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