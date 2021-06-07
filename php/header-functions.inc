<?php 

	/* Login details */
	include_once("login.inc");

	/* SQL details */
	include_once("mysql.inc");	

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

	$stations = weather_get_mysql_record_number_datas($LatestID, "stationname ASC");

	//print_r($stations);

	function generate_markers($stations)
	{

/*		
		echo "Stations:";
		print_r($stations);
		echo "<br>";
		comment("Stations got:");
		echo "<!---\n";
		print_r($_GET['stations']);
		echo "--->\n";

*/

		if ( $fv = $_GET['stations'] )
		{
			foreach ($fv as $selectedStation) {
				$stationData = $stations[$selectedStation];
			/*
				comment("Marker $selectedStation");
				echo "<!---\n";
				print_r($stationData);
				echo "--->\n";
			*/
				mkMarker($stationData);
			}
		}
	}

	function generate_station_selectiors($stations) {
		$FID = 0;
		$htmlEndln = "<br>\n";
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
