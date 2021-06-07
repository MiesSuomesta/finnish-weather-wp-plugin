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
		java_logger("FINWEATHER_PLUGIN_DIR = $FINWEATHER_PLUGIN_DIR"); echo "\n";
		java_logger("mydroot = $mydroot"); echo "\n";
		java_logger("myservername = $myservername"); echo "\n";
		java_logger("mydocstr = $mydocstr"); echo "\n";
*/

		$myret = $mydocstr;

		return $myret;
	}

	$FINWEATHER_PLUGIN_DIR = dirname( __FILE__ ) . "/";
	$FINWEATHER_PLUGIN_URL = get_file_base_http_address();

	function get_plugin_file_https_address($pf) {
		global $FINWEATHER_PLUGIN_URL;

/*
		java_logger("FINWEATHER_PLUGIN_DIR = $FINWEATHER_PLUGIN_DIR"); echo "\n";
		java_logger("mydroot = $mydroot"); echo "\n";
		java_logger("myservername = $myservername"); echo "\n";
		java_logger("mydocstr = $mydocstr"); echo "\n";
*/

		$myret = $FINWEATHER_PLUGIN_URL . "/" . $pf;

		return $myret;
	}

	/* Login details */
	require_once ($FINWEATHER_PLUGIN_DIR . "php/login.inc");

	/* MYSQL stuff */
	require_once ($FINWEATHER_PLUGIN_DIR . "php/mysql.inc");


	function evaluate_file($f, $ft="text/javascript")
	{
		global $FINWEATHER_PLUGIN_URL;
		
		echo '<script src="' . $FINWEATHER_PLUGIN_URL . $f . '" type="' . $ft . '"></script>';
	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_header()
	{

		evaluate_file("php/header.php", "text/html"); 

	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_body()
	{
		evaluate_file("php/body.php", "text/html"); 
	}

	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_shortcode()
	{
		$fn1 = "./php/body_selection_generate.inc";
		$fn2 = "./php/shortti.php";
		$fn1 = get_plugin_file_https_address("php/body_selection_generate.inc");
		$fn2 = get_plugin_file_https_address("php/shortti.php");

		
		$tagi1 = "<script nimi='shortti 1' fn='$fn1' src='$fn1' type='text/javascript'> ";
		$tagi2 = "<script nimi='shortti 2' fn='$fn2' src='$fn2' type='text/php'> ";
		
		$st1 = "";
		$st2 = "";

/*		
		$ret = "";
		$ret = $ret . $tagi1 . $st1 . file_get_contents($fn1) . "</script>";
		$ret = $ret . $tagi2 . $st2 . file_get_contents($fn2) . "</script>";
*/

		$ret = "";
		$ret = $ret . $tagi1 . $st1 . "</script>";
		$ret = $ret . $tagi2 . $st2 . "</script>";
		
		return $ret; 
	}

	// Now we set that function up to execute when the admin_notices action is called.
	add_action( 'wp_head', 			'finnish_weather_wp_plugin_header' 		);
	add_action( 'wp_body',		'finnish_weather_wp_plugin_body' 		);

	add_shortcode('finweather', 	'finnish_weather_wp_plugin_shortcode'	);

?>
 