<?php
$sl=1;
foreach($user_list AS $u){ ?>
    <tr>
        <td class="center hidden-phone">
            <input class="checkItem" type="checkbox" name="checkItem[]" id="checkItem" value="<?php echo $u['user_name']; ?>" />
        </td>
        <td class="center hidden-phone"><?php echo $u['user_name'];?></td>
        <td class="center hidden-phone"><?php echo $u['user_description'];?></td>
        <td class="center hidden-phone">
            <?php
                if($u['access_points'] == 1000){
                    echo 'ADMINISTRATOR';
                }
                if($u['access_points'] == 0){
                    echo 'CUTTING';
                }
                if($u['access_points'] == 1){
                    echo 'CUTTING SCAN';
                }
                if($u['access_points'] == 2){
                    echo 'LINE INPUT';
                }
                if($u['access_points'] == 3){
                    echo 'MID LINE QC';
                }
                if($u['access_points'] == 4){
                    echo 'END LINE QC';
                }
                if($u['access_points'] == 5){
                    echo 'FINISHING';
                }
                if($u['access_points'] == 6){
                    echo 'WASHING';
                }
                if($u['access_points'] == 7){
                    echo 'PACKING';
                }
                if($u['access_points'] == 8){
                    echo 'COLLAR-CUFF';
                }
                if($u['access_points'] == 9){
                    echo 'CARTON';
                }
                if($u['access_points'] == 200){
                    echo 'OPR';
                }
                if($u['access_points'] == 300){
                    echo 'QA';
                }
                if($u['access_points'] == 400){
                    echo 'SD';
                }
                if($u['access_points'] == 500){
                    echo 'PRODUCTION ADMIN';
                }
                if($u['access_points'] == 600){
                    echo 'MAINTENANCE ADMIN';
                }
            ?>
        </td>
        <td class="center hidden-phone"><?php echo $u['floor_code'];?></td>
        <td class="center hidden-phone"><?php echo $u['finishing_floor_code'];?></td>
        <td class="center hidden-phone"><?php echo $u['line_code'];?></td>
        <td class="center hidden-phone"><?php echo ($u['status'] == 1 ? 'ACTIVE' : 'INACTIVE');?></td>
        <td class="center hidden-phone"><?php echo $u['buyer_condition'];?></td>
        <td class="center hidden-phone">
            <a href="<?php echo base_url()?>access/editUserInfo/<?php echo $u['id'];?>" class="btn btn-warning" title="EDIT"><i class="fa fa-pencil"></i></a>
        </td>
    </tr>
<?php } ?>