<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 35px;
        height: 35px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>AQL Report</h1>
        <h2 class="">AQL Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">AQL Report</li>
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
                    <h3 class="content-header"></h3>
                </div>

                <div class="porlets-content">
                    <div id="print_div">
                    <div class="row">
                        <sec class="table-responsive">
                            <section class="panel default blue_title h2">

                                <div class="panel-body" id="table_content" style="overflow-x:auto;">

                                    <table class="display table table-bordered table-striped" id="" border="1">
                                        <thead>
                                            <tr>
                                                <th class="hidden-phone center" rowspan="2" style="font-size: 20px;"><b>Brand</b></th>
                                                <th class="hidden-phone center" colspan="4" style="font-size: 20px; background-color: #93e7ff;"><b>Today Plan AQL</b></th>
                                                <th class="hidden-phone center" colspan="2" style="font-size: 20px; background-color: #fffdcd;"><b>Previous Date Due AQL</b></th>
                                            </tr>
                                            <tr>
                                                <th class="hidden-phone center"><h4><b>Planned</b></h4></th>
                                                <th class="hidden-phone center"><h4><b>Pass</b></h4></th>
                                                <th class="hidden-phone center"><h4><b>Fail</b></h4></th>
                                                <th class="hidden-phone center"><h4><b>Balance</b></h4></th>
                                                <th class="hidden-phone center"><h4><b>Today Pass</b></h4></th>
                                                <th class="hidden-phone center"><h4><b>Balance</b></h4></th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size: 16px;">
                                            <?php foreach($aql_summary AS $v){
                                                if($v['today_plan_aql_count'] != '' || $v['today_plan_aql_pass_count'] != '' || $v['today_plan_aql_fail_count'] != '' || $v['previous_due_aql_count'] != '' || $v['previous_due_aql_pass_count'] != ''){
                                                $today_plan_aql_count = ($v['today_plan_aql_count'] != '' ? $v['today_plan_aql_count'] : 0);
                                                $today_plan_aql_pass_count = ($v['today_plan_aql_pass_count'] != '' ? $v['today_plan_aql_pass_count'] : 0);
                                                $today_plan_aql_fail_count = ($v['today_plan_aql_fail_count'] != '' ? $v['today_plan_aql_fail_count'] : 0);
                                                $previous_due_aql_count = ($v['previous_due_aql_count'] != '' ? $v['previous_due_aql_count'] : 0);
                                                $previous_due_aql_pass_count = ($v['previous_due_aql_pass_count'] != '' ? $v['previous_due_aql_pass_count'] : 0);

                                                ?>
                                                <tr>
                                                    <td class="hidden-phone center"><?php echo $v['brand'];?></td>
                                                    <td class="hidden-phone center"><?php echo $today_plan_aql_count;?></td>
                                                    <td class="hidden-phone center"><?php echo $today_plan_aql_pass_count;?></td>
                                                    <td class="hidden-phone center"><?php echo $today_plan_aql_fail_count;?></td>
                                                    <td class="hidden-phone center"><a href="<?php echo base_url()?>dashboard/getDetailsAqlreportToday/<?php echo $v['brand']?>" target="_blank"><?php echo $today_plan_aql_count-$today_plan_aql_pass_count;?></a></td>
<!--                                                    <td class="hidden-phone center">--><?php //echo $today_plan_aql_count-$today_plan_aql_pass_count;?><!--</td>-->
                                                    <td class="hidden-phone center"><?php echo $previous_due_aql_pass_count;?></td>
<!--                                                    <td class="hidden-phone center">--><?php //echo $previous_due_aql_count;?><!--</td>-->
<!--                                                    <td class="hidden-phone center">--><?php //echo $previous_due_aql_count;?><!--</td>-->
                                                    <td class="hidden-phone center"><a href="<?php echo base_url()?>dashboard/getDetailsAqlreport/<?php echo $v['brand']?>" target="_blank"><?php echo $previous_due_aql_count;?></a></td>
                                                </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                        </sec>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1"></h4>
            </div>

            <div class="modal-body">
                <div class="col-md-3 scroll4">
                    <div class="porlets-content">
                        <div class="table-responsive" id="wh_cl_list">

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $('select').select2();

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#table_content').html())
            location.href=url
            return false
        })
    })

    window.addEventListener('keydown', function(event) {
        if (event.keyCode === 80 && (event.ctrlKey || event.metaKey) && !event.altKey && (!event.shiftKey || window.chrome || window.opera)) {
            event.preventDefault();
            if (event.stopImmediatePropagation) {
                event.stopImmediatePropagation();
            } else {
                event.stopPropagation();
            }
            return;
        }
    }, true);



    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        location.reload();
    }
</script>