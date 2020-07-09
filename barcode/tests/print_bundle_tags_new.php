<?php
require_once('comon_pts.php');
require_once('comon.php');

$datex = new DateTime(date('H:i:s'));
$datex->modify('+18000 seconds');
$date_time=$datex->format('Y-m-d H:i:s');
$date=$datex->format('Y-m-d');

$cut_tracking_no = $_GET['cut_tracking_no'];
//$b = $_GET['b'];
//$sap_no = $_GET['sap_no'];
//$sap_no_last_five = substr($sap_no, -5);
//
//$po = $_GET['po'];
//$po_array = explode(",",$po);
//$item = $_GET['item'];
//$item_array = explode(",",$item);
//$cut_no = $_GET['cut_no'];
//
//$purchase_order = $po_array[0];
//$po_no_last_four = substr($purchase_order, -4);
//
//$item_no = $item_array[0];
//
//$cut_tracking_no = $sap_no_last_five.'_'.$cut_no.'_'.$po_no_last_four.'_'.$item_no;

//echo '<pre>';
//print_r($purchase_order.'-'.$item.'-'.$cut_no);
//echo '</pre>';

//Include the barcode script

include_once '../barcode.php'; /* FOR BARCODE */

//Handle if text posted
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bundle Tag Print</title>
    <style>
        p{
            font-size: 10px;
        }

        #break{
            page-break-after: always;
        }

        .foo {
            float: left;
            width: 50px;
            height: 20px;
            margin: 5px;
            border: 1px solid black;
        }

        /*table {*/
            /*border-collapse: collapse;*/
        /*}*/

        /*table, th, td {*/
            /*border: 1px solid black;*/
        /*}*/
    </style>
</head>
<body>

<?php
$sl = 0;
$SQL_1="SELECT * FROM efl_db_pts.`tb_cut_summary` WHERE cut_tracking_no='$cut_tracking_no'";    //table name
$result_1 = $obj->sql($SQL_1);

while($row = mysql_fetch_array($result_1)) {
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
//    $bundle_no = $row['bundle_no'];
    $bundle = $row['bundle'];
    $bundle_tracking_no = $row['bundle_tracking_no'];
    $bundle_range = $row['bundle_range'];
    $bundle_range_count = $row['cut_qty'];
    $cut_layer = $row['cut_layer'];

    $sl++;


    $SQL_2="SELECT A.bundle_tracking_no, A.pc_tracking_no as cl_ending, B.pc_tracking_no as cl_starting 
            From (SELECT *  FROM efl_db_pts.`tb_care_labels` 
            WHERE `bundle_tracking_no` LIKE '%$bundle_tracking_no%' ORDER BY `id`  DESC LIMIT 1) as A
            INNER JOIN
            (SELECT *  FROM efl_db_pts.`tb_care_labels` 
            WHERE `bundle_tracking_no` LIKE '%$bundle_tracking_no%' ORDER BY `id`  ASC LIMIT 1) as B";    //table name

    $result_2 = $obj->sql($SQL_2);
    $row_2 = mysql_fetch_array($result_2);
    $cl_starting = $row_2['cl_starting'];
    $cl_ending = $row_2['cl_ending'];
?>

        <div id="result" style="float: left; margin-top: 10px; margin-left: 10px; width: auto; height: auto; border-color: #000000; border-style: dotted;">
<!--            <p style="margin-left: 5px; margin-bottom: 2px;">ST_PO_Item_Cut_S-Lay_B</p>-->
<!--            <span style="font-size: 12px; margin-left: 5px;">--><?php //if(isset($bundle_tracking_no)){ echo $bundle_tracking_no; } ?><!--</span>-->
<!--            <p style="float: left; margin-left: 5px;">-->
<!--                --><?php //if(isset($bundle_tracking_no)){
//
//
//                        //Create the barcode
//
//                        $img = code128BarCode($bundle_tracking_no, 1);
//
//                        ob_start();
//                        imagepng($img);
//
//                        //Get the image from the output buffer
//
//                        $output_img		=	ob_get_clean();
//
//
//                    echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" />';
//                } ?>
<!--            </p>-->
<!---->
<!--            <br />-->
<!--            <div style="float: left;">-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><b>Brand:</b> --><?php //echo $brand;?><!--</p>-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><b>PO:</b> --><?php //echo $purchase_order;?><!--</p>-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><b>ITEM:</b> --><?php //echo $item;?><!--</p>-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><b>Quality:</b> --><?php //echo $quality.'-'.$color;?><!--</p>-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><b>Style No:</b> --><?php //echo $style_no;?><!--</p>-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><b>Style Name:</b> --><?php //echo $style_name;?><!--</p>-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><b>Cut No:</b> --><?php //echo $cut_no;?><!--</p>-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><b>Bundle No:</b> --><?php //echo $bundle_no;?><!--</p>-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><b>Bundle Range:</b> --><?php //echo $bundle_range;?><!--</p>-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><b>Size:</b> --><?php //echo $size;?><!--</p>-->
<!--                <p style="float: left; margin-left: 15px; font-size: 12px;"><div class="foo"></div></p>-->
<!--            </div>-->

            <table>
                <tr>
                    <td colspan="2">SAP_Cut_PO_Item_S-Grp_B</td>
                    <td colspan="1"><b>BODY</b></td>
                    <td colspan="1" align="right"><b>Date:</b> <?php echo $date;?></td>
                </tr>
                <tr>
                    <td colspan="4"><?php if(isset($bundle_tracking_no)){ $bundle_tracking_no=$bundle_tracking_no."bdy."; echo $bundle_tracking_no; } ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <?php if(isset($bundle_tracking_no)){


                            //Create the barcode

                            $img = code128BarCode($bundle_tracking_no, 1); /* FOR BARCODE */

                            ob_start(); /* FOR BARCODE */
                            imagepng($img); /* FOR BARCODE */

                            //Get the image from the output buffer

                            $output_img		=	ob_get_clean(); /* FOR BARCODE */


//                            echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" />';  /* FOR BARCODE */
                            $code = '<img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $bundle_tracking_no .'" title="QR Code Image!">';
                            echo $code;
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Brand:</b> <?php echo $brand;?></td>
                    <td><b>PO:</b> <?php echo $purchase_order;?></td>
                    <td><b>ITEM:</b> <?php echo $item;?></td>
                    <td><b>Quality:</b> <?php echo $quality.'-'.$color;?></td>
                </tr>
                <tr>
                    <td><b>Style No:</b> <?php echo $style_no;?></td>
                    <td><b>Style Name:</b> <?php echo $style_name;?></td>
                    <td><b>Cut No:</b> <?php echo $cut_no;?></td>
                    <td><b>Bundle No:</b> <?php echo $bundle;?></td>
                </tr>
                <tr>
<!--                    <td><b>Bundle Range:</b> --><?php //echo $bundle_range;?><!--</td>-->
                    <td><b>Bundle Qty:</b> <?php echo $bundle_range_count;?></td>
                    <td><b>(</b><?php echo $cl_starting.' - '.$cl_ending;?><b>)</b></td>
                    <td><b>Size:</b> <?php echo $size.'-'.$cut_layer;?></td>
                    <td><div class="foo"></div></td>
                </tr>
            </table>
    <br />
        </div>

    <?php
        if($sl == 5){
    ?>
        <div id="break"></div>
    <?php
            $sl = 0;
        }
    }
    ?>

</body>

</html>