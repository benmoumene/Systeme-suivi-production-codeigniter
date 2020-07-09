<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Active Print Label</h1>
        <h2 class="">Active Print Label...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Active Print Label</li>
        </ol>
    </div>
</div>

<h3> <?php
    $message=$this->session->userdata('message');
    if($message){
        echo "<span style='color:green'>$message<span>";
        $this->session->unset_userdata('message');
    }
    ?>
</h3>


<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
<!--    <form action="--><?php //echo base_url();?><!--access/activeCareLabel" method="post" onsubmit="return confirm('Do you really want to Active?');">-->
        <div class="row">
            <div class="col-md-12">
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



                <!--              <div class="col-md-3">-->
                <!--                  <input type="text" class="form-control" name="carelabel_tracking_no" autofocus required id="carelabel_tracking_no" onkeyup="clickToSubmitBtn();" />-->
                <!---->
                <!--<!--                  <input type="text" class="form-control" name="cut_tracking_no_1" required id="cut_tracking_no_1" />-->
                <!--<!--                  <span id="er_msg" style="color: red;"></span>-->
                <!--<!--                  <span id="s_msg" style="color: green;"></span>-->
                <!--              </div>-->
                <!--              <div class="col-md-3">-->
                <!--                  <button style="display: none;" id="submit_btn" class="btn btn-success">Send</button>-->
                <!--              </div>-->

            </div><!--/block-web-->
        </div><!--/col-md-12-->
<!--        <div class="row">-->




            <div class="row">
                <div class="form-group">

                    <div class="col-md-3">
                        <div class="form-group">
                            <select required type="text" class="form-control" id="po_no" name="po_no" onchange="getPONo();">
                                <option value="">Select PO No...</option>
                                <?php foreach ($sap_no as $v){ ?>
                                    <option value="<?php echo $v['po_no'];?>"><?php echo $v['po_no'];?></option>
                                <?php } ?>
                            </select>
                            <span style="font-size: 11px;">* PO No.</span>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <select required type="text" class="form-control" id="so_no" name="so_no" onchange="getSONo();">
                                <option value="">Select SO No...</option>
<!--                                --><?php //foreach ($sap_no as $v){ ?>
<!--                                    <option value="--><?php //echo $v['so_no'];?><!--">--><?php //echo $v['so_no'];?><!--</option>-->
<!--                                --><?php //} ?>
                            </select>
                            <span style="font-size: 11px;">* SO No.</span>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <select required class="form-control" id="purchase_no" name="purchase_no" onchange="getPurchaseNo();">
                                <option value="">Select Purchase Order No...</option>
                            </select>
                            <span style="font-size: 11px;">* Purchase Order No.</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select required class="form-control" id="item_no" name="item_no" onchange="getItemNo();">
                                <option value="">Select Item No...</option>
                            </select>
                            <span style="font-size: 11px;">* Item No.</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="quality" id="quality" onchange="getQualityNo();">
                                <option>Select Quality...</option>
                            </select>
                            <span style="font-size: 11px;">* Select Quality</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-control" name="color" id="color" onchange="getCutNo()" >
                                <option>Select Colour...</option>
                            </select>
                            <span style="font-size: 11px;">* Select Colour</span>
                        </div>
                    </div>

                    <!--                            </div>-->

                    <div class="col-md-3">
                        <select required class="form-control" id="cut_no" name="cut_no">
                            <option value="">Select Cut No...</option>

                        </select>
                        <span style="font-size: 11px;">* Cut No.</span>
                    </div>


                </div>
            </div>



            <div class="col-md-3">
                <span class="btn btn-success" onclick="getCuttingSummary();">Check</span>
            </div>
<!--        </div>-->
        <br />
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="widgets_user">
                    <div class="system_body_title"> <i class="fa fa-user"></i> Cutting Summary</div>
                    <div class="system_bg">
                        <div class="centered-container">

                        </div>
                    </div>
                    <div class="widget-stats "> <span class="item-number active_widget" style="font-size: 30px;" id="cl_qty"></span> <span class="item-title active_widget" style="font-size: 18px;">Care Label Qty</span> </div>
                    <div class="widget-stats"> <span class="item-number active_orangewidget" style="font-size: 30px;" id="bundle_range"></span> <span class="item-title active_orangewidget" style="font-size: 18px;">Bundle Range</span> </div>
                </div>
            </div>
            <button id="submit_btn" class="btn btn-danger" style="display: none;" onclick="getActiveData()">Active</button>
        </div>
<!--    </form>-->

</div>

