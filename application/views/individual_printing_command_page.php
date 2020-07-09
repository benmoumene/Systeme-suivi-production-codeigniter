<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Generate Care Label</h1>
          <h2 class="">Generate Care Label...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Generate Care Label</li>
          </ol>
        </div>
      </div>
      <div class="container clear_both padding_fix">
        <!--\\\\\\\ container  start \\\\\\-->
        <div class="row">
        <div class="col-md-12">
          <div class="block-web">
              <div class="porlets-content">
                      <div class="row">
                          <div class="form-group">
                              <div class="porlets-content">
                                  <div class="col-md-3 col-sm-3">
                                      <label class="form-control"><b>SAP No.:</b> <?php echo $sap_no;?></label>
                                  </div>
                                  <div class="col-md-3 col-sm-3">
                                      <label class="form-control"><b>PO No.:</b> <?php echo $po_no;?></label>
                                  </div>
                                  <div class="col-md-3 col-sm-3">
                                      <label class="form-control"><b>Item:</b> <?php echo $item_no;?></label>
                                  </div>
                                  <div class="col-md-3 col-sm-3">
                                      <label class="form-control"><b>Quality:</b> <?php echo $quality;?></label>
                                  </div>
                                  <div class="col-md-3 col-sm-3">
                                      <label class="form-control"><b>Style:</b> <?php echo $style_name;?></label>
                                  </div>
                                  <div class="col-md-3 col-sm-3">
                                      <label class="form-control"><b>Color:</b> <?php echo $color;?></label>
                                  </div>
                                  <div class="col-md-3 col-sm-3">
                                      <label class="form-control"><b>Brand:</b> <?php echo $brand;?></label>
                                  </div>
                                  <div class="col-md-3 col-sm-3">
                                      <label class="form-control"><b>Cut Tracking No:</b> <?php echo $cut_tracking_no;?></label>
                                  </div>
                              </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="form-group">
                              <div class="porlets-content">
                                  <div class="col-md-3 col-sm-3">
                                      <a target="_blank" href="<?php echo base_url();?>access/generate_care_label/<?php echo $cut_tracking_no;?>" id="save_btn" class="btn btn-primary">Generate Care Label</a>
                                  </div>
                                  <div class="col-md-3 col-sm-3">
                                      <a target="_blank" href="<?php echo base_url();?>barcode/tests/print_bundle_tags.php?cut_tracking_no=<?php echo $cut_tracking_no;?>" id="save_btn" class="btn btn-success">Print Bundle Tags</a>
                                  </div>
                              </div>
                          </div>
                      </div>

              </div>
           </div><!--/porlets-content-->  
          </div><!--/block-web--> 
        </div><!--/col-md-12-->
      </div>