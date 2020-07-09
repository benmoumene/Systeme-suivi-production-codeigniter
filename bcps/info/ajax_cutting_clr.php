<!--This Script id same as info_clr except url: "info/ajax_cutting_clr.php"
This is required as in ajax_clr data comes from tb_vsfs_color_info BUT While searching Already Cut Panels Data
I need to search from tb_vsfs_cut_info.-->

<?php
include "../db_Class.php";
$obj = new db_class();
$obj->MySQL();
?>


<?php

if($_POST['dis'])
{
$id=$_POST['dis'];

echo '<option style="color:#000" selected="selected" value="">-Select Color-</option>';

		$SQL2="select Color from tb_vsfs_cut_info where StyleCode ='$id' Group By Color order by Color ASC";
		
		$obj->sql($SQL2);

		while($row2 = mysql_fetch_array($obj->result))
		  { 
		  $data=$row2['Color'];
		  echo '<option style="color:#000" value="'.$data.'">'.$data.'</option>';
		  }
}
?>