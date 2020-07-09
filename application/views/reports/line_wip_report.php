<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title ?></title>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
    <script src="<?php echo base_url(); ?>assets/js/jquery-latest.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/css/jquery-1.9.0.js"></script>
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/compiled/timepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/css/colorpicker.css" />
    <link href="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/plugins/advanced-datatable/css/demo_page.css" rel="stylesheet" />

    <!--Select2 Start-->
    <script src="<?php echo base_url(); ?>assets/select2/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/select2/select2.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/select2/select2.min.css" rel="stylesheet"/>

    <style type="text/css">

        .has-error .select2-selection {
            /*border: 1px solid #a94442;
            border-radius: 4px;*/
            border-color:rgb(185, 74, 72) !important;
        }

    </style>
    <!--Select2 End-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body class="light_theme green_thm left_nav_hide">
<div class="wrapper">
    <div class="inner">
        <div class="contentpanel">
            <div class="pull-left breadcrumb_admin clear_both">
                <div class="pull-left page_title theme_color">
                    <h1>Line WIP Report</h1>
                    <h2 class="">Line WIP Report...</h2>
                </div>
                <div class="pull-right">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="active">Line WIP Report</li>
                    </ol>
                </div>
            </div>
            <div class="container clear_both padding_fix">
                <!--\\\\\\\ container  start \\\\\\-->
<!--                <form>-->
<!--                    <div class="row">-->
<!--                        <div class="col-md-12">-->
<!--                            <div class="block-web">-->
<!--                                <input type="date" name="date" id="date" />-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </form>-->
<!--                <br />-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="block-web">
                            <div id="chart_div" style="width: 1400px; height: 500px;"></div>
                        </div>
                    </div>
                </div>
             </div>

        </div>
        <!--\\\\\\\ inner end\\\\\\-->
    </div>

</body>
</html>
<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.0.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common-script.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jPushMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/js/side-chats.js"></script>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/form-components.js"></script>

<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/dynamic_table_init.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/edit-table/edit-table.js"></script>
<script type="text/javascript">
    setTimeout(function(){
        window.location.reload(1);
    }, 5000);

    //bar chart code started
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {

        var data = google.visualization.arrayToDataTable([
            ['Lines', 'WIP', { role: 'annotation'}],

            <?php

            foreach ($line_wip_report as $v)
            {
                $table=$v['cut_table'];
                $count_total_pc=$v['count_total_pc'];

                $line_id = $v['line_id'];
                $line_name = $v['line_name'];
                $floor_name = $v['floor_name'];

                if($v['count_wip_qty'] != ''){
                    $count_wip_qty = $v['count_wip_qty'];
                }else{
                    $count_wip_qty = 0;
                }

                $line_input_date = $v['line_input_date'];

                echo "['$line_name',$count_wip_qty,'$count_wip_qty'],";
            }
            ?>
        ]);

        var options = {
            title: "Line WIP Report of <?php echo $date;?>",
            bars: 'vertical', // Required for Material Bar Charts.
            colors: ['#fcb441'],
            theme: 'material',
            vAxis: {
                title: 'Quantity'
            },
            hAxis: {
                title: 'Lines'
            },
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

        chart.draw(data, google.charts.Bar.convertOptions(options));

        google.visualization.events.addListener(chart, 'select', function() {
            var row = chart.getSelection()[0].row;
            var element = data.getValue(row, 0);

//            window.open("<?php //echo base_url();?>//dashboard/lineWIPDetailReport/"+ element +"/<?php //echo $date ; ?>//","mywindow","menubar=1,resizable=1,width=800,height=400,left=40,top=90,location=yes");
        });
    }
</script>