
<?php	
	require_once('comon.php');
	require('header.php');
	
//		$date = date("d-m-Y");
//
//		$day_chk = date('l', strtotime(now)); // It contains the day name of Current Date
//
//		if ($day_chk=="Saturday")
//		{
//		$previous_date = date('d-m-Y', strtotime('-2 days')); // It contains the date 2 days before from today.
//		}
//		else
//		{ $previous_date = date('d-m-Y', strtotime('-1 days')); }
//
//
//
//	  	 $entry_date = $_POST['entry_date'];
	  
		  	  $style=mysql_real_escape_string($_POST['style']);
//		  	  $style1 = explode("~", $stylem);
//			  $style = $style1[0];
//			  $buyer = $style1[1];
	  
		  $color = $_POST['color'];
		  $cut_id = trim($_POST['cut_id']);
		  $cut_id=strtoupper($cut_id);
		  $lay = trim($_POST['lay']);
		  $order_no = trim($_POST['order_no']);
		  $order_no = strtoupper($order_no);
//		  $unit = $_POST['unit'];
	
	  	//$IsTube = $_POST['IsTube'];
		
		// die($stylem);

	$cnt = 0;
	$ttl_qty = 0;
		  
	foreach($_POST['bundle_ratio'] as $rowz=>$temp_bundle_ratio)
	  { 
		$temp_ttl_qty = 0;
		$row_ttl = 0;
		
		$bundle_ratio_m[] = trim($temp_bundle_ratio);

		$size = trim($_POST['size'][$rowz]);
		$temp_size=strtoupper($size);
		$size_m[] = $temp_size;

		$temp_marker = trim($_POST['marker'][$rowz]);
		$marker_m[] = $temp_marker;
		
		$temp_lot_no = trim($_POST['lot_no'][$rowz]);
		$lot_no_m[]=strtoupper($temp_lot_no);
		
		
		
		$temp_bndl=explode("+",$temp_bundle_ratio);	// the Bundle Ratio is divided here by + Sign.
			

			foreach($temp_bndl as $value=>$bundle_1) // Here $bundle_1 is a group of bundle located in $bundle_ratio.
			{

					$temp_bndl_1 = explode(".", $bundle_1);

					if(isset($temp_bndl_1[0])){
                        $bundle_qty_m = $temp_bndl_1[0];
                    }

                    if(isset($temp_bndl_1[0])){
                        $no_of_bundle = $temp_bndl_1[1];
                    }

                    echo '<pre>';
                    print_r($bundle_qty_m);
                    echo '</pre>';
                    echo '<pre>';
                    print_r($no_of_bundle);
                    echo '</pre>';

					if($no_of_bundle == '') { $no_of_bundle = 1; }
					
					$temp_ttl = $bundle_qty_m*$no_of_bundle ;
					$temp_ttl_qty = $temp_ttl_qty+$temp_ttl;
			}
			
		$row_ttl = $temp_ttl_qty*$temp_marker;	
		$ttl_qty = $ttl_qty+$row_ttl;
		
		$cnt ++;
			
	  }
	  	  
	    
	  $p = 0;
	  foreach($_POST['part_info'] as $rowz=>$part_info)
	  { 
	  $part_infom = explode("~", $part_info);
	  
	  $part_info_temp[$p] = $part_info;
	  // echo $part_info_temp[$p].'<br/><br/>';
	  $PartName[$p] = $part_infom[0];
	  $IsPrint[$p] = $part_infom[1];
	  $p ++;
	  }
	  
	  // die('Testing the Project.');
	  
