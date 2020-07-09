<?php 

	include "db_Class.php";
	$obj = new db_class();
	$obj->MySQL();
	
	
	// die('Hello This is Liza !!!');
	
		$date = new DateTime(null, new DateTimeZone('ASIA/Dhaka'));
		$date->modify('-3600 seconds');
		$date=$date->format("m-d-Y");
		// $datex=$datex->format("d-m-Y H:i:s");
		//$print_date = date('l, j-F-Y');
		
		$print_date = date('j-M-Y');
		
		
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sticker Sheet Print</title>
	
	<style type="text/css">
    table.bottomBorder { border-collapse:collapse; padding:1px }
    table.bottomBorder td, table.bottomBorder th { border-bottom:1px dotted black;
	text-align:left;
    font-size:16px;
    font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
	padding:5px;
    }
    table.bottomBorder tr, table.bottomBorder tr { border:1px dotted black; }
	
	
    table.bottomBorder2 td, table.bottomBorder2 th {
    font-size:16px;
    }
	
    </style> 
       
</head>

<body>

<?php
	
	$decd_CutID=$_POST['cid'];
	

	$marker_size_array=array('');
	$k = 0;
	 
	  
	$SQL2 = "SELECT size_main FROM tb_vsfs_size_marker WHERE cut_id = '$decd_CutID' ORDER BY sl ASC";
	$results2 = $obj->sql($SQL2);
	while($row2 = mysql_fetch_array($results2))
	{ 
		$fetch_size = $row2['size_main'];
		$search = '';
		
		if (in_array($fetch_size, $marker_size_array, TRUE))
		{ $search = $fetch_size; }
		
		if($search == '')
		{
		$marker_size_array[$k] = $fetch_size;
		$k ++;
		}
	}
	



	
	
	
	
	$cnt = 1;
	foreach($_POST['size_info'] as $rowz=>$s_info)
	{ $size_info[$cnt] = $s_info ; $cnt = $cnt+1 ; }
	  
	$size_infom = '';
	for($i = 1; $i < $cnt; $i++)
	{
	  if($i == $cnt-1) { $size_infom .= "'".$size_info[$i]."'" ; }
	  else { $size_infom .= "'".$size_info[$i]."', " ; }  
	}
	
	
	
	  
	  
	$SQL = "SELECT * FROM tb_vsfs_cut_info WHERE AutoCutID = '$decd_CutID'";
	$results = $obj->sql($SQL);
	while($row = mysql_fetch_array($results))
	{ 
		$buyer = $row['buyer'];
		$StyleCode = $row['StyleCode'];
		$Color = $row['Color'];
		$CutNo = $row['CutNo'];
		$OrderNo = $row['OrderNo'];
		$LotNo = $row['LotNo'];
		$Lay = $row['Lay'];
		$Quantity = $row['Quantity'];
	}
	
	  ?>
 
 <br/><br/>
<div align="center" style="width:300px">

	<div style="width:250px; margin-left:5px">
    	<!--<table class="bottomBorder" border="1" cellpadding="5px">-->
    	<table class="bottomBorder2" cellpadding="2px">
        	<tr><th style="text-align:left;">Auto CutID:</th><td><?php echo $decd_CutID; ?></td></tr>
        	<tr><th style="text-align:left; font-family:'Comic Sans MS', cursive">Style:</th><td style="font-family:'Comic Sans MS', cursive"><?php echo $StyleCode.' ('.$buyer.' )'; ?></td></tr>
        	<tr><th style="text-align:left; font-family:'Comic Sans MS', cursive">Cut No:</th><td style="font-family:'Comic Sans MS', cursive"><?php echo $CutNo; ?></td></tr>
        	<tr><th style="text-align:left; font-family:'Comic Sans MS', cursive">Color:</th><td style="font-family:'Comic Sans MS', cursive"><?php echo $Color; ?></td></tr>
        	<tr><th style="text-align:left; font-family:'Comic Sans MS', cursive">Lot:</th><td style="font-family:'Comic Sans MS', cursive"><?php echo $LotNo; ?></td></tr>
        	<tr><th style="text-align:left; font-family:'Comic Sans MS', cursive">Lay:</th><td style="font-family:'Comic Sans MS', cursive"><?php echo $Lay; ?></td></tr>
        	<tr><th style="text-align:left; font-family:'Comic Sans MS', cursive"><span style="margin-right:30px">Quantity:</span></th><td style="font-family:'Comic Sans MS', cursive"><?php echo $Quantity; ?></td></tr>
        </table>
    </div>
    
    <div>
    <br/><br/>
    	<table class="bottomBorder" border="1">
            <tr>
                <th>SL</th>
                <th><span style="margin-right:20px">Size</span></th>
                <th><span style="margin-right:5px">Start</span></th>
                <th>End</th>
                <th>Quantity</th>
            </tr>
 <?php
	  
	/*$SQL2 = "SELECT size_main FROM tb_vsfs_size_marker WHERE cut_id = '$decd_CutID' GROUP BY size_main ORDER BY sl ASC";
	$results2 = $obj->sql($SQL2);
	while($row2 = mysql_fetch_array($results2))
	{ $marker_size_array[] = $row2['size_main']; }*/
	

	$SQL1 = "SELECT Size FROM tb_vsfs_bundle_info WHERE CutID = '$decd_CutID' AND Suff IN (".$size_infom.") GROUP BY Size";	
	$results1 = $obj->sql($SQL1);
	while($row1 = mysql_fetch_array($results1))
	{ $bundle_size_array[] = $row1['Size']; }
	
	
	
	$res_arr = array(); 
	for ($i = 0; $i < count($marker_size_array); $i++) {
		 for ($j = 0; $j < count($bundle_size_array); $j++) {
			  if($bundle_size_array[$j] == $marker_size_array[$i]) {
				 $res_arr[] = $bundle_size_array[$j];
				 break;
			  }
		 }
	}
	
	// $res_array is your sorted array now
	
	
	/*foreach ($marker_size_array as $key => $val)
			{
		echo "$key = $val , \n";
		echo "<br/><br/>";
			 }
			 
		echo '====================';	 
		echo "<br/><br/>";

	foreach ($bundle_size_array as $key => $val)
			{
		echo "$key = $val , \n";
		echo "<br/><br/>";
			 }
			 
		echo '====================';	 
		echo "<br/><br/>";

	foreach ($res_arr as $key => $val)
			{
		echo "$key = $val , \n";
		echo "<br/><br/>";
			 }
			 
		die('<br/><br/><br/>Hello World !!!');*/
	
	
	
	$srl = 1;
	
	foreach ($res_arr as $key => $val)
		{
	
			$SQL1 = "SELECT * FROM vt_vsfs_sticker_info WHERE CutID = '$decd_CutID' AND Size LIKE '$val%' ORDER BY sl ASC";
			$results1 = $obj->sql($SQL1);
			$num_rows=mysql_num_rows($results1);
			while($row1 = mysql_fetch_array($results1))
			{ 
			?>
			
			<tr>
				<td style="text-align:center"><?php echo $srl; ?></td>
				<td><strong><?php echo $row1['Size']; ?></strong></td>
				<td><strong><?php echo $row1['Start']; ?></strong></td>
				<td><?php echo $row1['End']; ?></td>
				<td style="text-align:center"><?php echo $row1['Qty']; ?></td>
			</tr>
			
			<?php
			$srl++ ;
			}
	
		}
	
?>
	</table>
	
 </div>   

</div>

</body>
</html>