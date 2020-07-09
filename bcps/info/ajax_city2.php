<?php
include "../db_Class.php";
$obj = new db_class();
$obj->MySQL();
?>

      <script type="text/javascript">
	  
	  $(document).ready(function() {
         $('#selecctall2').click(function(event) {  //on click 
             if(this.checked) { // check select status
                 $('.checkbox2').each(function() { //loop through each checkbox
                     this.checked = true;  //select all checkboxes with class "checkbox1"               
                 });
             }else{
                 $('.checkbox2').each(function() { //loop through each checkbox
                     this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                 });         
             }
         });
      });
	  
   </script>

   <table class="bottomBorder" style="box-shadow:0px 0px 0px 0px #FFF ; margin-left:10px" border="1">
    <tr>
        <th><label style="font-weight:bold" title="Click to Select All"><input type="checkbox" id="selecctall2" checked /></label></th>
        <th>Part Name</th>
        <th>Print Status</th>
    </tr>

<?php

if($_POST['dis'])
{
$idm=$_POST['dis'];
$idm = explode("~", $idm);
$id = $idm[0];

 
          $SQL2="SELECT PartName, IsPrint FROM tb_vsfs_part_info WHERE StyleCode = '$id' ORDER BY PartInfoID ASC";    //table name
		  $result2 = $obj->sql($SQL2);
		  while($row2 = mysql_fetch_array($result2)) // Be careful $row1 can't repalce inside tis loop.
		  { ?>
          <tr>
              <td><input name="part_info[]" type="checkbox" value="<?php echo $row2['PartName'].'~'.$row2['IsPrint'] ; ?>" checked class="checkbox2" />
              </td>
              <td><?php echo $row2['PartName']; ?></td>
              <td>
              <?php if($row2['IsPrint'] == 1) echo '<span style="color:#0F9; font-weight:bold; font-size:15px">Yes</span>'; else echo 'No'; ?>
              </td>
          </tr>
	<?php }
}

?> 
</table>     
