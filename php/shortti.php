<?php

	$LatestID = weather_get_mysql_data_last_record_number();

	$stations = weather_get_mysql_record_number_datas($LatestID, "stationname ASC");


?>
	<table>
		<tr>
			<td>

				<form action="<?php echo $SELF; ?>" method="get">
					<label for="stations">Valitse sääasemat</label>
					<br>
					<select name="stations[]" id="stations" multiple size="10">
					<br>
					
					<?php generate_station_selectiors($stations); ?>

					</select>
					<br>
					<input type="submit" value="Valitse">
				</form>
			</td>
			<td>
				    <div id="osmMap" style="width:450px;height:550px;">
						<div id="osmPop" style="visibility: visible; display: block;">
							<a href="#" id="osmPop-closer"></a>
							<div id="osmPop-content" style="visibility: visible; display: block;"></div>
						</div>
					</div> 

					<script>
						window.document.onload = cb_onLoadDocument(event, cb_after);
					</script>

			</td>
		</tr>
	</table>
