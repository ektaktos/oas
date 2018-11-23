<?php
// This page recieves a request from the tutor page and returns the courses for a particular tutor. 
require_once "Admin/connect.php";
 $assId = $_REQUEST['assId'];

 $query = "SELECT* FROM assignmentsubmission WHERE assignmentId = '$assId'";
 $result = $conn->query($query);
 $sn = 1;
  while ($row = $result->fetch_assoc()) {
    // Exploding the assignment path to get the file name of assignment
    if (!empty($row['ass_file_path'])) {
        $ass_path = $row['ass_file_path'];
        $arr = explode('/', $ass_path);
        $ass_file = $arr[1];
    }
   

    echo"<tr>";
    echo "<td>".$sn.".</td>";
    echo "<td>".$row['matricNum']."</td>";
    echo "<td>".$row['status']."</td>";
    echo "<td>".$row['date']."</td>";
    echo "</tr>";
    $sn+=1;
  }

  return;

?>
