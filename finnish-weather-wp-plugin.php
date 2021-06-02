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
include ($FINWEATHER_PLUGIN_DIR . "php/login.inc");

// This just echoes the chosen line, we'll position it later.
function finnish_weather_wp_plugin_header()
{

	global $FINWEATHER_PLUGIN_DIR;

	$contents = file_get_contents ($FINWEATHER_PLUGIN_DIR . "php/saa-osm-fi-header.inc"); 
	$thehtml = 	"<head>\n" . $contents . "</head>\n";

	return $thehtml;
}

function finnish_weather_wp_plugin_body()
{

	global $FINWEATHER_PLUGIN_DIR;

	$contents = file_get_contents ($FINWEATHER_PLUGIN_DIR . "php/saa-osm-fi-body.inc"); 
	$thehtml = 	"<body>\n" . $contents . "</body>\n";

	return $thehtml;
}

// This just echoes the chosen line, we'll position it later.
function finnish_weather_wp_plugin_shortcode()
{

	global $FINWEATHER_PLUGIN_DIR;

	$theH = file_get_contents ($FINWEATHER_PLUGIN_DIR . "php/saa-osm-fi-header.inc");
	$theB = file_get_contents ($FINWEATHER_PLUGIN_DIR . "php/saa-osm-fi-body.inc");

//	return $theB;
	return $theH . $theB;
}

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'wp_head ', 'finnish_weather_wp_plugin_header' );
add_action( 'wp', 'finnish_weather_wp_plugin_body' );

add_shortcode('finweather', 'finnish_weather_wp_plugin_shortcode');


