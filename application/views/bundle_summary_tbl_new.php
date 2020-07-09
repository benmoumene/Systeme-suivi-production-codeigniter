<?php
$po_count=0;
foreach ($po_items as $v_po_count) {
    $po_count++;
}
?>
<div class="col-md-12">
    <section class="panel default blue_title h2">

        <div class="panel-body">

            <table class="display table table-bordered table-striped" id="sample_2">
                <thead>

<!--                --><?php //echo $img_url?>
<!---->




                    <tr>
                        <th class="center" colspan="<?php echo $po_count+1;?>">
                            <div style="float: left; padding: 2px">
                                <?php

                                $input_ticket_no_file = $img_url;
                                //                    echo $input_ticket_no_file;

                                $code = '<center><img src="'. base_url().'uploads/qr_image/'.$input_ticket_no_file.'" width="70" height="70" title="QR Code Image!"></center>';
                                echo $code;
                                ?>
                            </div>

                            <span style="font-size: 20px;">
                                SAP No.: <?php echo $cut_order_summary[0]['po_no'];?> /
                                Cut No.: <?php echo $cut_order_summary[0]['cut_no'];?> /
                                Style_Name: <?php echo $cut_order_summary[0]['style_name'];?> /
                                Quality: <?php echo $cut_order_summary[0]['quality'];?> /
                                Color: <?php echo $cut_order_summary[0]['color'];?> /
                                Ex-Fac Date: <?php echo $cut_order_summary[0]['ex_factory_date'];?> /
                                <?php
                                echo ($cut_order_summary[0]['is_lay_complete'] == 1 ? "Lay Complete /" : "");
                                echo ($cut_order_summary[0]['is_cutting_complete'] == 1 ? "Cut Complete /" : "");
                                ?>
                            </span>
                        </th>
                    </tr>
                    <tr>
                        <th class="center">Size</th>
                        <?php foreach ($po_items as $v_po_item){ ?>
                        <th class="center"><?php echo $v_po_item['purchase_order'].'-'.$v_po_item['item'].'-'.$v_po_item['so_no']?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                $total_columns = 1;
                $total_qty = 0;
                $total_scanned_qty = 0;

                foreach ($cut_order_summary as $v){
                $po_no = $v['po_no'];
                $purchase_order = $v['purchase_order'];
                $item = $v['item'];
                $size = $v['size'];
                $cut_no = $v['cut_no'];
                $cut_layer = $v['cut_layer'];
                $qty = $v['qty'];
                ?>
                    <tr>
                        <td class="center"><?php echo $size.'-'.$cut_layer;?></td>
                        <?php

//                            $po_items_size_layer = $this->method_call->sizeCutLayerWisePoItems($po_no, $size, $cut_no, $cut_layer);
                            foreach ($po_items as $v_po_item) {
                                $cut_order = $this->method_call->poItemSizeCutLayerWiseQtyNew($v_po_item['po_no'], $v_po_item['so_no'], $v_po_item['purchase_order'], $v_po_item['item'], $size, $cut_no, $cut_layer);

                            if(sizeof($cut_order) == 0) { ?>
                                <td class="center"></td>
                                <?php
                            }
                            foreach ($cut_order as $v_cut_order) {
                                    ?>
                                    <td class="center">

                                        <?php echo $v_cut_order['qty'] . ' (' . $v_cut_order['start_cl'] . ' - ' . $v_cut_order['end_cl'] . ')'; ?>
<!--                                        <br/>-->
<!--                                        --><?php //echo $v_po_item['purchase_order'] . '_' . $v_po_item['item'] ?>
                                    </td>
                                    <?php

                                }

                                $total_columns++;
                            }

                        ?>
                    </tr>
                <?php
                    $total_qty += $qty;
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="center"><h4><b>Total Qty</b></h4></td>
                        <td class="center" colspan="<?php echo $total_columns;?>"><h4><b><?php echo $total_qty;?></b></h4></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</div>