<!--\\\\\\\ contentpanel start\\\\\\-->
    <div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
            <h1>Line Input Report </h1>
            <h2 class="">Line Input Report...</h2>
        </div>
        <div class="pull-right">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">DASHBOARD</a></li>
                <li class="active">Line Input Report</li>
            </ol>
        </div>
    </div>
    <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
<!--        <div class="row">-->
<!--            <div class="form-group">-->
<!--                <div class="col-md-12">-->
<!--                <div class="col-md-3">-->
<!--                    <div class="form-group">-->
<!--                        <select required class="form-control" id="po_no" name="po_no" onchange="getReportByPo(id);">-->
<!--                                <option value="">Select PO No...</option>-->
<!--                            --><?php
//                                foreach ($purchase_order_nos as $pos){ ?>
<!--                                    <option value="--><?php //echo $pos['purchase_order'].'_'.$pos['item'].'_'.$pos['color'];?><!--">--><?php //echo $pos['purchase_order'].'-'.$pos['item'].'-'.$pos['color'];?><!--</option>-->
<!--                            --><?php
//                                }
////                            ?>
<!--                        </select>-->
<!--                        <span style="font-size: 11px;">* Select PO No.</span>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <br />-->

        <div class="row" id="report_content">
            <div class="col-lg-12">
                <section class="panel default blue_title h2">

                    <div class="panel-body">

                        <table class="display table table-bordered table-striped" id="dynamic-table" style="font-size: 23px;">
                            <thead>
                            <tr>
                                <th class="center">PO-ITEM</th>
                                <th class="center">Brand</th>
                                <th class="center">CL No</th>
                                <th class="center">QLTY</th>
                                <th class="center">STL</th>
                                <th class="center">Size</th>
                                <th class="center">Color</th>
                                <th class="center">Bundle Track No.</th>
                                <th class="center">BR</th>
                                <th class="center">Line</th>
                                <th class="center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($remain_detail as $v){
                                $line_id = $v['line_id'];
                                $line_name = $v['line_name'];
                                $pc_tracking_no = $v['pc_tracking_no'];
                                $purchase_order = $v['purchase_order'];
                                $item = $v['item'];
                                $quality = $v['quality'];
                                $style_no = $v['style_no'];
                                $style_name = $v['style_name'];
                                $brand = $v['brand'];
                                $size = $v['size'];
                                $color = $v['color'];
                                $bundle_tracking_no = $v['bundle_tracking_no'];
                                $bundle_range = $v['bundle_range'];
                                $sent_to_production = $v['sent_to_production'];
                                $is_printed = $v['is_printed'];
                                $access_points = $v['access_points'];
                                $access_points_status = $v['access_points_status'];

                                ?>
                                <tr>
                                    <td class="center"><?php echo $purchase_order.'-'.$item;?></td>
                                    <td class="center"><?php echo $brand;?></td>
<!--                                    <td class="center">--><?php //echo $pc_tracking_no?><!--</td>-->
                                    <td class="center">
                                        <?php if($access_points_status == 2){ ?>
                                            <a href="<?php echo base_url();?>dashboard/viewClDefects/<?php echo $pc_tracking_no;?>/<?php echo $line_id;?>/<?php echo $access_points;?>" target="_blank"><?php echo $pc_tracking_no;?></a>
                                        <?php }else{?>
                                            <?php echo $pc_tracking_no;?>
                                        <?php } ?>
                                    </td>
                                    <td class="center"><?php echo $quality?></td>
                                    <td class="center"><?php echo $style_no.'-'.$style_name;?></td>
                                    <td class="center"><?php echo $size?></td>
                                    <td class="center"><?php echo $color?></td>
                                    <td class="center"><?php echo $bundle_tracking_no?></td>
                                    <td class="center"><?php echo $bundle_range?></td>
                                    <td class="center"><?php echo $line_name?></td>
                                    <td class="center">
                                        <?php
                                        if(($access_points != 0)){
                                            if(($access_points==1) && ($access_points_status==1)){
                                                echo 'Cutting Pass';
                                            }elseif (($access_points==2) && ($access_points_status==1)){
                                                echo 'Input Pass';
                                            }elseif (($access_points==3) && ($access_points_status==1)){
                                                echo 'Mid Pass';
                                            }elseif (($access_points==3) && ($access_points_status==2)){
                                                echo 'Mid QC';
                                            }elseif (($access_points==4) && ($access_points_status<4)){
                                                echo 'End QC';
                                            }
//                                                elseif(($access_points==4) && ($access_points_status==4) && ($finishing_qc_status != 1)){
//                                                    echo 'End Pass/Wash/Finishing';
//                                                }
                                            elseif(($access_points==4) && ($access_points_status==4) && ($washing_status != 1) && ($packing_status != 1)){
                                                echo 'End Pass';
                                            }
                                            elseif(($access_points==4) && ($access_points_status==4) && ($washing_status == 1) && ($packing_status != 1)){
                                                echo 'End Pass & Washed';
                                            }

                                        }elseif($sent_to_production != 1){
                                            echo 'Cutting';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>

        </div>
    <!--\\\\\\\ container  end \\\\\\-->

<script type="text/javascript">
//    $('select').select2();

//        setTimeout(function(){
//            window.location.reload(1);
//        }, 3000);
</script>