<div class="col-md-8">
    <div class="porlets-content">
        <div class="table-responsive">
            <table class="display table table-bordered table-striped" id="sample_1" width="50%">
                <thead>
                    <tr>
                        <th class="center" width="2%">Sizes</th>
                        <th class="center" width="2%">SAP Qty</th>
                        <th class="center" width="2%">Ratio</th>
                        <th class="center" width="10%">PO~Item Qty</th>
                        <th class="center" width="2%">Balance Qty</th>

                        <?php
    //                    $count_tbl = 0;
    //                    $count_row = 0;

    //                    foreach ($po_item as $k => $v){
    //                        $count_tbl = $count_tbl + 1;
                            ?>

                            <th class="center" width="44%">
                                <select style="width: 130px;" name="" id="purchase_order_item" onchange="setPoItem(id);">
                                    <option value="">PO-Item</option>
                                    <?php foreach ($po_item as $k_1 => $v){ ?>
                                    <option value="<?php echo $v['purchase_order'].'~'.$v['item'].'~'.$sap_no.'~'.$v['so_no'].'~'.$v['quality'].'~'.$v['color'].'~'.$v['style_no'].'~'.$v['style_name'];?>"><?php echo $v['purchase_order'].'~'.$v['item'];?></option>
                                    <?php } ?>
                                </select>
    <!--                            Cut Qty - --><?php //echo $k+1;?>
                            </th>

    <!--                    --><?php //} ?>
    <!--                    <th class="center" width="10%">Action</th>-->
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($sizes as $k_s => $v_s){
                    $count_row = $count_row + 1;
                ?>
                    <tr>
                        <td>
                            <?php echo $v_s['size'];?>
                            <input type="hidden" name="" id="size<?php echo $k_s?>" value="<?php echo $v_s['size']?>" readonly>
                            <input type="hidden" name="" id="po_no_<?php echo $k_s?>" value="" readonly>
<!--                            <input type="hidden" name="" id="so_no_--><?php //echo $k_s?><!--" value="" readonly>-->
                            <input type="hidden" name="" id="purchase_order_<?php echo $k_s?>" value="" readonly>
                            <input type="hidden" name="" id="item_<?php echo $k_s?>" value="" readonly>
<!--                            <input type="hidden" name="" id="exfacdate_--><?php //echo $k_s?><!--" value="" readonly>-->
                        </td>
                        <td style="width: 50px;">
                            <input style="width: 50px;" type="text" readonly name="order_qty[]" id="sap_order_qty<?php echo $k_s?>" value="<?php echo $v_s['total_qty'];?>">
                        </td>
                        <td style="width: 50px;"><input style="width: 50px;" type="text" class="ratio" name="ratio[]" id="ratio<?php echo $k_s;?>" onblur="ratioAction(id)"></td>
                        <td style="width: 50px;"><input style="width: 50px;" readonly type="text" class="po_item_qty" name="po_item_qty[]" id="po_item_qty<?php echo $k_s;?>" ></td>
                        <td style="width: 50px;"><input style="width: 50px;" readonly type="text" class="balance_qty" name="balance_qty[]" id="balance_qty<?php echo $k_s;?>" ></td>
    <!--                    --><?php //foreach ($po_item as $k_2 => $v_2){ ?>
                        <td class="center">
    <!--                            <div class="new--><?php //echo $k_s?><!--">-->
    <!--                                <input type="text" name="qty[]" id="" placeholder="--><?php //echo $v_s['size'].'_1'?><!--">-->
    <!--                                <input readonly type="hidden" name="size[]" value="--><?php //echo $v_s['size'].'_1'?><!--" id="" />-->
    <!--                            </div>-->



                                <!--
                                    Table Class Format: new_tbl_col_row
                                -->

                                <table id="new_tbl_<?php echo $k_s?>" border="0" align="center">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input style="width: 100px; display: none;" class="so_no" type="text" name="so_no[]" id="so_no_<?php echo $k_s.'_0'?>" value="">
                                                <input style="width: 100px; display: none;" class="purchase_order" type="text" name="purchase_order[]" id="purchase_order_<?php echo $k_s.'_0'?>" value="">
                                            </td>
                                            <td><input style="width: 30px; display: none;" type="text" class="item" name="item[]" id="item_<?php echo $k_s.'_0';?>" value=""></td>
                                            <td>
                                                <input style="width: 60px;" type="text" class="cut_qty" name="qty[]" id="qty_<?php echo $k_s.'_0'?>" placeholder="<?php echo $v_s['size'].'_1';?>" />
                                                <input style="width: 30px;" readonly type="hidden" name="size[]" value="<?php echo $v_s['size'];?>" id="size_<?php echo $k_s.'_0'?>" />
                                                <input style="width: 30px;" readonly type="hidden" name="lay[]" value="<?php echo 1;?>" id="lay_<?php echo $k_s.'_0'?>" />
                                            </td>
                                            <td><span class="btn btn-success" style="font-size: 13px;" onclick="addNewRow('<?php echo $k_s;?>');">+</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                        </td>

    <!--                    --><?php //} ?>
                        <!--<td>
                            <span class="btn btn-primary" onclick="alertRowCell(this, '<?php echo $k_s?>//');">ADD</span>
                        </td>-->
                    </tr>
                <?php } ?>
                </tbody>
            </table>

