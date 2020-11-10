<?php
$total_size_qty = 0;
$total_cut_qty = 0;
$total_sew_size_qty = 0;
$total_pack_size_qty = 0;
$total_pack_balance_from_order = 0;
$total_pack_balance_from_cut = 0;
$total_carton_size_qty = 0;
$total_carton_balance_from_order = 0;
$total_carton_balance_from_cut = 0;
$total_manually_closed_qty = 0;
$total_wh_size_qty = 0;

//foreach ($order_info as $v){
$so_no = $order_info[0]['so_no'];
$po_no = $order_info[0]['po_no'];
$purchase_order = $order_info[0]['purchase_order'];
$item = $order_info[0]['item'];
$style_no = $order_info[0]['style_no'];
$style_name = $order_info[0]['style_name'];
$quality = $order_info[0]['quality'];
$color = $order_info[0]['color'];
$status = $order_info[0]['status'];
$ex_factory_date = $order_info[0]['ex_factory_date'];
$order_quality = $order_info[0]['order_quantity'];
$cut_qty = $order_info[0]['total_cut_qty'];
$count_total_packing_qty = $order_info[0]['total_packing_qty'];
$count_total_carton_qty = $order_info[0]['total_carton_qty'];
$po_closing_date = $order_info[0]['po_closing_date'];
$total_wh_qty = $order_info[0]['total_wh_qty'];
$count_unscanned_pc = $cut_qty - ($count_total_carton_qty + $total_wh_qty);

//$cut_order = $this->method_call->poWiseCartonInfo($so_no, $po_no, $purchase_order, $item, $style_no, $quality, $color);

?>
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel1"></h4>
                </div>

                <div class="modal-body">
                    <div class="col-md-3 scroll4">
                        <div class="porlets-content">
                            <div class="table-responsive" id="wh_cl_list">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
                </div>

            </div>
        </div>
    </div>
    <br />
    <button type="button" onclick="printDiv('print_div')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print</button>
    <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
    <br />
    <div id="print_div">
    <div class="col-lg-8" id="tableWrap">
        <section class="panel default blue_title h2">

            <div class="panel-body">

                <table class="table" border="1">
                    <thead>
                    <tr>
                        <th class="center">Group SO</th>
                        <th class="center">SO</th>
                        <th class="center">Purchase Order</th>
                        <th class="center">ITEM/WEEK</th>
                        <th class="center">STYLE</th>
                        <th class="center">QUALITY-COLOR</th>
                        <th class="center">Ex-Fac Date</th>
                        <th class="center">Status</th>
<!--                        <th class="center">ORDERED</th>-->
                        <!--                        <th class="center">Cut</th>-->
                        <!--                        <th class="center">Packed</th>-->
                        <!--                        <th class="center">Carton</th>-->
                        <!--                        <th class="center">Balance</th>-->
                        <!--                        <th class="center">PO Closing Date</th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="center"><?php echo $po_no;?></td>
                        <td class="center">
                            <a href="<?php echo base_url();?>dashboard/getPieceByPieceDetailBySo/<?php echo $so_no;?>" target="_blank"><?php echo $so_no;?></a>
                        </td>
                        <td class="center"><?php echo $purchase_order;?></td>
                        <td class="center"><?php echo $item;?></td>
                        <td class="center"><?php echo $style_no.'-'.$style_name;?></td>
                        <td class="center"><?php echo $quality.'-'.$color;?></td>
                        <td class="center"><?php echo $ex_factory_date;?></td>
                        <td class="center"><?php echo $status;?></td>
<!--                        <td class="center">--><?php //echo $order_quality;?><!--</td>-->
                        <!--                        <td class="center">--><?php //echo $cut_qty;?><!--</td>-->
                        <!--                        <td class="center">--><?php //echo $count_total_packing_qty;?><!--</td>-->
                        <!--                        <td class="center">--><?php //echo $count_total_carton_qty;?><!--</td>-->
                        <!--                        <td class="center">--><?php //echo $count_unscanned_pc;?><!--</td>-->
                        <!--                        <td class="center">-->
                        <!--                            --><?php
                        //                            if($order_quality <= $count_total_carton_qty) {
                        //                                echo $po_closing_date;
                        //                            } else{
                        //                                echo '';
                        //                            }
                        //                            ?>
                        <!--                        </td>-->
                    </tr>
                    </tbody>
                </table>
                <br />
                <table class="table" border="1">
                    <thead>
                    <tr>
                        <th class="center">Size</th>
                        <th class="center">Ordered</th>
                        <th class="center">Cut</th>
                        <th class="center">Cut Pass</th>
                        <th class="center">Sew</th>
                        <th class="center">Packed</th>
                        <th class="center">Pack Blnc(Order)</th>
                        <th class="center">Pack Blnc(Cut)</th>
                        <th class="center">Carton</th>
                        <th class="center">Carton Blnc(Order)</th>
                        <th class="center">Carton Blnc(Cut)</th>
                        <th class="center">Close by Admin</th>
<!--                        <th class="center">Warehouse Qty</th>-->
                    </tr>
                    </thead>
                    <tbody>
