<?php
include "../db_Class.php";
//$search = $HTTP_POST_VARS['search'];
$obj = new db_class();
$obj->MySQL();

?>


<?php

if($_POST['ID'])
{
$idm=$_POST['ID'];
$idm = explode("~", $idm);
$StyleCode = $idm[0];
$Color = $idm[1];
$Unit = $idm[2];
}
?>

<span style="font-size:15px; font-weight:bold; color:#0FF">Size wise Break Down &#10137;</span>
<table class="bottomBorder2" border="1" width="300px">
    <tr bgcolor="#DDDDDD">
    	<th>Unit</th>
        <th>Color</th>
        <th>Size</th>
        <th>Qty</th>
    </tr>
    
    <?php
		  $ttl_qty = 0;
		  
       $SQL2 = "SELECT T0.SizeMain, SUM(T0.Qty) AS 'row_qty' FROM vt_vsfs_sticker_info T0 LEFT JOIN tb_vsfs_cut_info T1 ON T1.AutoCutID = T0.CutID WHERE T1.StyleCode = '$StyleCode' AND T1.Color = '$Color' AND T1.UnitName = '$Unit' GROUP BY T0.SizeMain ORDER BY LENGTH(T0.SizeMain), T0.SizeMain ASC";
		  
		// $SQL2="SELECT T0.size FROM `tb_vsfs_bundle_info` T0 LEFT JOIN tb_vsfs_cut_info T1 ON T1.AutoCutID = T0.CutID WHERE T1.StyleCode = '$StyleCode' AND T1.Color = '$Color' GROUP  BY T0.size";
		$result2 = $obj->sql($SQL2);
		while($row2 = mysql_fetch_array($result2))
		  { 
		  $row_qty=$row2['row_qty'];
		  $ttl_qty = $ttl_qty+$row_qty;
			
			?>
    <tr>
    	<td><?php echo $Unit; ?></td>
        <td><?php echo $Color; ?></td>
        <td><?php echo $row2['SizeMain']; ?></td>
        <td><?php echo $row_qty; ?></td>
    </tr>
        <?php } ?>
    <tr><td colspan="4" style="text-align:right"><span style="margin-right:10px"><strong><?php echo $ttl_qty; ?></strong></span></td></tr>
</table>
