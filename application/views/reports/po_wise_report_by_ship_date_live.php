<div class="col-md-12 tableFixHead" id="">
    <table class="table table-bordered table-striped" id="" border="1">
        <thead>
        <tr>
            <th class="hidden-phone center" colspan="28"><h3>Ship Date: <?php echo $ex_factory_date;?></h3></th>
        </tr>
        <tr>
            <th class="hidden-phone center">SO</th>
            <th class="hidden-phone center">Brand</th>
            <th class="hidden-phone center">Line</th>
            <th class="hidden-phone center">Style</th>
            <th class="hidden-phone center">Color</th>
            <th class="hidden-phone center">PO</th>
            <th class="hidden-phone center">Item</th>
            <th class="hidden-phone center">Quality</th>
            <th class="hidden-phone center">Ex-Fac-Dt</th>

            <th class="hidden-phone center">Order</th>
<!--            <th class="hidden-phone center">Cut</th>-->
            <th class="hidden-phone center">Cut Pass</th>
            <th class="hidden-phone center">INPUT</th>
            <th class="hidden-phone center">MID</th>
            <th class="hidden-phone center">END</th>

            <th class="hidden-phone center" title="Sew Balance">Sew BLNC</th>
            <th class="hidden-phone center" title="Wash Send">Wash Send</th>
            <th class="hidden-phone center" title="Wash Receive">Wash Rcv</th>
            <th class="hidden-phone center" title="Wash Balance">Wash BLNC</th>
            <th class="hidden-phone center">Alter</th>
            <th class="hidden-phone center">Packed</th>
            <th class="hidden-phone center">Pack BLNC</th>
            <th class="hidden-phone center">Carton</th>
            <th class="hidden-phone center" title="Balance">Carton BLNC</th>
            <th class="hidden-phone center" title="Warehouse">WH</th>
            <th class="hidden-phone center" title="Balance">BLNC</th>
            <!--        <th class="hidden-phone center">Other</th>-->

            <!--        <th class="hidden-phone center">Ex-Fac Date</th>-->
