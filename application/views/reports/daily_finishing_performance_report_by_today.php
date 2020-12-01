<table class="display table table-bordered table-striped" id="">
    <thead>
    <tr style="background-color: #5d6155; color: #FFFFFF;">
        <th colspan="6" class="center"><h2>Finishing Report</h2></th>
    </tr>
    <tr style="background-color: #f7ffb0;">
        <th class="center">FLOOR</th>
        <th class="center">TARGET</th>
        <th class="center">OUTPUT</th>
        <th class="center">EOT QTY</th>
        <th class="center">ADDITIONAL QTY</th>
        <th class="center">TOTAL</th>
    </tr>
    </thead>
    <tbody>
        <?php

        foreach ($finishing_prod as $f){

        $finishing_floor_id = $f['finishing_floor_id'];

        $floor_name = str_replace(' ', '_', $f['floor_name']);

        ?>
    <tr>
        <td class="center"><?php echo $f['floor_name'];?></td>
        <td class="center"><?php echo $f['target'];?></td>
        <td class="center"><?php echo $f['sum_normal_qty'];?></td>
        <td class="center"><?php echo $f['finishing_extra_hours_output'];?></td>
        <td class="center"><?php echo $f['sum_manual_qty'];?></td>
        <td class="center">
            <a target="_blank" class="btn btn-warning" href="<?php echo base_url();?>dashboard/getDailyPackingReportDetail/<?php echo $search_date;?>/<?php echo $floor_name;?>/<?php echo $finishing_floor_id;?>">
                <?php echo $f['total_finishing_output'];?>
            </a>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>