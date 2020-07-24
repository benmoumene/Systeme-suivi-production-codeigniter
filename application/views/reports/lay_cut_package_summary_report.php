<table border="1" width="100%">
    <thead>
    <tr style="background-color: rgba(159,255,154,0.41)">
        <th class="text-center"><span style="font-size: 25px;">LAY WIP</span></th>
        <th class="text-center"><span style="font-size: 25px;">TODAY CUT</span></th>
        <th class="text-center"><span style="font-size: 25px;">MARKER</span></th>
        <th class="text-center"><span style="font-size: 25px;">RATIO</span></th>
        <th class="text-center" title="Today Ready Package"><span style="font-size: 25px;">TODAY PACKAGE(STOCK)</span></th>
        <th class="text-center" title="Total Ready Package"><span style="font-size: 25px;">TOTAL PACKAGE(STOCK)</span></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th class="text-center"><span style="font-size: 22px;"><?php echo ($lay_qty[0]['total_lay_qty'] != '' ? $lay_qty[0]['total_lay_qty'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 22px;"><?php echo ($today_cut[0]['today_cut_qty'] != '' ? $today_cut[0]['today_cut_qty'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 22px;"><?php echo ($today_no_of_marker[0]['total_no_of_marker_qty'] != '' ? $today_no_of_marker[0]['total_no_of_marker_qty'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 22px;"><?php echo ($today_no_of_garments[0]['total_no_of_garments'] != '' ? $today_no_of_garments[0]['total_no_of_garments'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 22px;"><?php echo ($today_cut_ready_package[0]['today_package_ready_qty'] != '' ? $today_cut_ready_package[0]['today_package_ready_qty'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 22px;"><?php echo ($cut_ready_package[0]['cut_ready_qty'] != '' ? $cut_ready_package[0]['cut_ready_qty'] : 0);?></span></th>
    </tr>
    </tbody>
</table>