<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
        $("#message").empty();
    });

    function getCuttingSummary() {

        var po_no = $("#po_no").val();
        var cut_no = $("#cut_no").val();


        $("#cl_qty").empty();
        $("#bundle_range").empty();

        if(po_no != '' && cut_no != ''){

            $.ajax({
                url: "<?php echo base_url();?>access/getCuttingSummary/",
                type: "POST",
                data: {po_no: po_no, cut_no: cut_no},
                dataType: "json",
                success: function (data) {
                    var total_cut_qty = data[0].total_cut_qty;
                    var bundle_range = data[0].bundle_start +' - '+ data[0].bundle_end;

                    $("#cl_qty").append(total_cut_qty);
                    $("#bundle_range").append(bundle_range);
                    $("#submit_btn").css('display', 'block');

                }
            });

        }else{
            alert("Please Enter Required Fields!");
            $("#submit_btn").css('display', 'none');
        }

    }
    function getActiveData() {
//        alert('success');

        var po_no = $("#po_no").val();
        var cut_no = $("#cut_no").val();
        var purchase_no=$("#purchase_no").val();
        var item_no=$("#item_no").val();
        var quality=$("#quality").val();
        var color=$("#color").val();

        if (po_no != '' && cut_no != '' && purchase_no != '' && item_no != '' && quality != '' && color != '') {

            $.ajax({
                async: true,
                url: "<?php echo base_url();?>access/activeCareLabel/",
                type: "POST",
                data: {po_no: po_no, cut_no: cut_no, purchase_no:purchase_no, item_no:item_no, quality:quality, color:color},
                dataType: "html",
                success: function (data) {
                    if(data == 'done')
                    {
                        alert('cutting activated successfully');
                    }

                }
            });


        }
    }

    function getSONo() {

        var po_no=$("#po_no").val();
        var so_no=$("#so_no").val();
        if(po_no != '' && so_no != '')
        {
            $.ajax({
                url:"<?php echo base_url('access/chk_purchase_order')?>",
                type:"post",
                dataType:'html',
                data:{po_no:po_no, so_no:so_no},
                success:function (data) {
                        console.log(data);
                    $('select[name="purchase_no"]').empty();
                    $('#purchase_no').html(data);

                }
            });
        }


    }
    function getPONo() {

        var po_no=$("#po_no").val();
        if(po_no != '')
        {
            $.ajax({
                url:"<?php echo base_url('access/chk_so_no')?>",
                type:"post",
                dataType:'html',
                data:{po_no:po_no},
                success:function (data) {
                    $('select[name="so_no"]').empty();
                    $('#so_no').html(data);

                }
            });
        }

    }



    function getPurchaseNo() {
        var po_no=$("#po_no").val();
        var so_no=$("#so_no").val();
        var purchase_no=$("#purchase_no").val();
        if(purchase_no != '' && po_no != '')
        {
            $.ajax({
                url:"<?php echo base_url('access/chk_item_no')?>",
                type:"post",
                dataType:'html',
                data:{purchase_no:purchase_no, po_no:po_no, so_no:so_no},
                success:function (data) {
//                        console.log(data);
                    $('select[name="item_no"]').empty();
                    $('#item_no').html(data);

                }
            });
        }

    }


    function getItemNo() {

        var po_no=$("#po_no").val();
        var so_no=$("#so_no").val();
        var purchase_no=$("#purchase_no").val();
        var item_no=$("#item_no").val();
        if(po_no != '' && so_no != '' && purchase_no != '' && item_no != '')
        {
            $.ajax({
                url:"<?php echo base_url('access/chk_quality')?>",
                type:"post",
                dataType:'html',
                data:{po_no:po_no, so_no:so_no, purchase_no:purchase_no, item_no:item_no},
                success:function (data) {
                        console.log(data);
                    $('select[name="quality"]').empty();
                    $('#quality').html(data);

                }
            });
        }

    }
    function getQualityNo() {

        var po_no=$("#po_no").val();
        var so_no=$("#so_no").val();
        var purchase_no=$("#purchase_no").val();
        var item_no=$("#item_no").val();
        var quality=$("#quality").val();
        if(po_no != '' && so_no != '' && purchase_no !='' && item_no != '' && quality != '' )
        {
            $.ajax({
                url:"<?php echo base_url('access/chk_color')?>",
                type:"post",
                dataType:'html',
                data:{po_no:po_no, so_no:so_no, purchase_no:purchase_no,item_no:item_no,quality:quality},
                success:function (data) {
//                        console.log(data);
                    $('select[name="color"]').empty();
                    $('#color').html(data);

                }
            });
        }

    }
    function getCutNo() {

        var po_no=$("#po_no").val();
        var so_no=$("#so_no").val();
        var purchase_no=$("#purchase_no").val();
        var item_no=$("#item_no").val();
        var quality=$("#quality").val();
        var color=$("#color").val();

        if(po_no != '' && so_no != '' && purchase_no !='' && item_no != '' && quality != '' && color != '' )
        {
            $.ajax({
                url:"<?php echo base_url('access/chk_cut_no')?>",
                type:"post",
                dataType:'html',
                data:{po_no:po_no, so_no:so_no, purchase_no:purchase_no,item_no:item_no,quality:quality,color:color},
                success:function (data) {
//                        console.log(data);
                    $('select[name="cut_no"]').empty();
                    $('#cut_no').html(data);

                }
            });
        }

    }

</script>