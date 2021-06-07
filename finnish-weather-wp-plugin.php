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

	function evaluate_file($f)
	{
			$content = file_get_contents($f);

/*
		ob_start();
			include($f);
			$content = ob_get_clean();
		ob_start();
*/
		return $content;
	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_header()
	{
		global $FINWEATHER_PLUGIN_DIR;

		$startti='<meta startti="lja header" /> ';
		$koodi  = evaluate_file($FINWEATHER_PLUGIN_DIR . "php/header.php"); 
		$loppu  = '<meta stoppi="lja header" /> ';

		echo $startti . $koodi . $loppu;
	//	return $startti . $koodi . $loppu;

	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_body()
	{
		global $FINWEATHER_PLUGIN_DIR;

		$startti='<meta startti="lja body" /> ';
		$koodi  = evaluate_file($FINWEATHER_PLUGIN_DIR . "php/body.php"); 
		$loppu  = '<meta stoppi="lja body" /> ';

		echo $startti . $koodi . $loppu;
		return $startti . $koodi . $loppu;
	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_shortcode()
	{
		global $FINWEATHER_PLUGIN_DIR;

		$startti='<meta shortti="lja alkaa" /> ';
		$koodi = evaluate_file($FINWEATHER_PLUGIN_DIR . "php/shortti.php"); 
		$loppu = '<meta shortti="lja stoppaa" ';
		
		return $startti . $koodi . $loppu;
	}

	// Now we set that function up to execute when the admin_notices action is called.
	add_action( 'wp_head', 			'finnish_weather_wp_plugin_header' 		);
	add_action( 'body_class',		'finnish_weather_wp_plugin_body' 		);

	add_shortcode('finweather', 	'finnish_weather_wp_plugin_shortcode'	);

?>
 