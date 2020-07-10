<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>PO Size Update</h1>
        <h2 class="">PO Size Update...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">PO Size Update</li>
        </ol>
    </div>
</div>

<div class="row" >
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">PO Size Update</h3>
            </div>
        </div>

        <div class="porlets-content">
            <form action="<?php echo base_url();?>access/updatingPoSizeQty" method="post">
                <div id="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
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
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <table class="display table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <td class="center">Size</td>
                                        <td class="center">
                                            Quantity
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

        $("#size_qty").empty();

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



    }

</script>