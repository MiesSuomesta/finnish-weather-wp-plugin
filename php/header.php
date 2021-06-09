
	<!--- LJA HEADER START --->
	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
	<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>

	
	<?php 
		function get_load_path() {
			$p =  dirname(dirname(dirname(dirname(dirname( __FILE__ ))))) . "/wp-load.php";
			return $p;
		}
		
		require_once(get_load_path());
		require_once('header-functions.inc');
		require_once('body_selection_generate.inc'); 

	?>
	<!--- LJA HEADER END --->
