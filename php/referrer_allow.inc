<?php

	//phpinfo();

	function getRemoteStr($rr, $rm)
	{
		$rv = $rr;
		if ( $rv == "" )
			$rv = $rm;
	}

	/* Update with your site/allowed referrers */
	$allowed_referrers = [ "paxsudos.fi", "paxsudos.com", "192.168." ];

	$referrer = $_SERVER['HTTP_REFERER'];
	$remote   = $_SERVER['REMOTE_ADDR'];

	$ref = getRemoteStr($referrer, $remote);

	$cont = False;
	$cont = True; // Allow by default if no modifications are done
	foreach ($allowed_referrers as $allowed) {
	
		$is= strpos($ref, $allowed);
		//echo "$allowed .... " . $is;
		
		if ($is >= 0)
			$cont = True;
			
	}

	if ( ! $cont )
	{
		echo "Hot linking to this content (from $ref) is restricted. Contact lauri.jakku@paxsudos.fi to gain access.";
		exit(1);
	}

?>
 
