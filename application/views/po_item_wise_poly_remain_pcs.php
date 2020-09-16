<table class="table">
    <thead>
        <tr>
            <th class="center">PO-ITEM: <?php echo $remain_pcs[0]['purchase_order'].'-'.$remain_pcs[0]['item'];?></th>
            <th class="center">Style: <?php echo $remain_pcs[0]['style_no'].'-'.$remain_pcs[0]['style_name'];?></th>
            <th class="center">QLT-CLR: <?php echo $remain_pcs[0]['quality'].'-'.$remain_pcs[0]['color'];?></th>
            <th class="center">ExFac: <?php echo $remain_pcs[0]['ex_factory_date'];?></th>
        </tr>
        <tr>
            <th class="center">Size</th>
            <th class="center">Pcs No.</th>
            <th class="center" colspan="2">Last Scan</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($remain_pcs as $v){

            $last_scanning_point = "";

            if($v['carton_status'] == 1){
                $last_scanning_point = "Carton";
            } elseif($v['packing_status'] == 1){
                $last_scanning_point = "Packing";
            } elseif($v['washing_status'] == 1){
                $last_scanning_point = "Wash Return";
            } elseif($v['is_going_wash'] == 1){
                $last_scanning_point = "Wash Send";
            } elseif($v['access_points'] == 4){
                $last_scanning_point = "End Line";
            } elseif($v['access_points'] == 3){
                $last_scanning_point = "Mid Line";
            } elseif($v['access_points'] == 2){
                $last_scanning_point = "Input Line";
            } elseif($v['sent_to_production'] == 1){
                $last_scanning_point = "Cutting";
            }
    ?>
        <tr>
            <td class="center"><?php echo $v['size'];?></td>
            <td class="center"><?php echo $v['pc_tracking_no'];?></td>
            <td class="center" colspan="2"><?php echo $last_scanning_point;?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>