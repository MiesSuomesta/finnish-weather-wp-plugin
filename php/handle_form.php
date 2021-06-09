<?php

	/* Login details */
	require_once("login.inc");

	/* SQL details */
	require_once("mysql.inc");	

	require_once("header-functions.inc");
	
	require_once("body_selection_generate.inc");

			
	comment("LJA A1");
	var_dump($_POST);
	comment("LJA A2");
	var_dump($_GET);
	comment("LJA A3");
	var_dump($_SESSION);

	$post = do_action('finweather_submit', $_GET);
	comment("LJA B: '$post'");
	$postObj = json_decode($post);

?>
