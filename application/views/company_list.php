<div class="pull-left breadcrumb_admin clear_both">
        <div class="pull-left page_title theme_color">
          <h1>Company List</h1>
          <h2 class="">Company List...</h2>
        </div>
        <div class="pull-right">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Home</a></li>
              <li class="active">Company List</li>
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
              <h3 class="content-header">Company List</h3>
            </div>
         <a target="_blank" class="btn btn-success" href="<?php echo base_url();?>access/add_new_company">+ Add Company</a><br />
       <div class="porlets-content">
         <div class="table-responsive">
                <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="sample_3">
                  <thead>
                    <tr>
                      <th class="hidden-phone">SL No.</th>
                      <th class="hidden-phone">Company Name</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php 
                      $sl = 1;
                      
                      foreach ($companies as $v) { ?>
                        <tr>
                            <td><?php echo $sl; $sl++;?></td>
                            <td><?php echo $v['company_name'];?></td>
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