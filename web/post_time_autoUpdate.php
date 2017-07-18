<?php
	/*
		post_time_autoUpdate.php
		=> Update time with ntpdate
	*/

	require '../config/include.php';

	$command = "sudo -u " . $config['ntp']['user'] . " " . $config['ntp']['date_path'] . " -u " . $config['ntp']['server'];

	$resultat = exec($command, $output, $return);

	if(!$return)
		echo "La date et l'heure à bien été à jour.";
	else
		echo "Error: " . $command;



?>
