<div class="col-md-12" id="tableWrap">
    <table class="table table-bordered table-striped" id="" border="1">
        <thead>
            <tr style="font-size: 20px;">
                <th class="hidden-phone center" rowspan="2">Brand</th>
                <th class="hidden-phone center" rowspan="2">ETD</th>
                <th class="hidden-phone center" colspan="5" style="background-color: rgba(105,216,138,0.88);">Today AQL Status</th>
                <th class="hidden-phone center" colspan="7" style="background-color: rgba(180,216,28,0.88);">PO CLOSING STATUS</th>
            </tr>
            <tr style="font-size: 16px;">
                <th class="hidden-phone center">Plan</th>
                <th class="hidden-phone center">Offer</th>
                <th class="hidden-phone center">Pass</th>
                <th class="hidden-phone center">Fail</th>
                <th class="hidden-phone center">Blnc</th>
                <th class="hidden-phone center">Total PO</th>
                <th class="hidden-phone center">Ready for AQL</th>
                <th class="hidden-phone center">Offered AQL</th>
                <th class="hidden-phone center">Pass</th>
                <th class="hidden-phone center">Fail</th>
                <th class="hidden-phone center">Offer Blnc</th>
                <th class="hidden-phone center">Closing Blnc</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($aql_reports AS $v){


                $today_planned_po = ($v['today_planned_po'] != '' ? $v['today_planned_po'] : 0);
                $today_plan_order_qty = ($v['today_plan_order_qty'] != '' ? $v['today_plan_order_qty'] : 0);
                $today_offered_po = ($v['today_offered_po'] != '' ? $v['today_offered_po'] : 0);
                $today_offered_order_qty = ($v['today_offered_order_qty'] != '' ? $v['today_offered_order_qty'] : 0);
                $today_passed_po = ($v['today_passed_po'] != '' ? $v['today_passed_po'] : 0);
                $today_passed_order_qty = ($v['today_passed_order_qty'] != '' ? $v['today_passed_order_qty'] : 0);
                $today_failed_po = ($v['today_failed_po'] != '' ? $v['today_failed_po'] : 0);
                $today_failed_order_qty = ($v['today_failed_order_qty'] != '' ? $v['today_failed_order_qty'] : 0);

                $today_plan_vs_balance = $today_planned_po-($today_passed_po+$today_failed_po);
                $today_plan_vs_balance = ($today_plan_vs_balance > 0 ? $today_plan_vs_balance : 0);
                $today_plan_vs_balance_order_qty = $today_plan_order_qty-($today_passed_order_qty+$today_failed_order_qty);
                $today_plan_vs_balance_order_qty = ($today_plan_vs_balance_order_qty > 0 ? $today_plan_vs_balance_order_qty : 0);

                $total_po = ($v['total_po'] != '' ? $v['total_po'] : 0);
                $total_order_qty = ($v['total_order_qty'] != '' ? $v['total_order_qty'] : 0);
                $total_ready_for_aql_po = ($v['total_ready_for_aql_po'] != '' ? $v['total_ready_for_aql_po'] : 0);
                $total_ready_for_aql_order_qty = ($v['total_ready_for_aql_order_qty'] != '' ? $v['total_ready_for_aql_order_qty'] : 0);
                $total_offered_aql_po = ($v['total_offered_aql_po'] != '' ? $v['total_offered_aql_po'] : 0);
                $total_offered_aql_order_qty = ($v['total_offered_aql_order_qty'] != '' ? $v['total_offered_aql_order_qty'] : 0);
                $total_passed_aql_po = ($v['total_passed_aql_po'] != '' ? $v['total_passed_aql_po'] : 0);
                $total_passed_aql_order_qty = ($v['total_passed_aql_order_qty'] != '' ? $v['total_passed_aql_order_qty'] : 0);
                $total_failed_aql_po = ($v['total_failed_aql_po'] != '' ? $v['total_failed_aql_po'] : 0);
                $total_failed_aql_order_qty = ($v['total_failed_aql_order_qty'] != '' ? $v['total_failed_aql_order_qty'] : 0);

                $total_po_offer_balance = $total_po-$total_offered_aql_po;
                $total_po_offer_balance = ($total_po_offer_balance > 0 ? $total_po_offer_balance : 0);
                $total_po_offer_balance_order_qty = $total_order_qty-$total_offered_aql_order_qty;
                $total_po_offer_balance_order_qty = ($total_po_offer_balance_order_qty > 0 ? $total_po_offer_balance_order_qty : 0);

                $total_po_closing_balance = $total_po-$total_ready_for_aql_po;
                $total_po_closing_balance = ($total_po_closing_balance > 0 ? $total_po_closing_balance : 0);
                $total_po_closing_balance_order_qty = $total_order_qty-$total_ready_for_aql_order_qty;
                $total_po_closing_balance_order_qty = ($total_po_closing_balance_order_qty > 0 ? $total_po_closing_balance_order_qty : 0);
            ?>
                <tr>
                    <td class="hidden-phone center"><?php echo $v['brand'];?></td>
                    <td class="hidden-phone center"><?php echo $v['approved_ex_factory_date'];?></td>
                    <td class="hidden-phone center"><?php echo $today_planned_po.' ('.$today_plan_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $today_offered_po.' ('.$today_offered_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $today_passed_po.' ('.$today_passed_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $today_failed_po.' ('.$today_failed_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $today_plan_vs_balance.' ('.$today_plan_vs_balance_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $total_po.' ('.$total_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $total_ready_for_aql_po.' ('.$total_ready_for_aql_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $total_offered_aql_po.' ('.$total_offered_aql_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $total_passed_aql_po.' ('.$total_passed_aql_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $total_failed_aql_po.' ('.$total_failed_aql_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $total_po_offer_balance.' ('.$total_po_offer_balance_order_qty.')';?></td>
                    <td class="hidden-phone center"><?php echo $total_po_closing_balance.' ('.$total_po_closing_balance_order_qty.')';?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>