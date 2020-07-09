  <?php 
 	include "../db_Class.php";
  	$obj = new db_class();
	$obj->MySQL(); 	

		$date=$_GET['DATE'] ;
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
      Google Visualization API Sample
    </title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Line', 'Actual',{ role: 'annotation' }, 'Target',{ role: 'annotation' }],


		   <?php 		 


$SQL="SELECT floor,unit, SUM( target ) as t , SUM( actual ) as a, date 
FROM  `vt_h_production` 
WHERE date like '$date' GROUP BY  `floor`,Unit order by LENGTH( unit ) , unit ASC";    //table name

	$results = $obj->sql($SQL);
	while($row = mysql_fetch_array($results))
	{
	$line=$row['floor'].'-'.$row['unit'];

	$t=round($row['t']);
	$a=$row['a'];
	
	 
	

echo "['$line',$a,'$a',$t,'$t'],";

//,$t1,$t2   

	}
  ?> 
		//  ['Work', 11]
        ]);
		
		
		var options = {
         title:'Line Wise Daily Production On <?php echo $date ; ?>',
          vAxis: {title: "Production"},
          hAxis: {title: "Floor"},
		  colors:['#004411','#dc1212'],
     //     seriesType: "bars",
     //     series: {1: {type: "line"}}
        };
     var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
		
		
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
    
  </head>
  <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="font-family: Arial;border: 0 none;">
   <div id="chart_div" style="width: 1200px; height: 310px; left:-25px"></div>
  </body>
</html>