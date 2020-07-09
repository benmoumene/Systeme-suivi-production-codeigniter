<table class="display table table-bordered table-striped" id="">
    <thead>
    <tr>
<!--        <th class="hidden-phone center">SO</th>-->
        <th class="hidden-phone center">Purchase Order</th>
        <th class="hidden-phone center">Item</th>
        <th class="hidden-phone center">Style</th>
        <th class="hidden-phone center">Quality</th>
        <th class="hidden-phone center">Color</th>
        <th class="hidden-phone center">Ex-Fac Date</th>
        <th class="hidden-phone center">Order</th>
        <th class="hidden-phone center">Cut</th>
        <th class="hidden-phone center">Sewed</th>
        <th class="hidden-phone center">Packed</th>
        <th class="hidden-phone center">Carton</th>
        <th class="hidden-phone center">Warehouse</th>
        <th class="hidden-phone center">Balance</th>
        <th class="hidden-phone center">Closing Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $balance_qty = 0;
    foreach ($po_close_report as $v){

    $balance_qty = $v['total_cut_qty'] - ($v['total_carton_qty'] + $v['count_wh_qty']);

    if($v['order_quantity'] <= $v['total_carton_qty']) {
    ?>
    <tr>
<!--        <td class="center">--><?php //echo $v['so_no'];?><!--</td>-->
        <td class="center"><?php echo $v['purchase_order'];?></td>
        <td class="center"><?php echo $v['item'];?></td>
        <td class="center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
        <td class="center"><?php echo $v['quality'];?></td>
        <td class="center"><?php echo $v['color'];?></td>
        <td class="center"><?php echo $v['ex_factory_date'];?></td>
        <td class="center"><?php echo $v['order_quantity'];?></td>
        <td class="center"><?php echo $v['total_cut_qty'];?></td>
        <td class="center"><?php echo $v['total_end_pass_qty'];?></td>
        <td class="center"><?php echo $v['total_packing_qty'];?></td>
        <td class="center"><?php echo $v['total_carton_qty'];?></td>
        <td class="center"><?php echo $v['count_wh_qty'];?></td>
        <td class="center"><?php echo $balance_qty;?></td>
        <td class="center"><?php echo $v['po_closing_date']; ?></td>
    </tr>
    <?php
        }
    }
    ?>
    </tbody>
</table>