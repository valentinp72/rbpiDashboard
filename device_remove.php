<?php

require '_config.php';

if(!empty($_POST['id'])){
	// Last value of the device
	$id = substr($_POST['id'], -1);
	
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
