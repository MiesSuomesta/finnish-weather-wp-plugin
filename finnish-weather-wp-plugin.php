<?php
	if (session_id() == '') { session_start(); }

	/**
	 * @package finnish-weather-wp-plugin
	 * @version 1.0.0
	 */
	/*
	Plugin Name: Finnish Weather WP Plugin
	Plugin URI: wordpress.org/plugins/finnish-weather-wp-plugin/
	Description: Finnish weather information map plugin
	Author: Lauri Jakku
	Version: 0.1.4
	Author URI: http://paxsudos.fi/
	*/

	/* common details */
	require_once("master_include.inc");

	function java_logger($txt)
	{
		$js = ' ?><script>console.log(' . $txt . ');</script><?php ';
		echo $js;
	}



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
		global $FINWEATHER_PLUGIN_URL;

		$ret = null;
		$fn = $FINWEATHER_PLUGIN_URL . "php/theMap.php";
		ob_start();
			echo "<iframe allowfullscreen='true' style='width:850px;height:730px;' src='$fn'/>";
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
 
