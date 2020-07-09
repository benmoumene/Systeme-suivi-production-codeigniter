<br />
<button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
<br />
<br />
<div id="tableWrap">
    <table class="display table table-bordered table-striped" id="" border="1">
        <thead>
        <tr>
            <th class="hidden-phone center" colspan="5"><h3><?php echo $floor_name;?></h3></th>
            <th class="hidden-phone center" colspan="4"><h3><?php echo $search_date;?></h3></th>
        </tr>
        <tr>
            <th class="hidden-phone center">Brand</th>
            <th class="hidden-phone center">PO</th>
            <th class="hidden-phone center">Item</th>
            <th class="hidden-phone center">Style</th>
            <th class="hidden-phone center">Style Name</th>
            <th class="hidden-phone center">Quality</th>
            <th class="hidden-phone center">Color</th>
            <th class="hidden-phone center">ExFac Date</th>
            <th class="hidden-phone center">Output Qty</th>
        </tr>
        </thead>
        <tbody>

        <?php

        $total_output_po_qty = 0;

        foreach ($finishing_report as $v){

            $total_output_po_qty += $v['carton_qty'];
            ?>
            <tr>
                <th class="hidden-phone center"><?php echo $v['brand']?></th>
                <th class="hidden-phone center"><?php echo $v['purchase_order']?></th>
                <th class="hidden-phone center"><?php echo $v['item']?></th>
                <th class="hidden-phone center"><?php echo $v['style_no']?></th>
                <th class="hidden-phone center"><?php echo $v['style_name']?></th>
                <th class="hidden-phone center"><?php echo $v['quality']?></th>
                <th class="hidden-phone center"><?php echo $v['color']?></th>
                <th class="hidden-phone center"><?php echo $v['ex_factory_date']?></th>
                <th class="hidden-phone center"><?php echo $v['carton_qty']?></th>
            </tr>
        <?php } ?>

        </tbody>
        <tfoot>

        <tr>
            <th class="hidden-phone" style="text-align: right;" colspan="8"><h5>TOTAL</h5></th>
            <th class="hidden-phone center"><h5><?php echo $total_output_po_qty;?></h5></th>
        </tr>

        </tfoot>
    </table>
</div>

<script type="text/javascript">

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

</script>