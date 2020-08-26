<!--<div class="info red_symbols">-->
<!--    <img width="85" height="85" src="--><?php //echo base_url();?><!--assets/images/efficiency_logo.png"></div>-->
<span style="font-size: 25px;">EFFICIENCY</span>
<h1 class="bolded">
    <?php
    $hour=0;
    $work_minute=0;

    if ($segment_id == 1){
        if($time > '13:00:00'){
            $sec_to_minutes = (($work_time-3600) / 60);

            $minutes = round($sec_to_minutes, 2);
        }else{
            $sec_to_minutes = ($work_time / 60);

            $minutes = round($sec_to_minutes, 2);
        }
    }else{
        $sec_to_minutes = ($work_time / 60);

        $minutes = round($sec_to_minutes, 2);
    }


    // For the Time Being - 30 Min being deducted for Floor-2 Start
    if($floor == 2){
        $minutes = $minutes - 30;
    }
    // For the Time Being - 30 Min being deducted for Floor-2 End

    if($man_power > 0){
        $hour = (round($minutes/60, 2) > 0 ? round($minutes/60, 2) : 0);
        $work_minute = (($minutes * $man_power) > 0 ? ($minutes * $man_power) : 0);
    }

//                                        echo '<pre>';
//                                        print_r($minutes);
//                                        echo '</pre>';
//                                        echo '<pre>';
//                                        print_r($work_time);
//                                        echo '</pre>';
//
//                                        echo '<pre>';
//                                        print_r($sec_to_minutes);
//                                        echo '</pre>';
//
//                                        echo '<pre>';
//                                        print_r('Minutes: '.$minutes.' MP: '.$man_power);
//                                        echo '</pre>';
//
//                                        echo '<pre>';
//                                        print_r('Work Min: '.$work_minute);
//                                        echo '</pre>';

    $produce_minute = 0;
    $average_produce_min = 0;
    foreach ($get_smv_list as $s){
        $smv = $s['smv'];
        $total_line_output = $s['total_line_output'];

        $produce_minute += ($total_line_output * $smv);

//                                            echo '<pre>';
//                                            print_r('smv: '.$smv.' output: '.$total_line_output);
//                                            echo '</pre>';
    }

//                                    echo '<pre>';
//                                    print_r('Prod Min: '.$produce_minute);
//                                    echo '</pre>';

    $eff = ($produce_minute/$work_minute) * 100;
    $line_efficiency = sprintf('%0.2f', $eff);

    $this->method_call->updateTodayEfficiency($line_id, $line_efficiency, $segment_id, $produce_minute, $work_minute, $hour);

    echo $line_efficiency;
    ?>
</h1>