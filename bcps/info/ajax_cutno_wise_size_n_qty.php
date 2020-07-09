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
$CutNo = $idm[3];

//$OrderNo = $idm[3];


?>

<td colspan="10">
    <div style="padding:20px">
        <table>
        <tr>
            <th>Size</th>
            <th>Total Qty</th>
            <th>Balance Qty</th>
            <th>Line Input</th>
        </tr>
        
        <?php
			// $SQL = "SELECT T1.Size FROM tb_vsfs_cut_info T0 LEFT JOIN tb_vsfs_bundle_info T1 ON T1.CutID = T0.AutoCutID WHERE StyleCode = '$style' AND Color = '$color' AND CutNo = '$CutNo' ORDER BY T1.Size ASC";
			
			
			
			
			
		  /*$SQL3 = "SELECT T0.OrderNo, T0.CutNo, T1.SizeMain, SUM(Qty) AS 'row_qty' FROM tb_vsfs_cut_info T0 LEFT JOIN vt_vsfs_sticker_info T1 ON T1.CutID = T0.AutoCutID WHERE entry_date = '$s_cutting_date' AND UnitName = '$UnitName' AND buyer = '$buyer' AND StyleCode = '$StyleCode' AND Color = '$Color' GROUP BY T1.SizeMain, T0.CutNo ORDER BY LENGTH(T1.SizeMain), T1.SizeMain ASC";
		  $result3 = $obj->sql($SQL3);
		  while($row3 = mysql_fetch_array($result3))
			  {
				  $row_qty=$row3['row_qty'];
			  }*/
			
			
			//$SQL = "SELECT T0.OrderNo, T0.CutNo, T1.SizeMain, SUM(Qty) AS 'row_qty' FROM tb_vsfs_cut_info T0 LEFT JOIN vt_vsfs_sticker_info T1 ON T1.CutID = T0.AutoCutID WHERE entry_date = '$s_cutting_date' AND UnitName = '$UnitName' AND buyer = '$buyer' AND StyleCode = '$StyleCode' AND Color = '$Color' GROUP BY T1.SizeMain, T0.CutNo ORDER BY LENGTH(T1.SizeMain), T1.SizeMain ASC";
			
			
			$cnt = 0;
			//$SQL = "SELECT T0.SizeMain, SUM(T0.Qty) AS 'size_ttl' FROM vt_vsfs_sticker_info T0 LEFT JOIN tb_vsfs_cut_info T1 ON T1.AutoCutID = T0.CutID WHERE T1.StyleCode = '$style' AND T1.Color = '$color' AND T1.CutNo = '$CutNo' AND T1.OrderNo = '$OrderNo' GROUP BY T0.SizeMain ORDER BY T0.sl ASC";
			$SQL = "SELECT T0.SizeMain, SUM(T0.Qty) AS 'size_ttl' FROM vt_vsfs_sticker_info T0 LEFT JOIN tb_vsfs_cut_info T1 ON T1.AutoCutID = T0.CutID WHERE T1.StyleCode = '$style' AND T1.Color = '$color' AND T1.CutNo = '$CutNo' GROUP BY T0.SizeMain ORDER BY T0.sl ASC";
			//die($SQL);
			
			$obj->sql($SQL);
			while($row = mysql_fetch_array($obj->result))
			  { 
			  $SizeMain[$cnt] = $row['SizeMain'];
			  $size_ttl[$cnt] = $row['size_ttl'];
			  $cnt ++;
			  }
				
				
				foreach ($SizeMain as $rowz=>$size_m)
				{
				
				$ttl_input = 0; 
				$SQLA = "SELECT IFNULL(sum(T0.input_qty), 0) AS 'ttl_input' FROM tb_vsfs_line_input_qty T0 LEFT JOIN tb_vsfs_line_input T1 ON T1.track_id = T0.track_id WHERE T1.StyleCode = '$style' AND T1.Color = '$color' AND T1.CutNo = '$CutNo' AND T0.size = '$size_m'";
				//die($SQLA);
				
				$resultsA = $obj->sql($SQLA);
				while($rowA = mysql_fetch_array($resultsA))
				{
				$ttl_input = $rowA['ttl_input'];	
				}
				
				$balance = $size_ttl[$rowz]-$ttl_input;
				


				/*$SQLA = "SELECT track_id from tb_vsfs_line_input where sl = 1";
				$resultsA = $obj->sql($SQLA);
				while($rowA = mysql_fetch_array($resultsA))
				{
				$ttl_input = $rowA['track_id'];	
				}*/
			
		?>

        <tr>
            <td><?php echo $size_m; ?><input name="size[]" type="hidden" value="<?php echo $size_m; ?>" /></td>
            <td><?php echo $size_ttl[$rowz]; ?><input name="size_ttl[]" type="hidden" value="<?php echo $size_ttl[$rowz]; ?>" /></td>
            <td style="color:#0F9; font-weight:bold"><?php echo $balance; ?></td>
            <td><input name="input_qty[]" type="number" tabindex="6" autofocus="autofocus" size="15px" min="1" max="<?php echo $balance; ?>"  onClick="this.select();" class="form-control" /></td>                
        </tr>

		<?php 
			  }
		?>
        
        <!--<tr>
            <td>S<input name="size" type="hidden" value="S" /></td>
            <td>200</td>
            <td>150</td>
            <td><input name="input_qty" type="text" size="15px" placeholder="Line Input" class="form-control" /></td>                
        </tr>-->
        
        <?php ?>
    </table> 
    </div>
    <div style="padding-left:114px; padding-bottom:20px">
        <input name="submit" type="submit" class="btn btn-success" tabindex="8" id="submit" value="Save" />
          &nbsp;
        <input name="input" type="reset" class="btn btn-danger" tabindex="9" value="Reset" />
    </div>        
</td> 

<?php } ?>