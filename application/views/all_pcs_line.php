<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $heading_title ?></title>
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
                    <h1><?php echo $heading_title ?></h1>
                    <h2 class=""><?php echo $heading_title ?>...</h2>
                </div>
                <div class="pull-right">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url();?>">Home</a></li>
                        <li class="active"><?php echo $heading_title ?></li>
                    </ol>
                </div>
            </div>
    <div class="container clear_both padding_fix">

    <div id="main-content">
        <div class="page-content">


            <div class="row">
                <div class="col-md-12">
                    <div class="block-web">
                        <div class="header">
                            <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                            <h3 class="content-header"><?php echo $heading_title?></h3>
                        </div>
                        <div class="porlets-content">
                            <div class="table-responsive">

                    <table class="display table table-bordered table-striped" id="dynamic-table">
                        <thead>
                            <tr>
                                <th class="center">SL</th>
                                <th class="center">Line - Floor</th>
                                <th class="center">Care Label No.</th>
                                <th class="center">Brand</th>
                                <th class="center">PO/STROKE</th>
                                <th class="center">ITEM/WEEK</th>
                                <th class="center">STYLE</th>
                                <th class="center">STYLE NAME</th>
                                <th class="center">QUALITY</th>
                                <th class="center">COLOR</th>
                                <th class="center">Size</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sl=1;

                        foreach ($order_info as $v){
                        $pc_tracking_no = $v['pc_tracking_no'];
                        $floor_name = $v['floor_name'];
                        $line_id = $v['line_id'];
                        $line_name = $v['line_name'];
                        $purchase_order = $v['purchase_order'];
                        $item = $v['item'];
                        $style_no = $v['style_no'];
                        $style_name = $v['style_name'];
                        $color = $v['color'];
                        $brand = $v['brand'];
                        $size = $v['size'];
                        $quality = $v['quality'];
                        $access_points = $v['access_points'];
                        $access_points_status = $v['access_points_status'];

//                        $cut_order = $this->method_call->poWiseCuttingInfo($purchase_order, $item, $style_no, $quality, $color);

                        ?>
                            <tr>
                                <td class="center"><?php echo $sl; $sl++;?></td>
                                <td class="center"><b><?php echo $line_name.'</b> - <b>'.$floor_name;?></b></td>
                                <td class="center">
                                    <?php if($access_points_status == 2){ ?>
                                        <a href="<?php echo base_url();?>access/viewClDefects/<?php echo $pc_tracking_no;?>/<?php echo $line_id;?>/<?php echo $access_points;?>" target="_blank"><?php echo $pc_tracking_no;?></a>
                                    <?php }else{?>
                                        <?php echo $pc_tracking_no;?>
                                    <?php } ?>
                                </td>
                                <td class="center"><?php echo $brand;?></td>
                                <td class="center"><?php echo $purchase_order;?></td>
                                <td class="center"><?php echo $item;?></td>
                                <td class="center"><?php echo $style_no;?></td>
                                <td class="center"><?php echo $style_name;?></td>
                                <td class="center"><?php echo $quality;?></td>
                                <td class="center"><?php echo $color;?></td>
                                <td class="center"><?php echo $size;?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
</div>
    <!--\\\\\\\ container  end \\\\\\-->
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
    $('select').select2();

//    setTimeout(function(){
//        window.location.reload(1);
//    }, 5000);

    function getReportByPo(id) {
        var purchase_order_stuff = $("#"+id).val();

        $("#report_content").empty();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoWiseReportbyPo/",
            type: "POST",
            data: {purchase_order_stuff: purchase_order_stuff},
            dataType: "html",
            success: function (data) {
                $("#report_content").append(data);
            }
        });

    }
</script>