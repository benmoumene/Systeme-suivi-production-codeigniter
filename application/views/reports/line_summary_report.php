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
                    <h1>Line Summary Report</h1>
                    <h2 class="">Line Summary Report...</h2>
                </div>
                <div class="pull-right">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="active">Line Summary Report</li>
                    </ol>
                </div>
            </div>
    <div class="container clear_both padding_fix">

        <div class="row" id="report_content">
            <?php
//            foreach ($line_input_report as $v){
//                $line_id = $v['line_id'];
//                $line_name = $v['line_name'];
//                $floor_name = $v['floor_name'];
//                $count_qty_line = $v['count_qty_line'];
//                $count_wip_qty = $v['count_wip_qty'];
//                $count_mid_line_qc_pass = $v['count_mid_line_qc_pass'];
//                $count_mid_line_qc_defect = $v['count_mid_line_qc_defect'];
//                $count_mid_line_qc_reject = $v['count_mid_line_qc_reject'];
//                $count_end_line_qc_pass = $v['count_end_line_qc_pass'];
//                $count_end_line_qc_defect = $v['count_end_line_qc_defect'];
//                $count_end_line_qc_reject = $v['count_end_line_qc_reject'];
//                $line_input_date = $v['line_input_date'];

                ?>
            <div class="col-lg-12">
                <section class="panel default blue_title h2">

                    <div class="panel-body">

                        <table class="table" border="1">
                            <thead>
                            <tr>
                                <th align="center" colspan="">Line No:</th>
                                <th class="center" colspan="">13</th>
                                <th class="" colspan="13"></th>
                            </tr>
                            <tr>
                                <th class="center">PO-ITEM</th>
                                <th class="center">Style</th>
                                <th class="center">Quality-Color</th>
                                <th class="center">Order Qty</th>
                                <th class="center">SC</th>
                                <th class="center">SB</th>
                                <th class="center">CC</th>
                                <th class="center">Mid Pass</th>
                                <th class="center">Mid Defect</th>
                                <th class="center">End Pass</th>
                                <th class="center">End Defect</th>
                                <th class="center">Finishing Pass</th>
                                <th class="center">Finishing Defect</th>
                                <th class="center">Packing</th>
                                <th class="center">Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                    <td class="center"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
            <?php
//            }
            ?>
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
</script>