<table class="display table table-bordered table-striped" id="sample_2">
    <thead>
        <tr>
            <th class="center">Size</th>
            <?php foreach ($po_item as $v_po){ ?>
                <th class="center"><?php echo $v_po['purchase_order'].'-'.$v_po['item']?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sizes as $v_s){ ?>
            <tr>
                <td class="center"><?php echo $v_s['size'];?></td>
                <?php foreach ($po_item as $v_po){

                    $po_item_size_cut_qty = $this->method_call->getSizeWisePoItemRemainCutQty($sales_order, $v_po['purchase_order'], $v_po['item'], $v_s['size']);

//                    echo '<pre>';
//                    print_r(sizeof($po_item_size_cut_qty));
//                    echo '</pre>';

                    if(sizeof($po_item_size_cut_qty) == 0){ ?>
                        <td class="center"></td>
                    <?php }

                    foreach ($po_item_size_cut_qty as $v_s_qty){
                        $po_item_size_wise_order_qty = ($v_s_qty['po_item_size_wise_order_qty'] == '' ? 0 : $v_s_qty['po_item_size_wise_order_qty']);
                        $po_item_size_wise_cut_qty = ($v_s_qty['po_item_size_wise_cut_qty'] == '' ? 0 : $v_s_qty['po_item_size_wise_cut_qty']);
                    ?>
                    <td class="center">
                        <?php echo $po_item_size_wise_order_qty - $po_item_size_wise_cut_qty;?>
                    </td>
                <?php
                    }
                }
                ?>
            </tr>
        <?php } ?>
    </tbody>

</table>