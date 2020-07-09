<script type="info/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
$("#style").change(function()
{
var dis=$(this).val();
var dataString = 'dis='+ dis;

$.ajax
({
type: "POST",
url: "info/ajax_city.php",
data: dataString,
cache: false,
success: function(html)
{
$("#color").html(html);
} 
});




$.ajax
({
type: "POST",
url: "info/ajax_city1.php",
data: dataString,
cache: false,
success: function(html)
{
$("#size_table").html(html);
} 
});


$.ajax
({
type: "POST",
url: "info/ajax_city2.php",
data: dataString,
cache: false,
success: function(html)
{
$("#part_table").html(html);
} 
});



});
});
</script>

<!--<script type="text/javascript">
$(document).ready(function()
{
$(".city").change(function()
{
var problem=$(this).val();
var dataString = 'problem='+ problem;


$.ajax
({
type: "POST",
url: "info/ajax_city1.php",
data: dataString,
cache: false,
success: function(html)
{
$(".city1").html(html);
} 
});
});
});
</script>-->