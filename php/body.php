

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

		echo $stout;
	}

	function comment($txt)
	{

	}

	$LatestID = weather_get_mysql_data_last_record_number();

	$stations = weather_get_mysql_record_number_datas($LatestID, "stationname ASC");

	//print_r($stations);

	function generate_markers()
	{
		global $stations;
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
?>

	<?php include("body_selection_generate.inc"); ?>

	<table>
		<tr>
			<td>

				<form action="saa-osm-fi.php" method="get">
				<label for="stations">Valitse sääasemat</label>
				<br>
				<select name="stations[]" id="stations" multiple size=10>
				<br>

				<?php
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
				?>
				</select>
				<br>
				<input type="submit" value="Valitse">
				</form>
			</td>
			<td>
				    <div id="osmMap" style="width:450px;height:550px;"></div>
				    <div id="osmPop" style="visibility: visible; display: block;">
						<a href="#" id="osmPop-closer"></div>
						<div id="osmPop-content" style="visibility: visible; display: block;"></div>
					</div>

					<script>
						window.document.onload = cb_onLoadDocument(event, cb_after);
					</script>

			</td>
		</tr>
	</table>
