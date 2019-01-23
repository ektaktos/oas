<?php
//update.php
$conn = mysqli_connect('localhost', 'root', 'password', 'oas');
// die(var_dump($_POST["sn"], $_POST["value"]));
if(isset($_POST["sn"]))
{

	$value = mysqli_real_escape_string($conn, $_POST["value"]);
	$query = "UPDATE course SET ".$_POST["column_name"]."='".$value."' WHERE sn = '".$_POST["sn"]."'";
	// die(var_dump($query));
	if(mysqli_query($conn, $query))
	{
		echo 'Data Updated';
	}
}
?>