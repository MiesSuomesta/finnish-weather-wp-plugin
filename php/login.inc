<?php
 
	$mysql_hostname         = "";
	$mysql_databasename     = "";
	$mysql_databasetable    = "";
	$mysql_username         = "";
	$mysql_password         = "";


	function create_db_config($fname, $config, $verbose = 0)
	{
		$jsonstr = json_encode($config, JSON_PRETTY_PRINT);
		
		if (! file_exists($fname) )
		{
			if ($verbose != 0)
				echo "<br>Putting JSON to file $fname .....";
			$rv = file_put_contents($fname, $jsonstr);
			if ($verbose != 0)
				echo "<br>Putting JSON to file $fname .....RV: " . (($rv) ? "OK" : "NOK");
		}
		
		if ($verbose != 0)
		{
			echo "<pre>";
			echo "DB Configuration:\n</br>";
			echo $jsonstr;
			echo "</pre>";
		}
		
	}

	function load_db_config($fname, $verbose = 0)
	{

		global $mysql_hostname;
		global $mysql_databasename;
		global $mysql_databasetable;
		global $mysql_username;
		global $mysql_password;
		
   		$jsonstr = "";
		
		if ( file_exists($fname) )
		{
			if ($verbose)
				echo "<br>Parsing DB config ..........";
			
			$jsonstr = file_get_contents($fname);

			if ($verbose)
				echo "<br>Parsed DB config..";
		}

		$config = json_decode($jsonstr, true);
		
		if ($config != null) {
		
			$mysql_hostname 		= $config['mysql']['$hostname'];
			$mysql_databasename		= $config['mysql']['$databasename'];
			$mysql_databasetable	= $config['mysql']['$databasetable'];
			$mysql_username			= $config['mysql']['$username'];
			$mysql_password			= $config['mysql']['$password'];

		}
		
		$h = $GLOBALS['mysql_hostname'];
		$u = $GLOBALS['mysql_username'];
		$p = $GLOBALS['mysql_password'];
		$dbn = $GLOBALS['mysql_databasename'];
		$dbt = $GLOBALS['mysql_databasetable'];

		if ($verbose)
		{
			echo "<br>Got MySQL config ${u}@${h}/${dbn} . ${dbt}";
		}
		return $config;
	}

?>
