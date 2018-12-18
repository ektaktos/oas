<?php
// This page recieves a request from the student page and returns the courses for a particular semester. 
require_once "Admin/connect.php";
 $semester_level = $_REQUEST['semester'];
 if ($semester_level == '1.1') {
   $semester = 1;
   $level = 100;
 }
 elseif ($semester_level == '1.2') {
   $semester = 2;
   $level = 100;
 }
 elseif ($semester_level == '2.1') {
   $semester = 1;
   $level = 200;
 }
 elseif ($semester_level == '2.2') {
   $semester = 2;
   $level = 200;
 }
 elseif ($semester_level == '3.1') {
   $semester = 1;
   $level = 300;
 }
 elseif ($semester_level == '3.2') {
   $semester = 2;
   $level = 300;
 }
 elseif ($semester_level == '4.1') {
   $semester = 1;
   $level = 400;
 }
 elseif ($semester_level == '4.2') {
   $semester = 2;
   $level = 400;
 }
            echo "<tr>";
              echo "<td>COURSE CODE</td>";
              echo "<td>COURSE NAME</td>";
              echo "<td>UNIT</td>";
              echo "<td>CHOICE</td>";
            echo "</tr>";
 $queryCourses = "SELECT * FROM course WHERE level = '$level' AND semester = '$semester'";
 $resultCourses = $conn->query($queryCourses);
 $rownum = $resultCourses->num_rows;
 if ($rownum < 1) {
  echo "<tr><td colspan='4' rowspan='3'><h3 align='center'>Invalid</h3></td></tr>";
 }
 else{

  while ($row = $resultCourses->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".str_replace('_',' ',$row['courseCode'])."</td>";
    echo "<td>".$row['courseName']."</td>";
    echo "<td>".$row['unit']."</td>";
    echo "<td><input type='checkbox' name='courses[]' value='".$row['courseCode']."'></td>";
    echo "<td><input type='hidden' name='level' value='".$row['level']."'></td>";
    echo "</tr>";
    
  }
  }
  return;

?>