<!--            <input readonly type="text" name="count_tables" id="count_tables" value="--><?php //echo $count_tbl;?><!--" />-->
            <input readonly type="hidden" name="count_rows" id="count_rows" value="<?php echo $count_row;?>" />
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="porlets-content">
        <table class="display table table-bordered table-striped" id="sample_2">
        <thead>
            <th class="center">PO~ITEM</th>
            <?php
            $size_count = 1;
            foreach ($sizes as $k_s => $v_s) {
                $size_count++;
            }
                ?>
                <th class="center" colspan="<?php echo $size_count;?>">Sizes</th>

        </thead>
        <tbody>
        <?php
            foreach ($po_item as $k_p => $v_p){
        ?>
<!--        <section class="panel default blue_border vertical_border h1">-->
<!--            <div class="task-footer">-->
<!--                <div class="pull-left">-->
<!--                    <ul class="footer-icons-group">-->
<!--                        <li><a href="#"><i class="fa">--><?php //echo $v_p['purchase_order'];?><!--</i></a></li>-->
<!--                        <li><a href="#"><i class="fa">--><?php //echo $v_p['item'];?><!--</i></a></li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                <label class="pull-right">-->
<!--                    <div class="progress">-->
<!--                        <div style="width:60%;" aria-valuemax="100" aria-valuemin="0" data-toggle="tooltip" title="60" aria-valuenow="60" role="progressbar" class="progress-bar progress-bar-info"> <span class="sr-only">60% Complete</span> </div>-->
<!--                    </div>-->
<!--                </label>-->
<!--                <span class="label btn-primary" style="font-size: 12px;">60</span>-->
<!---->
<!--            </div>-->
<!--        </section>-->
                <tr>
                    <td class="center"><?php echo $v_p['purchase_order'].'~'.$v_p['item'];?></td>
                    <td class="center">
                        <?php
                        $po_item_size_cut_qty = $this->method_call->getSizeWisePoItemCutQty($sap_no, $v_p['so_no'], $v_p['purchase_order'], $v_p['item'], $v_p['quality'], $v_p['color']);

                        foreach ($po_item_size_cut_qty as $k_v_pc => $v_pc){
                            $po_item_size_wise_order_qty = ($v_pc['po_item_size_wise_order_qty'] == '' ? 0 : $v_pc['po_item_size_wise_order_qty']);
                            $po_item_size_wise_cut_qty = ($v_pc['po_item_size_wise_cut_qty'] == '' ? 0 : $v_pc['po_item_size_wise_cut_qty']);
                            ?>
                            <div style="float: left; width: 30px; height: 20px; <?php if($po_item_size_wise_order_qty <= $po_item_size_wise_cut_qty){ ?>background-color: green; <?php } else{ ?>background-color: red; <?php } ?> text-align: center; color: white" data-toggle="tooltip" title="<?php echo $po_item_size_wise_order_qty.' ~ '.$po_item_size_wise_cut_qty;?>">
                                <?php echo $v_pc['size'];?>
                            </div>
                        <?php } ?>
                    </td>
                </tr>

        <?php } ?>
        </tbody>
        </table>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).on("change", ".cut_qty", function() {
        var sum = 0;
        var last_actual_cut_qty = parseInt($("#last_actual_cut_qty").val());

        $(".cut_qty").each(function(){
            sum += +$(this).val();
        });
        $("#actual_cut_qty").val(sum+last_actual_cut_qty);
//        $("#actual_cut_qty").val(sum);
    });

    function setPoItem(id) {
        var po_item = $("#"+id).val();

        var po = po_item.split('~')[0];
        var item = po_item.split('~')[1];
        var sap_no = po_item.split('~')[2];
        var so_no = po_item.split('~')[3];
        var quality = po_item.split('~')[4];
        var color = po_item.split('~')[5];
        var style_no = po_item.split('~')[6];
        var style_name = po_item.split('~')[7];

        $("#color").val(color);
        $("#quality").val(quality);
        $("#style_no").val(style_no);
        $("#style_name").val(style_name);

        $(".po_item_qty").val('');
        $(".balance_qty").val('');

        var rowCount = $("#sample_1 >tbody >tr").length;
        $("#so_no").val(so_no);

        for (var i=0; i < rowCount; i++){
            var size = $("#size"+i).val();

//            console.log(po+' - '+item+' - '+quality+' - '+color+' - '+size);

            $("#po_no_"+i).val(sap_no);

            $("#purchase_order_"+i).val(po);
            $("#item_"+i).val(item);

            var sap_order_qty = $("#sap_order_qty"+i).val();

            $.ajax({
                async: false,
                url: "<?php echo base_url();?>access/getPoItemSizeOrderQty/",
                type: "POST",
                data: {sap_no: sap_no, so_no: so_no, po_no: po, item: item, quality: quality, color: color, size: size},
                dataType: "json",
                success: function (data) {
//                    console.log(data[0].cut_qty);

//                    console.log(data);

                    if(data.length > 0){
                        var po_size_order_qty = (data[0].order_qty == null && data[0].order_qty == '' ? 0 : data[0].order_qty);
                        var po_size_cut_qty = (data[0].cut_qty == null && data[0].cut_qty == '' ? 0 : data[0].cut_qty);

//                        console.log(po_size_order_qty);

                        $("#po_item_qty" + i).val(po_size_order_qty);

                        var balance_qty = po_size_order_qty - po_size_cut_qty;

                        $("#balance_qty" + i).val(balance_qty);

                        $("#exfacdate").val(data[0].ex_factory_date);
                    }

                }
            });
        }


        $(".purchase_order").val(po);
        $(".item").val(item);
    }
    
