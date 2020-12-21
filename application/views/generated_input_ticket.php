<!DOCTYPE html>
<html>
<head>
    <title>
        CUT INPUT TICKET
    </title>
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

<div id="page">
    <br />
        <div id="result" style="margin-top: 20px; margin-bottom: -10px; width: 130px; height: auto;">
            <p style="text-align: center; font-size: 15px;"><b>INPUT TICKET</p>
<!--            <p style="margin-bottom: -5px; font-size: 10.5px;"><b>SAP_Cut_PO_Item_S-Grp_B</b></p>-->

            <p style="margin-bottom: -5px; font-size: 12px;"><?php echo $po_cut_summary[0]['po_no'];?></b></p>
            <p style="margin-bottom: -0px; font-size: 12px;">Cut No: <?php echo $po_cut_summary[0]['cut_no'];?></p>
            <p style="margin-bottom: -5px; font-size: 12px;">Brand: <?php echo $po_cut_summary[0]['brand'];?></b></p>
            <p style="margin-bottom: -5px; font-size: 12px;">Quality: <?php echo $po_cut_summary[0]['quality'];?></p>
            <p style="margin-bottom: -5px; font-size: 12px;">Color: <?php echo $po_cut_summary[0]['color'];?></p>
            <p style="margin-bottom: -5px; font-size: 12px;">Style No:<?php echo $po_cut_summary[0]['style_no'];?></p>
            <p style="margin-bottom: -5px; font-size: 12px;">Style: <?php echo $po_cut_summary[0]['style_name'];?></p>
            <p style="margin-bottom: -0px; font-size: 12px;">Cut Qty: <?php echo ($po_cut_summary[0]['total_cut_qty'] != '' ? $po_cut_summary[0]['total_cut_qty'] : 0);?></p>
            <p style="margin-bottom: -0px; font-size: 12px;">Prev. Input Qty: <?php echo ($po_cut_summary[0]['package_sent_to_production_qty'] != '' ? $po_cut_summary[0]['package_sent_to_production_qty'] : 0);?></p>
            <p style="margin-bottom: -0px; font-size: 12px;">Ready Qty: <?php echo $po_cut_summary[0]['total_cut_ready_qty'];?></p>
            <p style="margin-bottom: -0px; font-size: 12px;">Order Qty: <?php echo $po_cut_summary[0]['total_order_qty'];?></p>
            <p style="margin-bottom: -0px; font-size: 12px;">ExFac: <?php echo $po_cut_summary[0]['ex_factory_date'];?></p>

            <br />
            <div style="float: left; margin-bottom: -5px; margin-left: 1px;">
                <?php
//                $code = '<center><img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $bundle_tracking_no .'" title="QR Code Image!"></center>';
//                echo $code;

                $input_ticket_no_file = $input_ticket_no.'.png';

                $code = '<center><img src="'. base_url().'uploads/qr_image/'.$input_ticket_no_file.'" width="70" height="70" title="QR Code Image!"></center>';
                echo $code;
                ?>
            </div>
        </div>
    <br />
    <br />
    <br />
    <br />

            <div id="break"></div>

    </div>

<!--<button type="button" onclick="printDiv('page')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</button>-->

<footer>
    <script src="<?php echo base_url();?>assets/js/jquery-2.1.0.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
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
            url: "<?php echo base_url();?>access/updatingCLPrintLog/",
            type: "POST",
            data: {cut_tracking_no: cut_tracking_no},
            dataType: "html",
            success: function (data) {
                console.log(data);
            }
        });
    }
</script>

