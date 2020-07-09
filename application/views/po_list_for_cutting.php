<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>PO List For Cutting</h1>
          <h2 class="">PO List For Cutting...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">PO List For Cutting</li>
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
<!--              <div class="col-md-3">-->
<!--                  <select class="form-control" required id="po_no">-->
<!--                      <option value="">Search PO...</option>-->
<!--                      <option value="1">200075783</option>-->
<!--                      <option value="2">200075784</option>-->
<!--                  </select>-->
<!--              </div>-->
<!--              <br />-->
<!--              <br />-->
<!--              <br />-->
       <div class="porlets-content">

         <div class="table-responsive">
                <table class="display table table-bordered table-striped" id="dynamic-table">
                  <thead>
                    <tr>
                      <th class="hidden-phone">SL</th>
                      <th class="hidden-phone">Production Order</th>
                      <th class="hidden-phone">Purchase Order</th>
                      <th class="hidden-phone">Brand</th>
                      <th class="hidden-phone">Item</th>
                      <th class="hidden-phone">Style No.</th>
                      <th class="hidden-phone">Style Name</th>
                      <th class="hidden-phone">Color</th>
                      <th class="hidden-phone">Quality</th>
                      <th class="hidden-phone">Quantity</th>
                      <th class="hidden-phone">ExFactory_dt</th>
                      <th class="hidden-phone">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                      $sl = 1;

                      foreach ($po_list as $v) { ?>
                        <tr>
                            <td><?php echo $sl; $sl++;?></td>
                            <td><?php echo $v['po_no'];?></td>
                            <td><?php echo $v['purchase_order'];?></td>
                            <td><?php echo $v['brand'];?></td>
                            <td><?php echo $v['item'];?></td>
                            <td><?php echo $v['style_no'];?></td>
                            <td><?php echo $v['style_name'];?></td>
                            <td><?php echo $v['color'];?></td>
                            <td><?php echo $v['quality'];?></td>
                            <td><?php echo $v['total_qty'];?></td>
                            <td><?php echo $v['ex_factory_date'];?></td>
                            <td>
                                <a target="_blank" class="btn btn-primary" href="<?php echo base_url();?>bcps/cutting_input.php?po_no=<?php echo $v['po_no'];?>&brand=<?php echo $v['brand'];?>&purchase_no=<?php echo $v['purchase_order'];?>&style_no=<?php echo $v['style_no'];?>&style_name=<?php echo $v['style_name'];?>&quality=<?php echo $v['quality'];?>&item=<?php echo $v['item'];?>&color=<?php echo $v['color'];?>&qty=<?php echo $v['total_qty'];?>">Create Bundle</a>
                            </td>
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
</script>