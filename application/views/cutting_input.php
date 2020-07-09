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

    <script src="<?php echo base_url(); ?>assets/bcps/img/CalendarControl1.js" type="text/javascript"></script>
    <link href="<?php echo base_url(); ?>assets/bcps/img/CalendarControl.css" rel="stylesheet" type="text/css" />


    <!--<link id="bs-css" href="css/bootstrap-spacelab.min.css" rel="stylesheet">-->
    <link id="bs-css" href="<?php echo base_url(); ?>assets/bcps/css/bootstrap-slate.min.css" rel="stylesheet">


    <link href="<?php echo base_url(); ?>assets/bcps/css/charisma-app.css" rel="stylesheet">
    <!--<link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>-->
    <link href='<?php echo base_url(); ?>assets/bcps/bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>assets/bcps/bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>assets/bcps/bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>assets/bcps/bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>assets/bcps/css/jquery.noty.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>assets/bcps/css/noty_theme_default.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>assets/bcps/css/elfinder.min.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>assets/bcps/css/elfinder.theme.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>assets/bcps/css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>assets/bcps/css/uploadify.css' rel='stylesheet'>
    <link href='<?php echo base_url(); ?>assets/bcps/css/animate.min.css' rel='stylesheet'>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/bcps/img/favicon.ico">
    <!-- jQuery -->

    <script src="<?php echo base_url(); ?>assets/bcps/bower_components/jquery/jquery.min.js"></script>
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







        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <?php
                if($rule == 0)
                { require("menu_user.php"); }
                else if($rule == 2)
                { require("menu_coo.php"); } ?>
            </div>
        </div>







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


	<style type="text/css">

	<!--::-webkit-input-placeholder {color: black;}-->

	::-webkit-input-placeholder {color:#3CF;}

	.placeholder_color ::-webkit-input-placeholder {color: #FF6A22;}
	.placeholder_color :-moz-placeholder {color: #FF6A22;}
	.placeholder_color ::-moz-placeholder {color: #FF6A22;}
	.placeholder_color :-ms-input-placeholder {color: #FF6A22;}

	select { color:#000; }

	/*select option { color:#000; }*/

	 /*.green option{
        color:#0F0;
    }*/

	</style>

        <SCRIPT language="javascript">

      /* function addRow(tableID) {

            var table = document.getElementById(tableID);

            var rowCount = table.rows.length;
			//alert(rowCount);
            var row = table.insertRow(rowCount);

            var colCount = table.rows[0].cells.length;

            for(var i=0; i<colCount; i++) {

                var newcell = row.insertCell(i);

                newcell.innerHTML = table.rows[1].cells[i].innerHTML;
            }
        }*/

				/*alert(newcell.childNodes[i].type);

				switch(newcell.childNodes[i].type) {
                    case "text":
							alert('text');
                            // newcell.childNodes[i].value = "";
							break;
					case "number":
							alert('number');
                            //newcell.childNodes[i].value = "";
                            break;
					case "checkbox":
							alert('checkbox');
                            // newcell.childNodes[i].checked = false;
                            break;
                }*/

                   /*
				   break;
					case "number":
                            newcell.childNodes[i].value = "";
                            break;
					case "checkbox":
                            newcell.childNodes[i].checked = false;
                            break;

				   case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;*/




                //alert(newcell.childNodes);
                /*switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }*/



       /*function deleteRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 2) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }


            }
            }catch(e) {
                alert(e);
            }
        }*/



		function addSize(tableID) {

            var table = document.getElementById(tableID);

           // var table1 = document.getElementById('demo_size_mrkr');

            var rowCount = table.rows.length;
			var colCount = table.rows[0].cells.length;

			for(var i=1; i<rowCount; i++) {
                var row = table.rows[i];

				var insrow = i+1;

                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {

							row.cells[0].childNodes[0].checked = false;
							//newcell.childNodes[1].checked = false;

							var ins = 1;
							var row = table.insertRow(insrow);

							for(var j=0; j<colCount; j++) {
								var newcell = row.insertCell(j);
								//newcell.innerHTML = table.rows[1].cells[i].innerHTML;

								newcell.innerHTML = document.getElementById('data'+j).value;

                				//newcell.innerHTML = table.rows[0].cells[i].innerHTML;


									/*if(i==1){

										//alert(i);

								switch(newcell.childNodes[1].type) {
									case "text":
											newcell.childNodes[1].value = "";
											break;
									case "checkbox":
											newcell.childNodes[1].checked = false;
											break;
									case "select-one":
											newcell.childNodes[1].selectedIndex = 0;
											break;
																	}
											}*/

														  }
				}
			}

			if(ins == null)
			{
			  var row = table.insertRow(rowCount);
			  for(var i=0; i<colCount; i++) {
			  var newcell = row.insertCell(i);
			  //newcell.innerHTML = table.rows[1].cells[i].innerHTML;
			  newcell.innerHTML = document.getElementById('data'+i).value;

					  						}
			}

        }




		function deleteSizeRow(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }


            }
            }catch(e) {
                alert(e);
            }
        }

    </SCRIPT>

<!--<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Forms</a>
        </li>
    </ul>
</div>-->

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
               <h2><i class="glyphicon glyphicon-edit"></i> Add Cutting Information</h2>

                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round btn-default"><i
                            class="glyphicon glyphicon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
            	
             <script type="text/javascript">
					
				function OnButton1(){


                    if(document.getElementById('grouping').checked) {
                        document.getElementById("Form1").action="cutting_input_save.php";
                        document.getElementById("Form1").submit();
                    }else if(document.getElementById('continuous').checked) {
                        document.getElementById("Form1").action="cutting_input_save_new.php";
                        document.getElementById("Form1").submit();
                    }else{
                        alert("Nothing Checked!");
                    }

					}
				
				function OnButton2(){
					document.getElementById("Form1").action="cutting_input_total.php";
					document.getElementById("Form1").submit();
					// document.getElementById("Form1").target="_blank";
					}
						
				
				/*$(document).ready(function() {
				$("#ins_marker").change(function() {
					var dis=$(this).val();
					$('.ins_marker_no').each(function() {
						this.value = dis;
                 	});
					document.getElementById("ins_marker").value = '';
					});
				});
				
					               
				$(document).ready(function() {
				$("#ins_bundle_ratio").change(function() {
					var dis=$(this).val();
					$('.ins_bundle_range').each(function() {
						this.value = dis;
                 	});
					document.getElementById("ins_bundle_ratio").value = '';
					});
				});
				
				
				
				$(document).ready(function() {
				$("#ins_lot").change(function() {
					var dis=$(this).val();
					$('.ins_lot_no').each(function() {
						this.value = dis;
                 	});
					document.getElementById("ins_lot").value = '';
					});
				});
				
				*/
				
				
      /*$(document).ready(function() {
         $('#selecctall').click(function(event) {  //on click 
             if(this.checked) { // check select status
                 $('.checkbox1').each(function() { //loop through each checkbox
                     this.checked = true;  //select all checkboxes with class "checkbox1"               
                 });
             }else{
                 $('.checkbox1').each(function() { //loop through each checkbox
                     this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                 });         
             }
         });
      });*/
				
			</script>
      
     <form name="Form1" id="Form1" enctype="multipart/form-data" method="post" class="form-inline" role="form">

     <!--<form name="" id="Form1" enctype="multipart/form-data" action="cutting_input_save.php" method="post" class="form-inline" role="form">-->
     <!--<form class="form-inline" role="form">-->
     
     <div style="padding:10px 10px 20px 10px">
     <strong>Entry Date: </strong>
     <select name="entry_date" id="entry_date" data-rel="chosen" required autofocus>
        <option style="color:#000" selected="selected" value="<?php echo $date; ?>"><?php echo $date; ?></option>
        <option style="color:#000" value="<?php echo $previous_date; ?>"><?php echo $previous_date; ?></option>
      </select>
     </div>
     <!--<br /><br /><br />-->
     	<table class="bottomBorder" border="1">
        	<tr>
            	<th>Style: <span style="color:#F00">*</span></th>
                <td><select name="style" id="style" tabindex="1" data-rel="chosen" required autofocus>
                
                 <option style="color:#000" value="">Select Style ...</option>
                 
<!--					--><?php
//                    $SQL="SELECT DISTINCT StyleCode, season, BuyerID FROM tb_vsfs_style ORDER BY StyleSL DESC";    //table name
//                    $results = $obj->sql($SQL);
//                    while($row = mysql_fetch_array($results))
//                    {
//                    ?>
<!--                    <option style="color:#000" value="--><?php //echo $row['StyleCode'].'~'.$row['season'].'~'.$row['BuyerID']; ?><!--">--><?php //echo $row['StyleCode']; ?><!--</option>-->
<!--                    --><?php
//                    }
//                    ?>
                </select>
                
                </td>
            	<th><span style="text-align:right">Color:</span> <span style="color:#F00">*</span></th>
                
                <!--<span style="text-align:right; font-size:18px; font:'Comic Sans MS', cursive ">Color:</span>-->
                
                <td><select name="color" tabindex="2" id="color" required autofocus >
                  <option style="color:#000" selected="selected" value="">-Select Color-</option>
<!--         --><?php //
//       $SQL2 = "SELECT Color, OrderQty FROM tb_vsfs_color_info T0 WHERE T0.StyleCode = (SELECT StyleCode FROM `tb_vsfs_style` ORDER BY StyleSL DESC LIMIT 0,1) ORDER BY ColorInfoID DESC";
//		$obj->sql($SQL2);
//		while($row2 = mysql_fetch_array($obj->result))
//		  {
//		  $data=$row2['Color'].'~'.$row2['OrderQty'] ;
//		  $data1=$row2['Color'];
//		  echo '<option style="color:#000" value="'.$data.'">'.$data1.'</option>';
//		  }
//
//	   ?>
                  
                </select>
                <!--<input type="text" name="color" class="form-control" tabindex="2" placeholder="Color" required autofocus >--></td>
                <th>Cut No: <span style="color:#F00">*</span></th>
                <td><input type="text" name="cut_id" tabindex="3" size="10" placeholder="Cut No" required autofocus /></td>
                <th>Lay: <span style="color:#F00">*</span></th>
                <td><input type="number" name="lay" tabindex="4" size="5" min="1" max="99999999" placeholder="Lay" required autofocus /></td>
                <th>Order No: <span style="color:#F00">*</span></th>
                <td><input type="text" name="order_no" tabindex="5" size="12" placeholder="Order Number" required autofocus ></td>
                <th>Unit: <span style="color:#F00">*</span></th>
                <td><input type="text" name="unit" value="<?php // echo $user_unit; ?>" size="6" placeholder="Unit" readonly required autofocus ></td>
            </tr>
            <!--<tr>
              <td> Bundle Qty: <span style="color:#F00">*</span></td>
              <td><input type="number" name="bundle_qty" class="form-control" tabindex="2" placeholder="Bundle Qty" required autofocus ></td>
              <td> Lot No: </td>
              <td><input type="text" name="lot_no" class="form-control" tabindex="2" placeholder="Lot No" required autofocus ></td>
              <td> Unit: </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>-->
       </table>
         
         <br />
         <br />

        <div style="border-color: rgba(196,255,24,0.85); border-style: solid; width: 300px; margin-left: 100px;">
                 <table>
                     <tr>
                         <td><input type="radio" name="submit_type" id="grouping"></td>
                         <td>Grouping</td>
                         <td><input type="radio" name="submit_type" id="continuous"</td>
                         <td>Continuous</td>
                     </tr>
                 </table>
        </div>

    <table>
    <tr><td>
    
    
          <span style="color:#09F; font-size:14px; font-weight:bold; margin-left:15px">Add Size, Marker, Bundle Ratio and Lot Information &#10137;<!--&#10142;--></span>  
          
          <?php  // echo '=R='.round(4.49999).'=C='.ceil(4.49999); ?>
          
          <!--<span style="color:#09F; font-size:16px; font-weight:bold; margin-left:15px">Add Size and Marker Information >></span>--> <!--style="color:#33C"-->
         <br/><br/> 
         
    
   <script type="text/javascript">
   
	   /*$(document).ready(function() {
         $('#IsTube').click(function(event) {
		 document.getElementById("Form1").action="cutting_input_tube_save.php";
         });
      });*/
	  
	  
	  /* $(document).ready(function() {
         $('#IsTube').click(function(event) {  //on click 
		 //$("#ck").show();
		 if(this.checked) { // check select status
		 document.getElementById("Form1").action="cutting_input_tube_save.php";
             }else{
		 document.getElementById("Form1").action="cutting_input_save.php";
             }
         });
      });*/


   </script>

    
    <div style="margin-left:10px">   
    <!--<input type="button" value="Add" tabindex="6" class="btn btn-success btn-xs" onClick="addRow('size_mrkr')" />&nbsp;-->
    

    <!--<span style="margin-left:10px; color:#060; font-weight:bold">Insert Bundle Ratio:&nbsp;&nbsp;<input name="ins_bundle_ratio" id="ins_bundle_ratio" type="text" size="20" /></span>
    <span style="margin-left:10px; color:#060; font-weight:bold">Insert Lot No:&nbsp;&nbsp;<input name="ins_lot" id="ins_lot" type="text" size="15" /></span>-->
    
    <input type="button" value="Add" tabindex="6" class="btn btn-success btn-xs" onClick="addSize('size_mrkr')" />&nbsp;
    <input type="button" value="Delete" class="btn btn-warning btn-xs" onClick="deleteSizeRow('size_mrkr')" />
    
    <!--<span style="margin-left:50px; color:#0F9; font-weight:bold"><label style="font-weight:bold" title="Click if the Lays are Tube Fabric" ><input type="checkbox" name="IsTube" id="IsTube" value="1" />&nbsp;&nbsp;Is Tube?</label></span>-->
    
    
    <br/>
    <br/>
    
    <!--<table id="demo_size_mrkr">
        <tr>
            <td><input name='chk' type='checkbox' /></td>
          	<td><input name='size[]' type='text' tabindex='7' placeholder='Size' required autofocus /></td>
            <td><input name='marker[]' type='number' tabindex='8' min='1'  placeholder='Marker' required autofocus /></td>
            <td><input name='lay[]' type='number' tabindex='9' min='1' placeholder='Lay' required autofocus /></td>
            <td><input name='bundle_qty[]' type='number' tabindex='10' min='1' placeholder='Bundle Qty' required autofocus /></td>            
            <td><input name='lot_no[]' type='text' tabindex='11' placeholder='Lot' required autofocus /></td>
        </tr>
    </table>-->
   <div id="size_table">
   
      <script type="text/javascript">

      $(document).ready(function() {
         $('#selecctall').click(function(event) {  //on click 
             if(this.checked) { // check select status
                 $('.checkbox1').each(function() { //loop through each checkbox
                     this.checked = true;  //select all checkboxes with class "checkbox1"               
                 });
             }else{
                 $('.checkbox1').each(function() { //loop through each checkbox
                     this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                 });         
             }
         });
      });
	  
	  
	  $(document).ready(function() {
	  $("#ins_marker").change(function() {
		  var dis=$(this).val();
		  $('.ins_marker_no').each(function() {
			  this.value = dis;
		  });
		  document.getElementById("ins_marker").value = '';
		  });
	  });
	  
						 
	  $(document).ready(function() {
	  $("#ins_bundle_ratio").change(function() {
		  var dis=$(this).val();
		  $('.ins_bundle_range').each(function() {
			  this.value = dis;
		  });
		  document.getElementById("ins_bundle_ratio").value = '';
		  });
	  });
	  
	  
	  
	  $(document).ready(function() {
	  $("#ins_lot").change(function() {
		  var dis=$(this).val();
		  $('.ins_lot_no').each(function() {
			  this.value = dis;
		  });
		  document.getElementById("ins_lot").value = '';
		  });
	  });
	  
				
	  	  
   </script>

    
    <table class="bottomBorder" id="size_mrkr" style="box-shadow:0px 0px 0px 0px #FFF ;" border="1">
        <tr>
          <th><label title="Click to Select All"><input type="checkbox" id="selecctall" /></label>
          <input name="data0" id="data0" type="hidden" value="<?php echo "<input name='chk' type='checkbox' class='checkbox1' />"; ?>" /></th>
          <th>Size<input name="data1" id="data1" type="hidden" value="<?php echo "<input name='size[]' type='text' tabindex='7' onclick='select()' size='8' placeholder='Size' required autofocus />"; ?>" /></th>
          <th><!--Marker--><input name="data2" id="data2" type="hidden" value="<?php echo "<input name='marker[]' tabindex='9' class='ins_marker_no' type='number' value='0' onclick='select()' size='8' min='0'  placeholder='Marker9' required autofocus />"; ?>" />
          <span class="placeholder_color"><input name="ins_marker" id="ins_marker" type="number" tabindex="8" onclick="select()" size="8" min="0" placeholder="Insert Marker" /></span>
          </th>
          <th><!--Bundle Ratio--><input name="data3" id="data3" type="hidden" value="<?php echo "<input name='bundle_ratio[]' tabindex='11' class='ins_bundle_range' type='text' onclick='select()' size='50' placeholder='Bundle Ratio' />"; ?>" />
          
          <span class="placeholder_color"><input name="ins_bundle_ratio" id="ins_bundle_ratio" tabindex="10" type="text" size="44" placeholder="Insert Common Bundle Ratio (If Any)" /></span>
          </th>
          <th><!--Lot No--><input name="data4" id="data4" type="hidden" value="<?php echo "<input name='lot_no[]' tabindex='13' class='ins_lot_no' type='text' onclick='select()' size='10' placeholder='Lot No' />"; ?>" />
          
          <span class="placeholder_color"><input name="ins_lot" id="ins_lot" tabindex="12" type="text" size="9" placeholder="Insert LotNo" /></span>
          </th>
         </tr>

<!--      --><?php //
//		$SQL2="select size from tb_vsfs_size_info where StyleCode = (SELECT StyleCode FROM `tb_vsfs_style` ORDER BY StyleSL DESC LIMIT 0,1) order by SizeInfoID ASC";
//		$result2 = $obj->sql($SQL2);
//		while($row2 = mysql_fetch_array($result2))
//		  {
//		  $data=$row2['size'];
//		  echo '<tr>
//          <td><input name="chk" type="checkbox" class="checkbox1" /></td>
//          <td><input name="size[]" type="text" value="'.$data.'" onclick="select()" tabindex="7" size="8" placeholder="Size" required autofocus /></td>
//          <td><input name="marker[]" class="ins_marker_no" type="number" value="0" onclick="select()" tabindex="9" min="0" size="8" placeholder="Marker" required autofocus /></td>
//          <td><input name="bundle_ratio[]" class="ins_bundle_range" type="text" onclick="select()" tabindex="11" size="50" placeholder="Bundle Ratio" /></td>
//          <td><input name="lot_no[]" class="ins_lot_no" type="text" onclick="select()" tabindex="13" size="10" placeholder="Lot No" /></td>
//				</tr>';
//
//		  }
//	   ?>
         
        <!--<tr>
          <td><input name="chk" type="checkbox" /></td>
          <td><input name="size[]" type="number" tabindex="7" placeholder="Size" required autofocus /></td>
          <td><input name="marker[]" type="number" tabindex="8" placeholder="Marker" required autofocus /></td>
          <td><input name="lay[]" type="number" tabindex="9" placeholder="Lay" required autofocus /></td>
          <td><input name="bundle_qty[]" type="number" tabindex="10" placeholder="Bundle Qty" required autofocus /></td>
          <td><input name="lot_no[]" type="text" tabindex="11" placeholder="Lot" required autofocus /></td>
         </tr>-->
         
    </table>
    </div>
 </div> 
    
<br/><br/>
    
    <div align="left" style="margin-left:100px"> 
	  
      <!--<button class="btn btn-success" tabindex="12" onclick="OnButton1()" >Save</button>
      &nbsp;
      <input name="input" type="reset" class="btn btn-danger" tabindex="13" value="Reset" />
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <button class="btn btn-primary" tabindex="14" onclick="OnButton2()" >Check</button>-->
      
      
      <!--<input name="submit" type="submit" class="btn btn-success" tabindex="15" id="submit" value="Save" />
      &nbsp;
      <input name="input" type="reset" class="btn btn-danger" tabindex="16" value="Reset" />-->
      
      
      <!--<button class="btn btn-success" tabindex="15" onclick="OnButton1()" >Save</button>-->
      <input name="submit" type="submit" class="btn btn-success" onclick="OnButton1();" tabindex="15" id="submit" value="Save" />
      &nbsp;
      <input name="input" type="reset" class="btn btn-danger" tabindex="16" value="Reset" />
      
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      
       <button class="btn btn-info" tabindex="14" onclick="OnButton2()" >Check</button>
      
      
    </div>
    
    </td><td valign="top">
    
    <div style="margin-left:30px">
    <!--<br/>-->
    <span style="color:#09F; font-size:14px; font-weight:bold">Parts Information &#10137;<!--&#10142;--></span>  
    <br/><br/>
    
   <div id="part_table"> 
   
      <script type="text/javascript">
	  
	  $(document).ready(function() {
         $('#selecctall2').click(function(event) {  //on click 
             if(this.checked) { // check select status
                 $('.checkbox2').each(function() { //loop through each checkbox
                     this.checked = true;  //select all checkboxes with class "checkbox1"               
                 });
             }else{
                 $('.checkbox2').each(function() { //loop through each checkbox
                     this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                 });         
             }
         });
      });
	  
   </script>

   <table class="bottomBorder" style="box-shadow:0px 0px 0px 0px #FFF ; margin-left:10px" border="1">
        <tr>
          <th><label style="font-weight:bold" title="Click to Select All"><input type="checkbox" id="selecctall2" checked /></label></th>
          <th>Part Name</th>
          <th>Print Status</th>
        </tr>
        
<!--        --><?php //
//          $SQL2="SELECT PartName, IsPrint FROM tb_vsfs_part_info WHERE StyleCode = (SELECT StyleCode FROM `tb_vsfs_style` ORDER BY StyleSL DESC LIMIT 0,1) ORDER BY PartInfoID ASC";    //table name
//		  $result2 = $obj->sql($SQL2);
//		  while($row2 = mysql_fetch_array($result2)) // Be careful $row1 can't repalce inside tis loop.
//		  { ?>
<!--          <tr>-->
<!--              <td><input name="part_info[]" type="checkbox" value="--><?php //echo $row2['PartName'].'~'.$row2['IsPrint'] ; ?><!--" checked class="checkbox2" />-->
<!--              </td>-->
<!--              <td>--><?php //echo $row2['PartName']; ?><!--</td>-->
<!--              <td>-->
<!--              --><?php //if($row2['IsPrint'] == 1) echo '<span style="color:#0F9; font-weight:bold; font-size:15px">Yes</span>'; else echo 'No'; ?>
<!--              </td>-->
<!--          </tr>-->
<!--		--><?php //} ?>
        
    </table> 
    </div>
    </div>
    
    </td>
    
    </tr></table>
            
             </form>
      
             <br />
                
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->
<footer>
            <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

            <!-- library for cookie management -->
            <script src="js/jquery.cookie.js"></script>
            <!-- calender plugin -->
            <script src='bower_components/moment/min/moment.min.js'></script>
            <script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
            <!-- data table plugin -->
            <script src='js/jquery.dataTables.min.js'></script>

            <!-- select or dropdown enhancer -->
            <script src="bower_components/chosen/chosen.jquery.min.js"></script>
            <!-- plugin for gallery image view -->
            <script src="bower_components/colorbox/jquery.colorbox-min.js"></script>
            <!-- notification plugin -->
            <script src="js/jquery.noty.js"></script>
            <!-- library for making tables responsive -->
            <script src="bower_components/responsive-tables/responsive-tables.js"></script>
            <!-- tour plugin -->
            <script src="bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
            <!-- star rating plugin -->
            <script src="js/jquery.raty.min.js"></script>
            <!-- for iOS style toggle switch -->
            <script src="js/jquery.iphone.toggle.js"></script>
            <!-- autogrowing textarea plugin -->
            <script src="js/jquery.autogrow-textarea.js"></script>
            <!-- multiple file upload plugin -->
            <script src="js/jquery.uploadify-3.1.min.js"></script>
            <!-- history.js for cross-browser state change on ajax -->
            <script src="js/jquery.history.js"></script>
            <!-- application script for Charisma demo -->
            <script src="js/charisma.js"></script>

</footer>