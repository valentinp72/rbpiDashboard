<?php
	/*
		post_device_edit.php
		=> Edit a device according to POST datas
	*/

	if(isset($_POST)){

		require '../config/include.php';

		//
		// Get all data
		//

		$id             = $_POST['id'];
		$name           = $_POST['name'];
		$code_on        = $_POST['code_on'];
		$code_off       = $_POST['code_off'];
		$button_mac     = $_POST['button_mac'];

		$prog_on_state      = 0; // Initialization to 0 because if the checkbox is not checked, it won't exist
		$prog_on_time       = $_POST['prog_on_time'];
		$prog_on_code       = $_POST['prog_on_code'];
		$prog_on_persistent = 0; // Initialization to 0 because if the checkbox is not checked, it won't exist

		$prog_off_state      = 0; // Initialization to 0 because if the checkbox is not checked, it won't exist
		$prog_off_time       = $_POST['prog_off_time'];
		$prog_off_code       = $_POST['prog_off_code'];
		$prog_off_persistent = 0; // Initialization to 0 because if the checkbox is not checked, it won't exist


		if(isset($_POST['prog_on_state'])){
			$prog_on_state = 1;
		}
		if(isset($_POST['prog_off_state'])){
			$prog_off_state = 1;
		}
		if(isset($_POST['prog_on_persistent'])){
			$prog_on_persistent = 1;
		}
		if(isset($_POST['prog_off_persistent'])){
			$prog_off_persistent = 1;
		}

		// Update
		$query = "UPDATE devices SET
			name = '". $name ."',
			code_on = '". $code_on ."',
			code_off = '". $code_off ."',
			button_mac = '". $button_mac ."',

			prog_on_state = ". $prog_on_state .",
			prog_on_time = '". $prog_on_time ."',
			prog_on_code = '". $prog_on_code ."',
			prog_on_persistent = ". $prog_on_persistent .",

			prog_off_state = ". $prog_off_state .",
			prog_off_time = '". $prog_off_time ."',
			prog_off_code = '". $prog_off_code ."',
			prog_off_persistent = ". $prog_off_persistent ."
			
			WHERE id = ". $id . ";";

		$update = $DB->query($query);

		// Restart the button server:
		exec("sudo -u " . $config['ntp']['user'] . " systemctl restart buttonsServer.service");

	}
	else {
		echo "error";
	}

?>