//    var counter = 1;
//    var limit = 3;
//    function addInput(divName){
//        if (counter == limit)  {
//            alert("You have reached the limit of adding " + counter + " inputs");
//        }
//        else {
//            var newdiv = document.createElement('div');
//            newdiv.innerHTML = "Entry " + (counter + 1) + " <br><input type='text' name='myInputs[]'>";
//            document.getElementById(divName).appendChild(newdiv);
//            counter++;
//        }
//    }


    var tbl = document.getElementsByTagName("table")[0];

//    function alertRowCell (e, k) {

//        var col_length = document.getElementById('sample_1').rows[0].cells.length;
//
//        var without_last_td_length = col_length - 2;
//
////        if(col_length > 3){
////
////        }
//
//        var row_number = e.parentNode.parentNode.rowIndex;
//
//        for (var i=3; i <= without_last_td_length; i++){
////            document.getElementById('sample_1').tr:eq(row_number).td:eq(i).append("Here Input box");
//            var inputBox = '<input type="text" name="qty[]" id="" />';
////            document.getElementById('sample_1').rows[row_number].cells[i].appendChild(inputBox);
//            $(".new"+k).append(inputBox);
//
//            alert(row_number + ' : ' + i);
//        }

//        var cell = e.target || window.event.srcElement;
//        if ( cell.cellIndex >= 0 )
//            alert( cell.cellIndex + ' : ' + cell.parentNode.rowIndex );
//    }

//    if ( tbl.addEventListener ) {
//        tbl.addEventListener("click", alertRowCell, false);
//    } else if ( tbl.attachEvent ) {
//        tbl.attachEvent("onclick", alertRowCell);
//    }


