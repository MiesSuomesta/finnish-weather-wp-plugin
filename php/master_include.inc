<?php

	$FINWEATHER_PLUGIN_DIR = dirname( __FILE__ ) . "/";
	$FINWEATHER_PLUGIN_URL = get_file_base_http_address();
	$FINWEATHER_PLUGIN_MAIN_URL = get_file_base_http_address() . basename( __FILE__ );
	$FINWEATHER_CONFIG_FILE = $FINWEATHER_PLUGIN_DIR . "finnish_weather_wp_plugin_config.json";

	// Some random string to be used in memory tables to remember user selections
	$FINWEATHER_ID = base64_encode( "" + ( rand(1,9999) * rand(1,9999) ) );

	function my_session_id() 
	{
		return $FINWEATHER_ID;
	}

	function validate_int_data_in_range($min, $val, $max)
	{
		$rv = false;
		if ($min < $val)
			if ($val < $max)
				$rv = (int)($val);
	
		return $rv;
	}

	function get_master_config_file()
	{
		global $FINWEATHER_CONFIG_FILE;
		// echo "get config file: " . $FINWEATHER_CONFIG_FILE ;
		return $FINWEATHER_CONFIG_FILE;
	}
	
	function get_file_base_http_address()
	{
		global $FINWEATHER_PLUGIN_DIR;

		$mydroot=$_SERVER['DOCUMENT_ROOT'];
		$myservername=$_SERVER['SERVER_NAME'];
		

		$mydocstr = str_replace($mydroot, "https://$myservername/", $FINWEATHER_PLUGIN_DIR);

		$myret = $mydocstr;

		return $myret;
	}


?>