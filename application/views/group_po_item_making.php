<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Cut-Group Making</h1>
        <a href="<?php echo base_url();?>access/groupSoReform" class="btn btn-warning">Group SO Reform</a>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Cut-Group Making</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="porlets-content">
                <div style="padding-top:10px">
                    <h6 style="color:red">
                        <?php
                        $exc = $this->session->userdata('exception');
                        if (isset($exc)) {
                            echo $exc;
                            $this->session->unset_userdata('exception');
                        }
                        ?>
                    </h6>

                    <h6 style="color:green">
                        <?php
                        $msg = $this->session->userdata('message');
                        if (isset($msg)) {
                            echo $msg;
                            $this->session->unset_userdata('message');
                        }
                        ?>
                    </h6>
                </div>

                <form action="<?php echo base_url();?>access/makeGroupPoItem" method="post">

                    <div id="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div id="set_form">
                                    <table class="display table table-bordered table-striped" id="sample_2">
                                        <thead>
                                            <tr>
                                                <th class="left" colspan="6">
                                                    <span id="save_btn_cut" class="btn btn-success" onclick="addNewRow();">Add</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="center">Sales Order</th>
                                                <th class="center">Purchase Order</th>
                                                <th class="center">Item</th>
                                                <th class="center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="center">
                                                    <input required list="sales_orders" name="sales_orders[]" id="sales_order0" onblur="isValidSo(id)">
                                                    <datalist id="sales_orders">
                                                            <option value="">Select Sales Order</option>
                                                            <?php foreach ($so_list as $v_so){ ?>
                                                                <option value="<?php echo $v_so['po_no'];?>"><?php echo $v_so['po_no'];?></option>
                                                            <?php } ?>
                                                    </datalist>
                                                </td>
                                                <td class="center">
                                                    <input required list="purchase_order" name="purchase_order[]" id="purchase_order0" onblur="isValidPo(id)">
                                                    <datalist id="purchase_order">
                                                            <option value="">Select PO</option>
                                                            <?php foreach ($po_list as $v_p){ ?>
                                                                <option value="<?php echo $v_p['purchase_order'];?>"><?php echo $v_p['purchase_order'];?></option>
                                                            <?php } ?>
                                                    </datalist>
                                                </td>
                                                <td class="center">
                                                    <input required list="items" name="items[]" id="item0" onblur="isValidItem(id)">
                                                    <datalist id="items">
                                                        <option value="">Select Item</option>
                                                        <?php foreach ($item_list as $v_i){ ?>
                                                            <option value="<?php echo $v_i['item'];?>"><?php echo $v_i['item'];?></option>
                                                        <?php } ?>
                                                    </datalist>
                                                </td>
                                                <td class="center">
                                                    <span id="save_btn_cut" class="btn btn-danger" onclick="removeTheRow(this);">Remove</span>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="porlets-content">
                                    <div class="col-lg-6 col-md-6">
                                        <button type="submit" id="save_btn_cut" class="btn btn-primary">Save</button>
<!--                                        <a style="display: none;" href="" id="generate_bundle_ticket" class="btn btn-success" >Generate Bundles Ticket</a>-->
<!--                                        <a style="display: none;" href="" id="generate_care_label" class="btn btn-warning" >Generate Care Label</a>-->

