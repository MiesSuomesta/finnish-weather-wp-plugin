<?php

	/* common details */
	$master_inc_path = dirname(__DIR__);
	require_once($master_inc_path . "/master_include.inc");


	function mysql_config_get()
	{
		$config = load_db_config(get_master_config_file());
		return $config;
	}

	/* MYSQL stuff */
	function weather_get_weather_info_table_name()
	{
		$cnf = mysql_config_get();
		return $cnf['databasetable'];
	}

	function weather_do_mysql_query($query, $verbose = 0)
	{
		$cnf = mysql_config_get();

		$h   = $cnf['hostname'];
		$dbn = $cnf['databasename'];
		$dbt = $cnf['databasetable'];
		$u   = $cnf['username'];
		$p   = $cnf['password'];

		$q = $query . ';';

		if ($verbose > 0)
		{
			echo "<br>MySQL config for query ${u}@${h}/${dbn}.${dbt}";
			echo "<br>MySQL query  $query";
		}


		$mysqli = new mysqli($h, $u, $p, $dbn);

		if ($verbose > 0)
		{
			echo "<br>MySQL ${u}@${h}/${d} => " . (($mysqli != null) ? "OK" : "NOK");
		}

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

//		print_r($result);
		return $result;
	}

	function initialize_tables($config)
	{
		$cnf = mysql_config_get();
		
		var_dump($cnf);

		$dbt = $cnf['databasetable'];
		
		$q_dbtable = "CREATE TABLE IF NOT EXISTS $dbt ( stationid VARCHAR(250), stationname VARCHAR(250), latitude VARCHAR(250), longitude VARCHAR(250), airtempvalue VARCHAR(150), airtempunits VARCHAR(150),  windspeedvalue VARCHAR(150), windspeedunits VARCHAR(150),  winddirectionvalue VARCHAR(150), winddirectionunits VARCHAR(150),  gustspeedvalue VARCHAR(150), gustspeedunits VARCHAR(150),  relhumvalue VARCHAR(150), relhumunits VARCHAR(150),  dewpointvalue VARCHAR(150), dewpointunits VARCHAR(150),  precipitationamountvalue VARCHAR(150), precipitationamountunits VARCHAR(150),  precipitationintensityvalue VARCHAR(150), precipitationintensityunits VARCHAR(150),  snowdepthvalue VARCHAR(150), snowdepthunits VARCHAR(150),  pressurevalue VARCHAR(150), pressureunits VARCHAR(150),  horizvisibvalue VARCHAR(150), horizvisibunits VARCHAR(150),  cloudamountvalue VARCHAR(150), cloudamountunits VARCHAR(150), recordnro VARCHAR(150), recordts TIMESTAMP DEFAULT CURRENT_TIMESTAMP )";

		weather_do_mysql_query($q_dbtable, 1);
		
		
	}

	function weather_get_mysql_data_last_record_number()
	{
		$q = "select max(recordnro) from " . weather_get_weather_info_table_name();	

		$result = weather_do_mysql_query($q);
		$row = false;
		
		if ( is_object($result) )
			$row = $result->fetch_row();
		
		$res = 0;
		
		if ($row) {
			if ( is_object($result) )
				$res = $row[0];
			
		}

		if ( is_object($result) )
			$result -> free();

		return $res;
	}

	function weather_get_mysql_record_number_datas($recordnro, $orderby = "")
	{
		$q = "select * from " . weather_get_weather_info_table_name();
		$q = $q . " where recordnro = " . $recordnro;	
		
		if ($orderby != "")
			$q = $q . " order by $orderby ";

		$result = weather_do_mysql_query($q);

		$rows = array();

		if ( is_object($result) ) {
			while ($row = $result->fetch_row())
			{
				$rows[] = $row;
			}

			$result -> free();
		}
//		print("ROWS -------------------------------------\n");
//		var_dump($rows);

		return $rows;
	}

	function weather_init_mysql_memory_tables()
	{
		$q = "CREATE TABLE IF NOT EXISTS selections (sessionid VARCHAR(30), stationid BIGINT, stationname VARCHAR(250), latitude FLOAT, longitude FLOAT, airtempvalue FLOAT, airtempunits VARCHAR(150),  windspeedvalue FLOAT, windspeedunits VARCHAR(150),  winddirectionvalue FLOAT, winddirectionunits VARCHAR(150),  gustspeedvalue FLOAT, gustspeedunits VARCHAR(150),  relhumvalue FLOAT, relhumunits VARCHAR(150),  dewpointvalue FLOAT, dewpointunits VARCHAR(150),  precipitationamountvalue FLOAT, precipitationamountunits VARCHAR(150),  precipitationintensityvalue FLOAT, precipitationintensityunits VARCHAR(150),  snowdepthvalue FLOAT, snowdepthunits VARCHAR(150),  pressurevalue FLOAT, pressureunits VARCHAR(150),  horizvisibvalue FLOAT, horizvisibunits VARCHAR(150),  cloudamountvalue FLOAT, cloudamountunits VARCHAR(150), recordnro BIGINT, recordts TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE = MEMORY;";

		$result = weather_do_mysql_query($q);

		$rows = array();

		if ( is_object($result) ) {
			while ($row = $result->fetch_row())
			{
				$rows[] = $row;
			}

			$result -> free();
		}
		
		return $rows;
	}

	function weather_create_station_obj($sessionid,$stationid,$stationname,$latitude,$longitude,$airtempvalue,$airtempunits,$windspeedvalue,$windspeedunits,$winddirectionvalue,$winddirectionunits,$gustspeedvalue,$gustspeedunits,$relhumvalue,$relhumunits,$dewpointvalue,$dewpointunits,$precipitationamountvalue,$precipitationamountunits,$precipitationintensityvalue,$precipitationintensityunits,$snowdepthvalue,$snowdepthunits,$pressurevalue,$pressureunits,$horizvisibvalue,$horizvisibunits,$cloudamountvalue,$cloudamountunits,$recordnro,$recordts)
	{
		$station["sessionid"] = $sessionid;
		$station["stationid"]=$stationid;
		$station["stationname"]=$stationname;
		$station["latitude"]=$latitude;
		$station["longitude"]=$longitude;
		$station["airtempvalue"]=$airtempvalue;
		$station["airtempunits"]=$airtempunits;
		$station["windspeedvalue"]=$windspeedvalue;
		$station["windspeedunits"]=$windspeedunits;
		$station["winddirectionvalue"]=$winddirectionvalue;
		$station["winddirectionunits"]=$winddirectionunits;
		$station["gustspeedvalue"]=$gustspeedvalue;
		$station["gustspeedunits"]=$gustspeedunits;
		$station["relhumvalue"]=$relhumvalue;
		$station["relhumunits"]=$relhumunits;
		$station["dewpointvalue"]=$dewpointvalue;
		$station["dewpointunits"]=$dewpointunits;
		$station["precipitationamountvalue"]=$precipitationamountvalue;
		$station["precipitationamountunits"]=$precipitationamountunits;
		$station["precipitationintensityvalue"]=$precipitationintensityvalue;
		$station["precipitationintensityunits"]=$precipitationintensityunits;
		$station["snowdepthvalue"]=$snowdepthvalue;
		$station["snowdepthunits"]=$snowdepthunits;
		$station["pressurevalue"]=$pressurevalue;
		$station["pressureunits"]=$pressureunits;
		$station["horizvisibvalue"]=$horizvisibvalue;
		$station["horizvisibunits"]=$horizvisibunits;
		$station["cloudamountvalue"]=$cloudamountvalue;
		$station["cloudamountunits"]=$cloudamountunits;
		$station["recordnro"]=$recordnro;
		$station["recordts"]=$recordts;

		return $station;
	}

	function __create_quoted($s) { return '"' . $s . '"'; }

	function __create_q_value_string_from_station($station)
	{
		$sessionid = __create_quoted($station["sessionid"]);
		$stationid = __create_quoted($station["stationid"]);
		$stationname = __create_quoted($station["stationname"]);
		$latitude = __create_quoted($station["latitude"]);
		$longitude = __create_quoted($station["longitude"]);
		$airtempvalue = __create_quoted($station["airtempvalue"]);
		$airtempunits = __create_quoted($station["airtempunits"]);
		$windspeedvalue = __create_quoted($station["windspeedvalue"]);
		$windspeedunits = __create_quoted($station["windspeedunits"]);
		$winddirectionvalue = __create_quoted($station["winddirectionvalue"]);
		$winddirectionunits = __create_quoted($station["winddirectionunits"]);
		$gustspeedvalue = __create_quoted($station["gustspeedvalue"]);
		$gustspeedunits = __create_quoted($station["gustspeedunits"]);
		$relhumvalue = __create_quoted($station["relhumvalue"]);
		$relhumunits = __create_quoted($station["relhumunits"]);
		$dewpointvalue = __create_quoted($station["dewpointvalue"]);
		$dewpointunits = __create_quoted($station["dewpointunits"]);
		$precipitationamountvalue = __create_quoted($station["precipitationamountvalue"]);
		$precipitationamountunits = __create_quoted($station["precipitationamountunits"]);
		$precipitationintensityvalue = __create_quoted($station["precipitationintensityvalue"]);
		$precipitationintensityunits = __create_quoted($station["precipitationintensityunits"]);
		$snowdepthvalue = __create_quoted($station["snowdepthvalue"]);
		$snowdepthunits = __create_quoted($station["snowdepthunits"]);
		$pressurevalue = __create_quoted($station["pressurevalue"]);
		$pressureunits = __create_quoted($station["pressureunits"]);
		$horizvisibvalue = __create_quoted($station["horizvisibvalue"]);
		$horizvisibunits = __create_quoted($station["horizvisibunits"]);
		$cloudamountvalue = __create_quoted($station["cloudamountvalue"]);
		$cloudamountunits = __create_quoted($station["cloudamountunits"]);
		$recordnro = __create_quoted($station["recordnro"]);
		$recordts = __create_quoted($station["recordts"]);
		
		return "$sessionid,$stationid,$stationname,$latitude,$longitude,$airtempvalue,$airtempunits,$windspeedvalue,$windspeedunits,$winddirectionvalue,$winddirectionunits,$gustspeedvalue,$gustspeedunits,$relhumvalue,$relhumunits,$dewpointvalue,$dewpointunits,$precipitationamountvalue,$precipitationamountunits,$precipitationintensityvalue,$precipitationintensityunits,$snowdepthvalue,$snowdepthunits,$pressurevalue,$pressureunits,$horizvisibvalue,$horizvisibunits,$cloudamountvalue,$cloudamountunits,$recordnro,$recordts";
	}

	function __get_station_from_sql_row($row)
	{
		$arg = 0;
		$obj = weather_create_station_obj($row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++]);
		
		return $obj;
	}
	
	function __create_q_vname_string_from_station($station)
	{
		return "sessionid, stationid, stationname, latitude, longitude, airtempvalue, airtempunits, windspeedvalue, windspeedunits, winddirectionvalue, winddirectionunits, gustspeedvalue, gustspeedunits, relhumvalue, relhumunits, dewpointvalue, dewpointunits, precipitationamountvalue, precipitationamountunits, precipitationintensityvalue, precipitationintensityunits, snowdepthvalue, snowdepthunits, pressurevalue, pressureunits, horizvisibvalue, horizvisibunits, cloudamountvalue, cloudamountunits, recordnro, recordts";
	}
	
	function __set_mysql_memory_table_station($station)
	{
		
		$q_nam = __create_q_vname_string_from_station($station);
		$q_val = __create_q_value_string_from_station($station);
		$q = "insert into selections ($q_nam) VALUES($q_val);";

		$result = weather_do_mysql_query($q);

		return $result;
	}

	function weather_get_mysql_memory_table_recordnro($sessionid)
	{
		$q = "select * from selections where sessionid = $sessionid";

		$result = weather_do_mysql_query($q);

		$rows = array();

		while ($row = $result->fetch_row())
		{
			$rows[] = __get_station_from_sql_row($row);
		}

		$result -> free();

		return $rows;
	}	

	// recordnro, Array of stations
	function weather_set_mysql_memory_table_recordnro($sessionid, $selArray)
	{
		foreach ($selArray as $slct) {
			__set_mysql_memory_table_recordnro($sessionid, $slct);
		}
	}

	function weather_get_mysql_memory_session_records($sessionid)
	{
		$q = "select * from selections";
		$q = $q . " where sessionid = \"" . $sessionid . "\"";	
		
		$result = weather_do_mysql_query($q);

		$row = false;
		$rows = array();
		
		if ( ! is_object($result) ) {
			echo "<!---- Not object ... $result --->";
			return $rows;
		}
		
		while ($row = $result->fetch_row())
			$rows[] = __get_station_from_sql_row($row);

		$result -> free();
		
		return $rows;
	}

?>
