<html>
<?php

/* Login details */
include("login.inc");
/* Login details 
	global $GLOBAL_hostname;
	global $GLOBAL_username;
	global $GLOBAL_password;
	global $GLOBAL_weatherinfotable;
*/


function weather_do_mysql_query($query)
{

	$mysqli = new mysqli($GLOBAL_hostname, $GLOBAL_username, $GLOBAL_password, $GLOBAL_weatherinfotable);

	// Check connection
	if ($mysqli -> connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
		exit();
	}

	$result = $mysqli -> query($query);

	$mysqli -> close();

	return $result;
}

function weather_get_mysql_data_last_record_number()
{
	$q = "select * from $GLOBAL_weatherinfotable";	

	$r = weather_do_mysql_query($q);

	print($r);
}

weather_get_mysql_data_last_record_number();

?>
</html>



