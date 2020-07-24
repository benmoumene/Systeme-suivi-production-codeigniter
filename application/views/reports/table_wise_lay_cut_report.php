<script type="text/javascript">

    $(document).ready(function(){

//        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer_1",
                {
                    animationEnabled: true,
                    title: {
                        text: "CUT TABLE REPORT: <?php echo $date;?>"
                    },
                    dataPointWidth: 30,
                    axisX: {
                        valueFormatString: "",
                        labelFontSize: 25
                    },
                    axisY: {
                        prefix: "",
                    },
//            toolTip: {
//                shared: true
//            },
                    legend: {
                        cursor: "pointer"
                    },
                    data: [
                        {
                            type: "column",
                            name: "LAY WIP",
                            showInLegend: true,
                            color: "#d8cf27",
                            indexLabelFontSize: 25,
                            indexLabelOrientation: "vertical",
                            xValueFormatString: "LAY WIP",
                            yValueFormatString: "#,##0",
                            dataPoints: [

                                <?php foreach ($table_report as $k_1 => $v_1){

                                $balance_to_cut_qty = ($v_1['balance_to_cut_qty'] != '' ? $v_1['balance_to_cut_qty'] : 0);

                                ?>
                                { label: "<?php echo $v_1['table_name'];?>", y: <?php echo $balance_to_cut_qty;?>, indexLabel: "<?php echo $balance_to_cut_qty;?>" },
                                <?php } ?>

                            ]
                        },
                        {
                            type: "column",
                            name: "CUT",
                            showInLegend: true,
                            color: "#62a4d8",
                            indexLabelFontSize: 25,
                            indexLabelOrientation: "vertical",
                            xValueFormatString: "CUT",
                            yValueFormatString: "##0",
                            dataPoints: [

                                <?php foreach ($table_report as $k_1 => $v_1){

                                $cut_complete_qty = ($v_1['cut_complete_qty'] != '' ? $v_1['cut_complete_qty'] : 0);

                                ?>
                                { label: "<?php echo $v_1['table_name'];?>", y: <?php echo $cut_complete_qty;?>, indexLabel: "<?php echo $v_1['cut_complete_qty'];?>" },
                                <?php } ?>

                            ]
                        }

                    ]
                });

            chart.render();

//        }

    });

</script>