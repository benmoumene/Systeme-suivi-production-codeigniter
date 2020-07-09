<div class="row center"><b><span style="font-size: 20px;">
            MID PASS
        </span></b></div>
<div class="panel-body">

    <?php

    $count_mid_pass_qty = $line_status[0]['count_mid_pass_qty'];

    ?>

    <div class="row center" style="font-size: 25px;">
        <b>
            <?php
            echo (($count_mid_pass_qty != '' && $count_mid_pass_qty > 0) ? $count_mid_pass_qty : 0);
            ?>
        </b>
    </div>

</div>