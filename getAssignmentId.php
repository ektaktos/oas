<?php
// This page recieves a request from the tutor page and returns the assignments for a tutor. 

require_once "Admin/connect.php";
$course = $_REQUEST['courseCode'];
$tutorId = $_REQUEST['tutorId'];
// $courseCode = str_replace('_',' ',$course);
 // Mysql Query to select all the assignments from database
	$selectSubmAssignment = "SELECT assignmentId FROM assignmentdetails WHERE courseCode = '$course' AND tutorId = '$tutorId'";
	$result = $conn->query($selectSubmAssignment); 
	echo"<option value=''>--Select Assignment--</option>";

	while ($row = $result->fetch_assoc()) {

		echo "<option value=".$row['assignmentId'].">".$row['assignmentId']."</option>";
	}

?>