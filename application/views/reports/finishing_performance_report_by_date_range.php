<table class="display table table-bordered table-striped" id="">
    <thead>
    <tr style="background-color: #5d6155; color: #FFFFFF;">
        <th colspan="46" class="center"><h2>Finishing Report</h2></th>
    </tr>
    <tr style="background-color: #f7ffb0;">
        <th class="center">DATE</th>
        <th class="center">FLOOR</th>
        <th class="center">TARGET</th>
        <th class="center">OUTPUT</th>
        <th class="center">EOT QTY</th>
        <th class="center">TOTAL</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($finishing_prod as $f){ ?>
        <tr>
            <td class="center"><?php echo $f['date'];?></td>
            <td class="center"><?php echo $f['floor_name'];?></td>
            <td class="center"><?php echo $f['target'];?></td>
            <td class="center"><?php echo $f['normal_output'];?></td>
            <td class="center"><?php echo $f['eot_output'];?></td>
            <td class="center"><?php echo $f['output'];?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>