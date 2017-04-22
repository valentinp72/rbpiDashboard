#!/usr/bin/php
<?php
	/*
		command.php
		=> Turn on or off a device
	*/

	require '../config/include.php';
	$args_requiredNB = 3;

	// Returns all device info that match $id id
	function getDeviceInfo($id){
		global $DB;

		$response = $DB->query
			('SELECT * FROM devices
				WHERE
					id = '. $id .'
			');

		return $response->fetch();
	}

	// Get device code according to the origin of the command
	function getCode($device, $origin){
		if($origin == 'PROG_ON')
			return $device['prog_on_code'];
		if($origin == 'PROG_OFF')
			return $device['prog_off_code'];

		return $device['code'];
	}


	//
	// Get arguments from $_GET or $argv
	//
	if($_GET){
		$values = $_GET;
		$nb = count($values);
	}
	else {
		$arguments = $argv;
		$values = array();

		foreach($arguments as $arg){
   			list($x, $y) = explode('=', $arg);
   			$values["$x"] = $y;
		}

		$nb = count($values) - 1;
	}

	$command   = $values['command'];               // ON or OFF
	$devices   = explode(',', $values['devices']); // Array of devices IDs
	$nbDevices = count($devices);                  // Number of devices
	$origin    = $values['origin'];                // PROG_ON, PROG_OFF, or MANUAL

	// Check parameters
	if($nb != $args_requiredNB)
		die($nb . " arguments given, " . $args_requiredNB ." expecting.\n");
	if(empty($devices))
		die("No devices given\n");
	if($command != "ON" && $command != "OFF")
		die("Non-valid command [ON/OFF]");
	if($origin != "PROG_ON" && $origin != "PROG_OFF" && $origin != "MANUAL")
		die("Non-valid origin [PROG_ON/PROG_OFF/MANUAL]");

	// Turn on or off all devices
	foreach ($devices as $id) {
		$device = getDeviceInfo($id);
		$code = getCode($device, $origin);
		$cmd = $REPERTORY. "supervisor/emit " . $command . " " . $code;
		echo $cmd;
		echo "\n";
		echo exec($cmd);
		echo "\n";

	}

	echo "\n";
?>
