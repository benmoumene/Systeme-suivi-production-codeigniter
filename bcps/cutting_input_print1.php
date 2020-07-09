
<?php	
	require_once('comon.php');
	require('header.php');
		
	//$get_msg = $_GET['msg'];
	
	$get_cid = $_GET['cid'];
	$get_ttl = $_GET['ttl'];
	$lay = $_GET['lay'];
	$get_total_cl = $_GET['total_cl'];
	//$get_spe = $_GET['spe'];
	
	  $get_cid = base64_decode($get_cid);
	  $get_ttl = base64_decode($get_ttl);

	if (isset($_POST['Submit'])) { $AutoCutID=$_POST['AutoCutID']; }
	
	if($get_cid == '') { $get_cid = $AutoCutID; }
	
	// $decd_CutID = base64_decode($get_cid);

?>
  
<div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="#">Forms</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
               <h2><i class="glyphicon glyphicon-edit"></i> Print Cutting Information</h2>

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
            <br />
            
            
            
            	<?php if($get_cid != '') { ?>
                    <p style="margin-left:15px; font-weight:bold">
 <span style="color:#0F9; font-size:14px">The Auto Cut Id is : </span><u><span style="color:#0FF; font-size:18px">&nbsp;<?php echo $get_cid; ?> </span></u>
 
<!--							--><?php //if($get_ttl != '') { ?>
<!-- &nbsp;<span style="color:#0F9; font-size:14px"> And Total Bundle Ticket is : </span><u><span style="color:#0FF; font-size:18px">&nbsp;--><?php //echo $get_ttl; ?><!-- </span></u>-->
<!--							--><?php //} ?>

							<?php if($get_total_cl != '') { ?>
 &nbsp;<span style="color:#0F9; font-size:14px"> And Total Qty is : </span><u><span style="color:#0FF; font-size:18px">&nbsp;<?php echo $get_total_cl; ?> </span></u>
							<?php } ?>
                            
                     </p>
                     <br/>
                <?php } ?>
             
         <!--<br /><br /> -->
         
     <?php if($get_cid == '') { ?>    
	<!--<details style="margin-left:30px">
    <summary><span style="font-size:14px; font-weight:bold; color:#0190b8">Search Auto Cut ID &#10144; </span></summary>-->
    

            <!--<br /><br />-->

         <form name="Form1" action="cutting_input_print1.php" method="post" class="form-inline" role="form">

             <input name="lay" id="lay" value="<?php echo $lay;?>" type="text" class="form-control" />

        <span style="font-size:14px; font-weight:bold; color:#0190b8; margin-left:30px">&nbsp;&nbsp;&nbsp;Search Auto Cut ID &#10144; </span>&nbsp;&nbsp;&nbsp;&nbsp;
         <input name="AutoCutID" type="text" class="form-control" placeholder="Type Auto CutID" list="characters1" />


           
              <datalist id="characters1">
              				<?php
         					$SQL="SELECT DISTINCT AutoCutID FROM tb_vsfs_cut_info ORDER BY AutoCutID DESC ";
                            $obj->sql($SQL);
                            while($row = mysql_fetch_array($obj->result))
                            { 
                            $dis=$row['AutoCutID'];
                            echo '<option value="'.$dis.'">';
                            }
                            ?>
             </datalist>
            
            <!--<br /><br />-->
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Submit" type="submit" class="btn btn-success" value="Search">&nbsp;
            <input name="Reset" type="reset" class="btn btn-danger" value="Reset" />
            </form>
            
     <!--</details>-->
            
            <br /><br />
            
     <?php } else { ?> 
     
     
                    
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
                   
					<script type="text/javascript">
					
					
					
					function without_print(){
						document.getElementById("print_flag").value="0";
						document.getElementById("Form2").action="print_cut_panels_pdf_1.php";
						document.getElementById("Form2").submit();
						}

					function care_label_print(){
//						document.getElementById("print_flag").value="0";
						document.getElementById("Form2").action="care_label_printing.php";
						document.getElementById("Form2").submit();
						}
					
					function with_print(){
						document.getElementById("print_flag").value="1";
						document.getElementById("Form2").action="print_cut_panels_pdf_1.php";
						document.getElementById("Form2").submit();
						}
						
					function sticker_print(){
						document.getElementById("Form2").action="print_sticker_serial.php";
						document.getElementById("Form2").submit();
						}
											
					
                         /*$(document).ready(function() {  						 
                         $('#without_print').click(function() {
                            
							
							document.getElementById('print_flag').value='0' ;
							document.getElementById("Form2").submit(); 
							                 
                           }); 
						 });*/
                     </script>
                      
		<form name="Form2" id="Form2" method="post" target="_blank" > 

        	<input name="cid" type="hidden" value="<?php echo $get_cid; ?>" />
            <input name="print_flag" id="print_flag" type="hidden" />
        
         	<table>
            	<tr>
                <td valign="top">
                <span style="color:#068C99; font-size:14px; font-weight:bold; margin-left:25px">Click any of below two Buttons &#10137;<!--&#10142;--></span>  
                <br /><br />
                <div style="margin-left:50px">
                
               <!--<input name="without_print" id="without_print" type="submit" class="btn btn-primary" onclick="without_print()" value="Solid Part" />
                &nbsp;
               <input name="with_print" id="with_print" type="submit" class="btn btn-info" onclick="with_print()" value="Print Part" />-->
                
                <!--btn btn-primary-->
                <button class="btn btn-success" onclick="without_print()" >Solid Part</button>

                <button class="btn btn-primary" onclick="care_label_print()" >Generate CL </button>
                 &nbsp;
<!--                <button class="btn btn-info" onclick="with_print()" >Print Part</button>-->

               <!--<input name="without_print" id="without_print" type="submit" class="btn btn-primary" onclick="return without_print();" value="Solid Part" />
                &nbsp;
               <input name="with_print" id="with_print" type="submit" class="btn btn-info" onclick="return with_print();" value="Print Part" />
                -->
                                
               <!-- <a href="print_cut_panels.php?cid=<?php // echo base64_encode($get_cid); ?>&pf=0" target="_blank"><input name="without_print" type="submit" class="btn btn-primary" value="Solid Part" /></a>
                &nbsp;
                <a href="print_cut_panels.php?cid=<?php // echo base64_encode($get_cid); ?>&pf=1" target="_blank"><input name="print" type="submit" class="btn btn-info" id="submit" value="Print Part" /></a>
                --></div>
            	<br /></td>
            	<td valign="top">
                    
                    
                <span style="color:#FF6A22; font-size:14px; font-weight:bold; margin-left:25px">Print Sticker Serial &#10137;<!--&#10142;--></span>  
                    <br/><br/>
                    <div style="margin-left:40px">

<!--                <button class="btn btn-warning" onclick="sticker_print()" >Print Sticker</button>-->
                
                 </div>
                <br /> 
                                   
                </td>
            	<td valign="top">
                    
                    <div style="margin-left:30px">
                    
                    <span style="color:#09F; font-size:14px; font-weight:bold">Select Part You want to Print &#10137;<!--&#10142;--></span>  
                    <br/><br/>

                	<table class="bottomBorder" border="1" style="margin-left:20px">
                    	<tr>
         					<th><label style="font-weight:bold" title="Click to Select All"><input type="checkbox" id="selecctall2" checked /><!--&nbsp;#Select All--></label></th>
                            <th>Part Name</th>
                            <th>Print Status</th>
                        </tr>
						<?php 
                          $SQL2 = "SELECT PartName,print_flag FROM tb_vsfs_bundle_info WHERE CutID = '$get_cid' GROUP BY PartName ORDER BY AutoBundleID ASC";
						  $result2 = $obj->sql($SQL2);
                          while($row2 = mysql_fetch_array($result2))
                          {
                        ?>
                        <tr>
                            <td><input name="part_info[]" type="checkbox" value="<?php echo $row2['PartName']; ?>" checked class="checkbox2" />
                            <td><?php echo $row2['PartName']; ?></td>
                            <td><?php if ($row2['print_flag'] == 1) echo 'Yes'; else echo 'No'; ?></td>
                        </tr>
         <?php } ?>               
                    </table> 
                 </div>
                                   
                </td>
            	<td valign="top">
                    
                    <div style="margin-left:30px">
                    
                    <span style="color:#09F; font-size:14px; font-weight:bold">Select Size You want to Print &#10137;<!--&#10142;--></span>  
                    <br/><br/>

                	<table class="bottomBorder" border="1" style="margin-left:20px">
                    	<tr>
         					<th><label style="font-weight:bold" title="Click to Select All"><input type="checkbox" id="selecctall" checked /><!--&nbsp;#Select All--></label></th>
                            <th>Size</th>
                            <th>Lot No</th>
                        </tr>
						<?php 
                          //$SQL2="SELECT PartName, IsPrint FROM tb_vsfs_part_info WHERE StyleCode = $StyleCode ORDER BY PartInfoID ASC";    //table name
                         
                          // $SQL2 = "SELECT Suff, LotNo FROM tb_vsfs_bundle_info WHERE CutID = '$get_cid' GROUP BY Suff ORDER BY AutoBundleID ASC";
                          $SQL2 = "SELECT Size, Suff, LotNo FROM tb_vsfs_bundle_info WHERE CutID = '$get_cid' GROUP BY Suff ORDER BY AutoBundleID ASC";
						  $result2 = $obj->sql($SQL2);
                          while($row2 = mysql_fetch_array($result2))
                          {
                        ?>
                        <tr>
                            <td><input name="size_info[]" type="checkbox" value="<?php echo $row2['Suff']; ?>" checked class="checkbox1" />
<!--                            <td>--><?php //echo $row2['Suff']; ?><!--</td>-->
                            <td><?php echo $row2['Size']; ?></td>
                            <td><?php echo $row2['LotNo']; ?></td>
                            <!--<td><input name="s[]" type="text" value="<?php // echo $row2['Suff']; ?>" size="5" readonly class="form-control" /></td>
                            <td><input name="l[]" type="text" value="<?php // echo $row2['LotNo']; ?>" size="5" readonly class="form-control" /></td>-->
                        </tr>
         <?php } ?>               
                    </table> 
                 </div>
                                   
                </td>
         	</tr>
         </table>
       </form> 
          		<!--<script type="text/javascript">-->
				<!--<script language="Javascript">
                function without_print()
                {
                    //alert('I am in With Out Print !!!');
					//document.getElementById('print_flag').value='0' ; 
					document.Form2.action = "print_cut_panels.php"
                    document.Form2.submit();   // Submit the page   	
                    //document.Form2.target="_blank";  // Open in a new window
                    return true;
                }
                
                function with_print()
                {
					//document.getElementById('print_flag').value='1' ; 
					document.Form2.action = "print_cut_panels.php"
                    document.Form2.submit();   // Submit the page   	
                    //document.Form2.target="_blank";  // Open in a new window
                    return true;
                }
                </script> -->               
            </div>
            
                     
     <?php } ?>
                
            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->


<?php require('footer.php'); ?>

