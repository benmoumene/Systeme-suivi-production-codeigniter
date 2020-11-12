<table class="display table table-bordered table-striped" id="">
    <thead>
        <tr style="background-color: #615000; color: #FFFFFF;">
            <th colspan="4" class="center"><h2>Cutting Report</h2></th>
        </tr>
        <tr style="background-color: #f7ffb0; font-size: 20px;">
            <th class="center">DATE</th>
            <th class="center">TARGET</th>
            <th class="center">CUT</th>
            <th class="center">PACKAGE READY</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cutting_report AS $c){ ?>
            <tr style="font-size: 16px;">
                <td class="center"><?php echo $c['date'];?></td>
                <td class="center"><?php echo $c['cut_target'];?></td>
                <td class="center"><?php echo $c['cut_output'];?></td>
                <td class="center"><?php echo $c['cut_package_ready'];?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>