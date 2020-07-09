<div class="col-md-12">
    <section class="panel default blue_title h2">

        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr>
                        <th class="center" colspan="11"><span style="font-size: 20px;"><?php echo $line_po_items[0]['line_name']?></span></th>
                    </tr>
                    <tr>
                        <th class="center">PO-Item</th>
                        <th class="center">BRAND</th>
                        <th class="center">QLTY-CLR</th>
                        <th class="center">STL</th>
                        <th class="center">ExFac</th>
                        <th class="center"><span data-toggle="tooltip" title="Order QTY">OQ</span></th>
                        <th class="center"><span data-toggle="tooltip" title="Cut QTY">CQ</span></th>
                        <th class="center">Input</th>
                        <th class="center"><span data-toggle="tooltip" title="Collar-Cuff Qty">CC</span></th>
                        <th class="center"><span data-toggle="tooltip" title="Mid-Pass QTY">MQ</span></th>
                        <th class="center"><span data-toggle="tooltip" title="End-Pass QTY">EQ</span></th>
                        <th class="center"><span data-toggle="tooltip" title="line Balance QTY">LBQ</span></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($line_po_items as $v){ ?>
                    <tr>
                        <td class="center"><?php echo $v['purchase_order'].'-'.$v['item'];?></td>
                        <td class="center"><?php echo $v['brand'];?></td>
                        <td class="center"><?php echo $v['quality'].'-'.$v['color'];?></td>
                        <td class="center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                        <td class="center"><?php echo $v['ex_factory_date'];?></td>
                        <td class="center"><?php echo $v['total_order_qty'];?></td>
                        <td class="center"><?php echo $v['total_cut_qty'];?></td>
                        <td class="center"><?php echo $v['count_input_qty_line'];?></td>
                        <td class="center"><?php echo $v['collar_cuff_bndl_qty'];?></td>
                        <td class="center"><?php echo $v['count_mid_line_qc_pass'];?></td>
                        <td class="center"><?php echo $v['count_end_line_qc_pass'];?></td>
                        <td class="center"><?php echo $v['count_input_qty_line'] - $v['count_end_line_qc_pass'];?></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>
</div>