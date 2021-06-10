<?php 

	/* Login details */
	require_once("login.inc");

	/* SQL details */
	require_once("mysql.inc");	

	function mkMarker($obj)
	{
		$jsn = json_encode($obj);
		$quot= "'";

		$stout = "makeMarker(myMap," . $quot . $jsn . $quot . ");";

		echo $stout . "\n";
	}

	function comment($txt)
	{
		echo "<!---- $txt ---->";
	}


	$LatestID = weather_get_mysql_data_last_record_number();

	$LatestStations = weather_get_mysql_record_number_datas($LatestID, "stationname ASC");

	comment("Session ID: " . session_id());

	$selectedStationsSetNro = weather_get_mysql_memory_table_latest_recordnro(session_id());

	//print_r($stations);

	function generate_station_selectiors($stations) {
		$FID = 0;
		$htmlEndln = "<br>\n";
		$htmlVarS = '<?php $_POST[\'';
		$htmlVarE = '\'] = ';
		
		foreach ($stations as $stationi) {
			$station = $stationi[1];
			$htmlIP = "<option value=";
			$htmlIP = $htmlIP . $FID . ">";
			$htmlIP = $htmlIP . $station;
			$htmlIP = $htmlIP . "</option>";
			echo $htmlIP . $htmlEndln;
			$FID++;
		}
	}

?>
