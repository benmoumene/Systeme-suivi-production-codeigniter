<br />
<div class="row">
    <div class="col-md-1">
        <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
    </div>
    <div class="col-md-1">
        <button type="button" onclick="printDiv('print_div')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print</button>
    </div>
    <div class="col-md-8"></div>
    <div class="col-md-2">
        <a href="<?php echo base_url();?>dashboard/cuttingTableWiseReport/<?php echo $date?>" target="_blank" class="btn btn-warning">Table Wise Chart</a>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12" id="print_div">
        <div class="block-web" id="tableWrap" style="overflow-x:auto;">
            <table class="display table table-bordered table-striped" id="" border="1">
                <thead>
                    <tr>
                        <th class="hidden-phone center" colspan="11"><h4>Cutting Report</h4></th>
                        <th class="hidden-phone center" colspan="2"><h4><?php echo $date;?></h4></th>
                    </tr>
                    <tr style="font-size: 16px;">
                        <th class="hidden-phone center">Group SO</th>
                        <th class="hidden-phone center">SO</th>
                        <th class="hidden-phone center">Brand</th>
                        <th class="hidden-phone center">Purchase Order</th>
                        <th class="hidden-phone center">Item</th>
                        <th class="hidden-phone center">Style</th>
                        <th class="hidden-phone center">Quality</th>
                        <th class="hidden-phone center">Color</th>
                        <th class="hidden-phone center">Ex-Fac</th>
                        <th class="hidden-phone center">Order</th>
                        <th class="hidden-phone center">Balance to Cut</th>
                        <th class="hidden-phone center">Lay</th>
                        <th class="hidden-phone center">Cut</th>
                    </tr>
                </thead>

                <tbody>
                <?php

                $total_order_qty = 0;
                $total_lay_complete_cut_pending_qty = 0;
                $total_lay_qty = 0;
                $total_cut_qty = 0;
                $total_package_ready_qty = 0;

                foreach ($cut_report as $v){
                $total_order_qty += $v['total_order_qty'];
                $total_lay_complete_cut_pending_qty += $v['lay_complete_cut_pending_qty'];
                $total_lay_qty += $v['lay_complete_qty'];
                $total_cut_qty += $v['cut_complete_qty'];
                $total_package_ready_qty += $v['package_ready_qty'];
                ?>
                    <tr>
                        <td class="center"><?php echo $v['po_no'];?></td>
                        <td class="center"><?php echo $v['so_no'];?></td>
                        <td class="center"><?php echo $v['brand'];?></td>
                        <td class="center"><?php echo $v['purchase_order'];?></td>
                        <td class="center"><?php echo $v['item'];?></td>
                        <td class="center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                        <td class="center"><?php echo $v['quality'];?></td>
                        <td class="center"><?php echo $v['color'];?></td>
                        <td class="center"><?php echo $v['ex_factory_date']; ?></td>
                        <td class="center"><?php echo $v['total_order_qty'];?></td>
                        <td class="center">
                            <a href="<?php echo base_url();?>dashboard/getBalanceToCutDetailReport/<?php echo $v['po_no'];?>" target="_blank"><?php echo $v['lay_complete_cut_pending_qty'];?></a>
                        </td>
                        <td class="center"><?php echo $v['lay_complete_qty'];?></td>
                        <td class="center"><?php echo $v['cut_complete_qty'];?></td>
                    </tr>

                    <?php
                    }
                    ?>

                </tbody>

                <tfoot>
                    <tr>
                        <td class="" align="right" colspan="10"><h5><b>Total Qty</b></h5></td>
                        <td class="center"><h5><b><?php echo $total_lay_complete_cut_pending_qty;?></b></h5></td>
                        <td class="center"><h5><b><?php echo $total_lay_qty;?></b></h5></td>
                        <td class="center"><h5><b><?php echo $total_cut_qty;?></b></h5></td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
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
    }
</script>