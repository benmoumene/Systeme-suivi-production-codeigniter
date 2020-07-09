<div class="row">
    <div class="form-group">
        <div class="col-md-12">
            <div class="col-md-3">
                <div class="form-group">
                    <a href="" class="btn btn-primary" onclick="printDiv('print_area');">Print</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="print_area">
<div class="row">
    <div class="form-group">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                    <table border="1">
                        <tr>
                            <th>SAP No.: <?php echo $sap_info[0]['po_no'];?></th>
                            <th>ExFac: <?php echo $sap_info[0]['ex_factory_date'];?></th>
                            <th>Style: <?php echo $sap_info[0]['style_no'].' ~ '.$sap_info[0]['style_name'];?></th>
                        </tr>
                        <tr>
                            <th>Quality-Color: <?php echo $sap_info[0]['quality'].' ~ '.$sap_info[0]['color'];?></th>
                            <th>Total Order: <?php echo $sap_info[0]['total_order_qty'];?></th>
                            <th>Cut Qty: <?php echo $cut_info[0]['total_cut_qty'];?></th>
                        </tr>
                    </table>
                </div>
                </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <section class="panel default blue_title h2">

        <div class="panel-body">

            <?php


            foreach ($cut_nos as $v_c){

                $cut_no = $v_c['cut_no'];


                ?>
                <table class="" id="" border="1" style="float: left; margin-top: 10px; margin-left: 10px;">
                    <thead>
                    <tr>
                        <th class="center" colspan="2"><span style="font-size: 16px;"><b>Cut No: <?php echo $cut_no;?></b></span></th>

                    </tr>
                    <tr>
                        <th class="center">Size</th>
                        <?php
                        $po_items = $this->method_call->getPoItemBySapCut($sap_no, $cut_no);

                        foreach ($po_items as $v_po_item){ ?>
                            <th class="center"><?php echo $v_po_item['purchase_order'].'-'.$v_po_item['item']?></th>
                        <?php } ?>
                        <th class="center">Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_columns = 1;
                    $total_qty = 0;
                    $total_scanned_qty = 0;

                    $cut_order_summary = $this->method_call->getCutOrderSummary($sap_no, $cut_no);

                    foreach ($cut_order_summary as $v){
                        $total_size_qty = 0;

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
                                        <?php echo $v_cut_order['qty'].'('.$v_cut_order['start_cl'].'-'.$v_cut_order['end_cl'].')'; ?>
                                    </td>
                                    <?php

                                    $total_size_qty += $v_cut_order['qty'];
                                }

                                $total_columns++;
                            }

                            ?>

                            <td class="center"><?php echo $total_size_qty;?></td>
                        </tr>
                        <?php
                        $total_qty += $qty;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="center"><span style="font-size: 16px;"><b>Total Qty</b></span></td>
                        <?php

                        foreach ($po_items as $v_po_item) {
                        $total_po_item_qty = 0;

                        $cut_order_1 = $this->method_call->poItemWiseQtyNew($v_po_item['po_no'], $v_po_item['so_no'], $v_po_item['purchase_order'], $v_po_item['item'], $cut_no);

                        if(sizeof($cut_order_1) == 0) { ?>
                        <td class="center"></td>
                        <?php
                        }

                        foreach ($cut_order_1 as $v_cut_order_1) {
                            $total_po_item_qty += $v_cut_order_1['qty'];
                        ?>
                        <td class="center">
                            <?php echo $total_po_item_qty; ?>
                        </td>
                        <?php

                        }

                        $total_columns++;
                        }
                        ?>
                        <td class="center"><span style="font-size: 16px;"><b><?php echo $total_qty;?></b></span></td>
                    </tr>
                    </tfoot>
                </table>
            <?php
            } ?>

        </div>
    </section>
</div>
</div>