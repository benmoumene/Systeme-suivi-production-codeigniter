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
$idm = explode("~", $idm);
$id = $idm[0];


echo '<option style="color:#000" selected="selected" value="">-Select Color-</option>';

		$SQL2="select Color, OrderQty from tb_vsfs_color_info where StyleCode ='$id' order by Color ASC";
		$obj->sql($SQL2);

		while($row2 = mysql_fetch_array($obj->result))
		  { 
		  $data=$row2['Color'].'~'.$row2['OrderQty'];
		  $data1=$row2['Color'];
		  echo '<option style="color:#000" value="'.$data.'">'.$data1.'</option>';
		  }

}
?>