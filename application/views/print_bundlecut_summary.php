<?php
include_once ('../barcode/tests/barcode.php');

$five_parts = explode('_', $cut_tracking_no);
$po_no = $five_parts[0];
$purchase_order = $five_parts[1];
$style_no = $five_parts[2];
$color = $five_parts[3];
$cut_no = $five_parts[4];

foreach ($po_cut_summary as $k => $v) {
    $qty += $v['count_bundle_range'];
}

if(isset($cut_tracking_no)) {

    //Create the barcode

    $img			=	code128BarCode($cut_tracking_no, 1);

    //Start output buffer to capture the image
    //Output PNG image

    ob_start();
    imagepng($img);

    //Get the image from the output buffer

    $output_img		=	ob_get_clean();

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sticker Sheet Print</title>

    <style type="text/css">
        table.bottomBorder { border-collapse:collapse; padding:1px }
        table.bottomBorder td, table.bottomBorder th { border-bottom:1px dotted black;
            text-align:left;
            font-size:16px;
            font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
            padding:5px;
        }
        table.bottomBorder tr, table.bottomBorder tr { border:1px dotted black; }


        table.bottomBorder2 td, table.bottomBorder2 th {
            font-size:16px;
        }

    </style>

</head>

<body>

<?php

?>

<br/><br/>
<div align="center" style="width:300px">

    <div style="width:250px; margin-left:5px">
        <!--<table class="bottomBorder" border="1" cellpadding="5px">-->
        <table class="bottomBorder2" cellpadding="2px">
            <tr><th style="text-align:left;">Production Order:</th><td><?php echo $po_no; ?></td></tr>
            <tr><th style="text-align:left;">Auto CutID:</th><td><?php echo $cut_tracking_no; ?></td></tr>
            <tr><th style="text-align:left; font-family:'Comic Sans MS', cursive">Style:</th><td style="font-family:'Comic Sans MS', cursive"><?php echo $style_no; ?></td></tr>
            <tr><th style="text-align:left; font-family:'Comic Sans MS', cursive">Color:</th><td style="font-family:'Comic Sans MS', cursive"><?php echo $color; ?></td></tr>
<!--            <tr><th style="text-align:left; font-family:'Comic Sans MS', cursive">Lot:</th><td style="font-family:'Comic Sans MS', cursive">--><?php //echo ''; ?><!--</td></tr>-->
            <tr><th style="text-align:left; font-family:'Comic Sans MS', cursive"><span style="margin-right:30px">Quantity:</span></th><td style="font-family:'Comic Sans MS', cursive"><?php echo $qty; ?></td></tr>
        </table>
    </div>

    <div>
        <br/><br/>
        <table class="bottomBorder" border="1">
            <thead>
                <tr>
                    <th>SL</th>
                    <th><span style="margin-right:20px">Size</span></th>
                    <th><span style="margin-right:5px">Range</span></th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $sl=1;
                foreach ($po_cut_summary as $k => $v) {
            ?>
                    <tr>
                        <td style="text-align:center"><?php echo $sl; $sl++;?></td>
                        <td><strong></strong><?php echo $v['size'];?></td>
                        <td><strong></strong><?php echo $v['bundle_range'];?></td>
                        <td><strong></strong><?php echo $v['count_bundle_range'];?></td>
                    </tr>
            <?php
                }
            ?>
            </tbody>
        </table>

    </div>

</div>

</body>
</html>