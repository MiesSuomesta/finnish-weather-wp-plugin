<html>
<?php

/* Login details */
include("login.inc");


function weather_get_weather_info_table_name()
{
	return $GLOBALS['mysql_weatherinfotable'];
}

function weather_do_mysql_query($query)
{
	$q = $query . ";";
	echo "Query: $q";

	$mysqli = new mysqli(	$GLOBALS['mysql_hostname'],
				$GLOBALS['mysql_username'],
				$GLOBALS['mysql_password'],
				$GLOBALS['mysql_databasename']);

	// Check connection
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}

	$result = $mysqli -> query($q);

	// Check connection
	if ($mysqli->connect_errno) {
		echo "Failed to request from MySQL: " . $mysqli->connect_error;
	}

	echo "<br>Query : $q";
	echo "<br>Result: $result<br>";

	$mysqli -> close();

	return $result;
}

function weather_get_mysql_data_last_record_number()
{
	$q = "select max(rec_nro) from " . weather_get_weather_info_table_name();	

	$res = weather_do_mysql_query($q);

	return $res;
}

$r = weather_get_mysql_data_last_record_number();

echo "JEES poks";

print_r($r);

?>
</html>



