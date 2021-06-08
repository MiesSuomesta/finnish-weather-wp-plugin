
	<!--- LJA HEADER START --->
	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
	<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>

	
	<?php 
		
		session_start();
		
		require_once('header-functions.inc');
		require_once('body_selection_generate.inc'); 


		print_r($_POST);
		$postjson = json_encode($_POST);
		print_r($postjson);

		setcookie("POST", $postjson, time() + 2 * 60, "/");
	?>
	<!--- LJA HEADER END --->
