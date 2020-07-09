<table class="display table table-bordered table-striped" id="" border="1">
    <thead>
        <tr>
            <th class="hidden-phone center">INR No.</th>
            <th class="hidden-phone center">Brand</th>
            <th class="hidden-phone center">Purchase Order</th>
            <th class="hidden-phone center">Item</th>
            <th class="hidden-phone center">Style</th>
            <th class="hidden-phone center">Quality</th>
            <th class="hidden-phone center">Color</th>
            <th class="hidden-phone center">Size</th>
            <th class="hidden-phone center">Ex-factory</th>
            <th class="hidden-phone center">Season</th>
            <th class="hidden-phone center">Warehouse</th>
            <th class="hidden-phone center">Remarks</th>
            <th class="hidden-phone center">Other Reference</th>
        </tr>
    </thead>

    <tbody>
    <?php

    foreach ($wh_pcs as $v){

        $wh_type='';

        if($v['warehouse_qa_type'] == 1){
            $wh_type = 'BUYER';
        }
        if($v['warehouse_qa_type'] == 2){
            $wh_type = 'FACTORY';
        }
        if($v['warehouse_qa_type'] == 3){
            $wh_type = 'TRASH';
        }
        if($v['warehouse_qa_type'] == 4){
            $wh_type = 'SAMPLE';
        }
        if($v['warehouse_qa_type'] == 5){
            $wh_type = 'OTHER';
        }if($v['warehouse_qa_type'] == 6){
            $wh_type = 'LOST';
        }if($v['warehouse_qa_type'] == 7){
            $wh_type = 'Size Set';
        }

    ?>
    <tr>
        <td class="center"><?php echo $v['pc_tracking_no'];?></td>
        <td class="center"><?php echo $v['brand'];?></td>
        <td class="center"><?php echo $v['purchase_order'];?></td>
        <td class="center"><?php echo $v['item'];?></td>
        <td class="center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
        <td class="center"><?php echo $v['quality'];?></td>
        <td class="center"><?php echo $v['color'];?></td>
        <td class="center"><?php echo $v['size'];?></td>
        <td class="center"><?php echo $v['ex_factory_date'];?></td>
        <td class="center"><?php echo $v['season'];?></td>
        <td class="center"><?php echo $wh_type;?></td>
        <td class="center"><?php echo ($v['other_purpose_remarks'] != '' ? $v['other_purpose_remarks'] : '');?></td>
        <td class="center"><?php echo ($v['other_purpose_liable_person'] != '' ? $v['other_purpose_liable_person'] : '');?></td>
    </tr>

    <?php
    }
    ?>

    </tbody>

</table>