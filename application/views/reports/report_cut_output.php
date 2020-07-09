<!--\\\\\\\ contentpanel start\\\\\\-->
<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Cut Vs Output Report</h1>
        <h2 class="">Cut Vs Output Report...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">DASHBOARD</a></li>
            <li class="active">Cut Vs Output Report</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-md-2">
                    <div class="input-append date dpMonths" data-date="102/2012" data-date-format="yyyy-mm" data-date-viewmode="years" data-date-minviewmode="months">
                        <input type="text" id="year_month" class="form-control" size="30" value="yyyy-mm" readonly="">
                        <span class="input-group-btn add-on">
                      <button type="button" class="btn btn-danger"><i class="fa fa-calendar"></i></button>
                      </span> </div>
                    <span class="help-block">Select month only</span>
                </div>
                <div class="col-md-1">

                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" onclick="getCutVsOutputReport();">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />

    <div class="row" id="report_content">
        <div class="row">
            <div class="col-md-12">
                <div class="block-web">
                    <div id="chart_div" style="width: 1380px; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
    <!--\\\\\\\ container  end \\\\\\-->



    <script type="text/javascript">
        $('select').select2();

        //    setTimeout(function(){
        //        window.location.reload(1);
        //    }, 5000);

        <?php

        $total_cut_qty = $cut_output_report[0]['total_cut_qty'];
        $total_pack_qty = $cut_output_report[0]['total_pack_qty'];

        $dataPoints = array(
            array("label"=>"CUT", "y"=>$total_cut_qty),
            array("label"=>"PACK", "y"=>$total_pack_qty)
        );

        ?>

        function getCutVsOutputReport() {
            var year_month = $("#year_month").val();

            $("#report_content").empty();

            var dataPoints = [];

            $.ajax({
                url: "<?php echo base_url();?>dashboard/getCutVsOutputReport/",
                type: "POST",
                data: {year_month: year_month},
                dataType: "json",
                success: function (data) {

                    var total_cut_qty = data[0].total_cut_qty;
                    var total_pack_qty = data[0].total_pack_qty;

//                    $("#report_content").append(data);


                    console.log(dataPoints);

                    window.onload = function() {
                        CanvasJS.addColorSet("colorShades",
                            [//colorSet Array

                                "#ad1d0a",
                                "#28a832"
                            ]);

                        var chart = new CanvasJS.Chart("chart_div", {
                            colorSet: "colorShades",
                            theme: "theme2",
                            animationEnabled: true,
                            title: {
                                text: "CUT-PACKED Report of "+year_month,
                                fontSize: 25
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
                                dataPoints: [{label: "CUT", y: total_cut_qty},{label: "PACK", y: total_pack_qty}]
                            }]
                        });
                        chart.render();

                    }

                }
            });
        }
    </script>