<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>PO File Upload</h1>
        <h2 class="">PO File Upload...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">PO File Upload</li>
        </ol>
    </div>
</div>

<form action="<?php echo base_url();?>access/smsFileUploadTest" method="post" enctype="multipart/form-data">
    <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->

        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <h4 style="color:red">
                        <?php
                        $exc = $this->session->userdata('exception');
                        if (isset($exc)) {
                            echo $exc;
                            $this->session->unset_userdata('exception');
                        }
                        ?>
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <h4 align="right">Select File:</h4>
                        </div>
                    </div>




                    <div class="col-md-3">
                        <div class="form-group">
                            <input class="form-control" type="file" name="file" id="file" />
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            <select required type="text" class="form-control" id="po_type" name="po_type">
                                <option value="">Select PO Type...</option>

                                <option value="0">Bulk</option>
                                <option value="1">Size Set</option>
                                <option value="2">Sample</option>


                            </select>
                            <span style="font-size: 11px;">* PO Type.</span>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Upload</button>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class="form-group">
                            <a href="<?php echo base_url();?>uploads/manual_upload/file_format_pts.csv" class="btn btn-warning">File Format</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary" style="color: #FFF;" id="btnExport"><b>Export Excel</b></button>
        <span class="btn btn-info"><b>Last SO: <?php echo $last_so_no;?></b></span>
        <span class="btn btn-default"><b>Last Upload Date: <?php echo $upload_date;?></b></span>

        <div class="row">
            <div class="col-md-12" id="tableWrap">
                <section class="panel default blue_title h2">

                    <div class="panel-body">

                        <table class="table" border="1">
                            <thead>
                            <tr>
                                <th class="center">SO</th>
                                <th class="center">PO</th>
                                <th class="center">Brand</th>
                                <th class="center">Purchase Order</th>
                                <th class="center">Item</th>
                                <th class="center">Quality</th>
                                <th class="center">Color</th>
                                <th class="center">Style</th>
                                <th class="center">Style Name</th>
                                <th class="center">Ex-Fac-Date</th>
                                <th class="center">Order Qty</th>
                                <th class="center">Po Type</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($today_upload AS $v){ ?>
                            <tr>
                                <td class="center"><?php echo $v['so_no'];?></td>
                                <td class="center"><?php echo $v['po_no'];?></td>
                                <td class="center"><?php echo $v['brand'];?></td>
                                <td class="center"><?php echo $v['purchase_order'];?></td>
                                <td class="center"><?php echo $v['item'];?></td>
                                <td class="center"><?php echo $v['quality'];?></td>
                                <td class="center"><?php echo $v['color'];?></td>
                                <td class="center"><?php echo $v['style_no'];?></td>
                                <td class="center"><?php echo $v['style_name'];?></td>
                                <td class="center"><?php echo $v['ex_factory_date'];?></td>
                                <td class="center"><?php echo $v['total_order_qty'];?></td>
                                <td class="center"><?php if($v['po_type'] ==0){echo 'BULK';}
                                             if($v['po_type'] ==1){echo 'Size Set';}
                                             if($v['po_type'] ==2){echo 'Sample';}
                                    ;?></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </section>
            </div>
        </div>

    </div>
</form>


<script type="text/javascript">
    $('select').select2();

    $(document).ready(function(){
        $("#message").empty();
    });

    $(function(){
        $('#btnExport').click(function(){
            var url='data:application/vnd.ms-excel,' + encodeURIComponent($('#tableWrap').html())
            location.href=url
            return false
        })
    })

    //    function getPoItemDetail() {
    //        $("#report_content").empty();
    //
    //        var po_no_all = $("#po_no").val();
    //
    //        var res = po_no_all.split("_");
    //
    //        var sap_po = res[0];
    //        var purchase_order = res[1];
    //        var item = res[2];
    //        var quality = res[3];
    //        var color = res[4];
    //
    //        $.ajax({
    //            url: "<?php //echo base_url();?>//access/getPoItemDetail/",
    //            type: "POST",
    //            data: {sap_no: sap_po, purchase_order: purchase_order, item: item, quality: quality, color: color},
    //            dataType: "html",
    //            success: function (data) {
    //                $("#report_content").append(data);
    //            }
    //        });
    //    }
</script>