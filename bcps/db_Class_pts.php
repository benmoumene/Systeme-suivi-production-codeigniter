<?php


//this section for database backup
$DBhos_pts = 'localhost';
$DBuse_pts = 'root';
$DBpas_pts = '';
$DBNam_pts = 'efl_db_pts';
//this section for database backup


class db_class_pts
{
	//MyQql Property
	var $conn_pts;
	var $result_pts;
################################   DO NOT CHANGE   #################################
									//MySql Method
									
	//Connect the Server
	
	
	// immibdc_train with password tranning123

function MySQL_pts($host_pts="localhost", $user_pts="root", $pass_pts="",$bd_pts="efl_db_pts")
	//function MySQL($host, $user, $pass,$bd)
	{
		
		$this->conn = mysql_connect($host_pts,$user_pts,$pass_pts) or die(mysql_error())
				or die('Could not connect: ' . mysql_error());
				
		$this->select_db_pts($bd_pts);
	}
	
	//Connect to badabase
	function select_db_pts($bd_pts)
	{
				$db=mysql_select_db($bd_pts,$this->conn) or die(mysql_error())
						or die('Could not connect to '. $bd_pts .' ' . mysql_error());
	}
	
	//Generate Querey
	function sql_pts($SQL_pts)
	{

		$this->result = mysql_query($SQL_pts)
					or die('SQL Error<br>' .$SQL_pts.' '. mysql_error());
					
		return $this->result;
		
	}

}
?>