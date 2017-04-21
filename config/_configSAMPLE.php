<?php

// DATABSE INFORMATIONS
$DB_host     = 'IP_ADDRESS_V4'; // Please put an IP address here, not an hostname
$DB_dbName   = 'DATABASE_NAME';
$DB_username = 'USERNAME_HERE';
$DB_password = 'PASSWORD_HERE';

// TIMEZONE
$timezone = 'Europe/Paris';

// DEBUG ?
$debug = true;

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
