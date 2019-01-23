<?php
// Validating that the Student is really logged in and authorized
session_start();

if (!empty($_SESSION['oas_studmatricNum']) && !empty($_SESSION['oas_studpos'])) {
  # What to perform if the student is really logged in

require_once 'Admin/connect.php';
$matricNum = $_SESSION['oas_studmatricNum'];

// Selecting the courses a student has registered for.
$query = "SELECT* FROM assignmentsubmission WHERE matricNum = '$matricNum' GROUP BY AssignmentId";
$result = $conn->query($query);

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
    <link href="Admin/dashboard/image/logo.gif" rel="shortcut icon"/>
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View Scores - ASG</title>

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
     <?php include 'sidebar.php'; ?>

      <div id="content-wrapper">
        <div class="container-fluid">

         <table class="table table-responsive" style="margin-top: 40px;">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th>Assignment Id</th>
                  <th>Course Code</th>
                  <th>Assignment Answer</th>
                  <th>Status</th>
                  <th>Date Submitted</th>
                  <th>Score</th>
                </tr>
              </thead>

              <tbody>
                <?php
                   $sn = 1;
                  while ($row = $result->fetch_assoc()) {
                  if (!empty($row['ass_file_path'])) {
                    $filePath = $row['ass_file_path'];
                     $arr = explode('/', $filePath);
                     $ass_file = $arr[1];
                     $answer = "<a href='".$filePath."' target='_blank'>".$ass_file."</a>";
                  }
                  elseif (!empty($row['ass_answer'])) {
                    $answer = $row['ass_answer'];
                  }
                   
                   $assignmentId = $row['assignmentId'];
                   $courseCode = $row['courseCode'];
    
                    echo"<tr>";
                      echo "<td>".$sn.".</td>";
                      echo "<td>".$assignmentId."</td>";
                      echo "<td>".str_replace('_',' ',$row['courseCode'])."</td>";
                      echo "<td>".$answer."</td>";
                      echo "<td>".$row['status']."</td>";
                      echo "<td>".date("M j, Y",strtotime($row['date']))."</td>";

                      if (strpos($assignmentId, '_') !== false) {
                        $arr = explode('_', $assignmentId);
                        $assId = $arr[1];
                       }else{
                        $assId = $assignmentId;
                       }

                      if($row['status'] == 'Graded'){
                        $query1 = "SELECT * FROM assignmentresult WHERE matricNum = '$matricNum' AND courseCode = '$courseCode'";
                        $result1 = $conn->query($query1);
                        while ($row1 = $result1->fetch_assoc()) {
                          echo "<td>".$row1[$assId]."</td>";
                       }
                      }
                      else{
                          echo "<td>Nil</td>";
                      }
                      
                    echo "</tr>";
                      $sn+=1;
                    }                     
                      
                ?>

              </tbody>
            </table>



          

          

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
5
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
