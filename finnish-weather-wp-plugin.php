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

	/* Login details */
	require_once ($FINWEATHER_PLUGIN_DIR . "php/login.inc");

	/* MYSQL stuff */
	require_once ($FINWEATHER_PLUGIN_DIR . "php/mysql.inc");

	function get_file_base_http_address() {
		myserv=$_SERVER[''];
	}

	function evaluate_file($f)
	{
		global $FINWEATHER_PLUGIN_DIR;
		
//		echo '<script src="' . $FINWEATHER_PLUGIN_DIR . $f . '"></script>';

		
		
	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_header()
	{
		global $FINWEATHER_PLUGIN_DIR;

		evaluate_file("php/header.php"); 

	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_body()
	{
		global $FINWEATHER_PLUGIN_DIR;

		evaluate_file("php/body.php"); 
	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_shortcode()
	{
		global $FINWEATHER_PLUGIN_DIR;

		evaluate_file("php/shortti.php"); 
	}

	// Now we set that function up to execute when the admin_notices action is called.
	add_action( 'wp_head', 			'finnish_weather_wp_plugin_header' 		);
	add_action( 'body_class',		'finnish_weather_wp_plugin_body' 		);

	add_shortcode('finweather', 	'finnish_weather_wp_plugin_shortcode'	);

	print_r($_SERVER);

?>
 