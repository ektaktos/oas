<?php
$conn = mysqli_connect('localhost', 'root', 'password', 'oas');

if(isset($_POST["courseName"], $_POST["courseCode"], $_POST["unit"], $_POST["level"], $_POST["semester"]))
{
	// die(var_dump($_POST['courseCode'], $_POST['courseName'], $_POST['unit'], $_POST['level'], $_POST['semester']));
	$courseCode = mysqli_real_escape_string($conn, $_POST["courseCode"]);
	$courseName = mysqli_real_escape_string($conn, $_POST["courseName"]);
	$unit = mysqli_real_escape_string($conn, $_POST["unit"]);
	$level = mysqli_real_escape_string($conn, $_POST["level"]);
	$semester = mysqli_real_escape_string($conn, $_POST["semester"]);
	$r_coursecode = str_replace(' ', '_', $courseCode);
	$query = "INSERT INTO course(courseCode, courseName, unit, level, semester) VALUES('$r_coursecode', '$courseName', '$unit', '$level', '$semester')";
	$courseCode = mysqli_real_escape_string($conn, $_POST["courseCode"]);
	if(mysqli_query($conn, $query))
	{
		echo 'data inserted';
	}
}

?>