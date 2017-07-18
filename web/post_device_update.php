<?php
	/*
		post_device_update.php
		=> Update a device state according to POST datas
	*/

	require '../config/include.php';

	function execCommandDotPhp($command, $devicesID, $origin){
		global $config;

		$cmd = $config['repertory']. "supervisor/command.php command=". $command ." devices=" . $devicesID . " origin=" . $origin;
		echo $cmd . "\n";
		echo exec($cmd) . "\n";
	}

	//
	// Number of devices in database
	//
	$query = $DB->query('SELECT COUNT(*) FROM devices');
	$data = $query->fetch();

	$nbDevices = $data[0];
	$current = $nbDevices . " devices in database\n";

	//
	// Construction of the devices states
	//
	$devices = [];
	array_push($devices, $nbDevices); // To start the devices in the array at the index 1

	for($i = 1 ; $i <= $nbDevices ; $i++){

		if(isset($_GET[$i])){
			$state = 1;
		}
		else {
			$state = 0;
		}

		array_push($devices, $state);
	}

	//
	// Update of changed devices states
	//
	$query = $DB->query('SELECT id, state FROM devices ORDER BY id');
	$i = 1;
	while($data = $query->fetch()){
		if($data['state'] != $devices[$i]){
			// We changed the device $i

			if($devices[$i] == 1)
				execCommandDotPhp("ON", $data['id'], "MANUAL");
			else
				execCommandDotPhp("OFF", $data['id'], "MANUAL");

		}
		$i++;
	}



?>
