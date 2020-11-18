<?php

foreach ($lines AS $k => $line){

    $total_defects = 0;
    ?>
    <tr>
        <td align="center"><?php echo $line['date']; ?></td>
        <td align="center"><?php echo $line['line_code']; ?></td>
        <td align="center">
            <?php
            //                echo round($line['sum_of_dhu']/$hour, 2);
            ?>
            <?php echo $line['dhu']; ?>
        </td>

        <?php
        foreach ($defect_types AS $d){

            $defect_count_res = $this->method_call->getDefectCountDateRange($line['id'], $d['defect_code'], $from_date, $to_date);

            $count_defect = ($defect_count_res[0]['count_defect'] != '' ? $defect_count_res[0]['count_defect'] : 0);

            $total_defects += $count_defect;



            ?>
            <td align="center">
                <?php
                    echo $count_defect;
                ?>
            </td>
        <?php
        }
        ?>
        <td align="center">
            <?php echo $total_defects; ?>
        </td>

    </tr>

<?php

}

?>