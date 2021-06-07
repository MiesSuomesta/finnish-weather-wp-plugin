<?php
	/**
	 * @package finnish-weather-wp-plugin$
	 * @version 0.0.1a
	 */
	/*
	Plugin Name: finnish_weather_wp_plugin
	Plugin URI: http://paxsudos.fi/wp/finnish-weather-wp-plugin/
	Description: weather information plugin, at alfa state
	Author: Lauri Jakku
	Version: 0.0.1a
	Author URI: http://paxsudos.fi/
	*/

	$FINWEATHER_PLUGIN_DIR = dirname( __FILE__ ) . "/";

	function java_logger($txt)
	{
		$js = '<script>console.log(' . $txt . ');</script>';
		echo $js;
	}

	function get_file_base_http_address() {
		global $FINWEATHER_PLUGIN_DIR;

		$mydroot=$_SERVER['DOCUMENT_ROOT'];
		$myservername=$_SERVER['SERVER_NAME'];
		

		$mydocstr = str_replace($mydroot, "https://$myservername/", $FINWEATHER_PLUGIN_DIR);

/*
		java_logger("FINWEATHER_PLUGIN_DIR = $FINWEATHER_PLUGIN_DIR");
		java_logger("mydroot = $mydroot");
		java_logger("myservername = $myservername");
		java_logger("mydocstr = $mydocstr");
*/	

		$myret = $mydocstr . "/";

		return $myret;
	}

	$FINWEATHER_PLUGIN_DIR = dirname( __FILE__ ) . "/";
	$FINWEATHER_PLUGIN_URL = get_file_base_http_address();

	/* Login details */
	require_once ($FINWEATHER_PLUGIN_DIR . "php/login.inc");

	/* MYSQL stuff */
	require_once ($FINWEATHER_PLUGIN_DIR . "php/mysql.inc");


	function evaluate_file($f)
	{
		global $FINWEATHER_PLUGIN_URL;
		
		echo '<script src="' . $FINWEATHER_PLUGIN_URL . $f . '"></script>';
	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_header()
	{

		evaluate_file("php/header.php"); 

	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_body()
	{
		evaluate_file("php/body.php"); 
	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_shortcode()
	{

		evaluate_file("php/shortti.php"); 
	}

	// Now we set that function up to execute when the admin_notices action is called.
	add_action( 'wp_head', 			'finnish_weather_wp_plugin_header' 		);
	add_action( 'wp_body',		'finnish_weather_wp_plugin_body' 		);

	add_shortcode('finweather', 	'finnish_weather_wp_plugin_shortcode'	);

?>
 