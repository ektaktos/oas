<?php
// Validating that the Tutor is really logged in and authorized
session_start();
require_once "Admin/connect.php";

// Saving the assignment id in a session variable and allowing a new id to override
	if (!empty($_GET['page'])){
		$page = $_GET['page'];
		// $matricNum = $_GET['matric'];
		// $_SESSION['assID'] = $assignmentId;
		// $_SESSION['matric'] = $matricNum;
	}
	else{
		// $assignmentId = $_SESSION['assID'];
		// $matricNum = $_SESSION['matric'];
      header("Location:tutor.php");
	}


if (!empty($_SESSION['oas_tutorId']) && !empty($_SESSION['oas_tutorpos'])) {
 	 
    $tutorId = $_SESSION['oas_tutorId'];
  // Selecting the courses a student has registered for.
  $queryCourses = "SELECT courses FROM tutor WHERE StaffId = '$tutorId'";
  $resultCourses = $conn->query($queryCourses);
  while ($row = $resultCourses->fetch_assoc()) {
      $courses = $row['courses'];
  }
  $course_array = json_decode($courses);
  $course_string = implode("','", $course_array);

  $queryTutor = "SELECT Name FROM tutor WHERE StaffId = '$tutorId'";
	$resultTutor = $conn->query($queryTutor);

	// Mysql Query to select all the Ungraded assignments from database
  $selectSubmAssignment = "SELECT* FROM assignmentsubmission WHERE courseCode IN ('$course_string') AND status='UnGraded'";
  $resultSubmAssignment = $conn->query($selectSubmAssignment); 

  // Mysql Query to select all the Graded assignments from database
  $selectSubmAssignment1 = "SELECT* FROM assignmentsubmission WHERE courseCode IN ('$course_string') AND status='Graded'";
  $resultSubmAssignment1 = $conn->query($selectSubmAssignment1); 

  $queryTutor = "SELECT Name FROM tutor WHERE StaffId = '$tutorId'";
  $resultTutor = $conn->query($queryTutor);

    while ($row = $resultTutor->fetch_assoc()) {
        $tutorName = $row['Name'];
    }

 }

 else{
 	echo "Sorry You are not Authorized to view this page";
 	header("Location:index.php");
 } 

?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="Admin/dashboard/image/logo.gif" rel="shortcut icon"/>
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tutor - ASG</title>

    <!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

<!--       <a class="navbar-brand mr-1" href="tutor.php">Home</a>--> 

          <a class="nav-brand mr-1" href="tutor.php" style="color: #ffffff;">
            <img src="Admin/dashboard/image/logo.gif" width="50" height="50" alt="AU">
            <span style="color: white;">ASG System</span>
          </a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>


      <!-- Navbar Dispaly Search bar and User Name -->
      
      <form class="d-none d-md-inline-block form-inline ml-auto" method="post" action="searchStudent.php">
          <input type="text" name="matricNum" class="form-control" placeholder="Enter Matric Number">
          <input type="submit" value="Search" name="submit" class="btn">
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i><?php echo $tutorName;?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            <a class="dropdown-item" href="profile.php">Profile</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        
        <li class="nav-item">
            <a href="scoresheet.php" class="nav-link">
              <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Scoresheet</span>
            </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="searchStudent.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Search Student</span>
          </a>
        </li>

         <li class="nav-item">
          <a class="nav-link" href="checkSubmission.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Check Submission</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="newAssignment.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>New Assignment</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="newAssignment.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>New Group Assignment</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="articleEntry.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Article Entry</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="announcement.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Announcement</span>
          </a>
        </li>

      </ul>

 <div id="content-wrapper">
	<div class="container-fluid">
    <div id="message" style="text-align: center; margin-top: 5px;"></div>
