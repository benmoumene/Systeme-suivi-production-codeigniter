<?php

$sl=1;

foreach ($machine_list as $v){ ?>

    <tr>
        <td class="center">
            <?php echo $sl; $sl++;?>
            <input type="hidden" required="required" readonly="readonly" id="machine_id_<?php echo $k;?>" value="<?php echo $v['id'];?>">
        </td>
        <td class="center"><?php echo $v['machine_no'];?></td>
        <td class="center"><?php echo $v['machine_name'];?></td>
        <td class="center"><?php echo $v['machine_model'];?></td>
        <td class="center"><?php echo $v['brand'];?></td>
        <td class="center"><?php echo $v['line_code'];?></td>
        <td class="center"><?php echo $v['location_name'];?></td>
        <td class="center"><?php echo ($v['status'] == 1 ? 'ACTIVE' : ($v['status'] == 0 ? 'INACTIVE' : '') );?></td>
        <td class="center">
            <?php
            if($v['service_status'] == 0){
                echo 'Out of Service';
            }
            if($v['service_status'] == 1){
                echo 'Running';
            }
            if($v['service_status'] == 2){
                echo 'Under Maintenance';
            }
            if($v['service_status'] == 3){
                echo 'Idle';
            }
            ?>
        </td>
        <td class="center">
            <a href="<?php echo base_url();?>access/editMachineNo/<?php echo $v['id'];?>" class="btn btn-warning" title="EDIT" onclick="getSetDataToModal(<?php echo $k;?>);"><i class="fa fa-edit"></i></a>
        </td>
    </tr>

    <?php
}
?>