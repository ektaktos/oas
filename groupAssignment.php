<?php
// Validating that the Tutor is really logged in and authorized
session_start();
require_once "Admin/connect.php";
if (!empty($_SESSION['oas_tutorId']) && !empty($_SESSION['oas_tutorpos'])) {
 	# What to perform if the tutor is really logged in
  	$startdate = strtotime("today");
	$enddate = strtotime("+1 year",$startdate);

	$newstart =  date("Y", $startdate);
	$newend =  date("Y",$enddate);
 
    $tutorId = $_SESSION['oas_tutorId'];
    // Selecting the courses offered by tutor.
    $queryCourses = "SELECT courses FROM tutor WHERE StaffId = '$tutorId'";
    $resultCourses = $conn->query($queryCourses);
    while ($row = $resultCourses->fetch_assoc()) {
        $courses = $row['courses'];
    }
    $course_array = json_decode($courses);

    $queryTutor = "SELECT Name FROM tutor WHERE StaffId = '$tutorId'";
    $resultTutor = $conn->query($queryTutor);

    while ($row = $resultTutor->fetch_assoc()) {
        $tutorName = $row['Name'];
    }

    // Query to get the List of group names
    $selectGroups = "SELECT group_name FROM group_members WHERE courseCode = '$courseCode'";
    $resultGroups = $conn->query($selectGroups);
 }

 else{
 	echo "Sorry You are not Authorized to view this page";
 	header("Location:index.php");
 } 



?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Admin/dashboard/image/logo.gif" rel="shortcut icon"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<title>New Assignment - ASG</title>
<!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">
<body>
 <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

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
          <a class="nav-link" href="creategroup.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Create Group</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="newAssignment.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>New Assignment</span>
          </a>
        </li>

        <li class="nav-item active">
          <a class="nav-link" href="#">
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
     
    <div class="offset-md-2 col-md-8">
    <h3 align="center" class="display-5">New Assignment</h3>
    <div id="message" style="text-align: center; margin-top:10px;"></div>

  <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" onsubmit= "return validate(this)">


    <div class="formgroup">
      <textarea class="form-control" name="questiontext" Placeholder="Enter the Assignment Question" rows="5" cols="10"></textarea>
      </div><br>

      <h4 align="center">OR</h4>

      <div class="formgroup">
      <input type="file" name="questionfile" >
     </div><br>


    <div class="form-group">
      <select class="form-control" name="courseCode">
        <option value="">--Select Course Code--</option>
        <?php
         foreach ($course_array as $course) {
           echo "<option value = ".$course."> ".str_replace('_',' ',$course)."</option>";
         }
        ?>
      </select>
    </div>
    <label>**Select the Group Name to assign different assignments to different gropus or leave empty for general assignments</label>
    <select name="groupId">
      <option value=''>--Select Group Name--</option>
      <?php
      while ($row = $resultGroups->fetch_assoc()) {
        echo "<option value=".$row['members'].">".$row['group_name']."</option>";
      }
      ?>
    </select>

    <div class="form-group">
      <select class="form-control" name="assignmentId">
        <option value="">--Select AssignmentId--</option>
        <option value="Ass01">Assignment 1</option>
        <option value="Ass02">Assignment 2</option>
        <option value="Ass03">Assignment 3</option>
        <option value="Ass04">Assignment 4</option>
        <option value="Ass05">Assignment 5</option>
      </select>
    </div>


    <div class="form-group">
      <input type="text" class="form-control" name="score" Placeholder="Enter the Assigned Score">
    </div>


    <div class="form-group">
    <label>Submission Date:</label>
    <input type="date" name="date" class="form-control">
    </div>

    <div class="form-group">
    <label>Submission Time:</label>
    <input type="time" name="time" class="form-control">
    </div>


<div class="col-sm-12" align="center">
<input type="submit" value="Submit" name="submit" class="btn btn-primary">
</div>

</form>

