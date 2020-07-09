                    <div class="block-web">

                        <div class="porlets-content">

                            <div class="table-responsive">
                                <table class="display table table-bordered table-striped" id="">
                                    <thead>
                                        <tr>
                                            <th class="hidden-phone center">PO-ITEM</th>
                                            <th class="hidden-phone center">Brand</th>
                                            <th class="hidden-phone center">STL</th>
                                            <th class="hidden-phone center">QL-CLR</th>
                                            <th class="hidden-phone center">Order Qty</th>
                                            <th class="hidden-phone center">ExFac</th>
                                            <th class="hidden-phone center">Status</th>
                                            <th class="hidden-phone center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($po_detail as $k => $v) {
                                            ?>
                                            <tr>
                                                <td class="hidden-phone center">
                                                    <?php
                                                    if($v['item'] != ''){
                                                        echo $v['purchase_order'] . '_' . $v['item'];
                                                    }else{
                                                        echo $v['purchase_order'];
                                                    }
                                                    ?>
                                                </td>
                                                <td class="hidden-phone center"><?php echo $v['brand']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['style_no'] . '-' . $v['style_name']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['quality'] . '-' . $v['color']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['order_qty']; ?></td>
                                                <td class="hidden-phone center"><?php echo $v['ex_factory_date']; ?></td>
                                                <td class="hidden-phone center">
                                                    <?php if($v['wash_gmt'] == 0){ echo '<h5><b>Non-Wash GMT</b></h5>'; } ?>
                                                    <?php if($v['wash_gmt'] == 1){ echo '<h5><b>Wash GMT</b></h5>'; } ?>
                                                </td>
                                                <td class="hidden-phone center">
                                                    <?php
                                                    if($v['item'] == ''){
                                                        $item = 'NA';
                                                    }else{
                                                        $item = $v['item'];
                                                    }
                                                    if($v['wash_gmt'] == 0){
                                                    ?>
                                                        <a href="<?php echo base_url();?>access/washGmtStatus/<?php echo $v['po_no'].'/'.$v['so_no'].'/'.$v['purchase_order'].'/'.$item.'/'.$v['quality'].'/'.$v['color'];?>/1" class="btn btn-primary">Wash</a>
                                                    <?php }

                                                    if($v['wash_gmt'] == 1){
                                                    ?>
                                                        <a href="<?php echo base_url();?>access/washGmtStatus/<?php echo $v['po_no'].'/'.$v['so_no'].'/'.$v['purchase_order'].'/'.$item.'/'.$v['quality'].'/'.$v['color'];?>/0" class="btn btn-warning">Non-Wash</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div><!--/table-responsive-->
                        </div>

                    </div><!--/porlets-content-->