?>

	<style type="text/css">
	
	<!--::-webkit-input-placeholder {color: black;}-->
	
	.placeholder_color ::-webkit-input-placeholder {color: #FF6A22;}
	.placeholder_color :-moz-placeholder {color: #FF6A22;}
	.placeholder_color ::-moz-placeholder {color: #FF6A22;}
	.placeholder_color :-ms-input-placeholder {color: #FF6A22;}
									
	</style>
  
        <SCRIPT language="javascript">
		
		function addSize(tableID) {
 
            var table = document.getElementById(tableID);

            var rowCount = table.rows.length;
			var colCount = table.rows[0].cells.length;

			for(var i=1; i<rowCount; i++) {
                var row = table.rows[i];
				
				var insrow = i+1;
				
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
					
							row.cells[0].childNodes[0].checked = false;
							
							var ins = 1;
							var row = table.insertRow(insrow);
				 
							for(var j=0; j<colCount; j++) {				 
								var newcell = row.insertCell(j);
								//newcell.innerHTML = table.rows[1].cells[i].innerHTML;
								
								newcell.innerHTML = document.getElementById('data'+j).value;               
	  
														  }
				}
			}
			
			if(ins == null)
			{
			  var row = table.insertRow(rowCount);
			  for(var i=0; i<colCount; i++) {		 
			  var newcell = row.insertCell(i);
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
        
  <?php require("info.php"); ?>

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
					
				/*function OnButton1(){
					document.getElementById("Form1").action="cutting_input_save.php";
					document.getElementById("Form1").submit();
					}*/
				
				function OnButton2(){
					document.getElementById("Form1").action="cutting_input_total.php";
					document.getElementById("Form1").submit();
					// document.getElementById("Form1").target="_blank";
					}
						
			</script>
     
     <!--<?php // if($IsTube == 1) { ?> 
     <form name="Form1" id="Form1" enctype="multipart/form-data" action="cutting_input_tube_save.php" method="post" class="form-inline" role="form">
     <?php // } else { ?>
     <form name="Form1" id="Form1" enctype="multipart/form-data" action="cutting_input_save.php" method="post" class="form-inline" role="form">
     <?php // } ?>-->
     
     
     <form name="Form1" id="Form1" enctype="multipart/form-data" action="cutting_input_save.php" method="post" class="form-inline" role="form">
     
     

     <!--<form name="" id="Form1" enctype="multipart/form-data" action="cutting_input_save.php" method="post" class="form-inline" role="form">-->

     <!--<form class="form-inline" role="form">-->
     
     <div style="padding:10px 10px 20px 10px">
     <strong>Entry Date: </strong>
     <select name="entry_date" id="entry_date" data-rel="chosen" required autofocus>
        <option style="color:#000" selected="selected" value="<?php echo $entry_date; ?>"><?php echo $entry_date; ?></option>
        <option style="color:#000" value="<?php echo $date; ?>"><?php echo $date; ?></option>
        <option style="color:#000" value="<?php echo $previous_date; ?>"><?php echo $previous_date; ?></option>
      </select>
     </div>

     	<table class="bottomBorder" border="1">
        	<tr>
            	<th>Style: <span style="color:#F00">*</span></th>
                <td><input name="stylem" id="stylem" value="<?php echo $style; ?>" readonly size="15" tabindex="1" required autofocus />
                <input name="style" id="style" type="hidden" value="<?php echo $stylem; ?>" readonly />
                </td>

            	<td> Color: <span style="color:#F00">*</span></td>
                <td><select name="color" tabindex="2" id="color" required autofocus data-rel="chosen" >
                  <option style="color:#000" selected value="<?php echo $color; ?>"><?php echo $color; ?></option>
                  <option style="color:#000" value="">-Select Color-</option>
					 <?php         
                   $SQL2 = "SELECT Color, OrderQty FROM tb_vsfs_color_info T0 WHERE T0.StyleCode = '$style' ORDER BY ColorInfoID DESC";
                    $obj->sql($SQL2);
                    while($row2 = mysql_fetch_array($obj->result))
                      { 
					  $data=$row2['Color'].'~'.$row2['OrderQty'] ;
					  $data1=$row2['Color'];
					  echo '<option style="color:#000" value="'.$data.'">'.$data1.'</option>';
					  }
                   ?>
                </select>
                </td>
                <th> Cut No: <span style="color:#F00">*</span></th>
                <td><input type="text" name="cut_id" tabindex="3" value="<?php echo $cut_id; ?>" size="10" placeholder="Cut No" required autofocus /></td>
                <th> Lay: <span style="color:#F00">*</span></th>
                <td><input type="number" name="lay" tabindex="4" value="<?php echo $lay; ?>" size="5" placeholder="Lay" required autofocus /></td>
                <th> Order No: <span style="color:#F00">*</span></th>
                <td><input type="text" name="order_no" tabindex="5" value="<?php echo $order_no; ?>" size="12" placeholder="Order Number" required autofocus ></td>
                <th> Unit: <span style="color:#F00">*</span></th>
                <td><input type="text" name="unit" value="<?php echo $unit; ?>" tabindex="6" size="6" placeholder="Unit" readonly required autofocus ></td>
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
	  
	  
	   /*$(document).ready(function() {
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
    
    <input type="button" value="Add" tabindex="7" class="btn btn-success btn-xs" onClick="addSize('size_mrkr')" />&nbsp;
    <input type="button" value="Delete" class="btn btn-warning btn-xs" onClick="deleteSizeRow('size_mrkr')" />
    
    <!--<span style="margin-left:50px; color:#0F9; font-weight:bold"><label style="font-weight:bold" title="Click if the Lays are Tube Fabric" ><input type="checkbox" name="IsTube" id="IsTube" <?php // if($IsTube == 1) echo 'checked'; ?> value="1" />&nbsp;&nbsp;Is Tube?</label></span>-->
    
    
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
          <th>Size<input name="data1" id="data1" type="hidden" value="<?php echo "<input name='size[]' type='text' tabindex='11' onclick='select()' size='8' placeholder='Size' required autofocus />"; ?>" /></th>
          <th><!--Marker--><input name="data2" id="data2" type="hidden" value="<?php echo "<input name='marker[]' class='ins_marker_no' type='number' value='0' onclick='select()' tabindex='12' size='8' min='0'  placeholder='Marker' required autofocus />"; ?>" />
          <span class="placeholder_color"><input name="ins_marker" id="ins_marker" type="number" tabindex="8" onclick="select()" size="8" min="0" placeholder="Insert Marker" /></span>
          </th>
          <th><!--Bundle Ratio--><input name="data3" id="data3" type="hidden" value="<?php echo "<input name='bundle_ratio[]' class='ins_bundle_range' type='text' onclick='select()' tabindex='13' size='50' placeholder='Bundle Ratio' />"; ?>" />
          
          <span class="placeholder_color"><input name="ins_bundle_ratio" id="ins_bundle_ratio" tabindex="9" type="text" size="44" placeholder="Insert Common Bundle Ratio (If Any)" /></span>
          </th>
          <th><!--Lot No--><input name="data4" id="data4" type="hidden" value="<?php echo "<input name='lot_no[]' class='ins_lot_no' type='text' onclick='select()' tabindex='14' size='10' placeholder='Lot No' />"; ?>" />
          
          <span class="placeholder_color"><input name="ins_lot" id="ins_lot" tabindex="10" type="text" size="9" placeholder="Insert LotNo" /></span>
          </th>
         </tr>
	  
         <?php 
			for($i=0; $i<$cnt; $i++) {
			
		  echo '<tr>
          <td><input name="chk" type="checkbox" class="checkbox1" /></td>
          <td><input name="size[]" type="text" value="'.$size_m[$i].'" onclick="select()" tabindex="11" size="8" placeholder="Size" required autofocus /></td>
          <td><input name="marker[]" class="ins_marker_no" type="number" value="'.$marker_m[$i].'" onclick="select()" tabindex="12" min="0" size="8" placeholder="Marker" required autofocus /></td>
          <td><input name="bundle_ratio[]" class="ins_bundle_range" type="text" value="'.$bundle_ratio_m[$i].'" onclick="select()" tabindex="13" size="50" placeholder="Bundle Ratio" /></td>
          <td><input name="lot_no[]" class="ins_lot_no" type="text" value="'.$lot_no_m[$i].'" onclick="select()" tabindex="14" size="10" placeholder="Lot No" /></td>
				</tr>';
			}
		 ?>
	  
    </table>
    </div>
 </div> 
    
<br/><br/>
    
    <div align="left" style="margin-left:100px"> 
	  
      <!--<button class="btn btn-success" tabindex="15" onclick="OnButton1()" >Save</button>-->
      
      <input name="submit" type="submit" class="btn btn-success" tabindex="15" id="submit" value="Save" />
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
        
        <?php 
			for($i=0; $i<$p; $i++) {
		 ?>
        
          <tr>
              <td><input name="part_info[]" type="checkbox" value="<?php echo $part_info_temp[$i] ; ?>" checked class="checkbox1" />
              </td>
              <td><?php echo $PartName[$i]; ?></td>
              <td>
              <?php if($IsPrint[$i] == 1) echo '<span style="color:#0F9; font-weight:bold; font-size:15px">Yes</span>'; else echo 'No'; ?>
              </td>
          </tr>

        <?php } ?>
        
    </table>
    
    
        
    <br /><br />
    <?php if($ttl_qty != '') { ?>
    <span style="color:#0F9; font-size:18px; font-weight:bold">The Total Qty is: <?php echo $ttl_qty; ?></span>
    <?php } ?>
    

     
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


<?php require('footer.php'); ?>

