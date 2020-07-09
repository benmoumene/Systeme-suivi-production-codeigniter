<?php

$floor_name = '';
if($finishing_report[0]['floor_name'] != ''){
    $floor_name = $finishing_report[0]['floor_name'];
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
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="header">
<!--        <div class="actions"> <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button> </div>-->
    </div>
        <div class="row">
            <div class="col-md-12">

                <div class="col-md-12">

                    <section class="panel default">
                        <div class="panel-body">

                            <div id="chartContainer" style="height: 500px; width: 100%;"></div>

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
            $("#chartContainer").load('<?php echo base_url();?>dashboard/getFinishingOutputSummaryReload/<?php echo $floor_id;?>');
//            window.location.reload();
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