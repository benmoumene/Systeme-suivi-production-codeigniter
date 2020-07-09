<style type="text/css">

    body {font-family: Arial, Helvetica, sans-serif;}

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    /*Loader Start*/
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
    /*Loader End*/
</style>

<?php

$count_floor = 0;

$grand_total_target = 0;
$grand_total_output = 0;
$grand_sum_eff = 0;
$grand_average_eff = 0;
$grand_achievement_rate = 0;
$grand_wip = 0;

foreach ($floors as $v_f){

    $floor_id = $v_f['id'];

?>

<table class="display table table-bordered table-striped" id="">
    <thead>
    <tr style="background-color: #0A6EA0; color: #FFFFFF;">
        <th colspan="7" class="center"><h2><?php echo $v_f['floor_name'];?></h2></th>
    </tr>
    <tr style="background-color: #f7ffb0;">
        <th class="center">LINE</th>
        <th class="center">TARGET</th>
        <th class="center">OUTPUT</th>
        <th class="center">EFFICIENCY</th>
        <th class="center">WIP</th>
        <th class="center">DHU</th>
        <th class="center">REMARKS</th>
    </tr>
    </thead>
    <tbody>
    <?php

    $total_line_target=0;
    $total_line_output=0;
    $total_sum_efficiency=0;
    $total_wip=0;
    $count_lines=0;

    $line_prod = $this->method_call->getTodayLineProductionSummaryReport($search_date, $floor_id);
//    echo '<pre>';
//    print_r($line_prod);
//    echo '</pre>';
//    die();

    foreach ($line_prod as $v){

        $line_id = $v['line_id'];
        $line_target = ($v['target'] != '' ? $v['target'] : 0);
        $line_output = ($v['total_line_output'] != '' ? $v['total_line_output'] : 0);
        $wip=$v['wip'];

        $total_line_target += $line_target;
        $total_line_output += $line_output;
        $total_wip += $wip;
        ?>
        <tr>
            <td class="center">
                <?php echo $v['line_code'];?>
            </td>
            <td class="center"><?php echo $line_target;?></td>
            <td class="center">
                <a target="_blank" href="<?php echo base_url()?>dashboard/getDailyPerformanceDetail/<?php echo $v['line_name'];?>/<?php echo $v['line_id'];?>/<?php echo $search_date;?>">
                    <?php echo $line_output;?>
                </a>
            </td>
            <td class="center">
                <?php

                echo $line_efficiency = ($v['efficiency'] != '' ? $v['efficiency'] : "0.00");

                $total_sum_efficiency += $line_efficiency;

                if($v['total_line_output'] > 0){
                    $count_lines++;
                }
                ?>
            </td>
            <td class="center">
                <a target="_blank" href="<?php echo base_url();?>dashboard/lineWiseWipDetailReport/<?php echo $v['line_name'];?>/<?php echo $v['line_id'];?>/<?php echo $search_date;?>"><?php echo $v['wip'];?></a>
            </td>
            <td class="center" id="myBtn" onclick="getDhuReport(<?php echo $line_id;?>);" style="cursor: pointer;">
                <?php
                $dhu_sum = ($v['dhu_sum'] != '' ? $v['dhu_sum'] : 0);
                $work_hour_1 = ($v['work_hour_1'] != '' ? $v['work_hour_1'] : 0);
                $work_hour_2 = ($v['work_hour_2'] != '' ? $v['work_hour_2'] : 0);
                $work_hour_3 = ($v['work_hour_3'] != '' ? $v['work_hour_3'] : 0);
                $work_hour_4 = ($v['work_hour_4'] != '' ? $v['work_hour_4'] : 0);

                $total_wh = $work_hour_1+$work_hour_2+$work_hour_3+$work_hour_4;
                $average_dhu = round($dhu_sum/$total_wh, 2);

                echo $average_dhu;
                ?>
            </td>
            <td class="center"><?php echo $v['remarks']; ?></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    <tr>
        <td align="center"><h5><b>Total</b></h5></td>
        <td align="center"><h5><b><?php echo $total_line_target;?></b></h5></td>
        <td align="center"><h5><b><?php echo $total_line_output;?></b></h5></td>
        <td align="center">
            <h5>
                <b>
                    <?php
                    $total_eff = $total_sum_efficiency / $count_lines;
                    echo $total_line_efficiency = sprintf('%0.2f', $total_eff);
                    ?>
                </b>
            </h5>
        </td>
        <td class="center"><?php echo $total_wip;?></td>
        <td class="center"></td>
        <td class="center"></td>
    </tr>
    </tfoot>
</table>

<?php
    if($total_line_efficiency > 0){
        $count_floor++;
    }

    $grand_total_target +=  $total_line_target;
    $grand_total_output +=  $total_line_output;
    $grand_wip +=  $total_wip;
    $grand_sum_eff += $total_eff;

}

?>

<table class="display table table-bordered table-striped" id="">

    <thead>
        <tr style="background-color: #04a401; color: #FFFFFF;">
            <th class="center" colspan="5"><h2>GRAND TOTAL</h2></th>
        </tr>
        <tr style="">
            <th class="center"><h5><b>TARGET</b></h5></th>
            <th class="center"><h5><b>OUTPUT</b></h5></th>
            <th class="center"><h5><b>WIP</b></h5></th>
            <th class="center"><h5><b>ACHIEVEMENT(%)</b></h5></th>
            <th class="center"><h5><b>EFFICIENCY</b></h5></th>
        </tr>
    </thead>
    <tbody>
        <tr style="">
            <td class="center"><h5><?php echo $grand_total_target;?></h5></td>
            <td class="center"><h5><?php echo $grand_total_output;?></h5></td>
            <td class="center"><h5><?php echo $grand_wip;?></h5></td>
            <td class="center">
                <h5>
                    <?php
                    $grand_achievement_rate = (($grand_total_output/$grand_total_target)*100);
                        echo round($grand_achievement_rate).' %';
                    ?>
                </h5>
            </td>
            <td class="center">
                <h5>
                    <?php
                    $grand_average_eff = ($grand_sum_eff/$count_floor);
                    echo round($grand_average_eff, 2);
                    ?>
                </h5>
            </td>
        </tr>
    </tbody>

</table>


<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="loader_2" class="loader" style="display: block;"></div>
        <div id="quality"></div>
    </div>

</div>

<script type="text/javascript">
    //    Modal Start

    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    //    btn.onclick = function() {
    //        modal.style.display = "block";
    //    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    //    Modal End

    function getDhuReport(line_id) {
        $("#quality").empty();

        if(line_id != ''){

            $("#quality").load('<?php echo base_url();?>dashboard/getQualityDefectsReload/'+line_id);

            setInterval(function(){

                var isEmptyQuality = $("#quality").html() === "";

                if(isEmptyQuality == false){
                    $("#loader_2").css("display", "none");
                }
                if(isEmptyQuality == true){
                    $("#loader_2").css("display", "block");
                }

            }, 500);

            modal.style.display = "block";


        }

    }

</script>
