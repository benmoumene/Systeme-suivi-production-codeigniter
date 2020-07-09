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
        <h1>Daily Line Output Report</h1>
        <h2 class="">Daily Line Output Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Daily Line Output Report</li>
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

                    <br />
                    <button type="button" onclick="printDiv('print_div')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print</button>
                    <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
                    <br />

                    <div id="print_div">
                    <div class="row">

                        <div id="table_content">
                            <div class="col-md-12" id="tableWrap">

                                <table class="table table-bordered table-striped" id="" border="1">
                                    <thead>
                                        <tr>
                                            <th class="hidden-phone center">SO</th>
                                            <th class="hidden-phone center">Brand</th>
                                            <th class="hidden-phone center">Purchase Order</th>
                                            <th class="hidden-phone center">Item</th>
                                            <th class="hidden-phone center">Style</th>
                                            <th class="hidden-phone center">Style Name</th>
                                            <th class="hidden-phone center">Quality</th>
                                            <th class="hidden-phone center">Color</th>
                                            <th class="hidden-phone center">Ex-Factory</th>
                                            <th class="hidden-phone center">Order</th>
                                            <th class="hidden-phone center">Line</th>
                                            <th class="hidden-phone center">Date</th>
                                            <th class="hidden-phone center">Line Output</th>
                                            <th class="hidden-phone center">Manual Closed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $total_line_output = 0;
                                    $total_line_manual_output = 0;

                                    foreach($daily_output AS $v){

                                        $total_line_output += $v['line_output_qty'];
                                        $total_line_manual_output += $v['line_manual_output_qty'];
                                    ?>
                                        <tr>
                                            <td class="hidden-phone center"><?php echo $v['so_no'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['brand'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['purchase_order'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['item'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['style_no'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['style_name'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['quality'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['color'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['ex_factory_date'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['total_order_qty'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['line_code'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['line_output_date'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['line_output_qty'];?></td>
                                            <td class="hidden-phone center"><?php echo $v['line_manual_output_qty'];?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="hidden-phone center" colspan="12"></td>
                                            <td class="hidden-phone center"><?php echo $total_line_output;?></td>
                                            <td class="hidden-phone center"><?php echo $total_line_manual_output;?></td>
                                        </tr>
                                    </tfoot>
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

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        location.reload();
    }

</script>