<!--                                        <button type="submit" id="save_btn" class="btn btn-primary">Save</button>-->
<!--                                        <button type="reset" id="reset_btn" class="btn btn-danger">Reset</button>-->
                                    </div>
                                    <div class="col-md-1" id="loader" style="display: none;"><div class="loader"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                <input type="hidden" nam="rowCount" id="rowCount" readonly />
            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('select').select2();

    function isValidSo(id) {
        var po_no = $("#"+id).val();

        if(po_no != ''){
            $.ajax({
                url: "<?php echo base_url();?>access/isValidSo/",
                type: "POST",
                data: {po_no: po_no},
                dataType: "json",
                success: function (data) {
                    console.log(data.length);

                    if(data.length == 0){
                        alert("Invalid Sales Order!");
                        $("#"+id).val('');
                    }
                }
            });
        }
    }

    function isValidPo(id) {
        var purchase_order = $("#"+id).val();

        var po_index = id.slice(14);

        var sales_order = $("#sales_order"+po_index).val();

        if(sales_order != '' && purchase_order != ''){
            $.ajax({
                url: "<?php echo base_url();?>access/isValidPo/",
                type: "POST",
                data: {sales_order: sales_order, purchase_order: purchase_order},
                dataType: "json",
                success: function (data) {
                    console.log(data.length);

                    if(data.length == 0){
                        alert("Invalid Purchase Order!");
                        $("#"+id).val('');
                    }
                }
            });
        }
    }

    function isValidItem(id) {
        var item = $("#"+id).val();
        var item_index = id.slice(4);

        var purchase_order = $("#purchase_order"+item_index).val();
        var sales_order = $("#sales_order"+item_index).val();


        if(sales_order != '' && purchase_order != '' && item != ''){
            $.ajax({
                url: "<?php echo base_url();?>access/isValidItem/",
                type: "POST",
                data: {sales_order: sales_order, purchase_order: purchase_order, item: item},
                dataType: "json",
                success: function (data) {
                    if(data.length == 0){
                        alert("Invalid Item!");
                        $("#"+id).val('');
                    }
                }
            });
        }
    }

    function addNewRow() {
        var rowCount = $('#sample_2 tbody tr').length;

        var rows = $("#rowCount").val();
        rows = (rows !='') ? parseInt(rows):0;

        var rowCount = rows + 1;

        $("#rowCount").val(rowCount);

        $("#sample_2 > tbody").append('<tr class="center"><td class="center"><input required list="sales_orders" name="sales_orders[]" onblur="isValidSo(id)" id="sales_order'+rowCount+'"><datalist id="sales_orders"><option value="">Select Sales Order</option>'+'<?php foreach ($so_list as $v_so){ ?>'+'<option value="'+'<?php echo $v_so['po_no'];?>'+'">'+'<?php echo $v_so['po_no'];?>'+'</option>'+'<?php } ?>'+'</datalist></td><td class="center"><input required list="purchase_order" name="purchase_order[]" onblur="isValidPo(id)" id="purchase_order'+rowCount+'"><datalist id="purchase_order"><option value="">Select PO</option>'+'<?php foreach ($po_list as $v_p){ ?>'+'<option value="'+'<?php echo $v_p['purchase_order'];?>'+'">'+'<?php echo $v_p['purchase_order'];?>'+'</option>'+'<?php } ?>'+'</datalist></td><td class="center"><input required list="items" name="items[]" onblur="isValidItem(id)" id="item'+rowCount+'"><datalist id="items"><option value="">Select Item</option>'+'<?php foreach ($item_list as $v_i){ ?>'+'<option value="'+'<?php echo $v_i['item'];?>'+'">'+'<?php echo $v_i['item'];?>'+'</option>'+'<?php } ?>'+'</datalist></td><td><span class="btn btn-danger" id="remove" onclick="removeTheRow(this);">Remove</span></td></tr>');

    }

