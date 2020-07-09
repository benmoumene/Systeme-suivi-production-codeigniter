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

    <!--Canvas Chart Asset Start-->
    <script src="<?php echo base_url(); ?>assets/js/canvas_chart/canvasjs.min.js"></script>
    <!--Canvas Chart Asset End-->

    <style type="text/css">

        .has-error .select2-selection {
            /*border: 1px solid #a94442;
            border-radius: 4px;*/
            border-color:rgb(185, 74, 72) !important;
        }

        div.scroll {
            /*background-color: #00FFFF;*/
            width: 1900px;
            height: 500px;
            overflow: scroll;
        }

        div.scroll2 {
            /*background-color: #00FFFF;*/
            width: 1200px;
            height: 500px;
            overflow: scroll;
        }

        div.scroll3 {
            /*background-color: #00FFFF;*/
            width: 700px;
            height: 500px;
            overflow: scroll;
        }

        /*table thead fixed*/
        .table-fixed thead {
            width: 100%;
        }
        .table-fixed tbody {
            height: 230px;
            overflow-y: auto;
            width: 100%;
        }
        .table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
            display: block;
        }
        .table-fixed tbody td, .table-fixed thead > tr> th {
            float: left;
            border-bottom-width: 0;
        }
        /*table thead fixed*/

        .well1 {
            background: none;
            height: 400px;
        }

        .well {
            background: none;
            height: 600px;
        }

        .table-scroll tbody {
            position: absolute;
            overflow-y: scroll;
            height: 450px;
        }

        .table-scroll tr {
            width: 100%;
            table-layout: fixed;
            display: inline-table;
        }

        .table-scroll thead > tr > th {
            /*border: none;*/
        }

        /* Loader Style Start */

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

        /* Loader Style End */
    </style>
    <!--Select2 End-->

</head>
<!--<body class="light_theme  fixed_header left_nav_fixed">-->
<?php
if(isset($line_target)){
    if($line_target != 0 && $line_output != 0){
        $balance = $line_target-$line_output;

        $dataPoints = array(
            array("label"=>"Balance", "y"=>$balance),
            array("label"=>"Output", "y"=>$line_output)
        );

    }
}


?>

<body class="light_theme green_thm left_nav_hide">
<div class="wrapper">

    <div class="inner">
        <!--\\\\\\\left_nav end \\\\\\-->
        <div class="contentpanel">

        <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
<!--          <h1>Dashboard</h1>-->
<!--          <h2 class="">Dashboard...</h2>-->
            Line Performance
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="javascript:void(0);" onclick="window.location.reload(1);"> <i class="fa fa-repeat"></i> </a></li>
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Dashboard</li>
          </ol>
        </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="header">
<!--        <div class="actions"> <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button> </div>-->
    </div>
    <form action="<?php echo base_url();?>dashboard/linePerformanceDashboard" method="post">
        <div class="row">
            <div class="col-md-12">

                <select name="line_no" id="line_no" onchange="">
                    <option value="">Select Line</option>
                    <?php foreach ($lines as $ln){ ?>
                        <option value="<?php echo $ln['id'];?>"><?php echo $ln['line_name'];?></option>
                    <?php } ?>
                </select>

                <button type="submit">Search</button>
                <div id="loader" style="display: none;"><div class="loader"></div></div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">

            <?php
            $line_id = $line_info[0]['id'];

            if($line_info[0]['line_name'] != ''){ ?>
                <span class="center"><h1><b><?php echo $line_info[0]['line_name']; ?></b></h1></span>
            <?php } ?>

        </div>
        <div class="col-md-4">

        </div>
    </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">

                    <section class="panel default">
                        <div class="panel-body">

                            <div class="center">

