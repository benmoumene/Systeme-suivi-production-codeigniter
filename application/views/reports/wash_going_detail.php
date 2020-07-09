<br />
<button type="button" onclick="printDiv('print_area')" class="print_cl_btn" style="border-style: none; width: 80px; height: 30px; background-color: green; color: white; border-radius: 5px;">Print</button>
<div id="print_area">
<table class="display table table-bordered table-striped" id="" border="1">
    <thead>
    <tr>
        <th class="hidden-phone center" colspan="13"><h3>Sending Date: <?php echo $date;?></h3></th>
    </tr>
    <tr>
        <th class="hidden-phone center">INR No.</th>
        <th class="hidden-phone center">Brand</th>
        <th class="hidden-phone center">Purchase Order</th>
        <th class="hidden-phone center">Item</th>
        <th class="hidden-phone center">Style</th>
        <th class="hidden-phone center">Quality</th>
        <th class="hidden-phone center">Color</th>
    </tr>
    </thead>

    <tbody>
    <?php

    foreach ($wash_detail as $v){
    ?>
    <tr>
        <td class="center"><?php echo $v['pc_tracking_no'];?></td>
        <td class="center"><?php echo $v['brand'];?></td>
        <td class="center"><?php echo $v['purchase_order'];?></td>
        <td class="center"><?php echo $v['item'];?></td>
        <td class="center"><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
        <td class="center"><?php echo $v['quality'];?></td>
        <td class="center"><?php echo $v['color'];?></td>
    </tr>

    <?php
    }
    ?>

    </tbody>

</table>
</div>

<script type="text/javascript">

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        location.reload();
    }

</script>