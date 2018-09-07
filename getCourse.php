<?php
// This page recieves a request from the tutor page and returns the courses for a particular tutor. 
require_once "Admin/connect.php";
 $tutorId = $_REQUEST['tutorId'];
 $queryCourses = "SELECT courses FROM tutor WHERE StaffId = '$tutorId'";
  $resultCourses = $conn->query($queryCourses);
  echo"<option value=''>--Select Course--</option>";
  while ($row = $resultCourses->fetch_assoc()) {
    $courses = $row['courses'];
  }
  $course = json_decode($courses);

  foreach ($course as $key) {
     $keyval = str_replace(' ','_',$key);
     echo "<option value=".str_replace(' ','_',$key).">".$key."</option>";
  }

  return;

?>
