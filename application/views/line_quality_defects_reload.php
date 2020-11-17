<div class="panel-body">
<!--    <div class="center" style="font-size: 40px;"><b>Quality</b></div>-->

    <?php if(!empty($qa_major_defects)){ ?>
    <table class="table table-bordered table-responsive">
        <tr class="row center">
            <td style="font-size: 25px;">
                <?php
                $dhu = 0;

                $total_passed_qty = ($dhu_report[0]['qty'] != '' ? $dhu_report[0]['qty'] : 0);
                $defect_checking_count = ($dhu_report[0]['defect_checking_count'] != '' ? $dhu_report[0]['defect_checking_count'] : 0);
                $total_defect_count = ($dhu_report[0]['total_defect_count'] != '' ? $dhu_report[0]['total_defect_count'] : 0);

                if($total_defect_count > 0){
                    $total_pc_check_qty = $total_passed_qty+$defect_checking_count;

                    $dhu = round((($total_defect_count/$total_pc_check_qty)*100), 2);
                }else{
                    $dhu=0;
                }

                $res_hour = $this->method_call->lineQualityDefectSave($line_id, $dhu);
                ?>
                <b>
                    <?php
                    $total_output_qty = ($dhu_summary[0]['total_output_qty'] != '' ? $dhu_summary[0]['total_output_qty'] : 0);
                    $total_no_of_defect = ($dhu_count[0]['count_defect'] != '' ? $dhu_count[0]['count_defect'] : 0);
                    $total_inspected_qty = ($total_output_qty+$total_no_of_defect);

                    $dhu_sum = ($dhu_summary[0]['dhu_sum'] != '' ? $dhu_summary[0]['dhu_sum'] : 0);
                    $work_hour_1 = ($dhu_summary[0]['work_hour_1'] != '' ? $dhu_summary[0]['work_hour_1'] : 0);
                    $work_hour_2 = ($dhu_summary[0]['work_hour_2'] != '' ? $dhu_summary[0]['work_hour_2'] : 0);
                    $work_hour_3 = ($dhu_summary[0]['work_hour_3'] != '' ? $dhu_summary[0]['work_hour_3'] : 0);
                    $work_hour_4 = ($dhu_summary[0]['work_hour_4'] != '' ? $dhu_summary[0]['work_hour_4'] : 0);

                    $total_wh = $work_hour_1+$work_hour_2+$work_hour_3+$work_hour_4;

                    $average_dhu = round($dhu_sum/$hour, 2);

                    $dhu_res = round(($total_no_of_defect * 100) / $total_inspected_qty, 2);

                    $this->method_call->lineDhuUpdate($line_id, $dhu_res);
                    ?>
                </b>
                <b>DHU(%): </b> <?php echo $dhu_res;?>
            </td>
            <td style="font-size: 25px;">
                <b>Defect Count: </b> <?php echo $total_no_of_defect;?>
            </td>
        </tr>
    <?php
    foreach ($qa_major_defects as $v){ ?>

        <tr class="row center">
            <td style="font-size: 25px;"><b><?php echo $v['defect_name'];?></b></td>
            <td style="font-size: 25px;"><b><?php echo $v['defect_count'];?></b></td>
        </tr>

    <?php } ?>
    </table>
    <?php }else{ ?>
        <div class="center" style="<?php if($line_id == 7){ ?>height: 430px; <?php }else{ ?> height: 335px; <?php } ?> width: 100%; font-size: 40px;"><b>Quality</b></div>
    <?php } ?>
</div>

