<?php

$sizes_count = sizeof($sizes);

?>

<table class="display table table-bordered table-striped" id="table_id">
    <thead>
        <tr style="font-size: 15px; font-weight: 900;">
            <th class="hidden-phone" colspan="7">Final Consignee / Customer:</th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>">Supplier / factory:</th>
            <th class="hidden-phone" colspan="6">Detail Packing List of ETD : <?php echo date('Y-m-d');?></th>
        </tr>
        <tr>
            <th class="hidden-phone" colspan="7"></th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>"></th>
            <th class="hidden-phone" colspan="6"></th>
        </tr>
        <tr>
            <th class="hidden-phone" colspan="7">Description:</th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>"></th>
            <th class="hidden-phone" colspan="6">Shipping Schedule:</th>
        </tr>
        <tr>
            <th class="hidden-phone" colspan="7">Con.No.:</th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>"></th>
            <th class="hidden-phone" colspan="6">Ex factory:</th>
        </tr>
        <tr>
            <th class="hidden-phone" colspan="7">Container No:</th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>"></th>
            <th class="hidden-phone" colspan="6">ETD at port:</th>
        </tr>
        <tr>
            <th class="hidden-phone" colspan="7">Container Size:</th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>"></th>
            <th class="hidden-phone" colspan="6">Feeder Vessel:</th>
        </tr>
        <tr>
            <th class="hidden-phone" colspan="7">AWB.No:</th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>"></th>
            <th class="hidden-phone" colspan="6">Mother Vessel:</th>
        </tr>
        <tr>
            <th class="hidden-phone" colspan="7"></th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>"></th>
            <th class="hidden-phone" colspan="6">Flight 1st:</th>
        </tr>
        <tr>
            <th class="hidden-phone" colspan="7"></th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>"></th>
            <th class="hidden-phone" colspan="6">Flight 2nd:</th>
        </tr>
        <tr>
            <th class="hidden-phone" colspan="7"></th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>"></th>
            <th class="hidden-phone" colspan="6">Flight 3rd:</th>
        </tr>
        <tr>
            <th class="hidden-phone" colspan="7"></th>
            <th class="hidden-phone" colspan="<?php echo $sizes_count?>"></th>
            <th class="hidden-phone" colspan="6"><b>ETA at port SEA: ECOFAB</b></th>
        </tr>

        <tr style="font-size: 15px; font-weight: 900;">
            <th class="hidden-phone center" rowspan="2">#</th>
            <th class="hidden-phone center" rowspan="2">PO</th>
            <th class="hidden-phone center" rowspan="2"></th>
            <th class="hidden-phone center" rowspan="2"></th>
            <th class="hidden-phone center" rowspan="2">ART</th>
            <th class="hidden-phone center" rowspan="2">AL</th>
            <th class="hidden-phone center" rowspan="2">COL</th>
            <th class="hidden-phone center" colspan="<?php echo $sizes_count?>">SIZE</th>
            <th class="hidden-phone center" rowspan="2">ASSORTED PACKED</th>
            <th class="hidden-phone center" rowspan="2">TOTAL</th>
            <th class="hidden-phone center" rowspan="2">Total Ctns</th>
            <th class="hidden-phone center" rowspan="2">Net Weight</th>
            <th class="hidden-phone center" rowspan="2">Gross Weight</th>
            <th class="hidden-phone center" rowspan="2">CBM</th>
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
                <td class="hidden-phone center"></td>
                <td class="hidden-phone center"></td>
                <td class="hidden-phone center"><?php echo $p['item'];?></td>
                <td class="hidden-phone center"><?php echo $p['quality'];?></td>
                <td class="hidden-phone center"><?php echo $p['color'];?></td>
                <td class="hidden-phone center"><?php echo $p['style_no'];?></td>

                <?php foreach ($sizes AS $s){

                    $size_qty = $this->method_call->getPoSizeWiseCartonReport($p['so_no'], $s['size']);

                    $count_size_carton_qty = ($size_qty[0]['count_size_carton_qty'] != '' ? $size_qty[0]['count_size_carton_qty'] : 0);
                ?>

                <td class="hidden-phone center" style="width: 50px;">
                    <a target="_blank" href="<?php echo base_url();?>access/manualCartonPieceByPiece/<?php echo $p['so_no']?>/<?php echo $p['size']?>">
                        <?php echo $count_size_carton_qty;?>
                    </a>
                </td>

                <?php
                    $po_total_carton_qty += $count_size_carton_qty;
                }

                $total_carton_qty += $po_total_carton_qty;
                ?>

                <td class="hidden-phone center"></td>
                <td class="hidden-phone center"><?php echo $po_total_carton_qty;?></td>
                <td class="hidden-phone center"></td>
                <td class="hidden-phone center"></td>
                <td class="hidden-phone center"></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot style="font-size: 15px; font-weight: 900;">
        <tr>
            <th class="hidden-phone" style="text-align:right" colspan="<?php echo $sizes_count+9 ;?>">TOTAL</th>
            <th class="hidden-phone center"><?php echo $total_carton_qty;?></th>
            <th class="hidden-phone center"></th>
            <th class="hidden-phone center"></th>
            <th class="hidden-phone center"></th>
        </tr>
    </tfoot>
</table>