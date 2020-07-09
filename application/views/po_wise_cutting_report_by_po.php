<?php
$total_size_qty = 0;
$total_cut_qty = 0;
$total_scanned_size_qty = 0;
$total_unscanned_size_qty = 0;

//foreach ($order_info as $v){
    $responsible_line = $order_info[0]['responsible_line'];
    $purchase_order = $order_info[0]['purchase_order'];
    $item = $order_info[0]['item'];
    $style_no = $order_info[0]['style_no'];
    $quality = $order_info[0]['quality'];
    $color = $order_info[0]['color'];
    $ex_factory_date = $order_info[0]['ex_factory_date'];
    $order_quality = $order_info[0]['order_quality'];
    $cut_qty = $order_info[0]['total_cut_qty'];
    $count_scanned_pc = $order_info[0]['count_scanned_pc'];
    $count_unscanned_pc = $order_info[0]['count_unscanned_pc'];

    $cut_order = $this->method_call->poWiseCuttingInfo($purchase_order, $item, $style_no, $quality, $color);

    ?>
<div class="col-lg-8">
    <section class="panel default blue_title h2">

        <div class="panel-body">

            <table class="table">
                <thead>
                    <tr>
                        <th class="center">LINES</th>
                        <th class="center">PO/STROKE</th>
                        <th class="center">ITEM/WEEK</th>
                        <th class="center">STYLE</th>
                        <th class="center">QUALITY</th>
                        <th class="center">COLOR</th>
                        <th class="center">ExFac. Date</th>
                        <th class="center">Ordered</th>
                        <th class="center">Cut</th>
                        <th class="center">Scanned</th>
                        <th class="center">Un-Scanned</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="center"><?php echo $responsible_line;?></td>
                        <td class="center"><?php echo $purchase_order;?></td>
                        <td class="center"><?php echo $item;?></td>
                        <td class="center"><?php echo $style_no;?></td>
                        <td class="center"><?php echo $quality;?></td>
                        <td class="center"><?php echo $color;?></td>
                        <td class="center"><?php echo $ex_factory_date;?></td>
                        <td class="center"><?php echo $order_quality;?></td>
                        <td class="center"><?php echo $cut_qty;?></td>
                        <td class="center"><?php echo $count_scanned_pc;?></td>
                        <td class="center"><?php echo $count_unscanned_pc;?></td>
                    </tr>
                </tbody>
            </table>
<br />
            <table class="table">
                <thead>
                    <tr>
                        <th class="center">Size</th>
                        <th class="center">Ordered Qty</th>
                        <th class="center">Cut Qty</th>
                        <th class="center">Scanned Qty</th>
                        <th class="center">Un-scanned Qty</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cut_order as $v_1){ ?>
                    <tr style="<?php if($v_1['quantity'] > $v_1['count_scanned_pc']){ ?>background-color: #ff9098; <?php } if($v_1['quantity'] <= $v_1['count_scanned_pc']){ ?>background-color: #aeff82;<?php } ?>">
                        <td class="center"><?php echo $v_1['size'];?></td>
                        <td class="center"><?php echo $v_1['quantity'];?></td>
                        <td class="center"><?php echo $v_1['total_cut_qty'];?></td>
                        <td class="center"><?php echo $v_1['count_scanned_pc'];?></td>
                        <td class="center"><?php echo $v_1['count_unscanned_pc'];?></td>
                    </tr>
                <?php
                    $total_size_qty += $v_1['quantity'];
                    $total_cut_qty += $v_1['total_cut_qty'];
                    $total_scanned_size_qty += $v_1['count_scanned_pc'];
                    $total_unscanned_size_qty += $v_1['count_unscanned_pc'];
                } ?>
                </tbody>
                <tfoot>
                <tr style="background-color: #faffc5; font-weight: 700; font-size: 15px;">
                    <td class="center">Total</td>
                    <td class="center"><?php echo $total_size_qty;?></td>
                    <td class="center"><?php echo $total_cut_qty;?></td>
                    <td class="center"><?php echo $total_scanned_size_qty;?></td>
                    <td class="center"><?php echo $total_unscanned_size_qty;?></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </section>
</div>
<?php
//}
?>