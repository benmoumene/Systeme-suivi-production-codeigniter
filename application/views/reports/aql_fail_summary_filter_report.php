<div class="col-md-12" id="tableWrap">


    <table class="table table-bordered table-striped" id="" border="1">
        <thead>
            <tr style="font-size: 20px;">
                <th class="hidden-phone center" colspan="12" style="background-color: rgba(216,114,94,0.88);">FAIL LIST</th>
            </tr>
            <tr style="font-size: 16px;">
                <th class="hidden-phone center">#</th>
                <th class="hidden-phone center">SO</th>
                <th class="hidden-phone center">PO</th>
                <th class="hidden-phone center">ITEM</th>
                <th class="hidden-phone center">QUALITY</th>
                <th class="hidden-phone center">COLOR</th>
                <th class="hidden-phone center">STYLE</th>
                <th class="hidden-phone center">STYLE NAME</th>
                <th class="hidden-phone center">BRAND</th>
                <th class="hidden-phone center">ExFac</th>
                <th class="hidden-phone center">ORDER QTY</th>
                <th class="hidden-phone center">AQL DATE</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $sl = 1;

            foreach($aql_fail_reports AS $f){ ?>
                <tr style="font-size: 16px;">
                    <td class="hidden-phone center"><?php echo $sl; $sl++;?></td>
                    <td class="hidden-phone center"><?php echo $f['so_no'];?></td>
                    <td class="hidden-phone center"><?php echo $f['purchase_order'];?></td>
                    <td class="hidden-phone center"><?php echo $f['item'];?></td>
                    <td class="hidden-phone center"><?php echo $f['quality'];?></td>
                    <td class="hidden-phone center"><?php echo $f['color'];?></td>
                    <td class="hidden-phone center"><?php echo $f['style_no'];?></td>
                    <td class="hidden-phone center"><?php echo $f['style_name'];?></td>
                    <td class="hidden-phone center"><?php echo $f['brand'];?></td>
                    <td class="hidden-phone center"><?php echo $f['approved_ex_factory_date'];?></td>
                    <td class="hidden-phone center"><?php echo $f['total_order_qty'];?></td>
                    <td class="hidden-phone center"><?php echo $f['aql_action_date'];?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>