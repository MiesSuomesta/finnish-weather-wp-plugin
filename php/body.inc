<?php 

	include("saa-map-php-functions.inc");

	include("saa-map-java-functions.inc");
	$stations = weather_get_mysql_record_number_field($LatestID, 1, "stationname ASC");
	$FID = 0;

	function output_station($station) {

			global $stations;
			global $FID;
			$htmlEndln = "<br>\n";
			$htmlIP = '					<option value="' . $FID . '">' . $station . "</option>";
			return $htmlIP . $htmlEndln;

	}
	
	function output_saatable() {
			global $stations;
			global $FID;
?>

	<table>
		<tr>
			<td>

				<form action="saa-osm-fi.php" method="get">
				<label for="stations">Valitse sääasemat</label>
				<br>
				<select name="stations[]" id="stations" multiple size=10>

<?php
					foreach ($stations as $station) {
						echo output_station($station);
						$FID++;
					};
?>

				</select>
				<br>
					<input type="submit" value="Valitse">
				</form>
			</td>
			<td>
				    <div id="osmMap" style="width:450px;height:550px;"></div>
				    <div id="osmPop" style="visibility: visible; display: block;">
						<a href="#" id="osmPop-closer"></a>
						<div id="osmPop-content" style="visibility: visible; display: block;"></div>
					</div>
			</td>
		</tr>
	</table>

	<script language="javascript">
		window.document.onload = cb_onLoadDocument(event, cb_after);
	</script>

<?php }; 

	echo "\n<br>LJA S ---------------------------\n<br>";
	output_saatable();
	echo "\n<br>LJA E ---------------------------\n<br>";

?>