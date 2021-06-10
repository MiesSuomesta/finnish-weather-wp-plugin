<html>
	<head>
	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
	<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
	</head>

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

	function generate_marker($station)
	{
		mkMarker($station);
	}

	function comment($txt)
	{
		echo "<!---- $txt ---->";
	}


	$LatestID = weather_get_mysql_data_last_record_number();

	$LatestStations = weather_get_mysql_record_number_datas($LatestID, "stationname ASC");

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

<script type="text/javascript">
	let myMap;
	let firstOpeningWindow = true;
	let names = Array();
	let coordsToJSON = Array();
	let nameToOverlay = Array();
	let nameToLayer = Array();
	
	let saved_overlay = Array();
	let saved_fea = Array();
	let saved_layer = Array();
	
	let container;
	let content;
	let closer;
	
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
							["width", '160px'],
							["onclick", 'close_popup();']
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

	
	function close_popup()
	{
		overlay.setPosition(undefined);
		closer.blur();
	}
	
	function makeMarker(pMap, jsn)
	{
		var jObj = JSON.parse(jsn);
		var name = jObj[1];
		var lat = parseFloat( jObj[2] );
		var lng = parseFloat( jObj[3] );
		var point = new ol.geom.Point(ol.proj.fromLonLat([lng, lat]));
		
		content.isContentEditable = true;

		if (saved_overlay[name] == null) {
			var o = new ol.Overlay({
							id: name,
							element: container
						});

			saved_overlay[name] = o;
			
			console.log("Init ", name, " overlay: ", o);
										
		} 

		overlay 	= saved_overlay[name];
		
		if (saved_fea[name] == null) {
			var sfea = new ol.Feature({
									geometry: point
								});

			sfea.set("name",  name);
			sfea.set("json",  jObj);

			saved_fea[name] = sfea;

			console.log("Init ", name, " sfea: ", sfea);
		} 

		fea 		= saved_fea[name];


		if (saved_layer[name] == null) {
			var o = new ol.layer.Vector({
							source: new ol.source.Vector({
								features: [ fea ]
							})
						});

			saved_layer[name] = o;
			console.log("Init ", name, " layer: ", o);
		} 
		
		layer = saved_layer[name];

		console.log("overlay:", overlay);
		console.log("fea    :", fea);
		console.log("layer  :", layer);


/*
		var nToL  = myMap.get("nameToLayer") || nameToLayer;
		nToL[name] = overlay;
		myMap.set("nameToLayer", nToL);
*/

		nToO  = myMap.get("nameToOverlay") || nameToOverlay;
		nToO[name] = overlay;
		myMap.set("nameToOverlay", nToO);


		myMap.addLayer(layer);
		myMap.addOverlay(overlay);
	
		console.log("name: ", name, "set jsn: ", jObj);
		
		pMap.on('singleclick', function (event) {
					var cname 	= content.getAttribute("contname");
					var nToO    = myMap.get("nameToOverlay");
					var over    = nToO[cname];
					
					var feats = myMap.forEachFeatureAtPixel(
											event.pixel,
											function(f) { 
												console.log("Feature: ", f);
												return f;
											}
										);
			
					console.log("singleclick start -----------------------------------------");
					console.log("cname : ", cname);
					console.log("over  : ", over);
					console.log("nToO  : ", nToO);
					console.log("feats : ", feats);
					var rv = true;
					if (feats)
					{
						var coords = event.coordinate;
						console.log("Found event: ", event);
						
						/* get data from feature */
						var name 	= cname;
						var jObj 	= feats.get("json");
						var nToO    = myMap.get("nameToOverlay");
						var over    = nToO[name];

						console.log("name:", 		name);
						console.log("json:", 		jObj);
						console.log("over:", 		overlay);
						console.log("cont ID:", 	content.id);
						console.log("cont:", 		content);
						
						
						htmlcontent = makeMarkerContent(jObj);

						content.innerHTML = "";
						content.appendChild(htmlcontent);
						
						console.log("cont: ", content.innerHTML);
						console.log("this: ", this);
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
							over.setPosition(undefined);
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

		container 	= document.getElementById('osmPop');
		content 	= document.getElementById('osmPop-content');
		closer 		= document.getElementById('osmPop-closer');

		// Marker generation start
		<?php 
			global $LatestID;

			global $LatestStations;

			$postObj = Array();
			$statData = $LatestStations;
			$pval = false;
			
			if ( isset($_GET) && isset($_GET['stations']) ) {
				$postObj = $_GET;
				$pval = true;
				$statData = $LatestStations;
			}

			comment("Setting stations ..... POST:" . $pval);
			
			if ( $pval )
			{
				$tmp = Array();
				
				comment("Setting selected stations .....");
				foreach ($postObj['stations'] as $getstationi) {
					$st = $LatestStations[$getstationi];
					comment("Station $getstationi: " . $st[1]);
					//var_dump($st);
					$tmp[] = $st;
				}
				$statData = $tmp;
			} else {
				comment("Setting ALL stations .....");
			}
			
			foreach ($statData as $stationi) {
				generate_marker($stationi);
			}
		?>
		// Marker generation ends
		
	}
	
	function cb_onLoadDocument(event, after) 
	{
		console.log("Document loaded ... init: " + firstOpeningWindow);
		if (firstOpeningWindow)
		{
				initMap();
		}
		
		after();
	}

	function cb_after(){ firstOpeningWindow = false; }
	
</script>

<?php

	if ( isset($_POST) ) {
		comment("LJA A1");
		var_dump($_POST);
		comment("LJA A2");
		var_dump($_GET);
		comment("LJA A3");
		var_dump($_SESSION);
	}
?>
	<table>
		<tr>
			<td>
				<form action="" name="selectionmenu" method="GET">
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



</html>