<?php

$sizes_count = sizeof($sizes);

?>

<table class="display table table-bordered table-striped" id="table_id">
    <thead style="font-size: 15px; font-weight: 900;">
        <tr>
            <th class="hidden-phone center" rowspan="2">#</th>
            <th class="hidden-phone center" rowspan="2">PO</th>
            <th class="hidden-phone center" rowspan="2">ITEM</th>
            <th class="hidden-phone center" rowspan="2">QUALITY</th>
            <th class="hidden-phone center" rowspan="2">COLOR</th>
            <th class="hidden-phone center" rowspan="2">STYLE</th>
            <th class="hidden-phone center" colspan="<?php echo $sizes_count?>">SIZE</th>
            <th class="hidden-phone center" rowspan="2">TOTAL</th>
        </tr>
        <tr>
            <?php foreach ($sizes AS $s){ ?>

            <th class="hidden-phone center"><?php echo $s['size']?></th>

            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $sl=1;
        $total_carton_qty=0;

        foreach ($po_list AS $p){

            $po_total_carton_qty=0;
        ?>
            <tr>
                <td class="hidden-phone center"><?php echo $sl; $sl++;?></td>
                <td class="hidden-phone center"><?php echo $p['purchase_order'];?></td>
                <td class="hidden-phone center"><?php echo $p['item'];?></td>
                <td class="hidden-phone center"><?php echo $p['quality'];?></td>
                <td class="hidden-phone center"><?php echo $p['color'];?></td>
                <td class="hidden-phone center"><?php echo $p['style_no'];?></td>

                <?php foreach ($sizes AS $s){

                    $size_qty = $this->method_call->getPoSizeWiseCartonReport($p['so_no'], $s['size']);

                    $count_size_carton_qty = ($size_qty[0]['count_size_carton_qty'] != '' ? $size_qty[0]['count_size_carton_qty'] : 0);
                ?>

                    <td class="hidden-phone center"><?php echo $count_size_carton_qty;?></td>

                <?php
                    $po_total_carton_qty += $count_size_carton_qty;
                }

                $total_carton_qty += $po_total_carton_qty;
                ?>

                <td class="hidden-phone center"><?php echo $po_total_carton_qty;?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot style="font-size: 15px; font-weight: 900;">
        <tr>
            <th class="hidden-phone" style="text-align:right" colspan="<?php echo $sizes_count+6 ;?>">TOTAL</th>
            <th class="hidden-phone center"><?php echo $total_carton_qty;?></th>
        </tr>
    </tfoot>
</table>