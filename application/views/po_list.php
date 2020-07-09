<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>PO List</h1>
          <h2 class="">PO List...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">PO List</li>
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
              <h3 class="content-header">PO List    <a target="_blank" class="btn btn-primary" href="<?php echo base_url();?>access/excelUpload">Upload Excel - PO</a><br /></h3>
            </div>
              <div class="col-md-3">
                  <select class="form-control" required id="month">
                      <option>Search PO...</option>
                      <option value="1">200075783</option>
                      <option value="2">200075784</option>
                  </select>
              </div>
              <br />
              <br />
              <br />
       <div class="porlets-content">

         <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="sample_3">
                  <thead>
                    <tr>
                      <th class="hidden-phone">SL</th>
                      <th class="hidden-phone">Production Order</th>
                      <th class="hidden-phone">Purchase Order</th>
                      <th class="hidden-phone">Brand</th>
                      <th class="hidden-phone">Item</th>
                      <th class="hidden-phone">Style No.</th>
                      <th class="hidden-phone">Style Name</th>
                      <th class="hidden-phone">Quality</th>
                      <th class="hidden-phone">Color</th>
                      <th class="hidden-phone">Size</th>
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
                            <td><?php echo $v['quality'];?></td>
                            <td><?php echo $v['color'];?></td>
                            <td><?php echo $v['size'];?></td>
                            <td><?php echo $v['quantity'];?></td>
                            <td><?php echo $v['ex_factory_date'];?></td>
                            <td>
                                <a target="_blank" href="<?php echo base_url();?>access/printing_care_label/<?php echo $v['id'];?>/<?php echo $v['po_no'];?>/<?php echo $v['brand'];?>/<?php echo $v['style_no'];?>/<?php echo $v['color'];?>/<?php echo $v['size'];?>/<?php echo $v['quantity'];?>">Print Care Label</a>
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