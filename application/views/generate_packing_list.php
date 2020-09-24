<?php

$sizes_count = sizeof($sizes);

?>

<table class="display table table-bordered table-striped" id="table_id">
    <thead>
        <tr style="font-size: 15px; font-weight: 900;">
            <th style="text-align:left" colspan="7">Final Consignee / Customer:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>">Supplier / factory:</th>
            <th style="text-align:left" colspan="6">Detail Packing List of ETD : <?php echo date('Y-m-d');?></th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="7">
                OLYMP Bezner GmbH & Co. KG, 74321 Bietigheim-Bissingen, Germany
            </th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>">
                EcoFab Ltd, Gazipur, Bangladesh
            </th>
            <th style="text-align:left" colspan="6"></th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="7">Description:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Shipping Schedule:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="7">Con.No.:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Ex factory:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="7">Container No:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">ETD at port:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="7">Container Size:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Feeder Vessel:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="7">AWB.No:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Mother Vessel:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="7"></th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Flight 1st:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="7"></th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Flight 2nd:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="7"></th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Flight 3rd:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="7"></th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6"><b>ETA at port SEA: ECOFAB</b></th>
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
                <td class="hidden-phone center">
                    <span class="sl_no"><?php echo $sl; $sl++;?></span>
                    <span class="btn btn-danger" class="minus_sign" onclick="removeThisRow(this)"><i class="fa fa-minus"></i></span>
                </td>
                <td class="hidden-phone center"><?php echo $p['purchase_order'];?></td>
                <td class="hidden-phone center"></td>
                <td class="hidden-phone center"></td>
                <td class="hidden-phone center"><?php echo $p['item'];?></td>
                <td class="hidden-phone center"><?php echo $p['quality'];?></td>
                <td class="hidden-phone center"><?php echo $p['color'];?></td>

                <?php foreach ($sizes AS $s){

                    $size_qty = $this->method_call->getPoSizeWiseCartonReport($p['so_no'], $s['size']);

                    $count_size_carton_qty = ($size_qty[0]['count_size_carton_qty'] != '' ? $size_qty[0]['count_size_carton_qty'] : 0);
                    $size_order_qty = ($size_qty[0]['size_order_qty'] != '' ? $size_qty[0]['size_order_qty'] : 0);
                ?>

                <td class="hidden-phone center size_carton_quantity"
                    <?php if($count_size_carton_qty < $size_order_qty){ ?> style="background-color: red; color: white;" <?php } ?>
                    <?php if($count_size_carton_qty == $size_order_qty){ ?> style="background-color: green; color: white;" <?php } ?>
                    <?php if($count_size_carton_qty > $size_order_qty){ ?> style="background-color: yellow; color: white;" <?php } ?>
                >
                    <a class="qty" target="_blank" href="<?php echo base_url();?>access/manualCartonPieceByPiece/<?php echo $p['so_no']?>/<?php echo $s['size']?>">
                        <?php echo $count_size_carton_qty;?>
                    </a>
                </td>

                <?php
                    $po_total_carton_qty += $count_size_carton_qty;
                }

                $total_carton_qty += $po_total_carton_qty;
                ?>

                <td class="hidden-phone center"></td>
                <td class="hidden-phone center">
                    <span class="carton_qty"><?php echo $po_total_carton_qty;?></span>
                </td>
                <td class="hidden-phone center"></td>
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
            <th class="hidden-phone" style="text-align:right" colspan="<?php echo $sizes_count+8 ;?>">TOTAL</th>
            <th class="hidden-phone center">
                <span id="total_carton_qty"><?php echo $total_carton_qty;?></span>
            </th>
            <th class="hidden-phone center"></th>
            <th class="hidden-phone center"></th>
            <th class="hidden-phone center"></th>
            <th class="hidden-phone center"></th>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
    function removeThisRow(row) {
//        Remove This Row Start
            var i = row.parentNode.parentNode.rowIndex;
            document.getElementById('table_id').deleteRow(i);
//        Remove This Row End

//        Serial No start
            var sl_no = 1;
            $(".sl_no").each(function(){
                $(this).text(sl_no);

                sl_no++;
            });
//        Serial No end

//        Total carton quantity start
            var total_carton_qty = 0;
            $(".carton_qty").each(function(){
                total_carton_qty += +$(this).text();
            });
            $("#total_carton_qty").text(total_carton_qty);

            $("a.className1, a.className2").contents().unwrap();
//        Total carton quantity end
    }
</script>