function ratioAction(id) {
//    var count_tables = $("#count_tables").val();
//    var ratio = $("#"+id).val();
//
//    for(var i=1; i < ratio; i++){
//        addNewRow(0, 0);
//        addNewRow(1, 0);
//        addNewRow(2, 0);
//    }
}

function addNewRow(row_k) {
    var ratio = $("#ratio"+row_k).val();

    var table_id = "new_tbl_"+row_k;

    var rowCount = $('#'+table_id+' tbody tr').length;

    if((ratio != '') && (ratio != 0)){
//        var count_tables = $("#count_tables").val();

        var cnt = rowCount + 1;

        console.log(ratio);
        console.log(cnt);

        if(ratio >= cnt){
            var so_no_id = "so_no_"+row_k+"_0";
            var purchase_order_id = "purchase_order_"+row_k+"_0";
            var item_id = "item_"+row_k+"_0";
            var qty_id = "qty_"+row_k+"_0";
            var size_id = "size_"+row_k+"_0";
            var lay_id = "lay_"+row_k+"_0";

            var so_no = $('#'+so_no_id).val();
            var purchase_order = $('#'+purchase_order_id).val();
            var item = $('#'+item_id).val();
            var size = $('#'+size_id).val();
            var lay = $('#'+lay_id).val();

            var purchase_order_item_id = "purchase_order_item";

            var purchase_order_item = $('#'+purchase_order_item_id).val();

            var po = purchase_order_item.split('~')[0];
            var item_no = purchase_order_item.split('~')[1];
            var so = purchase_order_item.split('~')[2];

            if(item_no === undefined){
                item_no = '';
            }

//        console.log(po);
//    console.log(item_no);
//    console.log(qty);
//    console.log(size);
//    console.log(lay);

            var row_number = rowCount + 1;

            $('#'+table_id+' tbody').append('<tr><td><input style="width: 100px; display: none" class="so_no" type="text" name="so_no[]" id="so_no_'+row_k+'_'+rowCount+'" value="'+so+'"><input style="width: 100px; display: none" class="purchase_order" type="text" name="purchase_order[]" id="purchase_order_'+row_k+'_'+rowCount+'" value="'+po+'"></td><td><input style="width: 30px; display: none" type="text" class="item" name="item[]" id="item_'+row_k+'_'+rowCount+'" value="'+item_no+'"></td><td><input style="width: 60px;" type="text" class="cut_qty" name="qty[]" id="qty_'+row_k+'_'+rowCount+'" placeholder="'+size+'_'+row_number+'" /><input style="width: 30px;" readonly type="hidden" name="size[]" value="'+size+'" id="size_'+row_k+'_'+rowCount+'" /><input style="width: 30px;" readonly type="hidden" name="lay[]" value="'+row_number+'" id="lay_'+row_k+'_'+rowCount+'" /></td><td><span class="btn btn-danger" style="font-size: 13px;"  onclick="deleteRow(this, '+row_k+');">X</span></td></tr>');
        }
        if(ratio < cnt){
            alert("Ratio met!");
        }
    }
}

function deleteRow(row, row_k)
{
    var ratio = $("#ratio"+row_k).val();

    var table_id = "new_tbl_"+row_k;

    var rowCount = $('#'+table_id+' tbody tr').length;

    var row_index = row.parentNode.parentNode.rowIndex;
    var row_index_num = (row_index + 1);

    if(row_index_num <= ratio){
        alert("Ratio Mismatch!");
    }

    if((rowCount > ratio) && (row_index_num != ratio)){
        var i = row.parentNode.parentNode.rowIndex;
        document.getElementById(table_id).deleteRow(i);
    }
}

    $(document).on("change", ".ratio", function() {
        var sum = 0;
        $(".ratio").each(function(){
            sum += +$(this).val();
        });
        var layer = $("#layer").val();
        $("#planned_cut_qty").val(sum * layer);
    });


    $(document).on("change", "#layer", function() {
        var sum = 0;
        $(".ratio").each(function(){
            sum += +$(this).val();
        });
        var layer = $("#layer").val();
        $("#planned_cut_qty").val(sum * layer);
    });

</script>