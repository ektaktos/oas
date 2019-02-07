<?php
// Validating that the Tutor is really logged in and authorized
session_start();
require_once "Admin/connect.php";

// Saving the assignment id in a session variable and allowing a new id to override
	if (!empty($_GET['Id']) && !empty($_GET['matric']) && !empty($_GET['course'])){
		$courseCode = str_replace(' ', '_', $_GET['course']);
    $assignmentId = $_GET['Id'];
		$matricNum = $_GET['matric'];
		$_SESSION['matric'] = $matricNum;
    $studmatric = $_SESSION['oas_studmatricNum'];
	}
	else{
		$assignmentId = $_SESSION['assID'];
		$matricNum = $_SESSION['matric'];
	}

  if (strpos($assignmentId, '_') !== false) {
    $arr = explode('_', $assignmentId);
    $assId = $arr[1];
  }else{
    $assId = $assignmentId;
  }


if (!empty($_SESSION['oas_studmatricNum']) && !empty($_SESSION['oas_studpos'])) {
    

  $queryStudent = "SELECT Name FROM student WHERE MatricNum = '$studmatric'";
	$resultStudent = $conn->query($queryStudent);

	$queryAssDetails = "SELECT assignmentQuestion,score,format,type FROM assignmentdetails WHERE assignmentId='$assignmentId'";
	$resultAssDetails = $conn->query($queryAssDetails);

 	// Mysql Query to select the details of assignments from database
	$selectAssignment = "SELECT* FROM assignmentsubmission WHERE assignmentId='$assignmentId' AND matricNum = '$matricNum'";
	$resultAssignment = $conn->query($selectAssignment); 

	// Checking if the assignment has been graded for the student already 
	$queryResult = "SELECT* FROM assignmentresult WHERE courseCode = '$courseCode' AND matricNum = '$studmatric'";
	$resultResult = $conn->query($queryResult);

    while ($row = $resultStudent->fetch_assoc()) {
        $studentName = $row['Name'];
    }

    while ($row = $resultAssDetails->fetch_assoc()) {
    	$question = $row['assignmentQuestion'];
    	$exp_score[] = $row['score'];
      $format = $row['format'];
      $type = $row['type'];
    }
    $exp_score = array_sum($exp_score);
    
	while ($row = $resultAssignment->fetch_assoc()) {
        $courseCode = $row['courseCode'];
        if (!empty($row['ass_file_path'])) {
          $filePath = $row['ass_file_path'];
          $arr = explode('/', $filePath);
          $ass_file = $arr[1];
          $answer = "<a href='".$filePath."' target='_blank'>".$ass_file."</a>";
        }
        elseif (!empty($row['ass_answer'])) {
          $answer = $row['ass_answer'];
        }

     }

     while ($row = $resultResult->fetch_assoc()) {
       $graded_score = $row[$assId];
     }

 }

 else{
 	echo "Sorry You are not Authorized to view this page";
 	header("Location:index.php");
 } 

?>

<!DOCTYPE html>
<head>
<link rel="shortcut icon" href="image/alphatim.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Admin/dashboard/image/logo.gif" rel="shortcut icon"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<title>Check Score- ASG</title>
 <!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">


<body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="student.php">
        <img src="Admin/dashboard/image/logo.gif" width="50" height="50" alt="AU">
        <span style="color: white;">ASG System</span>
      </a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Dispaly User Name -->
      <form class="d-none d-md-inline-block form-inline ml-auto ">
        <span class="">
        </span>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i><?php echo $studentName;?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            <a class="dropdown-item" href="profile.php">Profile</a>
          </div>
        </li>
      </ul>

    </nav>

<div class="jumbotron">
      <div class="container" align="center">
      <h1 align="center">Online Assignment Submission</h1>
      <p align="center">Graded Assignment Detail</p>
      </div>
 </div><!-- End of Main Jumbotron-->


 <!-- Div container to contain the page -->
 <div class="container">

<div class="offset-md-2 col-md-8">
<p><strong>Course Name/Code:</strong> <?php echo str_replace('_',' ',$courseCode);  ?></p>
<p><strong>Assignment Id:</strong> <?php echo $assignmentId;  ?></p>

<?php 
  if ($format == 'individual') {
    if($type == 'multiple'){
    ?>
    <p><strong>Assignment Type:</strong> Multiple Questions</p>
    <p><strong>Student Matric Number:</strong> <?php echo $matricNum; ?></p>
    <p><strong>Expected Score:</strong> <?php echo $exp_score; ?></p>
  	<?php
    }elseif ($type == 'single') { 
    ?>
    <p><strong>Assignment Title:</strong> <?php echo $question; ?></p>
    <p><strong>Student Matric Number:</strong> <?php echo $matricNum; ?></p>
    <P><strong>Assignment File:</strong> <?=$answer?> </P>
    <p><strong>Expected Score:</strong> <?php echo $exp_score; ?></p>
    <?php
    }
		if ($resultResult->num_rows > 0) {
			echo "<p><strong>Score: </strong>".$graded_score."/".$exp_score."</p>";
		}
    else{
      echo "<p><strong>Submission Status: </strong> Not Graded</p>";
    } 
  }elseif($format == 'group'){
    ?>
    <p><strong>Assignment Title:</strong> <?php echo $question; ?></p>
    <p><strong>Group Name:</strong> <?php echo $matricNum; ?></p>
    <p><strong>Assignment File:</strong> <?=$answer?> </p>
    <p><strong>Expected Score:</strong> <?php echo $exp_score; ?></p>

    <?php
    if ($resultResult->num_rows > 0) {
      echo "<p><strong>Score: </strong>".$graded_score."/".$exp_score."</p>";
    }
    else{
      echo "<p><strong>Submission Status: </strong> Not Graded</p>";
    }
    }
	?>


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

    <!-- Page level plugin JavaScript-->
    <script src="Admin/dashboard/vendor/chart.js/Chart.min.js"></script>
    <script src="Admin/dashboard/vendor/datatables/jquery.dataTables.js"></script>
    <script src="Admin/dashboard/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Admin/dashboard/js/sb-admin.min.js"></script>