<!--            <th class="hidden-phone center">Closing Date</th>-->
            <th class="hidden-phone center" title="Remarks">Remarks</th>
            <th class="hidden-phone center" title="AQL Plan Date">AQL Plan</th>
            <th class="hidden-phone center" title="Remarks">AQL</th>
        </tr>
        </thead>
        <tbody>
        <?php

        $sew_balance_qty = 0;
        $carton_balance_qty = 0;
        $packing_balance_qty = 0;
        $balance_qty = 0;

        $total_order_qty = 0;
        $total_cut_qty = 0;
        $total_cut_pass_qty = 0;
        $total_line_output_qty = 0;
        $total_line_input_qty = 0;
        $total_line_mid_qty = 0;
        $total_line_output_balance_qty = 0;
        $total_wash_send_qty = 0;
        $total_washed_qty = 0;
        $total_washing_balance_qty = 0;
        $total_finishing_alter_qty = 0;
        $total_packing_qty = 0;
        $total_packing_balance_qty = 0;
        $total_carton_qty = 0;
        $total_wh_qty = 0;
        $total_other_qty = 0;
        $total_carton_balance_qty = 0;
        $total_balance_qty = 0;

        foreach ($po_close_report as $v){
            $sew_balance_qty = $v['count_end_line_qc_pass'] - $v['total_order_qty'];
            $carton_balance_qty = $v['count_carton_pass'] - $v['total_order_qty'];
            $washing_balance_qty = $v['count_wash_send'] - $v['count_washing_pass'];
            $packing_balance_qty = $v['count_packing_pass'] - $v['total_order_qty'];
            $balance_qty = ($v['count_carton_pass'] + $v['total_wh_qa']) - $v['total_cut_qty'];

            $total_order_qty += $v['total_order_qty'];
//            $total_cut_qty += $v['total_cut_qty'];
            $total_cut_pass_qty += $v['total_cut_input_qty'];
            $total_line_input_qty += $v['count_input_line_qc_pass'];
            $total_line_mid_qty += $v['count_mid_line_qc_pass'];
            $total_line_output_qty += $v['count_end_line_qc_pass'];
            $total_line_output_balance_qty += $sew_balance_qty;
            $total_wash_send_qty += $v['count_wash_send'];
            $total_washed_qty += $v['count_washing_pass'];
            $total_washing_balance_qty += $washing_balance_qty;
            $total_finishing_alter_qty += $v['count_finishing_alter_qty'];
            $total_packing_qty += $v['count_packing_pass'];
            $total_packing_balance_qty += $packing_balance_qty;
            $total_carton_qty += $v['count_carton_pass'];
            $total_wh_qty += ($v['total_wh_qa'] != NULL ? $v['total_wh_qa'] : 0);
            $total_carton_balance_qty += $carton_balance_qty;
            $total_balance_qty += $balance_qty;

            ?>
            <tr>
                <td class="center"><?php echo $v['so_no'];?></td>
                <td class="center"><?php echo $v['brand'];?></td>
                <td class="center"><?php echo $v['responsible_line'];?></td>
                <td class="center"><?php echo $v['style_name'];?></td>
                <td class="center"><?php echo $v['color'];?></td>
                <td class="center"><?php echo $v['purchase_order'];?></td>
                <td class="center"><?php echo $v['item'];?></td>


                <td class="center"><?php echo $v['quality'];?></td>
                <td class="center"><?php echo $v['ex_factory_date'];?></td>

                <td class="center"><?php echo $v['total_order_qty'];?></td>
<!--                <td class="center">--><?php //echo $v['total_cut_qty'];?><!--</td>-->
                <td class="center"><?php echo $v['total_cut_input_qty'];?></td>
                <td class="center"><?php echo $v['count_input_line_qc_pass'];?></td>
                <td class="center"><?php echo $v['count_mid_line_qc_pass'];?></td>
                <td class="center">
                    <a href="<?php echo base_url();?>dashboard/getDailyLineOutputReport/<?php echo $v['so_no'];?>" target="_blank">
                        <?php echo $v['count_end_line_qc_pass'];?>
                    </a>
                </td>
                <td class="center" <?php if($sew_balance_qty < 0){ ?>style="background-color: #ffbcbf" <?php } ?>>
                    <?php echo $sew_balance_qty;?>
                </td>
                <td class="center"><?php echo $v['count_wash_send'];?></td>
                <td class="center"><?php echo $v['count_washing_pass'];?></td>
                <td class="center" <?php if($washing_balance_qty < 0){ ?>style="background-color: #ffbcbf" <?php } ?>>
                    <?php echo $washing_balance_qty;?>
                </td>
                <td class="center"><?php echo $v['count_finishing_alter_qty'];?></td>
                <td class="center"><?php echo $v['count_packing_pass'];?></td>
                <td class="center" <?php if($packing_balance_qty < 0){ ?>style="background-color: #ffbcbf" <?php } ?>>
                    <?php echo $packing_balance_qty;?>
                </td>
                <td class="center"><?php echo $v['count_carton_pass'];?></td>
                <td class="center" <?php if($carton_balance_qty < 0){ ?>style="background-color: #ffbcbf" <?php } ?>>
                    <?php echo $carton_balance_qty;?>
                </td>
                <td class="center" onclick="getWarehousePcs('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');" data-target="#myModal3" data-toggle="modal" ><span class="btn btn-primary"><?php echo $v['total_wh_qa'];?></span></td>
                <!--        <td class="center">--><?php //echo $v['ex_factory_date']; ?><!--</td>-->
<!--                <td class="center">-->
<!--                    --><?php
//                    if($v['total_order_qty'] <= $v['count_carton_pass']) {
//                        echo $v['po_closing_date'];
//                    }else{
//                        echo '';
//                    }
//                    ?>
<!--                </td>-->
                <td class="center" <?php if($balance_qty < 0){ ?>style="background-color: #ffbcbf" <?php } ?>>
                    <?php echo (($balance_qty != '') ? $balance_qty : 0 );?>
                </td>
                <td class="center">
                    <?php
                    if($v['status'] == 'CLOSE') {
                        echo $v['status'];
                    }else{
                        echo '';
                    }
                    ?>
                </td>
                <td class="center" title="<?php echo $v['aql_action_date'];?>"><?php echo $v['aql_plan_date'];?></td>
                <td class="center"
                    style="background-color:
                        <?php
                            if($v['aql_status'] == 0){
                                echo 'yellow';
                            }
                            elseif($v['aql_status'] == 1){
                                echo 'green';
                            }
                            elseif($v['aql_status'] == 2){
                                echo 'red';
                            }
                        ?>"

                    title="<?php echo "Fail Count: ".($v['so_fail_count'] != '' ? $v['so_fail_count'] : 0);?>">
                    <?php
                    if($v['aql_status'] == 0) {
                        echo "Pending";
                    }elseif($v['aql_status'] == 1){
                        echo 'Pass';
                    }elseif($v['aql_status'] == 2){
                        echo 'Fail';
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" align="right"><h4><b>Total</b></h4></td>
                <td class="center"><h4><b><?php echo $total_order_qty;?></b></h4></td>
    <!--            <td class="center"><h4><b>--><?php //echo $total_cut_qty;?><!--</b></h4></td>-->
                <td class="center"><h4><b><?php echo $total_cut_pass_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_line_input_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_line_mid_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_line_output_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_line_output_balance_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_wash_send_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_washed_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_washing_balance_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_finishing_alter_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_packing_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_packing_balance_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_carton_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_carton_balance_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_wh_qty;?></b></h4></td>
                <td class="center"><h4><b><?php echo $total_balance_qty;?></b></h4></td>
                <td class="center" colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</div>