<?php

$line_name = '';
$line_id = $line_info[0]['id'];

if($line_info[0]['line_name'] != ''){
    $line_name = $line_info[0]['line_name'];
}

$line_target = (($line_target != '' && $line_target != 0) ? $line_target : 0);
$line_output = (($line_output != '' && $line_output != 0) ? $line_output : 0);

$balance = $line_target-$line_output;

$balance = (($balance != '' && $balance != 0) ? $balance : 0);

$dataPoints = array(
    array("label"=>"Balance", "y"=>$balance),
    array("label"=>"Output", "y"=>$line_output)
)

?>

<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
<!--          <h1>Dashboard</h1>-->
<!--          <h2 class="">Dashboard...</h2>-->
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
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">

                    <section class="panel default">
                        <div class="panel-body">

                            <div class="center">

<!--                                <span style="height: 420px; width: 100%; font-size: 50px;"><b>Hourly</b></span>-->
                                <div id="chartContainer_1" style="<?php if($line_id == 7){ ?>height: 520px; <?php }else{ ?> height: 430px; <?php } ?> width: 100%;"></div>
                            </div>


                        </div>
                    </section>
                </div>
                <div class="col-md-4">

                    <section class="panel default">
                        <div class="panel-body">

                            <div id="chartContainer" style="<?php if($line_id == 7){ ?>height: 520px; <?php }else{ ?> height: 430px; <?php } ?> width: 100%;"></div>

                        </div>
                    </section>
                </div>
                <div class="col-md-4">

                    <section class="panel default">
                        <div class="panel-body">

                            <div class="center" style="<?php if($line_id == 7){ ?>height: 520px; <?php }else{ ?> height: 430px; <?php } ?> width: 100%; font-size: 50px;"><b>Quality</b></div>

                        </div>
                    </section>
                </div>

            </div>
        </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">

                <section class="panel default">
                    <div class="panel-body">

                        <div class="left" style="width: 100%; font-size: 25px;"><b>Upcoming POs</b></div>
                        <br />
                        <marquee behavior="scroll" Scrolldelay="200" direction="up" scrollamount="1" onmouseover="this.stop();"
                                 onmouseout="this.start();" style="font-size: 18px; height: 75px;">

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
                                        <td class="center"><?php echo $v_3['style_no'].'_'.$v_3['style_name'];?></td>
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
            <div class="col-md-6">

                <div class="col-md-6">
                    <div class="information green_info">
                        <div class="information_inner">
                            <div class="info green_symbols"><i class="fa fa-users icon"></i></div>
                            <span style="font-size: 25px;">MAN POWER</span>
                            <h1 class="bolded"><?php echo $man_power;?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                        <div class="information red_info">
                            <div class="information_inner">
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

<script type="text/javascript">
    $(document).ready(function(){
//        setInterval(function(){
//            $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReportByUID');
//        }, 10000);

        setInterval(function() {
            window.location.reload();
        }, 60000);
    });

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

    function getSizeWiseReport(sap_no, po, item, quality, color) {
        $("#size_tbl").empty();

//        alert(sap_no+'-'+po+'-'+item+'-'+quality+'-'+color);

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getPoItemWiseSizeReport/",
            type: "POST",
            data: {po_no: sap_no, purchase_order: po, item: item, quality: quality, color: color},
            dataType: "html",
            success: function (data) {
                $("#size_tbl").append(data);
            }
        });
    }

// Chart Data Load

    window.onload = function() {
        CanvasJS.addColorSet("colorShades",
            [//colorSet Array

                "#ad1d0a",
                "#28a832"
            ]);

        var chart = new CanvasJS.Chart("chartContainer", {
            colorSet: "colorShades",
            theme: "theme2",
            animationEnabled: true,
            title: {
//                text: "Target: <?php //echo ($line_target != '' ? $line_target : 0);?>// | Output: <?php //echo ($line_output != '' ? $line_output : 0);?>// | Balance: <?php //echo ($balance != '' && $balance > 0 ? $balance : 0);?>//"
                text: "Target:<?php echo ($line_target != '' ? $line_target : 0);?> | Balance:<?php echo ($balance != '' && $balance > 0 ? $balance : 0);?>",
                fontSize: 28
            },
            data: [{
                type: "pie",
                indexLabel: "{y}",
//                yValueFormatString: "#,##0.00\"%\"",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#FFFFFF",
                indexLabelFontSize: 38,
                indexLabelFontWeight: "bolder",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();


        <!--HOURLY CHART START-->


        var chart_h = new CanvasJS.Chart("chartContainer_1",
            {
                title:{
                    text: "Hourly",
                    fontSize: 28
                },

                axisX:{
                    labelFontSize: 18,
                    labelFontWeight: "bold"
                },

                toolTip: {
                    shared: true
                },

                data: [
                    {
                        type: "bar",
                        legendText: "TARGET",
                        showInLegend: true,
                        name: "TARGET",
                        indexLabel: "{y}",
                        indexLabelFontSize: 18,
                        color: "#f9ae00",
                        dataPoints: [
                            <?php foreach ($hours as $k_1 => $v_1){ ?>
                                { label: "<?php echo date('H:i', strtotime($v_1['start_time'])).'-'.date('H:i', strtotime($v_1['end_time']));?>", y: <?php echo (round(($line_target != '' ? $line_target : 0)/10));?> },
                            <?php } ?>
                        ]
                    }
                    ,

                    {
                        type: "bar",
                        legendText: "OUTPUT",
                        showInLegend: true,
                        name: "OUTPUT",
                        indexLabel: "{y}",
                        indexLabelFontSize: 18,
                        dataPoints: [
                            <?php foreach ($hours as $k_2 => $v_2){
                            $output = $this->method_call->todayLineOutputHourly($v_2['start_time'], $v_2['end_time']);

                            $hourly_qty = ($output[0]['hourly_output'] != 0 ? $output[0]['hourly_output'] : 0);

                            $line_hour_target = (round(($line_target != '' ? $line_target : 0)/10));

                            $color_code = (($line_hour_target <= $hourly_qty) ? "#28a832" : "#ad1d0a");
                                ?>

                                { label: "<?php echo date('H:i', strtotime($v_2['start_time'])).'-'.date('H:i', strtotime($v_2['end_time']));?>", y: <?php echo $hourly_qty;?>, color: '<?php echo $color_code;?>' },
                            <?php } ?>
                        ]
                    }

                ]

            });

        chart_h.render();


    }

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