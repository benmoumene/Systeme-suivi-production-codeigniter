<table border="1" width="100%">
    <thead>
    <tr style="background-color: rgba(159,255,154,0.41)">
        <th class="text-center"><span style="font-size: 28px;">LAY WIP</span></th>
        <th class="text-center"><span style="font-size: 28px;">TODAY LAY</span></th>
        <th class="text-center"><span style="font-size: 28px;">TODAY CUT</span></th>
        <th class="text-center"><span style="font-size: 28px;">MARKER</span></th>
        <th class="text-center"><span style="font-size: 28px;">RATIO</span></th>
        <th class="text-center" title="Today Ready Package"><span style="font-size: 28px;">CUT to SEW</span></th>
        <th class="text-center" title="Today Ready Package"><span style="font-size: 28px;">TODAY PACKAGE</span></th>
        <th class="text-center" title="Total Ready Package"><span style="font-size: 28px;">TOTAL STOCK</span></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th class="text-center"><span style="font-size: 25px;"><?php echo ($cut_dashboard_report[0]['total_lay_wip_qty'] != '' ? $cut_dashboard_report[0]['total_lay_wip_qty'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 25px;"><?php echo ($cut_dashboard_report[0]['today_lay_qty'] != '' ? $cut_dashboard_report[0]['today_lay_qty'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 25px;"><?php echo ($cut_dashboard_report[0]['today_cut_qty'] != '' ? $cut_dashboard_report[0]['today_cut_qty'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 25px;"><?php echo ($cut_dashboard_report[0]['total_no_of_marker_qty'] != '' ? $cut_dashboard_report[0]['total_no_of_marker_qty'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 25px;"><?php echo ($cut_dashboard_report[0]['total_no_of_garments'] != '' ? $cut_dashboard_report[0]['total_no_of_garments'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 25px;"><?php echo ($cut_dashboard_report[0]['today_input_to_line_qty'] != '' ? $cut_dashboard_report[0]['today_input_to_line_qty'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 25px;"><?php echo ($cut_dashboard_report[0]['today_package_ready_qty'] != '' ? $cut_dashboard_report[0]['today_package_ready_qty'] : 0);?></span></th>
        <th class="text-center"><span style="font-size: 25px;"><?php echo ($cut_dashboard_report[0]['cut_ready_qty'] != '' ? $cut_dashboard_report[0]['cut_ready_qty'] : 0);?></span></th>
    </tr>
    </tbody>
</table>