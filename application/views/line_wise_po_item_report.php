<!--\\\\\\\ contentpanel start\\\\\\-->
    <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
            <h1>Line Wise PO-Item Report</h1>
            <h2 class="">Line Wise PO-Item Report...</h2>
        </div>
        <div class="pull-right">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">DASHBOARD</a></li>
                <li class="active">Line Wise PO-Item Report</li>
            </ol>
        </div>
    </div>
    <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                <div class="col-md-3">
                    <div class="form-group">
                        <select required class="form-control" id="line_no" name="line_no" onchange="getReportByLine(id);">
                                <option value="">Select Line...</option>
                            <?php
                                foreach ($lines as $l){ ?>
                                    <option value="<?php echo $l['id'];?>"><?php echo $l['line_name'];?></option>
                            <?php
                                }
//                            ?>
                        </select>
                        <span style="font-size: 11px;">* Select Line</span>

                    </div>

                </div>



                </div>
            </div>

        </div>
        <br />

        <div class="row" id="report_content">
            <?php
            foreach ($order_info as $v){
                $purchase_order = $v['purchase_order'];
                $item = $v['item'];
                $style_no = $v['style_no'];
                $quality = $v['quality'];
                $color = $v['color'];
                $order_quality = $v['order_quality'];
                $count_scanned_pc = $v['count_scanned_pc'];

                $cut_order = $this->method_call->poWiseCuttingInfo($purchase_order, $item, $style_no, $quality, $color);

                ?>
            <div class="col-lg-6">
                <section class="panel default blue_title h2">

                    <div class="panel-body">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="center">PO/STROKE</th>
                                    <th class="center">ITEM/WEEK</th>
                                    <th class="center">STYLE</th>
                                    <th class="center">QUALITY</th>
                                    <th class="center">COLOR</th>
                                    <th class="center">Ordered Qty</th>
                                    <th class="center">Scanned Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="center"><?php echo $purchase_order;?></td>
                                    <td class="center"><?php echo $item;?></td>
                                    <td class="center"><?php echo $style_no;?></td>
                                    <td class="center"><?php echo $quality;?></td>
                                    <td class="center"><?php echo $color;?></td>
                                    <td class="center"><?php echo $order_quality;?></td>
                                    <td class="center"><?php echo $count_scanned_pc;?></td>
                                </tr>
                            </tbody>
                        </table>
<br />
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="center">Size</th>
                                    <th class="center">Ordered Qty</th>
                                    <th class="center">Scanned Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $total_qty = 0;
                            $total_scanned_qty = 0;
                            foreach ($cut_order as $v){ ?>
                                <tr style="<?php if($v['quantity'] != $v['count_scanned_pc']){ ?>background-color: #ff9098; <?php } if($v['quantity'] == $v['count_scanned_pc']){ ?>background-color: #aeff82;<?php } ?>">
                                    <td class="center"><?php echo $v['size'];?></td>
                                    <td class="center"><?php echo $v['quantity'];?></td>
                                    <td class="center"><?php echo $v['count_scanned_pc'];?></td>
                                </tr>
                            <?php
                                $total_qty += $v['quantity'];
                                $total_scanned_qty += $v['count_scanned_pc'];
                                }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr style="background-color: #faffc5; font-weight: 700; font-size: 15px;">
                                    <td class="center">Total</td>
                                    <td class="center"><?php echo $total_qty;?></td>
                                    <td class="center"><?php echo $total_scanned_qty;?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
            </div>
            <?php
            }
            ?>
    </div>
    <!--\\\\\\\ container  end \\\\\\-->



<script type="text/javascript">
    $('select').select2();

//    setTimeout(function(){
//        window.location.reload(1);
//    }, 5000);

    function getReportByLine(id) {
        var line_no = $("#"+id).val();

        $("#report_content").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getLineWisePoItemReport/",
            type: "POST",
            data: {line_no: line_no},
            dataType: "html",
            success: function (data) {
                $("#report_content").append(data);
            }
        });

    }
</script>