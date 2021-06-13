<?php


	$allowed_referrers = [ "paxsudos.fi", "192.168.1.7" ];
	$ref = $_SERVER['HTTP_REFERER'];

	$cont = False;
	foreach ($allowed_referrers as $allowed) {
	
		$is= strpos($ref, $allowed);
		//echo "$allowed .... " . $is;
		
		if ($is > 0)
			$cont = True;
			
	}

	if ( ! $cont )
	{
		echo "Hot linking to this content is restricted. Contact lauri.jakku@paxsudos.fi to gain access.";
		exit(1);
	}
?>
 