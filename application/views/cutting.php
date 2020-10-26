<style>
    .loader {
        border: 20px solid #f3f3f3;
        border-radius: 50%;
        border-top: 20px solid #3498db;
        width: 35px;
        height: 35px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Cutting - New</h1>
        <h2 class="">Cutting...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Cutting</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">Cutting</h3>
            </div>
            <div class="porlets-content">
<!--                <form action="--><?php //echo base_url();?><!--access/saveBundleCutNew" method="post">-->
                    <div class="row">
                        <div class="form-group">
                            <!--                            <div class="col-md-12">-->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select required class="form-control select" id="sap_no" name="sap_no" onchange="getForm();">
                                        <option value="">GROUP SO...</option>
                                        <?php foreach ($sap_no as $v){ ?>
                                            <option value="<?php echo $v['po_no'];?>"><?php echo $v['po_no'];?></option>
                                        <?php } ?>
                                    </select>
                                    <span style="font-size: 11px;">* SO / GROUP SO No.</span>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" readonly required class="form-control" id="brand" name="brand">
                                    <span style="font-size: 11px;">* Brand </span>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" readonly required class="form-control" id="style_no" name="style_no" value="<?php echo $po_item[0]['style_no'];?>">
                                    <span style="font-size: 11px;">* Style No. </span>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" readonly required class="form-control" id="style_name" name="style_name" value="<?php echo $po_item[0]['style_name'];?>">
                                    <span style="font-size: 11px;">* Style Name </span>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" readonly required class="form-control" id="quality" name="quality" value="<?php echo $po_item[0]['quality'];?>">
                                    <span style="font-size: 11px;">* Quality </span>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" readonly required class="form-control" id="color" name="color" value="<?php echo $po_item[0]['color'];?>">
                                    <span style="font-size: 11px;">* Color </span>
                                </div>
                            </div>

                        </div>
                    </div><!--/form-group-->

                    <div class="row">
                        <div class="form-group">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="po_type" id="po_type" required >
                                        <option value="">Select PO Type...</option>
                                        <option value="0">BULK</option>
                                        <option value="1">Size Set</option>
                                        <option value="2">Sample</option>
                                    </select>
                                    <span style="font-size: 11px;">* PO Type</span>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="style_type" id="style_type" required >
                                        <option value="">Style Type...</option>
                                        <option value="1">SOLID</option>
                                        <option value="2">CHECK</option>
                                        <option value="3">PRINT</option>
                                    </select>
                                    <span style="font-size: 11px;">* Style Type</span>
                                </div>
                            </div>

<!--                            <div class="col-md-2">-->
<!--                                <div class="form-group">-->
<!--                                    <select class="form-control select" name="table" id="table" required >-->
<!--                                        <option value="">Select Table...</option>-->
<!--                                        --><?php //foreach ($tables as $t){?>
<!--                                            <option value="--><?php //echo $t['id'];?><!--">--><?php //echo $t['table_name'];?><!--</option>-->
<!--                                        --><?php //} ?>
<!--                                    </select>-->
<!--                                    <span style="font-size: 11px;">* Select Table</span>-->
<!--                                </div>-->
<!--                            </div>-->

                            <div class="col-md-2">
                                <div class="form-group">
                                    <select required class="form-control select" id="cut_no" name="cut_no" onchange="getCutInfo();">
                                        <option value="">Select Cut No...</option>
                                        <?php
                                            foreach ($cut_no as $v_c){
                                        ?>
                                                <option value="<?php echo $v_c['cut_no'];?>"><?php echo $v_c['cut_no'];?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    <span style="font-size: 11px;">* Cut No.</span>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" required class="form-control" id="layer" name="layer">
                                    <span style="font-size: 11px;">* Layer </span>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <input type="text" readonly required class="form-control" id="planned_cut_qty" name="planned_cut_qty">
                                    <span style="font-size: 11px;">* Planned Cut Qty </span>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <input type="text" readonly required class="form-control" id="actual_cut_qty" name="actual_cut_qty">
                                    <input type="hidden" readonly required class="form-control" id="last_actual_cut_qty" name="last_actual_cut_qty">
                                    <span style="font-size: 11px;">* Actual Cut Qty </span>

                                    <input type="hidden" name="" id="so_no" value="" readonly>
                                    <input type="hidden" name="" id="exfacdate" value="" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <input type="number" required class="form-control" id="per_bundle_qty" name="per_bundle_qty" value="10">
                                    <span style="font-size: 11px;">* Per Bundle Qty </span>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <div id="loader" style="display: none;"><div class="loader"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div id="set_form">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="porlets-content">
                                    <div class="col-lg-6 col-md-6">
                                        <span id="save_btn_cut" class="btn btn-primary" onclick="saveBundleCut();">Save Cut</span>
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

<!--                </form>-->
            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('.select').select2();

    $(document).ready(function(){
//        $("#reload_div").load('<?php //echo base_url();?>//access/line_input_prod_data');

        setInterval(function(){

            $.ajax({
                url: "<?php echo base_url();?>access/checkSession/", //Change this URL as per your settings
                type: "POST",
                data: {},
                dataType: "html",
                success: function(newVal) {
                    if (newVal == ''){
                        location.reload(true);
                    }
                }
            });


        }, 60000);

        $("#message").empty();
    });

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
//            $("#cut_no [value='']").attr("selected","selected");
            window.location.reload(true);
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
        var style_type = $("#style_type").val();
        var per_bundle_qty = $("#per_bundle_qty").val();

        var so_no = $("#so_no").val();
        var exfacdate = $("#exfacdate").val();

        var quality = $("#quality").val();
        var po_type = $("#po_type").val();
//        var table = $("#table").val();
        var planned_cut_qty = $("#planned_cut_qty").val();
        var actual_cut_qty = $("#actual_cut_qty").val();
        var last_actual_cut_qty = $("#last_actual_cut_qty").val();
        var purchase_order_item = $("#purchase_order_item").val();

        var percentage_qty = parseInt(Math.round(planned_cut_qty * 0.05)) + parseInt(planned_cut_qty);

//        var so_no = [];
        var po = [];
        var item_no = [];
        var sizes = [];
        var qty = [];
        var lays = [];
//        var ex_factory_date = [];

        if(count_rows != '' && count_rows != 0 && count_rows != undefined && layer != '' && layer != 0 && layer != undefined && style_type != '' && style_type != 0 && style_type != undefined && cut_no != '' && cut_no != 0 && cut_no != undefined && po_type != '' && po_type != undefined && purchase_order_item != '' && purchase_order_item != 0 && purchase_order_item != undefined && per_bundle_qty != '' && per_bundle_qty != 0 && per_bundle_qty != undefined){
            for(var i=0; i < count_rows; i++){
                var ratio = $("#ratio"+i).val();
                if(ratio != '' && ratio != 0 && ratio != undefined){
                    var table_id = ("#new_tbl_"+i);

                    var rowCount = $(table_id+' tbody tr').length;

                    var so = $("#so_no_"+i).val();
                    var po_no = $("#purchase_order_"+i).val();
                    var item = $("#item_"+i).val();
//                    var ex_factory_dt = $("#exfacdate_"+i).val();

                    for (var j=0; j < rowCount; j++){

                        var size = $("#size_"+i+"_"+j).val();
                        var cut_qty = $("#qty_"+i+"_"+j).val();
                        var lay = $("#lay_"+i+"_"+j).val();
//                    console.log(table_id);
//                    console.log(j);

                        if(cut_qty != '' && cut_qty != 0 && cut_qty != undefined){
//                            so_no.push(so_no);
                            po.push(po_no);
                            item_no.push(item);
                            sizes.push(size);
                            qty.push(cut_qty);
                            lays.push(lay);
//                            ex_factory_date.push(ex_factory_dt);
                        }
                    }
                }
            }

            if(percentage_qty >= actual_cut_qty){
                $("#loader").css("display", "block");

                $.ajax({
                    url: "<?php echo base_url();?>access/saveBundleCutNew/",
                    type: "POST",
                    data: {sap_no: sap_no, so_no: so_no, ex_factory_date: exfacdate, cut_no: cut_no, brand: brand, style_no: style_no, style_name: style_name, color: color, quality: quality, po_type: po_type, style_type: style_type, actual_cut_qty: actual_cut_qty, planned_cut_qty: planned_cut_qty, size: sizes, qty: qty, item: item_no, purchase_order: po, lay: lays, per_bundle_qty: per_bundle_qty},
                    dataType: "html",
                    success: function (data) {
                        $("#set_form").empty();
                        $("#sap_no").trigger("change");
                        $("#cut_no").trigger("change");

                        $("#loader").css("display", "none");

//                        window.open("<?php //echo base_url();?>//bcps/generated_care_label_printing_pre.php?cut_tracking_no="+data, '_blank');
//                        window.open("<?php //echo base_url();?>//bcps/generated_bundle_tag_cc.php?cc=1&cut_tracking_no="+data, '_blank');
//                        window.open("<?php //echo base_url();?>//bcps/generated_bundle_tag_cc.php?cc=2&cut_tracking_no="+data, '_blank');
//                        var win = window.open("<?php //echo base_url();?>//bcps/generated_bundle_tag_bdy.php?cut_tracking_no="+data, '_blank');

                        window.open("<?php echo base_url();?>access/printCareLabels/"+sap_no+"/"+so_no+"/"+data, '_blank');
                        window.open("<?php echo base_url();?>access/printBundleTicketCC/"+sap_no+"/"+so_no+"/"+data+"/1", '_blank');
                        window.open("<?php echo base_url();?>access/printBundleTicketCC/"+sap_no+"/"+so_no+"/"+data+"/2", '_blank');
                        var win = window.open("<?php echo base_url();?>access/printBundleTicket/"+sap_no+"/"+so_no+"/"+data, '_blank');
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
        $("#loader").css("display", "block");

        if(sap_no != ''){
            $.ajax({
                url: "<?php echo base_url();?>access/getForm/",
                type: "POST",
                data: {sap_no: sap_no},
                dataType: "html",
                success: function (data) {
                    $("#set_form").append(data);
                    $("#loader").css("display", "none");
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

                    var po_type = data[0].po_type;
                    $("#po_type option[value='"+po_type+"']").attr('selected','selected');
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