<?php
	/*
		include.php
		=> File to include to have database access, time, ...
	*/

	require_once '_config.php';

	// Add / to the end of REPERTORY
	if(substr($REPERTORY, -1) != '/') {
	    $REPERTORY .= '/';
	}

	// Connect to database
	try {
		$DB = new PDO('mysql:host='.$DB_host.';dbname='.$DB_dbName.';charset=utf8', $DB_username, $DB_password);
	}
	catch(Exception $error){
		die('Cannot connect to database: ' . $error->getMessage());
	}

	// Enable MYSQL debug
	if($DEBUG){
		$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	// Init timezone
	if(!ini_get('date.timezone')){
		if(!date_default_timezone_set($TIMEZONE)){
			echo "Non valid timezone in config/_config.php";
			exit(1);
		}
	}

?>