<div class="offset-md-2 col-md-8" style=" margin: 30px 0px 0px 10%">
  <?php
  if ($page == 'ungraded') { ?>
    <h4 align="center">Ungraded Assignments</h4>
     <table width="auto" class="table table-hover table-responsive" style="margin-top: 30px;">
            <thead class="thead-light">
            <tr>
              <th>Sn</th>
              <th>Assignment Id</th>
              <th>Course Code</th>
              <th>Matric Number</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
             $sn = 1;
              while ($row = $resultSubmAssignment->fetch_assoc()) {
                $assignmentId = $row['assignmentId'];
                $matricnum = $row['matricNum'];
                echo"<tr>";
                echo "<td>".$sn.".</td>";
                echo "<td>".$assignmentId."</td>";
                echo "<td>".$row['courseCode']."</td>";
                echo "<td>".$matricnum."</td>";
                echo "<td>".$row['date']."</td>";
                echo "<td><a href='gradeAssignment.php?Id=".$assignmentId."&matric=".$matricnum."'>Grade</a></td>";
                echo "</tr>";
                $sn+=1;            
              }
          ?>
        </tbody>
      </table>
    
 <?php } elseif ($page == 'graded') { ?>
    <h4 align="center">Graded Assignments</h4>
    <table width="auto" class="table table-hover table-responsive" style="margin-top: 30px;">
            <thead class="thead-light">
            <tr>
              <th>Sn</th>
              <th>Assignment Id</th>
              <th>Course Code</th>
              <th>Matric Number</th>
              <th>Score</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
              while ($row = $resultSubmAssignment1->fetch_assoc()) {
                $assignmentId = $row['assignmentId'];
                $matricnum = $row['matricNum'];
                $courseCode = $row['courseCode'];

                $queryAssDetails = "SELECT assignmentQuestion,score FROM assignmentdetails WHERE assignmentId='$assignmentId'";
                $resultAssDetails = $conn->query($queryAssDetails);

                while ($row1 = $resultAssDetails->fetch_assoc()) {
                    $expScore = $row1['score'];
                    $question = $row1['assignmentQuestion'];
                }

                // Query to slect the score of the selected assignment
                $queryscore = "SELECT score FROM assignmentresult WHERE assignmentId = '$assignmentId'";
                $resultscore = $conn->query($queryscore);
                $sn = 1;
                while ($row = $resultscore->fetch_assoc()) {
                    $obtScore = $row['score'];
                }
                echo"<tr>";
                echo "<td>".$sn.".</td>";
                echo "<td>".$assignmentId."</td>";
                echo "<td>".$courseCode."</td>";
                echo "<td>".$matricnum."</td>";
                echo "<td>".$obtScore."/".$expScore."</td>";
                echo "<td><a href='gradeAssignment.php?Id=".$assignmentId."&matric=".$matricnum."'>View</a></td>";
                echo "</tr>";
                $sn+=1;      
              }
          ?>
        </tbody></table>
 <?php }  ?>
	
</div>
</div>
</div></div>

<!-- Sticky Footer -->
        <footer class="sticky-footer container-fluid">
          <div class="container my-auto">
            <div class="copyright my-auto">
              <span>Assignment Submission & Grading System &copy; All rights reserved <?=date('Y')?></span>
            </div>
          </div>
        </footer>


</body> 

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (!empty($_POST['Score'])) {

		$score = $_POST['Score'];
		$status = "Graded";
		echo "The Score is " .$score;

		// Renaming the name of the assignment file and folder
		$path = rename($ass_path, $newpath);

		// Checking if the assignment has been graded for the student already 
		$queryResult = "SELECT* FROM assignmentresult WHERE assignmentId = '$assignmentId' AND matricNum = '$matricNum'";
		$resultResult = $conn->query($queryResult);
		if ($resultResult->num_rows < 1) {
					
		 // Saving the assignment in database
	        $stmt = $conn->prepare("INSERT INTO assignmentresult(courseCode,assignmentId,matricNum,score) VALUES (?,?,?,?)");
		    $stmt->bind_param("ssss",$courseCode,$assignmentId,$matricNum,$score);

		 // Updating the assignmentsubmission table
		    $updateSubmisssion = "UPDATE assignmentsubmission SET status = '$status',ass_file_path = '$newpath' WHERE assignmentId='$assignmentId' AND matricNum='$matricNum'";
		    $resultSubmission = $conn->query($updateSubmisssion);

		    if($stmt->execute() && $resultSubmission === TRUE){
		      ?>
		      <script type="text/javascript">
		      	alert("Student Score Successfully Saved")
		      	window.location = "tutor.php";
		      </script>
		      <?php
		    }
		    else{
          ?>
          <script>
              document.getElementById("message").innerHTML = "Student score not saved.";
              document.getElementById("message").style.color = "red";
          </script>
          <?php
		      // echo "Student score not saved " . $stmt->error;
		    }
		}
		else{
			?>
          <script>
              document.getElementById("message").innerHTML = "Student has been saved already.";
              document.getElementById("message").style.color = "red";
          </script>
          <?php
		}
	}
}

?>
