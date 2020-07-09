<?php
include "../db_Class.php";
//$search = $HTTP_POST_VARS['search'];
$obj = new db_class();
$obj->MySQL();

?>


<?php

if($_POST['dis'])
{

//$id=$_POST['dis'];

$style=$_POST['dis'];


echo '<option style="color:#000" selected="selected" value="">-Select Color-</option>';

		$SQL2="select Color from tb_vsfs_color_info where StyleCode = '$style' Group By Color order by Color ASC";
		
		//die($SQL2);
		//echo '<option style="color:#000" selected="selected" value="">'.$SQL2.'</option>';
	
		$results2 = $obj->sql($SQL2);
		while($row2 = mysql_fetch_array($results2))
		{
			//$data=$row2['StyleCode'].'~'.$row2['Color'];
			$data1=$row2['Color'];
			echo '<option style="color:#000" value="'.$data1.'">'.$data1.'</option>';
		}
		

/*
$SQL2="select * from tb_size_set group by concern_name order by LENGTH( concern_name ) , concern_name ASC";
		$obj->sql($SQL2);

		while($row2 = mysql_fetch_array($obj->result))
				{ 


$data=$row2['concern_name'];


echo '<option value="'.$data.'">'.$data.'</option>';
}

*/



}
?>