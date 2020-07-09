<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Viyellatex</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon" />
</head>
<body class="light_theme  fixed_header left_nav_fixed" style="background-color: #fff3b5; background-size: 1400px 820px;
    background-repeat: no-repeat;">
<div class="wrapper">
  <!--\\\\\\\ wrapper Start \\\\\\-->
  
  
  
  
  
  <div class="login_page">
  <div class="login_content">

  <div class="panel-heading">
  	  <span style="font-size: 18px; color:#690;">Product Tracking System</span>
  </div>	
  
  
  
  <div style="padding-top:10px">
      <h6 style="color:red">
          <?php
          $exc = $this->session->userdata('exception');
          if (isset($exc)) {
              echo $exc;
              $this->session->unset_userdata('exception');
          }
          ?>
      </h6>

      <h6 style="color:green">
          <?php
          $msg = $this->session->userdata('message');
          if (isset($msg)) {
              echo $msg;
              $this->session->unset_userdata('message');
          }
          ?>
      </h6>
  </div>

 <form role="form" class="form-horizontal"action="<?php echo base_url(); ?>welcome/login/" method="post">
      <div class="form-group">
        
        <div class="col-sm-10">
            <input type="text" autofocus="autofocus" placeholder="User Name" id="inputEmail3" name="username" class="form-control">
        </div>
      </div>
      <div class="form-group">
        
        <div class="col-sm-10">
            <input type="password" placeholder="Password" id="inputPassword3" name="password" class="form-control">
        </div>
      </div>
      <div class="form-group">
        <div class=" col-sm-10">
          <div class="checkbox checkbox_margin">
            
             <button class="btn btn-default pull-right" type="submit">Sign in</button>
              
          </div>
        </div>
      </div>
      <span style="font-size:10px;">Copyright © 2018 EcoFab Ltd All rights reserved.</span>
      
    </form>
 </div>
</div>
</div>
</div>


<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.0.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common-script.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.min.js"></script>

<script type="text/javascript">


</script>
</body>
</html>
