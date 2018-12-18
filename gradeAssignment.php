<?php
// Validating that the Tutor is really logged in and authorized
session_start();
require_once "Admin/connect.php";

// Saving the assignment id in a session variable and allowing a new id to override
	if (!empty($_GET['Id']) && !empty($_GET['matric'])){
		$assignmentId = $_GET['Id'];
		$matricNum = $_GET['matric'];
		$_SESSION['assID'] = $assignmentId;
		$_SESSION['matric'] = $matricNum;
	}
	else{
		$assignmentId = $_SESSION['assID'];
		$matricNum = $_SESSION['matric'];
	}
    $assId = $assignmentId;

if (!empty($_SESSION['oas_tutorId']) && !empty($_SESSION['oas_tutorpos'])) {
 	 
    $tutorId = $_SESSION['oas_tutorId'];
    

    $queryTutor = "SELECT Name FROM tutor WHERE StaffId = '$tutorId'";
	$resultTutor = $conn->query($queryTutor);

	$queryAssDetails = "SELECT* FROM assignmentdetails WHERE assignmentId='$assId'";
	$resultAssDetails = $conn->query($queryAssDetails);

 	// Mysql Query to select the details of assignments from database
	$selectAssignment = "SELECT* FROM assignmentsubmission WHERE assignmentId='$assId' AND matricNum = '$matricNum'";
	$resultAssignment = $conn->query($selectAssignment); 

  while ($row = $resultAssignment->fetch_assoc()) {
        $courseCode = $row['courseCode'];
        if (!empty($row['ass_file_path'])) {
          $ass_path = $row['ass_file_path'];
          $arr = explode('/', $ass_path);
          $ass_file = $arr[1];
          $newpath = "graded_ass_files/".$ass_file;
        }
        elseif (!empty($row['ass_answer'])) {
          $answer = $row['ass_answer'];
        }
  }

	// Checking if the assignment has been graded for the student already 
	$queryResult = "SELECT* FROM assignmentsubmission WHERE assignmentId = '$assId' AND matricNum = '$matricNum' AND status = 'Graded'";
	$resultResult = $conn->query($queryResult);

    while ($row = $resultTutor->fetch_assoc()) {
        $tutorName = $row['Name'];
    }

    while ($row = $resultAssDetails->fetch_assoc()) {
    	$question = $row['assignmentQuestion'];
    	$exp_score = $row['score'];
      $type = $row['type'];
      $format = $row['format'];
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
	<h5 align="center"><u>Grade Assignment</u></h5>
<p><strong>Course Name/Code:</strong> <?php echo str_replace('_',' ', $courseCode); ?></p>
<p><strong>Student Matric Number:</strong> <?php echo $matricNum; ?></p>
<?php 
if ($format == 'individual') {
if ($type == 'single') {
if (isset($ass_path)) {
?>
<p><strong>Assignment Title:</strong> <?php echo $question; ?></p>
<p><strong>Assignment File:</strong> <a target="_blank" href="<?php echo $ass_path; ?>"><?php echo $ass_file; ?></a></p>
<?php
}elseif (isset($answer)) {
?>
<p><strong>Assignment Answer:</strong><?php echo $answer; ?></p>

<?php
}
?>
<p><strong>Expected Score:</strong> <?php echo $exp_score; ?></p>

	<?php
		if ($resultResult->num_rows > 0) {
			echo "<p><strong>Score: </strong>".$graded_score."/".$exp_score."</p>";

		}
	?>


<form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	<div class="form-group">
		<?php
			if ($resultResult->num_rows > 0) {
				echo "<input type='text' class='form-control'  name='Score' Placeholder='Enter the Score' disabled>";	
			}
			elseif (!empty($_GET['Id']) && !empty($_GET['matric'])) {
				echo "<input type='text' class='form-control'  name='Score' Placeholder='Enter the Score'>";
			}
			else{
			}
		?>
	</div>
	<div class="col-sm-12" align="center">
    <input type="hidden" name="AssId" value="<?=$assId?>">
	<input type="submit" value="Submit" name="submit" class="btn btn-primary">
	</div>
</form>
<?php
  }elseif ($type == 'multiple') {
    ?>
    <table class="table">
        <tr>
          <td>Sn</td>
          <td>Question</td>
          <td>Answer</td>
          <td>Assigned Score</td>
          <td>Enter Score</td>
          <td>Action</td>
        </tr>
        <?php
      // Getting assignments that have been submitted from database
      $querySelect1 = "SELECT* FROM assignmentsubmission WHERE matricNum='$matricNum' AND courseCode='$courseCode' AND status = 'Ungraded'";
      $resultSelect1 = $conn->query($querySelect1);
      if ($resultSelect1->num_rows > 0) {
        while ($row2 = $resultSelect1->fetch_assoc()) {
      $assIdArray[] = $row2['sub_AssId'];
      }
      $assignments_string = implode("','", $assIdArray);
      }else{
        $assignments_string = '';
      }
      $selectQuestion = "SELECT* FROM assignmentdetails WHERE assignmentId = '$assignmentId' AND sub_AssId IN ('$assignments_string')";
      $resultQuestion = $conn->query($selectQuestion);
      $rownum = $resultQuestion->num_rows;  $i = 0; $j=1;
      while ($row1 = $resultQuestion->fetch_assoc()) {
        $assId = $row1['sub_AssId'];
        $arr = explode('_', $assId);
        $assNum = $arr[1];
        ?>
      <form method="post" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <tr>
          <td><?=$assNum?></td>
          <td><?=$row1['assignmentQuestion']?></td>
       <!-- Query to get the answer of a submitted question -->
       <?php 
       $selectAnswer = "SELECT* FROM assignmentsubmission WHERE sub_AssId = '$assId'";
       $resultAnswer = $conn->query($selectAnswer);
       // echo "Num is ". $resultAnswer->num_rows;
       while ($row = $resultAnswer->fetch_assoc()) {
         ?>
         <td><?=$row['ass_answer']?></td>
         <?php
       }
       ?>
       <td><?=$row1['score']?></td>
       <td><input class="form-control" name="Score" Placeholder=""></td>
       <input type="hidden" name="AssId" value="<?=$assId?>">
       <td><input type="submit" name="submit" value="Submit" class="btn btn-primary"></td>
       
      </form>
      <?php $j+=1;}
  }
  ?>
  </tr>
       </table><?php
}//End of Action to perform for Individual Assignments 
elseif ($format == 'group') {
if ($type == 'single') {
if (isset($ass_path)) {
 ?>
 <p><strong>Assignment File:</strong> <a target="_blank" href="<?php echo $ass_path; ?>"><?php echo $ass_file; ?></a></p>
 <?php
}elseif (isset($answer)) {
 ?>
 <p><strong>Assignment Answer:</strong><?php echo $answer; ?></p>

 <?php
 }
?>
 <p><strong>Expected Score:</strong> <?php echo $exp_score; ?></p>

  <?php
    if ($resultResult->num_rows > 0) {
      echo "<p><strong>Score: </strong>".$graded_score."/".$exp_score."</p>";

    }
  ?>
 <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <div class="form-group">
    <?php
      if ($resultResult->num_rows > 0) {
        echo "<input type='text' class='form-control'  name='Score' Placeholder='Enter the Score' disabled>"; 
      }
      elseif (!empty($_GET['Id']) && !empty($_GET['matric'])) {
        echo "<input type='text' class='form-control'  name='Score' Placeholder='Enter the Score'>";
      }
      else{
      }
    ?>
  </div>
  <input type="hidden" name="groupAssignment" value="groupAssignment">
  <div class="col-sm-12" align="center">
  <input type="submit" value="Submit" name="submit" class="btn btn-primary">
  </div>
</form>
<?php
 }}
?>
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
    $arr = explode('_', $assId);
    $ass_Id = $arr[1];
    echo "Assignment id is " . $assId;
    // echo "Assid is" . $ass_Id;

    if ($score > $exp_score) {
        echo "The Score cannot exceed the expected score";
        return;
    }
		echo "The Score is " .$score;

		// Renaming the name of the assignment file and folder
    if (isset($ass_path)) {
          $path = rename($ass_path, $newpath);
    }

    // If the assignment is not a group assignment 
    if(!isset($_POST['groupAssignment'])){
      // Conditionals to know if the assignment is multiple or single
      if($type == 'single'){
        $arr = explode('_', $assId);
        $ass_Id = $arr[1];
        echo "Assignment id is " . $assId;
      }elseif($type == 'multiple'){
        $assId = $_POST['AssId'];
        $arr = explode('_', $assId);
        $ass_Id = $arr[0];
        echo "Assignment id is " . $assId;
      }
    // Checking if the assignment has been graded for the student already 
    $queryResult = "SELECT* FROM assignmentresult WHERE courseCode = '$courseCode' AND matricNum = '$matricNum'";
    $resultResult = $conn->query($queryResult);
		if ($resultResult->num_rows < 1) {
      echo "Hello here";
		 // Saving the assignment in database
	        $stmt = $conn->prepare("INSERT INTO assignmentresult(courseCode,matricNum,".$ass_Id.") VALUES (?,?,?)");
		    $stmt->bind_param("sss",$courseCode,$matricNum,$score);

		 // Updating the assignmentsubmission table
        if (isset($newpath)) {
		    $updateSubmisssion = "UPDATE assignmentsubmission SET status = '$status',ass_file_path = '$newpath' WHERE assignmentId='$assignmentId' AND matricNum='$matricNum'";
		    $resultSubmission = $conn->query($updateSubmisssion);
        }elseif(isset($answer)){
          $updateSubmisssion = "UPDATE assignmentsubmission SET status = '$status',ass_answer = '$answer' WHERE assignmentId='$assignmentId' AND matricNum='$matricNum'";
        $resultSubmission = $conn->query($updateSubmisssion);
        }
		    if($stmt->execute() && $resultSubmission === TRUE){
		      ?>
		      <script type="text/javascript">
		      	alert("Student Score Successfully Saved");
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
      $queryResult = "SELECT $ass_Id FROM assignmentresult WHERE courseCode = '$courseCode' AND matricNum = '$matricNum'";
      $result = $conn->query($queryResult);
      while ($row = $result->fetch_assoc()) {
        $score_init = $row[$ass_Id];
      }
      // echo "THe initial score is " . $score_init;
      $newscore = $score + $score_init;
      // echo "THe new score is " . $newscore;
      // echo "Assid is ".$ass_Id;
      // Updating the assignmentsubmission table
        $updateSubmisssion = "UPDATE assignmentresult SET $ass_Id = '$newscore' WHERE courseCode='$courseCode' AND matricNum='$matricNum'";
        $resultSubmission = $conn->query($updateSubmisssion);
        if ($resultSubmission) {
          
          if ($type == 'single') {
          // Updating the assignmentsubmission table
        $updateSubmisssion = "UPDATE assignmentsubmission SET status = '$status' WHERE assignmentId='$assignmentId' AND matricNum='$matricNum'";
        $resultSubmission = $conn->query($updateSubmisssion);
          }elseif($type == 'multiple'){
          // Updating the assignmentsubmission table
        $updateSubmisssion = "UPDATE assignmentsubmission SET status = '$status' WHERE sub_AssId='$assId' AND matricNum='$matricNum'";
        $resultSubmission = $conn->query($updateSubmisssion);
          }
          ?>
          <script type="text/javascript">
            alert("Student Score Successfully Saved");
            window.location = "tutor.php";
          </script>
          <?php
        }
		}
  }
  // What to perform if the submitted assignment is a group assignment
    elseif (isset($_POST['groupAssignment'])) {
      // Select the matric number of students in the group that submitted the assignment
      $selectGroup = "SELECT members FROM group_members WHERE group_name ='$matricNum'"; 
      $resultGroup = $conn->query($selectGroup);
      while ($row = $resultGroup->fetch_assoc()) {
        $members = $row['members'];
      }
        $membersArray = json_decode($members);
    foreach ($membersArray as $key => $value) {
      $matricNum = $value;
      // Checking if the assignment has been graded for the student already 
    $queryResult = "SELECT* FROM assignmentresult WHERE courseCode = '$courseCode' AND matricNum = '$matricNum'";
    $resultResult = $conn->query($queryResult);
      if ($resultResult->num_rows < 1) {
      // Saving the assignment in database
      $stmt = $conn->prepare("INSERT INTO assignmentresult(courseCode,matricNum,".$ass_Id.") VALUES (?,?,?)");
      $stmt->bind_param("sss",$courseCode,$matricNum,$score);

        // Updating the assignmentsubmission table
        $updateSubmisssion = "UPDATE assignmentsubmission SET status = '$status',ass_file_path = '$newpath' WHERE assignmentId='$assignmentId'";
        $resultSubmission = $conn->query($updateSubmisssion);

        if($stmt->execute() && $resultSubmission === TRUE){
          ?>
          <script type="text/javascript">
            alert("Student Score Successfully Saved");
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
      $queryResult = "SELECT $ass_Id FROM assignmentresult WHERE courseCode = '$courseCode' AND matricNum = '$matricNum'";
      $result = $conn->query($queryResult);
      while ($row = $result->fetch_assoc()) {
        $score_init = $row[$ass_Id];
      }
      // echo "THe initial score is " . $score_init;
      $newscore = $score + $score_init;
      // echo "THe new score is " . $newscore;
      // echo "Assid is ".$assId;
      // Updating the assignmentsubmission table
        $updateSubmisssion = "UPDATE assignmentresult SET $ass_Id = '$newscore' WHERE courseCode='$courseCode' AND matricNum='$matricNum'";
        $resultSubmission = $conn->query($updateSubmisssion);
        if ($resultSubmission) {
          ?>
          <script type="text/javascript">
            alert("Student Score Successfully Saved");
            window.location = "tutor.php";
          </script>
          <?php
          // Updating the assignmentsubmission table
        $updateSubmisssion = "UPDATE assignmentsubmission SET status = '$status' WHERE assignmentId='$assignmentId'";
        $resultSubmission = $conn->query($updateSubmisssion);

        }
    }
    }//End of looping through the array of matric numbers. 
    }
	}
}

?>
