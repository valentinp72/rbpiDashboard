<?php

if(isset($_POST)){

	require '../config/_config.php';

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

	// Update
	$query = "UPDATE devices SET
		name = '". $name ."',
		code = '". $code ."',
		prog_on_state = ". $prog_on_state .",
		prog_on_time = '". $prog_on_time ."',
		prog_off_state = ". $prog_off_state .",
		prog_off_time = '". $prog_off_time ."'
		WHERE id = ". $id . ";";

	$update = $DB->query($query);

}
else {
	echo "error";
}

?>
