<?php
require 'Admin/connect.php';
// Validating that the Student is really logged in and authorized
session_start();
if (!empty($_SESSION['oas_studmatricNum']) && !empty($_SESSION['oas_studpos'])) {
 	# What to perform if the student is really logged in
$matricNum = $_SESSION['oas_studmatricNum'];
$id = $matricNum;
$link = "student.php";
$queryStudent = "SELECT* FROM student WHERE MatricNum = '$matricNum'";
$resultStudent = $conn->query($queryStudent);
$rownum = $resultStudent->num_rows;

 while ($row = $resultStudent->fetch_assoc()) {
        $Name = $row['Name'];
        $phone = $row['phone'];
        $email = $row['email'];
    }
 }

elseif (!empty($_SESSION['oas_tutorId'])) {
  # What to perform if the tutor is really logged in
$tutorId = $_SESSION['oas_tutorId'];
$link = "tutor.php";
$id = $tutorId;
$queryTutor = "SELECT* FROM tutor WHERE staffId = '$tutorId'";
$resultTutor = $conn->query($queryTutor);
$rownum = $resultTutor->num_rows;

 while ($row = $resultTutor->fetch_assoc()) {
        $Name = $row['Name'];
        $phone = $row['phone'];
        $email = $row['email'];
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

    <title>Profile - ASG</title>

    <!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">
<!-- Navigation Bar-->
    <?php include 'navbar.php'; ?>

<div id="wrapper">

      <!-- Sidebar -->
	<?php include 'sidebar.php'; ?>
  
	<!-- Profile Editor -->
	<?php include 'edit-profile.php'; ?> 
</div>
    <!-- Sticky Footer -->
        <nav class="navbar navbar-dark bg-dark nav-fixed-bottom">
            <div class = "container-fluid">
                <label class="navbar-text pull-left">Assignment Submission & Grading System &copy; All rights reserved 2018</label>
            </div>
        </nav>


     <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php include 'logoutmodal.php'; ?>  

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- Bootstrap core JavaScript-->
    <script src="Admin/dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="Admin/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
