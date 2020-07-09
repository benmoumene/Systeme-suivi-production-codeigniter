<?php
include "../db_Class.php";
$obj = new db_class();
$obj->MySQL();

?>


<?php

if($_POST['dis'])
{
$id=$_POST['dis'];

	echo '<option style="color:#000" selected="selected" value="">-Select Style-</option>';
	
	$SQL2="select StyleCode from tb_vsfs_cut_info where buyer='$id' order by StyleCode ASC";
	$obj->sql($SQL2);
	
	while($row2 = mysql_fetch_array($obj->result))
	  { 
	  $data=$row2['StyleCode'];
	  echo '<option style="color:#000" value="'.$data.'">'.$data.'</option>';
	  }
}

?>