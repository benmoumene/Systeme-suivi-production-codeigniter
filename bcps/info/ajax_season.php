<?php
include "../db_Class.php";
//$search = $HTTP_POST_VARS['search'];
$obj = new db_class();
$obj->MySQL();

?>


<?php

if($_POST['dis'])
{


$idm=$_POST['dis'];
$id=explode("~", $idm);
$buyer = $id[0];
$style = $id[1];


		echo '<option style="color:#000" selected="selected" value="">-Select-</option>';

		$SQL2="select season from tb_vsfs_cut_info where StyleCode = '$style' AND season != '' GROUP BY season order by sl DESC";
		$results2 = $obj->sql($SQL2);
		while($row2 = mysql_fetch_array($results2))
		{
			$data=$row2['season'];
			echo '<option style="color:#000" value="'.$data.'">'.$data.'</option>';
		}
		
		
		
		$SQL2="select season from tb_vsfs_style where StyleCode = '$style' AND season != ''";
		
		// die($SQL2);
		
		$results2 = $obj->sql($SQL2);
		while($row2 = mysql_fetch_array($results2))
		{
			$data=$row2['season'];
			echo '<option style="color:#000" value="'.$data.'">'.$data.'</option>';
		}
		
		
		
		
}
?>