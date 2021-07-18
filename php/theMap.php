<html>
       <head>
			<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
			<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
       </head>

<?php
/*
	This does not work for some reason ... and the map is not rendering at all with this.
	
	function finnish_weather_load_src_script($n, $src)
	{
		wp_register_script($n, $src);
		wp_enqueue_script($n);
	}

	function finnish_weather_load_src_style($n, $src)
	{
		wp_register_style($n, $src);
		wp_enqueue_style($n);
	}

	finnish_weather_load_src_script("finnish_weather_openlayers_ol_script",
									"https://openlayers.org/en/v4.6.5/build/ol.js");
									
	finnish_weather_load_src_style ("finnish_weather_openlayers_ol_style",
									"https://openlayers.org/en/v4.6.5/css/ol.css");
	
*/
	require_once("master_include.inc");

	require_once("referrer_allow.inc");
	/* Referrer must be known */

	/* Login details */
	require_once("login.inc");

	/* SQL details */
	require_once("mysql.inc");	

	require_once("gdFunctions.php");

	function mkImgTagFrom($imgsrc)
	{
		return '<image src="' . $imgsrc . '" /><br>';
	}

	function generateDirectionImage($dir) {
		$imgsrc = createDirectionImage(40, 40, $dir,  4);
		return mkImgTagFrom($imgsrc);
	}

	function mkMarker($obj)
	{
		$jsn = json_encode($obj);
		comment("mkMarker obj: ", $obj);
		$quot= "'";

		$stout = "makeMarker(myMap," . $quot . $jsn . $quot . ");";

		echo $stout . "\n";
	}

	function generate_marker($station)
	{
		$di = "N/A";
		
		if (! ($station[8] == 'nan') )
			$di = generateDirectionImage($station[8]);
		
		comment("IMG: $di");
		
		$station[] = base64_encode($di);
		mkMarker($station);
	}

	function comment($txt)
	{
		echo "<!---- $txt ---->\n";
	}


	$LatestID = weather_get_mysql_data_last_record_number();

	$LatestStations = weather_get_mysql_record_number_datas($LatestID, "stationname ASC");

	comment("Session ID: " . my_session_id());

	$selectedStationsSetForSession = weather_get_mysql_memory_session_records(my_session_id());

//	print_r($selectedStationsSetForSession);


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