</div>
</div>
</div>

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
// Testing if the post variables are not empty
if ((!empty($_POST['question']) || !empty($_FILES["questionfile"]["tmp_name"]) || !empty($_POST['questiontext'])) && !empty($_POST['courseCode']) && !empty($_POST['score']) && !empty($_POST['date']) && !empty($_POST['time'])) {

  $courseCode = $_POST['courseCode'];
  $date = $_POST['date'];
  $time = $_POST['time'];
  $assignmentId =str_replace('_','',$courseCode).'_'.$_POST['assignmentId'];
  $format = 'group';

  $assignedDay = date("Y-m-d h:i:sa");
  $submission = $date . ' ' . $time;
  $submissiondate = strtotime($submission);

  if (!empty($_FILES["questionfile"]["tmp_name"])){
      $target_dir = "question_files/";
      $question = $target_dir . basename($_FILES["questionfile"]["name"]);
      move_uploaded_file($_FILES["questionfile"]["tmp_name"], $question);
      $score = $_POST['score'];
      $type = 'single';
      // If the group assignment is peculiar to a group
      if (!empty($_POST['groupId'])) {
         $groupMembers = $_POST['groupId'];
         $stmt = $conn->prepare("INSERT INTO assignmentdetails(assignmentId,assignmentQuestion,tutor,tutorId,courseCode,type,format,groupmembers,dateAssigned,submissionDate,score) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssssss",$assignmentId,$question,$tutorName,$tutorId,$courseCode,$type,$format,$groupMembers,$assignedDay,$submission,$score);
        if($stmt->execute()){
           ?><script>
          alert("Group Assignment saved successfully");window.location.href = 'groupAssignment.php';
           </script><?php
        }
        else{
          ?><script>
                document.getElementById("message").innerHTML = "Group Assignment not saved.";
                document.getElementById("message").style.color = "red";
            </script><?php
          // echo "Data not Successfully Inserted " . $stmt->error;
        }
      }
      else{
        $stmt = $conn->prepare("INSERT INTO assignmentdetails(assignmentId,assignmentQuestion,tutor,tutorId,courseCode,type,format,dateAssigned,submissionDate,score) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssssss",$assignmentId,$question,$tutorName,$tutorId,$courseCode,$type,$format,$assignedDay,$submission,$score);
        if($stmt->execute()){
         ?><script>
        alert("Group Assignment saved successfully");window.location.href = 'groupAssignment.php';
       </script><?php
      }
      else{
        ?><script>
              document.getElementById("message").innerHTML = "Group Assignment not saved.";
              document.getElementById("message").style.color = "red";
          </script> <?php
        // echo "Data not Successfully Inserted " . $stmt->error;
      }
      }
  }
  elseif (!empty($_POST['questiontext'])) {
     $question = $_POST['questiontext'];
     $score = $_POST['score'];
     $type = 'single';
     
     if (!empty($_POST['groupId'])) {
      $groupMembers = $_POST['groupId'];
      $stmt = $conn->prepare("INSERT INTO assignmentdetails(assignmentId,assignmentQuestion,tutor,tutorId,courseCode,type,format,groupmembers,dateAssigned,submissionDate,score) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
      $stmt->bind_param("sssssssssss",$assignmentId,$question,$tutorName,$tutorId,$courseCode,$type,$format,$groupMembers,$assignedDay,$submission,$score);
      if($stmt->execute()){
         ?><script>
        alert("Group Assignment saved successfully");window.location.href = 'groupAssignment.php';
       </script><?php
      }
      else{
        ?><script>
              document.getElementById("message").innerHTML = "Group Assignment not saved.";
              document.getElementById("message").style.color = "red";
          </script><?php
        // echo "Data not Successfully Inserted " . $stmt->error;
      }
    }
    else{
      $stmt = $conn->prepare("INSERT INTO assignmentdetails(assignmentId,assignmentQuestion,tutor,tutorId,courseCode,type,format,dateAssigned,submissionDate,score) VALUES (?,?,?,?,?,?,?,?,?,?)");
      $stmt->bind_param("ssssssssss",$assignmentId,$question,$tutorName,$tutorId,$courseCode,$type,$format,$assignedDay,$submission,$score);
      if($stmt->execute()){
         ?><script>
        alert("Group Assignment saved successfully");window.location.href = 'groupAssignment.php';
       </script><?php
      }
      else{
        ?><script>
              document.getElementById("message").innerHTML = "Group Assignment not saved.";
              document.getElementById("message").style.color = "red";
          </script><?php
        // echo "Data not Successfully Inserted " . $stmt->error;
      }
    }
  }
}//End of validating if all the POST variables were sent
else{
	echo "Sorry, Fill in all the Fields";
}//End of What to perform if the POST variables were not sent

}//End of Confirming if the http request is a POST request


?>

<!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="Admin/dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="Admin/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="Admin/dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Admin/dashboard/js/sb-admin.js"></script>

    
