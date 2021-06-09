	<?php 
		

		$post = file_get_contents("php://input");
		print_r($post);
		$postjson = json_encode($post);
		print_r($postjson);

		setcookie("FinnishWeartherPOSTargsJSON", $postjson, time() + 2 * 60, "/");
		
	?>

	<!--- LJA HEADER START --->
	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
	<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>

	
	<?php 
		
		require_once('header-functions.inc');
		require_once('body_selection_generate.inc'); 

	?>
	<!--- LJA HEADER END --->
