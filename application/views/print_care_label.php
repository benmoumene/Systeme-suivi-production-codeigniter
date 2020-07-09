<!DOCTYPE html>
<html>
<head>
    <title>Care Label Print</title>
    <style>

        p{
            font-size: 10px;
        }

    </style>
</head>
<body>

<?php
foreach ($po_CareLabelInfo as $v){

    $pc_tracking_no = $v['pc_tracking_no'];
    $purchase_order = $v['purchase_order'];
    $item = $v['item'];
    $brand = $v['brand'];
    $style_no = $v['style_no'];
    $color = $v['color'];
    $size = $v['size'];

?>

<div id="result" style="width: 120px; height: 190px;">
    <?php
        if($brand == 'Boss') {
            ?>
            <p style="">PO: <?php echo $purchase_order . '-' . $item; ?></p>
            <?php
        }
        else {
            ?>
            <p style="">PO: <?php echo $purchase_order;?></p>
            <?php
        }
    ?>
    <p style="margin-bottom: -5px;">Size: <?php echo $size;?></p>

    <p style="margin-bottom: -5px;">Style: <?php echo $style_no;?></p>

    <p style="margin-bottom: -5px;">Brand: <?php echo $brand;?></p>
    <div style="float: left; margin-bottom: -5px;">
        <?php
        $code = '<center><img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $pc_tracking_no .'" title="Link to Google.com"></center>';
        echo $code;
        ?>
    </div><br />
    <span style="float: left;">-----------------</span>
    <br />
    <br />
    <br />
    <br />
    <span style="margin-left: 40px;">X</span>
    <p style="margin-bottom: -5px;">PO: <?php echo $purchase_order;?></p>

    <p style="margin-bottom: -5px;">Size: <?php echo $size;?></p>

    <p style="margin-bottom: -5px;">Style: <?php echo $style_no;?></p>

    <p style="margin-bottom: -5px;">Brand: <?php echo $brand;?></p>
    <div style="float: left;">
        <?php
        $code = '<center><img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $pc_tracking_no .'" title="Link to Google.com"></center>';
        echo $code;
        ?>
    </div>
</div>

<br />
<br />
<br />
<br />
<br />
<br />
<br />

<?php } ?>

</body>

</html>