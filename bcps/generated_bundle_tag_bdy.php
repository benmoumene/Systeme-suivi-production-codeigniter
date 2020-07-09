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
    <title>Bundle - Body Print</title>
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
<!--<button type="button" onclick="printDiv('page')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</button>-->

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
<div id="page">
    <br />
        <div id="result" style="margin-top: 20px; margin-bottom: -10px; width: 130px; height: auto;">
            <p style="text-align: center; font-size: 15px;"><b>BUNDLE TICKET</b> Body</p>
            <p style="margin-bottom: -5px;"><b>SAP_Cut_PO_Item_S-Grp_B</b></p>

            <p style="margin-bottom: -5px;"><?php if(isset($bundle_tracking_no)){ $bundle_tracking_no=$bundle_tracking_no."bdy."; echo $bundle_tracking_no; } ?></p>
            <p style="margin-bottom: -5px;">PO-ITEM: <?php echo $purchase_order.'-'.$item;?></p>
            <p style="margin-bottom: -5px;">Brand: <?php echo $brand;?></p>
            <p style="margin-bottom: -5px;">Quality: <?php echo $quality.'-'.$color;?></p>
            <p style="margin-bottom: -5px;">Style No: <?php echo $style_no;?></p>
            <p style="margin-bottom: -5px;">Style Name: <?php echo $style_name;?></p>
            <p style="margin-bottom: -0px;">Cut: <?php echo $cut_no;?></p>
            <p style="margin-bottom: -0px;">Bundle: <?php echo $bundle;?></p>
            <p style="margin-bottom: -0px;">QTY: <?php echo $bundle_range_count;?></p>
            <p style="margin-bottom: -0px;"><b>(</b><?php echo $cl_starting.' - '.$cl_ending;?><b>)</b></p>
            <br />
            <div style="text-align: center">
                <?php
                $code = '<center><img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $bundle_tracking_no .'" title="QR Code Image!"></center>';
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

<!--<button type="button" onclick="printDiv('page')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</button>-->

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

