<html>
<head>
<?php

/* Login details */
include("login.inc");

function weather_get_weather_info_table_name()
{
	return $GLOBALS['mysql_weatherinfotable'];
}

function weather_do_mysql_query($query)
{
	$q = $query . ";";

	$mysqli = new mysqli(	$GLOBALS['mysql_hostname'],
							$GLOBALS['mysql_username'],
							$GLOBALS['mysql_password'],
							$GLOBALS['mysql_databasename']);

	// Check connection
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}

	$result = $mysqli->query($q);

	// Check connection
	if ($mysqli->connect_errno) {
		echo "Failed to request from MySQL: " . $mysqli->connect_error;
		exit();
	}

	$mysqli->close();

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

function weather_get_mysql_record_number_field($rnro, $field, $orderby = "")
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

function mkMarker($obj)
{
	$jsn = json_encode($obj);
	echo "makeMarker(myMap, '" . $jsn ."');\n";
}

function comment($txt)
{
	echo "<!--- $txt --->\n";
}

?>
	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
	<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
	<script>
		let myMap;
		let firstOpeningWindow = true;
		let names = Array();
		let coordsToJSON = Array();
		//let bounds;
		//let infowin;

		function makeTRSet(varAT, varAV, varBT, varBV)
		{
			var outA = "<tr> <td colspan='2'>"+ varAT +"</td>" + 
						"<td width='5px'>&nbsp;</td>" +
						"<td colspan='2'>"+ varBT +"</td>" +
						"</tr>";

			var outB = "<tr> <td colspan='2'>"+ varAV +"</td>" + 
						"<td width='5px'>&nbsp;</td>" +
						"<td colspan='2'>"+ varBV +"</td>" +
						"</tr>";
						
			return outA + outB;
		}

		function makeMarkerContent(jObj)
		{
			var location 	= jObj[1];

			var airtemp 	= jObj[4];
			var windspeed 	= jObj[6];
			var winddir 	= jObj[8];

			var gustspeed 	= jObj[6];
			var relhumval	= jObj[12];

			console.log("locat: ", location, "airtemp: ", airtemp, "windspeed: ", windspeed, "winddir: ", winddir, "gustspeed: ", gustspeed);

			var locstr = "<h1>" + location + "</h1>";
			var tr_air = makeTRSet("Lämpötila", 		airtemp,	"Ilmankosteus",		relhumval);
			var tr_wind = makeTRSet("Tuulen nopeus",	windspeed,	"Tuulen suunta",	winddir);
			
			var out="<table bgcolor='#AAAAFF' width='120'>" + 
					"<tr><td colspan='5'>"+ locstr + "</td></tr>" +
						tr_air +
						tr_wind +
						"</table>";

			return out;
		}
		
		function findLayerJson(pMap, name)
		{
			console.log("findLayerJson start -----------------------------------------");
			cdata = myMap.get("customdata");
			console.log("findLayerJson: cdata: ", cdata);
			layername = name;
			console.log("findLayerJson: layername:", layername);
			for (var cdjson in cdata)
			{
				console.log("findLayerJsonDebug: cdjson:", cdjson, "layername:", layername);
				if (cdjson == layername)
					return cdata[cdjson];
				else
					continue;
			}
			console.log("findLayerJson end -----------------------------------------");

			return false;
		}

		let overlays = 0;
		function makeMarker(pMap, jsn)
		{
			var jObj = JSON.parse(jsn);
			var name = jObj[1];
			var lat = parseFloat( jObj[2] );
			var lng = parseFloat( jObj[3] );
			var point = new ol.geom.Point(ol.proj.fromLonLat([lng, lat]));

			
			var container = document.getElementById('osmPop');
			var content = document.getElementById('osmPop-content');
			var closer = document.getElementById('osmPop-closer');
			var fea = new ol.Feature({
								geometry: point
							});
				fea.set("name", name);
				fea.set("json", jObj);
				fea.set("cont", content);
				
			var layeri = new ol.layer.Vector({
					source: new ol.source.Vector({
						features: [ fea ]
					})
				});


			layeri.set("customdataname", name);
			myMap.addLayer(layeri);

			var overlay = new ol.Overlay({
							element: container
						});
			
			myMap.addOverlay(overlay);
		
			coordsToJSON[name] = jObj;
			console.log("-----------------------------------------");

			myMap.unset("customdata");
			myMap.set("customdata", coordsToJSON);

			console.log("name: ", name, "set jsn: " , myMap.get("customdata")[name]);
			
			pMap.on('singleclick', function (event) {
				
						var feats = myMap.forEachFeatureAtPixel(
										event.pixel,
										function(f) { return f; }
									);
				
						console.log("singleclick start - "+ name +" ----------------------------------------");
						var rv = true;
						if (feats)
						{
							var coords = event.coordinate;
							console.log("Found event:", event);
							var name = feats.get("name");
							var jObj = feats.get("json");
							var cont = feats.get("cont");
							console.log("name:", name);
							console.log("json:", jObj);
							cont.innerHTML = makeMarkerContent(jObj);
							console.log("content:", cont);
							overlay.setPosition(coords);
							rv = false; /* Stop propagation */
						} else {
							overlay.setPosition(undefined);
							closer.blur();
						}		
						console.log("singleclick end -----------------------------------------");
						return rv;
					});

			closer.onclick = function() {
						overlay.setPosition(undefined);
						closer.blur();
						return false;
					};
					
		}

		function initMap() {
			
			myMap = new ol.Map({
						target: 'osmMap',
						layers: [
							new ol.layer.Tile({
								source: new ol.source.OSM()
							})
						],
						view: new ol.View({ 
								center: new ol.proj.fromLonLat([26.876078, 64.280601]),
								zoom: 5
							})
					});

			<?php
			
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
			
			?>
			
//			myMap.fitBounds(bounds);
			
		}
		
		function cb_onLoadDocument(event, after) 
		{
			if (firstOpeningWindow)
			{
					initMap();
			}
			
			after();
		}

		function cb_after(){ firstOpeningWindow = false; }
		
	</script>
</head>

<?php
	$stations = weather_get_mysql_record_number_field($LatestID, 1, "stationname ASC");
	$FID = 0;
	$htmlEndln = "<br>\n";
?>

	<table>
		<tr>
			<td>

				<form action="saa-osm-fi.php" method="get">
				<label for="stations">Valitse sääasemat</label>
				<br>
				<select name="stations[]" id="stations" multiple size = 10>
				<br>

<?php
foreach ($stations as $station) {
	$htmlIP = '					<option value="' . $FID . '">' . $station . "</option>";
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
				    <div id="osmPop" id="osmPop-popup" class="ol-popup">
						<a href="#" id="osmPop-closer" class="ol-popup-closer"></a>
						<div id="osmPop-content"></div>
					</div>

				<script language="javascript">
					window.document.onload = cb_onLoadDocument(event, cb_after);
				</script>

			</td>
		</tr>
	</table>
</html>



