<table class="table table-bordered table-striped" id="" border="1">
    <thead>
    <tr>
        <th class="hidden-phone center" colspan="19"><h3>Package Report On <?php echo $date;?></h3></th>
        <th class="hidden-phone center" rowspan="2" style="vertical-align:bottom">Total Package</th>
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
        <th class="hidden-phone center">Order</th>
        <th class="hidden-phone center">Cut</th>
        <th class="hidden-phone center">Collar</th>
        <th class="hidden-phone center">Cuff</th>
        <th class="hidden-phone center">Back</th>
        <th class="hidden-phone center">Yoke</th>
        <th class="hidden-phone center">Sleeve</th>
        <th class="hidden-phone center">Slv-Plkt</th>
        <th class="hidden-phone center">Pocket</th>
        <th class="hidden-phone center">Package</th>
    </tr>
    </thead>
    <tbody>
    <?php

    $total_pkg_rdy_qty = 0;

    foreach ($fusing_report as $v){

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
            <td class="center"><?php echo $v['total_cut_qty'];?></td>

            <td class="center">
                <?php echo $v['count_cutting_collar_bundle_qty'];?>
            </td>
            <td class="center">
                <?php echo $v['count_cutting_cuff_bundle_qty'];?>
            </td>
            <td class="center">
                <?php echo $v['count_cutting_back_bundle_qty'];?>
            </td>
            <td class="center">
                <?php echo $v['count_cutting_yoke_bundle_qty'];?>
            </td>
            <td class="center">
                <?php echo $v['count_cutting_sleeve_bundle_qty'];?>
            </td>
            <td class="center">
                <?php echo $v['count_cutting_sleeve_plkt_bundle_qty'];?>
            </td>
            <td class="center">
                <?php echo $v['count_cutting_pocket_bundle_qty'];?>
            </td>
            <td class="center">
                <?php echo $v['count_package_ready_qty'];?>
            </td>
            <td class="center"
                <?php if($v['total_cut_qty'] > $v['count_cut_package_ready_qty']){ ?>
                style="background-color: red; color: white;"
                <?php } ?>
            >
                <?php echo $v['count_cut_package_ready_qty'];?>
            </td>

        </tr>
        <?php
                $total_pkg_rdy_qty += $v['count_package_ready_qty'];
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="18" align="right"><h4><b>Total</b></h4></td>
            <td class="center"><h4><b><?php echo $total_pkg_rdy_qty;?></b></h4></td>
            <td></td>
        </tr>
    </tfoot>
</table>