<!--                    --><?php //foreach ($cut_order as $v_1){ ?>
                    <?php

                    $pack_balance_from_order = 0;
                    $pack_balance_from_cut = 0;
                    $carton_balance_from_order = 0;
                    $carton_balance_from_cut = 0;

                    foreach ($order_info as $v_1){

                        $pack_balance_from_order = $v_1['total_packing_qty'] - $v_1['order_qty'];
                        $pack_balance_from_cut = $v_1['total_packing_qty'] - $v_1['cut_qty'];

                        $total_pack_balance_from_order += $pack_balance_from_order;
                        $total_pack_balance_from_cut += $pack_balance_from_cut;

                        $carton_balance_from_order = $v_1['total_carton_qty'] - $v_1['order_qty'];
                        $carton_balance_from_cut = $v_1['total_carton_qty'] - $v_1['cut_qty'];

                        $total_carton_balance_from_order += $carton_balance_from_order;
                        $total_carton_balance_from_cut += $carton_balance_from_cut;
                    ?>
                        <tr style="background-color: #aeff82;<?php  ?>">
<!--                        <tr>-->
                            <td class="center"><?php echo $v_1['size'];?></td>
                            <td class="center"><?php echo $order_qty = $v_1['order_qty'];?></td>

                            <td class="center" <?php if($v_1['order_qty'] > $v_1['cut_qty'])
                            { ?> style="background-color: #ff8080;" <?php } ?>>
                                <?php echo $v_1['cut_qty']; ?>
                            </td>

                            <td class="center" <?php if($v_1['order_qty'] > $v_1['cut_pass_qty'])
                            { ?> style="background-color: #ff8080;" <?php } ?>>
                               <?php echo $v_1['cut_pass_qty']; ?>
                            </td>

                            <td class="center" <?php if($v_1['order_qty'] > $v_1['sew_qty'])
                            { ?> style="background-color: #ff8080;" <?php } ?>>
                                <?php echo $v_1['sew_qty']; ?>
                            </td>

                            <td class="center" <?php if($v_1['order_qty'] > $v_1['total_packing_qty'])
                            { ?> style="background-color: #ff8080;" <?php } ?>>
                                <?php echo $v_1['total_packing_qty']; ?>
                            </td>

                            <td class="center" <?php if($pack_balance_from_order < 0)
                            { ?> style="background-color: #ff8080;" <?php } ?>>
                                <?php echo $pack_balance_from_order; ?>
                            </td>

                            <td class="center" <?php if($pack_balance_from_cut < 0)
                            { ?> style="background-color: #ff8080;" <?php } ?>>
                                <?php echo $pack_balance_from_cut; ?>
                            </td>

                            <td class="center" <?php if($v_1['order_qty'] > $v_1['total_carton_qty'])
                            { ?> style="background-color: #ff8080;" <?php } ?>>
                                <?php echo $v_1['total_carton_qty']; ?>
                            </td>


                            <td class="center" <?php if($carton_balance_from_order < 0)
                            { ?> style="background-color: #ff8080;" <?php } ?>>
                                <?php echo $carton_balance_from_order; ?>
                            </td>

                            <td class="center" <?php if($carton_balance_from_cut < 0)
                            { ?> style="background-color: #ff8080;" <?php } ?>>
                                <?php echo $carton_balance_from_cut; ?>
                            </td>

                            <td class="center" <?php if($v_1['order_qty'] > $v_1['total_carton_qty'])
                            { ?> style="background-color: yellow;" <?php } ?>>
                                <?php echo $v_1['total_manually_closed_qty']; ?>
                            </td>

                        </tr>
                        <?php
                        $total_size_qty += $v_1['order_qty'];
                        $total_cut_qty += $v_1['cut_qty'];
                        $total_cut_pass_qty += $v_1['cut_pass_qty'];
                        $total_sew_size_qty += $v_1['sew_qty'];
                        $total_pack_size_qty += $v_1['total_packing_qty'];
                        $total_carton_size_qty += $v_1['total_carton_qty'];
                        $total_manually_closed_qty += $v_1['total_manually_closed_qty'];
                        $total_wh_size_qty += $v_1['total_wh_qty'];
                    } ?>
                    </tbody>
                    <tfoot>
                    <tr style="background-color: #faffc5; font-weight: 700; font-size: 15px;">
                        <td class="center">Total</td>
                        <td class="center"><?php echo $total_size_qty;?></td>
                        <td class="center"><?php echo $total_cut_qty;?></td>
                        <td class="center"><?php echo $total_cut_pass_qty;?></td>
                        <td class="center"><?php echo $total_sew_size_qty;?></td>
                        <td class="center"><?php echo $total_pack_size_qty;?></td>
                        <td class="center"><?php echo $total_pack_balance_from_order;?></td>
                        <td class="center"><?php echo $total_pack_balance_from_cut;?></td>
                        <td class="center"><?php echo $total_carton_size_qty;?></td>
                        <td class="center"><?php echo $total_carton_balance_from_order;?></td>
                        <td class="center"><?php echo $total_carton_balance_from_cut;?></td>
                        <td class="center"><?php echo $total_manually_closed_qty;?></td>
<!--                        <td class="center">--><?php //echo $total_wh_size_qty;?><!--</td>-->
                    </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>
    </div>
<?php
//}
?>
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

        location.reload();
    }

</script>
