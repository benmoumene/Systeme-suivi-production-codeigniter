<!DOCTYPE html>
<html>
<head>
    <title>
        <?php echo $title;?>
    </title>
    <style>
        p{
            font-size: 10px;
        }

        #break{
            page-break-after: always;
            /*page-break-before: always;*/
        }

        .label {
            display: inline-block;
            width: 200px;
            height: 230px;
            border: 1px solid black;
            padding: 5px;
            margin: 5px;
        }
    </style>
</head>
<body>
<!--<button type="button" onclick="printDiv('page')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</button>-->

<div id="page">
    <br />

    <?php foreach($user_codes AS $u){

            $user_info_res = $this->method_call->getUserInfo($u);

            $user_description = $user_info_res[0]['user_description'];

    ?>

        <div id="result" class="label" >
            <p style="text-align: center; font-size: 16px;"><b><?php echo $user_description;?></p>
            <center>
                <?php

                $qr_code_file = $u.'.png';

                $code = '<center><img src="'. base_url().'uploads/qr_image/'.$qr_code_file.'" width="160" height="160" title="QR Code Image!"></center>';
                echo $code;
                ?>
            </center>
        </div>
    <?php } ?>

<!--            <div id="break"></div>-->

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

