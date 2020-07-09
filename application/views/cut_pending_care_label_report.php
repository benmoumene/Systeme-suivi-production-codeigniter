<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Compose New Task</h4>
            </div>
            <div class="modal-body"> content </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Cutting Care Label Pending Report</h1>
        <h2 class="">Cutting Care Label Pending Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Cutting Care Label Pending Report</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="col-md-12">
            <div class="block-web">
                <div class="header">
                    <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                    <h3 class="content-header">Cutting Care Label Pending Report</h3>
                </div>
<!--                <div class="porlets-content">-->
<!--                    <div class="row">-->
<!--                        <div class="form-group">-->
<!--                            <div class="col-md-3">-->
<!--<!--                                Select Date:-->
<!--<!--                                <input class="form-control form-control-inline input-medium default-date-picker" onblur="getSummaryReportbyDate();" name="date_picker" id="date_picker" />-->
<!--<!--                                <input class="form-control" type="date" onblur="getSummaryReportbyDate();" name="date_picker" id="date_picker" />-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <br />-->
                <div class="porlets-content">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="display table table-bordered table-striped" id="dynamic-table">
                                        <thead>
                                        <tr>
                                            <th class="hidden-phone" colspan="9"><h4><b>Care Labels Pending - Cutting To Production</b></h4></th>
                                        </tr>
                                        <tr>
                                            <th>Cut Tracking No.</th>
                                            <th>Care Label No.</th>
                                            <th>PO No.</th>
                                            <th>Style</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Bundle No.</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($sent_to_prod_rep as $k => $v){
                                            ?>
                                            <tr>
                                                <td><?php echo $v['cut_tracking_no'];?></td>
                                                <td><?php echo $v['pc_tracking_no'];?></td>
                                                <td><?php echo $v['purchase_order'];?></td>
                                                <td><?php echo $v['style_no'].'-'.$v['brand'];?></td>
                                                <td><?php echo $v['color'];?></td>
                                                <td><?php echo $v['size'].'-'.$v['layer_group'];?></td>
                                                <td><?php echo $v['bundle_tracking_no'];?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div><!--/table-responsive-->
                             </div>
                          </div>
                      </div>
                    <br />
                    <br />
                </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div>

<script type="text/javascript">
    setTimeout(function(){
        window.location.reload(1);
    }, 30000);
</script>
