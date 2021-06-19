<?php
	if (session_id() == '') { session_start(); }

	/**
	 * @package finnish-weather-wp-plugin
	 * @version 2.1
	 */
	/*
	Version: 2.1
	Plugin Name: Finnish Weather WP Plugin
	Plugin URI: wordpress.org/plugins/finnish-weather-wp-plugin/
	Description: Finnish weather information map plugin that is very lightwheight. Donate if you like: https://gofund.me/0403326f
	Author: Lauri Jakku
	Author URI: https://paxsudos.fi/
	*/

	/* common details (database config name etc. ) */
	require_once("php/master_include.inc");

	function java_logger($txt)
	{
		$js = ' ?><script>console.log(' . $txt . ');</script><?php ';
		echo $js;
	}

	/* Login details */
	require_once ("php/login.inc");

	/* MYSQL stuff */
	require_once ("php/mysql.inc");


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
		global $FINWEATHER_PLUGIN_URL;

		$ret = null;
		$fn = $FINWEATHER_PLUGIN_URL . "php/theMap.php";
		ob_start();
			echo "<iframe allowfullscreen='true' style='width:850px; height:730px;' src='$fn'/>";
		$ret = ob_get_clean();
		return $ret;
	}

	function finweather_submit_func()
	{
		$post = $_POST['stations'];
		$postjson = json_encode($post);
		
		echo "SUBMIT FUNC POST: '$postjson' \n";
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
 
