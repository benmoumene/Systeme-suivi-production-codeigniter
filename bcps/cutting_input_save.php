<?php 

// die('I am in Normal Save Page');

require_once('comon.php');
	
if (isset($_POST['submit']) and $_SERVER['REQUEST_METHOD'] == "POST")
	{

	$datex = new DateTime(null, new DateTimeZone('ASIA/Dhaka'));			
	$date=$datex->format('d-m-Y');
	$datex->modify('-3600 seconds');									
	$datex=$datex->format("d-m-Y H:i:s");
	
	  
	  $entry_date = $_POST['entry_date'];
	  
	  // echo $entry_date.'<br/>' ;

	  $stylem=mysql_real_escape_string($_POST['style']);
	  $stylem = explode("~", $stylem);
	  $style = $_POST['style'];
	  $style_name = $_POST['style_name'];
//	  $season = $stylem[1];
	  $buyer = $_POST['buyer'];
	  
	  $colorm = $_POST['color'];
//	  $colorm = explode("~", $colorm);
//	  $color = trim($colorm[0]);
//	  $Clr_OrderQty = trim($colorm[1]);
	  
	  
	  $cut_id = trim($_POST['cut_id']);
	  $cut_id=strtoupper($cut_id);
	  $lay = trim($_POST['lay']);
	  $order_no = trim($_POST['order_no']);
	  $order_no = strtoupper($order_no);
//	  $unit = $_POST['unit'];
	  
	  //$ins_lot = $_POST['ins_lot'];
	  //$IsTube = $_POST['IsTube'];
	  
	 // die($IsTube);

//	  $auto_CutID = $_POST['auto_CutID'];
	  $auto_CutID = $_POST['cut_id'];

	 /*foreach($_POST['part_info'] as $part_row=>$part_info)
	  { echo $part_row.' == '.$part_info.'<br/><br/>'; }
	  die('Okay, Bye. <br/> Assalamu Alikum !!!');*/
	  
	  
	  
	  
	  if($auto_CutID != '')
	  {
		// $SQL = "UPDATE tb_vsfs_cut_info SET `StyleCode` = '$style', `Color` = '$color', `CutNo` = '$cut_id', `OrderNo` = '$order_no', `UnitName` = '$unit', `u_id` = '$vsfs_uid', `entry_time` = '$datex' WHERE AutoCutID = '$auto_CutID'";

		//Previous Codes Starts

//        $SQL = "UPDATE tb_vsfs_cut_info SET `Color` = '$color', `CutNo` = '$cut_id', `OrderNo` = '$order_no', Lay = '$lay', `UnitName` = '$unit', `u_id` = '$vsfs_uid', `entry_time` = '$datex' WHERE AutoCutID = '$auto_CutID'";
//		$obj->sql($SQL);
//
//		$SQL = "DELETE FROM tb_vsfs_size_marker WHERE cut_id = '$auto_CutID'";
//		//die($SQL);
//		$obj->sql($SQL);
//
//		$SQL = "DELETE FROM tb_vsfs_bundle_info WHERE CutID = '$auto_CutID'";
//		$obj->sql($SQL);
//
//		$SQL = "DELETE FROM tb_vsfs_sticker_info WHERE CutID = '$auto_CutID'";
//		$obj->sql($SQL);
//
//
//	  }
//
//	  else
//	  {
//		  $SQL_CutID = "SELECT MAX(AutoCutID)+1 AS 'auto_CutID' FROM tb_vsfs_cut_info";
//		  $results_CutID = $obj->sql($SQL_CutID);
//		  while($row_CutID = mysql_fetch_array($results_CutID))
//		  { $auto_CutID = $row_CutID['auto_CutID']; } // May be it also can do with $SQL ;

          //Previous Codes Ends

			$SQL = "INSERT INTO tb_vsfs_cut_info (`sl`, `AutoCutID`, `buyer`, `StyleCode`, `style_name`, `season`, `Color`, `Clr_OrderQty`, `CutNo`, `OrderNo`, `Lay`, `UnitName`, `u_id`, `entry_date`, `entry_time`) VALUES ('', '$auto_CutID', '$buyer', '$style', '$style_name', '', '$color', '', '$cut_id', '$order_no', '$lay', '', '', '$entry_date', '$datex')"; //here the special field is missing as it will autometically assigned as 0 bcz it is not for Special Cut Save.
			
			//die($SQL);
			//echo $SQL.'<br/><br/><br/>';
			//die('Please wait a Moment as Some Development Work is Running !!! Thanks for Co-Operation.');
			
			$obj->sql($SQL);
	  }
	
	
	
	$rowz = 0;
	foreach($_POST['bundle_ratio'] as $rowz=>$temp_bundle_ratio)
	  { 
		$bundle_ratio_m[] = trim($temp_bundle_ratio);

		$size = trim($_POST['size'][$rowz]);
		$temp_size=strtoupper($size);
		
		$sizea = explode("-",$temp_size);
		$temp_cut_size = trim($sizea[0]);
		$cut_size_m[]=$temp_cut_size;
		
		$size_input[] = $temp_size; // The inputed Size from User End
		$size_m[] = $temp_size;

		$temp_marker = trim($_POST['marker'][$rowz]);
		$marker_m[] = $temp_marker;		
		$temp_lot_no = trim($_POST['lot_no'][$rowz]);
		$lot_no_m[]=strtoupper($temp_lot_no);
		
		//die($size);
		
		$SQL = "INSERT INTO `tb_vsfs_size_marker` (`sl`, `cut_id`, `size_main`, `size`, `marker`, `bundle_ratio`, `lot_no`, `u_id`, `entry_time`) VALUES ('', '$auto_CutID', '$temp_cut_size', '$temp_size', '$temp_marker', '$temp_bundle_ratio', '$temp_lot_no', '', '$datex')";
		$obj->sql($SQL);
		
		$rowz ++;				
	  }
	  
		// asort($cut_size_m);
		
														// asort($size_m);
		
		/*foreach ($size_m as $key => $val)
			{
		echo "$key = $val , \n";
		echo "$key = $cut_size_m[$key] , \n";
		echo "$key = $marker_m[$key] , \n";
		echo "$key = $bundle_ratio_m[$key] , \n";
		echo "$key = $lot_no_m[$key] , \n";
		echo "<br/><br/>";
			 }
			 
		die('<br/><br/><br/>Hello World !!!');*/
		
		

  $cut_size_ck = '';
  $size_main_ck = '';		
  $ttl_cut_pnl = 0;
  $part = 0; // it is for calculating how many part is calculated under this Bundle Print process.
				
  //$marker_array = array('',' - A',' - B',' - C',' - D',' - E',' - F',' - G',' - H',' - I',' - J',' - K',' - L',' - M',' - N',' - O',' - P',' - Q',' - R',' - S',' - T',' - U',' - V',' - W',' - X',' - Y',' - Z');
  
  //$marker_array = array('','-A','-B','-C','-D','-E','-F','-G','-H','-I','-J','-K','-L','-M','-N','-O','-P','-Q','-R','-S','-T','-U','-V','-W','-X','-Y','-Z');

	  foreach($_POST['part_info'] as $part_row=>$part_info)
	  { 
	 
	 $tag_no = 1 ; //Tag No of each Bundle which is continuous for a particular part.
  	 $bndl_end = 0 ; // It is for resetting Start of Bundle Range at the begenning of new Part. // This may has no need as we make it 0 on the begigning of each marker of every size.

	  $part_infom = explode("~", $part_info);
	  $PartName = $part_infom[0];
	  $IsPrint = $part_infom[1];
	 
	  $suffix = 1;
	  foreach ($size_m as $key => $size)
	  { 
		
		$bndl_end = 0 ; // It is for resetting Start of Bundle Range at the begenning of Every Size.// This may has no need as we make it 0 on the begigning of each marker of every size.
		
		$bundle_ratio = $bundle_ratio_m[$key];  // Here the Suffix _m indicates It is the main Array.
		// $size = $size_m[$key];		
		$cut_size = $cut_size_m[$key];
		$marker = $marker_m[$key];
		$lot_no = $lot_no_m[$key];
		
		/*if($cut_size != $cut_size_ck)
		 { 
		$bndl_end = 0 ; // It is for resetting Start of Bundle Range at the begenning of new Size.
		$cut_size_ck = $cut_size;
		 }*/
		
		$mrkr = 1 ;
				  		  		  		
	  while($mrkr <= $marker)
	  {
		  
		$bndl_end = 0 ; // It is for resetting Start of Bundle Range at the begenning of Each Marker of Every Size.
		  
		  $size_main = $size.'-'.$suffix;
		
		  $bundle_no = 1;

		$temp_bndl=explode("+",$bundle_ratio);	// the Bundle Ration is divided here by + Sign.

			foreach($temp_bndl as $value=>$bundle_1) // Here $bundle_1 is a group of bundle located in $bundle_ratio.
			{
					$temp_bndl_1 = explode(".", $bundle_1);
					
						$bundle_qtym = trim($temp_bndl_1[0]);
						$bundle_qty = $bundle_qtym-1;
						
						$no_of_bundle = trim($temp_bndl_1[1]);
						if($no_of_bundle == '') { $no_of_bundle = 1; }
					
					for($i=1; $i<=$no_of_bundle; $i++)
					{
				  		$bndl_st = $bndl_end+1 ;
						$bndl_end = $bndl_st+$bundle_qty;
						
						$bundle_range = $bndl_st.' - '.$bndl_end ; // Here $bundle_range is to show on Print Paper. 
						$b_qty = ($bndl_end-$bndl_st)+1 ;
				  
				  $SQL = "INSERT INTO `tb_vsfs_bundle_info` (`AutoBundleID`, `CutID`, `BundleNo`, `RollNo`, `PartName`, `Size`, `Suff`, `LotNo`, `BundleRange`, `Qty`, `print_flag`) VALUES ('', '$auto_CutID', '$bundle_no', '$tag_no', '$PartName', '$cut_size', '$size_main', '$lot_no', '$bundle_range', '$b_qty', '$IsPrint')";
				 	//die($SQL);
				  $obj->sql($SQL);
				  
				  $ttl_cut_pnl = $ttl_cut_pnl+$b_qty;
				  
				  if($value == 0 && $i == 1) { $sticker_st = $bndl_st;}
				  
				  $tag_no ++ ;
				  $bundle_no ++;

					}
				
			}// End of each (+) part of bundle_ratio
		
			
			if($part_row == 0 && $size_main_ck != $size_main){
			$SQL_Sticker = "INSERT INTO `tb_vsfs_sticker_info` (`sl`, `CutID`, `SizeMain`, `Size`, `Start`, `End`) VALUES ('', '$auto_CutID', '$cut_size', '$size_main', '$sticker_st', '$bndl_end')"; 
			//$SQL_Sticker = "INSERT INTO `tb_vsfs_sticker_info` (`sl`, `CutID`, `PartName`, `SizeMain`, `Size`, `Start`, `End`) VALUES ('', '$auto_CutID', '$PartName', '$cut_size', '$size_main', '$sticker_st', '$bndl_end')"; 
			$obj->sql($SQL_Sticker);
			// Here Please note that while inserting value through mySql query we put the value within '' -> Which indicates treat it as a String so, in case of numeric value we can ommit it But for arithmetic calculation it is mandatory to ommit it.
			// for example ($bndl_end-$sticker_st+1) OR $bndl_end-$sticker_st+1 --> it is OK, But '($bndl_end-$sticker_st+1)' --> is wrong
							  }
							  
			else if ($part_row == 0 && $size_main_ck == $size_main) {
			$SQL_Sticker = "UPDATE `tb_vsfs_sticker_info` SET `End` = '$bndl_end' WHERE CutID = '$auto_CutID' AND Size = '$size_main'"; 
			$obj->sql($SQL_Sticker);
			}
		  
		   $mrkr ++;
		   $suffix ++;
		   
		  $size_main_ck = $size_main;
		   
	  	  } // For Each Marker
		  
	   } // For Each Size
	   $part ++;
	 } // For Each Parts
	 
	
	
	$ttl_cut_pnl = $ttl_cut_pnl/$part; 
  $ttl_cut_pnl_encode = base64_encode($ttl_cut_pnl);
  
  
  		  $ttl_LOT = '';
		  $SQL_LOT = "SELECT lot_no FROM `tb_vsfs_size_marker` WHERE cut_id = '$auto_CutID' GROUP BY lot_no";
		  $results_LOT = $obj->sql($SQL_LOT);
		  $lot_sl = 1;
		  while($row_LOT = mysql_fetch_array($results_LOT))
		  {
			   if ($lot_sl == 1) {$ttl_LOT = $row_LOT['lot_no'];}
			   else {$ttl_LOT = $ttl_LOT.', '.$row_LOT['lot_no'];}
			   
			   $lot_sl ++;
		  }
	
		$SQL = "UPDATE tb_vsfs_cut_info SET `LotNo` = '$ttl_LOT', Quantity = '$ttl_cut_pnl' WHERE AutoCutID = '$auto_CutID'";
		$obj->sql($SQL);
  
  $encd_CutID = base64_encode($auto_CutID);
  header("location:cutting_input_print1.php?cid=$encd_CutID&ttl=$ttl_cut_pnl_encode");

    } // If the form is posted.
   else
   {
  header("location:index.php?msg='Error!!! Please Log in Again'"); 
  die('Please Log in Again !!!');
   }
		
  
  //$msg = 'The Auto Cut Id is : '.$auto_CutID.' And total Qty is : '.$ttl_cut_pnl ;
  
  
				
  
 ?>