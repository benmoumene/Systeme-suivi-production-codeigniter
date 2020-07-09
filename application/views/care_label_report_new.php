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
        <h1>Care Label Report</h1>
        <h2 class="">Care Label Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Care Label Report</li>
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
                    <h3 class="content-header">Care Label Report</h3>
                </div>
                <div class="porlets-content">
                    <div class="row">
                        <div class="form-group">
<!--                            <div class="col-md-3">-->
<!--                                <select class="form-control" required id="cl_no" onchange="getClDetail();">-->
<!--                                    <option value="">Search Care Label...</option>-->
<!--                                    --><?php //foreach ($cut_tracking_list as $k => $v){?>
<!--                                        <option value="--><?php //echo $v['cut_tracking_no'];?><!--">--><?php //echo $v['cut_tracking_no'];?><!--</option>-->
<!--                                    --><?php //} ?>
<!--                                </select>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
                <br />
                <div class="porlets-content">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="display table table-bordered table-striped" id="dynamic-table">
                                        <thead>
                                        <tr>
                                            <th class="hidden-phone" colspan="9"><h4><b>Care Labels Sent - Cutting To Production</b></h4></th>
                                        </tr>
                                        <tr>
                                            <th class="center hidden-phone">PO No.</th>
                                            <th class="center hidden-phone">Style</th>
                                            <th class="center hidden-phone">Color</th>
                                            <th class="center hidden-phone">Cut Tracking No.</th>
                                            <th class="center hidden-phone">Total QTY</th>
                                            <th class="center hidden-phone">Sent To Prod.</th>
                                            <th class="center hidden-phone">Pending CL.</th>
<!--                                            <th class="center hidden-phone">Date</th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $sl = 1;
                                        foreach ($cl_sent_to_production as $k => $v){ ?>
                                            <tr>
                                                <td><?php echo $v['po_no'];?></td>
                                                <td><?php echo $v['style_no'];?></td>
                                                <td><?php echo $v['color'];?></td>
                                                <td><?php echo $v['cut_tracking_no'];?></td>
                                                <td><?php echo $v['cut_tracking_no_qty'];?></td>
                                                <td><?php echo $v['count_sent_to_prod'];?></td>
                                                <td><a href="<?php echo base_url();?>access/getCutPendingClReport/<?php echo $v['cut_tracking_no'];?>" target="_blank"><?php echo $v['cut_tracking_no_qty'] - $v['count_sent_to_prod'];?></a></td>
<!--                                                <td>--><?php //echo $v['production_sending_date'];?><!--</td>-->

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
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="sample_2">
                                        <thead>
                                        <tr>
                                            <th class="hidden-phone" colspan="4"><h4><b>Care Labels Passed</b></h4></th>
                                        </tr>
                                        <tr>
                                            <th class="center hidden-phone">SL No.</th>
                                            <th class="center hidden-phone">QTY</th>
                                            <th class="center hidden-phone">Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="gradeX">
                                            <td class="center hidden-phone"></td>
                                            <td class="center hidden-phone"></td>
                                            <td class="center hidden-phone"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div><!--/table-responsive-->
                            </div>
                        </div>
                    </div>
                    <br />
                    <br />
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="sample_3">
                                        <thead>
                                        <tr>
                                            <th class="hidden-phone" colspan="4"><h4><b>Care Labels Rejected</b></h4></th>
                                        </tr>
                                        <tr>
                                            <th class="center hidden-phone">SL No.</th>
                                            <th class="center hidden-phone">QTY</th>
                                            <th class="center hidden-phone">Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="gradeX">
                                                <td class="center hidden-phone"></td>
                                                <td class="center hidden-phone"></td>
                                                <td class="center hidden-phone"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!--/table-responsive-->
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div>

<script type="text/javascript">
    $('select').select2();

    $(document).ready(function() {
        setInterval(function() {
            cache_clear()
        }, 50000);
    });

    function cache_clear() {
        window.location.reload(true);
        // window.location.reload(); use this if you do not remove cache
    }

//    function getSummaryReportbyDate() {
//        var date_picker = $("#date_picker").val();
//
//        if(date_picker != ''){
//            $("#sample_1 tbody tr").remove();
//
//            $.ajax({
//                url: "<?php //echo base_url();?>//access/getSummaryReportbyDateNew/",
//                type: "POST",
//                data: {date_picker: date_picker},
//                dataType: "html",
//                success: function (data) {
//                    $('#sample_1 tbody').append(data);
//                }
//            });
//        }
//    }
</script>