#!/usr/bin/php
<?php
	/*
		checker.php
		=> Check if we need to turn on or turn off a device
	*/

	require '../config/include.php';

	// Returns all devices that match the $time_columnName, $prog_state and $active
	// ==> All devices that should be activated of disactivated according to the DB
	function getDevices($time_columnName, $time_start, $time_end, $prog_state, $active){
		global $DB;

		$response = $DB->query
			('SELECT * FROM devices
				WHERE
					'. $prog_state .' = 1
				AND
					state = '. $active .'
				AND
					'. $time_columnName .' BETWEEN "'. $time_start .'" AND "'. $time_end .'"
			');

		return $response->fetchAll();
	}

	function getIds($devices){
		$ids = '';

		foreach ($devices as $key => $value) {
			$ids .= $value['id'] . ",";
		}

		$ids = rtrim($ids, ',');

		return $ids;
	}

	function execCommandDotPhp($command, $devicesID, $origin){
		global $REPERTORY;

		$cmd = $REPERTORY. "supervisor/command.php command=". $command ." devices=" . $devicesID . " origin=" . $origin;
		echo $cmd . "\n";
		echo exec($cmd) . "\n";
	}


	$date = getdate();
	$minuteStart = sprintf("%d:%d:0", $date['hours'], $date['minutes']);
	$minuteEnd   = sprintf("%d:%d:59", $date['hours'], $date['minutes']);

	// Debug
	//$minuteStart = "19:24:00";
	//$minuteEnd   = "19:24:59";

	echo "\nWe are checking for devices between " . $minuteStart . " and " . $minuteEnd . ".\n";

	$devicesMustTurnOn  = getDevices("prog_on_time", $minuteStart, $minuteEnd, "prog_on_state", 0);
	$devicesMustTurnOff = getDevices("prog_off_time", $minuteStart, $minuteEnd, "prog_off_state", 1);

	echo "\nDevices that must be turned on  : ";
	$idsON = getIds($devicesMustTurnOn);
	echo $idsON . "\n";
	if(!empty($idsON))
		execCommandDotPhp("ON", $idsON, "PROG_ON");

	echo "\nDevices that must be turned off : ";
	$idsOFF = getIds($devicesMustTurnOff);
	echo $idsOFF . "\n";
	if(!empty($idsOFF))
		execCommandDotPhp("OFF", $idsOFF, "PROG_OFF");

	echo "\n";
?>
