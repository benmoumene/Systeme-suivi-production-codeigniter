<div class="col-md-12 well" id="tableWrap">
    <table class="table table-scroll table-striped" border="1">
        <thead>
        <tr>
            <th class="" colspan="6" style="width: 43.4%"></th>
            <th class="" colspan="3" style="text-align: center;">Cutting</th>
            <th class="" colspan="2" style="text-align: center;">Range</th>
            <th class="" colspan="4" style="text-align: center;">Sewing</th>
            <th class="" colspan="3" style="text-align: center;">Finishing</th>
        </tr>
        <tr>
            <th class="" style="width: 10%"><span data-toggle="tooltip" title="PO-ITEM">PO-ITEM</span></th>
            <th class=""><span data-toggle="tooltip" title="Brand">Brand</span></th>
            <th class="" style="width: 9.9%"><span data-toggle="tooltip" title="Style">STL</span></th>
            <th class="" style="width: 10%"><span data-toggle="tooltip" title="Quality-Color">QL-CLR</span></th>
            <th class=""><span data-toggle="tooltip" title="Order Qty">OQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Ex-Factory Date">ExFac</span></th>
            <th class=""><span data-toggle="tooltip" title="Cut QTY">CQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Cut Balance">CBQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Cut Pass QTY">CPQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Bundle Range">BR</span></th>
            <th class=""><span data-toggle="tooltip" title="Identity Number Range">INR</span></th>
            <th class=""><span data-toggle="tooltip" title="Line Input">IN</span></th>
            <th class=""><span data-toggle="tooltip" title="Collar Cuff">CC</span></th>
            <th class=""><span data-toggle="tooltip" title="Mid-Line Pass QTY">MPQ</span></th>
            <th class=""><span data-toggle="tooltip" title="End-Line Pass QTY">EPQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Wash QTY">WQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Packing QTY">PQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Packing Balance QTY">PBQ</span></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($prod_summary as $k => $v){
            if(($v['count_input_qty_line'] - $v['count_end_line_qc_pass']) != 0){
                ?>

                <tr>
                    <td class="" style="width: 10%"><span style="color: #727dff; cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');"><?php echo $v['purchase_order'].'-'.$v['item'];?></span></td>
                    <td class=""><?php echo $v['brand'];?></td>
                    <td class="" style="width: 9.9%"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                    <td class="" style="width: 10%"><?php echo $v['quality'].'-'.$v['color'];?></td>
                    <td class=""><?php echo $v['total_order_qty'];?></td>
                    <td class=""><?php echo $v['ex_factory_date'];?></td>
                    <td class=""><?php echo $v['total_cut_qty'];?></td>
                    <td class=""><?php echo $v['total_cut_qty']-$v['total_cut_input_qty'];?></td>
                    <td class=""><?php echo $v['total_cut_input_qty'];?></td>
                    <td class=""><span style="color: #ffffff;">'</span><?php echo $v['bundle_start'].'-'.$v['bundle_end'];?></td>
                    <td class=""><?php echo $v['min_care_label'].'-'.$v['max_care_label'];?></td>
                    <td class=""><?php echo $v['count_input_qty_line'];?></td>
                    <td class=""><?php echo $v['collar_cuff_bndl_qty'];?></td>
                    <td class=""><?php echo $v['count_mid_line_qc_pass'];?></td>
                    <td class=""><?php echo $v['count_end_line_qc_pass'];?></td>
                    <td class="" <?php if($v['wash_gmt'] == 1){ ?> style="background-color: #faff88;" <?php } ?>>
                        <?php echo $v['count_washing_pass'];?>
                    </td>
                    <td class=""><?php echo $v['count_packing_pass'];?></td>
                    <td class=""><a target="_blank" href="<?php echo base_url();?>dashboard/remainQtyStatus/<?php echo $v['po_no'];?>/<?php echo $v['purchase_order'];?>/<?php echo $v['item'];?>/4"><?php echo $v['total_cut_qty'] - $v['count_packing_pass'];?></a></td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>