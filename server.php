<?php 
session_start();
require_once "Admin/connect.php";
$email = "";
$matricNum = "";
$errors = array();


// if the registration button is clicked
if (isset($_POST['register'])) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$matricNum = $_POST['matric_num'];
	$password_1 = $_POST['password_1'];
	$password_2 = $_POST['password_2'];
	$Name = $firstname . ' ' . $lastname;
	
	// ensure that form fields are filled properly
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($matricNum)) {
		array_push($errors, "Matric Number is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}

	if ($password_1 != $password_2) {
		array_push($errors, "The passwords do not match");
	}

	// if there are no errors, save user to database
	if (count($errors) == 0) {
		$salt1 = "qm&h*";
		$salt2 = "pg!@";
		$passwrd = hash('ripemd128', "$salt1$password_1$salt2");// encrypt password before storing into database (security)
		$sql = "INSERT INTO `student`(`Name`, `MatricNum`, `phone`, `email`, `password`) VALUES ('$Name', '$matricNum', '$phone', '$email', '$passwrd')";
		mysqli_query($conn, $sql);
		$_SESSION['matricNum'] = $matricNum;
		header('location:index.php');
		
	}	
}
?>