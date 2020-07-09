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
    <br />
        <div id="result" style="margin-top: 20px; margin-left: 5px; margin-bottom: -10px; width: 120px; height: auto;">
            <p style="margin-bottom: -5px;"><?php echo $pc_tracking_no;?></p>
<!--            <p style="margin-bottom: -5px;">PO: --><?php //echo $po_no;?><!--</p>-->
            <?php
            if(($brand == 'HUGO') || ($brand == 'BOSS') || ($brand == 'HB') || ($brand == 'HUGOBOSS') || ($brand == 'HUGO BOSS')) {
                ?>
                <p style="margin-bottom: -5px;">B PO: <?php echo $purchase_order . '-' . $item; ?></p>
                <?php
            }else {
                ?>
                <p style="margin-bottom: -5px;">B PO: <?php echo $purchase_order;?></p>
                <?php
            }
            ?>
            <p style="margin-bottom: -5px;"><?php echo $bundle_tracking_no;?></p>
            <p style="margin-bottom: -5px;">Quality: <?php echo $quality.'-'.$color;?></p>
<!--            <p style="margin-bottom: -5px;">Bundle Range: --><?php //echo $bundle_range;?><!--</p>-->
            <p style="margin-bottom: -5px;">Style No: <?php echo $style_no.'-'.substr($brand, 0, 1);?></p>
            <p style="margin-bottom: -5px;">Style Name: <?php echo $style_name;?></p>
            <p style="margin-bottom: -0px;">Size: <?php echo $size.'-'.$bundle_no;?></p>
<!--            <p style="margin-bottom: -5px;">Brand: --><?php //echo $brand;?><!--</p>-->
            <div style="float: left; margin-bottom: -5px; margin-left: 1px;">
                <?php
                $code = '<center><img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $pc_tracking_no .'" title="QR Code Image!"></center>';
                echo $code;
                ?>
            </div><br />
            <span style="float: left;">--|-----------------|--</span>
            <br />
            <br />
            <span style="margin-left: 45px !important; font-size: 55px !important;"><b>+</b></span>

            <p style="margin-bottom: -5px;"><?php echo $pc_tracking_no;?></p>
            <p style="margin-bottom: -5px;">SAP_Cut_PO_Item_S-Grp_B</p>
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
            <p style="margin-bottom: -5px;"><?php echo $bundle_tracking_no;?></p>
            <p style="margin-bottom: -0px;">Style No: <?php echo $style_no.'-'.substr($brand, 0, 1);?></p>
<!--            <p style="margin-bottom: -5px;">Color: --><?php //echo $color;?><!--</p>-->
<!--            <p style="margin-bottom: -5px;">Size: --><?php //echo $size.'-'.$bundle_no;?><!--</p>-->
            <div style="float: left; margin-left: 1px;">
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

        //alert(cut_tracking_no);

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

