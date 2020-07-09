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

<label>Remaining PCs:</label><input type="text" readonly value="<?php echo $count_pcs;?>" name="total_qty" id="total_qty">
<label>Print Qty:</label><input type="text" name="print_qty" id="print_qty">

<button type="button" onclick="getRemainingClList();" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Check</button>

<div id="cl_list">

</div>


<footer>
    <script src="<?php echo base_url();?>assets/js/jquery-2.1.0.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
</footer>
</body>

</html>

<script type="text/javascript">

    window.addEventListener('keydown', function(event) {
        if (event.keyCode === 80 && (event.ctrlKey || event.metaKey) && !event.altKey && (!event.shiftKey || window.chrome || window.opera)) {
            event.preventDefault();
            if (event.stopImmediatePropagation) {
                event.stopImmediatePropagation();
            } else {
                event.stopPropagation();
            }
            return;
        }
    }, true);

    function printDiv(divName) {
        var print_qty = $("#print_qty").val();
        var total_qty = $("#print_qty").val();

        if(print_qty != "" && print_qty != 0 && print_qty > 0 && total_qty >= print_qty){

            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

            var cut_tracking_no = '<?php echo $cut_tracking_no;?>';
            var so_no = '<?php echo $so_no;?>';

//        alert(cut_tracking_no);

            $.ajax({
                url: "<?php echo base_url();?>access/updatingCLPrintLog/",
                type: "POST",
                data: {so_no: so_no, cut_tracking_no: cut_tracking_no, print_qty: print_qty},
                dataType: "html",
                success: function (data) {
//                    console.log(data);
                    window.location.reload(true);
                }
            });

        }else{
            alert("Please Input Valid Qty!");
            $("#print_qty").val('');
        }
    }

    function getRemainingClList() {
        var print_qty = $("#print_qty").val();
        var total_qty = $("#print_qty").val();

        var cut_tracking_no = '<?php echo $cut_tracking_no;?>';
        var so_no = '<?php echo $so_no;?>';
        var po_no = '<?php echo $po_no;?>';

        $("#cl_list").empty();

        if(print_qty != "" && print_qty != 0 && print_qty > 0 && total_qty != "" && total_qty != 0 && total_qty > 0 && total_qty >= print_qty){
            $.ajax({
                url: "<?php echo base_url();?>access/getPrintCareLabels/",
                type: "POST",
                data: {so_no: so_no, po_no: po_no, cut_tracking_no: cut_tracking_no, print_qty: print_qty},
                dataType: "html",
                success: function (data) {

                    $("#cl_list").append(data);

                }
            });
        }else{
            alert("Please Input Valid Qty!");
            $("#print_qty").val('');
        }

    }

</script>