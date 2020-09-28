<?php

$sizes_count = sizeof($sizes);

?>

<table class="display table table-bordered table-striped" id="table_id">
    <thead>
        <tr style="font-size: 15px; font-weight: 900;">
            <th style="text-align:left" colspan="5">Final Consignee / Customer:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>">Supplier / factory:</th>
            <th style="text-align:left" colspan="6">Detail Packing List of ETD : <?php echo $ship_date;?></th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="5">
                OLYMP Bezner GmbH & Co. KG, 74321 Bietigheim-Bissingen, Germany
            </th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>">
                EcoFab Ltd, Gazipur, Bangladesh
            </th>
            <th style="text-align:left" colspan="6"></th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="5">Description:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Shipping Schedule:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="5">Con.No.:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Ex factory:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="5">Container No:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">ETD at port:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="5">Container Size:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Feeder Vessel:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="5">AWB.No:</th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Mother Vessel:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="5"></th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Flight 1st:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="5"></th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Flight 2nd:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="5"></th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6">Flight 3rd:</th>
        </tr>
        <tr>
            <th style="text-align:left" colspan="5"></th>
            <th style="text-align:left" colspan="<?php echo $sizes_count?>"></th>
            <th style="text-align:left" colspan="6"><b>ETA at port SEA: ECOFAB</b></th>
        </tr>

        <tr style="font-size: 15px; font-weight: 900;">
            <th class="hidden-phone center" rowspan="2">#</th>
            <th class="hidden-phone center" rowspan="2">PO</th>
            <th class="hidden-phone center" rowspan="2">ART</th>
            <th class="hidden-phone center" rowspan="2">AL</th>
            <th class="hidden-phone center" rowspan="2">COL</th>
            <th class="hidden-phone center" colspan="<?php echo $sizes_count?>">SIZE</th>
            <th class="hidden-phone center" rowspan="2" style="width: 60px;">ASSORTED PACKED</th>
            <th class="hidden-phone center" rowspan="2">TOTAL</th>
            <th class="hidden-phone center" rowspan="2">Total Ctns</th>
            <th class="hidden-phone center" rowspan="2">Net Weight</th>
            <th class="hidden-phone center" rowspan="2">Gross Weight</th>
            <th class="hidden-phone center" rowspan="2">CBM</th>
        </tr>
        <tr style="font-size: 15px;">
            <?php foreach ($sizes AS $s){ ?>

            <th class="hidden-phone center"><?php echo $s['size']?></th>

            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $sl=1;
        $total_carton_qty=0;

        foreach ($po_list AS $k => $p){

            $po_total_carton_qty=0;
        ?>
            <tr style="font-size: 15px;">
                <td class="hidden-phone center">
                    <span class="sl_no"><?php echo $sl; $sl++;?></span>
                    <span class="btn btn-danger" class="minus_sign" onclick="removeThisRow(this)"><i class="fa fa-minus"></i></span>
                </td>
                <td class="hidden-phone center"><?php echo $p['purchase_order'];?></td>
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
                    <a class="qty" target="_blank" href="<?php echo base_url();?>access/manualCartonPieceByPiece/<?php echo $p['so_no']?>/<?php echo $s['size']?>" style="background-color: #ffffff;">
                        <?php echo $count_size_carton_qty;?>
                    </a>
                </td>

                <td class="hidden
                <?php
                $po_total_carton_qty += $count_size_carton_qty;
                }

                $total_carton_qty += $po_total_carton_qty;
                ?>
-phone center"></td>
                <td class="hidden-phone center">
                    <span class="carton_qty"><?php echo $po_total_carton_qty;?></span>
                </td>
                <td class="hidden-phone center">
                    <input type="number" class="carton" name="carton" id="carton_<?php echo $k?>" onblur="cartonCalculations(<?php echo $k;?>);" style="width: 60px" />
                    <span class="carton_span" id="carton_span_<?php echo $k?>" style="display: none;"></span>
                </td>
                <td class="hidden-phone center">
                    <input type="text" class="net_weight_single_carton" name="net_weight_single_carton" id="net_weight_single_carton_<?php echo $k?>" onblur="netWeightCalculation(<?php echo $k;?>);" style="width: 60px" />
                    <span class="net_weight" id="net_weight_<?php echo $k?>">0</span>
                </td>
                <td class="hidden-phone center">
                    <input type="text" class="gross_weight_single_carton" name="gross_weight_single_carton" id="gross_weight_single_carton_<?php echo $k?>" onblur="grossWeightCalculation(<?php echo $k;?>);" style="width: 60px" />
                    <span class="gross_weight" id="gross_weight_<?php echo $k?>">0</span>
                </td>
                <td class="hidden-phone center">
                    <span class="cbm" id="cbm_<?php echo $k?>">0</span>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot style="font-size: 15px; font-weight: 900;">
        <tr>
            <th class="hidden-phone" style="text-align:right" colspan="<?php echo $sizes_count+6 ;?>">TOTAL</th>
            <th class="hidden-phone center">
                <span id="total_carton_qty"><?php echo $total_carton_qty;?></span>
            </th>
            <th class="hidden-phone center">
                <span id="total_carton">0</span>
            </th>
            <th class="hidden-phone center">
                <span id="total_net_weight">0</span>
            </th>
            <th class="hidden-phone center">
                <span id="total_gross_weight">0</span>
            </th>
            <th class="hidden-phone center">
                <span id="total_cbm">0</span>
            </th>
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

        totalNetWeight();
        totalGrossWeight();
        totalCBM();

    }

    function cartonCalculations(i) {

        var sum = 0;
        $(".carton").each(function(){
            sum += +$(this).val();
        });
        $("#total_carton").text(sum);

        var carton = $("#carton_"+i).val();
        $("#carton_span_"+i).text(carton);

        var cbm = (0.52*0.38*0.29*carton).toFixed(2);
        $("#cbm_"+i).text(cbm);

        totalCBM();
    }

    function netWeightCalculation(i) {
        var carton = $("#carton_"+i).val();
        carton = (carton != '' ? carton : 0);

        var net_weight_single_carton = $("#net_weight_single_carton_"+i).val();
        net_weight_single_carton = (net_weight_single_carton != '' ? net_weight_single_carton : 0);

        var net_weight = (carton * net_weight_single_carton).toFixed(2);
        $("#net_weight_"+i).text(net_weight);

        totalNetWeight();

        totalCBM();
    }

    function grossWeightCalculation(i) {
        var carton = $("#carton_"+i).val();
        carton = (carton != '' ? carton : 0);

        var gross_weight_single_carton = $("#gross_weight_single_carton_"+i).val();
        gross_weight_single_carton = (gross_weight_single_carton != '' ? gross_weight_single_carton : 0);

        var gross_weight = (carton * gross_weight_single_carton).toFixed(2);
        $("#gross_weight_"+i).text(gross_weight);

        totalGrossWeight();

        totalCBM();
    }

    function totalCBM() {
        var sum_cbm = 0;
        $(".cbm").each(function(){
            sum_cbm += +$(this).text();
        });
        $("#total_cbm").text(sum_cbm.toFixed(2));
    }

    function totalNetWeight() {
        var sum_net_weight = 0;
        $(".net_weight").each(function(){
            sum_net_weight += +$(this).text();
        });
        $("#total_net_weight").text(sum_net_weight.toFixed(2));
    }

    function totalGrossWeight() {
        var sum_gross_weight = 0;
        $(".gross_weight").each(function(){
            sum_gross_weight += +$(this).text();
        });
        $("#total_gross_weight").text(sum_gross_weight.toFixed(2));
    }
</script>