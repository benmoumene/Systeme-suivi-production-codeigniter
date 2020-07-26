<table>
    <thead>
    <tr style="background-color: rgba(159,255,154,0.41)">
        <th class="text-center" colspan="6"><span style="font-size: 28px;">BRAND WISE CUTTING: <?php echo $date;?></span></th>
    </tr>
</table>
<table>
    <thead>
        <tr>
            <th class="text-center"><span style="font-size: 25px;">BRAND</span></th>
            <th class="text-center"><span style="font-size: 25px;">LAY</span></th>
            <th class="text-center"><span style="font-size: 25px;">CUT</span></th>
            <th class="text-center"><span style="font-size: 25px;">MARKER</span></th>
            <th class="text-center"><span style="font-size: 25px;">RATIO</span></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cutting_buyers AS $b){

            $result = $this->method_call->getBuyerWiseCuttingDashboardReport($b['brand']);

        ?>
            <tr>
                <td class="text-center">
                    <span style="font-size: 22px;"><?php echo $b['brand'];?></span>
                </td>
                <td class="text-center">
                    <span style="font-size: 22px;"><?php echo ($result[0]['total_lay_qty'] != '' ? $result[0]['total_lay_qty'] : 0);?></span>
                </td>
                <td class="text-center">
                    <span style="font-size: 22px;"><?php echo ($result[0]['today_cut_qty'] != '' ? $result[0]['today_cut_qty'] : 0);?></span>
                </td>
                <td class="text-center">
                    <span style="font-size: 22px;"><?php echo ($result[0]['total_no_of_marker_qty'] != '' ? $result[0]['total_no_of_marker_qty'] : 0);?></span>
                </td>
                <td class="text-center">
                    <span style="font-size: 22px;"><?php echo ($result[0]['total_no_of_garments'] != '' ? $result[0]['total_no_of_garments'] : 0);?></span>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>