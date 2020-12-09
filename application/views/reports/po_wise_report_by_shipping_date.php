<?php
$total_month_order_qty = 0;
$total_month_cut_qty = 0;
$total_month_cut_package_qty = 0;
$total_month_cut_pass_qty = 0;
$total_month_line_input_qty = 0;
$total_month_line_output_qty = 0;
$total_month_line_output_balance_qty = 0;
$total_month_wash_send_qty = 0;
$total_month_washed_qty = 0;
$total_month_wash_balance_qty = 0;
$total_month_packing_qty = 0;
$total_month_packing_balance_qty = 0;
$total_month_carton_qty = 0;
$total_month_carton_balance_qty = 0;
$total_month_wh_qty = 0;
$total_month_other_qty = 0;
$total_month_balance_qty = 0;

$week_date = array();

$week_total_order_qty = array();
$week_total_cut_qty = array();
$week_total_cut_package_qty = array();
$week_total_cut_pass_qty = array();
$week_total_line_input_qty = array();
$week_total_line_output_qty = array();
$week_total_line_output_balance_qty = array();
$week_total_wash_send_qty = array();
$week_total_washed_qty = array();
$week_total_wash_balance_qty = array();
$week_total_packing_qty = array();
$week_total_packing_balance_qty = array();
$week_total_carton_qty = array();
$week_total_carton_balance_qty = array();
$week_total_wh_qty = array();
$week_total_balance_qty = array();

