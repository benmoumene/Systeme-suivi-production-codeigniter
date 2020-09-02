<div class="col-md-12" id="tableWrap">
    <section class="panel default blue_title h2">

            <span class="btn btn-success" onclick="allowPOsToOutput()">Allow</span>
            <span class="btn btn-danger" onclick="denyPOsToOutput()">Deny</span>

            <br>
            <br>

            <table class="table" border="1">
                <thead>
                    <tr>
                        <th class="center"><input type="checkbox" class="select_all" id="checkAll" name="select_all"></th>
                        <th class="center">Output Status</th>
                        <th class="center">SO</th>
                        <th class="center">PO</th>
                        <th class="center">Item</th>
                        <th class="center">BRAND</th>
                        <th class="center">QLTY</th>
                        <th class="center">CLR</th>
                        <th class="center">STL</th>
                        <th class="center">SMV</th>
                        <th class="center">PO TYPE</th>
                        <th class="center">ExFac</th>
                        <th class="center">Order</th>
                        <th class="center">Input Date</th>
                        <th class="center">Input Qty</th>
                    </tr>
                </thead>
                <tbody>
                <?php

                foreach ($line_running_pos as $v){

                ?>

                        <tr>
                            <td class="center">
                                <input class="checkItem" type="checkbox" name="checkItem[]" id="checkItem" value="<?php echo $v['so_no']; ?>">
                            </td>
                            <td class="center">
                                <?php if($v['is_allowed_to_output'] == 1){ ?>
                                    <span class="btn btn-success"><i class="fa fa-check"></i></span>
                                <?php }else{ ?>
                                    <span class="btn btn-danger"><i class="fa fa-times"></i></span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td class="center"><?php echo $v['so_no']; ?></td>
                            <td class="center"><?php echo $v['purchase_order']; ?></td>
                            <td class="center"><?php echo $v['item']; ?></td>
                            <td class="center"><?php echo $v['brand']; ?></td>
                            <td class="center"><?php echo $v['quality']; ?></td>
                            <td class="center"><?php echo $v['color']; ?></td>
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
                            <td class="center"><?php echo $v['order_quantity']; ?></td>
                            <td class="center"><?php echo $v['min_line_input_date_time']; ?></td>
                            <td class="center"><?php echo $v['count_input_qty_line']; ?></td>
                        </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>

        </div>
    </section>
</div>