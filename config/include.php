<?php
	/*
		include.php
		=> File to include to have database access, time, ...
	*/

	require_once '_config.php';

	try {
		$DB = new PDO('mysql:host='.$DB_host.';dbname='.$DB_dbName.';charset=utf8', $DB_username, $DB_password);
	}
	catch(Exception $error){
		die('Cannot connect to database: ' . $error->getMessage());
	}

	if($debug){
		$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	if(!ini_get('date.timezone')){
		if(!date_default_timezone_set($timezone)){
			echo "Non valid timezone in config/_config.php";
			exit(1);
		}
	}

?>
