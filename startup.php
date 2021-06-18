
<?php
	if (session_id() == '') { session_start(); }
?>

<html>

<?php

	// var_dump($_POST);

	if ( ! isset($FINWEATHER_PLUGIN_DIR) )
		$FINWEATHER_PLUGIN_DIR = dirname( __FILE__ ) . "/";
	
	if ( ! isset($FINWEATHER_CONFIG_FILE) )
		$FINWEATHER_CONFIG_FILE = $FINWEATHER_PLUGIN_DIR . "finnish_weather_wp_plugin_config.json";

	/* Login details */
	require_once ($FINWEATHER_PLUGIN_DIR . "php/login.inc");

	/* MYSQL stuff */
	require_once ($FINWEATHER_PLUGIN_DIR . "php/mysql.inc");
	
	if (isset($_POST['submit']))
	{
		global $FINWEATHER_CONFIG_FILE;
		echo "<br>Doing setup......";

			$config['mysql']['$hostname'] 		= $_POST['hostname'];
			$config['mysql']['$databasename'] 	= $_POST['databasename'];
			$config['mysql']['$databasetable'] 	= $_POST['databasetable'];
			$config['mysql']['$username'] 		= $_POST['username'];
			$config['mysql']['$password'] 		= $_POST['password'];
			create_db_config($FINWEATHER_CONFIG_FILE, $config, 1);
			load_db_config($FINWEATHER_CONFIG_FILE);
			initialize_tables($config);

		echo "<br>Done setup......";
		
	}
	
?> 
<html>
	<center>
		<form action="#" method="post">
		<table>
			<tr clospan="3">
				<td clospan="3">
					<p><center>MySQL server details questions</center></p>
				</td>
			</tr>
			<tr>
				<td>
					<p>MySQL server hostname:</p>
				</td>
				<td width="10">
					&nbsp;
				</td>
				<td>
					<input type="text" placeholder="hostname name" name="hostname" required />
				</td>
			</tr>

			<tr>
				<td>
					<p>MySQL database name:</p>
				</td>
				<td width="10">
					&nbsp;
				</td>
				<td>
					<input type="text" placeholder="Name of the database" name="databasename" required />
				</td>
			</tr>

			<tr>
				<td>
					<p>MySQL database table name:</p>
				</td>
				<td width="10">
					&nbsp;
				</td>
				<td>
					<input type="text" placeholder="Name of the database table" name="databasetable" required />
				</td>
			</tr>

			<tr>
				<td>
					<p>MySQL username:</p>
				</td>
				<td width="10">
					&nbsp;
				</td>
				<td>
					<input type="text" placeholder="username" name="username" required />
				</td>
			</tr>
			<tr>
				<td>
					<p>MySQL user password:</p>
				</td>
				<td width="10">
					&nbsp;
				</td>
				<td>
					<input type="password" placeholder="Password" name="password" required />
				</td>
			</tr>
	

			<tr>
				<td colspan="3">
					<center>
						<button type="submit" name="submit">initialise</button>
					</center>
				</td>
			</tr>
		</table>
	</center>
	
	<br>
	<center>
	<p>Setup database update process: <br> echo "<?php echo " 17   * * * *  sudo -u www-data -- python3 $FINWEATHER_PLUGIN_DIR/download_to_sql_fi.py ";?>" &gt;&gt; /etc/crontab</p>
	</center>
</html>

