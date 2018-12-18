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
    // Selecting the courses offered by the current tutor from database
    $querySelect = "SELECT courses FROM tutor WHERE StaffId = '$tutorId'";
    $resultSelect = $conn->query($querySelect);

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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Admin/dashboard/image/logo.gif" rel="shortcut icon"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<title>Search Student - ASG</title>
<!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">

<body>

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
        
        <li class="nav-item active">
          <a class="nav-link" href="#">
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
        <div style="margin-top: 40px; margin-bottom: 30px;" class="offset-sm-2 col-sm-6">
        <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-group">
            <input type="text" name="matricNum" class="form-control" placeholder="Enter Matric Number">
          </div>

          <div class="col-sm-12" align="center">
            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
          </div>

        </form>
        </div>
        <?php
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              if(!empty($_POST['matricNum'])){ 

              $matricNum = $_POST['matricNum'];
              $querySearch = "SELECT* FROM assignmentresult WHERE matricNum = '$matricNum'";
              $resultSearch = $conn->query($querySearch);
              $rownum = $resultSearch->num_rows;

              if ($rownum < 1) {
                  echo "No records found for " . $matricNum;
              }
              else{
        ?>
            <table width="auto" class="table table-hover">
                    <tr>
                      <th>Sn.</th>
                      <th>Name</th>
                      <th>Matric. No</th>
                      <th>Course Code</th>
                      <th>Assignment 1</th>
                      <th>Assignment 2</th>
                      <th>Assignment 3</th>
                      <th>Assignment 4</th>
                      <th>Assignment 5</th>
                    </tr>
                  
      <?php
        //php block of code to display the selected data from database
        $i = 1;
        while ($row = $resultSearch->fetch_assoc()) {

          $matricNum = $row['matricNum'];
          //Mysql Query to select the name of the corresponding matric number from database
          $queryStudent = "SELECT Name FROM student WHERE matricNum = '$matricNum'";
          $resultStudent = $conn->query($queryStudent); 

          while ($rowname = $resultStudent->fetch_assoc()) {
              $studentName = $rowname['Name'];
          }
          
          echo "<tr>";
          echo '<td>'.$i.'</td>';
          echo "<td>". $studentName."</td>";
          echo "<td>". $matricNum."</td>";
          echo "<td>". str_replace('_',' ',$row['courseCode'])."</td>";
          echo "<td>". $row['Ass01']."</td>";
          echo "<td>". $row['Ass02']."</td>";
          echo "<td>". $row['Ass03']."</td>";
          echo "<td>". $row['Ass04']."</td>";
          echo "<td>". $row['Ass05']."</td>";
          echo "</tr>";

        $i++;

        }//End of Php Block (While loop) of code to display the selected data from database 
        }//End of validating that data was selected from database 
        }//End of validating that the submitted field is not empty
        else{
          echo "Sorry No Matric Number was Entered";
        } 
       }//End of validating that a POST request was sent
      ?>
      </table>
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
</html>

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


