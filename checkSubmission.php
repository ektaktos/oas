<?php
// Validating that the Student is really logged in and authorized
session_start();

require_once 'Admin/connect.php';

if (!empty($_SESSION['oas_tutorId'])) {

$tutorId = $_SESSION['oas_tutorId'];
 
// Selecting the courses a student has registered for.
$queryCourses = "SELECT courses FROM tutor WHERE StaffId = '$tutorId'";
$resultCourses = $conn->query($queryCourses);
while ($row = $resultCourses->fetch_assoc()) {
    $courses = $row['courses'];
}
$course_array = json_decode($courses);
$course_string = implode("','", $course_array);

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

    <title>Check Submission - ASG</title>

    <!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

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

        <li class="nav-item active">
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

        <li class="nav-item">
          <a class="nav-link" href="groupAssignment.php">
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

        <div class="container-fluid" style="width:70%; margin-left:15%; margin-right:15%;">
          <!-- Div to display selection of course and assignment-->
          <div class="form-inline">
          <div class="form-group">
           <label>Select Course: </label>
           <select name="courseCode" id="courseCode" class="form-control" style="margin-right: 10px;">
             <option value="">--Select Course--</option>
           </select>
          </div>

          <div class="form-group">
           <label>Select Assignment: </label>
           <select name="courseCode" id="assId" class="form-control">
             <option value="">--Select Assignment ID--</option>
           </select>
         </div>
        </div>
          
          <!-- Div to handle the table for submitted assignments -->
           <table width="auto" class="table table-hover table-responsive" style="margin-top: 30px;">
            <thead class="thead-light">
            <tr>
              <th>Sn</th>
              <th>Matric Num</th>
              <th>Status</th>
              <th>Submission Date</th>
              <!-- <th>Score</th> -->
            </tr>
          </thead>
           <tbody id="assTable">
             
           </tbody>
           </table>

        </div>


    </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

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

    <!-- Bootstrap core JavaScript-->
    <script src="Admin/dashboard/vendor/jquery/jquery.min.js"></script>
    <script src="Admin/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="Admin/dashboard/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Admin/dashboard/js/sb-admin.min.js"></script>

    <!-- Script to display assignments -->
    <script type="text/javascript">
      $(document).ready(function() {
      var tutorId = "<?php echo $tutorId; ?>";
      $("#courseCode").load('getCourse.php',{"tutorId":tutorId})

      $('#courseCode').unbind('change');
      $('#courseCode').change(function() {
      var courseCode = $('#courseCode').val();
      $("#assId").load('getAssignmentId.php',{"courseCode":courseCode,"tutorId":tutorId})
      });

      $('#assId').unbind('change');
      $('#assId').change(function() {
      var courseCode = $('#courseCode').val();
      var assId = $('#assId').val();
      console.log(courseCode);
      $("#assTable").load('getSubmissions.php',{"courseCode":courseCode,"assId":assId,})
      });

      });
    </script>


  </body>

</html>
