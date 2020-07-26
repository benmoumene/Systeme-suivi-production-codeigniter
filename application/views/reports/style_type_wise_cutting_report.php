<table>
    <thead>
    <tr style="background-color: rgba(159,255,154,0.41)">
        <th class="text-center" colspan="4"><span style="font-size: 28px;">STYLE TYPE WISE REPORT</span></th>
    </tr>
</table>
<table>
    <thead>
    <tr style="background-color: rgba(179,238,255,0.88)">
        <th class="text-center" colspan="4"><span style="font-size: 22px;">CHECK</span></th>
    </tr>
    <tr>
        <th class="text-center"><span style="font-size: 20px;">LAY WIP</span></th>
        <th class="text-center"><span style="font-size: 20px;">CUT</span></th>
        <th class="text-center"><span style="font-size: 20px;">MARKER</span></th>
        <th class="text-center"><span style="font-size: 20px;">RATIO</span></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($lay_qty[0]['total_lay_qty_check'] != '' ? $lay_qty[0]['total_lay_qty_check'] : 0);?>
            </span>
        </td>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($today_cut[0]['today_cut_check_qty'] != '' ? $today_cut[0]['today_cut_check_qty'] : 0);?>
            </span>
        </td>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($today_no_of_marker[0]['total_no_of_marker_check_qty'] != '' ? $today_no_of_marker[0]['total_no_of_marker_check_qty'] : 0);?>
            </span>
        </td>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($today_no_of_garments[0]['total_no_of_garments_check'] != '' ? $today_no_of_garments[0]['total_no_of_garments_check'] : 0);?>
            </span>
        </td>
    </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr style="background-color: rgba(179,238,255,0.88)">
        <th class="text-center" colspan="4"><span style="font-size: 22px;">SOLID</span></th>
    </tr>
    <tr>
        <th class="text-center"><span style="font-size: 20px;">LAY WIP</span></th>
        <th class="text-center"><span style="font-size: 20px;">CUT</span></th>
        <th class="text-center"><span style="font-size: 20px;">MARKER</span></th>
        <th class="text-center"><span style="font-size: 20px;">RATIO</span></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($lay_qty[0]['total_lay_qty_solid'] != '' ? $lay_qty[0]['total_lay_qty_solid'] : 0);?>
            </span>
        </td>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($today_cut[0]['today_cut_solid_qty'] != '' ? $today_cut[0]['today_cut_solid_qty'] : 0);?>
            </span>
        </td>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($today_no_of_marker[0]['total_no_of_marker_solid_qty'] != '' ? $today_no_of_marker[0]['total_no_of_marker_solid_qty'] : 0);?>
            </span>
        </td>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($today_no_of_garments[0]['total_no_of_garments_solid'] != '' ? $today_no_of_garments[0]['total_no_of_garments_solid'] : 0);?>
            </span>
        </td>
    </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr style="background-color: rgba(179,238,255,0.88)">
        <th class="text-center" colspan="4"><span style="font-size: 22px;">PRINT</span></th>
    </tr>
    <tr>
        <th class="text-center"><span style="font-size: 20px;">LAY WIP</span></th>
        <th class="text-center"><span style="font-size: 20px;">CUT</span></th>
        <th class="text-center"><span style="font-size: 20px;">MARKER</span></th>
        <th class="text-center"><span style="font-size: 20px;">RATIO</span></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($lay_qty[0]['total_lay_qty_print'] != '' ? $lay_qty[0]['total_lay_qty_print'] : 0);?>
            </span>
        </td>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($today_cut[0]['today_cut_print_qty'] != '' ? $today_cut[0]['today_cut_print_qty'] : 0);?>
            </span>
        </td>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($today_no_of_marker[0]['total_no_of_marker_print_qty'] != '' ? $today_no_of_marker[0]['total_no_of_marker_print_qty'] : 0);?>
            </span>
        </td>
        <td class="text-center">
            <span style="font-size: 20px;">
                <?php echo ($today_no_of_garments[0]['total_no_of_garments_print'] != '' ? $today_no_of_garments[0]['total_no_of_garments_print'] : 0);?>
            </span>
        </td>
    </tr>
    </tbody>
</table>