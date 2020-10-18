<br />
<button type="button" onclick="printDiv('print_div')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print</button>
<button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
<br />
<div id="print_div">
    <div class="col-md-12" id="table_content" style="overflow-x:auto;">
        <table class="table table-bordered table-striped" id="" border="1">
            <thead>
            <tr>
                <th class="hidden-phone center" colspan="12"><h3><?php echo $title;?></h3></th>
            </tr>
            <tr>
                <th class="hidden-phone center">SO</th>
                <th class="hidden-phone center">PO</th>
                <th class="hidden-phone center">Item</th>
                <th class="hidden-phone center">Style</th>
                <th class="hidden-phone center">Quality</th>
                <th class="hidden-phone center">Color</th>
                <th class="hidden-phone center">Ex-fac</th>
                <th class="hidden-phone center">Order</th>
                <th class="hidden-phone center">AQL Plan</th>
                <th class="hidden-phone center">AQL Offer</th>
                <th class="hidden-phone center">AQL Status</th>
                <th class="hidden-phone center">Remarks</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $sew_balance_qty = 0;
            $balance_qty = 0;
            $packing_balance_qty = 0;

            $total_order_qty = 0;
            $total_cut_qty = 0;
            $total_cut_pass_qty = 0;
            $total_line_output_qty = 0;
            $total_line_output_balance_qty = 0;
            $total_washed_qty = 0;
            $total_packing_qty = 0;
            $total_packing_balance_qty = 0;
            $total_carton_qty = 0;
            $total_wh_qty = 0;
            $total_other_qty = 0;
            $total_balance_qty = 0;

            foreach ($aql_detail_today as $v){

                $total_order_qty += $v['total_order_qty'];

                ?>
                <tr>
                    <td class="center"><?php echo $v['so_no'];?></td>
                    <td class="center"><?php echo $v['purchase_order'];?></td>
                    <td class="center"><?php echo $v['item'];?></td>
                    <td class="center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                    <td class="center"><?php echo $v['quality'];?></td>
                    <td class="center"><?php echo $v['color'];?></td>
                    <td class="center"><?php echo $v['ex_factory_date'];?></td>
                    <td class="center"><?php echo $v['total_order_qty'];?></td>
                    <td class="center"><?php echo $v['aql_plan_date'];?></td>
                    <td class="center"><?php echo $v['aql_offer_date'];?></td>
                    <td class="center"
                        style="background-color:
                        <?php
                        if($v['aql_status'] == 0){
                            echo 'Gold';
                        }
                        elseif($v['aql_status'] == 1){
                            echo 'green';
                        }
                        elseif($v['aql_status'] == 2){
                            echo 'Salmon';
                        }
                        ?>"
                        title="<?php echo "Fail Count: ".($v['so_fail_count'] != '' ? $v['so_fail_count'] : 0);?>">
                        <?php
                        if($v['aql_status'] == 0) {
                            echo "Pending";
                        }
                        if($v['aql_status'] == 1){
                            echo 'Pass';
                        }
                        if($v['aql_status'] == 2){
                            echo 'Fail';
                        }
                        ?>
                    </td>
                    <td class="center"><?php echo $v['aql_remarks'];?></td>

                </tr>
                <?php
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7" align="right"><h4><b>Total</b></h4></td>
                <td class="center"><h4><b><?php echo $total_order_qty;?></b></h4></td>
                <td colspan="4" align="right"><h4><b></b></h4></td>

            </tr>
            </tfoot>
        </table>
    </div>
</div>

<script type="text/javascript">
    $('select').select2();

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#table_content').html())
            location.href=url
            return false
        })
    })



    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        location.reload();
    }


</script>