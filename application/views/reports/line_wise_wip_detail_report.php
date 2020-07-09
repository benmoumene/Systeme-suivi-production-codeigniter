<br />
<button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
<br />
<br />
<div id="tableWrap">
    <table class="display table table-bordered table-striped" id="" border="1">
        <thead>
            <tr>
                <th class="hidden-phone center" colspan="7"><h3><?php echo $line_name;?></h3></th>
                <th class="hidden-phone center" colspan="7"><h3><?php echo $search_date;?></h3></th>
            </tr>
            <tr>
                <th class="hidden-phone center">SO</th>
                <th class="hidden-phone center">PO</th>
                <th class="hidden-phone center">Item</th>
                <th class="hidden-phone center">Quality</th>
                <th class="hidden-phone center">Color</th>
                <th class="hidden-phone center">Style</th>
                <th class="hidden-phone center">Style Name</th>
                <th class="hidden-phone center">Ex-Fac-Date</th>
                <th class="hidden-phone center">Balance</th>
            </tr>
        </thead>
        <tbody>

        <?php

        $total_line_wip_po_qty = 0;

        foreach ($wip_detail as $v){

            $total_line_wip_po_qty += $v['line_po_balance'];

            ?>
            <tr>
                <th class="hidden-phone center"><?php echo $v['so_no']?></th>
                <th class="hidden-phone center"><?php echo $v['purchase_order']?></th>
                <th class="hidden-phone center"><?php echo $v['item']?></th>
                <th class="hidden-phone center"><?php echo $v['quality']?></th>
                <th class="hidden-phone center"><?php echo $v['color']?></th>
                <th class="hidden-phone center"><?php echo $v['style_no']?></th>
                <th class="hidden-phone center"><?php echo $v['style_name']?></th>
                <th class="hidden-phone center"><?php echo $v['ex_factory_date']?></th>
                <th class="hidden-phone center">
                    <span class="center btn btn-danger" data-target="#myModal2" data-toggle="modal" onclick="getPoItemWiseLineRemainCL('<?php echo $v['so_no']; ?>', '<?php echo $line_id; ?>');">
                        <?php echo $v['line_po_balance'];?>
                    </span>
                </th>
            </tr>
        <?php } ?>

        </tbody>
        <tfoot>

            <tr>
                <th class="hidden-phone" style="text-align: right;" colspan="8"><h5>TOTAL WIP</h5></th>
                <th class="hidden-phone center"><h5><?php echo $total_line_wip_po_qty;?></h5></th>
            </tr>

        </tfoot>
    </table>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>

            <div class="modal-body">
                <div class="col-md-3 scroll4">
                    <div class="porlets-content">
                        <div class="table-responsive" id="remain_cl_list">

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })


    function getPoItemWiseLineRemainCL(so_no, line_id) {
        $("#remain_cl_list").empty();

        $.ajax({
            url: "<?php echo base_url();?>dashboard/getPoItemWiseLineRemainCL/",
            type: "POST",
            data: {so_no: so_no, line_id: line_id},
            dataType: "html",
            success: function (data) {
                $("#remain_cl_list").append(data);
            }
        });
    }

</script>