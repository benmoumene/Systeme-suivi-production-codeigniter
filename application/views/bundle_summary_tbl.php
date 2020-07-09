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
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-control">SAP No.: <?php echo $cut_order_summary[0]['po_no'];?></label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-control">Cut No.: <?php echo $cut_order_summary[0]['cut_no'];?></label>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <div class="col-md-12">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-control">Style_Name: <?php echo $cut_order_summary[0]['style_name'];?></label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-control">Quality_Color: <?php echo $cut_order_summary[0]['quality'].'_'.$cut_order_summary[0]['color'];?></label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <section class="panel default blue_title h2">

        <div class="panel-body">

            <table class="display table table-bordered table-striped" id="sample_2">
                <thead>
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
                                $cut_order = $this->method_call->poItemSizeCutLayerWiseQty($v_po_item['po_no'], $v_po_item['so_no'], $v_po_item['purchase_order'], $v_po_item['item'], $size, $cut_no, $cut_layer);

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
</div>