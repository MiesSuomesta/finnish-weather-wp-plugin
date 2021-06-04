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
	include_once ($FINWEATHER_PLUGIN_DIR . "php/login.inc");

	/* MYSQL stuff */
	include_once ($FINWEATHER_PLUGIN_DIR . "php/mysql.inc");


	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_header()
	{

		global $FINWEATHER_PLUGIN_DIR;

		include_once($FINWEATHER_PLUGIN_DIR . "php/header.php"); 
	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_shortcode()
	{

		global $FINWEATHER_PLUGIN_DIR;

		echo "<p>BODY start</p>";
		$thefilestr = file_get_contents($FINWEATHER_PLUGIN_DIR . "php/body.php"); 
		$thestr = $thefilestr;
		echo $thestr;
		echo "<p>BODY end</p>";

	}

	// Now we set that function up to execute when the admin_notices action is called.
	add_action( 'wp_head', 		'finnish_weather_wp_plugin_header' 	);

	add_shortcode('finweather', 'finnish_weather_wp_plugin_shortcode');

?>
 