<!--                                <span style="height: 420px; width: 100%; font-size: 50px;"><b>Hourly</b></span>-->
                                <div id="chartContainer_1" style="height: 370px; width: 100%;"></div>
                            </div>


                        </div>
                    </section>
                </div>
                <div class="col-md-4">

                        <section class="panel default">
                            <div class="panel-body">

                                <div id="chartContainer" style="height: 370px; width: 100%;"></div>

                            </div>
                        </section>

                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <section class="panel default" id="wip" style="background-color: #ff0e16; color: #ffffff;"></section>
                        </div>
                        <!--                        <div class="col-sm-4">-->
                        <!---->
                        <!--                            <section class="panel default" style="background-color: #286110; color: #ffffff;">-->
                        <!--                                <div class="row center"><b><span style="font-size: 15px;">Collar-Cuff</span></b></div>-->
                        <!--                                <div class="panel-body">-->
                        <!---->
                        <!--                                    <div class="row center" style="font-size: 25px;"><b>250</b></div>-->
                        <!---->
                        <!--                                </div>-->
                        <!--                            </section>-->
                        <!--                        </div>-->
                        <div class="col-sm-6">
                            <section class="panel default" id="mid_qc_pass" style="background-color: #ffcb0c; color: #000000;"></section>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <section class="panel default" id="quality">
                                <div class="center" style="height: 335px; width: 100%; font-size: 40px;"><b>Quality</b></div>
                            </section>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">

                    <section class="panel default">
                        <div class="panel-body" id="upcoming_pos">

                            <div class="left" style="width: 100%; font-size: 25px;"><b>Upcoming POs</b></div>
                            <br />
                            <marquee behavior="scroll" Scrolldelay="200" direction="up" scrollamount="1"
                                     onmouseover="this.stop();" onmouseout="this.start();" style="font-size: 18px; height: 75px;">

                                <?php

                                foreach ($upcoming_po as $v_3){ ?>

                                    <table border="1" style="margin-left: 25px;">
                                        <thead>
                                        <tr style="background-color: #f7ffb0;">
                                            <th class="center">PO_ITEM</th>
                                            <th class="center">Brand</th>
                                            <th class="center">QLTY_CLR</th>
                                            <th class="center">STYLE</th>
                                            <th class="center">QTY</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td class="center"><?php echo $v_3['purchase_order'].'_'.$v_3['item'];?></td>
                                            <td class="center"><?php echo $v_3['brand'];?></td>
                                            <td class="center"><?php echo $v_3['quality'].'_'.$v_3['color'];?></td>
                                            <td class="center"><?php echo $v_3['style_name'];?></td>
                                            <td class="center"><?php echo $v_3['total_order_qty'];?></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <br />
                                <?php } ?>


                            </marquee>

                        </div>
                    </section>
                </div>
                <div class="col-md-2">
                    <div class="information red_info">
                        <div class="information_inner" id="running_pos">
                            <span style="font-size: 25px;">RUNNING POs</span>
                            <h1 class="bolded"><?php echo '';?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="col-md-6">
                        <div class="information green_info">
                            <div class="information_inner" id="man_power">
                                <div class="info green_symbols"><i class="fa fa-users icon"></i></div>
                                <span style="font-size: 25px;">MAN POWER</span>
                                <h1 class="bolded"><?php echo $man_power;?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="information red_info">
                            <div class="information_inner" id="efficiency">
                                <div class="info red_symbols"><img width="85" height="85" src="<?php echo base_url();?>assets/images/efficiency_logo.png"></div>
                                <span style="font-size: 25px;">EFFICIENCY</span>
                                <h1 class="bolded">
                                    <?php
                                        $minutes = ($work_time[0]['working_time_diff_to_sec'] / 60);
                                        $work_minute = $minutes * $man_power;

//                                    echo '<pre>';
//                                    print_r($minutes.' '.$man_power);
//                                    echo '</pre>';

//                                    echo '<pre>';
//                                    print_r('Work Min: '.$work_minute);
//                                    echo '</pre>';

                                        $produce_minute = 0;
                                        $average_produce_min = 0;
                                        foreach ($get_smv_list as $s){
                                            $smv = $s['smv'];
                                            $total_line_output = $s['total_line_output'];

                                            $produce_minute += ($total_line_output * $smv);

//                                            echo '<pre>';
//                                            print_r($smv.' '.$total_line_output);
//                                            echo '</pre>';
                                        }

//                                    echo '<pre>';
//                                    print_r('Prod Min: '.$produce_minute);
//                                    echo '</pre>';

                                        $eff = ($produce_minute/$work_minute) * 100;

                                        echo $line_efficiency = sprintf('%0.2f', $eff);
                                    ?>
                                </h1>
                            </div>
                        </div>

                    </div>

                </div>

            </div>


        </div>
        </div>

        </div>
        </div>

</div>
</body>


<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
//        setInterval(function(){
//            $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReportByUID');
//        }, 10000);

            $("#chartContainer_1").load('<?php echo base_url();?>dashboard/getLineHourlyOutputReload/<?php echo $line_id;?>');
            $("#chartContainer").load('<?php echo base_url();?>dashboard/getLineOutputSummaryReload/<?php echo $line_id;?>');
            $("#wip").load('<?php echo base_url();?>dashboard/getWipReload/<?php echo $line_id;?>');
            $("#mid_qc_pass").load('<?php echo base_url();?>dashboard/getMidQcPassReload/<?php echo $line_id;?>');
            $("#efficiency").load('<?php echo base_url();?>dashboard/getEfficiencyReload_1/<?php echo $line_id;?>');
            $("#man_power").load('<?php echo base_url();?>dashboard/getManPowerReload/<?php echo $line_id;?>');
            $("#running_pos").load('<?php echo base_url();?>dashboard/getRunningPoQtyReload/<?php echo $line_id;?>');
            $("#upcoming_pos").load('<?php echo base_url();?>dashboard/getUpcomingPosReload/<?php echo $line_id;?>');
            $("#quality").load('<?php echo base_url();?>dashboard/getQualityDefectsReload/<?php echo $line_id;?>');


            '<?php if($line_id != ""){ ?>'
                $("#loader").css("display", "block");

                setInterval(function(){


                    var isEmptywip = $("#wip").html() === "";

                    if(isEmptywip == false){
                        $("#loader").css("display", "none");
                    }

                }, 10000);

            '<?php } ?>'
    });

