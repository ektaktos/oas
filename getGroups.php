<?php
// This page recieves a request from the tutor page and returns the groups for a course.
if (isset($_REQUEST['courseCode'])) {

require_once "Admin/connect.php";
	$courseCode = $_REQUEST['courseCode'];
	$selectSubmAssignment = "SELECT* FROM group_members WHERE courseCode = '$courseCode'";
	$result = $conn->query($selectSubmAssignment); 
		echo "<option value=''>--Select Group Name--</option>";
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<option value='".$row['members']."'>".$row['group_name']."</option>";
			}
		}else{
			echo "<option value=''>Groups Not available for Selected Course</option>";
		}
 }
 else{
 	echo "There was no request sent";
 } 
?>
