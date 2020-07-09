
<?php
	require_once('comon_pts.php');
	require_once('comon.php');
	require('header.php');

    $po_no = $_GET['po_no'];
    $purchase_no = $_GET['purchase_no'];
    $buyer = $_GET['brand'];
    $style_no = $_GET['style_no'];
    $style_name = $_GET['style_name'];
    $item = $_GET['item'];
    $quality = $_GET['quality'];
    $color = $_GET['color'];
    $qty = $_GET['qty'];

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

?>

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

  <?php require("info.php"); ?>

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

<!--     <div style="padding:10px 10px 20px 10px">-->
<!--     <strong>Entry Date: </strong>-->
<!--     <select name="entry_date" id="entry_date" data-rel="chosen" required autofocus>-->
<!--        <option style="color:#000" selected="selected" value="--><?php //echo $date; ?><!--">--><?php //echo $date; ?><!--</option>-->
<!--        <option style="color:#000" value="--><?php //echo $previous_date; ?><!--">--><?php //echo $previous_date; ?><!--</option>-->
<!--      </select>-->
<!--     </div>-->
     <!--<br /><br /><br />-->
         <?php
         $cut_count= 0;
         $SQL_cut="SELECT * FROM efl_db_pts.`tb_pc_detail` where po_no LIKE '%$po_no%' group by po_no";    //table name
         $result_cut = $obj_pts->sql_pts($SQL_cut);

         while ($row_cut = mysql_fetch_array($result_cut)) // Be careful $row1 can't repalce inside tis loop.
         {
             $cut_count = $row_cut['cut_no'];
         }

         $cut_count_1 = $cut_count+1;


         ?>
     	<table class="bottomBorder" border="1">
            <tr>
                <th>Buyer: <span style="color:#F00">*</span></th>
                <td><input name="buyer" id="buyer" readonly value="<?php echo $buyer;?>" required />
            </tr>
            <tr>
            	<th>Style: <span style="color:#F00">*</span></th>
                <td><input name="style" id="style" readonly value="<?php echo $style_no;?>" required />

                <th>Style Name: <span style="color:#F00">*</span></th>
                <td><input name="style_name" id="style" readonly value="<?php echo $style_name;?>" required />

                </td>
            	<th><span style="text-align:right">Color:</span> <span style="color:#F00">*</span></th>

                <!--<span style="text-align:right; font-size:18px; font:'Comic Sans MS', cursive ">Color:</span>-->

                <td>
                    <input name="color" readonly tabindex="2" id="color" value="<?php echo $color?>" required />
                </td>
                <th>Quality: <span style="color:#F00">*</span></th>
                <td><input name="quality" id="quality" readonly value="<?php echo $quality;?>" />
            </tr>
            <tr>
                <th>Cut No: <span style="color:#F00">*</span></th>
                <td><input type="text" readonly name="cut_id" tabindex="3" size="10" placeholder="Cut No" value="<?php echo $po_no.'_'.$style_no.'_'.$color.'_'.((!empty($item)) ? $item : '0').'_'.$cut_count_1.'.';?>" required autofocus /></td>
                <th>QTY: <span style="color:#F00">*</span></th>
                <td><input type="number" name="qty" readonly tabindex="4" size="5" min="1" max="99999999" placeholder="Qty" value="<?php echo $qty;?>" required autofocus /></td>
                <th>Lay: <span style="color:#F00">*</span></th>
                <td><input type="number" name="lay" tabindex="4" size="5" min="1" max="99999999" placeholder="Lay" required autofocus /></td>
                <th>Order No: <span style="color:#F00">*</span></th>
                <td><input type="text" name="order_no" readonly tabindex="5" size="12" placeholder="Order Number" value="<?php echo $po_no;?>" required autofocus ></td>
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
          <th>Qty<input name="data5" id="data5" type="hidden" value="<?php echo "<input name='qty[]' type='text' tabindex='7' onclick='select()' size='8' placeholder='Qty' required autofocus />"; ?>" /></th>
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

      <?php

         $SQL_po="SELECT id, po_no, purchase_order, brand, item, style_no, style_name, size, quantity,
                quality, color, ex_factory_date 
                FROM efl_db_pts.`tb_po_detail`
                WHERE po_no LIKE '%$po_no%' and purchase_order LIKE '%$purchase_no%'
                and quality LIKE '%$quality%' and item LIKE '%$item%'";    //table name
         $result_po = $obj_pts->sql_pts($SQL_po);
         while($row_po = mysql_fetch_array($result_po)) // Be careful $row1 can't repalce inside tis loop.
         {

		  $size=$row_po['size'];
		  $quantity=$row_po['quantity'];
		  echo '<tr>
          <td><input name="chk" type="checkbox" class="checkbox1" /></td>
          <td><input name="size[]" type="text" value="'.$size.'" onclick="select()" tabindex="7" size="8" placeholder="Size" required autofocus /></td>
          <td><input name="qty[]" type="text" value="'.$quantity.'" readonly onclick="select()" tabindex="7" size="8" placeholder="Size" required autofocus /></td>
          <td><input name="marker[]" class="ins_marker_no" type="number" value="0" onclick="select()" tabindex="9" min="0" size="8" placeholder="Marker" required autofocus /></td>
          <td><input name="bundle_ratio[]" class="ins_bundle_range" type="text" onclick="select()" tabindex="11" size="50" placeholder="Bundle Ratio" /></td>
          <td><input name="lot_no[]" class="ins_lot_no" type="text" onclick="select()" tabindex="13" size="10" placeholder="Lot No" /></td>
			</tr>';

		  }
	   ?>

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

<!--       <button class="btn btn-info" tabindex="14" onclick="OnButton2()" >Check</button>-->


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
          $SQL2="SELECT PartName, IsPrint FROM tb_vsfs_part_info WHERE StyleCode = (SELECT StyleCode FROM `tb_vsfs_style` ORDER BY StyleSL DESC LIMIT 0,1) ORDER BY PartInfoID ASC";    //table name
		  $result2 = $obj->sql($SQL2);
		  while($row2 = mysql_fetch_array($result2)) // Be careful $row1 can't repalce inside tis loop.
		  { ?>
          <tr>
              <td><input name="part_info[]" type="checkbox" value="<?php echo $row2['PartName'].'~'.$row2['IsPrint'] ; ?>" checked class="checkbox2" />
              </td>
              <td><?php echo $row2['PartName']; ?></td>
              <td>
              <?php if($row2['IsPrint'] == 1) echo '<span style="color:#0F9; font-weight:bold; font-size:15px">Yes</span>'; else echo 'No'; ?>
              </td>
          </tr>
		<?php } ?>

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


<?php require('footer.php'); ?>

