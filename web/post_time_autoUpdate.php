<?php
	/*
		post_time_autoUpdate.php
		=> Update time with ntpdate
	*/

	require '../config/include.php';

	$command = "sudo -u " . $NTP_USER . " " . $NTP_DATE_PATH . " -u " . $NTP_SERVER;

	$resultat = exec($command, $output, $return);

	if(!$return)
		echo "La date et l'heure à bien été à jour.";
	else
		echo "Error: " . $command;



?>
