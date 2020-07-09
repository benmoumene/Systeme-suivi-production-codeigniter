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

<?php

$floor_name = '';
if($finishing_report[0]['floor_name'] != ''){
    $floor_name = $finishing_report[0]['floor_name'];
    $floor_id = $finishing_report[0]['floor_id'];
    echo $floor_id;
}

$finishing_target = (($finishing_target != '' && $finishing_target != 0) ? $finishing_target : 0);
$finishing_output_qty = (($finishing_output_qty != '' && $finishing_output_qty != 0) ? $finishing_output_qty : 0);

$balance = $finishing_target-$finishing_output_qty;

$balance = (($balance != '' && $balance != 0) ? $balance : 0);

$dataPoints = array(
    array("label"=>"Balance", "y"=>$balance),
    array("label"=>"Output", "y"=>$finishing_output_qty)
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

<!--  --><?php
//  echo '<pre>';
//  print_r($hours);
//  echo '</pre>';
//  ?>


</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="header">
        <!--        <div class="actions"> <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button> </div>-->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">

                <section class="panel default">
                    <div class="panel-body">

                        <div class="center">
                                <div id="chartContainer_1" style="height: 430px; width: 100%;"></div>
                        </div>


                    </div>
                </section>
            </div>
            <div class="col-md-6">

                <section class="panel default">
                    <div class="panel-body">

                        <div class="center">
                            <div id="chartContainer" style="height: 430px; width: 100%;"></div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4"></div>
            <div class="col-md-4">

                <section class="panel default">
                    <div class="panel-body" style="background-color: red; color: white;">

                        <div class="center">
                            <span style="font-size: 30px;">QC ALTER</span>

                            <div id="chartContainer_2" style="font-size: 25px; margin-top: 20px;"></div>
                        </div>


                    </div>
                </section>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function(){
//        setInterval(function(){
//            $("#reload_div").load('<?php //echo base_url();?>//access/getProductionSummaryReportByUID');
//        }, 10000);

        $("#chartContainer").load('<?php echo base_url();?>dashboard/getFinishingOutputSummaryReload/<?php echo $floor_id;?>');
        $("#chartContainer_1").load('<?php echo base_url();?>dashboard/getFinishingHourlyOutputReload/<?php echo $floor_id;?>');
        $("#chartContainer_2").load('<?php echo base_url();?>dashboard/getFinishingQcSummaryReload/<?php echo $floor_id;?>');

        setInterval(function() {
            $("#chartContainer_1").load('<?php echo base_url();?>dashboard/getFinishingHourlyOutputReload/<?php echo $floor_id;?>');
            $("#chartContainer").load('<?php echo base_url();?>dashboard/getFinishingOutputSummaryReload/<?php echo $floor_id;?>');
            $("#chartContainer_2").load('<?php echo base_url();?>dashboard/getFinishingQcSummaryReload/<?php echo $floor_id;?>');

        }, 120000);
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

                                    $output = $this->method_call->todayLineOutputHourly($line_id, $v_2['start_time'], $v_2['end_time']);
                                    echo $output;

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
                text: "Target:<?php echo ($finishing_target != '' ? $finishing_target : 0);?> | Balance:<?php echo ($balance != '' && $balance > 0 ? $balance : 0);?>"
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

</script>