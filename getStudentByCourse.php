<?php
// This page recieves a request from the tutor page and returns the assignments for a tutor.
if (isset($_REQUEST['courseCode'])) {

require_once "Admin/connect.php";
	$courseCode = $_REQUEST['courseCode'];
	$selectSubmAssignment = "SELECT courses,MatricNum,Name FROM student";
	$result = $conn->query($selectSubmAssignment); 
	while ($row = $result->fetch_assoc()) {
		$course = json_decode($row['courses']);
		foreach ($course as $key => $value) {
		if ($value == $courseCode) {
			echo "<input type='checkbox' name='students[]' value='".$row['MatricNum']."'><label>".$row['Name']."</label>";
		}	
		}
	}
 }
 else{
 	echo "There was no request sent";
 } 
?>
