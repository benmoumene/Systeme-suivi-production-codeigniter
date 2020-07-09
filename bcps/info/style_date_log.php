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

<span style="font-size:15px; font-weight:bold; color:#0FF">Create Date Log &#10137;</span>
<table class="bottomBorder2" border="1" width="300px">
    <tr bgcolor="#DDDDDD">
    	<th>Unit</th>
        <th>Color</th>
        <th>Cut No</th>
        <th>Cut Date</th>
        <th>Qty</th>
    </tr>
    
    <?php
		$sum_ttl_qty = 0;
		$SQL2="SELECT CutNo, entry_date, SUM(Quantity) AS 'ttl_qty' FROM `tb_vsfs_cut_info` WHERE StyleCode ='$StyleCode' AND Color = '$Color' AND UnitName = '$Unit' GROUP BY CutNo, entry_date order by AutoCutID ASC";
		$result2 = $obj->sql($SQL2);
		while($row2 = mysql_fetch_array($result2))
		  { 
		  /*$CutNo=$row2['CutNo'];
		  $entry_date=$row2['entry_date'];*/
		  $ttl_qty=$row2['ttl_qty'];
		  
		$sum_ttl_qty = $sum_ttl_qty+$ttl_qty;
			
			?>
    <tr>
    	<td><?php echo $Unit; ?></td>
        <td><?php echo $Color; ?></td>
        <td><?php echo $row2['CutNo']; ?></td>
        <td><?php echo $row2['entry_date']; ?></td>
        <td><?php echo $ttl_qty; ?></td>
    </tr>
        <?php } ?>
    <tr><td colspan="5" style="text-align:right"><span style="margin-right:10px"><strong><?php echo $sum_ttl_qty; ?></strong></span></td></tr>
</table>
