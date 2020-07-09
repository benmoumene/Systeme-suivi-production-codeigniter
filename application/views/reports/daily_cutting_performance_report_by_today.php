<table class="display table table-bordered table-striped" id="">
    <thead>
        <tr style="background-color: #615000; color: #FFFFFF;">
            <th colspan="5" class="center"><h2>Cutting Report</h2></th>
        </tr>
        <tr style="background-color: #f7ffb0;">
            <th class="center">TARGET</th>
            <th class="center">LAY</th>
            <th class="center">CUT</th>
            <th class="center">PACKAGE READY</th>
        </tr>
    </thead>
    <tbody>
        <tr style="background-color: #f7ffb0;">
            <th class="center"><?php echo $cutting_target[0]['target'];?></th>
            <th class="center"><a target="_blank" class="btn btn-warning" href="<?php echo base_url();?>dashboard/getDailyLayCutPackageReportDetail/<?php echo $search_date;?>"><?php echo $cutting_prod[0]['lay_complete_qty'];?></a></th>
            <th class="center"><a target="_blank" class="btn btn-warning" href="<?php echo base_url();?>dashboard/getDailyLayCutPackageReportDetail/<?php echo $search_date;?>"><?php echo $cutting_prod[0]['cut_complete_qty'];?></a></th>
            <th class="center"><a target="_blank" class="btn btn-warning" href="<?php echo base_url();?>dashboard/getDailyPackageReportDetail/<?php echo $search_date;?>"><?php echo $cutting_prod[0]['package_ready_qty'];?></a></th>
        </tr>
    </tbody>
</table>