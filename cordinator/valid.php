<?php
	require_once '../Admin/connect.php';
	session_start();
	if(!ISSET($_SESSION['oas_adminuser'])){
		header('location:index.php');
	}
?>