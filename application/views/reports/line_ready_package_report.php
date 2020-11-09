<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Ready Package</h1>
        <h2 class="">Ready Package...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Ready Package</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions">

                    <div class="row">
                        <div class="col-md-1">
                            <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
                        </div>
                    </div>

<!--                <h3 class="content-header">Daily Performance Report</h3>-->
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 center" id="tableWrap">

                <div class="col-md-2"></div>
                <div class="col-md-10">
                <div class="porlets-content center" id="report_content" style="width: 75%">

                    <table class="display table" border="1">
                        <thead>
                            <tr style="background-color: #5d6155; color: #FFFFFF;">
                                <th colspan="5" class="center"><h2>READY PACKAGE</h2></th>
                            </tr>
                            <tr style="background-color: #b9ffb2;">
                                <th class="center" style="font-size: 20px; font-weight: 900;"></th>
                                <th colspan="1" class="center" style="font-size: 20px; font-weight: 900;"><h3>CUTTING</h3></th>
                                <th colspan="3" class="center" style="font-size: 20px; font-weight: 900;"><h3>LINE</h3></th>
                            </tr>
                            <tr style="background-color: #f7ffb0;">
                                <th class="center" style="font-size: 20px; font-weight: 900;">Plan Line</th>
                                <th class="center" style="font-size: 20px; font-weight: 900;">Stock Qty</th>
                                <th class="center" style="font-size: 20px; font-weight: 900;">Super Market</th>
                                <th class="center" style="font-size: 20px; font-weight: 900;">Line WIP</th>
                                <th class="center" style="font-size: 20px; font-weight: 900;">TOTAL WIP</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        $total_cut_ready_qty = 0;
                        $total_cut_to_sew_ready_qty = 0;
                        $total_line_wip_qty = 0;

                        $total_wip = 0;
                        $total_line_cut_sew_and_line_wip_qty = 0;

                        foreach ($ready_package as $p){

                            $line_id = $p['id'];
                            $line_code = $p['line_code'];
                            $cut_ready_qty = ($p['ready_qty'] != '' ? $p['ready_qty'] : 0);
                            $cut_sew_ready_qty = ($p['cut_sew_ready_qty'] != '' ? $p['cut_sew_ready_qty'] : 0);
                            $line_wip_qty = ($p['wip'] != '' ? $p['wip'] : 0);

                            $total_cut_ready_qty += $cut_ready_qty;
                            $total_cut_to_sew_ready_qty += $cut_sew_ready_qty;
                            $total_line_wip_qty += $line_wip_qty;

                            $total_line_cut_sew_and_line_wip_qty = $cut_sew_ready_qty+$line_wip_qty;
                            $total_wip += $total_line_cut_sew_and_line_wip_qty;

                            ?>
                            <tr>
                                <td class="center" style="font-size: 20px;"><?php echo $line_code;?></td>
                                <td class="center" style="font-size: 20px;">
                                    <?php if($line_id != ''){ ?>
                                    <a target="_blank" href="<?php echo base_url();?>dashboard/getPoCuttingReadyPackageDetail/<?php echo $line_id;?>/<?php echo $line_code;?>/">
                                        <?php echo $cut_ready_qty;?>
                                    </a>
                                    <?php }else{ ?>
                                        <?php echo $cut_ready_qty;?>
                                    <?php } ?>
                                </td>
                                <td class="center" style="font-size: 20px;">
                                    <?php if($line_id != ''){ ?>
                                        <a target="_blank" href="<?php echo base_url();?>dashboard/getPoCutToSewReadyPackageDetail/<?php echo $line_id;?>/<?php echo $line_code;?>/">
                                            <?php echo $cut_sew_ready_qty;?>
                                        </a>
                                    <?php }else{ ?>
                                        <?php echo $cut_sew_ready_qty;?>
                                    <?php } ?>
<!--                                    --><?php //echo $cut_sew_ready_qty;?>
                                </td>
                                <td class="center" style="font-size: 20px;"><?php echo $line_wip_qty;?></td>
                                <td class="center" style="font-size: 20px;"><?php echo $total_line_cut_sew_and_line_wip_qty;?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="center" style="font-size: 20px; font-weight: 900;">TOTAL</td>
                                <td class="center" style="font-size: 20px; font-weight: 900;"><?php echo $total_cut_ready_qty;?></td>
                                <td class="center" style="font-size: 20px; font-weight: 900;"><?php echo $total_cut_to_sew_ready_qty;?></td>
                                <td class="center" style="font-size: 20px; font-weight: 900;"><?php echo $total_line_wip_qty;?></td>
                                <td class="center" style="font-size: 20px; font-weight: 900;"><?php echo $total_wip;?></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
                </div>

            </div><!--/block-web-->
        </div><!--/col-md-12-->

    </div><!--/col-md-12-->
</div>
<!--/row-->

<script type="text/javascript">

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

</script>