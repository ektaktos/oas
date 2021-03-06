<?php
// Validating that the Student is really logged in and authorized
session_start();

if (!empty($_SESSION['oas_studmatricNum']) && !empty($_SESSION['oas_studpos'])){
  # What to perform if the student is really logged in

require_once 'Admin/connect.php';
$matricNum = $_SESSION['oas_studmatricNum'];

// Selecting the courses a student has registered for.
$queryCourses = "SELECT courses FROM student WHERE MatricNum = '$matricNum'";
$resultCourses = $conn->query($queryCourses);

while ($row = $resultCourses->fetch_assoc()) {
    $courses = $row['courses'];
}
$course_array = json_decode($courses);
if (!empty($course_array)) {
  $course_string = implode("','", $course_array);
}else{
  $course_string = ''; 
}

// Mysql Query to select all the available announcements based on tutorid
$selectAnnouncement = "SELECT* FROM announcement WHERE visible = '1' ORDER BY sn desc LIMIT 0,2";
$resultAnnouncement = $conn->query($selectAnnouncement); 

$queryStudent = "SELECT Name,current_semester FROM student WHERE MatricNum = '$matricNum'";
$resultStudent = $conn->query($queryStudent);

while ($row = $resultStudent->fetch_assoc()) {
    $studentName = $row['Name'];
    $cur_level = $row['current_semester'];
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
    <link href="Admin/dashboard/image/logo.gif" rel="shortcut icon">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student - ASG</title>

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

          <a class="nav-brand mr-1" href="student.php" style="color: #ffffff;">
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

      <h5 align="center" style="color: #FFF;">Current Level (<?=$cur_level;?> Level)</h5>

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

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="course/registerCourse.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Register Course</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="announcement.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Announcement</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="viewscores.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>View Scores</span>
          </a>
        </li>

       <li class="nav-item">
          <a class="nav-link" href="articleEntry.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Article Entry</span>
          </a>
        </li>
                
      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="announcement.php">Announcements</a>
            </li>
<!--             <li class="breadcrumb-item active"></li>
 -->          </ol>
          <!-- Table to dispaly all current articles -->
            <table class="table" style="margin-top: 10px;">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th>Title</th>
                  <th>Content</th>
                  <th>Date</th>
                  <th>Tutor Id</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>

              <tbody>
                <?php
                  
                   $sn = 1;
                    while ($row = $resultAnnouncement->fetch_assoc()) {
                      
                      echo"<tr>";
                      echo "<td>".$sn.".</td>";
                      echo "<td>".$row['title']."</td>";
                      echo "<td>".$row['content']."</td>";
                      echo "<td>".date("M j, Y",strtotime($row['date']))."</td>";
                      echo "<td>".$row['tutor_id']."</td>";
                      // echo "<td><a href='#'>View</a></td>";
                      echo "</tr>";
                      $sn+=1;
                    }
                ?>

              </tbody>
            </table>

            <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Group Assignments</a>
            </li>
<!--             <li class="breadcrumb-item active"></li>
 -->          </ol>
          <div class="row">
          <?php
          
                // Getting assignments that have been submitted but not graded from database
                // Mysql Query to select the details of assignments from database
                $selectQuestion = "SELECT* FROM assignmentdetails WHERE format = 'group'";
                $result = $conn->query($selectQuestion);

                while ($row = $result->fetch_assoc()) {
                  if ($row['type'] == 'single') {
                    $selectQuestion = "SELECT* FROM assignmentdetails WHERE courseCode IN ('$course_string') AND format = 'group' ORDER BY sn desc";
                    $resultQuestion = $conn->query($selectQuestion);
                  }
                  elseif ($row['type'] == 'multiple') {
                    $selectQuestion = "SELECT* FROM assignmentdetails WHERE format = 'group' AND groupmembers LIKE '%".$matricNum."%' ORDER BY sn asc";
                    $resultQuestion = $conn->query($selectQuestion);
                  }
                } 

                if ($resultQuestion->num_rows < 1) {
                    // echo "Error" . $conn->error;
                }
                else{
                  while ($row1 = $resultQuestion->fetch_assoc()) {
                    
              echo "<div class='col-xl-4 col-sm-4 mb-3'>";
              echo "<div class='card text-white bg-success o-hidden h-100'>";
                echo "<div class='card-body'>";
                  echo "<div class='card-body-icon'>";
                    echo "<i class='fas fa-fw fa-comments'></i>";
                  echo "</div>";
                  echo "<div class='mr-5'>";
                  if ($row1['type'] == 'single') {
                    echo "<span class='assignmentTitle'><b>Question: ".$row1['assignmentQuestion']."</b></span><br>";
                  }else{
                    echo "<span class='assignmentTitle'><b>Question: ".$row1['assignmentQuestion']."</b></span><br>";
                  }
                 
                  echo "<span>Course Code: <b>".str_replace('_',' ',$row1['courseCode'])."</b></span><br>";
                  echo "<span>Assignment Id: <b>".$row1['assignmentId']."</b></span><br>";
                  echo "<span class='assignmentDetails'> Tutor: <b>".$row1['tutor']."</b></span><br>";
                  echo "<span>Date Assigned: <b>".date("M j, Y",strtotime($row1['dateAssigned']))."</b></span><br>";
                  echo "<span>Submission Deadline: <b>".date("M j, Y",strtotime($row1['submissionDate']))."</b></span><br>";
                  echo "<span>Submission Time: <b>".date("h:ia",strtotime($row1['submissionDate']))."</b></span><br>";
                  echo "<span>Expected Score: <b>".$row1['score']."</b></span>
                  </div>";
                echo "</div>";
                echo "<a class='card-footer text-white clearfix small z-1' href='submitGroup.php?Id=".$row1['assignmentId']."'>";
                  echo "<span class='float-left'>Submit Assignment</span>";
                  echo "<span class='float-right'>";
                    echo "<i class='fas fa-angle-right'></i>";
                  echo "</span>";
                echo "</a>";
              echo "</div>";
            echo "</div>";
            }
            }
          ?>
          </div>

          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Assignments</a>
            </li>
            <li class="breadcrumb-item active">Ungraded</li>
          </ol>
          <div class="row">
          <?php
             
                // Getting assignments that have been submitted but not graded from database
                $querySelect = "SELECT* FROM assignmentsubmission WHERE matricNum='$matricNum' AND status='UnGraded' GROUP BY AssignmentId ORDER BY sn desc";
                $resultSelect = $conn->query($querySelect);
                $rownum = $resultSelect->num_rows;
             
                if ($rownum > 0) {
                  while ($row = $resultSelect->fetch_assoc()) {
                      echo "<hr>"; 
                      $assignmentId = $row['assignmentId'];
                      $courseCode = $row['courseCode'];
                      $matricnum = $row['matricNum'];

                    if (!empty($row['ass_file_path'])) {
                      $filePath = $row['ass_file_path'];
                      $arr = explode('/', $filePath);
                      $ass_file = $arr[1];
                      $answer = "<a href='".$filePath."' target='_blank'>".$ass_file."</a>";
                    }
                    elseif (!empty($row['ass_answer'])) {
                      $answer = $row['ass_answer'];
                    }

              echo "<div class='col-xl-4 col-sm-4 mb-3'>";
              echo "<div class='card text-white bg-success o-hidden h-100'>";
                echo "<div class='card-body'>";
                  echo "<div class='card-body-icon'>";
                    echo "<i class='fas fa-fw fa-comments'></i>";
                  echo "</div>";
                  echo "<div class='mr-5'>
                  <h5 align='center'>Submitted but not Graded</h5>
                  <span>Assignment Id: ".$assignmentId."</span><br>
                  <span>Course Code: ".str_replace('_',' ',$courseCode)."</span><br>
                  <span>Date Assigned:".date("M j, Y",strtotime($row['date']))."</span><br>
                  <span class='fileDetails'> Matric Num: ".$matricnum."</span><br>
                  </div>";
                echo "</div>";
                echo "<a class='card-footer text-white clearfix small z-1' href='checkScore.php?Id=".$assignmentId."&matric=".$matricnum."&course=".$courseCode."'>";
                  echo "<span class='float-left'>View Details</span>";
                  echo "<span class='float-right'>";
                    echo "<i class='fas fa-angle-right'></i>";
                  echo "</span>";
                echo "</a>";
              echo "</div>";
            echo "</div>";
                  }
                }

                // Getting assignments that have been submitted from database
                $querySelect1 = "SELECT* FROM assignmentsubmission WHERE matricNum='$matricNum'";
                $resultSelect1 = $conn->query($querySelect1);
                if ($resultSelect1->num_rows > 0) {
                while ($row2 = $resultSelect1->fetch_assoc()) {
                  $assIdArray[] = $row2['assignmentId'];
                }
                 $assignments_string = implode("','", $assIdArray);
                }else{
                  $assignments_string = '';
                }

                // Getting assignments that have not been submitted yet
                // Mysql Query to select the details of assignments from database
                $selectQuestion = "SELECT* FROM assignmentdetails WHERE courseCode IN ('$course_string') AND assignmentId NOT IN ('$assignments_string') AND format = 'individual' GROUP BY AssignmentId ORDER BY sn desc";
                $resultQuestion = $conn->query($selectQuestion); 

                if ($resultQuestion->num_rows < 1) {
                    // echo "Error" . $conn->error;
                }
                else{
                  while ($row1 = $resultQuestion->fetch_assoc()) {
                    
              echo "<div class='col-xl-4 col-sm-4 mb-3'>";
              echo "<div class='card text-white bg-success o-hidden h-100'>";
                echo "<div class='card-body'>";
                  echo "<div class='card-body-icon'>";
                    echo "<i class='fas fa-fw fa-comments'></i>";
                  echo "</div>";
                  echo "<div class='mr-5'>";
                  if ($row1['type'] == 'single') {
                    echo "<span class='assignmentTitle'><b>Question: ".$row1['assignmentQuestion']."</b></span><br>";
                  }else{
                    echo "<span class='assignmentTitle'><b>Question: Multiple Question</b></span><br>";
                  }
                 
                  echo "<span>Course Code: <b>".str_replace('_',' ',$row1['courseCode'])."</b></span><br>";
                  echo "<span>Assignment Id: <b>".$row1['assignmentId']."</b></span><br>";
                  echo "<span class='assignmentDetails'> Tutor: <b>".$row1['tutor']."</b></span><br>";
                  echo "<span>Date Assigned: <b>".date("M j, Y",strtotime($row1['dateAssigned']))."</b></span><br>";
                  echo "<span>Submission Deadline: <b>".date("M j, Y",strtotime($row1['submissionDate']))."</b></span><br>";
                  echo "<span>Submission Time: <b>".date("h:ia",strtotime($row1['submissionDate']))."</b></span><br>";
                  if ($row1['type'] == 'single') {
                  echo "<span>Expected Score: <b>".$row1['score']."</b></span>";   
                  }             
                  echo "</div>";
                echo "</div>";
                echo "<a class='card-footer text-white clearfix small z-1' href='upload.php?Id=".$row1['assignmentId']."'>";
                  echo "<span class='float-left'>Submit Assignment</span>";
                  echo "<span class='float-right'>";
                    echo "<i class='fas fa-angle-right'></i>";
                  echo "</span>";
                echo "</a>";
              echo "</div>";
            echo "</div>";
            }
            }
          ?>
          </div>

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Assignments</a>
            </li>
            <li class="breadcrumb-item active">Graded</li>
          </ol>

          <div class="row">

          <?php
             
          // Mysql Query to select all the Graded assignments from database
          $selectSubmAssignment1 = "SELECT* FROM assignmentsubmission WHERE courseCode IN ('$course_string') AND status='Graded' GROUP BY AssignmentId ORDER BY sn desc
          ";
          $resultSubmAssignment1 = $conn->query($selectSubmAssignment1); 

              $escore = 0;
              while ($row = $resultSubmAssignment1->fetch_assoc()) {

                $assignmentId = $row['assignmentId'];
                $courseCode = $row['courseCode'];
                $matricnum = $row['matricNum'];
                $ass_path = $row['ass_file_path'];

                $queryAssDetails = "SELECT assignmentQuestion,score FROM assignmentdetails WHERE assignmentId='$assignmentId'";
                $resultAssDetails = $conn->query($queryAssDetails);

                while ($row1 = $resultAssDetails->fetch_array()) {
                    $expScore = $row1['score'];
                    $question = $row1['assignmentQuestion'];
                    $escore += $expScore;
                }

                 if (strpos($assignmentId, '_') !== false) {
                  $arr = explode('_', $assignmentId);
                  $assId = $arr[1];
                   }else{
                    $assId = $assignmentId;
                   }
                // Query to slect the score of the selected assignment
                $queryscore = "SELECT * FROM assignmentresult WHERE courseCode = '$courseCode' AND matricNum='$matricnum' ";
                $resultscore = $conn->query($queryscore); 

                while ($row = $resultscore->fetch_assoc()) {
                    $obtScore = $row[$assId];
                }
                            
              echo "<div class='col-xl-4 col-sm-4 mb-3'>";
              echo "<div class='card text-white bg-success o-hidden h-100'>";
                echo "<div class='card-body'>";
                  echo "<div class='card-body-icon'>";
                    echo "<i class='fas fa-fw fa-comments'></i>";
                  echo "</div>";
                  echo "<div class='mr-5'>
                  <span>Ass. Id: ".$assignmentId."</span><br>
                  <span>Course Code: ".str_replace('_',' ',$courseCode)."</span><br>
                  <span class='fileDetails'> Matric Num: ".$matricnum."</span><br>
                  <span class='fileName'>Score: ".$obtScore."/".$escore."</span><br>

                  </div>";
                echo "</div>";
                echo "<a class='card-footer text-white clearfix small z-1' href='checkScore.php?Id=".$assignmentId."&matric=".$matricnum."&course=".$courseCode."'>";
                  echo "<span class='float-left'>View Details</span>";
                  echo "<span class='float-right'>";
                    echo "<i class='fas fa-angle-right'></i>";
                  echo "</span>";
                echo "</a>";
              echo "</div>";
            echo "</div>";
              
              }
          ?>
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
