<!DOCTYPE html>
<html>
<body>

<div id="cl_no" style="width: auto; height: auto;">
    <table>

        <tr>
            <td align="left">
                <?php
//                    $code = '<center><img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl='. $cl_no .'" title="QR Code Image!"></center>';
                    $code = '<center><img src="'. base_url().'uploads/qr_image/'.$cl_no_file.'" width="50" height="50" title="QR Code Image!"></center>';
                    echo $code;

                    $concat_str = '';

                    if($po != ''){
                        $concat_str .= $po;
                    }

                    if($item != ''){
                        $concat_str .= '~'.$item;
                    }

                    if($color != ''){
                        $concat_str .= '~'.$color;
                    }
                ?>
            </td>
            <td align="center">
                <span style="margin-top: 0px;">
                    <?php
                        $care_lbl_no = str_replace (".", "", $cl_no);
                        $care_label_no = substr($care_lbl_no, -5);
                        echo $care_label_no.'~'.$size;
                    ?>
                </span>
                <span style="margin-top: 0px;"><?php echo $concat_str;?></span>
            </td>
        </tr>

    </table>
</div>
<span onclick="printDiv('cl_no');" class="print_cl_btn" style="display: none; border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print CL</span>


<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){

        setTimeout(function() {
            '<?php if($cl_no_file != ""){ ?>'

            $(".print_cl_btn").click();
            window.location.href = '<?php echo base_url();?>access/care_label_packing';

            '<?php } ?>'
        }, 1000);

    }).delay(3000);


    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        window.close();
    }

</script>

</body>
</html>
