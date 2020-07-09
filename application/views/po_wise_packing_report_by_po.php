<?php
$total_size_qty = 0;
$total_cut_qty = 0;
$total_pack_size_qty = 0;
$total_carton_size_qty = 0;
$total_wh_size_qty = 0;

//foreach ($order_info as $v){
$po_no = $order_info[0]['po_no'];
$purchase_order = $order_info[0]['purchase_order'];
$item = $order_info[0]['item'];
$style_no = $order_info[0]['style_no'];
$quality = $order_info[0]['quality'];
$color = $order_info[0]['color'];
$order_quality = $order_info[0]['order_quantity'];
$cut_qty = $order_info[0]['total_cut_qty'];
$count_total_packing_qty = $order_info[0]['total_packing_qty'];
$count_total_carton_qty = $order_info[0]['total_carton_qty'];
$po_closing_date = $order_info[0]['po_closing_date'];
$total_wh_qty = $order_info[0]['total_wh_qty'];
$count_unscanned_pc = $cut_qty - ($count_total_carton_qty + $total_wh_qty);

$cut_order = $this->method_call->poWiseCatonInfo($po_no, $purchase_order, $item, $style_no, $quality, $color);

?>
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

    <div class="col-lg-8">
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
                        <th class="center">Ordered</th>
                        <th class="center">Cut</th>
                        <th class="center">Packed</th>
                        <th class="center">Carton</th>
                        <th class="center">Balance</th>
                        <th class="center">PO Closing Date</th>
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
                        <td class="center"><?php echo $cut_qty;?></td>
                        <td class="center"><?php echo $count_total_packing_qty;?></td>
                        <td class="center"><?php echo $count_total_carton_qty;?></td>
                        <td class="center"><?php echo $count_unscanned_pc;?></td>
                        <td class="center">
                            <?php
                            if($order_quality <= $count_total_carton_qty) {
                                echo $po_closing_date;
                            } else{
                                echo '';
                            }
                            ?>
                        </td>
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
                        <th class="center">Packed Qty</th>
                        <th class="center">Carton Qty</th>
                        <th class="center">Warehouse Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cut_order as $v_1){ ?>
                        <tr style="<?php if($v_1['order_quantity'] > $v_1['total_carton_qty']){ ?>background-color: #ff9098; <?php } if($v_1['order_quantity'] <= $v_1['total_carton_qty']){ ?>background-color: #aeff82;<?php } ?>">
                            <td class="center"><?php echo $v_1['size'];?></td>
                            <td class="center"><?php echo $v_1['order_quantity'];?></td>
                            <td class="center"><?php echo $v_1['total_cut_qty'];?></td>
                            <td class="center"><?php echo $v_1['total_packing_qty'];?></td>
                            <td class="center"><?php echo $v_1['total_carton_qty'];?></td>
                            <td class="center" style="cursor: pointer;" onclick="getWarehousePcs('<?php echo $v_1['po_no']; ?>', '<?php echo $v_1['purchase_order'];?>','<?php echo $v_1['item'];?>', '<?php echo $v_1['quality']; ?>', '<?php echo $v_1['color']; ?>', '<?php echo $v_1['size']; ?>');" data-target="#myModal3" data-toggle="modal" ><?php echo $v_1['total_wh_qty'];?></td>
                        </tr>
                        <?php
                        $total_size_qty += $v_1['order_quantity'];
                        $total_cut_qty += $v_1['total_cut_qty'];
                        $total_pack_size_qty += $v_1['total_packing_qty'];
                        $total_carton_size_qty += $v_1['total_carton_qty'];
                        $total_wh_size_qty += $v_1['total_wh_qty'];
                    } ?>
                    </tbody>
                    <tfoot>
                    <tr style="background-color: #faffc5; font-weight: 700; font-size: 15px;">
                        <td class="center">Total</td>
                        <td class="center"><?php echo $total_size_qty;?></td>
                        <td class="center"><?php echo $total_cut_qty;?></td>
                        <td class="center"><?php echo $total_pack_size_qty;?></td>
                        <td class="center"><?php echo $total_carton_size_qty;?></td>
                        <td class="center"><?php echo $total_wh_size_qty;?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>
<?php
//}
?>