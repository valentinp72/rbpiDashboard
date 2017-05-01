#!/usr/bin/php
<?php
	/*
		command.php
		=> Turn on or off a device
	*/

	require __DIR__ . '/../config/include.php';
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
	function getCode($device, $origin, $command){
		if($origin == 'PROG_ON')
			return $device['prog_on_code'];
		if($origin == 'PROG_OFF')
			return $device['prog_off_code'];

		if($command == 'ON')
			return $device['code_on'];
		return $device['code_off'];
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
   			$elems = explode('=', $arg);
			if(count($elems) == 2){
   				$values["$elems[0]"] = $elems[1];
			}
		}

		$nb = count($values);
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
		// Get device infos
		$device = getDeviceInfo($id);
		$code = getCode($device, $origin, $command);

		// Exec the command to transmit the code to the device
		$cmd = "sudo " . $REPERTORY. "supervisor/emit " . $code;
		echo $cmd . "\n";
		echo exec($cmd) . "\n";

		// Switch back to false the prog_x_state if it was not persistant
		if($origin == "PROG_ON" && $device['prog_on_persistent'] == 0)
			$update = $DB->query("UPDATE devices SET prog_on_state = 0 WHERE id = ". $id);
		else if($origin == "PROG_OFF" && $device['prog_off_persistent'] == 0)
			$update = $DB->query("UPDATE devices SET prog_off_state = 0 WHERE id = ". $id);

		// Turn on or off the device state in DB
		if($command == "ON")
			$update = $DB->query("UPDATE devices SET state = 1 WHERE id = ". $id);
		else
			$update = $DB->query("UPDATE devices SET state = 0 WHERE id = ". $id);
	}

	echo "\n";
?>
