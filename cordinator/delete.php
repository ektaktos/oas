<?php 
// Delete.php
$conn = mysqli_connect('localhost', 'root', 'password', 'oas');
// die(var_dump($_POST["id"]));
if(isset($_POST["sn"]))
{
	$query = "DELETE FROM course WHERE sn = '".$_POST["sn"]."'";
	if(mysqli_query($conn, $query))
	{
		echo 'Data Deleted';
	}
}
?>