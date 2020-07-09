<?php
    require_once('comon_pts.php');
    require_once('comon.php');

    $datex = new DateTime(date('H:i:s'));
    $datex->modify('+18000 seconds');
    $date_time=$datex->format('Y-m-d H:i:s');

    if(isset($_GET['pc_tracking_no'])){
        $decd_CutID=$_GET['pc_tracking_no'];
    }

?>
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

  $SQL_1="SELECT t1.*, t2.purchase_order, t2.brand, t2.item, t2.style_no, t2.style_name, t2.quality, 
        t2.color FROM efl_db_pts.`tb_pc_detail` as t1 
        Inner JOIN
        efl_db_pts.`tb_po_detail` as t2
        ON t1.po_no = t2.po_no and t1.size=t2.size
        WHERE t1.pc_tracking_no LIKE '%$decd_CutID%'";    //table name
$result_1 = $obj->sql($SQL_1);

while($row = mysql_fetch_array($result_1)) {
    $pc_tracking_no = $row['pc_tracking_no'];
    $po_no = $row['po_no'];
    $purchase_order = $row['purchase_order'];
    $item = $row['item'];
    $quality = $row['quality'];
    $brand = $row['brand'];
    $style_no = $row['style_no'];
    $style_name = $row['style_name'];
    $color = $row['color'];
    $cut_tracking_no = $row['cut_tracking_no'];
    $size = $row['size'];
    $suff = $row['suff'];
    $bundle_range = $row['bundle_range'];
    $cut_no = $row['cut_no'];

    ?>

    <div id="result" style="width: 120px; height: 540px;">
        <p style="margin-bottom: -5px;"><?php echo $pc_tracking_no;?></p>
        <p style="margin-bottom: -5px;">PO: <?php echo $po_no;?></p>
        <?php
        if($brand == 'BOSS') {
            ?>
            <p style="">PO: <?php echo $purchase_order . '-' . $item; ?></p>
            <?php
        }else {
            ?>
            <p style="">PO: <?php echo $purchase_order;?></p>
            <?php
        }
        ?>
        <p style="margin-bottom: -5px;">Cut No: <?php echo $cut_no;?></p>
        <p style="margin-bottom: -5px;">Quality: <?php echo $quality;?></p>
        <p style="margin-bottom: -5px;">Bundle Range: <?php echo $bundle_range;?></p>
        <p style="margin-bottom: -5px;">Color: <?php echo $color;?></p>
        <p style="margin-bottom: -5px;">Size: <?php echo $suff;?></p>

        <p style="margin-bottom: -5px;">Style No: <?php echo $style_no;?></p>
        <p style="margin-bottom: -5px;">Style Name: <?php echo $style_name;?></p>

        <p style="margin-bottom: -5px;">Brand: <?php echo $brand;?></p>
        <div style="float: left; margin-bottom: -5px;">
            <?php
            $code = '<center><img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $pc_tracking_no .'" title="QR Code Image!"></center>';
            echo $code;
            ?>
        </div><br />
        <span style="float: left;">-----------------</span>
        <br />
        <br />
        <br />
        <br />
        <span style="margin-left: 38px;">X</span>

        <p style="margin-bottom: -5px;"><?php echo $pc_tracking_no;?></p>
        <p style="margin-bottom: -5px;">PO: <?php echo $po_no;?></p>
        <?php
        if($brand == 'BOSS') {
            ?>
            <p style="">PO: <?php echo $purchase_order . '-' . $item; ?></p>
            <?php
        }else {
            ?>
            <p style="">PO: <?php echo $purchase_order;?></p>
            <?php
        }
        ?>

        <p style="margin-bottom: -5px;">Cut No: <?php echo $cut_no;?></p>
        <p style="margin-bottom: -5px;">Quality: <?php echo $quality;?></p>
        <p style="margin-bottom: -5px;">Bundle Range: <?php echo $bundle_range;?></p>
        <p style="margin-bottom: -5px;">Color: <?php echo $color;?></p>
        <p style="margin-bottom: -5px;">Size: <?php echo $suff;?></p>

        <p style="margin-bottom: -5px;">Style No: <?php echo $style_no;?></p>
        <p style="margin-bottom: -5px;">Style Name: <?php echo $style_name;?></p>
        <p style="margin-bottom: -5px;">Brand: <?php echo $brand;?></p>
        <div style="float: left;">
            <?php
            $code = '<center><img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $pc_tracking_no .'" title="QR Code Image!"></center>';
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
    <br />

<?php } ?>

</body>

</html>