// Chart Data Load

//    window.onload = function() {
//        CanvasJS.addColorSet("colorShades",
//            [//colorSet Array
//
//                "#ad1d0a",
//                "#28a832"
//            ]);
//
//        var chart = new CanvasJS.Chart("chartContainer", {
//            colorSet: "colorShades",
//            theme: "theme2",
//            animationEnabled: true,
//            title: {
////                text: "Target: <?php ////echo ($line_target != '' ? $line_target : 0);?>//// | Output: <?php ////echo ($line_output != '' ? $line_output : 0);?>//// | Balance: <?php ////echo ($balance != '' && $balance > 0 ? $balance : 0);?>////"
//                text: "Target:<?php //echo ($line_target != '' ? $line_target : 0);?>// | Balance:<?php //echo ($balance != '' && $balance > 0 ? $balance : 0);?>//",
//                fontSize: 25
//            },
//            data: [{
//                type: "pie",
//                indexLabel: "{y}",
////                yValueFormatString: "#,##0.00\"%\"",
//                indexLabelPlacement: "inside",
//                indexLabelFontColor: "#FFFFFF",
//                indexLabelFontSize: 35,
//                indexLabelFontWeight: "bolder",
//                showInLegend: true,
//                legendText: "{label}",
//                dataPoints: <?php //echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
//            }]
//        });
//        chart.render();
//
//        <!--HOURLY CHART START-->
//
//
//        var chart_h = new CanvasJS.Chart("chartContainer_1",
//            {
//                title:{
//                    text: "Hourly",
//                    fontSize: 25
//                },
//
//                axisX:{
//                    labelFontSize: 15,
//                    labelFontWeight: "bold"
//                },
//
//                toolTip: {
//                    shared: true
//                },
//
//                data: [
//                    {
//                        type: "bar",
//                        legendText: "TARGET",
//                        showInLegend: true,
//                        name: "TARGET",
//                        indexLabel: "{y}",
//                        indexLabelFontSize: 16,
//                        color: "#f9ae00",
//                        dataPoints: [
//                            <?php //foreach ($hours as $k_1 => $v_1){ ?>
//                            { label: "<?php //echo date('H:i', strtotime($v_1['start_time'])).'-'.date('H:i', strtotime($v_1['end_time']));?>//", y: <?php //echo (round(($line_target != '' ? $line_target : 0)/10));?>// },
//                            <?php //} ?>
//                        ]
//                    }
//                    ,
//
//                    {
//                        type: "bar",
//                        legendText: "OUTPUT",
//                        showInLegend: true,
//                        name: "OUTPUT",
//                        indexLabel: "{y}",
//                        indexLabelFontSize: 16,
//                        dataPoints: [
//                            <?php //foreach ($hours as $k_2 => $v_2){
//                            $output = $this->method_call->todayLineOutputHourly($line_id, $v_2['start_time'], $v_2['end_time']);
//
//                            $hourly_qty = ($output[0]['hourly_output'] != 0 ? $output[0]['hourly_output'] : 0);
//
//                            $line_hour_target = (round(($line_target != '' ? $line_target : 0)/10));
//
//                            $color_code = (($line_hour_target <= $hourly_qty) ? "#28a832" : "#ad1d0a");
//                            ?>
//
//                            { label: "<?php //echo date('H:i', strtotime($v_2['start_time'])).'-'.date('H:i', strtotime($v_2['end_time']));?>//", y: <?php //echo $hourly_qty;?>//, color: '<?php //echo $color_code;?>//' },
//                            <?php //} ?>
//                        ]
//                    }
//
//                ]
//
//            });
//
//        chart_h.render();
//
//
//    }

//    window.onload = function () {
//        CanvasJS.addColorSet("colorShades",
//        [//colorSet Array
//
//            "#ad1d0a",
//            "#3CB371"
//        ]);
//
//        var chart = new CanvasJS.Chart("chartContainer", {
//            animationEnabled: true,
//            title:{
//                text: "Target: <?php //echo ($line_target != '' ? $line_target : 0);?>// | Output: <?php //echo ($line_output != '' ? $line_output : 0);?>// | Balance: <?php //echo ($balance != '' && $balance > 0 ? $balance : 0);?>//"
//            },
//            toolTip: {
//                shared: true
//            },
//            legend: {
//                reversed: true,
//                verticalAlign: "center",
//                horizontalAlign: "right"
//            },
//            data: [{
//                type: "stackedColumn100",
//                name: "OUTPUT",
//                color: "green",
//                showInLegend: true,
//                dataPoints: [
//                    { label: "<?php //echo $line_name;?>//", y: <?php //echo $line_output;?>// }
//                ]
//            },
//                {
//                    type: "stackedColumn100",
//                    name: "BALANCE",
//                    color: "red",
//                    showInLegend: true,
//                    dataPoints: [
//                        { label: "<?php //echo $line_name;?>//", y: <?php //echo $balance;?>// }
//                    ]
//                }]
//        });
//        chart.render();
//
//    }
</script>
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