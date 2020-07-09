<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
      <h1>Cutting</h1>
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
                <form action="<?php echo base_url();?>access/saveBundleCut" method="post">
                    <div class="row">
                        <div class="form-group">
<!--                            <div class="col-md-12">-->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select required type="text" class="form-control" id="sap_no" name="sap_no" onchange="getPOs();">
                                            <option value="">Select SAP No...</option>
                                            <?php foreach ($sap_no as $v){ ?>
                                                <option value="<?php echo $v['po_no'];?>"><?php echo $v['po_no'];?></option>
                                            <?php } ?>
                                        </select>
                                        <span style="font-size: 11px;">* SAP No.</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select required class="form-control" id="po_no" name="po_no" onchange="getItems();">
                                            <option value="">Select PO No...</option>
                                        </select>
                                        <span style="font-size: 11px;">* PO No.</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select required class="form-control" id="item_no" name="item_no" onchange="getColors();">
                                            <option value="">Select Item No...</option>
                                        </select>
                                        <span style="font-size: 11px;">* Item No.</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control" name="color" id="color" onchange="getQuality();">
                                            <option>Select Color...</option>
                                        </select>
                                        <span style="font-size: 11px;">* Select Color</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Quality" name="quality" id="quality" required readonly />
                                        <span style="font-size: 11px;">* Quality No.</span>
                                    </div>
                                </div>
<!--                            </div>-->
                        </div>
                    </div><!--/form-group-->

                    <div class="row">
                        <div class="form-group">
<!--                            <div class="col-md-12">-->

                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" placeholder="Style No" class="form-control" name="style_no" id="style_no" required readonly />
                                    <span style="font-size: 11px;">* Style No.</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" placeholder="Style Name" class="form-control" name="style_name" id="style_name" required readonly />
                                    <span style="font-size: 11px;">* Style Name.</span>
                                </div>
                            </div>
<!--                            <div class="col-md-1">-->
<!--                                <div class="form-group">-->
<!--                                    <input type="text" placeholder="Color" class="form-control" name="color" id="color" required readonly />-->
<!--                                    <span style="font-size: 11px;">* Color.</span>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" placeholder="Brand" class="form-control" name="brand" id="brand" required readonly />
                                    <span style="font-size: 11px;">* Brand.</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" placeholder="Cut Tracking No." class="form-control" name="cut_tracking_no" id="cut_tracking_no" required readonly />
                                    <span style="font-size: 11px;">* Cut Tracking No.</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="table" id="table" required >
                                        <option value="">Select table...</option>
                                        <?php foreach ($tables as $t){?>
                                            <option value="<?php echo $t['table_name'];?>"><?php echo $t['table_name'];?></option>
                                        <?php } ?>
                                    </select>
                                    <span style="font-size: 11px;">* Select Table</span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" placeholder="Number of Layers" class="form-control" name="layers" id="layers" required />
                                    <span style="font-size: 11px;">* Number of Layers</span>
                                </div>
                            </div>
<!--                            </div>-->
                        </div>
                    </div><!--/form-group-->

                    <div class="row">
                        <div class="form-group">
                            <div class="porlets-content">
                                <div class="col-md-6">
                                <div class="table-responsive">
                                    <table  cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th class="hidden-phone">Size</th>
                                                <th class="hidden-phone">Order Qty</th>
                                                <th class="hidden-phone">Balance Qty</th>
                                                <th class="hidden-phone">Cut Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!--/table-responsive-->
                            </div>
                            </div>
                        </div>
                    </div><!--/form-group-->

                    <div class="row">
                        <div class="form-group">
                            <div class="porlets-content">
                            <div class="col-lg-3">
                            <button type="submit" id="save_btn" class="btn btn-primary">Save</button>
                            <button type="reset" id="reset_btn" class="btn btn-danger">Reset</button>
                        </div>
                        </div>
                        </div>
                    </div>

                </form>
            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('select').select2();

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