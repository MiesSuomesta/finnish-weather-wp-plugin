<?php

/*
	Plugin Name: Finnish Weather
	Plugin URI: wordpress.org/plugins/finnish-weather/
	Description: Finnish weather information map plugin that is very lightwheight. Donate if you like the plugin: https://gofund.me/0403326f
	Version: 2.6.1
	Stable version: 2.6.1
	Tested up to: 5.7.2
	Author: Lauri Jakku
	Author URI: http://paxsudos.fi/
*/

	/* common details (database config name etc. ) */
	require_once("php/master_include.inc");

	function get_plugin_file_https_address($pf) {
		global $FINWEATHER_PLUGIN_URL;
		$myret = $FINWEATHER_PLUGIN_URL . "/" . $pf;
		return $myret;
	}

	/* Login details */
	require_once ("php/login.inc");

	/* MYSQL stuff */
	require_once ("php/mysql.inc");


	// This just echoes the chosen line, we'll position it later.
	function finnish_weather_wp_plugin_header()
	{
	}

	function finnish_weather_wp_plugin_body()
	{
	}

	function finnish_weather_wp_plugin_shortcode()
	{
		global $FINWEATHER_PLUGIN_URL;

		$ret = null;
		$fn = $FINWEATHER_PLUGIN_URL . "/theMap.php";
		$ret = "<iframe allowfullscreen='true' style='width:850px; height:730px;' src='$fn'></iframe>";
		return $ret;
	}

	function finweather_validate_submission($pPostArray)
	{
		$rv = false;
		
		if ( is_array($pPostArray) )
		{
			$arrv = true;
			$idx = len($pPostArray);
			while ( $idx > 0 )
			{
				$inx--;
				$arrv &= is_integer($pPostArray[$idx]);
			}

			$rv = $arrv;
		}

		return $rv;
	}

	function finweather_submit_func()
	{
		// Validate here
		if ( ! finweather_validate_submission($_POST['stations']) )
			return False;
		
		$post = $_POST['stations'];
		$postjson = json_encode($post);
		
		//echo "SUBMIT FUNC POST: '$postjson' \n";
		return $postjson; 
	}

	function startup()
	{
		global $FINWEATHER_CONFIG_FILE;
		global $FINWEATHER_MYSQL_CONFIG;
		
		if (! file_exists($FINWEATHER_CONFIG_FILE) )
		{
			// Installation helper 
			include_once("startup.php");

		} else {
			
			$config = load_db_config($FINWEATHER_CONFIG_FILE);

			//var_dump($config);

			$h   = $config['hostname'];
			$dbn = $config['databasename'];
			$dbt = $config['databasetable'];
			$u   = $config['username'];
			$p   = $config['password'];

			//echo "<br>[Main] Loaded MySQL config ${u}@${h}/${dbn}.${dbt}";


			// Now we set that function up to execute when the admin_notices action is called.
			add_action( 'wp_head', 			'finnish_weather_wp_plugin_header' 		);

			//add_action( 'wp_body',		'finnish_weather_wp_plugin_body' 		);

			// Add actions for form -----------------------------
			// add_action( 'admin_post_nopriv',						'finweather_submit_func'	);
			// add_action( 'admin_post_nopriv_finweather_submit',	'finweather_submit_func'	);
			// add_action( 'admin_post',							'finweather_submit_func'	);
			// add_action( 'admin_post_finweather_submit',			'finweather_submit_func'	);

			add_shortcode('finweather', 	'finnish_weather_wp_plugin_shortcode'	);
		}
	}

	startup();

?> 
 
