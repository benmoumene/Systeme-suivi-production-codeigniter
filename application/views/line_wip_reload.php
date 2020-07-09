<div class="row  center"><b><span style="font-size: 20px;">WIP</span></b></div>
<div class="panel-body">

    <?php
    $line_no;
    $count_wip_qty_line = $line_status[0]['count_wip_qty_line'];
    $this->method_call->updateTodayWip($count_wip_qty_line,$line_no);

    ?>

    <div class="row center" style="font-size: 25px;"><b><?php echo (($count_wip_qty_line != '' && $count_wip_qty_line > 0) ? $count_wip_qty_line : 0);?></b></div>

</div>