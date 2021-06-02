
<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script>
		let myMap;

		function makeMarker(jsn)
		{
			var jObj = JSON.parse(jsn);
			var point = new google.maps.LatLng();
		}

		function initMap() {

		  myMap = new google.maps.Map(document.getElementById("googleMap"), {
			zoom: 8,
		  });

			<?php
				
				function mkMarker($map, $obj)
				{
					$jsn = json_encode($obj);
					
					echo "json = " . '"' . $jsn . '";';
					makeMarker(json);
					
				}

				if ( $fv = $_POST['stations'] )
				{
					foreach ($fv as $selectedStation) {
						$stationData = $latestData[$selectedStation];
						mkMarker($stationData);
					}
				}
			?>


		}


	</script>
  </head>
  <body>
    <div id="googleMap" style="width:100%;height:500px;"></div>


    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gmap_api_key ?>&callback=initMap"
      async
    ></script>
  </body>
</html>

