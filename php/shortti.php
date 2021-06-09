<?php

	/* Login details */
	require_once("login.inc");

	/* SQL details */
	require_once("mysql.inc");	

	require_once("header.php");
	
	require_once("body_selection_generate.inc");

?>
	<table>
		<tr>
			<td>

				<form action="<?php echo __DIR__ . 'handle_form.php'; ?>" name="selectionmenu" method="GET">
					<input type="hidden" name="action" value="finweather_submit">
					
					<label for="stations">Valitse sääasemat</label>
					<br>
					<select name="stations[]" id="stations" multiple size="10">
					<br>
					<?php generate_station_selectiors($LatestStations); ?>
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
