<?php
include "../db_Class.php";
$obj = new db_class();
$obj->MySQL();

?>

      <script type="text/javascript">

      $(document).ready(function() {
         $('#selecctall').click(function(event) {  //on click 
             if(this.checked) { // check select status
                 $('.checkbox1').each(function() { //loop through each checkbox
                     this.checked = true;  //select all checkboxes with class "checkbox1"               
                 });
             }else{
                 $('.checkbox1').each(function() { //loop through each checkbox
                     this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                 });         
             }
         });
      });
	  
	   
	  
	  $(document).ready(function() {
	  $("#ins_marker").change(function() {
		  var dis=$(this).val();
		  $('.ins_marker_no').each(function() {
			  this.value = dis;
		  });
		  document.getElementById("ins_marker").value = '';
		  });
	  });
	  
						 
	  $(document).ready(function() {
	  $("#ins_bundle_ratio").change(function() {
		  var dis=$(this).val();
		  $('.ins_bundle_range').each(function() {
			  this.value = dis;
		  });
		  document.getElementById("ins_bundle_ratio").value = '';
		  });
	  });
	  
	  
	  
	  $(document).ready(function() {
	  $("#ins_lot").change(function() {
		  var dis=$(this).val();
		  $('.ins_lot_no').each(function() {
			  this.value = dis;
		  });
		  document.getElementById("ins_lot").value = '';
		  });
	  });
	  
	
	  	  
   </script>

    <table class="bottomBorder" id="size_mrkr" style="box-shadow:0px 0px 0px 0px #FFF ;" border="1">
        
         
         
        <tr>
          <th><label title="Click to Select All"><input type="checkbox" id="selecctall" /></label>
          <input name="data0" id="data0" type="hidden" value="<?php echo "<input name='chk' type='checkbox' class='checkbox1' />"; ?>" />
          </th>
          <th>Size<input name="data1" id="data1" type="hidden" value="<?php echo "<input name='size[]' type='text' tabindex='11' onclick='select()' size='8' placeholder='Size' required autofocus />"; ?>" />
          </th>
          <th><input name="data2" id="data2" type="hidden" value="<?php echo "<input name='marker[]' class='ins_marker_no' type='number' value='0' onclick='select()' tabindex='12' size='8' min='0'  placeholder='Marker' required autofocus />"; ?>" />
          <input name="ins_marker" id="ins_marker" type="number" onclick="select()" size="8" min="0" placeholder="Insert Marker" />
          </th>
          <th><input name="data3" id="data3" type="hidden" value="<?php echo "<input name='bundle_ratio[]' class='ins_bundle_range' type='text' onclick='select()' tabindex='13' size='50' placeholder='Bundle Ratio' />"; ?>" />
          <span class="placeholder_color"><input name="ins_bundle_ratio" id="ins_bundle_ratio" type="text" size="44" placeholder="Insert Common Bundle Ratio (If Any)" /></span>
          </th>
          <th><input name="data4" id="data4" type="hidden" value="<?php echo "<input name='lot_no[]' class='ins_lot_no' type='text' onclick='select()' tabindex='14' size='10' placeholder='Lot No' />"; ?>" />
          <span class="placeholder_color"><input name="ins_lot" id="ins_lot" type="text" size="9" placeholder="Insert LotNo" /></span>
          </th>
       </tr>


<?php

if($_POST['dis'])
{
$idm=$_POST['dis'];
$idm = explode("~", $idm);
$id = $idm[0];

	$SQL2="select size from tb_vsfs_size_info where StyleCode ='$id' order by SizeInfoID ASC";
	$result2 = $obj->sql($SQL2);
	while($row2 = mysql_fetch_array($result2))
	  { 
	  $data=$row2['size'];
	  echo '<tr>
          <td><input name="chk" type="checkbox" class="checkbox1" /></td>
          <td><input name="size[]" type="text" value="'.$data.'" tabindex="11" size="8" onclick="select()" placeholder="Size" required autofocus /></td>
          <td><input name="marker[]" class="ins_marker_no" type="number" value="0" onclick="select()" tabindex="12" min="0" size="8" placeholder="Marker" required autofocus /></td>
          <td><input name="bundle_ratio[]" class="ins_bundle_range" type="text" onclick="select()" tabindex="13" size="50" placeholder="Bundle Ratio" /></td>
          <td><input name="lot_no[]" class="ins_lot_no" type="text" tabindex="14" onclick="select()" size="10" placeholder="Lot No" /></td>
			</tr>';
   
	  }
	  
}
?>
</table>
