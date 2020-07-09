<!DOCTYPE html>
<html lang="en">
<head>
    <!--
        ===
        This comment should NOT be removed.

        Charisma v2.0.0

        Copyright 2012-2014 Muhammad Usman
        Licensed under the Apache License v2.0
        http://www.apache.org/licenses/LICENSE-2.0

        http://usman.it
        http://twitter.com/halalit_usman
        ===
        
         type="image/x-icon"
    -->
    <meta charset="utf-8">
    <title>BCPS</title>
    <link rel="shortcut icon" href="img/BCPS_title.gif" />
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BCPS, A Web application to generate tags of Cut Panel.">
    <meta name="author" content="Amena Khatun">

	<style type="text/css">
    table.bottomBorder { border-collapse:collapse; }
    table.bottomBorder td, table.bottomBorder th { border-bottom:1px dotted gray;padding:5px; border:1px dotted gray;
	/* text-align:center; */
    font-size:14px;
    font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
    }
    table.bottomBorder tr, table.bottomBorder tr { border:1px dotted gray;padding:5px; }
	
	
	/*table.bottomBorder2 { border-collapse:collapse; }
    table.bottomBorder2 td, table.bottomBorder2 th { border-bottom:1px dotted black;padding:5px;
    font-size:14px;
    font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
    }
    table.bottomBorder2 tr { border:1px dotted black;padding:5px; }*/
	
    </style> 
       

    <!-- The styles -->
    <!--<link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">-->
    
        <script src="img/CalendarControl1.js" type="text/javascript"></script>
    	<link href="img/CalendarControl.css" rel="stylesheet" type="text/css" />

    
    <!--<link id="bs-css" href="css/bootstrap-spacelab.min.css" rel="stylesheet">-->
    <link id="bs-css" href="css/bootstrap-slate.min.css" rel="stylesheet">
    

    <link href="css/charisma-app.css" rel="stylesheet">
    <!--<link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>-->
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>
    
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- jQuery -->
    
	<script src="bower_components/jquery/jquery.min.js"></script>
	<!--<script type="text/javascript" src="info/jquery.min.js"></script>-->
    
    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->

</head>

<body>
<?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>
    <!-- topbar starts -->
    
 <!-- <header id="mainHeader" class="clearfix">-->
      <div class="navbar navbar-fixed-top">
          <div class="navbar-inner">

    	 <!--<div class="navbar navbar-default" role="navigation">-->

              <div class="navbar-inner">
              
                  <button type="button" class="navbar-toggle pull-left animated flip">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  
                  <span style="margin-left:30px">
                  <img alt="BCPS Logo" src="img/BCPS_title.gif" width="30" height="*" />
                  <span style="color:#09F; font-weight:bold; font-size:22px; font-family:'Comic Sans MS', cursive">BCPS</span>
                  </span>
                  
                <img style="margin-left:15px" alt="BCPS Logo" src="img/BCPS_Transperant_Text.gif" height="50px" width="300px" />  
                
      
     <!-- <img alt="DMS Logo" src="img/logo20.png" class="hidden-xs"/>-->
      <!--<a class="navbar-brand" href="home.php"><span>BCPS</span></a>-->
      
                  <!-- user dropdown starts -->
                  <div class="btn-group pull-right">
                      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                          <i class="glyphicon glyphicon-user"></i><span class="hidden-sm hidden-xs"> User</span>
                          <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                          <li><a href="#">Profile</a></li>
                          <li class="divider"></li>
                          <?php  $msg ="<font color='green'><strong>Sucessfully Loged Out :-)</strong></font>"; ?>
                          <li><a href="index.php?msg=<?php echo $msg; ?>">Logout</a></li>
                          <!--<li><a href="index.php?msg='Sucessfully Loged Out :-)'">Logout</a></li>-->
                      </ul>
                  </div>
                  <!-- user dropdown ends -->
      
                  <!-- theme selector starts -->
                  <div class="btn-group pull-right theme-container animated tada">
                      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                          <i class="glyphicon glyphicon-tint"></i><span
                              class="hidden-sm hidden-xs"> Change Theme</span>
                          <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu" id="themes">
                          <li><a data-value="classic" href="#"><i class="whitespace"></i> Classic</a></li>
                          <li><a data-value="cerulean" href="#"><i class="whitespace"></i> Cerulean</a></li>
                          <li><a data-value="cyborg" href="#"><i class="whitespace"></i> Cyborg</a></li>
                          <li><a data-value="simplex" href="#"><i class="whitespace"></i> Simplex</a></li>
                          <li><a data-value="darkly" href="#"><i class="whitespace"></i> Darkly</a></li>
                          <li><a data-value="lumen" href="#"><i class="whitespace"></i> Lumen</a></li>
                          <li><a data-value="slate" href="#"><i class="whitespace"></i> Slate</a></li>
                          <li><a data-value="spacelab" href="#"><i class="whitespace"></i> Spacelab</a></li>
                          <li><a data-value="united" href="#"><i class="whitespace"></i> United</a></li>
                      </ul>
                  </div>
                  <!-- theme selector ends -->
      
      
                  <!--<ul class="collapse navbar-collapse nav navbar-nav top-menu">
                  
            <li><img alt="BCPS Logo" src="img/BCPS_Transperant_Text.gif" height="50px" width="300px" /></li> --> 
            
            
                
           <!--<li><a href="https://10.234.20.55/index.php"><i class="glyphicon glyphicon-globe"></i> Servicedesk.com</a></li>-->
                      <!--<li class="dropdown">
<a href="#" data-toggle="dropdown"><i class="glyphicon glyphicon-star"></i> Dropdown <span class="caret"></span></a>
                          <ul class="dropdown-menu" role="menu">
                              <li><a href="#">Action</a></li>
                              <li><a href="#">Another action</a></li>
                              <li><a href="#">Something else here</a></li>
                              <li class="divider"></li>
                              <li><a href="#">Separated link</a></li>
                              <li class="divider"></li>
                              <li><a href="#">One more separated link</a></li>
                          </ul>
                      </li>-->
                      
                      
                      <!--<li>
                          <form class="navbar-search pull-left">
                              <input placeholder="Search" class="search-query form-control col-md-10" name="query"
                                     type="text">
                          </form>
                      </li>-->
                      
                      
                  <!--</ul>-->
      
              </div>
    <!--</div>-->

        	</div>
   		</div>
    <!--</header>-->

	<div>&nbsp;</div>

    
    <!-- topbar ends -->
<?php } ?>
<div class="ch-container">
    <div class="row">
        <?php if (!isset($no_visible_elements) || !$no_visible_elements) { ?>

        <!-- left menu starts -->
        
        <div>&nbsp;</div>
        <div>&nbsp;</div>
        <div>&nbsp;</div>







<!--<div class="col-sm-2 col-lg-2">-->
<!--    <div class="sidebar-nav">-->
<!--        --><?php
//		if($rule == 0)
//		{ require("menu_user.php"); }
//		else if($rule == 2)
//		{ require("menu_coo.php"); } ?>
<!--    </div>-->
<!--</div>-->






        
        <!--/span-->
        <!-- left menu ends -->

       <!-- <noscript>
            <div class="alert alert-block col-md-12">
                <h4 class="alert-heading">Warning!</h4>

                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>-->

        <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
            <?php } ?>

            
