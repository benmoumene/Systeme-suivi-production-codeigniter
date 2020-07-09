<?php
include "../db_Class.php";
//$search = $HTTP_POST_VARS['search'];
$obj = new db_class();
$obj->MySQL();

?>


<?php

if($_POST['dis'])
{
$id=$_POST['dis'];
$idm=explode("~", $id);
$style = $idm[0];
$color = $idm[1];


echo '<option style="color:#000" selected="selected" value="">-Cut No-</option>';


		$SQL2="select CutNo, Clr_OrderQty, OrderNo from tb_vsfs_cut_info where StyleCode ='$style' AND Color ='$color' order by CutNo ASC";
		// die($SQL2);
		$obj->sql($SQL2);

		while($row2 = mysql_fetch_array($obj->result))
		  { 
		  $data = $style.'~'.$color.'~'.$row2['Clr_OrderQty'].'~'.$row2['CutNo'].'~'.$row2['OrderNo'];
		  $data1=$row2['CutNo'];
		  
		  echo '<option style="color:#000" value="'.$data.'">'.$data1.'</option>';
		  }
}
?>