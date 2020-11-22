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
        <h1>Piece By Piece Detail</h1>
        <h2 class="">Piece By Piece Detail...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Piece By Piece Detail</li>
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
                            <div class="col-md-3">
                                <select class="form-control" name="piece_no[]" id="piece_no">
                                    <option value="">Select Piece No</option>
                                    <?php foreach ($pieces as $v){ ?>
                                          <option value="<?php echo $v['pc_tracking_no'];?>"><?php echo $v['pc_tracking_no']?></option>
                                    <?php } ?>
                                </select>
                                <span><b>* Select Piece No. </b></span>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submit_btn" onclick="getPieceReport();">SEARCH</button>
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
                                                    <th class="hidden-phone center">Piece No</th>
                                                    <th class="hidden-phone center">Size</th>
                                                    <th class="hidden-phone center">SO</th>
                                                    <th class="hidden-phone center">Type</th>
                                                    <th class="hidden-phone center">Brand</th>
                                                    <th class="hidden-phone center">Purchase Order</th>
                                                    <th class="hidden-phone center">Item</th>
                                                    <th class="hidden-phone center">Style</th>
                                                    <th class="hidden-phone center">Style Name</th>
                                                    <th class="hidden-phone center">Quality</th>
                                                    <th class="hidden-phone center">Color</th>
                                                    <th class="hidden-phone center">ExFac</th>
                                                    <th class="hidden-phone center">Package Ready?</th>
                                                    <th class="hidden-phone center">Sent to Sew</th>
                                                    <th class="hidden-phone center">Line</th>
                                                    <th class="hidden-phone center">Line Input</th>
                                                    <th class="hidden-phone center">Mid Pass</th>
                                                    <th class="hidden-phone center">Line Output</th>
                                                    <th class="hidden-phone center">Wash Sent</th>
                                                    <th class="hidden-phone center">Wash Received</th>
                                                    <th class="hidden-phone center">Poly</th>
                                                    <th class="hidden-phone center">Carton</th>
                                                    <th class="hidden-phone center">Close By Admin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($pieces as $p){ ?>
                                                <tr>
                                                    <td class="center"><?php echo $p['pc_tracking_no'];?></td>
                                                    <td class="center"><?php echo $p['size'];?></td>
                                                    <td class="center"><?php echo $p['so_no'];?></td>
                                                    <td class="center">
                                                        <?php
                                                            if($p['po_type'] == 0){
                                                                echo 'BULK';
                                                            }
                                                            if($p['po_type'] == 1){
                                                                echo 'SIZE SET';
                                                            }
                                                            if($p['po_type'] == 2){
                                                                echo 'SAMPLE';
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="center"><?php echo $p['brand'];?></td>
                                                    <td class="center"><?php echo $p['purchase_order'];?></td>
                                                    <td class="center"><?php echo $p['item'];?></td>
                                                    <td class="center"><?php echo $p['style_no'];?></td>
                                                    <td class="center"><?php echo $p['style_name'];?></td>
                                                    <td class="center"><?php echo $p['quality'];?></td>
                                                    <td class="center"><?php echo $p['color'];?></td>
                                                    <td class="center"><?php echo $p['ex_factory_date'];?></td>
                                                    <td class="center"><?php echo ($p['is_package_ready'] == 1 ? 'YES' : 'NO');?></td>
                                                    <td class="center"><?php echo $p['package_sent_to_production_date_time'];?></td>
                                                    <td class="center"><?php echo $p['line_code'];?></td>
                                                    <td class="center"><?php echo $p['line_input_date_time'];?></td>
                                                    <td class="center"><?php echo $p['mid_line_qc_date_time'];?></td>
                                                    <td class="center"><?php echo $p['end_line_qc_date_time'];?></td>
                                                    <td class="center"><?php echo $p['going_wash_scan_date_time'];?></td>
                                                    <td class="center"><?php echo $p['washing_date_time'];?></td>
                                                    <td class="center"><?php echo $p['packing_date_time'];?></td>
                                                    <td class="center"><?php echo $p['carton_date_time'];?></td>
                                                    <td class="center">
                                                        <?php
                                                            if($p['manually_closed'] == 1){
                                                                echo 'Yes';
                                                            }
                                                        ?>
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

    function getPieceReport() {
        var piece_no = $("#piece_no").val();

        if(piece_no != ''){
            $("#loader").css("display", "block");

            $("#table_content").empty();

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getPieceByPieceDetailFilter/",
                type: "POST",
                data: {piece_no: piece_no},
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