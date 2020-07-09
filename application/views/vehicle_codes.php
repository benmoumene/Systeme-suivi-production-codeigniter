<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Vehicle Codes</h1>
          <h2 class="">Vehicle Codes...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Vehicle Codes</li>
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
              <h3 class="content-header">Vehicle Codes</h3>         
            </div>
              <a target="_blank" class="btn btn-success" href="<?php echo base_url();?>access/new_card">+ New Card</a><br />
            
       <div class="porlets-content">
         <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="sample_3">
                  <thead>
                    <tr>
                      <th class="hidden-phone">SL No.</th>
                      <th class="hidden-phone">Company Name</th>
                      <th class="hidden-phone">User ID</th>
                      <th class="hidden-phone">Card No.</th>
                      <th class="hidden-phone">Type</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 
                      $sl = 1;
                      
                      foreach ($v_codes as $v) { ?>
                        <tr>
                            <td><?php echo $sl; $sl++;?></td>
                            <td><?php echo $v['company_name'];?></td>
                            <td><?php echo $v['user_id'];?></td>
                            <td><?php echo $v['card_no'];?></td>
                            <td><?php echo $v['vehicle_type'];?></td>
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