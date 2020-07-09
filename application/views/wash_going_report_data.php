<div class="block-web">

    <div id="print_div">
    <div class="porlets-content">

        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="basic-table" border="1">
                <thead>
                    <tr>
                        <th class="hidden-phone center" colspan="10"><h3><b>Ecofab Ltd</b></h3></th>
                    </tr>
                    <tr>
                        <th class="hidden-phone center" colspan="10">228/1, Bypass Road, Jogitola, BRRI, Gazipur-1701<br /><h4>Date: <?php echo $date;?></h4></th>
                    </tr>
                    <tr>
                        <th class="hidden-phone center" colspan="10"><h4><b>WASH RECEIPT</b></h4></th>
                    </tr>
                    <tr>
                            <th class="hidden-phone center">PO</th>
                            <th class="hidden-phone center">ITEM</th>
                            <th class="hidden-phone center">BRAND</th>
                            <th class="hidden-phone center">STYLE</th>
                            <th class="hidden-phone center">QUALITY</th>
                            <th class="hidden-phone center">COLOR</th>
                            <th class="hidden-phone center">ORDER</th>
                            <th class="hidden-phone center">ALREADY WASHED</th>
                            <th class="hidden-phone center">QUANTITY</th>
                            <th class="hidden-phone center">BALANCE</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $balance = 0;
                $total_wash_going = 0;

                foreach($wash_going_report as $k => $v) {

                    $blnc = ($v['total_order_qty'] - ($v['already_went_wash_qty'] + $v['wash_going_qty']));

                    $balance = ($blnc < 0 ? 0 : $blnc);

                    $total_wash_going += $v['wash_going_qty'];

                ?>
                    <tr>
                        <td class="hidden-phone center"><?php echo $v['purchase_order']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['item']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['quality']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['color']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['total_order_qty']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['already_went_wash_qty']; ?></td>
                        <td class="hidden-phone center"><?php echo $v['wash_going_qty']; ?></td>
                        <td class="hidden-phone center"><?php echo $balance; ?></td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="" colspan="8" align="right"><h5><b>Total Wash Going</b></h5></td>
                        <td class="hidden-phone center"><h5><b><?php echo $total_wash_going;?></b></h5></td>
                        <td class=""></td>
                    </tr>
                </tfoot>
            </table>
            <br />
            <br />
            <br />
            <table class="" style="float: right;">
                <tr>
                    <td class="" colspan="6" style="text-align: right"><h4><b>Signature:</b></h4></td>
                    <td class="hidden-phone center" colspan="1" style="text-align: left">------------------------------------------</td>
                </tr>
            </table>
        </div><!--/table-responsive-->
        </div><!--/table-responsive-->
    </div>

</div><!--/porlets-content-->