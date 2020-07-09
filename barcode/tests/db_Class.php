<?php


//this section for database backup
$DBhos = 'localhost';
$DBuse = 'root';
$DBpas = '';
$DBNam = 'ecofab_hpts_db';
//this section for database backup


class db_class
{
	//MyQql Property
	var $conn;
	var $result;
################################   DO NOT CHANGE   #################################
									//MySql Method
									
	//Connect the Server
	
	
	// immibdc_train with password tranning123

function MySQL($host="localhost", $user="root", $pass="",$bd="ecofab_hpts_db")
	//function MySQL($host, $user, $pass,$bd)
	{
		
		$this->conn = mysql_connect($host,$user,$pass) or die(mysql_error()) 
				or die('Could not connect: ' . mysql_error());
				
		$this->select_db($bd);
	}
	
	//Connect to badabase
	function select_db($bd)
	{
				$db=mysql_select_db($bd,$this->conn) or die(mysql_error())
						or die('Could not connect to '. $bd .' ' . mysql_error());
	}
	
	//Generate Querey
	function sql($SQL)
	{

		$this->result = mysql_query($SQL)
					or die('SQL Error<br>' .$SQL.' '. mysql_error());
					
		return $this->result;
		
	}

}
?>