<?php

	/* common details */
	require_once("master_include.inc");

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
   		$jsonstr = "";
		
		if ( file_exists($fname) )
		{
			if ($verbose > 0)
				echo "<br>Parsing DB config ..........";
			
			$jsonstr = file_get_contents($fname);

			if ($verbose > 0)
				echo "<br>Parsed DB config..";
		}

		$config = json_decode($jsonstr, true);
		
		$h   = "N/A";
		$u   = "N/A";
		$p   = "N/A";
		$dbn = "N/A";
		$dbt = "N/A";

		if ($config != null) {
			$h   = $config['mysql']['hostname'];
			$dbn = $config['mysql']['databasename'];
			$dbt = $config['mysql']['databasetable'];
			$u   = $config['mysql']['username'];
			$p   = $config['mysql']['password'];
		}
		
		if ($verbose > 0)
		{
			echo "<br>login: Loaded MySQL config ${u}@${h}/${dbn}.${dbt}";
			var_dump($FINWEATHER_MYSQL_CONFIG);
		}
		
		return $config['mysql'];
	}

?>
