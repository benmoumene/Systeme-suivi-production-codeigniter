<button type="button" onclick="printDiv('page')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</button>


<?php
$sl = 0;
foreach ($care_label_list as $row){

$pc_tracking_no = $row['pc_tracking_no'];
$purchase_order = $row['purchase_order'];
$item = $row['item'];
$quality = $row['quality'];
$style_no = $row['style_no'];
$style_name = $row['style_name'];
$ex_factory_date = $row['ex_factory_date'];
$brand = $row['brand'];
$size = $row['size'];
$color = $row['color'];
$cut_no = $row['cut_no'];
$cut_tracking_no = $row['cut_tracking_no'];
$bundle_no = $row['bundle_no'];
$bundle_tracking_no = $row['bundle_tracking_no'];
$bundle_range = $row['bundle_range'];
$layer_group = $row['layer_group'];

$sl++;
?>
<div id="page">
    <br />
    <div id="result" style="margin-top: 20px; margin-left: 5px; margin-bottom: -10px; width: 120px; height: auto;">
        <p style="margin-bottom: -5px;"><?php echo $pc_tracking_no;?></p>
        <p style="margin-bottom: -5px;"><?php echo $ex_factory_date;?></p>
        <!--            <p style="margin-bottom: -5px;">PO: --><?php //echo $po_no;?><!--</p>-->
        <?php
//        if(($brand == 'HUGO') || ($brand == 'BOSS') || ($brand == 'HB') || ($brand == 'HUGOBOSS') || ($brand == 'HUGO BOSS')) {
            ?>
            <p style="margin-bottom: -5px;">PO:<?php echo $purchase_order . '-' . $item; ?></p>
            <?php
//        }else {
            ?>
<!--            <p style="margin-bottom: -5px;">B PO: --><?php //echo $purchase_order;?><!--</p>-->
            <?php
//        }
        ?>
        <p style="margin-bottom: -5px;"><?php echo $bundle_tracking_no;?></p>
        <p style="margin-bottom: -5px;">Quality: <?php echo $quality.'-'.$color;?></p>
        <!--            <p style="margin-bottom: -5px;">Bundle Range: --><?php //echo $bundle_range;?><!--</p>-->
        <p style="margin-bottom: -5px;">Style: <?php echo $style_name;?></p>
        <p style="margin-bottom: -0px;">Size: <?php echo $size.'-'.$bundle_no;?></p>
        <!--            <p style="margin-bottom: -5px;">Brand: --><?php //echo $brand;?><!--</p>-->
        <div style="float: left; margin-bottom: -5px; margin-left: 1px;">
            <?php
            $cl_no_file = $pc_tracking_no.'.png';
            $code = '<center><img src="'. base_url().'uploads/qr_image/'.$cl_no_file.'" width="80" height="80" title="QR Code Image!"></center>';
            echo $code;
            ?>
        </div>
        <?php if($brand != "OLYMP" && $brand != "John Lewis" && $brand != "WOOLWORTH" && $brand != "CONBIPEL" && $brand != "TIMBERLAND" && $brand != "M&S T11" && $brand != "M&S T25" && $brand != "M&ST11" && $brand != "M&ST25" && $brand != "M&S"){ ?>
        <br />
        <span style="float: left;">--|-----------------|--</span>
        <br />
        <span style="margin-left: 45px !important; font-size: 55px !important;"><b>+</b></span>

        <p style="margin-bottom: -5px;"><?php echo $pc_tracking_no;?></p>
<!--        <p style="margin-bottom: -5px;">SAP_Cut_PO_Item_S-Grp_B</p>-->
        <!--            <p style="margin-bottom: -5px;">PO: --><?php //echo $po_no;?><!--</p>-->
        <?php
        if($brand == 'BOSS') {
            ?>
            <!--                <p style="">B PO: --><?php //echo $purchase_order . '-' . $item; ?><!--</p>-->
            <?php
        }else {
            ?>
            <!--                <p style="">B PO: --><?php //echo $purchase_order;?><!--</p>-->
            <?php
        }
        ?>
        <p style="margin-bottom: -5px;">PO:<?php echo $purchase_order . '-' . $item; ?></p>
        <p style="margin-bottom: -5px;">Quality: <?php echo $quality.'-'.$color;?></p>
        <p style="margin-bottom: -5px;">Style No: <?php echo $style_no;?></p>
        <!--            <p style="margin-bottom: -5px;">Color: --><?php //echo $color;?><!--</p>-->
        <p style="margin-bottom: 0px;">Size: <?php echo $size.'-'.$bundle_no;?></p>
        <div style="float: left; margin-left: 1px;">
            <?php
            $cl_no_file = $pc_tracking_no.'.png';
            $code = '<center><img src="'. base_url().'uploads/qr_image/'.$cl_no_file.'" width="80" height="80" title="QR Code Image!"></center>';
            echo $code;
            ?>
        </div>
        <?php } ?>
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