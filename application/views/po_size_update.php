<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>PO Update</h1>
        <h2 class="">PO Update...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">PO Update</li>
        </ol>
    </div>
</div>

<div class="row" >
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">PO Update</h3>
            </div>
        </div>

        <div class="porlets-content">
            <form action="<?php echo base_url();?>access/updatingPoSizeQty" method="post">
                <div id="row">
                    <div class="col-md-12">
                        <div class="col-md-8">
                            <div class="form-group">

                                <div style="padding-top:10px">
                                    <h4 style="color:red">
                                        <?php
                                        $exc = $this->session->userdata('exception');
                                        if (isset($exc)) {
                                            echo $exc;
                                            $this->session->unset_userdata('exception');
                                        } ?>
                                    </h4>

                                    <h4 style="color:green">
                                        <?php
                                        $msg = $this->session->userdata('message');
                                        if (isset($msg)) {
                                            echo $msg;
                                            $this->session->unset_userdata('message');
                                        }
                                        ?>
                                    </h4>
                                </div>

                                <table class="display table table-bordered table-striped" id="sample_2">
                                    <tbody>
                                    <tr>
                                        <td class="center">
                                            <select required id="so_no" class="form-control" name="so_no" onchange="getPoSizeQty();">
                                                <option value="">Select SO No</option>
                                                <?php
                                                $po_type = '';
                                                foreach ($so_nos as $v_s){
                                                    if($v_s['po_type'] == 0){
                                                        $po_type='BULK';
                                                    }
                                                    if($v_s['po_type'] == 1){
                                                        $po_type='SIZE SET';
                                                    }
                                                    if($v_s['po_type'] == 2){
                                                        $po_type='SAMPLE';
                                                    }
                                                    ?>
                                                    <option value="<?php echo $v_s['so_no'];?>"><?php echo $v_s['so_no'].'~'.$v_s['purchase_order'].'~'.$v_s['item'].'~'.$v_s['quality'].'~'.$v_s['color'].'~'.$v_s['style_no'].'~'.$v_s['style_name'].'~'.$v_s['ex_factory_date'].'~'.$po_type;?></option>
                                                <?php } ?>
                                            </select>
                                            <span id="" style="color: red;">SO~PO~ITEM~QUALITY~COLOR~StyleNo~StyleName~ExFacDate~TYPE</span>
                                        </td>
                                        <td class="center">
                                            <button class="btn btn-success">UPDATE</button>
                                        </td>
                                        <td class="center">
                                            <span class="btn btn-danger" onclick="deletePO()">DELETE</span>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="row">
                    <div class="col-md-12">
                        <div class="col-md-8">
                            <div class="form-group">
                                <table class="display table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <td class="center">PO</td>
                                            <td class="center">
                                                <input type="text" name="purchase_order" id="purchase_order">
                                            </td>
                                            <td class="center">Item</td>
                                            <td class="center">
                                                <input type="text" name="item" id="item">
                                            </td>
                                            <td class="center">Quality</td>
                                            <td class="center">
                                                <input type="text" name="quality" id="quality">
                                            </td>
                                            <td class="center">Color</td>
                                            <td class="center">
                                                <input type="text" name="color" id="color">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="center">Style No</td>
                                            <td class="center">
                                                <input type="text" name="style_no" id="style_no">
                                            </td>
                                            <td class="center">Style Name</td>
                                            <td class="center">
                                                <input type="text" name="style_name" id="style_name">
                                            </td>
                                            <td class="center">Ex-Fac Date</td>
                                            <td class="center">
                                                <input type="text" class="form-control-inline input-small default-date-picker" id="ex_fac_date" name="ex_fac_date" required autocomplete="off" />
                                            </td>
                                            <td class="center">CRD Date</td>
                                            <td class="center">
                                                <input type="text" class="form-control-inline input-small default-date-picker" id="crd_date" name="crd_date" required autocomplete="off" />
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="row">
                    <div class="col-md-12">
                        <div class="col-md-8">
                            <div class="form-group">
                                <table class="display table table-bordered table-striped">
                                    <thead>
                                        <tr style="font-size: 16px; font-weight: 700;">
                                            <td class="center">Size</td>
                                            <td class="center">
                                                Total Quantity=<span id="total_qty">0</span>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody id="size_qty">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div><!--/porlets-content-->

    </div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('#so_no').select2();


    function getPoSizeQty() {
        $("#purchase_order").val('');
        $("#item").val('');
        $("#quality").val('');
        $("#color").val('');
        $("#style_no").val('');
        $("#style_name").val('');
        $("#ex_fac_date").val('');
        $("#crd_date").val('');

        $("#size_qty").empty();
        $("#total_qty").empty();

        var so_no = $("#so_no").val();

        $.ajax({
            url: "<?php echo base_url();?>access/getPoSizeQty/",
            type: "POST",
            data: {so_no: so_no},
            dataType: "html",
            success: function (data) {
                $("#size_qty").append(data);
            }
        });

        $.ajax({
            url: "<?php echo base_url();?>access/getPoItemDetail/",
            type: "POST",
            data: {so_no: so_no},
            dataType: "json",
            success: function (data) {
                var purchase_order = data[0].purchase_order;
                var item = data[0].item;
                var quality = data[0].quality;
                var color = data[0].color;
                var style_no = data[0].style_no;
                var style_name = data[0].style_name;

                var ex_factory_dt = data[0].ex_factory_date;
                var ex_factory_dt_split = ex_factory_dt.split("-");
                var ex_year = ex_factory_dt_split[0];
                var ex_month = ex_factory_dt_split[1];
                var ex_date = ex_factory_dt_split[2];
                var ex_factory_date = ex_month+"-"+ex_date+"-"+ex_year;

                var crd_dt = data[0].crd_date;
                var crd_dt_split = crd_dt.split("-");
                var crd_year = crd_dt_split[0];
                var crd_month = crd_dt_split[1];
                var crd_date = crd_dt_split[2];
                var crd_date = crd_month+"-"+crd_date+"-"+crd_year;
                var total_order_qty = data[0].order_qty;

                $("#purchase_order").val(purchase_order);
                $("#item").val(item);
                $("#quality").val(quality);
                $("#color").val(color);
                $("#style_no").val(style_no);
                $("#style_name").val(style_name);
                $("#ex_fac_date").val(ex_factory_date);
                $("#crd_date").val(crd_date);

                $("#total_qty").append(total_order_qty);
            }
        });

    }

    function deletePO() {
        var so_no = $("#so_no").val();

        if(so_no != ''){
            var result = confirm("Are you sure to delete?");

            if (result) {
                $.ajax({
                    url: "<?php echo base_url();?>access/deletePO/",
                    type: "POST",
                    data: {so_no: so_no},
                    dataType: "html",
                    success: function (data) {

                        if(data == 'done'){
                            location.reload();
                        }

                    }
                });
            }

        }else{
            alert("Please Select SO !");
        }

    }

</script>