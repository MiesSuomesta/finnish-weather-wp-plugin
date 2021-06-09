<?php

	/* MYSQL stuff */
	function weather_get_weather_info_table_name()
	{
		return $GLOBALS['mysql_weatherinfotable'];
	}

	function weather_do_mysql_query($query)
	{
		$q = $query . ';';

		$mysqli = new mysqli(	$GLOBALS['mysql_hostname'],
								$GLOBALS['mysql_username'],
								$GLOBALS['mysql_password'],
								$GLOBALS['mysql_databasename']);

		// Check connection
		if ($mysqli -> connect_errno) {
			echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
		}

		$result = $mysqli->query($q);

		// Check connection
		if ($mysqli -> connect_errno) {
			echo "Failed to request from MySQL: " . $mysqli -> connect_error;
			exit();
		}

		
		$mysqli->close();

	//	print_r($result);
		return $result;
	}

	function weather_get_mysql_data_last_record_number()
	{
		$q = "select max(recordnro) from " . weather_get_weather_info_table_name();	

		$result = weather_do_mysql_query($q);

		$row = $result->fetch_row();
		$res = 0;
		
		if ($row)
			$res = $row[0];

		$result -> free();
		
		return $res;
	}

	function weather_get_mysql_record_number_datas($rnro, $orderby = "")
	{
		$q = "select * from " . weather_get_weather_info_table_name();
		$q = $q . " where recordnro = " . $rnro;	
		
		if ($orderby != "")
			$q = $q . " order by $orderby ";

		$result = weather_do_mysql_query($q);

		$rows = array();

		while ($row = $result->fetch_row())
		{
			$rows[] = $row;
		}

		$result -> free();
		
		return $rows;
	}

	function weather_init_mysql_memory_tables()
	{
		$q = "create table selections (rnro INT, stationIndex INT) ENGINE = MEMORY;";

		$result = weather_do_mysql_query($q);

		$result -> free();
		
		return $rows;
	}

	function weather_get_mysql_memory_table_rnro($rnro)
	{
		$q = "select * from selections ";
		$q = $q . " where rnro = " . $rnro;	

		$result = weather_do_mysql_query($q);

		$rows = array();

		while ($row = $result->fetch_row())
		{
			$rows[] = $row[$field];
		}

		$result -> free();
		
		return $rows;
	}

	function __set_mysql_memory_table_rnro($rnro, $selID)
	{
		$q = "insert into selections (rnro, stationIndex) VALUES($rnro, $selID);";

		$result = weather_do_mysql_query($q);
		
	}

	function weather_get_mysql_memory_table_rnro($rnro)
	{
		$q = "select * from selections where rnro = $rnro;";

		$result = weather_do_mysql_query($q);

		$rows = array();

		while ($row = $result->fetch_row())
		{
			$rows[] = $row;
		}

		$result -> free();

		return $rows;
	}	

	function weather_get_mysql_memory_table_latest_rnro()
	{
		$q = "select max(rnro) from selections;";

		$result = weather_do_mysql_query($q);

		$row = $result->fetch_row();
		$res = 0;
		
		if ($row)
			$res = $row[0];

		$result -> free();
		
		return $res;
	}	

	function weather_set_mysql_memory_table_rnro($rnro, $selArray)
	{
		foreach ($selArray as $slct) {
			__set_mysql_memory_table_rnro($rnro, $slct);
		}
	}

	function weather_get_mysql_record_number_field($rnro, $orderby = "")
	{
		$q = "select * from " . weather_get_weather_info_table_name();
		$q = $q . " where recordnro = " . $rnro;	
		
		if ($orderby != "")
			$q = $q . " order by $orderby ";
		
 
		$result = weather_do_mysql_query($q);

		$rows = array();

		while ($row = $result->fetch_row())
		{
			$rows[] = $row[$field];
		}

		$result -> free();
		
		return $rows;
	}

?>
