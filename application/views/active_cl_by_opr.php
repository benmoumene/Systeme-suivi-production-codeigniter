<div class="pull-left breadcrumb_admin clear_both">
    <div class="pull-left page_title theme_color">
        <h1>Care Label List</h1>
        <h2 class="">Care Label List...</h2>
    </div>
    <div class="pull-right">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Home</a></li>
            <li class="active">Care Label List</li>
        </ol>
    </div>
</div>
<div class="container clear_both padding_fix">
    <!--\\\\\\\ container  start \\\\\\-->
    <div class="row">
        <div class="col-md-12">
            <div class="block-web">
                <div class="header">
                    <div class="actions"> <a class="minimize" href="#"><i class="fa fa-chevron-down"></i></a> <a class="refresh" href="#"><i class="fa fa-repeat"></i></a> <a class="close-down" href="#"><i class="fa fa-times"></i></a> </div>
                </div>
                <div class="col-md-3">
                    <input type="text" id="cl_no" onblur="getClDetailForActive();">
                </div>
                <!--              <div class="col-md-3">-->
                <!--                  <select class="form-control" required id="cut_no">-->
                <!--                      <option>Search Cut No...</option>-->
                <!--                      <option>1</option>-->
                <!--                      <option>2</option>-->
                <!--                  </select>-->
                <!--              </div>-->
                <br />
                <br />
                <br />
                <div class="porlets-content">

                    <div class="table-responsive">
                        <table class="display table table-bordered table-striped" id="dynamic-table1">
                            <thead>
                            <tr>
                                <th class="hidden-phone">Care Label No.</th>
                                <th class="hidden-phone">SO No.</th>
                                <th class="hidden-phone">Brand</th>
                                <th class="hidden-phone">PO</th>
                                <th class="hidden-phone">Item</th>
                                <th class="hidden-phone">Quality</th>
                                <th class="hidden-phone">Color</th>
                                <th class="hidden-phone">Style No.</th>
                                <th class="hidden-phone">Style Name</th>
                                <th class="hidden-phone">Size</th>
                                <th class="hidden-phone">Bundle No</th>
                                <th class="hidden-phone">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                                    <tr>
                                                        <td><input type="text" class="form-control" id="pc_tracking_no" name="pc_tracking_no" value="" autocomplete="off" readonly></td>
                                                        <td><input type="text" class="form-control" id="so_no" name="so_no" value="" autocomplete="off" readonly></td>
                                                        <td><input type="text" class="form-control" id="brand" name="brand" value="" autocomplete="off" readonly></td>
                                                        <td><input type="text" class="form-control" id="purchase_order" name="purchase_order" value="" autocomplete="off" readonly></td>
                                                        <td><input type="text" class="form-control" id="item" name="item" value="" autocomplete="off" readonly></td>
                                                        <td><input type="text" class="form-control" id="quality" name="quality" value="" autocomplete="off" readonly></td>
                                                        <td><input type="text" class="form-control" id="color" name="color" value="" autocomplete="off" readonly></td>
                                                        <td><input type="text" class="form-control" id="style_no" name="style_no" value="" autocomplete="off" readonly></td>
                                                        <td><input type="text" class="form-control" id="style_name" name="style_name" value="" autocomplete="off" readonly></td>
                                                        <td><input type="text" class="form-control" id="size" name="size" value="" autocomplete="off" readonly></td>
                                                        <td><input type="text" class="form-control" id="bundle_no" name="bundle_no" value="" autocomplete="off" readonly></td>
                                                        <td>
                                                            <a  class="btn btn-primary" onclick="activeCl();" >Active Care Label</a>
                                                        </td>
                                                    </tr>

                            </tbody>
                        </table>
                    </div><!--/table-responsive-->
                </div>

            </div><!--/porlets-content-->
        </div><!--/block-web-->
    </div><!--/col-md-12-->
</div>

<script type="text/javascript">
    $('select').select2();

    function getClDetailForActive() {
        var cl_no = $("#cl_no").val();

        if(cl_no != ''){
//            $("#dynamic-table tbody tr").remove();

            $.ajax({
                url: "<?php echo base_url();?>access/getClDetailForActive/",
                type: "POST",
                data: {cl_no: cl_no},
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    var pc_tracking_no = data[0].pc_tracking_no;
                    var so_no = data[0].so_no;
                    var brand = data[0].brand;
                    var purchase_order = data[0].purchase_order;
                    var item = data[0].item;
                    var quality = data[0].quality;
                    var color = data[0].color;
                    var style_no = data[0].style_no;
                    var style_name = data[0].style_name;
                    var size = data[0].size;
                    var bundle_no = data[0].bundle_no;

                    $("#pc_tracking_no").val(pc_tracking_no);
                    $("#so_no").val(so_no);
                    $("#brand").val(brand);
                    $("#purchase_order").val(purchase_order);
                    $("#item").val(item);
                    $("#quality").val(quality);
                    $("#color").val(color);
                    $("#style_no").val(style_no);
                    $("#style_name").val(style_name);
                    $("#size").val(size);
                    $("#bundle_no").val(bundle_no);

//                    $("#dynamic-table tbody").append(data);
                }
            });
        }
    }

    function activeCl() {
        var cl_no = $("#cl_no").val();
        if (cl_no != '') {
            $.ajax({
                url: "<?php echo base_url();?>access/activeCl/",
                type: "POST",
                data: {cl_no: cl_no},
                dataType: "html",
                success: function (data) {
                    if(data == 'success'){
                        alert("Care Label Activated Sucessfully");
                        location.reload(true);
                    }

                }
            });


        }
        else {
            alert("Pc No Can't Be Empty");
        }
    }
</script>