<!DOCTYPE html>
<html>
<head>
    <title>Bundle - <?php

        if($part_name=='collar_outer'){
            echo 'COLLAR_OUTER';
        }
        if($part_name=='cuff_outer'){
            echo 'CUFF_OUTER';
        }
        if($part_name=='back'){
            echo 'BACK';
        }
        if($part_name=='front_l'){
            echo 'FRONT_L';
        }
        if($part_name=='front_r'){
            echo 'FRONT_R';
        }
        if($part_name=='yoke_upper'){
            echo 'YOKE_OUTER';
        }
        if($part_name=='yoke_inner'){
            echo 'YOKE_INNER';
        }
        if($part_name=='sleeve_r'){
            echo 'SLEEVE_R';
        }
        if($part_name=='sleeve_l'){
            echo 'SLEEVE_L';
        }
        if($part_name=='slv_plkt_r'){
            echo 'SLV_PLKT_R';
        }
        if($part_name=='slv_plkt_l'){
            echo 'SLV_PLKT_L';
        }
        if($part_name=='pocket'){
            echo 'Pocket';
        }
        if($part_name=='box_plkt'){
            echo 'BOX_PLKT';
        }
        //                if($part_name=='collar_upper'){
        //                    echo '<b>Collar_Upper</b>';
        //                }
        if($part_name=='collar_inner'){
            echo 'COLLAR_INNER';
        }
        if($part_name=='collar_inner_2'){
            echo 'COLLAR_INNER_2';
        }
        if($part_name=='collar_outer_2'){
            echo 'COLLAR_OUTER_2';
        }
        if($part_name=='band_upper'){
            echo 'BAND_OUTER';
        }
        if($part_name=='band_inner'){
            echo 'BAND_INNER';
        }
        //                if($part_name=='cuff_upper'){
        //                    echo '<b>Cuff_Upper</b>';
        //                }
        if($part_name=='cuff_inner'){
            echo 'CUFF_INNER';
        }
        ?>
    </title>
    <style>
        p{
            font-size: 10px;
        }

        #break{
            /*page-break-after: always;*/
            page-break-before: always;
        }
    </style>
</head>
<body>
<!--<button type="button" onclick="printDiv('page')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</button>-->

<?php
$sl = 0;