<html>

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
		rvstr = usstr;

		if (typeof(rvstr) == "string" )
				rvstr.replace(/&/g, "&amp;")
					 .replace(/</g, "&lt;")
					 .replace(/>/g, "&gt;")
					 .replace(/"/g, "&quot;")
					 .replace(/'/g, "&#039;");
//					 .replace(/ /g, "&nbsp;");
					 
		return rvstr;
	}

	function createTag(prnt, tag, pHtml, attr)
	{
		
		var html = document.createElement(tag);

		// console.log("Attr: ", attr);
		if (attr != null) {
			for (var a in attr)
			{

				var an = attr[a][0];
				var av = attr[a][1];
				// console.log("A: ", a, "T: ", an, "V: ", av);
				html.setAttribute(an, av);
			}
		}
		
		if (pHtml != null) {
			html.innerHTML = escapeHtml(pHtml);
		}
		
		var out = html;
		// console.log("html out: ", out.toString());
		
		if (prnt != null)
			prnt.appendChild(out);
		
		return out;
	}

	function makeTRSet(pParent, valuetdattrs, varAT, varAV, varBT, varBV)
	{
		
		valuetdattrs.push([ "colspan",	2]);
		
		var outH   = createTag(null, "tr", null, null);
		var outEAH = createTag(outH, "td", escapeHtml(varAT), 	valuetdattrs);
		var outEBH = createTag(outH, "td", "&nbsp;",			[ [ "width",	"5px"] 	]);
		var outECH = createTag(outH, "td", escapeHtml(varBT), 	valuetdattrs);
		

		var outC   = createTag(null, "tr", null, null);
		var outEAC = createTag(outC, "td", escapeHtml(varAV), 	valuetdattrs);
		var outEBC = createTag(outC, "td", "&nbsp;",			[ [ "width",	"5px"] 	]);
		var outECC = createTag(outC, "td", escapeHtml(varBV), 	valuetdattrs);

		var outC   = createTag(null, "tr", null, null);
		var outEAC = createTag(outC, "td", escapeHtml(varAV),   valuetdattrs);
		var outEBC = createTag(outC, "td", "&nbsp;", 			[ [ "width",	"5px"] 	]);
		var outECC = createTag(outC, "td", escapeHtml(varBV),   valuetdattrs);
		
		pParent.appendChild(outH);
		pParent.appendChild(outC);

		return pParent;
	}
	
	function mkBackgroundFrom(imgsrc, w, h)
	{

		ssw =  'width: ' + w + '; ';
		ssh = 'height: ' + h + '; ';

		return ssw + ssh + "background-image:url('" + imgsrc + "');";
	
	}

	async function generate_style_for_marker_bg(oElement, w, h)
	{
		var imageUrl = "<?php echo $FINWEATHER_PLUGIN_URL . '/generate_saatietotausta_image.php'; ?>";

		console.log("generate_style_for_marker_bg Fetch from: ", imageUrl);

		const resp = await fetch(imageUrl);

		// console.log("URL Fetch resp: ", resp);

		await resp.text().then(function (text) {
				styletag = mkBackgroundFrom(text, w, h);
				oElement.style = styletag;
				// console.log("generate_style_for_marker_bg for: ", oElement.style);
				// console.log("generate_style_for_marker_bg as : ", styletag);
			});;
	}

	function mkElementData(v,u)
	{

		if (v == 'nan')
			return "Nada";
		
		if (u == 'degC')
			u = '°C';
		
		return v + " " + u;
		
	}
	
	function mkElementDataClouds(v)
	{
		
	}
	
	function mkElementDataRain(v) {
		
		
	}

	function makeMarkerContent(jObj)
	{
		
		console.log("makeMarkerContent: ", jObj);
		var stationid							= jObj[00];
		var stationname							= jObj[01];
		var latitude							= jObj[02];
		var longitude							= jObj[03];
		var airtemp								= jObj[04];
		var airtempunit							= jObj[05];
		var windspeed							= jObj[06];
		var windspeedunit						= jObj[07];
		var winddirection						= jObj[08];
		var winddirectionunit					= jObj[09];
		var gustspeed							= jObj[10];
		var gustspeedunit						= jObj[11];
		var relhumval							= jObj[12];
		var relhumvalunit						= jObj[13];
		var dewpoint							= jObj[14];
		var dewpointunit						= jObj[15];
		var precipitationamount					= jObj[16];
		var precipitationamountunit				= jObj[17];
		var precipitationintensity				= jObj[18];
		var precipitationintensityunit			= jObj[19];
		var snowdepth							= jObj[20];
		var snowdepthunit						= jObj[21];
		var pressure							= jObj[22];
		var pressureunit						= jObj[23];
		var horizvisib							= jObj[24];
		var horizvisibunit						= jObj[25];
		var cloudamount							= jObj[26];
		var cloudamountunit						= jObj[27];
		var recordnro							= jObj[28];
		var recordts							= jObj[29];
		var winddirimg							= atob(jObj[30]);

		var location 	= stationname;

		 console.log("locat: ", location, "airtemp: ", airtemp, "windspeed: ", windspeed, "gustspeed: ", gustspeed, "cloudamount:", cloudamount);
		 console.log("cloudamount:", cloudamount);
		 console.log("cloudamountunit:", cloudamountunit);

		 console.log("snowdepth:", snowdepth);
		 console.log("snowdepthunit:", snowdepthunit);

		 console.log("horizvisib:", horizvisib);
		 console.log("horizvisibunit:", horizvisibunit);

		 console.log("pressure:", pressure);
		 console.log("pressureunit:", pressureunit);

		 console.log("precipitationamount:", precipitationamount);
		 console.log("precipitationamountunit:", precipitationamountunit);

		 console.log("precipitationintensity:", precipitationintensity);
		 console.log("precipitationintensityunit:", precipitationintensityunit);

		var popup_width = 180;
		var popup_height = 220;


		var textstyle = "color: #ddddFF;";

		var tableattrs=	[
							["width", popup_width + 'px'  ],
							["height", popup_height + 'px'],
							["onclick", 'close_popup();'  ],
						];

		var headertdattrs=	[
								["style", textstyle ],
								["colspan", 5],
							];

		var valuetdattrs=	[
								["style", textstyle ],
							];
		
		var out=createTag(null, "table", null, tableattrs);

			generate_style_for_marker_bg(out, popup_width, popup_height);

		var outHDRpaikkaTR = createTag(out, "tr", null, null);

		var outHDRpaikkaTD  = createTag(outHDRpaikkaTR,  "td", null, headertdattrs);

		var outHDRpaikkaHTML  = createTag(outHDRpaikkaTD,  "h3", location, valuetdattrs);

		var outHDRarvotHTMLair  = makeTRSet(out, valuetdattrs,
												"Lämpötila", 		mkElementData(airtemp,airtempunit),	
												"Ilmankosteus",		mkElementData(relhumval,relhumvalunit));
		var outHDRarvotHTMLwind = makeTRSet(out, valuetdattrs,
												"Tuulen nopeus",	mkElementData(windspeed,windspeedunit),
												"Tuulen suunta",	winddirimg);

		var outHDRarvotHTMLpilvisyysJasademäärä = makeTRSet(out, valuetdattrs,
												"Pilvisyys",	mkElementData(cloudamount,cloudamountunit),
												"Sademäärä",	mkElementData(precipitationamount, precipitationamountunit));
		
		var suprise =  Math.floor(10 * Math.random());
		

		if ( suprise == 1 )
		{

			suprisetxt = "<p color='red'>Yllätys!!!</p><br>30% ALE kupongilla FINWEATHER30<br>Kaupoille <a href='https://paxsudos.fi/' target='_blank'>Paxsudossiin</a>";

			var supriseHDRpaikkaTR    = createTag(out, "tr", null, null);
			var supriseHDRpaikkaTD    = createTag(supriseHDRpaikkaTR,  "td", null, headertdattrs);
			var supriseHDRpaikkaCENTER= createTag(supriseHDRpaikkaTD,  "center", null, valuetdattrs);
			var supriseHDRpaikkaHTML  = createTag(supriseHDRpaikkaCENTER,  "h4", suprisetxt, valuetdattrs);
			
		}

		
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
//		// console.log("makeMarker jsn: ", jsn);
//		// console.log("makeMarker jObj: ", jObj);
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
			
//			// console.log("Init ", name, " overlay: ", o);
										
		} 

		overlay 	= saved_overlay[name];
		
		if (saved_fea[name] == null) {
			var sfea = new ol.Feature({
									geometry: point
								});

			sfea.set("name",  name);
			sfea.set("json",  jObj);

			saved_fea[name] = sfea;

//			// console.log("Init ", name, " sfea: ", sfea);
		} 

		fea 		= saved_fea[name];


		if (saved_layer[name] == null) {
			var o = new ol.layer.Vector({
							source: new ol.source.Vector({
								features: [ fea ]
							}),
							style: new ol.style.Style({
								image: new ol.style.Icon({
									anchor: [0.5, 0.5],
									anchorXUnits: "fraction",
									anchorYUnits: "fraction",
									opacity: 0.4,
									scale: 2.5,
									src: "https://upload.wikimedia.org/wikipedia/commons/e/ec/RedDot.svg"
								})
							})
						});

			saved_layer[name] = o;
//			// console.log("Init ", name, " layer: ", o);
		} 
		
		layer = saved_layer[name];

/*
		// console.log("overlay:", overlay);
		// console.log("fea    :", fea);
		// console.log("layer  :", layer);
*/
		nToO  = myMap.get("nameToOverlay") || nameToOverlay;
		nToO[name] = overlay;
		myMap.set("nameToOverlay", nToO);


		myMap.addLayer(layer);
		myMap.addOverlay(overlay);
	
		// console.log("name: ", name, "set jsn: ", jObj);
		
		pMap.on('singleclick', function (event) {
					var cname 	= content.getAttribute("contname");
					var nToO    = myMap.get	("nameToOverlay");
					var over    = nToO[cname];
					
					var feats = myMap.forEachFeatureAtPixel(
											event.pixel,
											function(f) { 
												// console.log("Feature: ", f);
												return f;
											}
										);
			
					// console.log("singleclick start -----------------------------------------");
					// console.log("cname : ", cname);
					// console.log("over  : ", over);
					// console.log("nToO  : ", nToO);
					// console.log("feats : ", feats);
					// console.log("pixel : ", event.pixel);
					// console.log("coords: ", event.coordinate);
					var rv = true;

					if (feats)
					{
						var coords = event.coordinate;
						// console.log("Found event: ", event);
						
						/* get data from feature */
						var name 	= cname;
						var jObj 	= feats.get("json");
						var nToO    = myMap.get("nameToOverlay");
						var over    = nToO[name];

						// console.log("name:", 		name);
						// console.log("json:", 		jObj);
						// console.log("over:", 		overlay);
						// console.log("cont ID:", 	content.id);
						// console.log("cont:", 		content);

						htmlcontent = makeMarkerContent(jObj);

						content.innerHTML = "";
						content.appendChild(htmlcontent);
						
						// console.log("cont: ", content.innerHTML);
						// console.log("coords Bef: ", coords);
						pMap.getView().setCenter(coords);
						overlay.setPosition(coords);
	
						rv = false; /* Stop propagation */
					} else {
						overlay.setPosition(undefined);
						closer.blur();
					}		
					// console.log("singleclick end -----------------------------------------");
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
							center: new ol.proj.fromLonLat([26.876078, 65.280601]),
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
			global $selectedStationsSetForSession;


			$postObj = Array();
			$statData = $LatestStations;
			$pval = false;
			
			if ( isset($_GET) && isset($_GET['stations'])) {
				$postObj = $_GET;
				$pval = true;
				$statData = $selectedStationsSetForSession;
				comment("Setting some stations .....");
			}

			comment("Setting stations ..... POST:" . $pval);
			//var_dump($statData);
			
			if ( $pval )
			{
				$tmp = Array();
				
				comment("Setting selected stations .....");
				
				foreach ($postObj['stations'] as $getstationi) {
					$st = $LatestStations[$getstationi];
					comment("    Station $getstationi: " . $st[1]);
					//var_dump($st);
					$tmp[] = $st;
				}
				$statData = $tmp;
			} else {
				comment("Setting ALL stations .....");
				$statData = $LatestStations;
			}

			comment("Setting theys stations:");
			//var_dump($st);
			
			foreach ($statData as $stationi) {
				generate_marker($stationi);
			}
		?>
		// Marker generation ends
		
	}
	
	function cb_onLoadDocument(event, after) 
	{
		// console.log("Document loaded ... init: " + firstOpeningWindow);
		if (firstOpeningWindow)
		{
				initMap();
		}
		
		after();
	}

	function cb_after(){ firstOpeningWindow = false; }
	
</script>

<center>
	<table>
		<tr>
			<td>
				    <div id="osmMap" style="width:450px;height:700px;">
						<div id="osmPop" style="visibility: visible; display: block;">
							<a href="#" id="osmPop-closer"></a>
							<div id="osmPop-content" style="visibility: visible; display: block;"></div>
						</div>
					</div> 

			</td>
			<td>
				<form action="" name="selectionmenu" method="GET">
					<input type="hidden" name="action" value="finweather_submit">
					
					<label for="stations">Valitse sääasemat</label>
					<br>
					<select name="stations[]" id="stations" multiple size="30">
					<br>
					<?php generate_station_selectiors($LatestStations); ?>
					</select>
					<br>
					<input type="submit" value="Valitse">
				</form>
			</td>
		</tr>
	</table>
</center>

<script>
	window.document.onload = cb_onLoadDocument(event, cb_after);
</script>



</html>
