<?php

	function output_to_select_all_stations()
	{

		$LatestID = weather_get_mysql_data_last_record_number();

		$stations = weather_get_mysql_record_number_datas($LatestID, "stationname ASC");

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
				comment("Marker $selectedStation");
			/*
				echo "<!---\n";
				print_r($stationData);
				echo "--->\n";
			*/
				mkMarker($stationData);
			}
		}
	}
	
?>
