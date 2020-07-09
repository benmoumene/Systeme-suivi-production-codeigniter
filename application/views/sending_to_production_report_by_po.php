<?php
    foreach ($sent_to_prod_rep as $key => $v) {
?>
                    <div class="col-md-4 col-sm-6">

                        <div class="widgets_user">
                            <!--                    <div class="stat-label">403</div>-->
                            <div class="system_body_title">
                                <span style="color: #2324ff"><?php echo $v['brand'];?></span>
                                -
                                <span style="color: #2324ff"><?php echo $v['purchase_order'].'-'.$v['item'];?></span>
                                --------
                                <span style="color: #970f12;"><?php echo $v['style_name'];?></span>
                                <h5>CUT#
                                    <?php
                                    $res = $v['count_care_label'] - $v['count_sent_prod_care_label'];
                                    if($res == 0){ ?>
                                        <span style="color: green;">
                                    <?php }
                                    if($res != 0){ ?>
                                        <span style="color: red;">
                                    <?php } ?>
                                        <?php echo $v['cut_tracking_no'];?>
                                    </span></h5>
                            </div>
<!--                            <div class="system_bg">-->
<!--                                <div class="centered-container">-->
<!---->
<!--                                    <input type="text" class="dial" value="2000" data-width="130" data-height="150"-->
<!--                                           data-fgcolor="#a4ed16" data-step="1000" data-min="-15000" data-max="15000"-->
<!--                                           data-thickness=".15"/>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="widget-stats_last"><span class="item-number active_greenwidget"><?php echo ($v['count_sent_prod_care_label'] == '' ? 0 : $v['count_sent_prod_care_label']);?></span> <span
                                    class="item-title active_greenwidget">Line Input</span></div>
                            <a href="<?php echo base_url();?>access/getNotScannedCareLabels/<?php echo $v['cut_tracking_no'];?>" target="_blank"><div class="widget-stats "><span class="item-number active_widget"><?php echo $v['count_care_label'] - $v['count_sent_prod_care_label'];?></span> <span
                                            class="item-title active_widget">Cutting Stock</span></div></a>
                            <div class="widget-stats"><span class="item-number active_orangewidget"><?php echo $v['count_care_label'];?></span> <span
                                    class="item-title active_orangewidget">Total Printed</span></div>
                            <br />
                            <br />
                            <span style="float: right;">CL Printing Date: <?php echo $v['print_date'];?></span>
                        </div>
                    </div>
<?php
    }
?>