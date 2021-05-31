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
		
		function escapeHtml(usstr)
		{
			if (usstr != null) 
				usstr.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
			else
				usstr = "";
			
			return usstr;
		}

		function createTag(prnt, tag, pHtml, attr)
		{
			
			var html = document.createElement(tag);

			console.log("Attr: ", attr);
			if (attr != null) {
				for (var a in attr)
				{

					var an = attr[a][0];
					var av = attr[a][1];
					console.log("A: ", a, "T: ", an, "V: ", av);
					html.setAttribute(an, av);
				}
			}
			
			if (pHtml != null) {
				html.innerHTML = pHtml;
			}
			
			var out = html;
			console.log("html out: ", out.toString());
			
			if (prnt != null)
				prnt.appendChild(out);
			
			return out;
		}

		function makeTRSet(pParent, varAT, varAV, varBT, varBV)
		{
			var outH   = createTag(null, "tr", null, null);
			var outEAH = createTag(outH, "td", escapeHtml(varAT), 	[ [ "colspan",	2 ]		]);
			var outEBH = createTag(outH, "td", "&nbsp;",			[ [ "width",	"5px"] 	]);
			var outECH = createTag(outH, "td", escapeHtml(varBT), 	[ [ "colspan",	2 ]		]);
			

			var outC   = createTag(null, "tr", null, null);
			var outEAC = createTag(outC, "td", escapeHtml(varAV), 	[ [ "colspan",	2 ]		]);
			var outEBC = createTag(outC, "td", "&nbsp;",			[ [ "width",	"5px"] 	]);
			var outECC = createTag(outC, "td", escapeHtml(varBV), 	[ [ "colspan",	2 ]		]);

			var outC   = createTag(null, "tr", null, null);
			var outEAC = createTag(outC, "td", escapeHtml(varAV),   [ [ "colspan",	2]		]);
			var outEBC = createTag(outC, "td", "&nbsp;", 			[ [ "width",	"5px"] 	]);
			var outECC = createTag(outC, "td", escapeHtml(varBV),   [ [ "colspan",	2]		]);
			
			pParent.appendChild(outH);
			pParent.appendChild(outC);

			return pParent;
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
			var tableattrs=	[
								["bgcolor",'#AAAAFF'],
								["width", '120']
							];

			var headertdattrs=	[
									["colspan", 5]
								];
			
			var out=createTag(null, "table", null, tableattrs);
			var outHDRpaikkaTR = createTag(out, "tr", null, null);

			var outHDRpaikkaTD  = createTag(outHDRpaikkaTR,  "td", null, headertdattrs);

			var outHDRpaikkaHTML  = createTag(outHDRpaikkaTD,  "h1", location, null);

			var outHDRarvotHTMLair  = makeTRSet(out, "Lämpötila", 		airtemp,	"Ilmankosteus",		relhumval);
			var outHDRarvotHTMLwind = makeTRSet(out, "Tuulen nopeus",	windspeed,	"Tuulen suunta",	winddir);
			

			
			return out;
		}
		
		function makeMarker(pMap, jsn)
		{
			var jObj = JSON.parse(jsn);
			var name = jObj[1];
			var lat = parseFloat( jObj[2] );
			var lng = parseFloat( jObj[3] );
			var point = new ol.geom.Point(ol.proj.fromLonLat([lng, lat]));
			
			var container 	= document.getElementById('osmPop');
			var content 	= document.getElementById('osmPop-content');
			var closer 		= document.getElementById('osmPop-closer');

			content.isContentEditable = true;

			var overlay = new ol.Overlay({
							element: container
						});

			var fea = new ol.Feature({
								geometry: point
							});

				fea.set("name",  name);
				fea.set("json",  jObj);
				fea.set("cont",  content);
				fea.set("over",  overlay);
				
			var layeri = new ol.layer.Vector({
					source: new ol.source.Vector({
						features: [ fea ]
					})
				});

			myMap.addLayer(layeri);
			myMap.addOverlay(overlay);
		
			console.log("name: ", name, "set jsn: ", jObj);
			
			pMap.on('singleclick', function (event) {
						var contner = document.getElementById('osmPop');
						var contnt 	= document.getElementById('osmPop-content');
						var closer 	= document.getElementById('osmPop-closer');

						var feats = myMap.forEachFeatureAtPixel(
												event.pixel,
												function(f) { 
													console.log("Feature: ", f);
													return f;
												}
											);
				
						console.log("singleclick start -----------------------------------------");
						console.log("feats: ", feats);
						var rv = true;
						if (feats)
						{
							var coords = event.coordinate;
							console.log("Found event:", event);
							/* get data from feature */
							var name = feats.get("name");
							var jObj = feats.get("json");
							var cont = feats.get("cont");
							var over = feats.get("over");
							
							console.log("name:", 		name);
							console.log("json:", 		jObj);
							console.log("over:", 		over);
							console.log("cont ID:", 	cont.id);
							console.log("cont:", 		cont);
							
							
							htmlcontent = makeMarkerContent(jObj);
							
							cont.innerHTML = "";
							cont.appendChild(htmlcontent);
							
							console.log("cont: ", cont.innerHTML);
							console.log("this: ", this);
							over.setPosition(coords);
		
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
				<select name="stations[]" id="stations" multiple size=10>
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
</html>



