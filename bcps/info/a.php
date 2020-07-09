<?php
include "../db_Class.php";
//$search = $HTTP_POST_VARS['search'];
$obj = new db_class();
$obj->MySQL();

?>



<script type="jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$(".country").change(function()
{
var dis=$(this).val();
var dataString = 'dis='+ dis;

$.ajax
({
type: "POST",
url: "ajax_city.php",
data: dataString,
cache: false,
success: function(html)
{
$(".city").html(html);
} 
});

});

});
</script>
//HTML Code
Country :
<select name="district" class="country" id="district">
<option selected="selected">--Select Country--</option>
<?php

$SQL="select * from tb_dis_thana group by dis";
		$obj->sql($SQL);

		while($row = mysql_fetch_array($obj->result))
				{ 
				

$dis=$row['dis'];
echo '<option value="'.$dis.'">'.$dis.'</option>';
} ?>
</select> <br/><br/>

City :
<select name="thana" class="city" id="thana">
<option selected="selected">--Select City--</option>
</select>