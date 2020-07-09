<div class="pull-left breadcrumb_admin clear_both" xmlns="http://www.w3.org/1999/html">
    <div class="pull-left page_title theme_color">
        <h1>Manual Closing</h1>
        <h2 class="">Manual Closing...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Manual Closing</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="block-web">
            <div class="header">
                <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a><a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                <h3 class="content-header">Manual Closing</h3>
            </div>


            <br class="porlets-content">
<!--                <form action="--><?php //echo base_url();?><!--access/search_cutting_result" method="post">-->



                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select required type="text" class="form-control select" id="so_no" name="so_no" onchange="getWashGmt();">
                                        <option value="">Select SO No...</option>
                                        <?php foreach ($sap_no as $v){ ?>
                                            <option value="<?php echo $v['so_no'];?>"><?php echo $v['so_no'];?></option>
                                        <?php } ?>
                                    </select>
                                    <span style="font-size: 11px;">* SO No.</span>
                                </div>
                            </div>



                                <div class="form-group">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" name="destination_id" id="destination_id">

                                                <option value="">Select Warehouse Type</option>

                                                <option value="carton">Carton</option>
                                                <option value="1">Warehouse Buyer</option>
                                                <option value="2">Warehouse Factory</option>
                                                <option value="3">Warehouse Trash</option>
                                                <option value="4">Warehouse Production Sample</option>
                                                <option value="5">Other</option>
                                                <option value="6">Lost</option>
                                                <option value="7">Size Set</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select required class="form-control" id="is_wash_garments" name="is_wash_garments"">
                                            <option value="">Is wash garments?</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="ex_fac_date" name="ex_fac_date" />
                                            <span>Ex-Factory Date (YYYY-mm-dd)</span>
                                        </div>
                                    </div>
                                </div>



<!--                            <div class="col-md-3">-->
<!--                                <div class="form-group">-->
<!--                                    <select required class="form-control" id="purchase_no" name="purchase_no" onchange="getPurchaseNo();">-->
<!--                                        <option value="">Select Purchase Order No...</option>-->
<!--                                    </select>-->
<!--                                    <span style="font-size: 11px;">* Purchase Order No.</span>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="col-md-2">-->
<!--                                <div class="form-group">-->
<!--                                    <select required class="form-control" id="item_no" name="item_no" onchange="getItemNo();">-->
<!--                                        <option value="">Select Item No...</option>-->
<!--                                    </select>-->
<!--                                    <span style="font-size: 11px;">* Item No.</span>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="col-md-2">-->
<!--                                <div class="form-group">-->
<!--                                    <select class="form-control" name="quality" id="quality" onchange="getQualityNo();">-->
<!--                                        <option>Select Quality...</option>-->
<!--                                    </select>-->
<!--                                    <span style="font-size: 11px;">* Select Quality</span>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="col-md-2">-->
<!--                                <div class="form-group">-->
<!--                                    <select class="form-control" name="color" id="color" onchange="getWashGmt1()" >-->
<!--                                        <option>Select Colour...</option>-->
<!--                                    </select>-->
<!--                                    <span style="font-size: 11px;">* Select Colour</span>-->
<!--                                </div>-->
<!--                            </div>-->

                            <!--                            </div>-->
                        </div>
                    </div><!--/form-group-->


                <div class="row">
                    <div class="form-group">
                        <div class="porlets-content">
                            <div class="col-lg-3">
                                <button type="submit" id="save_btn" class="btn btn-success"onclick="getManualItem()">Search</button>
                            </div>
                        </div>
                    </div>



                </div>
            </br>
            </br>


<!--            <div class="row">-->
<!--                <div class="form-group">-->
<!--                    <div class="col-md-3">-->
<!--                        <div class="form-group">-->
<!--                            <select class="form-control" name="destination_id" id="destination_id">-->
<!---->
<!--                                <option value="">Select Warehouse Type</option>-->
<!---->
<!--                                <option value="carton">Carton</option>-->
<!--                                <option value="1">Warehouse Buyer</option>-->
<!--                                <option value="2">Warehouse Factory</option>-->
<!--                                <option value="3">Warehouse Trash</option>-->
<!--                                <option value="4">Warehouse Production Sample</option>-->
<!--                                <option value="5">Other</option>-->
<!--                                <option value="6">Lost</option>-->
<!---->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-md-3">-->
<!--                        <div class="form-group">-->
<!--                            <select required class="form-control" id="is_wash_garments" name="is_wash_garments"">-->
<!--                            <option value="">Is wash garments?</option>-->
<!--                            <option value="1">Yes</option>-->
<!--                            <option value="0">No</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-md-3">-->
<!--                        <div class="form-group">-->
<!--                            <input type="text" class="form-control" id="ex_fac_date" name="ex_fac_date" />-->
<!--                            <span>Ex-Factory Date (YYYY-mm-dd)</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->


            <div class="row">
                <div class="form-group">
                    <div class="porlets-content">
                        <div class="col-lg-4">
                            <button type="submit" id="save_btn" class="btn btn-primary"onclick="transfer_all_final()">Submit</button>
