<?php
    require_once('comon_pts.php');
    require_once('comon.php');

    $datex = new DateTime(date('H:i:s'));
    $datex->modify('+18000 seconds');
    $date_time=$datex->format('Y-m-d H:i:s');

    if(isset($_POST['cid'])){
        $decd_CutID=$_POST['cid'];
    }
    if(isset($_GET['cid'])){
        $decd_CutID=$_GET['cid'];
    }

    if(isset($_GET['lay'])){
        $lay=$_GET['lay'];
    }



    $two_parts = explode('_', $decd_CutID);
    $po_no = $two_parts[0];
    $purchase_order_no = $two_parts[1];
    $style_no = $two_parts[2];
    $color = $two_parts[3];
    $item = $two_parts[4];
    $cut_no = $two_parts[5];


    $lst_CareLable_id = '';

    $sql_last_CL_id = "SELECT * FROM efl_db_pts.`tb_pc_detail` ORDER BY ID DESC LIMIT 1";
    $result_CL_id = $obj_pts->sql_pts($sql_last_CL_id);

    while ($last_CL_id = mysql_fetch_array($result_CL_id)){
        $lst_CareLable_id = $last_CL_id['pc_tracking_no'];
    }

    if($lst_CareLable_id != ''){
        $last_care_lable_id = (int)$lst_CareLable_id;
    }else{
        $lst_CareLable_id=0;
        $last_care_lable_id = (int)$lst_CareLable_id;
    }

    $SQL_check_avail="SELECT * FROM efl_db_pts.`tb_pc_detail` WHERE cut_tracking_no LIKE '%$decd_CutID%' Group By cut_tracking_no";    //table name
    $result_check_avail = $obj->sql($SQL_check_avail);

    while($row_ck = mysql_fetch_array($result_check_avail))
    {
        $is_already_avail = $row_ck['id'];
    }

    if(empty($is_already_avail)){
        $SQL="SELECT t1.*,t2.marker FROM `tb_vsfs_bundle_info` as t1
            Inner JOIN
            `tb_vsfs_size_marker` as t2
            ON t1.CutID=t2.cut_id and t1.Size=t2.size
            WHERE t1.CutID LIKE '%$decd_CutID%' AND t1.PartName LIKE '%BACK%' 
            Group by t1.CutID, t1.BundleNo, t1.Size Order BY t1.AutoBundleID";    //table name

        $result = $obj->sql($SQL);

        while($row = mysql_fetch_array($result))
        {
            $cut_id = $row['CutID'];
            $bundle_range = $row['BundleRange'];
            $size = $row['Size'];
            $suff = $row['Suff'];
            $quantity = $row['Qty'];
            $marker = $row['marker'];

//            $qty = $quantity * $marker;
            $qty = $quantity;

            for ($i=1; $i <= $qty; $i++){
                $last_care_lable_id = $last_care_lable_id + 1;
                $f_last_care_lable_id = sprintf("%015s", $last_care_lable_id.'.');

                $sql_insert = "INSERT INTO efl_db_pts.`tb_pc_detail`
                          (`pc_tracking_no`, `po_no`, `purchase_order`, `cut_no`, `cut_tracking_no`,
                          `style_no`, `size`, `suff`, `bundle_range`, `date_time`, `u_id`, `care_label_printed`)
                          VALUES ('$f_last_care_lable_id', '$po_no', '$purchase_order_no', '$cut_no', '$cut_id', '$style_no', '$size',
                          '$suff', '$bundle_range', '$date_time', '', '1')";
                $obj_pts->sql_pts($sql_insert);
            }
        }
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

        body {
            background: rgb(204,204,204);
        }
        page[size="A4"] {
            background: white;
            width: 21cm;
            height: 29.7cm;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);

        }
        @media print {
            body, page[size="A4"] {
                margin: 0;
                box-shadow: 0;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>

<?php

  $SQL_1="SELECT t1.*, t2.purchase_order, t2.brand, t2.item, t2.style_no, t2.style_name, t2.quality, 
        t2.color, SUBSTRING_INDEX(SUBSTRING_INDEX(t1.cut_tracking_no, '_', -2), '_', 1) as item FROM efl_db_pts.`tb_pc_detail` as t1 
        Inner JOIN
        efl_db_pts.`tb_po_detail` as t2
        ON t1.po_no = t2.po_no and t1.purchase_order=t2.purchase_order and t1.size=t2.size and SUBSTRING_INDEX(SUBSTRING_INDEX(t1.cut_tracking_no, '_', -2), '_', 1)=t2.item
        WHERE t1.cut_tracking_no LIKE '%$decd_CutID%'";    //table name
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
<page size="A4">
    <div id="result" style="margin-left: 5px; width: 120px; height: 540px;">
        <p style="margin-bottom: -5px;"><?php echo $pc_tracking_no;?></p>
        <p style="margin-bottom: -5px;">PO: <?php echo $po_no;?></p>
        <?php
        if($brand == 'BOSS') {
            ?>
            <p style="">B PO: <?php echo $purchase_order . '-' . $item; ?></p>
            <?php
        }else {
            ?>
            <p style="">B PO: <?php echo $purchase_order;?></p>
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
            <p style="">B PO: <?php echo $purchase_order . '-' . $item; ?></p>
            <?php
        }else {
            ?>
            <p style="">B PO: <?php echo $purchase_order;?></p>
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

</page>

<?php
}
?>

</body>

</html>
