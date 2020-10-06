<!DOCTYPE html>
<html>
<head>
    <title>Care Label Print</title>
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
<input type="text" name="pc_no" id="pc_no" readonly value="<?php echo $pc_no;?>" />
<input type="text" name="lost_point" id="lost_point" readonly  value="<?php echo $lost_point;?>" />
<input type="hidden" name="access_point" id="access_point"  value="<?php echo $access_point;?>" />
<input type="hidden" name="line_id" id="line_id"  value="<?php echo $line_id;?>" />

<br />
<br />
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
        <p style="margin-bottom: -5px;">Style No: <?php echo $style_no.'-'.substr($brand, 0, 1);?></p>
        <p style="margin-bottom: -5px;">Style Name: <?php echo $style_name;?></p>
        <p style="margin-bottom: -0px;">Size: <?php echo $size.'-'.$layer_group;?></p>
        <!--            <p style="margin-bottom: -5px;">Brand: --><?php //echo $brand;?><!--</p>-->
        <div style="float: left; margin-bottom: -5px; margin-left: 1px;">
            <?php
            $cl_no_file = $pc_tracking_no.'.png';
            $code = '<center><img src="'. base_url().'uploads/qr_image/'.$cl_no_file.'" width="80" height="80" title="QR Code Image!"></center>';
            echo $code;
            ?>
        </div><br />
        <?php if($brand != "OLYMP" && $brand != "TIMBERLAND" && $brand != "M&S T11" && $brand != "M&S T25" && $brand != "M&ST11" && $brand != "M&ST25" && $brand != "M&S"){ ?>
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
        <p style="margin-bottom: -5px;">Style No: <?php echo $style_no.'-'.substr($brand, 0, 1);?></p>
        <!--            <p style="margin-bottom: -5px;">Color: --><?php //echo $color;?><!--</p>-->
        <p style="margin-bottom: 0px;">Size: <?php echo $size.'-'.$layer_group;?></p>
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

<!--<button type="button" onclick="printDiv('page')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</button>-->

<footer>
    <script src="<?php echo base_url();?>assets/js/jquery-2.1.0.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
</footer>
</body>

</html>

<script type="text/javascript">

    window.addEventListener('keydown', function(event) {
        if (event.keyCode === 80 && (event.ctrlKey || event.metaKey) && !event.altKey && (!event.shiftKey || window.chrome || window.opera)) {
            event.preventDefault();
            if (event.stopImmediatePropagation) {
                event.stopImmediatePropagation();
            } else {
                event.stopPropagation();
            }
            return;
        }
    }, true);

    function printDiv(divName) {
        var pc_no = $("#pc_no").val();
        var lost_point = $("#lost_point").val();
        var access_point = $("#access_point").val();
        var reason = $("#reason").val();
        var reference = $("#reference").val();
        if(pc_no != '' && reason != '' && reference != ''){
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

            var cut_tracking_no = '<?php echo $cut_tracking_no;?>';
            var so_no = '<?php echo $po_no;?>';
            var line_id = '<?php echo $line_id;?>';


            $.ajax({
                url: "<?php echo base_url();?>access/keepReprintLog/",
                type: "POST",
                data: {pc_no: pc_no, lost_point: lost_point, access_point: access_point, line_id: line_id},
                dataType: "html",
                success: function (data) {
                    console.log(data);
                }
            });
        }else{
            alert("Please Fill Up Required Fields!");
        }

    }
</script>