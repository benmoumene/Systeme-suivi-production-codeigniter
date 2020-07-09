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
<div class="col-md-6">
    <section class="panel default blue_title h2">

        <div class="panel-body">

            <table class="table">
                <thead>
                    <tr>
                        <th class="center" colspan="4"><?php echo $po.'~'.$item;?></th>
                    </tr>
                    <tr>
                        <th class="center">Size</th>
                        <th class="center">Qty</th>
                        <th class="center">Bundle No</th>
                        <th class="center">Bundle Range</th>
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
                $qty = $v['cut_qty'];
                $bundle = $v['bundle'];
                $bundle_range = $v['bundle_range'];
                $bundle_range = $v['care_label_range'];
                ?>
                    <tr>
                        <td class="center"><?php echo $size.'-'.$cut_layer;?></td>
                        <td class="center"><?php echo $qty;?></td>
                        <td class="center"><?php echo $bundle;?></td>
                        <td class="center"><?php echo $bundle_range;?></td>
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
                        <td class="center" colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</div>
</div>