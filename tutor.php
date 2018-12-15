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
$selectSubmAssignment = "SELECT* FROM assignmentsubmission WHERE courseCode IN ('$course_string') AND status='UnGraded' GROUP BY AssignmentId";
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
      
      <form class="d-none d-md-inline-block form-inline ml-auto ">
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

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              Assignments
            </li>
            <li class="breadcrumb-item active"><a href="assignment.php?page=ungraded">Ungraded</a></li>
          </ol>
          <div class="">
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
                echo "<td>".str_replace('_', ' ',$row['courseCode'])."</td>";
                echo "<td>".$matricnum."</td>";
                echo "<td>".$row['date']."</td>";
                echo "<td><a href='gradeAssignment.php?Id=".$assignmentId."&matric=".$matricnum."'>Grade</a></td>";
                echo "</tr>";
                $sn+=1;            
              }
          ?>
        </tbody>
      </table>
          </div>

          <!-- Breadcrumbs-->
          <!-- <ol class="breadcrumb">
            <li class="breadcrumb-item">
              Assignments
            </li>
            <li class="breadcrumb-item active"><a href="assignment.php?page=graded">Graded</a></li>
          </ol>

          <div class="">
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
          </div>
 -->

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

    <!-- Page level plugin JavaScript-->
    <script src="Admin/dashboard/vendor/chart.js/Chart.min.js"></script>
    <script src="Admin/dashboard/vendor/datatables/jquery.dataTables.js"></script>
    <script src="Admin/dashboard/vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="Admin/dashboard/js/sb-admin.min.js"></script>

    <!-- Demo scripts for this page-->
    <script src="Admin/dashboard/js/demo/datatables-demo.js"></script>
    <script src="Admin/dashboard/js/demo/chart-area-demo.js"></script>

    <!-- Script to display assignments -->
    <script type="text/javascript">
      $(document).ready(function() {
      $('.ass_btn').unbind('click');
      $('.ass_btn').click(function() {
      var status = $(this).attr('value');
      var matricNum = $("input[type='hidden']").val();
      $("#ass_div").load('getCourses.php',{"status":status,"matricNum":matricNum})
      });
      return false;
       });
    </script>

  </body>

</html>
