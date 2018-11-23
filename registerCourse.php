<?php
// Validating that the Student is really logged in and authorized
session_start();

if (!empty($_SESSION['oas_studmatricNum']) && !empty($_SESSION['oas_studpos'])) {
  # What to perform if the student is really logged in

require_once 'Admin/connect.php';
$matricNum = $_SESSION['oas_studmatricNum'];

// Selecting the courses a student has registered for.
$queryCourses = "SELECT courses FROM student WHERE matricNum = '$matricNum'";
$resultCourses = $conn->query($queryCourses);

while ($row = $resultCourses->fetch_assoc()) {
    $courses = $row['courses'];
}
$course_array = json_decode($courses);

$course_string = implode("','", $course_array);

// Selecting all the available courses from database
$querySelectCourse = "SELECT courseCode FROM course";  
$resultSelectCourse = $conn->query($querySelectCourse);


$queryStudent = "SELECT Name FROM student WHERE MatricNum = '$matricNum'";
$resultStudent = $conn->query($queryStudent);

 while ($row = $resultStudent->fetch_assoc()) {
        $studentName = $row['Name'];
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
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Student - OAS</title>

    <!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">


    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="nav-brand mr-1" href="student.php" style="color: #ffffff;">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span >Dashboard</span>
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

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">

        <li class="nav-item active">
          <a class="nav-link" href="registerCourse.php">
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

          <h2 align="center">Current Level (100 Level)</h2>
          <div>
            <select class="form-group" id="semester">
              <option value=""> Choose Semester</option>
              <option value="1.1">100 First</option>
              <option value="1.2">100 Second</option>
              <option value="2.1">200 First</option>
              <option value="2.2">200 Second</option>
              <option value="3.1">300 First</option>
              <option value="3.2">300 Second</option>
              <option value="4.1">400 First</option>
              <option value="4.2">400 Second</option>
            </select>
          </div>
          

         <form class="form-horizontal" method="post" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
          <table class="table table-responsive" id="Semestercourses" align="center">
            <th>
              <td>COURSE CODE</td>
              <td>COURSE NAME</td>
              <td>UNIT</td>
              <td>CHOICE</td>
            </th>
              
          </table>
          <div class="col-sm-10" align="center">
                  <input type="Submit" name="submit" value="Submit" class="btn btn-primary">
              </div> 
          </form>       
          

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Your Website 2018</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

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

  </body>

  <!-- Script to display assignments -->
    <script type="text/javascript">
      $(document).ready(function() {
      $('#semester').change(function() {
      var semester = $("#semester").val();
      $("#Semestercourses").load('getSemesterCourse.php',{"semester":semester})
      });
      return false;
       });
    </script>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (!empty($_POST['courses'])) {
  $course = $_POST['courses'];
  $courses_json = json_encode($course);

  // Checking if the course exists in database already
  $querySelect = "SELECT courses FROM student WHERE MatricNum = '$matricNum'";
  $resultSelect = $conn->query($querySelect);
  $rowNum = $resultSelect->num_rows;

    // What to perform if course does not exist in database yet.
    // Code to Insert the details of the new admin to database
    $updateQuery = "UPDATE student SET courses AS $courses_json WHERE MatricNum = '$matricNum'";
    $resultUpdate = query($updateQuery);

    if($stmt->execute()){
      echo "Data Inserted Successfully";
      
    }
    else{
      echo "Data not Successfully Inserted" . $stmt->error;
    }


}//End of validating that the POST variables are not empty

}//End of validating that the request method is a POST method



function fix_string($string)
{
if (get_magic_quotes_gpc()) $string = stripslashes($string);
return htmlentities ($string);
}


?>