<!--                            <button type="submit" id="save_btn" class="btn btn-primary"onclick="transfer_all()">Submit</button>-->
                        </div>
                    </div>
                </div>
            </div>


                    <div class="row">
                        <div class="form-group">
                            <!--                            <div class="col-md-12">-->



                            <!--                            <div class="col-md-1">-->
                            <!--                                <div class="form-group">-->
                            <!--                                    <input type="text" placeholder="Color" class="form-control" name="color" id="color" required readonly />-->
                            <!--                                    <span style="font-size: 11px;">* Color.</span>-->
                            <!--                                </div>-->
                            <!--                            </div>-->




                            <!--                            </div>-->
                        </div>
                    </div><!--/form-group-->

                    <!--/form-group-->
                <div class="porlets-content">

                    <div class="table-responsive">
                        <table class="display table table-bordered table-striped" id="table_data">
                            <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll"/>ID</th>
                                <th class="hidden-phone">Care Label No.</th>
                                <th class="hidden-phone">SO No.</th>
                                <th class="hidden-phone">Brand</th>
                                <th class="hidden-phone">PO-Item</th>
                                <th class="hidden-phone">Quality-Color</th>
                                <th class="hidden-phone">Style No.</th>
                                <th class="hidden-phone">Style Name</th>
                                <th class="hidden-phone">Size</th>
                                <th class="hidden-phone">PO Type</th>
                                <th class="hidden-phone">Lost Point</th>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                    </div><!--/table-responsive-->
                </div>


<!--                </form>-->
            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div><!--/row-->

