	<?php 

		if (function_exists('add_action'))
			add_action('finweather_submit', finweather_submit_func);

		function finweather_submit_func()
		{
			global $_GET;
			global $_SESSION;
			$post = $_GET;
			var_dump($post);
			$postjson = json_encode($post);
			var_dump($postjson);

			$_SESSION['FinnishWeartherPOSTargsJSON'] = $postjson;
			
			//setcookie("FinnishWeartherPOSTargsJSON", $postjson, time() + 2 * 60, "/");
		}
		
	?>

	<!--- LJA HEADER START --->
	<link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
	<script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>

	
	<?php 
		
		require_once('header-functions.inc');
		require_once('body_selection_generate.inc'); 

	?>
	<!--- LJA HEADER END --->
