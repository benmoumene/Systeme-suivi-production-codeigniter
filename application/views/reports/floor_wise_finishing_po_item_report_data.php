<div class="col-md-12" id="tableWrap">
    <section class="panel default blue_title h2">

        <div class="panel-body">

            <table class="table" border="1">
                <thead>
                    <tr>
                        <th class="center">SO</th>
                        <th class="center">PO-Item</th>
                        <th class="center">QLTY-CLR</th>
                        <th class="center">STL</th>
                        <th class="center">BRAND</th>
                        <th class="center">PO TYPE</th>
                        <th class="center">ExFac</th>
                        <th class="center">Order</th>
                        <th class="center">Line Pass</th>
                        <th class="center">Poly</th>
                        <th class="center">Carton</th>
                        <th class="center" title="Warehouse/Others">WH/Others</th>
                        <th class="center">Balance</th>
                    </tr>
                </thead>
                <tbody>
                <?php

                $balance = 0;

                foreach ($prod_summary as $v){

                    $balance = $v['count_end_line_qc_pass'] - ($v['count_carton_pass'] + $v['total_wh_qa']);

                ?>
                        <tr>
                            <td class="center"><?php echo $v['so_no']; ?></td>
                            <td class="center">
                                <?php echo $v['purchase_order'] . '-' . $v['item']; ?>
                            </td>
                            <td class="center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                            <td class="center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                            <td class="center"><?php echo $v['brand']; ?></td>
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
                            <td class="center"><?php echo $v['count_end_line_qc_pass']; ?></td>
                            <td class="center"><?php echo $v['count_packing_pass']; ?></td>
<!--                            <td class="center">--><?php //echo $v['min_line_input_date_time']; ?><!--</td>-->
                            <td class="center"><?php echo $v['count_carton_pass']; ?></td>
                            <td class="center"><?php echo $v['total_wh_qa']; ?></td>
                            <td class="">
                                <span class="center btn btn-danger" data-target="#myModal2" data-toggle="modal" onclick="getPoItemWiseRemainCL('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');">
                                <?php echo $balance; ?>
                                </span>
                            </td>
                        </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>

        </div>
    </section>
</div>