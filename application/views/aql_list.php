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
        <h1>AQL</h1>
        <h2 class="">AQL...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">AQL</li>
        </ol>
    </div>
</div>
<form action="<?php echo base_url();?>access/saveAqlStatus" method="post">
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
                                                <th class="hidden-phone center">SO</th>
                                                <th class="hidden-phone center">PO</th>
                                                <th class="hidden-phone center">Item</th>
                                                <th class="hidden-phone center">Quality</th>
                                                <th class="hidden-phone center">Color</th>
                                                <th class="hidden-phone center">Style</th>
                                                <th class="hidden-phone center">Style Name</th>
                                                <th class="hidden-phone center">Brand</th>
                                                <th class="hidden-phone center">Order</th>
                                                <th class="hidden-phone center">Ex-Fac</th>
                                                <th class="hidden-phone center">AQL Date</th>
                                                <th class="hidden-phone center">AQL Status</th>
                                                <th class="hidden-phone center">Action</th>
                                                <th class="hidden-phone center">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($aql_list AS $v){ ?>
                                                <tr>
                                                    <td class="hidden-phone center">
                                                        <input type="text" name="so_no[]" id="so_no" value="<?php echo $v['so_no'];?>" readonly="readonly" />
                                                    </td>
                                                    <td class="hidden-phone center"><?php echo $v['purchase_order'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['item'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['quality'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['color'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['style_no'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['style_name'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['brand'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['order_qty'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['ex_factory_date'];?></td>
                                                    <td class="hidden-phone center"><?php echo $v['aql_plan_date'];?></td>
                                                    <td class="hidden-phone center">
                                                        <?php
                                                            if($v['aql_status'] == 0){
                                                                echo 'Pending';
                                                            }
                                                            if($v['aql_status'] == 1){
                                                                echo 'Pass';
                                                            }
                                                            if($v['aql_status'] == 2){
                                                                echo 'Fail';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="hidden-phone center">
                                                        <select name="aql_status[]" id="aql_status">
                                                            <option value="">Select Status</option>
                                                            <option value="1">Pass</option>
                                                            <option value="2">Fail</option>

                                                        </select>
                                                    </td>
                                                    <td class="hidden-phone center">
                                                        <input type="text" name="aql_remarks[]" id="aql_remarks" value="<?php echo $v['aql_remarks'];?>" />
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </sec>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10"></div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success">SAVE AQL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</form>
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