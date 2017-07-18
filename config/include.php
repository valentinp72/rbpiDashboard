<?php
	/*
		include.php
		=> File to include to have database access, time, ...
	*/

	//require_once '_config.php';
	$configFile = file_get_contents(__DIR__ . '/_config.json');
	$config = json_decode($configFile, true); 

	if($configFile === False)
		die("Could not load config file!");

	// Add / to the end of REPERTORY
	if(substr($config['repertory'], -1) != '/') {
	    $config['repertory'] .= '/';
	}

	// Connect to database
	try {
		$DB = new PDO('mysql:
						host='.$config['database']['host'].';
						dbname='.$config['database']['name'].';
						charset=utf8', 
						$config['database']['username'], 
						$config['database']['password']);
	}
	catch(Exception $error){
		die('Cannot connect to database: ' . $error->getMessage());
	}

	// Enable MYSQL debug
	if($config['debug']){
		$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	// Init timezone
	if(!ini_get('date.timezone')){
		if(!date_default_timezone_set($config['ntp']['timezone'])){
			echo "Non valid timezone in config/_config.json";
			exit(1);
		}
	}

?>
