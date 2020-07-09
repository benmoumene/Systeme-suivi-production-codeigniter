<!--\\\\\\\ contentpanel start\\\\\\-->
    <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
            <h1>PO Wise Cutting Report</h1>
            <h2 class="">PO Wise Cutting Report...</h2>
        </div>
        <div class="pull-right">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">DASHBOARD</a></li>
                <li class="active">PO Wise Cutting Report</li>
            </ol>
        </div>
    </div>
    <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                <div class="col-md-5">
                    <div class="form-group">
                        <select required class="form-control" id="po_no" name="po_no" onchange="getReportByPo(id);">
                                <option value="">SO_PO_ITEM_STYLE_QUALITY_COLOR</option>
                            <?php
                                foreach ($purchase_order_nos as $pos){ ?>
                                    <option value="<?php echo $pos['po_no'].'_'.$pos['purchase_order'].'_'.$pos['item'].'_'.$pos['color'];?>"><?php echo $pos['po_no'].'_'.$pos['purchase_order'].'_'.$pos['item'].'_'.$pos['style_no'].'_'.$pos['quality'].'_'.$pos['color'];?></option>
                            <?php
                                }
//                            ?>
                        </select>
                        <span style="font-size: 11px;">* Select PO No.</span>
                    </div>
                </div>


                </div>
            </div>
        </div>
        <br />

        <div class="row" id="report_content">
<!--            --><?php
//            foreach ($order_info as $v){
//                $responsible_line = $v['responsible_line'];
//                $purchase_order = $v['purchase_order'];
//                $item = $v['item'];
//                $style_no = $v['style_no'];
//                $quality = $v['quality'];
//                $color = $v['color'];
//                $ex_factory_date = $v['ex_factory_date'];
//                $order_quality = $v['order_quality'];
//                $count_scanned_pc = $v['count_scanned_pc'];
//
//                $cut_order = $this->method_call->poWiseCuttingInfo($purchase_order, $item, $style_no, $quality, $color);
//
//                ?>
<!--            <div class="col-lg-6">-->
<!--                <section class="panel default blue_title h2">-->
<!---->
<!--                    <div class="panel-body">-->
<!---->
<!--                        <table class="table">-->
<!--                            <thead>-->
<!--                                <tr>-->
<!--                                    <th class="center">Lines</th>-->
<!--                                    <th class="center">PO/STROKE</th>-->
<!--                                    <th class="center">ITEM/WEEK</th>-->
<!--                                    <th class="center">STYLE</th>-->
<!--                                    <th class="center">QUALITY</th>-->
<!--                                    <th class="center">COLOR</th>-->
<!--                                    <th class="center">ExFac. Date</th>-->
<!--                                    <th class="center">Ordered Qty</th>-->
<!--                                    <th class="center">Scanned Qty</th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody>-->
<!--                                <tr>-->
<!--                                    <td class="center">--><?php //echo $responsible_line;?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $purchase_order;?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $item;?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $style_no;?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $quality;?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $color;?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $ex_factory_date;?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $order_quality;?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $count_scanned_pc;?><!--</td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--<br />-->
<!--                        <table class="table">-->
<!--                            <thead>-->
<!--                                <tr>-->
<!--                                    <th class="center">Size</th>-->
<!--                                    <th class="center">Ordered Qty</th>-->
<!--                                    <th class="center">Scanned Qty</th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody>-->
<!--                            --><?php
//                            $total_qty = 0;
//                            $total_scanned_qty = 0;
//                            foreach ($cut_order as $v){ ?>
<!--                                <tr style="--><?php //if($v['quantity'] != $v['count_scanned_pc']){ ?><?php //} if($v['quantity'] == $v['count_scanned_pc']){ ?><?php //} ?><!--">-->
<!--                                    <td class="center">--><?php //echo $v['size'];?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $v['quantity'];?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $v['count_scanned_pc'];?><!--</td>-->
<!--                                </tr>-->
<!--                            --><?php
//                                $total_qty += $v['quantity'];
//                                $total_scanned_qty += $v['count_scanned_pc'];
//                                }
//                            ?>
<!--                            </tbody>-->
<!--                            <tfoot>-->
<!--                                <tr style="background-color: #faffc5; font-weight: 700; font-size: 15px;">-->
<!--                                    <td class="center">Total</td>-->
<!--                                    <td class="center">--><?php //echo $total_qty;?><!--</td>-->
<!--                                    <td class="center">--><?php //echo $total_scanned_qty;?><!--</td>-->
<!--                                </tr>-->
<!--                            </tfoot>-->
<!--                        </table>-->
<!--                    </div>-->
<!--                </section>-->
<!--            </div>-->
<!--            --><?php
//            }
//            ?>
    </div>
    </div>
    <!--\\\\\\\ container  end \\\\\\-->



<script type="text/javascript">
    $('select').select2();

//    setTimeout(function(){
//        window.location.reload(1);
//    }, 5000);

    function getReportByPo(id) {
        var purchase_order_stuff = $("#"+id).val();

        $("#report_content").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoWiseReportbyPo/",
            type: "POST",
            data: {purchase_order_stuff: purchase_order_stuff},
            dataType: "html",
            success: function (data) {
                $("#report_content").append(data);
            }
        });

    }
</script>