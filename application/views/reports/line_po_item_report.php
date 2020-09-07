<div class="col-md-12" id="tableWrap">
    <section class="panel default blue_title h2">

        <div class="panel-body">

            <?php

            $total_wip_qty = 0;

            foreach ($line_no as $vl){


                $line_po_items = $this->method_call->getLineWisePoItemDetailReport($vl);

            ?>

            <table class="table" border="1">
                <thead>
                    <tr>
                        <th class="center" colspan="17"><span style="font-size: 20px;"><?php echo $line_po_items[0]['line_name']?></span></th>
                    </tr>
                    <tr>
                        <th class="center">PO-Item</th>
                        <th class="center">SO</th>
                        <th class="center">BRAND</th>
                        <th class="center">QLTY-CLR</th>
                        <th class="center">STL</th>
                        <th class="center">SMV</th>
                        <th class="center">PO TYPE</th>
                        <th class="center">ExFac</th>
                        <th class="center"><span data-toggle="tooltip" title="Order QTY">Order</span></th>
<!--                        <th class="center"><span data-toggle="tooltip" title="Cut QTY">Cut</span></th>-->
<!--                        <th class="center"><span data-toggle="tooltip" title="Cut Pass QTY">Cut Pass</span></th>-->
<!--                        <th class="center"><span data-toggle="tooltip" title="Other Line Input">Other Line</span></th>-->
                        <th class="center">Input Date</th>
                        <th class="center">Output Start</th>
                        <th class="center">Input</th>
<!--                        <th class="center">Input Date</th>-->
                        <th class="center"><span data-toggle="tooltip" title="Collar Qty">Collar</span></th>
                        <th class="center"><span data-toggle="tooltip" title="Cuff Qty">Cuff</span></th>
                        <th class="center"><span data-toggle="tooltip" title="Mid-Pass QTY">Mid</span></th>
                        <th class="center"><span data-toggle="tooltip" title="End-Pass QTY">End</span></th>
                        <th class="center"><span data-toggle="tooltip" title="line Balance QTY">Balance</span></th>
                    </tr>
                </thead>
                <tbody>
                <?php

                $balance = 0;
                $total_balance = 0;

                foreach ($line_po_items as $v){
                    $total_line_input_qty = $v['count_input_qty_line'] + $v['count_other_input_qty_line'];

                    if($v['count_input_qty_line'] - ($v['count_end_line_qc_pass'] + $v['count_manual_close']) > 0) {

                        $balance = $v['count_input_qty_line'] - $v['count_end_line_qc_pass'];
                        $total_balance += $balance;

                ?>

                        <tr>
                            <td class="center">
                                <?php echo $v['purchase_order'] . '-' . $v['item']; ?>
                            </td>
                            <td class="center"><?php echo $v['so_no']; ?></td>
                            <td class="center"><?php echo $v['brand']; ?></td>
                            <td class="center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                            <td class="center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                            <td class="center"><?php echo (sprintf('%0.2f', $v['smv'])); ?></td>
                            <td class="center">
                                <?php
                                if($v['po_type'] == 0){
                                    echo 'BULK';
                                }
                                if($v['po_type'] == 1){
                                    echo 'SIZE SET';
                                }
                                if($v['po_type'] == 2){
                                    echo 'SAMPLE';
                                }

                                ?>
                            </td>
                            <td class="center"><?php echo $v['ex_factory_date']; ?></td>
                            <td class="center"><?php echo $v['total_order_qty']; ?></td>
<!--                            <td class="center">--><?php //echo $v['total_cut_qty']; ?><!--</td>-->
<!--                            <td class="center">--><?php //echo $v['total_cut_input_qty']; ?><!--</td>-->
<!--                            <td class="center">-->
<!--                                --><?php
//                                    echo $v['count_other_input_qty_line'];
//                                ?>
<!--                            </td>-->
                            <td class="center"><?php echo $v['min_line_input_date_time']; ?></td>
                            <td class="center"><?php echo $v['min_line_output_date']; ?></td>
                            <td class="center"><?php echo $v['count_input_qty_line']; ?></td>
<!--                            <td class="center">--><?php //echo $v['min_line_input_date_time']; ?><!--</td>-->
                            <td class="center"><?php echo $v['collar_bndl_qty']; ?></td>
                            <td class="center"><?php echo $v['cuff_bndl_qty']; ?></td>
                            <td class="center"><?php echo $v['count_mid_line_qc_pass']; ?></td>
                            <td class="center"><?php echo $v['count_end_line_qc_pass']; ?></td>
                            <td class="center">
                                <span class="center btn btn-danger" data-target="#myModal2" data-toggle="modal" onclick="getPoItemWiseLineRemainCL('<?php echo $v['so_no']; ?>', '<?php echo $vl; ?>');">
                                    <?php echo $balance; ?>
                                </span>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td align="right" colspan="16">Total</td>
                        <td class="center"><?php echo $total_balance;?></td>
                    </tr>
                </tfoot>
            </table>

            <?php
                $total_wip_qty += $total_balance;
            }
            ?>

            <table class="table" border="1" style="font-size: 20px; font-weight: 700;">
                <tbody>
                    <tr>
                        <td align="right" colspan="16">Total WIP</td>
                        <td class="center"><?php echo $total_wip_qty;?></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </section>
</div>