//    function addNewRow() {
//        $("#rowToClone").clone().appendTo("#sample_2 > tbody");
//    }

    function removeTheRow(row) {
        var i = row.parentNode.parentNode.rowIndex;
        document.getElementById('sample_2').deleteRow(i);
    }

    function getCutInfo() {
        var cut_no = $("#cut_no").val();
        var sap_no = $("#sap_no").val();

        var actual_cut_qty = $("#actual_cut_qty").val();


        $("#planned_cut_qty").val(0);

        if(sap_no != ''){
            $.ajax({
                url: "<?php echo base_url();?>access/getCutInfo/",
                type: "POST",
                data: {sap_no: sap_no, cut_no: cut_no},
                dataType: "json",
                success: function (data) {
                    if(data.length > 0 && data[0].total_cut_qty > 0){
                        $("#last_actual_cut_qty").val(data[0].total_cut_qty);
                        $("#actual_cut_qty").val(data[0].total_cut_qty);
                        $("#planned_cut_qty").val(data[0].planned_cut_qty);

                    }else{
                        $("#last_actual_cut_qty").val(0);
                        $("#actual_cut_qty").val(0);
                    }

//                    if(data.length > 0 && data[0].planned_cut_qty > 0) {
//                        $("#planned_cut_qty").val(data[0].planned_cut_qty);
//                    }else{
//                        $("#planned_cut_qty").val(0);
//                    }
                }
            });
        }else{
            alert("SAP Number is not Selected!");
            $("#cut_no [value='']").attr("selected","selected");
        }


    }

    function saveBundleCut() {
        var count_rows = $("#count_rows").val();

        var sap_no = $("#sap_no").val();
        var cut_no = $("#cut_no").val();
        var layer = $("#layer").val();
        var brand = $("#brand").val();
        var style_no = $("#style_no").val();
        var style_name = $("#style_name").val();
        var color = $("#color").val();
        var quality = $("#quality").val();
        var table = $("#table").val();
        var planned_cut_qty = $("#planned_cut_qty").val();
        var actual_cut_qty = $("#actual_cut_qty").val();
        var last_actual_cut_qty = $("#last_actual_cut_qty").val();
        var purchase_order_item = $("#purchase_order_item").val();

        var percentage_qty = parseInt(Math.round(planned_cut_qty * 0.05)) + parseInt(planned_cut_qty);

        var po = [];
        var item_no = [];
        var sizes = [];
        var qty = [];
        var lays = [];

        if(count_rows != '' && count_rows != 0 && count_rows != undefined && layer != '' && layer != 0 && layer != undefined && cut_no != '' && cut_no != 0 && cut_no != undefined && table != '' && table != 0 && table != undefined && purchase_order_item != '' && purchase_order_item != 0 && purchase_order_item != undefined){
            for(var i=0; i < count_rows; i++){
                var ratio = $("#ratio"+i).val();
                if(ratio != '' && ratio != 0 && ratio != undefined){
                    var table_id = ("#new_tbl_"+i);

                    var rowCount = $(table_id+' tbody tr').length;

                    for (var j=0; j < rowCount; j++){
                        var po_no = $("#purchase_order_"+i+"_"+j).val();
                        var item = $("#item_"+i+"_"+j).val();
                        var size = $("#size_"+i+"_"+j).val();
                        var cut_qty = $("#qty_"+i+"_"+j).val();
                        var lay = $("#lay_"+i+"_"+j).val();
//                    console.log(table_id);
//                    console.log(j);

                        if(cut_qty != '' && cut_qty != 0 && cut_qty != undefined){
                            po.push(po_no);
                            item_no.push(item);
                            sizes.push(size);
                            qty.push(cut_qty);
                            lays.push(lay);
                        }
                    }
                }
            }

            if(percentage_qty >= actual_cut_qty){
                $("#loader").css("display", "block");

                $.ajax({
                    url: "<?php echo base_url();?>access/saveBundleCutNew/",
                    type: "POST",
                    data: {sap_no: sap_no, cut_no: cut_no, brand: brand, style_no: style_no, style_name: style_name, color: color, quality: quality, table: table, actual_cut_qty: actual_cut_qty, planned_cut_qty: planned_cut_qty, size: sizes, qty: qty, item: item_no, purchase_order: po, lay: lays},
                    dataType: "html",
                    success: function (data) {
                        $("#set_form").empty();
                        $("#sap_no").trigger("change");
                        $("#cut_no").trigger("change");

                        $("#loader").css("display", "none");

                        window.open("<?php echo base_url();?>bcps/generated_care_label_printing_pre.php?cut_tracking_no="+data, '_blank');
                        window.open("<?php echo base_url();?>bcps/generated_bundle_tag_cc.php?cc=1&cut_tracking_no="+data, '_blank');
                        window.open("<?php echo base_url();?>bcps/generated_bundle_tag_cc.php?cc=2&cut_tracking_no="+data, '_blank');
                        var win = window.open("<?php echo base_url();?>bcps/generated_bundle_tag_bdy.php?cut_tracking_no="+data, '_blank');
                        win.focus();
                    }
                });
            }else{
                alert("Please 5% Extra Qty Exceed!");
            }
        }else{
            alert("Please fill-up all the fields!");
        }
    }

    function getForm() {
        var sap_no = $("#sap_no").val();
//        $("#cut_no [value='']").attr("selected","selected");
//        $("#cut_no  option[value="+''+"]").prop("selected", true);

        $("#set_form").empty();

        if(sap_no != ''){
            $.ajax({
                url: "<?php echo base_url();?>access/getForm/",
                type: "POST",
                data: {sap_no: sap_no},
                dataType: "html",
                success: function (data) {
                    $("#set_form").append(data);
                }
            });

            $.ajax({
                url: "<?php echo base_url();?>access/getSapInfo/",
                type: "POST",
                data: {sap_no: sap_no},
                dataType: "json",
                success: function (data) {
                    $("#brand").val(data[0].brand);
                    $("#style_no").val(data[0].style_no);
                    $("#style_name").val(data[0].style_name);
                    $("#color").val(data[0].color);
                    $("#quality").val(data[0].quality);
                }
            });
        }
    }

    function getPOs() {
        var sap_no = $("#sap_no").val();

        $("#style_no").val('');
        $("#style_name").val('');
        $("#color").val('');
        $("#brand").val('');

        $("#color").empty();
        $("#po_no").empty();
        $("#item_no").empty();
        $("#quality").val('');
        $("#cut_tracking_no").val('');
        $("#sample_1 tbody tr").remove();

        if(sap_no != ''){
            $.ajax({
                url: "<?php echo base_url();?>access/getPOs/",
                type: "POST",
                data: {sap_no: sap_no},
                dataType: "html",
                success: function (data) {
                    $("#po_no").append(data);
                }
            });
        }
    }

    function getItems() {
        var po_no = $("#po_no").val();
        var sap_no = $("#sap_no").val();
        $("#cut_tracking_no").val('');
        $("#style_no").val('');
        $("#style_name").val('');
        $("#color").val('');
        $("#brand").val('');

        $("#color").empty();
        $("#item_no").empty();
        $("#quality").val('');
        $("#sample_1 tbody tr").remove();

        if((po_no != '') && (sap_no != '')){
            $.ajax({
                url: "<?php echo base_url();?>access/getItems/",
                type: "POST",
                data: {po_no: po_no, sap_no:sap_no},
                dataType: "html",
                success: function (data) {
                    $("#item_no").append(data);
                }
            });
        }
    }

    function getColors() {
        var po_no = $("#po_no").val();
        var sap_no = $("#sap_no").val();
        var item_no = $("#item_no").val();

        $("#cut_tracking_no").val('');
        $("#style_no").val('');
        $("#style_name").val('');
        $("#color").val('');
        $("#brand").val('');

        $("#color").empty();
        $("#quality").val('');
        $("#sample_1 tbody tr").remove();

        if((po_no != '') && (sap_no != '')){
            $.ajax({
                url: "<?php echo base_url();?>access/getColors/",
                type: "POST",
                data: {po_no: po_no, sap_no:sap_no, item_no:item_no},
                dataType: "html",
                success: function (data) {
                    $("#color").append(data);
                }
            });
        }
    }

    function getQuality() {
        var item_no = $("#item_no").val();
        var po_no = $("#po_no").val();
        var sap_no = $("#sap_no").val();
        var color = $("#color").val();

        var str_in_array = color.split(" ");

        var clr_code = '';

        if(str_in_array.length > 1){
            for (var i=0; i < str_in_array.length; i++){
                clr_code += str_in_array[i].charAt(0);
            }
        }
        else if(str_in_array.length == 1){
            clr_code = color;
        }

        $("#cut_tracking_no").val('');
        $("#style_no").val('');
        $("#style_name").val('');
        $("#color").val('');
        $("#brand").val('');

        var sapLastFour = sap_no.substr(sap_no.length - 4);
        var poLastFour = po_no.substr(po_no.length - 4);

        var styleLastFour = '';

        $("#quality").val('');
        $("#sample_1 tbody tr").remove();

        if((po_no != '') && (sap_no != '') && (item_no != '') && (color != '')){
            $.ajax({
                async: false,
                url: "<?php echo base_url();?>access/getQuality/",
                type: "POST",
                data: {po_no: po_no, sap_no:sap_no, item_no:item_no, color:color},
                dataType: "json",
                success: function (data) {
                    if (data != '') {
//                        console.log(data);
                        var quality = data[0].quality;
                        var color = data[0].color;
                        var style_no = data[0].style_no;
                        var style_name = data[0].style_name;
                        var brand = data[0].brand;

                        $("#quality").val(quality);
                        $("#style_no").val(style_no);
                        $("#style_name").val(style_name);
                        $("#color").val(color);
                        $("#brand").val(brand);

//                        console.log(style_no);

                        styleLastFour = style_no.substr(style_no.length - 4);
                    }
                }
            });

            $.ajax({
                async: false,
                url: "<?php echo base_url();?>access/getQualitySizes/",
                type: "POST",
                data: {po_no: po_no, sap_no:sap_no, item_no:item_no},
                dataType: "html",
                success: function (data) {
//                    console.log(data);
                    $('#sample_1 tbody').append(data);
                }
            });

            $.ajax({
                async: false,
                url: "<?php echo base_url();?>access/getCutNo/",
                type: "POST",
                data: {po_no: po_no, sap_no:sap_no, item_no:item_no},
                dataType: "html",
                success: function (data) {
                    data = (data != '') ? parseInt(data) : 0;

                    var count_cut = parseInt(data)+1;

                    var cut_tracking_no = styleLastFour+'_'+poLastFour+'_'+item_no+'_'+clr_code+'_'+count_cut;
                    $("#cut_tracking_no").val(cut_tracking_no);
                }
            });
        }
    }

    function calculateBalanceQty(index) {
        var cut_qty = $("#cut_qty"+index).val();
        cut_qty     = (cut_qty != '') ? parseInt(cut_qty) : 0;

        var order_qty = $("#order_qty"+index).val();
        order_qty     = (order_qty != '') ? parseInt(order_qty) : 0;

        var balance_qty = order_qty - cut_qty;
        balance_qty     = (balance_qty != '') ? parseInt(balance_qty) : 0;

        $("#balance_qty"+index).val(balance_qty);

    }

    function qtyValidity(id) {
        var qty = $("#"+id).val();
        qty = (qty != '') ? parseInt(qty) : 0;

        var layers = $("#layers").val();
        layers = (layers != '') ? parseInt(layers) : 0;

        if(layers != 0){
            if(qty != 0){
                var res = (qty%layers);
                if(res == 0){
                    $("#"+id).css('border-color', '');
                    $("#save_btn").attr('disabled', false);
                }else{
                    $("#"+id).val('');
                    $("#"+id).css('border-color', 'red');
                    $("#save_btn").attr('disabled', true);
                }
            }
            $("#layers").css('border-color', '');
        }else{
            $("#layers").css('border-color', 'red');
        }
    }
</script>