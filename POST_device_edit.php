<?php

$file = 'log.txt';
$current = file_get_contents($file);


if(isset($_POST)){

	require '_config.php';

	//
	// Get all data
	//

	$id             = $_POST['id'];
	$name           = $_POST['name'];
	$code           = $_POST['code'];
	$prog_on_state  = 0; // Initialization to 0 because if the checkbox is not checked, it won't exist
	$prog_on_time   = $_POST['prog_on_time'];
	$prog_off_state = 0; // Initialization to 0 because if the checkbox is not checked, it won't exist
	$prog_off_time  = $_POST['prog_off_time'];

	if(isset($_POST['prog_on_state'])){
		$prog_on_state = 1;
	}
	if(isset($_POST['prog_off_state'])){
		$prog_off_state = 1;
	}

	$current .= "PROG ON STATE : " . $prog_on_state . "\n";

	// Update
	$query = "UPDATE devices SET
		name = '". $name ."',
		code = '". $code ."',
		prog_on_state = ". $prog_on_state .",
		prog_on_time = '". $prog_on_time ."',
		prog_off_state = ". $prog_off_state .",
		prog_off_time = '". $prog_off_time ."'
		WHERE id = ". $id . ";";

	$current .= $query;
	$update = $DB->query($query);


	$current .= print_r($_POST, true);


}
else {
	echo "error";
}

file_put_contents($file, $current);

?>
