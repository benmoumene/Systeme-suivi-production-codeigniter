<table class="display table table-bordered table-striped" id="" border="1">
    <thead>
        <tr>
            <th class="hidden-phone center">Piece No</th>
            <th class="hidden-phone center">Size</th>
            <th class="hidden-phone center">SO</th>
            <th class="hidden-phone center">Type</th>
            <th class="hidden-phone center">Brand</th>
            <th class="hidden-phone center">Purchase Order</th>
            <th class="hidden-phone center">Item</th>
            <th class="hidden-phone center">Style</th>
            <th class="hidden-phone center">Style Name</th>
            <th class="hidden-phone center">Quality</th>
            <th class="hidden-phone center">Color</th>
            <th class="hidden-phone center">ExFac</th>
            <th class="hidden-phone center">Package Ready?</th>
            <th class="hidden-phone center">Sent to Sew</th>
            <th class="hidden-phone center">Line</th>
            <th class="hidden-phone center">Line Input</th>
            <th class="hidden-phone center">Mid Pass</th>
            <th class="hidden-phone center">Line Output</th>
            <th class="hidden-phone center">Wash Sent</th>
            <th class="hidden-phone center">Wash Received</th>
            <th class="hidden-phone center">Poly</th>
            <th class="hidden-phone center">Carton</th>
            <th class="hidden-phone center">Close By Admin</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($pieces as $p){ ?>
        <tr>
            <td class="center"><?php echo $p['pc_tracking_no'];?></td>
            <td class="center"><?php echo $p['size'];?></td>
            <td class="center"><?php echo $p['so_no'];?></td>
            <td class="center">
                <?php
                    if($p['po_type'] == 0){
                        echo 'BULK';
                    }
                    if($p['po_type'] == 1){
                        echo 'SIZE SET';
                    }
                    if($p['po_type'] == 2){
                        echo 'SAMPLE';
                    }
                ?>
            </td>
            <td class="center"><?php echo $p['brand'];?></td>
            <td class="center"><?php echo $p['purchase_order'];?></td>
            <td class="center"><?php echo $p['item'];?></td>
            <td class="center"><?php echo $p['style_no'];?></td>
            <td class="center"><?php echo $p['style_name'];?></td>
            <td class="center"><?php echo $p['quality'];?></td>
            <td class="center"><?php echo $p['color'];?></td>
            <td class="center"><?php echo $p['ex_factory_date'];?></td>
            <td class="center"><?php echo ($p['is_package_ready'] == 1 ? 'YES' : 'NO');?></td>
            <td class="center"><?php echo $p['package_sent_to_production_date_time'];?></td>
            <td class="center"><?php echo $p['line_code'];?></td>
            <td class="center"><?php echo $p['line_input_date_time'];?></td>
            <td class="center"><?php echo $p['mid_line_qc_date_time'];?></td>
            <td class="center"><?php echo $p['end_line_qc_date_time'];?></td>
            <td class="center"><?php echo $p['going_wash_scan_date_time'];?></td>
            <td class="center"><?php echo $p['washing_date_time'];?></td>
            <td class="center"><?php echo $p['packing_date_time'];?></td>
            <td class="center"><?php echo $p['carton_date_time'];?></td>
            <td class="center">
                <?php
                    if($p['manually_closed'] == 1){
                        echo 'Yes';
                    }
                ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>