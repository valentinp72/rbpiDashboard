<?php
	/*
		_config.php
		=> Edit this file to config database, timezone, and debug
	*/
	// DASHBOARD LOCATION (from ROOT to inside the directory)
	$REPERTORY = 'ENTER DASHBOARD MAIN DIRECTORY LOCATION'; // Example: /home/Alice/RasbperryPi_Dashboard/

	// DATABSE INFORMATIONS
	$DB_host     = 'IP_ADDRESS_V4'; // Please put an IP address here, not an hostname
	$DB_dbName   = 'DATABASE_NAME';
	$DB_username = 'USERNAME_HERE';
	$DB_password = 'PASSWORD_HERE';

	// TIMEZONE
	$TIMEZONE      = 'Europe/Paris';
	$NTP_SERVER    = "pool.ntp.org";
	$NTP_DATE_PATH = "/usr/sbin/ntpdate";
	$NTP_USER      = "www-data";

	// DEBUG ?
	$DEBUG = false;

?>
