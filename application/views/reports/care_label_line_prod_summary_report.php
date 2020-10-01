<div class="col-md-12 well1" id="tableWrap">
    <table class="table table-scroll table-striped" border="1" id="table_id">
        <thead>
        <tr style="background-color: #defa9e; font-size: 20px;">
            <th class="text-center" colspan="11" style="width: 55.2%;">RUNNING PO LIST</th>
            <th class="" colspan="3" style="text-align: center;">Cutting</th>
            <!--            <th class="" colspan="1" style="text-align: center;">Range</th>-->
            <th class="" colspan="5" style="text-align: center;">Sewing</th>
            <th class="" colspan="6" style="text-align: center;">Finishing</th>
        </tr>
        <tr>
            <th class="" style="width: 10%"><span data-toggle="tooltip" title="PO-ITEM">PO-ITEM</span></th>
            <th class=""><span data-toggle="tooltip" title="Sales Order">SO</span></th>
            <th class=""><span data-toggle="tooltip" title="Plan Lines">PL</span></th>
            <th class=""><span data-toggle="tooltip" title="Responsible Lines">Line</span></th>
            <th class=""><span data-toggle="tooltip" title="Sales Order">PO TYPE</span></th>
            <th class=""><span data-toggle="tooltip" title="Brand">Brand</span></th>
            <th class="" style="width: 9.7%"><span data-toggle="tooltip" title="Style">STL</span></th>
            <th class="" style="width: 10%"><span data-toggle="tooltip" title="Quality-Color">QL-CLR</span></th>
            <th class=""><span data-toggle="tooltip" title="Order Qty">OQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Ex-Factory Date">ExFac</span></th>
            <th class=""><span data-toggle="tooltip" title="Approved Ex-Factory">App. ExFac</span></th>
            <th class=""><span data-toggle="tooltip" title="Cut QTY">CQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Cut Balance">CBQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Cut Pass QTY">CPQ</span></th>
            <!--            <th class=""><span data-toggle="tooltip" title="Bundle Range">BR</span></th>-->
            <!--            <th class=""><span data-toggle="tooltip" title="Identity Number Range">INR</span></th>-->
            <th class=""><span data-toggle="tooltip" title="Line Input">IN</span></th>
            <th class=""><span data-toggle="tooltip" title="Collar ">Collar</span></th>
            <th class=""><span data-toggle="tooltip" title="Cuff">Cuff</span></th>
            <th class=""><span data-toggle="tooltip" title="Mid-Line Pass QTY">MPQ</span></th>
            <th class=""><span data-toggle="tooltip" title="End-Line Pass QTY">EPQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Wash Going QTY">WGQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Wash QTY">WQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Packing QTY">PQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Carton QTY">CTN</span></th>
            <th class=""><span data-toggle="tooltip" title="Warehouse QTY">WHQ</span></th>
            <th class=""><span data-toggle="tooltip" title="Balance QTY">BQ</span></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $cur_date = date('Y-m-d');
        $till_date = date("Y-m-d", strtotime("+ 30 days"));
        foreach($prod_summary as $k => $v){

            $total_finishing_wh_qa = $v['count_carton_pass'] + $v['total_wh_qa'];
            $total_wh_qa = $v['total_wh_qa'];

//            if(((($v['total_cut_qty'] - $total_finishing_wh_qa) != 0) && ($v['responsible_line'] != ''))){
//            if(($cur_date <= $v['ex_factory_date']) || ($till_date <= $v['ex_factory_date']) || (($v['total_cut_qty'] - $total_finishing_wh_qa) > 0)){

            $ship_date = $v['ex_factory_date'];
            $approved_ship_date = $v['approved_ex_factory_date'];

            $upcoming_month = date('Y-m-d', strtotime('+1 month'));

            if($v['balance'] > 0){

                ?>

                <tr>
                    <td class="" style="width: 10%; <?php if($v['status'] == 'CLOSE'){ ?> background-color: #ff481f; color: #fff;<?php } ?>">
                        <!--<span style="cursor: pointer;" onclick="getSizeWiseReport('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');">-->
                        <span>
                            <?php
                            if($v['item'] != ''){
                                echo $v['purchase_order'] . '_' . $v['item'];
                            }else{
                                echo $v['purchase_order'];
                            }
                            ?>
                        </span>
                    </td>
                    <td class=""><?php echo $v['so_no'];?></td>
                    <td class=""><?php echo $v['planned_lines'];?></td>
                    <td class=""><?php echo $v['responsible_line'];?></td>
                    <td class="">
                        <?php
                        if($v['po_type'] == 0){
                            echo 'BULK';
                        }
                        if($v['po_type'] == 1){
                            echo 'SIZE SET';
                        }
                        if($v['po_type'] == 2){
                            echo 'SAMPLE';
                        }
                        ?>
                    </td>
                    <td class=""><?php echo $v['brand'];?></td>
                    <td class="" style="width: 9.7%"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                    <td class="" style="width: 10%"><?php echo $v['quality'].'_'.$v['color'];?></td>
                    <td class=""><?php echo $v['total_order_qty'];?></td>
                    <td class="" <?php if($cur_date > $ship_date){ ?> style="background-color: #ff481f; color: #fff;" <?php } ?> >
                        <?php echo $ship_date;?>
                    </td>
                    <td class="" <?php if($cur_date > $approved_ship_date){ ?> style="background-color: #ff481f; color: #fff;" <?php } ?> >
                        <?php echo $approved_ship_date;?>
                    </td>
                    <td class=""><?php echo $v['total_cut_qty'];?></td>
                    <td class=""><?php echo $v['total_cut_qty']-$v['total_cut_input_qty'];?></td>
                    <td class=""><?php echo $v['total_cut_input_qty'];?></td>
                    <!--                    <td class=""><span style="color: #ffffff;">'</span>--><?php //echo $v['bundle_start'].'-'.$v['bundle_end'];?><!--</td>-->
                    <!--                    <td class="" title="Bundles: --><?php //echo $v['bundle_start'].'-'.$v['bundle_end'];?><!--">--><?php //echo $v['min_care_label'].'-'.$v['max_care_label'];?><!--</td>-->
                    <td class="">
                        <?php echo $v['count_input_qty_line'];?>
                    </td>
                    <td class=""><?php echo $v['collar_bndl_qty'];?></td>
                    <td class=""><?php echo $v['cuff_bndl_qty'];?></td>
                    <td class=""><?php echo $v['count_mid_line_qc_pass'];?></td>
                    <td class=""><?php echo $v['count_end_line_qc_pass'];?></td>
                    <td class=""><?php echo $v['count_washing_qty'];?></td>
                    <td class="" <?php if($v['wash_gmt'] == 1){ ?> style="background-color: #faff88;" <?php } ?>>
                        <?php echo $v['count_washing_pass'];?>
                    </td>
                    <td class=""><?php echo $v['count_packing_pass'];?></td>
                    <td class=""><?php echo $v['count_carton_pass'];?></td>
                    <td class="" style="cursor: pointer;" onclick="getWarehousePcs('<?php echo $v['po_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');" data-target="#myModal3" data-toggle="modal" ><?php echo $total_wh_qa;?></td>
                    <!--                    <td class=""><a target="_blank" href="--><?php //echo base_url();?><!--dashboard/remainQtyStatus/--><?php //echo $v['po_no'];?><!--/--><?php //echo $v['purchase_order'];?><!--/--><?php //echo $item;?><!--/4">--><?php //echo $v['total_cut_qty'] - $total_finishing_wh_qa;?><!--</a></td>-->
                    <td class="">
                        <span class="center btn btn-danger" data-target="#myModal2" data-toggle="modal" onclick="getPoItemWiseRemainCL('<?php echo $v['po_no']; ?>', '<?php echo $v['so_no']; ?>', '<?php echo $v['purchase_order'];?>','<?php echo $v['item'];?>', '<?php echo $v['quality']; ?>', '<?php echo $v['color']; ?>');">
                        <?php echo $v['total_cut_qty'] - $total_finishing_wh_qa;?>
                        </span>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>