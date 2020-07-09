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
                                <div class="table-responsive" style="">
                                    <table class="display table table-bordered table-striped" id="">
                                        <thead>
                                            <tr>
                                                <th class="center"><span style="font-size: 25px;">Hour</span></th>
                                                <th class="center"><span style="font-size: 25px;">Target</span></th>
                                                <th class="center"><span style="font-size: 25px;">Output</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $total_hourly_qty = 0;

                                        foreach ($hours as $k => $v){ ?>
                                            <tr>
                                                <td class="center"><span style="font-size: 18px;"><?php echo date('H:i', strtotime($v['start_time'])) .' - '. date('H:i', strtotime($v['end_time']));?></span></td>
                                                <td class="center"><span style="font-size: 18px;"><?php echo (round($line_target/10));?></span></td>
                                                <td class="center">
                                                    <span style="font-size: 18px;">
                                                    <?php
                                                        $output = $this->method_call->todayLineOutputHourly($v['start_time'], $v['end_time']);

                                                        echo $hourly_qty = $output[0]['hourly_output'];

//                                                    $total_hourly_qty += $hourly_qty;
                                                    ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
<!--                                        <tfoot>-->
<!--                                            <tr>-->
<!--                                                <td class="center"><span style="font-size: 25px;">Total</span></td>-->
<!--                                                <td class="center"><span style="font-size: 25px;">--><?php //echo $line_target;?><!--</span></td>-->
<!--                                                <td class="center"><span style="font-size: 25px;">--><?php //echo $total_hourly_qty;?><!--</span></td>-->
<!--                                            </tr>-->
<!--                                        </tfoot>-->
                                    </table>
                                </div>
                            </div>


                        </div>
                    </section>
                </div>
                <div class="col-md-5">

                    <section class="panel default">
                        <div class="panel-body">

                            <div id="chartContainer" style="height: 420px; width: 100%;"></div>

                        </div>
                    </section>
                </div>
                <div class="col-md-3">

                    <section class="panel default">
                        <div class="panel-body">

                            <div class="center" style="height: 420px; width: 100%; font-size: 50px;"><b>Quality</b></div>

                        </div>
                    </section>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">

                    <section class="panel default">
                        <div class="panel-body">

                            <div class="center" style="width: 100%; font-size: 30px;"><b>Upcoming POs</b></div>

                        </div>
                    </section>
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
        }, 30000);
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
                "#3CB371"
            ]);

        var chart = new CanvasJS.Chart("chartContainer", {
            colorSet: "colorShades",
            theme: "theme2",
            animationEnabled: true,
            title: {
//                text: "Target: <?php //echo ($line_target != '' ? $line_target : 0);?>// | Output: <?php //echo ($line_output != '' ? $line_output : 0);?>// | Balance: <?php //echo ($balance != '' && $balance > 0 ? $balance : 0);?>//"
                text: "Target:<?php echo ($line_target != '' ? $line_target : 0);?> | Balance:<?php echo ($balance != '' && $balance > 0 ? $balance : 0);?>"
            },
            data: [{
                type: "pie",
                indexLabel: "{y}",
//                yValueFormatString: "#,##0.00\"%\"",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "#FFFFFF",
                indexLabelFontSize: 35,
                indexLabelFontWeight: "bolder",
                showInLegend: true,
                legendText: "{label}",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

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