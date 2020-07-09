<?php
require_once('comon_pts.php');
require_once('comon.php');

$datex = new DateTime(date('H:i:s'));
$datex->modify('+18000 seconds');
$date_time=$datex->format('Y-m-d H:i:s');

if(isset($_GET['cut_tracking_no'])){
    $cut_tracking_no = $_GET['cut_tracking_no'];

    $five_parts = explode('_', $cut_tracking_no);
    $po_no = $five_parts[0];
    $style_no = $five_parts[1];
    $color = $five_parts[2];
    $item = $five_parts[3];
    $cut_no = $five_parts[4];
}
$SQL_1="SELECT cut_tracking_no, style_no, size, COUNT(bundle_range) as count_bundle_range, bundle_range 
        FROM efl_db_pts.`tb_pc_detail` WHERE cut_tracking_no LIKE '%$cut_tracking_no%' Group BY cut_tracking_no, bundle_range";    //table name
$result_1 = $obj_pts->sql_pts($SQL_1);

$qty = 0;
while($row_1 = mysql_fetch_array($result_1)) {
    $qty += $row_1['count_bundle_range'];
}


//Include the barcode script

include_once '../barcode.php';

//Handle if text posted

if(isset($cut_tracking_no)) {

    //Create the barcode

    $img			=	code128BarCode($cut_tracking_no, 1);

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
<div align="center" style="width: 100%">
<div align="left" style="">
    <?php if(isset($cut_tracking_no)){ echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" />'; } ?>
    <!--        <br />-->
    <!--        --><?php //if(!empty($output_img)){ ?>
    <!--        ------------------------>
    <!--        <p style="color: rgba(30,54,255,0.8); margin-left: 50px;">X</p>-->
    <!--        --><?php //} ?>
    <!--    	--><?php //if($_POST['text']) echo '<b> Size: '. $text2 .'</b><br /><b> PO No.: '. $text3 .'</b>'.'<br /><b> Gmt:'.$_POST['text'].' </b><br />'.'<img src="data:image/png;base64,' . base64_encode($output_img) . '" />'; ?>
    <!---->
    <!--        --><?php //if(!empty($output_img)){ ?>
    <!--           <br />-->
    <!--           <br />-->
    <!--           <br />-->
    <!---->
    <!--        --><?php //}?>
    <!---->
</div>
<br /><br /><br />


    <div align="left" style="">
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
    <br/><br/>
    <div align="center">

<div>
        <?php
        $count = 1 ;
            $SQL_2="SELECT t1.id, t1.cut_tracking_no, t1.style_no, t1.size, t2.serial
                    FROM efl_db_pts.`tb_pc_detail` as t1
                    Inner JOIN
                    efl_db_pts.tb_size_serial as  t2
                    ON t1.size=t2.size
                    WHERE cut_tracking_no LIKE '%$cut_tracking_no%' Group BY t1.cut_tracking_no, t1.size
                    ORDER BY t2.serial";    //table name

            $result_2 = $obj_pts->sql_pts($SQL_2);
            while ($row_2 = mysql_fetch_array($result_2)){
                $size = $row_2['size'];
        ?>

        <table class="" border="1" style="border-color: white; float:left; width: 24%; margin-left: 5px; margin-top: 5px;">
            <thead>
                <tr>
                    <th>SL</th>
                    <th><span style="margin-right:20px">Size</span></th>
                    <th><span style="margin-right:5px">Range</span></th>
                    <th>CL Range</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sl=1;
            $SQL_3="SELECT t1.id, t1.cut_tracking_no, t1.style_no, t1.size, t1.suff, t1.bundle_range, t2.serial
                    FROM efl_db_pts.`tb_pc_detail` as t1
                    Inner JOIN
                    efl_db_pts.tb_size_serial as  t2
                    ON t1.size=t2.size
                    WHERE t1.cut_tracking_no LIKE '%$cut_tracking_no%' 
                    AND t1.size = '$size'
                    Group BY t1.cut_tracking_no, t1.size, t1.bundle_range
                    ORDER BY t2.serial";
            $result_3 = $obj_pts->sql_pts($SQL_3);
            while($row_3 = mysql_fetch_array($result_3)) {
                $bundle_range = $row_3['bundle_range'];
                $cut_size = $row_3['size'];

                $SQL_4="SELECT * FROM efl_db_pts.`tb_pc_detail` where cut_tracking_no = '$cut_tracking_no' 
                        and size = '$cut_size' and bundle_range = '$bundle_range' ORDER BY `id`  ASC LIMIT 1";
                $result_4 = $obj_pts->sql_pts($SQL_4);

            while($row_4 = mysql_fetch_array($result_4)) {
                $pc_tracking_no_start = $row_4['pc_tracking_no'];
            }


                $SQL_5="SELECT * FROM efl_db_pts.`tb_pc_detail` where cut_tracking_no = '$cut_tracking_no' 
                        and size = '$cut_size' and bundle_range = '$bundle_range' ORDER BY `id`  DESC LIMIT 1";
                $result_5 = $obj_pts->sql_pts($SQL_5);

                while($row_5 = mysql_fetch_array($result_5)) {
                    $pc_tracking_no_end = $row_5['pc_tracking_no'];
                }
            ?>
                    <tr>
                        <td style="text-align:center"><?php echo $sl; $sl++;?></td>
                        <td><strong></strong><?php echo $row_3['suff'];?></td>
                        <td><strong></strong><?php echo $row_3['bundle_range'];?></td>
                        <td><strong></strong><?php echo +$pc_tracking_no_start.'-'.+$pc_tracking_no_end;?></td>
                    </tr>
            <?php
            $count++;
                }
            ?>
            </tbody>
        </table>
        <?php
            }
        ?>
    </div>
    </div>

</div>

</body>
</html>