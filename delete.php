<?php
require_once 'Admin/connect.php';

if (isset($_POST['id'])) {
	$db = $_POST['db'];
	$id = $_POST['id'];

	// Writing the delete query
	$query = "UPDATE ".$db." SET visible = '0' WHERE sn = '".$id."' ";
	$result = $conn->query($query);
	if ($result) {
		return 'Hello there';
	}
	else{
		return 'Hello there there';
	}

}

?>