foreach ($dates as $dt){

    array_push($week_date, $dt['approved_ex_factory_date']);

    ?>
<table class="display table table-bordered table-striped" id="" border="1">
    <thead>
    <tr>
        <th class="hidden-phone center" colspan="31"><h3>Ship Date: <?php echo $dt['approved_ex_factory_date'];?></h3></th>
    </tr>
    <tr>
        <th class="hidden-phone center">SO</th>
        <th class="hidden-phone center">Brand</th>
        <th class="hidden-phone center">PO</th>
        <th class="hidden-phone center">Item</th>
        <th class="hidden-phone center">Line</th>
        <th class="hidden-phone center">Style</th>
        <th class="hidden-phone center">Quality</th>
        <th class="hidden-phone center">Color</th>
        <th class="hidden-phone center">ExFac Date</th>
        <th class="hidden-phone center">CRD Date</th>
        <th class="hidden-phone center">Order</th>
        <th class="hidden-phone center">Cut</th>
        <th class="hidden-phone center">Cut Package</th>
        <th class="hidden-phone center">Cut Pass</th>
        <th class="hidden-phone center">Line Input</th>
        <th class="hidden-phone center">Sew</th>
        <th class="hidden-phone center" title="Sew Balance">Sew BLNC</th>
        <th class="hidden-phone center" title="Wash Send">Wash Send</th>
        <th class="hidden-phone center" title="Wash Received">Wash Rcv</th>
        <th class="hidden-phone center" title="Wash Balance">Wash BLNC</th>
        <th class="hidden-phone center">Packed</th>
        <th class="hidden-phone center">Pack BLNC</th>
        <th class="hidden-phone center">Carton</th>
        <th class="hidden-phone center">Carton BLNC</th>
        <th class="hidden-phone center" title="Warehouse">WH</th>
        <!--        <th class="hidden-phone center">Other</th>-->
        <th class="hidden-phone center" title="Balance">BLNC</th>
        <!--        <th class="hidden-phone center">Ex-Fac Date</th>-->
        <th class="hidden-phone center">Closing Date</th>
        <th class="hidden-phone center">Test Report Status</th>
        <th class="hidden-phone center">Plan Final Audit Date</th>
        <th class="hidden-phone center">Cargo Handover Date</th>
        <th class="hidden-phone center">Remarks</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $po_close_report = $this->method_call->getShipReportByDate($dt['approved_ex_factory_date'], $brands_string, $po_type);

    $sew_balance_qty = 0;
    $balance_qty = 0;
    $packing_balance_qty = 0;
    $carton_balance_qty = 0;

    $total_order_qty = 0;
    $total_cut_qty = 0;
    $total_cut_package_qty = 0;
    $total_cut_pass_qty = 0;
    $total_line_input_qty = 0;
    $total_line_output_qty = 0;
    $total_line_output_balance_qty = 0;
    $total_wash_send_qty = 0;
    $total_washed_qty = 0;
    $total_wash_balance_qty = 0;
    $total_packing_qty = 0;
    $total_packing_balance_qty = 0;
    $total_carton_qty = 0;
    $total_carton_balance_qty = 0;
    $total_wh_qty = 0;
    $total_other_qty = 0;
    $total_balance_qty = 0;

    foreach ($po_close_report as $v){
        $sew_balance_qty = $v['count_end_line_qc_pass'] - $v['total_order_qty'];
        $balance_qty = ($v['count_carton_pass'] + $v['total_wh_qa']) - $v['total_cut_qty'];
        $washing_balance_qty = $v['count_washing_pass'] - $v['count_washing_qty'];
        $packing_balance_qty = $v['count_packing_pass'] - $v['total_order_qty'];
        $carton_balance_qty = $v['count_carton_pass'] - $v['total_order_qty'];

        $total_order_qty += $v['total_order_qty'];
        $total_cut_qty += $v['total_cut_qty'];
        $total_cut_package_qty += $v['count_cut_package_ready_qty'];
        $total_cut_pass_qty += $v['total_cut_input_qty'];
        $total_line_input_qty += $v['count_input_qty_line'];
        $total_line_output_qty += $v['count_end_line_qc_pass'];
        $total_line_output_balance_qty += $sew_balance_qty;
        $total_wash_send_qty += $v['count_washing_qty'];
        $total_washed_qty += $v['count_washing_pass'];
        $total_wash_balance_qty += $washing_balance_qty;
        $total_packing_qty += $v['count_packing_pass'];
        $total_packing_balance_qty += $packing_balance_qty;
        $total_carton_qty += $v['count_carton_pass'];
        $total_carton_balance_qty += $carton_balance_qty;
        $total_wh_qty += $v['total_wh_qa'];
//        $total_other_qty += $v['count_other_qty'];
        $total_balance_qty += $balance_qty;

    ?>
        <tr>
            <td class="center">
                <a href="<?php echo base_url();?>dashboard/getPieceByPieceDetailBySo/<?php echo $v['so_no'];?>" target="_blank">
                    <?php echo $v['so_no'];?>
                </a>
            </td>
            <td class="center"><?php echo $v['brand'];?></td>
            <td class="center"><?php echo $v['purchase_order'];?></td>
            <td class="center"><?php echo $v['item'];?></td>
            <td class="center"><?php echo $v['responsible_line'];?></td>
            <td class="center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
            <td class="center"><?php echo $v['quality'];?></td>
            <td class="center"><?php echo $v['color'];?></td>
            <td class="center"><?php echo $v['ex_factory_date'];?></td>
            <td class="center"><?php echo $v['crd_date'];?></td>
            <td class="center"><?php echo $v['total_order_qty'];?></td>
            <td class="center"><?php echo $v['total_cut_qty'];?></td>
            <td class="center"><?php echo $v['count_cut_package_ready_qty'];?></td>
            <td class="center"><?php echo $v['total_cut_input_qty'];?></td>
            <td class="center"><?php echo $v['count_input_qty_line'];?></td>
            <td class="center">
                <a href="<?php echo base_url();?>dashboard/getDailyLineOutputReport/<?php echo $v['so_no'];?>" target="_blank">
                    <?php echo $v['count_end_line_qc_pass'];?>
                </a>
            </td>
            <td class="center" <?php if($sew_balance_qty < 0){ ?>style="background-color: #ffbcbf" <?php } ?>>
                <?php echo $sew_balance_qty;?>
            </td>
            <td class="center"><?php echo $v['count_washing_qty'];?></td>
            <td class="center"><?php echo $v['count_washing_pass'];?></td>
            <td class="center" <?php if($washing_balance_qty < 0){ ?>style="background-color: #ffbcbf" <?php } ?>>
                <?php echo $washing_balance_qty;?>
            </td>
            <td class="center"><?php echo $v['count_packing_pass'];?></td>
            <td class="center" <?php if($packing_balance_qty < 0){ ?>style="background-color: #ffbcbf" <?php } ?>>
                <?php echo $packing_balance_qty;?>
            </td>
            <td class="center"><?php echo $v['count_carton_pass'];?></td>
            <td class="center" <?php if($carton_balance_qty < 0){ ?>style="background-color: #ffbcbf" <?php } ?>>
                <?php echo $carton_balance_qty;?>
            </td>
            <td class="center" onclick="getWarehousePcs('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');" data-target="#myModal3" data-toggle="modal" ><span class="btn btn-primary">
                    <?php echo $v['total_wh_qa'];?></span>
            </td>
            <td class="center" <?php if($balance_qty < 0){ ?>style="background-color: #ffbcbf" <?php } ?>>
                <?php echo (($balance_qty != '') ? $balance_qty : 0 );?>
            </td>
            <!--        <td class="center">--><?php //echo $v['ex_factory_date']; ?><!--</td>-->
            <td class="center">
                <?php
                if($v['total_order_qty'] <= $v['count_carton_pass']) {
                    if($v['max_carton_date_time'] != '' && $v['max_carton_date_time'] != '0000-00-00 00:00:00'){
                        $date=date_create($v['max_carton_date_time']);
                        echo date_format($date,"Y-m-d");
                    }
                }else{
                    echo '';
                }
                ?>
            </td>
            <td class="center"></td>
            <td class="center">
                <?php
                if($v['brand'] == 'TIMBERLAND'){
                    echo date('Y-m-d', strtotime($v['ex_factory_date']. ' - 1 days'));
                }else{

                }
                ?>
            </td>
            <td class="center">
                <?php
                    if($v['brand'] == 'TIMBERLAND'){
                        echo $v['ex_factory_date'];
                    }else{
                        echo '';
                    }
                ?>
            </td>
            <td class="center">
                <?php
//                if($v['status'] == 'CLOSE') {
//                    echo $v['status'];
//                }else{
//                    echo '';
//                }
                echo $v['remarks'];
                ?>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="10" align="right"><h4><b>Total</b></h4></td>
        <td class="center"><h4><b><?php echo $total_order_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_cut_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_cut_package_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_cut_pass_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_line_input_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_line_output_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_line_output_balance_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_wash_send_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_washed_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_wash_balance_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_packing_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_packing_balance_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_carton_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_carton_balance_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo ($total_wh_qty + $total_other_qty);?></b></h4></td>
        <!--        <td class="center"><h4><b>--><?php //echo $total_other_qty;?><!--</b></h4></td>-->
        <td class="center"><h4><b><?php echo $total_balance_qty;?></b></h4></td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
        <td class="center"></td>
    </tr>
    </tfoot>
</table>
<?php

    array_push($week_total_order_qty, $total_order_qty);
    array_push($week_total_cut_qty, $total_cut_qty);
    array_push($week_total_cut_package_qty, $total_cut_package_qty);
    array_push($week_total_cut_pass_qty, $total_cut_pass_qty);
    array_push($week_total_line_input_qty, $total_line_input_qty);
    array_push($week_total_line_output_qty, $total_line_output_qty);
    array_push($week_total_line_output_balance_qty, $total_line_output_balance_qty);
    array_push($week_total_wash_send_qty, $total_wash_send_qty);
    array_push($week_total_washed_qty, $total_washed_qty);
    array_push($week_total_wash_balance_qty, $total_wash_balance_qty);
    array_push($week_total_packing_qty, $total_packing_qty);
    array_push($week_total_packing_balance_qty, $total_packing_balance_qty);
    array_push($week_total_carton_qty, $total_carton_qty);
    array_push($week_total_carton_balance_qty, $total_carton_balance_qty);
    array_push($week_total_wh_qty, ($total_wh_qty + $total_other_qty));
    array_push($week_total_balance_qty, $total_balance_qty);

    $total_month_order_qty += $total_order_qty;
    $total_month_cut_qty += $total_cut_qty;
    $total_month_cut_package_qty += $total_cut_package_qty;
    $total_month_cut_pass_qty += $total_cut_pass_qty;
    $total_month_line_input_qty += $total_line_input_qty;
    $total_month_line_output_qty += $total_line_output_qty;
    $total_month_line_output_balance_qty += $total_line_output_balance_qty;
    $total_month_wash_send_qty += $total_wash_send_qty;
    $total_month_washed_qty += $total_washed_qty;
    $total_month_wash_balance_qty += $total_wash_balance_qty;
    $total_month_packing_qty += $total_packing_qty;
    $total_month_packing_balance_qty += $total_packing_balance_qty;
    $total_month_carton_qty += $total_carton_qty;
    $total_month_carton_balance_qty += $total_carton_balance_qty;
    $total_month_wh_qty += $total_wh_qty;
    $total_month_other_qty += $total_other_qty;
    $total_month_balance_qty += $total_balance_qty;

} ?>
<table class="display table table-bordered table-striped" id="" border="1">
    <thead>
    <tr>
        <th class="hidden-phone center" colspan="31"><h1><b>Month Summary</b></h1></th>
    </tr>
    <tr>
        <th class="hidden-phone center">Dates</th>
        <th class="hidden-phone center">Order</th>
        <th class="hidden-phone center">Cut</th>
        <th class="hidden-phone center">Cut Package</th>
        <th class="hidden-phone center">Cut Pass</th>
        <th class="hidden-phone center">Line Input</th>
        <th class="hidden-phone center">Sew</th>
        <th class="hidden-phone center" title="Sew Balance">Sew BLNC</th>
        <th class="hidden-phone center" title="Wash Send">Wash Send</th>
        <th class="hidden-phone center" title="Wash Receive">Wash Rcv</th>
        <th class="hidden-phone center" title="Wash Balance">Wash BLNC</th>
        <th class="hidden-phone center">Packed</th>
        <th class="hidden-phone center">Pack BLNC</th>
        <th class="hidden-phone center">Carton</th>
        <th class="hidden-phone center">Carton BLNC</th>
        <th class="hidden-phone center" title="Warehouse">WH</th>
        <!--        <th class="hidden-phone center">Other</th>-->
        <th class="hidden-phone center" title="Balance">BLNC</th>
        <!--        <th class="hidden-phone center">Ex-Fac Date</th>-->
        <th class="hidden-phone center" colspan="14"></th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach ($week_date AS $k => $w){
    ?>
    <tr>
        <td class="hidden-phone center"><?php echo $w;?></td>
        <td class="hidden-phone center"><?php echo $week_total_order_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_cut_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_cut_package_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_cut_pass_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_line_input_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_line_output_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_line_output_balance_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_wash_send_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_washed_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_wash_balance_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_packing_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_packing_balance_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_carton_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_carton_balance_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_wh_qty[$k];?></td>
        <td class="hidden-phone center"><?php echo $week_total_balance_qty[$k];?></td>
        <td class="hidden-phone center" colspan="14"></td>
    </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td align="right"><h4><b>Month Total</b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_order_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_cut_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_cut_package_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_cut_pass_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_line_input_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_line_output_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_line_output_balance_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_wash_send_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_washed_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_wash_balance_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_packing_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_packing_balance_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_carton_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_carton_balance_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_month_wh_qty + $total_month_other_qty;?></b></h4></td>
        <!--        <td class="center"><h4><b>--><?php //echo $total_other_qty;?><!--</b></h4></td>-->
        <td class="center"><h4><b><?php echo $total_month_balance_qty;?></b></h4></td>
        <td class="center" colspan="14"></td>
    </tr>
    </tfoot>
</table>

