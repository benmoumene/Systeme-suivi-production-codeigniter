<?php
require_once('comon_pts.php');
require_once('comon.php');

$datex = new DateTime(date('H:i:s'));
$datex->modify('+18000 seconds');
$date_time=$datex->format('Y-m-d H:i:s');
$date=$datex->format('Y-m-d');

$cut_tracking_no = $_GET['cut_tracking_no'];

//Include the barcode script

include_once '../barcode.php';

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
$SQL_1="SELECT * FROM efl_db_pts.`tb_bundle_cut_detail` WHERE cut_tracking_no='$cut_tracking_no'";    //table name
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
    $bundle_no = $row['bundle_no'];
    $bundle_tracking_no = $row['bundle_tracking_no'];
    $bundle_range = $row['bundle_range'];
    $bundle_range_count = $row['bundle_range_count'];
    $layer_group = $row['layer_group'];

    $sl++;
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
                    <td colspan="3">ST_PO_Item_Clr_Cut_S-Lay_B</td>
                    <td colspan="1"><b>Date:</b> <?php echo $date;?></td>
                </tr>
                <tr>
                    <td colspan="4"><?php if(isset($bundle_tracking_no)){ echo $bundle_tracking_no; } ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <?php if(isset($bundle_tracking_no)){


                            //Create the barcode

                            $img = code128BarCode($bundle_tracking_no, 1);

                            ob_start();
                            imagepng($img);

                            //Get the image from the output buffer

                            $output_img		=	ob_get_clean();


                            echo '<img src="data:image/png;base64,' . base64_encode($output_img) . '" />';
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
                    <td><b>Bundle No:</b> <?php echo $bundle_no;?></td>
                </tr>
                <tr>
                    <td><b>Bundle Range:</b> <?php echo $bundle_range;?></td>
                    <td> </td>
                    <td><b>Size:</b> <?php echo $size;?></td>
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