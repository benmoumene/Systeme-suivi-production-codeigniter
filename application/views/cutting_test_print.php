<!--<div class="pull-left breadcrumb_admin clear_both">-->
<!--    <div class="pull-left page_title theme_color">-->
<!--        <h1>PO List For Cutting</h1>-->
<!--        <h2 class="">PO List For Cutting...</h2>-->
<!--    </div>-->
<!--    <div class="pull-right">-->
<!--        <ol class="breadcrumb">-->
<!--            <li><a href="--><?php //echo base_url();?><!--">Home</a></li>-->
<!--            <li class="active">PO List For Cutting</li>-->
<!--        </ol>-->
<!--    </div>-->
<!--</div>-->
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="col-md-12">
            <div class="block-web">
                <div class="header">
                    <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                </div>
                <!--              <div class="col-md-3">-->
                <!--                  <select class="form-control" required id="po_no">-->
                <!--                      <option>Search PO...</option>-->
                <!--                      <option>200075783</option>-->
                <!--                  </select>-->
                <!--              </div>-->
                <!--              <div class="col-md-3">-->
                <!--                  <select class="form-control" required id="cut_no">-->
                <!--                      <option>Search Cut No...</option>-->
                <!--                      <option>1</option>-->
                <!--                      <option>2</option>-->
                <!--                  </select>-->
                <!--              </div>-->
                <!--              <br />-->
                <!--              <br />-->
                <!--              <br />-->
                <div class="porlets-content">

                    <div class="table-responsive">
                        <table class="display table table-bordered table-striped" id="dynamic-table">
                            <thead>
                            <tr>
                                <!--                      <th class="hidden-phone">SL</th>-->
                                <th class="hidden-phone">Group SO</th>
                                <th class="hidden-phone">SO</th>
                                <th class="hidden-phone">Purchase Order</th>
                                <th class="hidden-phone">Brand</th>
                                <th class="hidden-phone">Item</th>
                                <th class="hidden-phone">Quality</th>
                                <th class="hidden-phone">Style No.</th>
                                <th class="hidden-phone">Style Name</th>
                                <th class="hidden-phone">Ex-Fac-Dt</th>
                                <th class="hidden-phone">Color</th>
                                <!--                      <th class="hidden-phone">Cut No</th>-->
                                <th class="hidden-phone">Cut Track. No.</th>
                                <th class="hidden-phone">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sl = 1;

                            foreach ($order_info as $v) { ?>
                                <tr>
                                    <!--                            <td>--><?php //echo $sl; $sl++;?><!--</td>-->
                                    <td><?php echo $v['po_no'];?></td>
                                    <td><?php echo $v['so_no'];?></td>
                                    <td><?php echo $v['purchase_order'];?></td>
                                    <td><?php echo $v['brand'];?></td>
                                    <td><?php echo $v['item'];?></td>
                                    <td><?php echo $v['quality'];?></td>
                                    <td><?php echo $v['style_no'];?></td>
                                    <td><?php echo $v['style_name'];?></td>
                                    <td><?php echo $v['ex_factory_date'];?></td>
                                    <td><?php echo $v['color'];?></td>
                                    <!--                            <td>--><?php //echo $v['cut_no'];?><!--</td>-->
                                    <td><?php echo $v['cut_tracking_no'];?></td>
                                    <td>
                                        <!--                                <a target="_blank" class="btn btn-primary" href="--><?php //echo base_url();?><!--bcps/generated_care_label_printing_pre.php?cut_tracking_no=--><?php //echo $v['cut_tracking_no'];?><!--">Print CL</a>-->
                                        <?php if($v['remaining_qty'] > 0){ ?>
                                            <a target="_blank" class="btn btn-primary" href="<?php echo base_url();?>access/printCareLabels/<?php echo $v['po_no'];?>/<?php echo $v['so_no'];?>/<?php echo $v['cut_tracking_no'];?>">CL</a>
                                        <?php } ?>
                                        <!--                                <a target="_blank" class="btn btn-warning" href="--><?php //echo base_url();?><!--barcode/tests/print_bundle_tags_new.php?cut_tracking_no=--><?php //echo $v['cut_tracking_no'];?><!--">Body Tag</a>-->
                                        <!--                                <a target="_blank" class="btn btn-warning" href="--><?php //echo base_url();?><!--bcps/generated_bundle_tag_bdy.php?cut_tracking_no=--><?php //echo $v['cut_tracking_no'];?><!--">Body Tag</a>-->
                                        <!--                                <a target="_blank" class="btn btn-warning" href="--><?php //echo base_url();?><!--access/printBundleTicket/--><?php //echo $v['po_no'];?><!--/--><?php //echo $v['so_no'];?><!--/--><?php //echo $v['cut_tracking_no'];?><!--">Front_R</a>-->
                                        <!--                                <a target="_blank" class="btn btn-success" href="--><?php //echo base_url();?><!--bcps/generated_bundle_tag_cc.php?cut_tracking_no=--><?php //echo $v['cut_tracking_no'];?><!--&cc=1">Collar Tag</a>-->
                                        <!--                                <a target="_blank" class="btn btn-success" href="--><?php //echo base_url();?><!--access/printBundleTicketCC/--><?php //echo $v['po_no'];?><!--/--><?php //echo $v['so_no'];?><!--/--><?php //echo $v['cut_tracking_no'];?><!--/1">Collar</a>-->
                                        <!--                                <a target="_blank" class="btn btn-info" href="--><?php //echo base_url();?><!--bcps/generated_bundle_tag_cc.php?cut_tracking_no=--><?php //echo $v['cut_tracking_no'];?><!--&cc=2">Cuff Tag</a>-->
                                        <!--                                <a target="_blank" class="btn btn-info" href="--><?php //echo base_url();?><!--access/printBundleTicketCC/--><?php //echo $v['po_no'];?><!--/--><?php //echo $v['so_no'];?><!--/--><?php //echo $v['cut_tracking_no'];?><!--/2">Cuff</a>-->
                                        <!--                                <a target="_blank" class="btn btn-success" href="--><?php //echo base_url();?><!--barcode/tests/print_bundle_tags_new_cc.php?cut_tracking_no=--><?php //echo $v['cut_tracking_no'];?><!--&cc=1">Collar Tag</a>-->
                                        <!--                                <a target="_blank" class="btn btn-info" href="--><?php //echo base_url();?><!--barcode/tests/print_bundle_tags_new_cc.php?cut_tracking_no=--><?php //echo $v['cut_tracking_no'];?><!--&cc=2">Cuff Tag</a>-->

                                        <!--                                <a target="_blank" class="btn btn-success" href="--><?php //echo base_url();?><!--barcode/tests/print_bundlecut_summary.php?cut_tracking_no=--><?php //echo $v['cut_tracking_no'];?><!--">Summary</a>-->

                                        <a target="_blank" class="btn btn-default" href="<?php echo base_url();?>access/printBundleTicketOthers/<?php echo $v['po_no'];?>/<?php echo $v['so_no'];?>/<?php echo $v['cut_tracking_no'];?>">Bundle Cards</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div><!--/table-responsive-->
                </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div>

<script type="text/javascript">
    $('select').select2();
</script>