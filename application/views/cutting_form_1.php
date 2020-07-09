<div class="porlets-content">
    <div class="table-responsive">
        <table class="display table table-bordered table-striped" id="sample_1">
            <thead>
                <tr>
                    <th class="center" width="2%">Sizes</th>
                    <th class="center" width="2%">Order Qty</th>
                    <th class="center" width="2%">Ratio</th>

                    <?php
                    $count_tbl = 0;
                    $count_row = 0;

                    foreach ($po_item as $k => $v){
                        $count_tbl = $count_tbl + 1;
                        ?>

                        <th class="center" width="">
                            <select style="width: 130px;" name="" id="purchase_order_item<?php echo $k;?>" onchange="setPoItem(id, '<?php echo $k;?>');">
                                <option value="">PO-Item</option>
                                <?php foreach ($po_item as $k_1 => $v){?>
                                <option value="<?php echo $v['purchase_order'].'-'.$v['item'];?>"><?php echo $v['purchase_order'].'-'.$v['item'];?></option>
                                <?php } ?>
                            </select>

<!--                            Cut Qty - --><?php //echo $k+1;?>
                        </th>

                    <?php } ?>
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
                    </td>
                    <td style="width: 50px;"><input style="width: 50px;" type="text" name="order_qty[]" id="" value="<?php echo $v_s['total_qty'];?>"></td>
                    <td style="width: 50px;"><input style="width: 50px;" type="text" name="ratio[]" id="ratio<?php echo $k_s;?>" onblur="ratioAction(id)"></td>
                    <?php foreach ($po_item as $k_2 => $v_2){ ?>
                        <td class="center">
<!--                            <div class="new--><?php //echo $k_s?><!--">-->
<!--                                <input type="text" name="qty[]" id="" placeholder="--><?php //echo $v_s['size'].'_1'?><!--">-->
<!--                                <input readonly type="hidden" name="size[]" value="--><?php //echo $v_s['size'].'_1'?><!--" id="" />-->
<!--                            </div>-->



                            <!--
                                Table Class Format: new_tbl_col_row
                            -->

                            <table id="new_tbl_<?php echo $k_2.'_'.$k_s?>" border="0" align="center">
                                <tbody>
                                    <tr>
                                        <td><input style="width: 100px; display: none;" class="purchase_order<?php echo $k_2;?>" type="text" name="purchase_order_<?php echo $k_2;?>[]" id="purchase_order_<?php echo $k_2.'_'.$k_s.'_0'?>" value=""></td>
                                        <td><input style="width: 30px; display: none;" type="text" class="item<?php echo $k_2;?>" name="item_<?php echo $k_2;?>[]" id="item_<?php echo $k_2.'_'.$k_s.'_0';?>" value=""></td>
                                        <td>
                                            <input style="width: 60px;" type="text" class="cut_qty" name="qty_<?php echo $k_2;?>[]" id="qty_<?php echo $k_2.'_'.$k_s.'_0'?>" placeholder="<?php echo $v_s['size'].'_1';?>" />
                                            <input style="width: 30px;" readonly type="hidden" name="size_<?php echo $k_2;?>[]" value="<?php echo $v_s['size'];?>" id="size_<?php echo $k_2.'_'.$k_s.'_0'?>" />
                                            <input style="width: 30px;" readonly type="hidden" name="lay_<?php echo $k_2;?>[]" value="<?php echo 1;?>" id="lay_<?php echo $k_2.'_'.$k_s.'_0'?>" />
                                        </td>
                                        <td><span class="btn btn-success" style="font-size: 13px;" onclick="addNewRow('<?php echo $k_2;?>','<?php echo $k_s;?>');">+</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>

                    <?php } ?>
                    <!--<td>
                        <span class="btn btn-primary" onclick="alertRowCell(this, '<?php echo $k_s?>//');">ADD</span>
                    </td>-->
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <input readonly type="hidden" name="count_tables" id="count_tables" value="<?php echo $count_tbl;?>" />
        <input readonly type="hidden" name="count_rows" id="count_rows" value="<?php echo $count_row;?>" />
    </div>
</div>

<script type="text/javascript">

    $(document).on("change", ".cut_qty", function() {
        var sum = 0;
        $(".cut_qty").each(function(){
            sum += +$(this).val();
        });
        $("#actual_cut_qty").val(sum);
    });

    function setPoItem(id, k) {
        var po_item = $("#"+id).val();

        var po = po_item.split('-')[0];
        var item = po_item.split('-')[1];

        $(".purchase_order"+k).val(po);
        $(".item"+k).val(item);
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

function addNewRow(col_k, row_k) {
    var ratio = $("#ratio"+row_k).val();
//    var rowCount_1 = $('#'+table_id+' tbody tr').length;


    if((ratio != '') && (ratio != 0)){
        var count_tables = $("#count_tables").val();

        var table_id = "new_tbl_"+col_k+"_"+row_k;
        var rowCount = $('#'+table_id+' tbody tr').length;

        var purchase_order_id = "purchase_order_"+col_k+"_"+row_k+"_0";
        var item_id = "item_"+col_k+"_"+row_k+"_0";
        var qty_id = "qty_"+col_k+"_"+row_k+"_0";
        var size_id = "size_"+col_k+"_"+row_k+"_0";
        var lay_id = "lay_"+col_k+"_"+row_k+"_0";

        var purchase_order = $('#'+purchase_order_id).val();
        var item = $('#'+item_id).val();
        var size = $('#'+size_id).val();
        var lay = $('#'+lay_id).val();


        var purchase_order_item_id = "purchase_order_item"+col_k;

        var purchase_order_item = $('#'+purchase_order_item_id).val();

        var po = purchase_order_item.split('-')[0];
        var item_no = purchase_order_item.split('-')[1];

        if(item_no === undefined){
            item_no = '';
        }

        console.log(po);
    console.log(item_no);
//    console.log(qty);
//    console.log(size);
//    console.log(lay);

        var row_number = rowCount + 1;

        $('#'+table_id+' tbody').append('<tr><td><input style="width: 100px; display: none;" class="purchase_order'+col_k+'" type="text" name="purchase_order_'+col_k+'[]" id="purchase_order_'+col_k+'_'+row_k+'_'+rowCount+'" value="'+po+'"></td><td><input style="width: 30px; display: none;" type="text" class="item'+col_k+'" name="item_'+col_k+'[]" id="item_'+col_k+'_'+row_k+'_'+rowCount+'" value="'+item_no+'"></td><td><input style="width: 60px;" type="text" class="cut_qty" name="qty_'+col_k+'[]" id="qty_'+col_k+'_'+row_k+'_'+rowCount+'" placeholder="'+size+'_'+row_number+'" /><input style="width: 30px;" readonly type="hidden" name="size_'+col_k+'[]" value="'+size+'" id="size_'+col_k+'_'+row_k+'_'+rowCount+'" /><input style="width: 30px;" readonly type="hidden" name="lay_'+col_k+'[]" value="'+row_number+'" id="lay_'+col_k+'_'+row_k+'_'+rowCount+'" /></td><td><span class="btn btn-danger" style="font-size: 13px;"  onclick="deleteRow(this, '+col_k+', '+row_k+');">X</span></td></tr>');
    }
}

function deleteRow(row, col_k, row_k)
{
    var ratio = $("#ratio"+row_k).val();

    var table_id = "new_tbl_"+col_k+"_"+row_k;

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

</script>
