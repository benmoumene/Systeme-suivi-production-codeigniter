<?php
require_once('comon_pts.php');
require_once('comon.php');

$datex = new DateTime(date('H:i:s'));
$datex->modify('+18000 seconds');
$date_time=$datex->format('Y-m-d H:i:s');


$cut_tracking_no = $_GET['cut_tracking_no'];

?>
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
<button type="button" onclick="printDiv('page')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</button>

<?php
$sl = 0;
$SQL_1="SELECT * FROM efl_db_pts.`tb_care_labels` WHERE cut_tracking_no='$cut_tracking_no'";    //table name

$result_1 = $obj->sql($SQL_1);



while($row = mysql_fetch_array($result_1)) {
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
        <div id="result" style="margin-top: 0px;margin-left: 0px; width: auto; height: auto;">

            <table border="0" style="font-size: 9px;">
                <tr>
                    <td>  </td>
                </tr>
                <tr>
                    <td>  </td>
                </tr>
                <tr>
                    <td><?php echo $pc_tracking_no;?></td>
                </tr>
                <?php
                if($brand == 'BOSS') {
                    ?>
                    <tr>
                        <td>B PO: <?php echo $purchase_order . '-' . $item; ?></td>
                    </tr>
                    <?php
                }else {
                    ?>
                    <tr>
                        <td>B PO: <?php echo $purchase_order; ?></td>
                    </tr>
                    <?php
                }
                ?>

                <tr>
                    <td><?php echo $bundle_tracking_no;?></td>
                </tr>
                <tr>
                    <td>Style No: <?php echo $style_no.'-'.substr($brand, 0, 1);?></td>
                </tr>
                <tr>
                    <td>Style Name: <?php echo $style_name;?></td>
                </tr>
                <tr>
                    <td align="center">
                        <span style="float: left;">Size: <?php echo $size;?></span>
                    </td>
                </tr>
                <tr>
                    <td style="float: left; margin-left: 25px;">
                        <?php
                        $code = '<center><img src="https://chart.googleapis.com/chart?chs=60x60&cht=qr&chl='.$pc_tracking_no.'" title="QR Code Image!"></center>';
                        echo $code;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="float: left;">-------------------------------</td>
                </tr>
                <tr>
                    <td style="font-size: 50px;"><b style="margin-left: 35px;">+</b></td>
                </tr>
                <tr>
                    <td><?php echo $pc_tracking_no;?></td>
                </tr>
                <tr>
                    <td>ST_PO_Item_Cut_S-Lay_B</td>
                </tr>
                <tr>
                    <td><?php echo $bundle_tracking_no;?></td>
                </tr>
                <tr>
                    <td>Style No: <?php echo $style_no.'-'.substr($brand, 0, 1);?></td>
                </tr>
                <tr>
                    <td style="float: left; margin-left: 25px;">
                        <?php
                        $code = '<center><img src="https://chart.googleapis.com/chart?chs=60x60&cht=qr&chl='.$pc_tracking_no.'" title="QR Code Image!"></center>';
                        echo $code;
                        ?>
                    </td>
                </tr>
            </table>

    <?php
        if($sl == 3) {
    ?>
            <div id="break"></div>

        <?php
            $sl = 0;
        }

}
?>

    </div>

<button type="button" onclick="printDiv('page')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</button>

<footer>
    <script src="http://10.234.15.22/pts/assets/js/jquery-2.1.0.js"></script>
    <script src="http://10.234.15.22/pts/assets/js/jquery.min.js"></script>
</footer>
</body>

</html>

<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        var cut_tracking_no = '<?php echo $cut_tracking_no;?>';

        $.ajax({
            url: "http://10.234.15.22/pts/access/updatingCLPrintLog/",
            type: "POST",
            data: {cut_tracking_no: cut_tracking_no},
            dataType: "html",
            success: function (data) {
                console.log(data);
            }
        });
    }
</script>

