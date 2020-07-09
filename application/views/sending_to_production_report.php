<!--\\\\\\\ contentpanel start\\\\\\-->
    <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
            <h1>Cutting Report</h1>
            <h2 class="">Cutting Report...</h2>
        </div>
        <div class="pull-right">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">DASHBOARD</a></li>
                <li class="active">Cutting Report</li>
            </ol>
        </div>
    </div>
    <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
<!--        <div class="row">-->
<!--            <div class="form-group">-->
<!--                <!--                            <div class="col-md-12">-->
<!--                <div class="col-md-3">-->
<!--                    <div class="form-group">-->
<!--                        <select required class="form-control" id="po_no" name="po_no" onchange="getReportByPo(id);">-->
<!--                                <option value="">Select PO No...</option>-->
<!--                            --><?php
//                                foreach ($purchase_order_nos as $pos){ ?>
<!--                                    <option value="--><?php //echo $pos['purchase_order'];?><!--">--><?php //echo $pos['purchase_order'];?><!--</option>-->
<!--                            --><?php
//                                }
//                            ?>
<!--                        </select>-->
<!--                        <span style="font-size: 11px;">* Select PO No.</span>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!---->
<!--                <!--                            </div>-->
<!--            </div>-->
<!--        </div><!--/form-group-->
<!--        <br />-->

        <div class="row" id="report_content">
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
                                ----
                                <span style="color: #970f12;"><?php echo $v['style_no'];?></span>
                                ----
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
                            <span style="float: right;">CL Printing Date: <?php echo $v['print_date']?></span>
                        </div>
                    </div>
            <?php
                }
            ?>
        </div>
    </div>
    <!--\\\\\\\ container  end \\\\\\-->



<script type="text/javascript">
    $('select').select2();

    setTimeout(function(){
        window.location.reload(1);
    }, 5000);

    function getReportByPo(id) {
        var purchase_order = $("#"+id).val();


        $("#report_content").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getSummaryReportbyPo/",
            type: "POST",
            data: {purchase_order: purchase_order},
            dataType: "html",
            success: function (data) {
                $("#report_content").append(data);
            }
        });

    }
</script>