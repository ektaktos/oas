<?php
// die(var_dump($_REQUEST[MatricNum]));
	require_once 'connect.php';
	$conn->query("DELETE FROM `student` WHERE `MatricNum` = '$_REQUEST[MatricNum]'") or die(mysqli_error());
	header('location: student.php');
?>