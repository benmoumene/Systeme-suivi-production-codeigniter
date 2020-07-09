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
                    <input id="cl_no" onblur="chkReprintStatus1();">
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
                        <table class="display table table-bordered table-striped" id="dynamic-table">

                            <thead>
                            <tr>
                                <th class="hidden-phone">SL.</th>
                                <th class="hidden-phone">Care Label No.</th>
                                <th class="hidden-phone">Referenced By</th>
                                <th class="hidden-phone">PO-Item</th>
                                <th class="hidden-phone">Quality-Color</th>
                                <th class="hidden-phone">Style No-Name.</th>
                                <th class="hidden-phone">Brand</th>
                                <th class="hidden-phone">Size</th>
                                <th class="hidden-phone">Bundle No</th>


                                <th class="hidden-phone">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                                  <?php
                                                  $sl = 1;

                                                  foreach ($reprint_cl as $v) { ?>
                                                    <tr>
                                                        <td><?php echo $sl; $sl++;?></td>
                                                        <td><?php echo $v['pc_tracking_no'];?></td>
                                                        <td><?php echo $v['referenced_by'];?></td>
                                                        <td><?php echo $v['purchase_order'].'-'.$v['item'];?></td>
                                                        <td><?php echo $v['quality'].'-'.$v['color'];?></td>
                                                        <td><?php echo $v['style_no'].'-'.$v['style_name'];?></td>
                                                        <td><?php echo $v['brand'];?></td>
                                                        <td><?php echo $v['size'].'-'.$v['layer_group'];?></td>
                                                        <td><?php echo $v['bundle_tracking_no'];?></td>
                                                        <td><a target="_blank" class="btn btn-primary" href="<?php echo base_url()?>access/printSingleCareLabel/<?php echo $v['pc_tracking_no']?>">CL</a></td>



                                                    </tr>
                                                <?php } ?>
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



    function chkReprintStatus() {
        var cl_no = $("#cl_no").val();

        if(cl_no != ''){
            $("#dynamic-table tbody tr").remove();

            $.ajax({
                url: "<?php echo base_url();?>access/chkReprintStatus/",
                type: "POST",
                data: {cl_no: cl_no},
                dataType: "html",
                success: function (data) {
                    $("#dynamic-table tbody").append(data);
                }
            });
        }
    }


</script>