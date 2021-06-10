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

	function weather_get_mysql_record_number_datas($recordnro, $orderby = "")
	{
		$q = "select * from " . weather_get_weather_info_table_name();
		$q = $q . " where recordnro = " . $recordnro;	
		
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
		$q = "CREATE TABLE IF NOT EXISTS selections (recordnro BIGINT, stationid BIGINT, stationname VARCHAR(250), latitude FLOAT, longitude FLOAT, airtempvalue FLOAT, airtempunits VARCHAR(150),  windspeedvalue FLOAT, windspeedunits VARCHAR(150),  winddirectionvalue FLOAT, winddirectionunits VARCHAR(150),  gustspeedvalue FLOAT, gustspeedunits VARCHAR(150),  relhumvalue FLOAT, relhumunits VARCHAR(150),  dewpointvalue FLOAT, dewpointunits VARCHAR(150),  precipitationamountvalue FLOAT, precipitationamountunits VARCHAR(150),  precipitationintensityvalue FLOAT, precipitationintensityunits VARCHAR(150),  snowdepthvalue FLOAT, snowdepthunits VARCHAR(150),  pressurevalue FLOAT, pressureunits VARCHAR(150),  horizvisibvalue FLOAT, horizvisibunits VARCHAR(150),  cloudamountvalue FLOAT, cloudamountunits VARCHAR(150), recordnro BIGINT, recordts TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE = MEMORY;";

		$result = weather_do_mysql_query($q);

		$result -> free();
		
		return $rows;
	}

	function weather_create_station_obj($stationid,$stationname,$latitude,$longitude,$airtempvalue,$airtempunits,$windspeedvalue,$windspeedunits,$winddirectionvalue,$winddirectionunits,$gustspeedvalue,$gustspeedunits,$relhumvalue,$relhumunits,$dewpointvalue,$dewpointunits,$precipitationamountvalue,$precipitationamountunits,$precipitationintensityvalue,$precipitationintensityunits,$snowdepthvalue,$snowdepthunits,$pressurevalue,$pressureunits,$horizvisibvalue,$horizvisibunits,$cloudamountvalue,$cloudamountunits,$recordnro)
	{
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

		return $station;
	}

	function __create_q_value_string_from_station($station)
	{
		$stationid = $station["stationid"];
		$stationname = $station["stationname"];
		$latitude = $station["latitude"];
		$longitude = $station["longitude"];
		$airtempvalue = $station["airtempvalue"];
		$airtempunits = $station["airtempunits"];
		$windspeedvalue = $station["windspeedvalue"];
		$windspeedunits = $station["windspeedunits"];
		$winddirectionvalue = $station["winddirectionvalue"];
		$winddirectionunits = $station["winddirectionunits"];
		$gustspeedvalue = $station["gustspeedvalue"];
		$gustspeedunits = $station["gustspeedunits"];
		$relhumvalue = $station["relhumvalue"];
		$relhumunits = $station["relhumunits"];
		$dewpointvalue = $station["dewpointvalue"];
		$dewpointunits = $station["dewpointunits"];
		$precipitationamountvalue = $station["precipitationamountvalue"];
		$precipitationamountunits = $station["precipitationamountunits"];
		$precipitationintensityvalue = $station["precipitationintensityvalue"];
		$precipitationintensityunits = $station["precipitationintensityunits"];
		$snowdepthvalue = $station["snowdepthvalue"];
		$snowdepthunits = $station["snowdepthunits"];
		$pressurevalue = $station["pressurevalue"];
		$pressureunits = $station["pressureunits"];
		$horizvisibvalue = $station["horizvisibvalue"];
		$horizvisibunits = $station["horizvisibunits"];
		$cloudamountvalue = $station["cloudamountvalue"];
		$cloudamountunits = $station["cloudamountunits"];
		$recordnro = $station["recordnro"];
		
		return "$stationid,$stationname,$latitude,$longitude,$airtempvalue,$airtempunits,$windspeedvalue,$windspeedunits,$winddirectionvalue,$winddirectionunits,$gustspeedvalue,$gustspeedunits,$relhumvalue,$relhumunits,$dewpointvalue,$dewpointunits,$precipitationamountvalue,$precipitationamountunits,$precipitationintensityvalue,$precipitationintensityunits,$snowdepthvalue,$snowdepthunits,$pressurevalue,$pressureunits,$horizvisibvalue,$horizvisibunits,$cloudamountvalue,$cloudamountunits,$recordnro";
	}

	function __get_station_from_sql_row($row)
	{
		$arg = 0;
		$obj = weather_create_station_obj($row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++], $row[$arg++]);
		
		return $obj;
	}
	
	function __create_q_vname_string_from_station($station)
	{
		return " stationid, stationname, latitude, longitude, airtempvalue, airtempunits, windspeedvalue, windspeedunits, winddirectionvalue, winddirectionunits, gustspeedvalue, gustspeedunits, relhumvalue, relhumunits, dewpointvalue, dewpointunits, precipitationamountvalue, precipitationamountunits, precipitationintensityvalue, precipitationintensityunits, snowdepthvalue, snowdepthunits, pressurevalue, pressureunits, horizvisibvalue, horizvisibunits, cloudamountvalue, cloudamountunits, recordnro";
	}
	
	function __set_mysql_memory_table_station($station)
	{
		
		$q_nam = __create_q_vname_string_from_station($station);
		$q_val = __create_q_value_string_from_station($station);
		$q = "insert into selections ($q_nam) VALUES($q_val);";

		$result = weather_do_mysql_query($q);

		return $result;
	}

	function weather_get_mysql_memory_table_recordnro($recordnro)
	{
		$q = "select * from selections where recordnro = $recordnro";

		$result = weather_do_mysql_query($q);

		$rows = array();

		while ($row = $result->fetch_row())
		{
			$rows[] = __get_station_from_sql_row($row);
		}

		$result -> free();

		return $rows;
	}	

	function weather_get_mysql_memory_table_latest_recordnro()
	{
		$q = "select max(recordnro) from selections";

		$result = weather_do_mysql_query($q);

		$row = $result->fetch_row();
		$res = 0;
		
		if ($row)
			$res = $row[0];

		$result -> free();
		
		return $res;
	}	

	// recordnro, Array of stations
	function weather_set_mysql_memory_table_recordnro($recordnro, $selArray)
	{
		foreach ($selArray as $slct) {
			__set_mysql_memory_table_recordnro($recordnro, $slct);
		}
	}

	function weather_get_mysql_record_number_field($recordnro, $field, $orderby = "")
	{
		$q = "select * from " . weather_get_weather_info_table_name();
		$q = $q . " where recordnro = " . $recordnro;	
		
		if ($orderby != "")
			$q = $q . " order by $orderby ";
		
 
		$result = weather_do_mysql_query($q);

		$rows = array();

		while ($row = $result->fetch_row())
		{
			$ro[] = __get_station_from_sql_row($row);
			$rows[] = $ro[$field];
		}

		$result -> free();
		
		return $rows;
	}

?>
