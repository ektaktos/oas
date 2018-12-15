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
        $courses = str_replace('_',' ', $row['courses']);
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
        $courses = $row['courses'];
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

    <title>Article Entry - ASG</title>

    <!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
   
      <a class="nav-brand mr-1" href="<?php echo $link; ?>" style="color: #ffffff;">
        <img src="Admin/dashboard/image/logo.gif" width="50" height="50" alt="AU">
        <span style="color: white;">ASG System</span>
      </a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>


      <!-- Navbar Dispaly Search bar and User Name -->
      
      <form class="d-none d-md-inline-block form-inline ml-auto ">
          <input type="text" name="matricNum" class="form-control" placeholder="Enter Matric Number">
          <input type="submit" value="Search" name="submit" class="btn">
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i><?php echo $Name;?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
            <a class="dropdown-item" href="#">Profile</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
      <?php if (!empty($_SESSION['oas_tutorId'])) { ?>
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

        <li class="nav-item active">
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
        
      <?php } elseif(!empty($_SESSION['oas_studmatricNum'])){?>

        <li class="nav-item">
          <a class="nav-link" href="registerCourse.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Register Course</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="viewscores.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>View Scores</span>
          </a>
        </li>

       <li class="nav-item active">
          <a class="nav-link" href="articleEntry.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Article Entry</span>
          </a>
        </li>
        <?php } ?>

      </ul>


    <div class="container-fluid">
        <table class="table" style="width: 70%; margin: 50px 0px 0px 50px">
        <?php
          if ($rownum >0) {
              echo "<tr><td>Full Name: </td><td>" . $Name ."</td></tr>";
              echo "<tr><td>Identification Number: </td><td>" . $id ."</td></tr>";
              echo "<tr><td>Phone: </td><td>" . $phone ."</td></tr>";
              echo "<tr><td>Email: </td><td>" . $email ."</td></tr>";
              $course = implode(",", json_decode($courses));
              echo "<tr><td>Courses: </td><td>" . $course ."</td></tr>";

          }
          else{
            echo "Profile not available";
          }
        ?>

        </table>


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

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- Bootstrap core JavaScript-->
    <script src="Admin/dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="Admin/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
