<?php
// Validating that the Tutor is really logged in and authorized
session_start();
require_once "Admin/connect.php";
if (!empty($_SESSION['oas_tutorId']) && !empty($_SESSION['oas_tutorpos'])) {
 
    $tutorId = $_SESSION['oas_tutorId'];
    // Selecting the courses offered by tutor.
    $queryCourses = "SELECT courses FROM tutor WHERE StaffId = '$tutorId'";
    $resultCourses = $conn->query($queryCourses);
    while ($row = $resultCourses->fetch_assoc()) {
        $courses = $row['courses'];
    }
    $course_array = json_decode($courses);
    $course_string = implode("','", $course_array);

    $queryTutor = "SELECT Name FROM tutor WHERE StaffId = '$tutorId'";
    $resultTutor = $conn->query($queryTutor);

    while ($row = $resultTutor->fetch_assoc()) {
        $tutorName = $row['Name'];
    }

    // Selecting the groups available for each course
    $queryGroups = "SELECT* FROM group_members WHERE courseCode IN ('$course_string')";
    $resultGroups = $conn->query($queryGroups);
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
<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<title>Create Group-Online Assignment Submission</title>
<!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">
<body>
 <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

         <a class="nav-brand mr-1" href="tutor.php" style="color: #ffffff;">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span >Dashboard</span>
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

        <li class="nav-item active">
          <a class="nav-link" href="#">
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
     
    <div class="offset-md-2 col-md-8">
    <h3 align="center" class="display-5">Create New Group</h3>

    <form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" onsubmit= "return validate(this)">
    <div class="form-group">
      <select class="form-control" name="courseCode" id="courseCode" required>
        <option value="">--Select Course Code--</option>
        <?php
         foreach ($course_array as $course) {
           echo "<option value = ".$course."> ".str_replace('_',' ',$course)."</option>";
         }
        ?>
      </select>
    </div>

    <div class="form-group" id="students" required>
      
    </div>

    <div class="form-group">
      <input type="text" name="groupName" placeholder="Enter Group Name" class="form-control" required>
    </div>

    <div class="form-group">
      <input type="submit" name="submit" class="btn btn-primary">
    </div>
   </form>

   <table class="table table-striped">
     <thead>
       <tr>
         <th>Sn</th>
         <th>Group Name</th>
         <th>Course Code</th>
         <th>Group Members</th>
       </tr>
     </thead>
     <tbody>
       <?php
       $sn = 1;
       if ($resultGroups->num_rows < 1) {
        echo"<tr align='center'>";
        echo "<td colspan='4'> No Group Records Available </td>";
        echo "</tr>";
       }
       else{
        while ($row = $resultGroups->fetch_assoc()) {
          echo "<tr>";
          echo "<td>".$sn."";
          echo "<td>".$row['group_name']."";
          echo "<td>".$row['courseCode']."";
          echo "<td>".$row['members']."";
          echo "</tr>";
          $sn+=1;
        }
       }
       ?>
     </tbody>
   </table>

  </div>
  </div>
  </div>

<div class="container-fluid col-sm-12">
    <footer class="footer">
         <hr>
       <p align="center">&copy; <?php echo Date("Y");?> Alphatim Inc. </p>
      </footer>
</div>

</body> 

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST['courseCode']) && !empty($_POST['groupName']) && !empty($_POST['students'])) {
        $courseCode = $_POST['courseCode'];
        $groupName = $_POST['groupName'];
        $members = json_encode($_POST['students'],JSON_UNESCAPED_SLASHES);
       
    }	

    $stmt = $conn->prepare("INSERT INTO group_members(group_name,courseCode,members) VALUES (?,?,?)");
      $stmt->bind_param("sss",$groupName,$courseCode,$members);
      if($stmt->execute()){
        echo "Data Inserted Successfully";
      }
      else{
        echo "Data not Successfully Inserted " . $stmt->error;
      }

}


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

    <!-- Custom scripts for all pages-->
<!--     <script src="Admin/dashboard/js/sb-admin.js"></script> -->
    <script type="text/javascript">
      $(document).ready(function() {
    
      $('#courseCode').unbind('change');
      $('#courseCode').change(function() {
        console.log('Hello');
      var courseCode = $('#courseCode').val();
      // $("#assTable").load('getSubmissions.php',{"courseCode":courseCode,"assId":assId,})
      $("#students").load('getStudentByCourse.php',{"courseCode":courseCode,})
      });

      });
    </script>

