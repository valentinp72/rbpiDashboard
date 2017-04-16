<?php

$DB_host     = 'HOSTNAME_HERE';
$DB_dbName   = 'DATABASE_NAME';
$DB_username = 'USERNAME_HERE';
$DB_password = 'PASSWORD_HERE';

try {
	$DB = new PDO('mysql:host='.$DB_host.';dbname='.$DB_dbName.';charset=utf8', $DB_username, $DB_password);
}
catch(Exception $error){
	die('Cannot connect to database: ' . $error->getMessage());
}

?>
