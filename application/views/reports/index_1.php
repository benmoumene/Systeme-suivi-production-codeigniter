<div class="contentpanel">
<div class="container clear_both padding_fix">

    <?php

    foreach ($summary_report as $v){ ?>
    <div class="col-md-3 col-sm-6">
        <div class="widgets_user">
            <div class="system_bg">
                <div class="centered-container">

                    <a class="btn btn-primary" href="<?php echo base_url();?>dashboard/getBuyerShipDateWiseDetailReport_1/<?php echo $v['ex_factory_date'];?>/<?php echo $brands;?>" target="_blank"><h4><?php echo $v['ex_factory_date'];?></h4></a>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="col-md-4">
                        <div class="widget-stats_last"> <span class="item-number active_orangewidget"><?php echo $v['total_order_qty'];?></span> <span class="item-title active_orangewidget">ORDER</span> </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-stats"> <span class="item-number active_greenwidget"><?php echo $v['count_carton_qty'];?></span> <span class="item-title active_greenwidget">CARTON</span> </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget-stats"> <span class="item-number active_widget"><?php echo $v['total_order_qty'] - $v['count_carton_qty'];?></span> <span class="item-title active_widget">BALANCE</span> </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php } ?>

</div>
</div>