foreach ($bundle_others_list as $row){

$po_no = $row['po_no'];
$purchase_order = $row['purchase_order'];
$item = $row['item'];
$quality = $row['quality'];
$style_no = $row['style_no'];
$style_name = $row['style_name'];
$brand = $row['brand'];
$ex_factory_date = $row['ex_factory_date'];
$size = $row['size'];
$color = $row['color'];
$cut_no = $row['cut_no'];
$cut_tracking_no = $row['cut_tracking_no'];
//    $bundle_no = $row['bundle_no'];
$bundle = $row['bundle'];
$bundle_trcking_no = $row['bundle_tracking_no'];
$bundle_range = $row['bundle_range'];
$bundle_range_count = $row['cut_qty'];
$cut_layer = $row['cut_layer'];

$sl++;

$packing_order_size = $this->method_call->getBundleInfoDetail($po_no, $bundle_trcking_no);
$order_qty = $this->method_call->getTotalOrderQty($po_no);

$total_order_qty = $order_qty[0]['total_order_qty'];
$cl_starting = $packing_order_size[0]['cl_starting'];
$cl_ending = $packing_order_size[0]['cl_ending'];
?>
<div id="page">
    <br />
        <div id="result" style="margin-top: 20px; margin-bottom: -10px; width: 130px; height: auto;">
            <p style="text-align: center; font-size: 15px;"><b>BUNDLE TICKET</b> <?php
                $bundle_tracking_no = '';

                if($part_name=='collar_outer'){
                    echo '<b>COLLAR_OUTER</b>';
                    $bundle_tracking_no = $bundle_trcking_no.'clr.';
                }

                if($part_name=='cuff_outer'){
                    echo '<b>CUFF_OUTER</b>';
                    $bundle_tracking_no = $bundle_trcking_no.'cff.';
                }

                if($part_name=='back'){
                    echo '<b>BACK</b>';
                    $bundle_tracking_no = $bundle_trcking_no.'bck.';
                }
                if($part_name=='front_l'){
                    echo '<b>FRONT_L</b>';
                }
                if($part_name=='front_r'){
                    echo '<b>FRONT_R</b>';
                }
                if($part_name=='yoke_upper'){
                    echo '<b>YOKE_OUTER</b>';
                    $bundle_tracking_no = $bundle_trcking_no.'yok.';
                }
                if($part_name=='yoke_inner'){
                    echo '<b>YOKE_INNER</b>';
                }
                if($part_name=='sleeve_r'){
                    echo '<b>SLEEVE_R</b>';
                    $bundle_tracking_no = $bundle_trcking_no.'slv.';
                }
                if($part_name=='sleeve_l'){
                    echo '<b>SLEEVE_L</b>';
                }
                if($part_name=='slv_plkt_r'){
                    echo '<b>SLV_PLKT_R</b>';
                    $bundle_tracking_no = $bundle_trcking_no.'spt.';
                }
                if($part_name=='slv_plkt_l'){
                    echo '<b>SLV_PLKT_L</b>';
                }
                if($part_name=='box_plkt'){
                    echo '<b>BOX_PLKT</b>';
                }
                if($part_name=='pocket'){
                    echo '<b>Pocket</b>';
                    $bundle_tracking_no = $bundle_trcking_no.'pkt.';
                }
//                if($part_name=='collar_upper'){
//                    echo '<b>Collar_Upper</b>';
//                }
                if($part_name=='collar_inner'){
                    echo '<b>COLLAR_INNER</b>';
                }
                if($part_name=='collar_inner_2'){
                    echo '<b>COLLAR_INNER_2</b>';
                }
                if($part_name=='collar_outer_2'){
                    echo '<b>COLLAR_OUTER_2</b>';
                }
                if($part_name=='band_upper'){
                    echo '<b>BAND_OUTER</b>';
                }
                if($part_name=='band_inner'){
                    echo '<b>BAND_INNER</b>';
                }
//                if($part_name=='cuff_upper'){
//                    echo '<b>Cuff_Upper</b>';
//                }
                if($part_name=='cuff_inner'){
                    echo '<b>CUFF_INNER</b>';
                }
                ?></p>
<!--            <p style="margin-bottom: -5px; font-size: 10.5px;"><b>SAP_Cut_PO_Item_S-Grp_B</b></p>-->

            <p style="margin-bottom: -5px; font-size: 10.5px;"><?php if(isset($bundle_tracking_no)){  echo $bundle_tracking_no; } ?></p>
            <p style="margin-bottom: -5px;">PO: <?php echo $purchase_order.'-'.$item;?></p>
            <p style="margin-bottom: -5px;">Brand: <?php echo $brand.' / <b>Order: '.$total_order_qty;?></b></p>
            <p style="margin-bottom: -5px;">Quality: <?php echo $quality.'-'.$color;?></p>
            <p style="margin-bottom: -5px;">ExFac: <?php echo $ex_factory_date;?></p>
            <p style="margin-bottom: -5px;">Style: <?php echo $style_name;?></p>
            <p style="margin-bottom: -0px;">Cut: <?php echo $cut_no;?></p>
            <p style="margin-bottom: -0px;">Bundle: <b><?php echo $bundle;?></b></p>
            <p style="margin-bottom: -0px; font-size: 12px;">Size: <b><?php echo $size.' - '.$cut_layer;?></b></p>
            <p style="margin-bottom: -0px; font-size: 12px;">QTY: <?php echo $bundle_range_count;?></p>
            <p style="margin-bottom: -0px; font-size: 14px;"><b>(<?php echo $cl_starting.' - '.$cl_ending;?>)</b></p>
            <br />
            <div style="float: left; margin-bottom: -5px; margin-left: 1px;">
                <?php
//                $code = '<center><img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $bundle_tracking_no .'" title="QR Code Image!"></center>';
//                echo $code;

                if($bundle_tracking_no != ''){
                    $bundle_tracking_no_file = $bundle_tracking_no.'.png';
                    $code = '<center><img src="'. base_url().'uploads/qr_image/'.$bundle_tracking_no_file.'" width="70" height="70" title="QR Code Image!"></center>';
                    echo $code;
                }

                ?>
            </div>
        </div>
    <br />
    <br />
    <br />
    <br />

    <?php
//        if($sl == 1) {
    ?>
            <div id="break"></div>

        <?php
//            $sl = 0;
//        }

}
?>
    </div>

<!--<button type="button" onclick="printDiv('page')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</button>-->

<footer>
    <script src="<?php echo base_url();?>assets/js/jquery-2.1.0.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
</footer>
</body>

</html>

<script type="text/javascript">

</script>

