<table class="table table-bordered table-striped" id="" border="1">
    <thead>
    <tr>
        <th class="hidden-phone center" colspan="15"><h3>Fusing Report On <?php echo $date;?></h3></th>
    </tr>
    <tr>
        <th class="hidden-phone center">Group SO</th>
        <th class="hidden-phone center">SO</th>
        <th class="hidden-phone center">Brand</th>
        <th class="hidden-phone center">Purchase Order</th>
        <th class="hidden-phone center">Item</th>
        <th class="hidden-phone center">Style</th>
        <th class="hidden-phone center">Quality</th>
        <th class="hidden-phone center">Color</th>
        <th class="hidden-phone center">Ex-fac</th>
        <th class="hidden-phone center">Order Qty</th>
        <th class="hidden-phone center">Cut Qty</th>
        <th class="hidden-phone center">Collar Qty</th>
        <th class="hidden-phone center">Cuff Qty</th>
        <th class="hidden-phone center">Slv Plkt Qty</th>
        <th class="hidden-phone center">Package Ready</th>
    </tr>
    </thead>
    <tbody>
    <?php

    $sew_balance_qty = 0;
    $balance_qty = 0;
    $packing_balance_qty = 0;

    $total_order_qty = 0;
    $total_cut_qty = 0;
    $total_cut_pass_qty = 0;
    $total_line_output_qty = 0;
    $total_line_output_balance_qty = 0;
    $total_washed_qty = 0;
    $total_packing_qty = 0;
    $total_packing_balance_qty = 0;
    $total_carton_qty = 0;
    $total_wh_qty = 0;
    $total_other_qty = 0;
    $total_balance_qty = 0;

    foreach ($fusing_report as $v){

        $total_order_qty += $v['total_order_qty'];
        $count_cut_quantity += $v['count_cut_quantity'];
        $total_collar_qty += $v['count_cutting_collar_bundle_qty'];
        $total_cuff_qty += $v['count_cutting_cuff_bundle_qty'];
        $total_slv_plkt_qty += $v['count_slv_plkt_qty'];


        ?>
        <tr>
            <td class="center"><?php echo $v['po_no'];?></td>
            <td class="center"><?php echo $v['so_no'];?></td>
            <td class="center"><?php echo $v['brand'];?></td>
            <td class="center"><?php echo $v['purchase_order'];?></td>
            <td class="center"><?php echo $v['item'];?></td>
            <td class="center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
            <td class="center"><?php echo $v['quality'];?></td>
            <td class="center"><?php echo $v['color'];?></td>
            <td class="center"><?php echo $v['ex_factory_date'];?></td>
            <td class="center"><?php echo $v['total_order_qty'];?></td>
            <td class="center"><?php echo $v['count_cut_quantity'];?></td>
            <td class="center"><?php echo $v['count_cutting_collar_bundle_qty'];?></td>
            <td class="center"><?php echo $v['count_cutting_cuff_bundle_qty'];?></td>
            <td class="center"><?php echo $v['count_slv_plkt_qty'];?></td>
            <td class="center">
                <?php

                if(strstr( $v['part_codes'], 'cuff_outer' )){
                    echo $pkg_rdy_qty=(min($v['count_cutting_collar_bundle_qty'], $v['count_cutting_cuff_bundle_qty'], $v['count_slv_plkt_qty']));
                }else{
                    echo $pkg_rdy_qty=$v['count_cutting_collar_bundle_qty'];
                }

                ?>
            </td>
            <?php
            $total_pkg_rdy_qty +=$pkg_rdy_qty;

            ?>


        </tr>
        <?php
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="9" align="right"><h4><b>Total</b></h4></td>
        <td class="center"><h4><b><?php echo $total_order_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $count_cut_quantity;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_collar_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_cuff_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_slv_plkt_qty;?></b></h4></td>
        <td class="center"><h4><b><?php echo $total_pkg_rdy_qty;?></b></h4></td>
        <!--                <td colspan="3" align="right"><h4><b></b></h4></td>-->

    </tr>
    </tfoot>
</table>