<script type="text/javascript">
    $('.select').select2();

    $(document).on('click','#checkAll',function () {
        $('.checkItem').not(this).prop('checked', this.checked);
    });


    function transfer_all_final()
    {
        var destination_id=$("#destination_id").val();
        var is_wash_garments=$("#is_wash_garments").val();
        var ex_fac_date=$("#ex_fac_date").val();


        var po_ids = [];
        var lost_points = [];
        var line_ids = [];

        $('input.checkItem:checkbox:checked').each(function () {
            var sThisVal = $(this).val();

            po_ids.push(sThisVal);

        });

        $('input.lost_point').each(function () {
            var sThisVal = $(this).val();

            lost_points.push(sThisVal);

        });

        $('input.line_id').each(function () {
            var sThisVal = $(this).val();

            line_ids.push(sThisVal);

        });

        if(destination_id=='carton' && is_wash_garments==1)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_carton_and_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,ex_fac_date:ex_fac_date,is_wash_garments:is_wash_garments, lost_points: lost_points },
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }
            });
        }

        if(destination_id =='carton' && is_wash_garments==0)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_carton_and_non_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }
            });

        }

        if(destination_id ==1 && is_wash_garments==1)
    {
        $.ajax({
            url:"<?php echo base_url('access/po_in_warehouse_buyer_and_wash_gmt')?>",
            type:"post",
            dataType:"html",
            data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
            success:function (data) {
                if(data='done'){
                    alert('Po Closed Success!!');
                    $("#table_data tbody").empty();
                    $("#checkAll").attr("checked", false);
                }
            }

            });

    }
        if(destination_id ==1 && is_wash_garments==0)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_warehouse_buyer_and_non_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }

            });

        }

        if(destination_id ==2 && is_wash_garments==0)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_warehouse_factory_and_non_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }

            });

        }

        if(destination_id ==3 && is_wash_garments==0)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_warehouse_trash_and_non_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }

            });

        }

        if(destination_id ==4 && is_wash_garments==0)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_warehouse_production_and_non_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }

            });

        }
        if(destination_id ==5 && is_wash_garments==0)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_warehouse_other_and_non_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }

            });

        }



        if(destination_id ==6 && is_wash_garments==0)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_lost_and_non_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }
                });

        }


        if(destination_id ==7 && is_wash_garments==0)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_size_set_and_non_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }
            });

        }

        if(destination_id ==2 && is_wash_garments==1)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_warehouse_factory_and_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }
            });

        }

        if(destination_id ==3 && is_wash_garments==1)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_warehouse_trash_and_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }
            });

        }
        if(destination_id ==4 && is_wash_garments==1)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_warehouse_production_and_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }
            });

        }

        if(destination_id ==5 && is_wash_garments==1)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_warehouse_other_and_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }
            });

        }

        if(destination_id ==6 && is_wash_garments==1)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_lost_and_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }
            });

        }

        if(destination_id ==7 && is_wash_garments==1)
        {
            $.ajax({
                url:"<?php echo base_url('access/po_in_size_set_and_wash_gmt')?>",
                type:"post",
                dataType:"html",
                data:{destination_id:destination_id,po_ids:po_ids,line_ids:line_ids,lost_points: lost_points,is_wash_garments:is_wash_garments,ex_fac_date:ex_fac_date},
                success:function (data) {
                    if(data='done'){
                        alert('Po Closed Success!!');
                        $("#table_data tbody").empty();
                        $("#checkAll").attr("checked", false);
                    }
                }
            });

        }

         }


    function transfer_all() {
//        alert("success");
        var destination_id=$("#destination_id").val();
        var message=$("#message").val();
        var po_ids = [];
        $('input.checkItem:checkbox:checked').each(function () {
            var sThisVal = $(this).val();

            po_ids.push(sThisVal);
            console.log(po_ids);
            console.log(destination_id);
        });

        $.ajax({
            url:"<?php echo base_url('access/manual_closed')?>",
            type:"post",
            dataType:"html",
            data:{destination_id:destination_id,po_ids:po_ids},
            success:function (data) {
                console.log(data);
                alert('Po Closed Success!!');
                location.reload(true);
            }



        });

    }

    function getPONo() {

        var so_no=$("#so_no").val();
        if(so_no != '')
        {
            console.log(so_no);

            $.ajax({
                url:"<?php echo base_url('access/chk_purchase_order')?>",
                type:"post",
                dataType:'html',
                data:{so_no:so_no},
                success:function (data) {
//                        console.log(data);
                    $('select[name="purchase_no"]').empty();
                    $('#purchase_no').html(data);

                }
            });
        }


    }



    function getPurchaseNo() {
        var so_no=$("#so_no").val();
        var purchase_no=$("#purchase_no").val();
        if(purchase_no != '' && so_no != '')
        {
            $.ajax({
                url:"<?php echo base_url('access/chk_item_no')?>",
                type:"post",
                dataType:'html',
                data:{purchase_no:purchase_no,so_no:so_no},
                success:function (data) {
//                        console.log(data);
                    $('select[name="item_no"]').empty();
                    $('#item_no').html(data);

                }
            });
        }

    }


    function getItemNo() {


        var so_no=$("#so_no").val();
        var purchase_no=$("#purchase_no").val();
        var item_no=$("#item_no").val();
        if(so_no != '' && purchase_no != '' && item_no != '')
        {
            $.ajax({
                url:"<?php echo base_url('access/chk_quality')?>",
                type:"post",
                dataType:'html',
                data:{so_no:so_no,purchase_no:purchase_no,item_no:item_no},
                success:function (data) {
//                        console.log(data);
                    $('select[name="quality"]').empty();
                    $('#quality').html(data);

                }
            });
        }

    }
    function getQualityNo() {

        var so_no=$("#so_no").val();
        var purchase_no=$("#purchase_no").val();
        var item_no=$("#item_no").val();
        var quality=$("#quality").val();
        if(so_no != '' && purchase_no !='' && item_no != '' && quality != '' )
        {
            $.ajax({
                url:"<?php echo base_url('access/chk_color')?>",
                type:"post",
                dataType:'html',
                data:{so_no:so_no,purchase_no:purchase_no,item_no:item_no,quality:quality},
                success:function (data) {
//                        console.log(data);
                    $('select[name="color"]').empty();
                    $('#color').html(data);

                }
            });
        }

    }

    function getWashGmt() {
        var so_no=$("#so_no").val();
        if(so_no != '')
        {

            $("#ex_fac_date").val('');

            $.ajax({
                url:"<?php echo base_url('access/chk_wsh_gmt')?>",
                type:"post",
                dataType:'html',
                data:{so_no:so_no},
                success:function (data) {
//                        console.log(data);
//                    $('select[name="wsh_gmt"]').empty();
                    $('#is_wash_garments').empty();
                    $('#is_wash_garments').html(data);

                }
            });

            $.ajax({
                url:"<?php echo base_url('access/getWashAndShipDate')?>",
                type:"post",
                dataType:'json',
                data:{so_no:so_no},
                success:function (data) {
//                        console.log(data[0].ex_factory_date);

                    $("#ex_fac_date").val(data[0].ex_factory_date);
                }
            });
        }
    }

    function getManualItem() {
//        alert('success');
        var so_no=$("#so_no").val();
//        var purchase_no=$("#purchase_no").val();
//        var item_no=$("#item_no").val();
//        var quality=$("#quality").val();
//        var color=$("#color").val();

        if(so_no != '')
        {

            $("#table_data tbody tr").remove();
            $.ajax({
                url:"<?php echo base_url('access/search_manual_closing_report')?>",
                type:"post",
                dataType:'html',
                data:{so_no:so_no},
                success:function (data)
                {

                    $("#table_data tbody").append(data);
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


</script>