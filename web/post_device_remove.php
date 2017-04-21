<?php

require '../config/_config.php';

if(!empty($_POST['id'])){
	// Get the id of the device
	sscanf($_POST['id'], "device_delete_%s", $id);

	if(is_numeric($id)){
		$update = $DB->query("UPDATE devices SET visible = 0 WHERE id = ".$id.";");
	}
	else {
		echo "Non-valid ID";
	}
}
else {
	echo "Non-valid ID";
}


?>
